<?php
// ============================================================
// InternDashboardController — the signed-in candidate's own area.
//
// Every query in here is scoped by intern_id from the session. An intern can
// only ever see their own applications, resume and offer letter, regardless of
// the id they put in the URL.
// ============================================================

require_once ROOT_PATH . '/app/controllers/BaseController.php';
require_once ROOT_PATH . '/app/helpers/OfferLetter.php';

class InternDashboardController extends BaseController {

    /**
     * Application list plus a small summary for the signed-in intern.
     */
    public function index(): void {
        requireIntern();

        $stmt = $this->db->prepare(
            "SELECT a.*, t.title AS track_title, t.slug AS track_slug, t.icon AS track_icon,
                    t.duration_weeks, t.stipend_text, t.mode
             FROM applications a
             JOIN internship_tracks t ON t.id = a.track_id
             WHERE a.intern_id = ?
             ORDER BY a.created_at DESC"
        );
        $stmt->execute([internId()]);
        $applications = $stmt->fetchAll();

        // Summary counts, derived in PHP to avoid a second round trip.
        $summary = ['total' => count($applications), 'active' => 0, 'approved' => 0, 'closed' => 0];
        foreach ($applications as $a) {
            match ($a['status']) {
                'approved'              => $summary['approved']++,
                'rejected', 'withdrawn' => $summary['closed']++,
                default                 => $summary['active']++,
            };
        }

        $profile = $this->profile();

        $this->view('internships.dashboard.index', [
            'pageTitle'     => 'My Dashboard | ' . APP_NAME,
            'canonicalPath' => 'internships/dashboard',
            'robotsMeta'    => 'noindex, nofollow',
            'applications'  => $applications,
            'summary'       => $summary,
            'profile'       => $profile,
        ]);
    }

    /**
     * Detail of one of the intern's own applications, with its status timeline.
     */
    public function application(): void {
        requireIntern();

        $id  = (int) ($_GET['id'] ?? 0);
        $app = $this->ownedApplication($id);

        $stmt = $this->db->prepare(
            "SELECT * FROM application_status_history
             WHERE application_id = ?
             ORDER BY created_at ASC, id ASC"
        );
        $stmt->execute([$id]);
        $history = $stmt->fetchAll();

        $this->view('internships.dashboard.application', [
            'pageTitle'     => 'Application ' . $app['ref_no'] . ' | ' . APP_NAME,
            'canonicalPath' => 'internships/dashboard',
            'robotsMeta'    => 'noindex, nofollow',
            'app'           => $app,
            'history'       => $history,
        ]);
    }

    /**
     * Withdraw an application the intern no longer wants considered.
     */
    public function withdraw(): void {
        requireIntern();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('internships/dashboard'));
        }
        $this->validateCsrf();

        $id  = (int) ($_POST['id'] ?? 0);
        $app = $this->ownedApplication($id);

        if (in_array($app['status'], ['approved', 'rejected', 'withdrawn'], true)) {
            setFlash('error', 'This application can no longer be withdrawn.');
            redirect(url('internships/dashboard/application?id=' . $id));
        }

        $stmt = $this->db->prepare(
            "UPDATE applications SET status = 'withdrawn', updated_at = NOW() WHERE id = ? AND intern_id = ?"
        );
        $stmt->execute([$id, internId()]);

        $hist = $this->db->prepare(
            "INSERT INTO application_status_history
                (application_id, old_status, new_status, note, changed_by_name)
             VALUES (?, ?, 'withdrawn', ?, ?)"
        );
        $hist->execute([$id, $app['status'], 'Withdrawn by the candidate.', internName()]);

        setFlash('success', 'Application ' . $app['ref_no'] . ' has been withdrawn.');
        redirect(url('internships/dashboard'));
    }

    /**
     * Stream the intern's own resume back to them.
     */
    public function resume(): void {
        requireIntern();

        $id  = (int) ($_GET['id'] ?? 0);
        $app = $this->ownedApplication($id);

        $this->streamResume($app);
    }

    /**
     * Download the offer letter — only once the application is approved.
     */
    public function offerLetter(): void {
        requireIntern();

        $id  = (int) ($_GET['id'] ?? 0);
        $app = $this->ownedApplication($id);

        if ($app['status'] !== 'approved') {
            setFlash('error', 'An offer letter is available once your application is approved.');
            redirect(url('internships/dashboard/application?id=' . $id));
        }

        $app['intern_name'] = (string) ($_SESSION['intern_name'] ?? $app['intern_name'] ?? '');

        $pdf = OfferLetter::build($app);
        $pdf->download(OfferLetter::filename($app));
    }

    // ── Shared helpers ───────────────────────────────────────────────────

    /**
     * Fetch an application that MUST belong to the current intern.
     * Anything else 404s rather than revealing that the row exists.
     */
    private function ownedApplication(int $id): array {
        if ($id <= 0) {
            $this->notFound();
        }

        $stmt = $this->db->prepare(
            "SELECT a.*, t.title AS track_title, t.slug AS track_slug, t.duration_weeks,
                    t.stipend_text, t.mode, i.name AS intern_name, i.email AS intern_email
             FROM applications a
             JOIN internship_tracks t ON t.id = a.track_id
             JOIN interns i           ON i.id = a.intern_id
             WHERE a.id = ? AND a.intern_id = ?
             LIMIT 1"
        );
        $stmt->execute([$id, internId()]);
        $app = $stmt->fetch();

        if (!$app) {
            $this->notFound();
        }

        return $app;
    }

    /**
     * Send a stored resume as a download. Shared shape with the admin side.
     */
    private function streamResume(array $app): never {
        // basename() guards against any traversal sequence that reached the column.
        $file = RESUME_PATH . '/' . basename((string) $app['resume_path']);

        if (!is_file($file)) {
            error_log('Missing resume file: ' . $file);
            setFlash('error', 'That resume file could not be found. Please re-apply or contact support.');
            redirect(url('internships/dashboard'));
        }

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $name = Security::safeFilename((string) $app['resume_original_name']);

        header('Content-Type: ' . $app['resume_mime']);
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header('Content-Length: ' . (string) filesize($file));
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: private, no-store, max-age=0');
        header('X-Content-Type-Options: nosniff');
        readfile($file);
        exit;
    }

    private function profile(): array {
        $stmt = $this->db->prepare(
            "SELECT name, email, phone, college, course, graduation_year, created_at
             FROM interns WHERE id = ? LIMIT 1"
        );
        $stmt->execute([internId()]);
        return $stmt->fetch() ?: [];
    }

    private function notFound(): never {
        http_response_code(404);
        require_once ROOT_PATH . '/app/views/errors/404.php';
        exit;
    }
}
