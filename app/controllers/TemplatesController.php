<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

class TemplatesController extends BaseController {

    public function index(): void {
        $stmt = $this->db->prepare(
            "SELECT * FROM templates WHERE is_active = 1 ORDER BY created_at DESC"
        );
        $stmt->execute();
        $templates = $stmt->fetchAll();

        $this->view('templates', [
            'templates' => $templates,
            'pageTitle' => 'Templates - ' . APP_NAME,
            'metaDescription' => 'Discover responsive website templates from Ecotech Service, built to help businesses launch professional digital experiences faster.',
            'canonicalPath' => 'templates',
        ]);
    }
}
