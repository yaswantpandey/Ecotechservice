<?php
namespace Admin;

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class ContactsController extends \BaseController {

    public function index(): void {
        requireAdmin();
        $contacts = $this->db->query(
            "SELECT * FROM contacts ORDER BY created_at DESC"
        )->fetchAll();
        $this->view('admin.contacts.index', [
            'layout' => 'admin', 'pageTitle' => 'Contact Submissions — Admin', 'contacts' => $contacts,
        ]);
    }

    public function show(): void {
        requireAdmin();
        $id   = (int)($_GET['id'] ?? 0);
        $stmt = $this->db->prepare("SELECT * FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        $contact = $stmt->fetch();
        if (!$contact) { setFlash('error','Not found.'); redirect(url('admin/contacts')); }

        // Mark as read
        $this->db->prepare("UPDATE contacts SET is_read = 1 WHERE id = ?")->execute([$id]);

        $this->view('admin.contacts.view', [
            'layout' => 'admin', 'pageTitle' => 'View Message — Admin', 'contact' => $contact,
        ]);
    }

    public function delete(): void {
        requireAdmin();
        $this->db->prepare("DELETE FROM contacts WHERE id=?")->execute([(int)($_GET['id'] ?? 0)]);
        setFlash('success','Message deleted.');
        redirect(url('admin/contacts'));
    }
}
