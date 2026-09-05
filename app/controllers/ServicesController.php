<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

class ServicesController extends BaseController {

    public function index(): void {
        // ── One-time seeder: Web Security & Penetration Testing ──────────
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
