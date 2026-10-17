<?php
// ============================================================
// InternshipsController — public track listing, track detail and
// application submission.
// ============================================================

require_once ROOT_PATH . '/app/controllers/BaseController.php';
require_once ROOT_PATH . '/app/helpers/Mailer.php';

class InternshipsController extends BaseController {

    /**
     * Listing of every open track.
     */
    public function index(): void {
        // A schema problem (e.g. the internship migration not run on this
        // database) is logged and shown as "no tracks open", not a 500.
        try {
            $stmt = $this->db->query(
                "SELECT t.*,
                        (SELECT COUNT(*) FROM applications a WHERE a.track_id = t.id) AS application_count
                 FROM internship_tracks t
                 WHERE t.is_active = 1
                 ORDER BY t.sort_order ASC, t.title ASC"
            );
            $tracks = $stmt->fetchAll();
        } catch (Throwable $e) {
            $this->logDbFailure('index', $e);
            $tracks = [];
        }

        // Which tracks has this intern already applied to, so the cards can say so.
        try {
            $applied = $this->appliedTrackIds();
        } catch (Throwable $e) {
            $this->logDbFailure('appliedTrackIds', $e);
            $applied = [];
        }

        $this->view('internships.index', [
            'pageTitle'       => '11 Internship Tracks — Apply Online | ' . APP_NAME,
            'metaDescription' => 'Apply for Ecotech Services internships in full stack, frontend, backend, '
                . 'Python, Java, mobile app, UI/UX, cybersecurity, IoT, AI & machine learning and data science. '
                . 'Remote and hybrid options with mentorship and a completion certificate.',
            'metaKeywords'    => 'internship, full stack internship, python internship, cybersecurity internship, '
                . 'data science internship, ai ml internship, iot internship, ui ux internship, lucknow internship',
            'canonicalPath'   => 'internships',
            'tracks'          => $tracks,
            'appliedIds'      => $applied,
        ]);
    }

    /**
     * Single track detail page.
     */
    public function show(): void {
        $slug  = Security::sanitize($_GET['slug'] ?? '');
        $track = $this->findTrackBySlug($slug);

        if (!$track) {
            $this->notFound();
        }

        $applied = $this->appliedTrackIds();

        $this->view('internships.show', [
            'pageTitle'       => $track['title'] . ' Internship — Apply Now | ' . APP_NAME,
            'metaDescription' => truncate($track['short_desc'], 155, ''),
            'canonicalPath'   => 'internships/track?slug=' . $track['slug'],
            'track'           => $track,
            'alreadyApplied'  => in_array((int) $track['id'], $applied, true),
        ]);
    }

    /**
     * Application form. Requires a signed-in intern.
     */
    public function apply(): void {
        requireIntern();

        $slug  = Security::sanitize($_GET['slug'] ?? '');
        $track = $this->findTrackBySlug($slug);

        if (!$track) {
            $this->notFound();
        }

        // Do not present a form that is guaranteed to be rejected.
        if ($this->hasApplied((int) $track['id'])) {
            setFlash('error', 'You have already applied for the ' . $track['title'] . ' track.');
            redirect(url('internships/dashboard'));
        }

        $this->view('internships.apply', [
            'pageTitle'     => 'Apply — ' . $track['title'] . ' | ' . APP_NAME,
            'canonicalPath' => 'internships/apply?slug=' . $track['slug'],
            'robotsMeta'    => 'noindex, nofollow',
            'track'         => $track,
            'maxResume'     => Security::humanSize(Security::maxResumeBytes()),
            'old'           => $this->oldInput(),
        ]);
    }

    /**
     * Handle the submitted application.
     */
    public function store(): void {
        requireIntern();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('internships'));
        }
        $this->validateCsrf();

        $internId = (int) internId();
        $trackId  = (int) ($_POST['track_id'] ?? 0);

        $stmt = $this->db->prepare(
            "SELECT * FROM internship_tracks WHERE id = ? AND is_active = 1 LIMIT 1"
        );
        $stmt->execute([$trackId]);
        $track = $stmt->fetch();

        if (!$track) {
            setFlash('error', 'That internship track is not available.');
            redirect(url('internships'));
        }

        $back = url('internships/apply?slug=' . $track['slug']);

        $coverNote = Security::sanitize($_POST['cover_note'] ?? '');
        $portfolio = trim((string) ($_POST['portfolio_url'] ?? ''));
        $agree     = !empty($_POST['agree']);

        $errors = [];

        if (mb_strlen($coverNote) < 40) {
            $errors[] = 'Please write at least 40 characters about why you are a good fit.';
        }
        if (mb_strlen($coverNote) > 4000) {
            $errors[] = 'Please keep your note under 4000 characters.';
        }
        if ($portfolio !== '') {
            if (!Security::validUrl($portfolio) || !preg_match('#^https?://#i', $portfolio)) {
                $errors[] = 'Your portfolio link must be a valid http or https URL.';
            } elseif (mb_strlen($portfolio) > 255) {
                $errors[] = 'That portfolio link is too long.';
            }
        }
        if (!$agree) {
            $errors[] = 'Please confirm the information you have provided is accurate.';
        }

        if ($this->hasApplied($trackId)) {
            setFlash('error', 'You have already applied for this track.');
            redirect(url('internships/dashboard'));
        }

        if ($errors) {
            $this->rememberInput(['cover_note' => $coverNote, 'portfolio_url' => $portfolio]);
            setFlash('error', implode(' ', $errors));
            redirect($back);
        }

        // Resume last: no point storing a file if the rest is invalid.
        try {
            $resume = Security::uploadResume($_FILES['resume'] ?? []);
        } catch (RuntimeException $e) {
            $this->rememberInput(['cover_note' => $coverNote, 'portfolio_url' => $portfolio]);
            setFlash('error', $e->getMessage());
            redirect($back);
        }

        $refNo = $this->generateRefNo();

        try {
            $stmt = $this->db->prepare(
                "INSERT INTO applications
                    (ref_no, intern_id, track_id, cover_note, portfolio_url,
                     resume_path, resume_original_name, resume_mime, resume_size, ip_address)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $refNo,
                $internId,
                $trackId,
                $coverNote,
                $portfolio !== '' ? $portfolio : null,
                $resume['path'],
                $resume['original'],
                $resume['mime'],
                $resume['size'],
                $_SERVER['REMOTE_ADDR'] ?? null,
            ]);

            $applicationId = (int) $this->db->lastInsertId();

            // Seed the history so the dashboard timeline always has an origin entry.
            $hist = $this->db->prepare(
                "INSERT INTO application_status_history
                    (application_id, old_status, new_status, note, changed_by_name)
                 VALUES (?, NULL, 'pending', ?, ?)"
            );
            $hist->execute([$applicationId, 'Application submitted.', internName()]);
        } catch (PDOException $e) {
            // Clean up the stored resume so a failed insert does not orphan a file.
            @unlink(RESUME_PATH . '/' . $resume['path']);

            if ($e->getCode() === '23000') {
                setFlash('error', 'You have already applied for this track.');
                redirect(url('internships/dashboard'));
            }

            error_log('Application insert failed: ' . $e->getMessage());
            setFlash('error', 'We could not submit your application. Please try again.');
            redirect($back);
        }

        $email = (string) ($_SESSION['intern_email'] ?? '');
        Mailer::applicationReceived($email, internName(), (string) $track['title'], $refNo);
        Mailer::adminAlert(internName(), (string) $track['title'], $refNo, $email);

        setFlash('success', 'Application submitted. Your reference is ' . $refNo . '.');
        redirect(url('internships/dashboard'));
    }

    // ── Internals ────────────────────────────────────────────────────────

    private function findTrackBySlug(string $slug): array|false {
        if ($slug === '') {
            return false;
        }
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM internship_tracks WHERE slug = ? AND is_active = 1 LIMIT 1"
            );
            $stmt->execute([$slug]);
            return $stmt->fetch();
        } catch (Throwable $e) {
            $this->logDbFailure('findTrackBySlug', $e);
            return false;
        }
    }

    /**
     * Record a database failure with enough detail to fix it (missing table,
     * missing column, …) without exposing it to visitors.
     */
    private function logDbFailure(string $where, Throwable $e): void {
        error_log(sprintf('[internships:%s] %s: %s', $where, get_class($e), $e->getMessage()));
    }

    /**
     * Track ids the current intern has already applied to.
     *
     * @return int[]
     */
    private function appliedTrackIds(): array {
        if (!isIntern()) {
            return [];
        }
        $stmt = $this->db->prepare("SELECT track_id FROM applications WHERE intern_id = ?");
        $stmt->execute([internId()]);
        return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
    }

    private function hasApplied(int $trackId): bool {
        $stmt = $this->db->prepare(
            "SELECT id FROM applications WHERE intern_id = ? AND track_id = ? LIMIT 1"
        );
        $stmt->execute([internId(), $trackId]);
        return (bool) $stmt->fetch();
    }

    /**
     * Sequential, human-quotable reference: ECO-INT-2026-0001.
     *
     * Retries on the (unlikely) race where two submissions derive the same
     * number; the UNIQUE index on ref_no is the final arbiter.
     */
    private function generateRefNo(): string {
        $year = date('Y');

        $stmt = $this->db->prepare(
            "SELECT ref_no FROM applications
             WHERE ref_no LIKE ?
             ORDER BY id DESC LIMIT 1"
        );
        $stmt->execute([OFFER_PREFIX . '-' . $year . '-%']);
        $last = $stmt->fetchColumn();

        $next = 1;
        if ($last && preg_match('/-(\d+)$/', (string) $last, $m)) {
            $next = (int) $m[1] + 1;
        }

        return sprintf('%s-%s-%04d', OFFER_PREFIX, $year, $next);
    }

    private function notFound(): never {
        http_response_code(404);
        require_once ROOT_PATH . '/app/views/errors/404.php';
        exit;
    }

    private function rememberInput(array $data): void {
        $_SESSION['intern_old'] = $data;
    }

    private function oldInput(): array {
        $old = $_SESSION['intern_old'] ?? [];
        unset($_SESSION['intern_old']);
        return is_array($old) ? $old : [];
    }
}
