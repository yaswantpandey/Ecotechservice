<?php
namespace Admin;

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class SettingsController extends \BaseController {

    public function index(): void {
        requireAdmin();
        $stmt = $this->db->query("SELECT * FROM site_settings ORDER BY `key` ASC");
        $settings = [];
        foreach ($stmt->fetchAll() as $row) {
            $settings[$row['key']] = $row['value'];
        }
        $this->view('admin.settings', [
            'layout' => 'admin', 'pageTitle' => 'Settings — Admin', 'settings' => $settings,
        ]);
    }

    public function update(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(url('admin/settings'));
        $this->validateCsrf();

        $stmt = $this->db->prepare(
            "INSERT INTO site_settings (`key`,`value`) VALUES (?,?)
             ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)"
        );

        $allowed = [
            'site_name','site_tagline','site_email','site_phone','site_address',
            'whatsapp_number','google_analytics_id','meta_description',
            'facebook_url','twitter_url','linkedin_url','instagram_url',
        ];

        foreach ($allowed as $key) {
            if (isset($_POST[$key])) {
                $stmt->execute([$key, \Security::sanitize($_POST[$key])]);
            }
        }

        setFlash('success', 'Settings saved successfully.');
        redirect(url('admin/settings'));
    }
}
