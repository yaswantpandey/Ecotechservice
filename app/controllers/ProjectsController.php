<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

class ProjectsController extends BaseController {

    public function index(): void {
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
            'projects'        => $projects,
            'activeCategory'  => $category,
            'pageTitle'       => 'Portfolio & Client Case Studies — ' . APP_NAME,
            'metaDescription' => 'Explore our portfolio of web applications, e-commerce platforms, mobile apps, and digital campaigns built with modern tech stacks and responsive design.',
            'metaKeywords'    => 'web development portfolio, custom software projects, ecommerce case studies, mobile application portfolio, client work',
            'canonicalPath'   => 'projects' . ($category ? '?cat=' . urlencode($category) : ''),
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
            'project'         => $project,
            'images'          => $images,
            'pageTitle'       => $project['title'] . ' — Case Study | ' . APP_NAME,
            'metaDescription' => truncate(strip_tags($project['description']), 155, ''),
            'metaKeywords'    => $project['title'] . ', ' . $project['tech_stack'] . ', case study, web development, ' . APP_NAME,
            'canonicalPath'   => 'projects/view?slug=' . urlencode($project['slug']),
            'ogImage'         => !empty($project['thumbnail']) ? uploadUrl($project['thumbnail']) : null,
        ]);
    }
}
