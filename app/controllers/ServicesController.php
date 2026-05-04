<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

class ServicesController extends BaseController {

    public function index(): void {
        $stmt = $this->db->prepare(
            "SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order ASC"
        );
        $stmt->execute();
        $services = $stmt->fetchAll();

        $this->view('services', [
            'services' => $services,
            'pageTitle' => 'Services - ' . APP_NAME,
            'metaDescription' => 'Explore Ecotech Service offerings including web development, app development, UI/UX design, digital marketing, and growth-focused technology consulting.',
            'canonicalPath' => 'services',
        ]);
    }
}
