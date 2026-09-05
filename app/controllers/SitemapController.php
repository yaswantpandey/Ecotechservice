<?php
// ============================================================
// Ecotech Service — Dynamic XML Sitemap & Robots Controller
// ============================================================

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class SitemapController extends BaseController {

    /**
     * Generate dynamic XML sitemap
     */
    public function index(): void {
        header('Content-Type: application/xml; charset=utf-8');
        header('X-Robots-Tag: noindex, follow');

        $xml = [];
        $xml[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
        $xml[] = '        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
        $xml[] = '        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

        $now = date('Y-m-d');

        // 1. Core Pages
        $corePages = [
            ['path' => '',          'priority' => '1.0', 'changefreq' => 'weekly'],
            ['path' => 'services',   'priority' => '0.9', 'changefreq' => 'weekly'],
            ['path' => 'projects',   'priority' => '0.9', 'changefreq' => 'weekly'],
            ['path' => 'about',      'priority' => '0.8', 'changefreq' => 'monthly'],
            ['path' => 'templates',  'priority' => '0.8', 'changefreq' => 'weekly'],
            ['path' => 'blog',       'priority' => '0.8', 'changefreq' => 'daily'],
            ['path' => 'contact',    'priority' => '0.8', 'changefreq' => 'monthly'],
        ];

        foreach ($corePages as $page) {
            $loc = htmlspecialchars(url($page['path']), ENT_XML1, 'UTF-8');
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . $loc . '</loc>';
            $xml[] = '    <lastmod>' . $now . '</lastmod>';
            $xml[] = '    <changefreq>' . $page['changefreq'] . '</changefreq>';
            $xml[] = '    <priority>' . $page['priority'] . '</priority>';
            $xml[] = '  </url>';
        }

        // 2. Active Projects
        try {
            $stmt = $this->db->prepare("SELECT slug, updated_at, created_at FROM projects WHERE is_active = 1 ORDER BY is_featured DESC, sort_order ASC, id DESC");
            $stmt->execute();
            $projects = $stmt->fetchAll();

            foreach ($projects as $project) {
                $lastmod = !empty($project['updated_at']) ? date('Y-m-d', strtotime($project['updated_at'])) : (!empty($project['created_at']) ? date('Y-m-d', strtotime($project['created_at'])) : $now);
                $loc = htmlspecialchars(url('projects/view?slug=' . urlencode($project['slug'])), ENT_XML1, 'UTF-8');
                $xml[] = '  <url>';
                $xml[] = '    <loc>' . $loc . '</loc>';
                $xml[] = '    <lastmod>' . $lastmod . '</lastmod>';
                $xml[] = '    <changefreq>weekly</changefreq>';
                $xml[] = '    <priority>0.8</priority>';
                $xml[] = '  </url>';
            }
        } catch (Throwable $e) {
            // Silently continue if table error occurs
        }

        // 3. Published Blog Posts
        try {
            $stmt = $this->db->prepare("SELECT slug, updated_at, published_at, created_at FROM blog_posts WHERE is_published = 1 ORDER BY published_at DESC");
            $stmt->execute();
            $posts = $stmt->fetchAll();

            foreach ($posts as $post) {
                $lastmod = !empty($post['updated_at']) ? date('Y-m-d', strtotime($post['updated_at'])) : (!empty($post['published_at']) ? date('Y-m-d', strtotime($post['published_at'])) : $now);
                $loc = htmlspecialchars(url('blog/post?slug=' . urlencode($post['slug'])), ENT_XML1, 'UTF-8');
                $xml[] = '  <url>';
                $xml[] = '    <loc>' . $loc . '</loc>';
                $xml[] = '    <lastmod>' . $lastmod . '</lastmod>';
                $xml[] = '    <changefreq>monthly</changefreq>';
                $xml[] = '    <priority>0.8</priority>';
                $xml[] = '  </url>';
            }
        } catch (Throwable $e) {
            // Silently continue
        }

        // 4. Programmatic SEO Landing Pages
        try {
            $stmt = $this->db->prepare("SELECT slug, updated_at FROM seo_pages ORDER BY id ASC");
            $stmt->execute();
            $seoPages = $stmt->fetchAll();

            foreach ($seoPages as $sp) {
                $lastmod = !empty($sp['updated_at']) ? date('Y-m-d', strtotime($sp['updated_at'])) : $now;
                $loc = htmlspecialchars(url($sp['slug']), ENT_XML1, 'UTF-8');
                $xml[] = '  <url>';
                $xml[] = '    <loc>' . $loc . '</loc>';
                $xml[] = '    <lastmod>' . $lastmod . '</lastmod>';
                $xml[] = '    <changefreq>monthly</changefreq>';
                $xml[] = '    <priority>0.7</priority>';
                $xml[] = '  </url>';
            }
        } catch (Throwable $e) {
            // Silently continue
        }

        $xml[] = '</urlset>';
        $content = implode("\n", $xml);

        // Cache file to disk for static fallbacks if writable
        @file_put_contents(PUBLIC_PATH . '/sitemap.xml', $content);

        echo $content;
        exit;
    }

    /**
     * Dynamic robots.txt handler
     */
    public function robots(): void {
        header('Content-Type: text/plain; charset=utf-8');

        $sitemapUrl = url('sitemap.xml');

        $robots = [];
        $robots[] = "User-agent: *";
        $robots[] = "Allow: /";
        $robots[] = "Allow: /assets/";
        $robots[] = "Allow: /uploads/";
        $robots[] = "Disallow: /admin/";
        $robots[] = "Disallow: /config/";
        $robots[] = "Disallow: /app/";
        $robots[] = "Disallow: /logs/";
        $robots[] = "Disallow: /vendor/";
        $robots[] = "Disallow: /*?*cat=*";
        $robots[] = "Disallow: /*?*page=*";
        $robots[] = "";
        $robots[] = "# Sitemap";
        $robots[] = "Sitemap: {$sitemapUrl}";
        $robots[] = "";

        $content = implode("\n", $robots);

        // Cache file to disk
        @file_put_contents(PUBLIC_PATH . '/robots.txt', $content);

        echo $content;
        exit;
    }
}
