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

    /**
     * Send a reply to a contact-form message from the site mailbox.
     */
    public function reply(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(url('admin/contacts'));
        $this->validateCsrf();

        $id   = (int) ($_POST['id'] ?? 0);
        $stmt = $this->db->prepare("SELECT * FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        $contact = $stmt->fetch();
        if (!$contact) { setFlash('error', 'Message not found.'); redirect(url('admin/contacts')); }

        $back    = url('admin/contacts/view?id=' . $id);
        // Strip CR/LF so a subject can never inject extra mail headers.
        $subject = trim(str_replace(["\r", "\n"], ' ', (string) ($_POST['subject'] ?? '')));
        $body    = trim((string) ($_POST['body'] ?? ''));

        if ($subject === '' || mb_strlen($subject) > 200) {
            setFlash('error', 'Please enter a subject (up to 200 characters).');
            redirect($back);
        }
        if (mb_strlen($body) < 2 || mb_strlen($body) > 10000) {
            setFlash('error', 'Please write a reply (up to 10,000 characters).');
            redirect($back);
        }

        require_once ROOT_PATH . '/app/helpers/Mailer.php';
        $sent = \Mailer::contactReply(
            (string) $contact['email'],
            (string) $contact['name'],
            $subject,
            $body,
            (string) $contact['message'],
            formatDate($contact['created_at'], 'd M Y, H:i')
        );

        if ($sent) {
            setFlash('success', 'Reply sent to ' . $contact['email'] . '.');
        } else {
            setFlash('error', 'Reply could not be sent: ' . (\Mailer::$lastError ?: 'unknown error') . ' Your text is kept below.');
            $_SESSION['contact_reply_draft'] = ['id' => $id, 'subject' => $subject, 'body' => $body];
        }
        redirect($back);
    }

    public function delete(): void {
        requireAdmin();
        $this->db->prepare("DELETE FROM contacts WHERE id=?")->execute([(int)($_GET['id'] ?? 0)]);
        setFlash('success','Message deleted.');
        redirect(url('admin/contacts'));
    }
}
