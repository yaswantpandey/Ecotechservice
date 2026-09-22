<?php
namespace Admin;

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class ProjectsController extends \BaseController {

    public function index(): void {
        requireAdmin();
        $projects = $this->db->query(
            "SELECT * FROM projects ORDER BY sort_order ASC, created_at DESC"
        )->fetchAll();

        $this->view('admin.projects.index', [
            'layout' => 'admin', 'pageTitle' => 'Projects — Admin', 'projects' => $projects,
        ]);
    }

    public function add(): void {
        requireAdmin();
        $this->view('admin.projects.form', [
            'layout' => 'admin', 'pageTitle' => 'Add Project — Admin', 'project' => null,
        ]);
    }

    public function store(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(url('admin/projects'));
        $this->validateCsrf();

        $data = $this->extractFormData();
        $thumb = $this->handleImageUpload('thumbnail', 'projects');

        $this->db->prepare(
            "INSERT INTO projects (title,slug,description,tech_stack,category,thumbnail,live_url,github_url,is_featured,is_active,sort_order)
             VALUES (?,?,?,?,?,?,?,?,?,?,?)"
        )->execute([
            $data['title'], $data['slug'], $data['description'], $data['tech_stack'],
            $data['category'], $thumb, $data['live_url'], $data['github_url'],
            $data['is_featured'], $data['is_active'], $data['sort_order'],
        ]);

        setFlash('success', 'Project added successfully.');
        redirect(url('admin/projects'));
    }

    public function edit(): void {
        requireAdmin();
        $id      = (int)($_GET['id'] ?? 0);
        $project = $this->findProject($id);
        $this->view('admin.projects.form', [
            'layout' => 'admin', 'pageTitle' => 'Edit Project — Admin', 'project' => $project,
        ]);
    }

    public function update(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(url('admin/projects'));
        $this->validateCsrf();

        $id      = (int)($_POST['id'] ?? 0);
        $project = $this->findProject($id);
        $data    = $this->extractFormData();
        $thumb   = $this->handleImageUpload('thumbnail', 'projects') ?? $project['thumbnail'];

        $this->db->prepare(
            "UPDATE projects SET title=?,slug=?,description=?,tech_stack=?,category=?,thumbnail=?,
             live_url=?,github_url=?,is_featured=?,is_active=?,sort_order=? WHERE id=?"
        )->execute([
            $data['title'], $data['slug'], $data['description'], $data['tech_stack'],
            $data['category'], $thumb, $data['live_url'], $data['github_url'],
            $data['is_featured'], $data['is_active'], $data['sort_order'], $id,
        ]);

        setFlash('success', 'Project updated successfully.');
        redirect(url('admin/projects'));
    }

    public function delete(): void {
        requireAdmin();
        // Destructive action: POST + CSRF only, so a crafted link or image
        // tag cannot delete a project on behalf of a logged-in admin.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/projects'));
        }
        $this->validateCsrf();

        $id = (int)($_POST['id'] ?? 0);
        $this->db->prepare("DELETE FROM projects WHERE id = ?")->execute([$id]);
        setFlash('success', 'Project deleted.');
        redirect(url('admin/projects'));
    }

    // ── Private helpers ───────────────────────────────────────

    private function findProject(int $id): array {
        $stmt = $this->db->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) {
            setFlash('error', 'Project not found.');
            redirect(url('admin/projects'));
        }
        return $row;
    }

    private function extractFormData(): array {
        $s = fn($k) => \Security::sanitize($_POST[$k] ?? '');
        return [
            'title'       => $s('title'),
            'slug'        => slugify($s('title')),
            'description' => $s('description'),
            'tech_stack'  => $s('tech_stack'),
            'category'    => $s('category'),
            'live_url'    => $s('live_url'),
            'github_url'  => $s('github_url'),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_active'   => isset($_POST['is_active'])   ? 1 : 0,
            'sort_order'  => (int)($_POST['sort_order'] ?? 0),
        ];
    }

    private function handleImageUpload(string $field, string $subDir): ?string {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            try {
                return \Security::uploadImage($_FILES[$field], $subDir);
            } catch (\RuntimeException $e) {
                setFlash('warning', 'Image upload skipped: ' . $e->getMessage());
            }
        }
        return null;
    }
}
