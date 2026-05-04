<?php
namespace Admin;

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class TestimonialsController extends \BaseController {

    public function index(): void {
        requireAdmin();
        $rows = $this->db->query("SELECT * FROM testimonials ORDER BY sort_order ASC")->fetchAll();
        $this->view('admin.testimonials.index', [
            'layout' => 'admin', 'pageTitle' => 'Testimonials — Admin', 'testimonials' => $rows,
        ]);
    }

    public function add(): void {
        requireAdmin();
        $this->view('admin.testimonials.form', [
            'layout' => 'admin', 'pageTitle' => 'Add Testimonial', 'testimonial' => null,
        ]);
    }

    public function store(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(url('admin/testimonials'));
        $this->validateCsrf();
        $d = $this->formData();
        $this->db->prepare(
            "INSERT INTO testimonials (name,position,company,message,rating,is_active,sort_order) VALUES (?,?,?,?,?,?,?)"
        )->execute([$d['name'],$d['position'],$d['company'],$d['message'],$d['rating'],$d['is_active'],$d['sort_order']]);
        setFlash('success','Testimonial added.');
        redirect(url('admin/testimonials'));
    }

    public function edit(): void {
        requireAdmin();
        $row = $this->find((int)($_GET['id'] ?? 0));
        $this->view('admin.testimonials.form', [
            'layout' => 'admin', 'pageTitle' => 'Edit Testimonial', 'testimonial' => $row,
        ]);
    }

    public function update(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(url('admin/testimonials'));
        $this->validateCsrf();
        $id = (int)($_POST['id'] ?? 0);
        $d  = $this->formData();
        $this->db->prepare(
            "UPDATE testimonials SET name=?,position=?,company=?,message=?,rating=?,is_active=?,sort_order=? WHERE id=?"
        )->execute([$d['name'],$d['position'],$d['company'],$d['message'],$d['rating'],$d['is_active'],$d['sort_order'],$id]);
        setFlash('success','Testimonial updated.');
        redirect(url('admin/testimonials'));
    }

    public function delete(): void {
        requireAdmin();
        $this->db->prepare("DELETE FROM testimonials WHERE id=?")->execute([(int)($_GET['id'] ?? 0)]);
        setFlash('success','Testimonial deleted.');
        redirect(url('admin/testimonials'));
    }

    private function find(int $id): array {
        $stmt = $this->db->prepare("SELECT * FROM testimonials WHERE id=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) { setFlash('error','Not found.'); redirect(url('admin/testimonials')); }
        return $row;
    }

    private function formData(): array {
        $s = fn($k) => \Security::sanitize($_POST[$k] ?? '');
        return [
            'name'       => $s('name'),
            'position'   => $s('position'),
            'company'    => $s('company'),
            'message'    => $s('message'),
            'rating'     => min(5, max(1, (int)($_POST['rating'] ?? 5))),
            'is_active'  => isset($_POST['is_active']) ? 1 : 0,
            'sort_order' => (int)($_POST['sort_order'] ?? 0),
        ];
    }
}
