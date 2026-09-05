<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

class ProjectsController extends BaseController {

    public function index(): void {
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

        $category = Security::sanitize($_GET['cat'] ?? '');
        $allowed  = ['website','marketing','template','mobile','other'];

        $sql = "SELECT * FROM projects WHERE is_active = 1";
        $params = [];

        if ($category && in_array($category, $allowed, true)) {
            $sql    .= " AND category = ?";
            $params[] = $category;
        }
        $sql .= " ORDER BY sort_order ASC, created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $projects = $stmt->fetchAll();

        $this->view('projects', [
            'projects' => $projects,
            'activeCategory' => $category,
            'pageTitle' => 'Portfolio - ' . APP_NAME,
            'metaDescription' => 'Browse Ecotech Service portfolio projects across websites, apps, templates, marketing campaigns, and sustainable digital products.',
            'canonicalPath' => 'projects' . ($category ? '?cat=' . urlencode($category) : ''),
        ]);
    }

    public function showDetail(): void {
        $slug = Security::sanitize($_GET['slug'] ?? '');
        if (!$slug) {
            redirect(url('projects'));
        }

        $stmt = $this->db->prepare(
            "SELECT * FROM projects WHERE slug = ? AND is_active = 1"
        );
        $stmt->execute([$slug]);
        $project = $stmt->fetch();

        if (!$project) {
            http_response_code(404);
            require_once ROOT_PATH . '/app/views/errors/404.php';
            return;
        }

        $imgStmt = $this->db->prepare(
            "SELECT * FROM project_images WHERE project_id = ? ORDER BY sort_order ASC"
        );
        $imgStmt->execute([$project['id']]);
        $images = $imgStmt->fetchAll();

        $this->view('project_detail', [
            'project' => $project,
            'images' => $images,
            'pageTitle' => $project['title'] . ' - ' . APP_NAME,
            'metaDescription' => truncate(strip_tags($project['description']), 155, ''),
            'canonicalPath' => 'projects/view?slug=' . urlencode($project['slug']),
            'ogImage' => !empty($project['thumbnail']) ? uploadUrl($project['thumbnail']) : null,
        ]);
    }
}
