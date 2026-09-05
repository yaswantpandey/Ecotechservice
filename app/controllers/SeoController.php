<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

class SeoController extends BaseController {
    public function show(string $slug): void {
        $stmt = $this->db->prepare("SELECT * FROM seo_pages WHERE slug = ? LIMIT 1");
        $stmt->execute([$slug]);
        $page = $stmt->fetch();

        if (!$page) {
            http_response_code(404);
            require_once ROOT_PATH . '/app/views/errors/404.php';
            return;
        }

        $this->view('seo_landing', [
            'pageTitle'       => Security::e($page['meta_title']),
            'metaDescription' => Security::e($page['meta_description']),
            'metaKeywords'    => Security::e($page['target_keyword']),
            'canonicalPath'   => $slug,
            'page'            => $page
        ]);
    }
}
