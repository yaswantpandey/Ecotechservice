<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

class HomeController extends BaseController {

    public function index(): void {

        // ── One-time service seeder: Web Security & Penetration Testing ───
        $check = $this->db->prepare("SELECT id FROM services WHERE slug = 'web-security-penetration-testing' LIMIT 1");
        $check->execute();
        if (!$check->fetch()) {
            $ins = $this->db->prepare("
                INSERT INTO services (title, slug, description, icon, sort_order, is_active)
                VALUES (:title, :slug, :desc, :icon, :sort, 1)
            ");
            $ins->execute([
                ':title' => 'Web Security & Penetration Testing',
                ':slug'  => 'web-security-penetration-testing',
                ':desc'  => 'Comprehensive security audits, vulnerability assessments, and ethical penetration testing for websites and applications. We identify OWASP Top 10 risks, SQL injection, XSS, broken auth, and provide detailed remediation reports with CVE scoring.',
                ':icon'  => 'fa-shield-halved',
                ':sort'  => 7,
            ]);
        }
        // ─────────────────────────────────────────────────────────────────

        // Top Featured projects for home page marquee
        $stmt = $this->db->prepare(
            "SELECT * FROM projects WHERE is_active = 1 ORDER BY is_featured DESC, sort_order ASC, id DESC LIMIT 10"
        );
        $stmt->execute();
        $featuredProjects = $stmt->fetchAll();

        // Services preview
        $stmt = $this->db->prepare(
            "SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 7"
        );
        $stmt->execute();
        $services = $stmt->fetchAll();

        // Testimonials preview
        $stmt = $this->db->prepare(
            "SELECT * FROM testimonials WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 4"
        );
        $stmt->execute();
        $testimonials = $stmt->fetchAll();

        // Featured templates preview
        $stmt = $this->db->prepare(
            "SELECT * FROM templates WHERE is_active = 1 ORDER BY created_at DESC LIMIT 3"
        );
        $stmt->execute();
        $templates = $stmt->fetchAll();

        $this->view('home', [
            'featuredProjects' => $featuredProjects,
            'services'         => $services,
            'testimonials'     => $testimonials,
            'templates'        => $templates,
            'pageTitle'        => APP_NAME . ' | Web Development, Digital Marketing & Eco-Tech Solutions',
            'metaDescription'  => 'Ecotech Service builds websites, web apps, digital marketing campaigns, and eco-technology solutions that help modern businesses grow sustainably.',
            'canonicalPath'    => '',
        ]);
    }
}
