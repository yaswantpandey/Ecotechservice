<?php
namespace Admin;

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class ServicesController extends \BaseController {

    public function index(): void {
        requireAdmin();
        $services = $this->db->query(
            "SELECT * FROM services ORDER BY sort_order ASC"
        )->fetchAll();
        $this->view('admin.services.index', [
            'layout' => 'admin', 'pageTitle' => 'Services — Admin', 'services' => $services,
        ]);
    }

    public function add(): void {
        requireAdmin();
        $this->view('admin.services.form', [
            'layout' => 'admin', 'pageTitle' => 'Add Service — Admin', 'service' => null,
        ]);
    }

    public function store(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(url('admin/services'));
        $this->validateCsrf();
        $d = $this->formData();
        $this->db->prepare(
            "INSERT INTO services (title,slug,description,icon,is_active,sort_order) VALUES (?,?,?,?,?,?)"
        )->execute([$d['title'], $d['slug'], $d['description'], $d['icon'], $d['is_active'], $d['sort_order']]);
        setFlash('success', 'Service added.');
        redirect(url('admin/services'));
    }

    public function edit(): void {
        requireAdmin();
        $service = $this->find((int)($_GET['id'] ?? 0));
        $this->view('admin.services.form', [
            'layout' => 'admin', 'pageTitle' => 'Edit Service — Admin', 'service' => $service,
        ]);
    }

    public function update(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(url('admin/services'));
        $this->validateCsrf();
        $id = (int)($_POST['id'] ?? 0);
        $d  = $this->formData();
        $this->db->prepare(
            "UPDATE services SET title=?,slug=?,description=?,icon=?,is_active=?,sort_order=? WHERE id=?"
        )->execute([$d['title'], $d['slug'], $d['description'], $d['icon'], $d['is_active'], $d['sort_order'], $id]);
        setFlash('success', 'Service updated.');
        redirect(url('admin/services'));
    }

    public function delete(): void {
        requireAdmin();
        $this->db->prepare("DELETE FROM services WHERE id=?")->execute([(int)($_GET['id'] ?? 0)]);
        setFlash('success', 'Service deleted.');
        redirect(url('admin/services'));
    }

    private function find(int $id): array {
        $stmt = $this->db->prepare("SELECT * FROM services WHERE id=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) { setFlash('error','Not found.'); redirect(url('admin/services')); }
        return $row;
    }

    private function formData(): array {
        $s = fn($k) => \Security::sanitize($_POST[$k] ?? '');
        return [
            'title'      => $s('title'),
            'slug'       => slugify($s('title')),
            'description'=> $s('description'),
            'icon'       => $s('icon') ?: 'fa-cog',
            'is_active'  => isset($_POST['is_active']) ? 1 : 0,
            'sort_order' => (int)($_POST['sort_order'] ?? 0),
        ];
    }
}
