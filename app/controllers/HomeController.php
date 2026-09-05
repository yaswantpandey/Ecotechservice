<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

class HomeController extends BaseController {

    public function index(): void {
        // ── Auto-sync project images to uploads & database ─────────────
        $artifactDir = 'C:/Users/lucifer/.gemini/antigravity-ide/brain/0a6e346e-ec38-43b3-8db5-621b191be737';
        $uploadsDir  = PUBLIC_PATH . '/uploads';

        $imgMappings = [
            'project_pandey_reality.jpg'   => $artifactDir . '/pandey_reality_ui_1788530587455.jpg',
            'project_apna_cleaning.jpg'    => $artifactDir . '/apna_cleaning_ui_1788530616616.jpg',
            'project_kranti_furniture.jpg' => $artifactDir . '/kranti_furniture_ui_1788530647804.jpg',
        ];

        foreach ($imgMappings as $dest => $src) {
            if (file_exists($src) && !file_exists($uploadsDir . '/' . $dest)) {
                @copy($src, $uploadsDir . '/' . $dest);
            }
        }

        $dbThumbnails = [
            'pandey-reality'      => 'project_pandey_reality.jpg',
            'apna-cleaning'       => 'project_apna_cleaning.jpg',
            'kranti-furniture'    => 'project_kranti_furniture.jpg',
            'yaswant-portfolio'   => 'project_startup_landing.png',
            'ecotech-ai'          => 'project_solarmetrics.png',
            'ecotech-engineering' => 'project_greentrack.png',
        ];

        foreach ($dbThumbnails as $slug => $thumb) {
            $up = $this->db->prepare("UPDATE projects SET thumbnail = :thumb WHERE slug = :slug AND (thumbnail IS NULL OR thumbnail = '' OR thumbnail NOT LIKE 'project_%')");
            $up->execute([':thumb' => $thumb, ':slug' => $slug]);
        }

        // Top Featured projects for home page marquee
        $stmt = $this->db->prepare(
            "SELECT * FROM projects WHERE is_active = 1 ORDER BY is_featured DESC, sort_order ASC, id DESC LIMIT 10"
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
