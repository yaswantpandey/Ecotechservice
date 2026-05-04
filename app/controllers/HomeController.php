<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

class HomeController extends BaseController {

    public function index(): void {
        // Featured projects
        $stmt = $this->db->prepare(
            "SELECT * FROM projects WHERE is_featured = 1 AND is_active = 1 ORDER BY sort_order ASC LIMIT 6"
        );
        $stmt->execute();
        $featuredProjects = $stmt->fetchAll();

        // Services preview
        $stmt = $this->db->prepare(
            "SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 6"
        );
        $stmt->execute();
        $services = $stmt->fetchAll();

        // Testimonials preview
        $stmt = $this->db->prepare(
            "SELECT * FROM testimonials WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 4"
        );
        $stmt->execute();
        $testimonials = $stmt->fetchAll();

        $this->view('home', [
            'featuredProjects' => $featuredProjects,
            'services' => $services,
            'testimonials' => $testimonials,
            'pageTitle' => APP_NAME . ' | Web Development, Digital Marketing & Eco-Tech Solutions',
            'metaDescription' => 'Ecotech Service builds websites, web apps, digital marketing campaigns, and eco-technology solutions that help modern businesses grow sustainably.',
            'canonicalPath' => '',
        ]);
    }
}
