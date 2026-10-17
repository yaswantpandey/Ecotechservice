<?php
namespace Admin;

// ============================================================
// Admin\ApplicationsController — review queue for internship applications.
//
// Filtering, pagination, status transitions (with audit history), resume and
// offer-letter downloads, and CSV export.
//
// Status changes and deletes are POST + CSRF, deliberately stricter than the
// older GET-based deletes elsewhere in this admin panel.
// ============================================================

require_once ROOT_PATH . '/app/controllers/BaseController.php';
require_once ROOT_PATH . '/app/helpers/OfferLetter.php';
require_once ROOT_PATH . '/app/helpers/Mailer.php';

class ApplicationsController extends \BaseController {

    private const PER_PAGE = 15;

    /**
     * Filterable, paginated list.
     */
    public function index(): void {
        requireAdmin();

        [$where, $params] = $this->buildFilters();

        $countSql = "SELECT COUNT(*)
                     FROM applications a
                     JOIN internship_tracks t ON t.id = a.track_id
                     JOIN interns i           ON i.id = a.intern_id
                     {$where}";
        $stmt = $this->db->prepare($countSql);
        $stmt->execute($params);
        $total = (int) $stmt->fetchColumn();

        $page = paginate($total, self::PER_PAGE);

        // LIMIT/OFFSET are cast ints, never interpolated user strings.
        $sql = "SELECT a.*, t.title AS track_title, t.icon AS track_icon,
                       i.name AS intern_name, i.email AS intern_email, i.phone AS intern_phone,
                       i.college AS intern_college
                FROM applications a
                JOIN internship_tracks t ON t.id = a.track_id
                JOIN interns i           ON i.id = a.intern_id
                {$where}
                ORDER BY a.created_at DESC, a.id DESC
                LIMIT " . (int) $page['perPage'] . " OFFSET " . (int) $page['offset'];

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $applications = $stmt->fetchAll();

        $this->view('admin.applications.index', [
            'layout'       => 'admin',
            'pageTitle'    => 'Applications — Admin',
            'applications' => $applications,
            'tracks'       => $this->allTracks(),
            'statusCounts' => $this->statusCounts(),
            'page'         => $page,
            'filters'      => $this->currentFilters(),
        ]);
    }

    /**
     * Single application with its full history.
     */
    public function show(): void {
        requireAdmin();

        $id  = (int) ($_GET['id'] ?? 0);
        $app = $this->findApplication($id);

        $stmt = $this->db->prepare(
            "SELECT * FROM application_status_history
             WHERE application_id = ? ORDER BY created_at ASC, id ASC"
        );
        $stmt->execute([$id]);
        $history = $stmt->fetchAll();

        // Other applications by the same candidate, for context.
        $stmt = $this->db->prepare(
            "SELECT a.id, a.ref_no, a.status, t.title AS track_title
             FROM applications a
             JOIN internship_tracks t ON t.id = a.track_id
             WHERE a.intern_id = ? AND a.id <> ?
             ORDER BY a.created_at DESC"
        );
        $stmt->execute([(int) $app['intern_id'], $id]);
        $otherApplications = $stmt->fetchAll();

        $this->view('admin.applications.view', [
            'layout'            => 'admin',
            'pageTitle'         => 'Application ' . $app['ref_no'] . ' — Admin',
            'app'               => $app,
            'history'           => $history,
            'otherApplications' => $otherApplications,
        ]);
    }

    /**
     * Apply a status transition, record history, and notify the candidate.
     */
    public function updateStatus(): void {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/applications'));
        }
        $this->validateCsrf();

        $id        = (int) ($_POST['id'] ?? 0);
        $newStatus = (string) ($_POST['status'] ?? '');
        $note      = \Security::sanitize($_POST['note'] ?? '');
        $startDate = \Security::sanitize($_POST['start_date'] ?? '');
        $notify    = !empty($_POST['notify']);

        $app = $this->findApplication($id);

        // Whitelist the status — never trust a submitted enum value.
        if (!array_key_exists($newStatus, applicationStatuses())) {
            setFlash('error', 'That status is not recognised.');
            redirect(url('admin/applications/view?id=' . $id));
        }

        if (mb_strlen($note) > 500) {
            setFlash('error', 'Please keep the note under 500 characters.');
            redirect(url('admin/applications/view?id=' . $id));
        }

        if ($startDate !== '' && !$this->validDate($startDate)) {
            setFlash('error', 'Please provide the start date as YYYY-MM-DD.');
            redirect(url('admin/applications/view?id=' . $id));
        }

        $oldStatus = (string) $app['status'];

        if ($oldStatus === $newStatus && $note === '' && $startDate === '') {
            setFlash('error', 'Nothing to update — the status is already ' . statusLabel($newStatus) . '.');
            redirect(url('admin/applications/view?id=' . $id));
        }

        // Approval assigns the offer letter number and stamps the approval time.
        $offerNo    = $app['offer_letter_no'];
        $approvedAt = $app['approved_at'];

        if ($newStatus === 'approved') {
            $offerNo    = $offerNo ?: (string) $app['ref_no'];
            $approvedAt = $approvedAt ?: date('Y-m-d H:i:s');
        }

        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare(
                "UPDATE applications
                 SET status = ?, admin_notes = ?, reviewed_by = ?, reviewed_at = NOW(),
                     offer_letter_no = ?, approved_at = ?, start_date = ?, updated_at = NOW()
                 WHERE id = ?"
            );
            $stmt->execute([
                $newStatus,
                $note !== '' ? $note : $app['admin_notes'],
                (int) ($_SESSION['admin_id'] ?? 0) ?: null,
                $offerNo,
                $approvedAt,
                $startDate !== '' ? $startDate : $app['start_date'],
                $id,
            ]);

            if ($oldStatus !== $newStatus || $note !== '') {
                $hist = $this->db->prepare(
                    "INSERT INTO application_status_history
                        (application_id, old_status, new_status, note, changed_by, changed_by_name)
                     VALUES (?, ?, ?, ?, ?, ?)"
                );
                $hist->execute([
                    $id,
                    $oldStatus,
                    $newStatus,
                    $note !== '' ? $note : null,
                    (int) ($_SESSION['admin_id'] ?? 0) ?: null,
                    (string) ($_SESSION['admin_name'] ?? 'Admin'),
                ]);
            }

            $this->db->commit();
        } catch (\PDOException $e) {
            $this->db->rollBack();
            error_log('Status update failed: ' . $e->getMessage());
            setFlash('error', 'The status could not be updated. Please try again.');
            redirect(url('admin/applications/view?id=' . $id));
        }

        $emailed = false;
        if ($notify && $oldStatus !== $newStatus) {
            $emailed = \Mailer::statusChanged(
                (string) $app['intern_email'],
                (string) $app['intern_name'],
                (string) $app['track_title'],
                (string) $app['ref_no'],
                $newStatus,
                $note
            );
        }

        $msg = 'Application ' . $app['ref_no'] . ' set to ' . statusLabel($newStatus) . '.';
        if ($notify && $oldStatus !== $newStatus) {
            $msg .= $emailed
                ? ' The candidate has been emailed.'
                : ' The notification email could not be sent — check logs/error.log and your SMTP settings.';
        }

        setFlash('success', $msg);
        redirect(url('admin/applications/view?id=' . $id));
    }

    /**
     * Download a candidate's resume.
     */
    public function resume(): void {
        requireAdmin();

        $id  = (int) ($_GET['id'] ?? 0);
        $app = $this->findApplication($id);

        $file = RESUME_PATH . '/' . basename((string) $app['resume_path']);

        if (!is_file($file)) {
            setFlash('error', 'That resume file is missing from storage.');
            redirect(url('admin/applications/view?id=' . $id));
        }

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        // Prefix the candidate name so a folder of downloads stays navigable.
        $prefix   = preg_replace('/[^A-Za-z0-9]+/', '_', (string) $app['intern_name']) ?? 'candidate';
        $original = \Security::safeFilename((string) $app['resume_original_name']);
        $name     = trim($prefix, '_') . '_' . $original;

        header('Content-Type: ' . $app['resume_mime']);
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header('Content-Length: ' . (string) filesize($file));
        header('Cache-Control: private, no-store, max-age=0');
        header('X-Content-Type-Options: nosniff');
        readfile($file);
        exit;
    }

    /**
     * Download the generated offer letter for an approved application.
     */
    public function offerLetter(): void {
        requireAdmin();

        $id  = (int) ($_GET['id'] ?? 0);
        $app = $this->findApplication($id);

        if ($app['status'] !== 'approved') {
            setFlash('error', 'An offer letter can only be issued for an approved application.');
            redirect(url('admin/applications/view?id=' . $id));
        }

        $pdf = \OfferLetter::build($app);
        $pdf->download(\OfferLetter::filename($app));
    }

    /**
     * Export the current filtered set as CSV.
     */
    public function export(): void {
        requireAdmin();

        [$where, $params] = $this->buildFilters();

        $sql = "SELECT a.ref_no, i.name AS intern_name, i.email AS intern_email, i.phone AS intern_phone,
                       i.college AS intern_college, t.title AS track_title, a.status,
                       a.portfolio_url, a.created_at, a.reviewed_at, a.start_date,
                       a.offer_letter_no, a.admin_notes
                FROM applications a
                JOIN internship_tracks t ON t.id = a.track_id
                JOIN interns i           ON i.id = a.intern_id
                {$where}
                ORDER BY a.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $filename = 'internship_applications_' . date('Y-m-d_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: private, no-store, max-age=0');

        $out = fopen('php://output', 'wb');

        // BOM so Excel opens UTF-8 names correctly.
        fwrite($out, "\xEF\xBB\xBF");

        fputcsv($out, [
            'Reference', 'Candidate', 'Email', 'Phone', 'College', 'Track', 'Status',
            'Portfolio', 'Applied On', 'Reviewed On', 'Start Date', 'Offer No.', 'Admin Notes',
        ], ',', '"', '\\');

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            fputcsv($out, [
                $row['ref_no'],
                $row['intern_name'],
                $row['intern_email'],
                $row['intern_phone'],
                $row['intern_college'],
                $row['track_title'],
                statusLabel((string) $row['status']),
                $row['portfolio_url'],
                $row['created_at'],
                $row['reviewed_at'],
                $row['start_date'],
                $row['offer_letter_no'],
                $row['admin_notes'],
            ], ',', '"', '\\');
        }

        fclose($out);
        exit;
    }

    /**
     * Delete an application and its stored resume.
     */
    public function delete(): void {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/applications'));
        }
        $this->validateCsrf();

        $id  = (int) ($_POST['id'] ?? 0);
        $app = $this->findApplication($id);

        $stmt = $this->db->prepare("DELETE FROM applications WHERE id = ?");
        $stmt->execute([$id]);

        // Remove the orphaned file once the row is gone.
        $file = RESUME_PATH . '/' . basename((string) $app['resume_path']);
        if (is_file($file)) {
            @unlink($file);
        }

        setFlash('success', 'Application ' . $app['ref_no'] . ' and its resume were deleted.');
        redirect(url('admin/applications'));
    }

    // ── Internals ────────────────────────────────────────────────────────

    /**
     * Translate the query string into a parameterised WHERE clause.
     *
     * @return array{0:string,1:array<int,mixed>}
     */
    private function buildFilters(): array {
        $clauses = [];
        $params  = [];

        $status = (string) ($_GET['status'] ?? '');
        if ($status !== '' && array_key_exists($status, applicationStatuses())) {
            $clauses[] = 'a.status = ?';
            $params[]  = $status;
        }

        $trackId = (int) ($_GET['track'] ?? 0);
        if ($trackId > 0) {
            $clauses[] = 'a.track_id = ?';
            $params[]  = $trackId;
        }

        $search = trim((string) ($_GET['q'] ?? ''));
        if ($search !== '') {
            $clauses[] = '(i.name LIKE ? OR i.email LIKE ? OR a.ref_no LIKE ? OR i.college LIKE ?)';
            $like      = '%' . $search . '%';
            array_push($params, $like, $like, $like, $like);
        }

        $from = (string) ($_GET['from'] ?? '');
        if ($from !== '' && $this->validDate($from)) {
            $clauses[] = 'a.created_at >= ?';
            $params[]  = $from . ' 00:00:00';
        }

        $to = (string) ($_GET['to'] ?? '');
        if ($to !== '' && $this->validDate($to)) {
            $clauses[] = 'a.created_at <= ?';
            $params[]  = $to . ' 23:59:59';
        }

        return [$clauses ? 'WHERE ' . implode(' AND ', $clauses) : '', $params];
    }

    /**
     * Filter values echoed back into the form.
     */
    private function currentFilters(): array {
        return [
            'status' => (string) ($_GET['status'] ?? ''),
            'track'  => (int) ($_GET['track'] ?? 0),
            'q'      => trim((string) ($_GET['q'] ?? '')),
            'from'   => (string) ($_GET['from'] ?? ''),
            'to'     => (string) ($_GET['to'] ?? ''),
        ];
    }

    /**
     * Counts per status across ALL applications, for the filter chips.
     *
     * @return array<string,int>
     */
    private function statusCounts(): array {
        $counts = ['all' => 0];
        foreach (array_keys(applicationStatuses()) as $key) {
            $counts[$key] = 0;
        }

        $stmt = $this->db->query("SELECT status, COUNT(*) AS c FROM applications GROUP BY status");
        foreach ($stmt->fetchAll() as $row) {
            $counts[$row['status']] = (int) $row['c'];
            $counts['all'] += (int) $row['c'];
        }

        return $counts;
    }

    private function allTracks(): array {
        return $this->db->query(
            "SELECT id, title FROM internship_tracks ORDER BY sort_order ASC, title ASC"
        )->fetchAll();
    }

    /**
     * Fetch a full application row, or 404.
     */
    private function findApplication(int $id): array {
        if ($id <= 0) {
            $this->notFound();
        }

        $stmt = $this->db->prepare(
            "SELECT a.*, t.title AS track_title, t.slug AS track_slug, t.duration_weeks,
                    t.stipend_text, t.mode, t.icon AS track_icon,
                    i.name AS intern_name, i.email AS intern_email, i.phone AS intern_phone,
                    i.college AS intern_college, i.course AS intern_course,
                    i.graduation_year AS intern_grad_year,
                    u.name AS reviewer_name
             FROM applications a
             JOIN internship_tracks t ON t.id = a.track_id
             JOIN interns i           ON i.id = a.intern_id
             LEFT JOIN users u        ON u.id = a.reviewed_by
             WHERE a.id = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        $app = $stmt->fetch();

        if (!$app) {
            $this->notFound();
        }

        return $app;
    }

    private function validDate(string $date): bool {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d !== false && $d->format('Y-m-d') === $date;
    }

    private function notFound(): never {
        http_response_code(404);
        require_once ROOT_PATH . '/app/views/errors/404.php';
        exit;
    }
}
