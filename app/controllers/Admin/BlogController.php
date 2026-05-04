<?php
namespace Admin;

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class BlogController extends \BaseController {

    // ── List all posts ────────────────────────────────────────
    public function index(): void {
        requireAdmin();
        $posts = $this->db->query(
            "SELECT bp.*, u.name AS author_name
             FROM blog_posts bp
             JOIN users u ON u.id = bp.user_id
             ORDER BY bp.created_at DESC"
        )->fetchAll();

        $this->view('admin.blog.index', [
            'layout'    => 'admin',
            'pageTitle' => 'Blog Posts — Admin',
            'posts'     => $posts,
        ]);
    }

    // ── Show add form ─────────────────────────────────────────
    public function add(): void {
        requireAdmin();
        $this->view('admin.blog.form', [
            'layout'    => 'admin',
            'pageTitle' => 'Add Blog Post — Admin',
            'post'      => null,
        ]);
    }

    // ── Store new post ────────────────────────────────────────
    public function store(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(url('admin/blog'));
        $this->validateCsrf();

        $data  = $this->extractFormData();
        $thumb = $this->handleImageUpload('thumbnail', 'blog');

        $this->db->prepare(
            "INSERT INTO blog_posts (user_id, title, slug, excerpt, body, thumbnail, is_published, published_at, meta_title, meta_description, meta_keywords)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        )->execute([
            $_SESSION['admin_id'],
            $data['title'],
            $data['slug'],
            $data['excerpt'],
            $data['body'],
            $thumb,
            $data['is_published'],
            $data['published_at'],
            $data['meta_title'],
            $data['meta_description'],
            $data['meta_keywords'],
        ]);

        setFlash('success', 'Blog post created successfully.');
        redirect(url('admin/blog'));
    }

    // ── Show edit form ────────────────────────────────────────
    public function edit(): void {
        requireAdmin();
        $id   = (int)($_GET['id'] ?? 0);
        $post = $this->findPost($id);
        $this->view('admin.blog.form', [
            'layout'    => 'admin',
            'pageTitle' => 'Edit Post — Admin',
            'post'      => $post,
        ]);
    }

    // ── Update post ───────────────────────────────────────────
    public function update(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(url('admin/blog'));
        $this->validateCsrf();

        $id    = (int)($_POST['id'] ?? 0);
        $post  = $this->findPost($id);
        $data  = $this->extractFormData();
        $thumb = $this->handleImageUpload('thumbnail', 'blog') ?? $post['thumbnail'];

        $this->db->prepare(
            "UPDATE blog_posts
             SET title=?, slug=?, excerpt=?, body=?, thumbnail=?, is_published=?, published_at=?, meta_title=?, meta_description=?, meta_keywords=?
             WHERE id=?"
        )->execute([
            $data['title'],
            $data['slug'],
            $data['excerpt'],
            $data['body'],
            $thumb,
            $data['is_published'],
            $data['published_at'],
            $data['meta_title'],
            $data['meta_description'],
            $data['meta_keywords'],
            $id,
        ]);

        setFlash('success', 'Blog post updated successfully.');
        redirect(url('admin/blog'));
    }

    // ── Delete post ───────────────────────────────────────────
    public function delete(): void {
        requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        $this->db->prepare("DELETE FROM blog_posts WHERE id = ?")->execute([$id]);
        setFlash('success', 'Blog post deleted.');
        redirect(url('admin/blog'));
    }

    // ── Private helpers ───────────────────────────────────────

    private function findPost(int $id): array {
        $stmt = $this->db->prepare("SELECT * FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) {
            setFlash('error', 'Post not found.');
            redirect(url('admin/blog'));
        }
        return $row;
    }

    private function extractFormData(): array {
        $s = fn($k) => \Security::sanitize($_POST[$k] ?? '');
        $isPublished = isset($_POST['is_published']) ? 1 : 0;
        $publishedAt = $isPublished
            ? (trim($_POST['published_at'] ?? '') ?: date('Y-m-d H:i:s'))
            : null;

        return [
            'title'            => $s('title'),
            'slug'             => slugify($s('title')),
            'excerpt'          => $s('excerpt'),
            'body'             => trim($_POST['body'] ?? ''),   // Allow HTML from editor
            'is_published'     => $isPublished,
            'published_at'     => $publishedAt,
            'meta_title'       => $s('meta_title'),
            'meta_description' => $s('meta_description'),
            'meta_keywords'    => $s('meta_keywords'),
        ];
    }

    private function handleImageUpload(string $field, string $subDir): ?string {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            try {
                return \Security::uploadImage($_FILES[$field], $subDir);
            } catch (\RuntimeException $e) {
                setFlash('warning', 'Image upload skipped: ' . $e->getMessage());
            }
        }
        return null;
    }
}
