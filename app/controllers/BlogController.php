<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

class BlogController extends BaseController {

    public function index(): void {
        $stmt = $this->db->query(
            "SELECT bp.*, u.name AS author_name
             FROM blog_posts bp
             JOIN users u ON u.id = bp.user_id
             WHERE bp.is_published = 1
             ORDER BY bp.published_at DESC"
        );
        $posts = $stmt->fetchAll();

        $this->view('blog', [
            'pageTitle' => 'Blog - ' . APP_NAME,
            'metaDescription' => 'Read Ecotech Service insights on web development, digital marketing, eco-technology, business growth, and sustainable digital strategy.',
            'canonicalPath' => 'blog',
            'posts' => $posts,
        ]);
    }

    public function post(): void {
        $slug = Security::sanitize($_GET['slug'] ?? '');
        if (!$slug) {
            redirect(url('blog'));
        }

        $stmt = $this->db->prepare(
            "SELECT bp.*, u.name AS author_name
             FROM blog_posts bp
             JOIN users u ON u.id = bp.user_id
             WHERE bp.slug = ? AND bp.is_published = 1
             LIMIT 1"
        );
        $stmt->execute([$slug]);
        $post = $stmt->fetch();

        if (!$post) {
            http_response_code(404);
            require_once ROOT_PATH . '/app/views/errors/404.php';
            return;
        }

        $pageTitle = !empty($post['meta_title']) ? $post['meta_title'] : $post['title'] . ' - ' . APP_NAME;
        $metaDescription = !empty($post['meta_description'])
            ? $post['meta_description']
            : truncate(strip_tags($post['excerpt'] ?: $post['body']), 155, '');

        $this->view('blog_post', [
            'pageTitle' => $pageTitle,
            'metaDescription' => $metaDescription ?: setting('meta_description'),
            'metaKeywords' => !empty($post['meta_keywords']) ? $post['meta_keywords'] : null,
            'ogImage' => !empty($post['thumbnail']) ? uploadUrl($post['thumbnail']) : null,
            'ogType' => 'article',
            'canonicalPath' => 'blog/post?slug=' . urlencode($post['slug']),
            'post' => $post,
        ]);
    }
}
