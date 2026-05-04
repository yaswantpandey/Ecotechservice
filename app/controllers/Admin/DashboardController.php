<?php
namespace Admin;

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class DashboardController extends \BaseController {

    public function index(): void {
        requireAdmin();

        // Quick stats
        $stats = [
            'projects'     => $this->count('projects'),
            'services'     => $this->count('services'),
            'testimonials' => $this->count('testimonials'),
            'blog_posts'   => $this->count('blog_posts'),
            'contacts'     => $this->count('contacts'),
            'unread'       => $this->count('contacts', 'is_read = 0'),
        ];

        // Latest 5 contacts
        $stmt = $this->db->query(
            "SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5"
        );
        $recentContacts = $stmt->fetchAll();

        $this->view('admin.dashboard', [
            'layout'    => 'admin',
            'pageTitle' => 'Dashboard — Admin',
            'stats'     => $stats,
            'recentContacts' => $recentContacts,
        ]);
    }

    private function count(string $table, string $where = ''): int {
        $sql  = "SELECT COUNT(*) FROM `{$table}`";
        if ($where) $sql .= " WHERE {$where}";
        return (int)$this->db->query($sql)->fetchColumn();
    }
}
