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
            'templates'       => $templates,
            'pageTitle'       => 'Premium & Free Website Templates — ' . APP_NAME,
            'metaDescription' => 'Download responsive, SEO-ready HTML5, CSS3, and PHP website templates crafted by Ecotech Service for businesses, SaaS startups, and creative portfolios.',
            'metaKeywords'    => 'website templates, free HTML templates, SaaS landing page template, business website template, responsive web templates',
            'canonicalPath'   => 'templates',
        ]);
    }
}
