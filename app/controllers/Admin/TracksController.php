<?php
namespace Admin;

// ============================================================
// Admin\TracksController — CRUD for the internship tracks.
// Follows the same shape as the existing Admin\ServicesController.
// ============================================================

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class TracksController extends \BaseController {

    public function index(): void {
        requireAdmin();

        $tracks = $this->db->query(
            "SELECT t.*,
                    (SELECT COUNT(*) FROM applications a WHERE a.track_id = t.id) AS application_count
             FROM internship_tracks t
             ORDER BY t.sort_order ASC, t.title ASC"
        )->fetchAll();

        $this->view('admin.tracks.index', [
            'layout'    => 'admin',
            'pageTitle' => 'Internship Tracks — Admin',
            'tracks'    => $tracks,
        ]);
    }

    public function add(): void {
        requireAdmin();

        $this->view('admin.tracks.form', [
            'layout'    => 'admin',
            'pageTitle' => 'Add Internship Track — Admin',
            'track'     => null,
        ]);
    }

    public function edit(): void {
        requireAdmin();

        $track = $this->findTrack((int) ($_GET['id'] ?? 0));

        $this->view('admin.tracks.form', [
            'layout'    => 'admin',
            'pageTitle' => 'Edit ' . $track['title'] . ' — Admin',
            'track'     => $track,
        ]);
    }

    public function store(): void {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/tracks'));
        }
        $this->validateCsrf();

        $data   = $this->formData();
        $errors = $this->validate($data);

        if ($errors) {
            setFlash('error', implode(' ', $errors));
            redirect(url('admin/tracks/add'));
        }

        $slug = slugify($data['title']);
        if ($this->slugTaken($slug, null)) {
            $slug .= '-' . substr(bin2hex(random_bytes(3)), 0, 4);
        }

        $stmt = $this->db->prepare(
            "INSERT INTO internship_tracks
                (title, slug, short_desc, description, skills, icon,
                 duration_weeks, stipend_text, seats, mode, is_active, sort_order)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['title'], $slug, $data['short_desc'], $data['description'],
            $data['skills'], $data['icon'], $data['duration_weeks'], $data['stipend_text'],
            $data['seats'], $data['mode'], $data['is_active'], $data['sort_order'],
        ]);

        setFlash('success', $data['title'] . ' has been added.');
        redirect(url('admin/tracks'));
    }

    public function update(): void {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/tracks'));
        }
        $this->validateCsrf();

        $id    = (int) ($_POST['id'] ?? 0);
        $track = $this->findTrack($id);

        $data   = $this->formData();
        $errors = $this->validate($data);

        if ($errors) {
            setFlash('error', implode(' ', $errors));
            redirect(url('admin/tracks/edit?id=' . $id));
        }

        // Keep the existing slug unless the title changed, so inbound links survive.
        $slug = (string) $track['slug'];
        if ($data['title'] !== $track['title']) {
            $candidate = slugify($data['title']);
            if (!$this->slugTaken($candidate, $id)) {
                $slug = $candidate;
            }
        }

        $stmt = $this->db->prepare(
            "UPDATE internship_tracks
             SET title = ?, slug = ?, short_desc = ?, description = ?, skills = ?, icon = ?,
                 duration_weeks = ?, stipend_text = ?, seats = ?, mode = ?, is_active = ?, sort_order = ?
             WHERE id = ?"
        );
        $stmt->execute([
            $data['title'], $slug, $data['short_desc'], $data['description'],
            $data['skills'], $data['icon'], $data['duration_weeks'], $data['stipend_text'],
            $data['seats'], $data['mode'], $data['is_active'], $data['sort_order'], $id,
        ]);

        setFlash('success', $data['title'] . ' has been updated.');
        redirect(url('admin/tracks'));
    }

    /**
     * Delete a track — refused if applications reference it, since the FK is
     * ON DELETE RESTRICT and losing applications would be worse than keeping
     * an unwanted track.
     */
    public function delete(): void {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/tracks'));
        }
        $this->validateCsrf();

        $id    = (int) ($_POST['id'] ?? 0);
        $track = $this->findTrack($id);

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM applications WHERE track_id = ?");
        $stmt->execute([$id]);

        if ((int) $stmt->fetchColumn() > 0) {
            setFlash(
                'error',
                'This track has applications against it, so it cannot be deleted. Hide it instead by setting it inactive.'
            );
            redirect(url('admin/tracks'));
        }

        $stmt = $this->db->prepare("DELETE FROM internship_tracks WHERE id = ?");
        $stmt->execute([$id]);

        setFlash('success', $track['title'] . ' has been deleted.');
        redirect(url('admin/tracks'));
    }

    // ── Internals ────────────────────────────────────────────────────────

    private function formData(): array {
        return [
            'title'          => \Security::sanitize($_POST['title'] ?? ''),
            'short_desc'     => \Security::sanitize($_POST['short_desc'] ?? ''),
            'description'    => \Security::sanitize($_POST['description'] ?? ''),
            'skills'         => \Security::sanitize($_POST['skills'] ?? ''),
            'icon'           => \Security::sanitize($_POST['icon'] ?? 'fa-code'),
            'stipend_text'   => \Security::sanitize($_POST['stipend_text'] ?? 'Performance based'),
            'mode'           => \Security::sanitize($_POST['mode'] ?? 'Remote / Hybrid'),
            'duration_weeks' => max(1, min(104, (int) ($_POST['duration_weeks'] ?? 8))),
            'seats'          => max(0, min(9999, (int) ($_POST['seats'] ?? 10))),
            'sort_order'     => (int) ($_POST['sort_order'] ?? 0),
            'is_active'      => !empty($_POST['is_active']) ? 1 : 0,
        ];
    }

    /**
     * @return string[]
     */
    private function validate(array $d): array {
        $errors = [];

        if (mb_strlen($d['title']) < 3 || mb_strlen($d['title']) > 150) {
            $errors[] = 'Please enter a track title between 3 and 150 characters.';
        }
        if (mb_strlen($d['short_desc']) < 10 || mb_strlen($d['short_desc']) > 255) {
            $errors[] = 'The short description must be between 10 and 255 characters.';
        }
        if (mb_strlen($d['description']) < 20) {
            $errors[] = 'Please write a fuller description of at least 20 characters.';
        }
        if (mb_strlen($d['skills']) > 500) {
            $errors[] = 'Please keep the skills list under 500 characters.';
        }
        if (!preg_match('/^fa-[a-z0-9-]+$/', $d['icon'])) {
            $errors[] = 'The icon must be a Font Awesome class such as fa-code.';
        }

        return $errors;
    }

    private function slugTaken(string $slug, ?int $exceptId): bool {
        $sql    = "SELECT id FROM internship_tracks WHERE slug = ?";
        $params = [$slug];

        if ($exceptId !== null) {
            $sql     .= " AND id <> ?";
            $params[] = $exceptId;
        }

        $stmt = $this->db->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);
        return (bool) $stmt->fetch();
    }

    private function findTrack(int $id): array {
        $stmt = $this->db->prepare("SELECT * FROM internship_tracks WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $track = $stmt->fetch();

        if (!$track) {
            setFlash('error', 'That internship track could not be found.');
            redirect(url('admin/tracks'));
        }

        return $track;
    }
}
