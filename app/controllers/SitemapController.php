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
        $xml[] = '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"';
        $xml[] = '        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
        $xml[] = '        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

        $now = date('Y-m-d');

        // Dynamic blog priority depending on whether articles exist
        $blogPriority = '0.5';
        $blogFreq = 'monthly';
        try {
            $hasPosts = (int)$this->db->query("SELECT COUNT(*) FROM blog_posts WHERE is_published = 1")->fetchColumn();
            if ($hasPosts > 0) {
                $blogPriority = '0.8';
                $blogFreq = 'daily';
            }
        } catch (Throwable $e) {}

        // 1. Core Pages
        $corePages = [
            ['path' => '',          'priority' => '1.0', 'changefreq' => 'weekly'],
            ['path' => 'services',   'priority' => '0.9', 'changefreq' => 'weekly'],
            ['path' => 'projects',   'priority' => '0.9', 'changefreq' => 'weekly'],
            ['path' => 'about',      'priority' => '0.8', 'changefreq' => 'monthly'],
            ['path' => 'templates',  'priority' => '0.8', 'changefreq' => 'weekly'],
            ['path' => 'blog',       'priority' => $blogPriority, 'changefreq' => $blogFreq],
            ['path' => 'contact',    'priority' => '0.8', 'changefreq' => 'monthly'],
            ['path' => 'events',     'priority' => '0.8', 'changefreq' => 'weekly'],
            ['path' => 'events/promptwars-x-sudarshan', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['path' => 'events/hack2skill-x-sudarshan', 'priority' => '0.8', 'changefreq' => 'weekly'],
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

        // 2. Active Projects (with image entries for Google image search)
        try {
            $stmt = $this->db->prepare("SELECT slug, title, thumbnail, updated_at, created_at FROM projects WHERE is_active = 1 ORDER BY is_featured DESC, sort_order ASC, id DESC");
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
                // Image entry for Google Images index (own thumbnail only)
                if (!empty($project['thumbnail'])) {
                    $imgLoc = htmlspecialchars(uploadUrl($project['thumbnail']), ENT_XML1, 'UTF-8');
                    $imgTitle = htmlspecialchars($project['title'], ENT_XML1, 'UTF-8');
                    $xml[] = '    <image:image>';
                    $xml[] = '      <image:loc>' . $imgLoc . '</image:loc>';
                    $xml[] = '      <image:title>' . $imgTitle . '</image:title>';
                    $xml[] = '    </image:image>';
                }
                $xml[] = '  </url>';
            }
        } catch (Throwable $e) {
            // Silently continue if table error occurs
        }

        // 3. Published Blog Posts (with image entries)
        try {
            $stmt = $this->db->prepare("SELECT slug, title, thumbnail, updated_at, published_at, created_at FROM blog_posts WHERE is_published = 1 ORDER BY published_at DESC");
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
                if (!empty($post['thumbnail'])) {
                    $imgLoc = htmlspecialchars(uploadUrl($post['thumbnail']), ENT_XML1, 'UTF-8');
                    $imgTitle = htmlspecialchars($post['title'], ENT_XML1, 'UTF-8');
                    $xml[] = '    <image:image>';
                    $xml[] = '      <image:loc>' . $imgLoc . '</image:loc>';
                    $xml[] = '      <image:title>' . $imgTitle . '</image:title>';
                    $xml[] = '    </image:image>';
                }
                $xml[] = '  </url>';
            }
        } catch (Throwable $e) {
            // Silently continue
        }

        // 4. Programmatic SEO Landing Pages
        try {
            $stmt = $this->db->prepare("SELECT slug, created_at FROM seo_pages ORDER BY id ASC");
            $stmt->execute();
            $seoPages = $stmt->fetchAll();

            foreach ($seoPages as $sp) {
                $lastmod = !empty($sp['created_at']) ? date('Y-m-d', strtotime($sp['created_at'])) : $now;
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

        // Cache file to disk for static fallbacks only in production
        if (APP_ENV === 'production') {
            @file_put_contents(PUBLIC_PATH . '/sitemap.xml', $content);
        }

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
        $robots[] = "# AI Search Engines";
        $robots[] = "User-agent: GPTBot";
        $robots[] = "Allow: /";
        $robots[] = "";
        $robots[] = "User-agent: PerplexityBot";
        $robots[] = "Allow: /";
        $robots[] = "";
        $robots[] = "User-agent: ClaudeBot";
        $robots[] = "Allow: /";
        $robots[] = "";
        $robots[] = "User-agent: Applebot-Extended";
        $robots[] = "Allow: /";
        $robots[] = "";
        $robots[] = "# Sitemap";
        $robots[] = "Sitemap: {$sitemapUrl}";
        $robots[] = "";

        $content = implode("\n", $robots);

        // Cache file to disk only in production
        if (APP_ENV === 'production') {
            @file_put_contents(PUBLIC_PATH . '/robots.txt', $content);
        }

        echo $content;
        exit;
    }

    /**
     * Machine-readable LLM context (/llms.txt) for AI search engines & agents
     */
    public function llms(): void {
        header('Content-Type: text/plain; charset=utf-8');

        $candidates = [
            PUBLIC_PATH . '/llms.txt',
            ROOT_PATH . '/public/llms.txt',
            ROOT_PATH . '/llms.txt',
            __DIR__ . '/../../public/llms.txt',
            __DIR__ . '/../../../public/llms.txt',
        ];

        foreach ($candidates as $candidate) {
            if (file_exists($candidate)) {
                readfile($candidate);
                exit;
            }
        }

        // Complete embedded fallback
        echo <<<EOT
# Ecotech Services

> Software that stays fast. Ecotech Services provides full-stack web application development, cross-platform mobile apps, cloud architecture, cybersecurity auditing, and managed digital solutions for startups and enterprises worldwide.

## Company Information
- **Company Name:** Ecotech Services
- **Headquarters:** Lucknow, Uttar Pradesh, India - 226001
- **Technical Director:** Yaswant Kumar
- **Contact Email:** ecotech.servic@gmail.com
- **Phone / WhatsApp:** +91 7398301184
- **Official Website:** https://ecotechservices.tech

## Core Services
- [Custom Web App Development](https://ecotechservices.tech/services#web-development): Scalable enterprise platforms, client portals, and internal dashboards built on modern stacks (PHP 8, React, Node.js, Python).
- [Web Security & Penetration Testing](https://ecotechservices.tech/services#web-security-penetration-testing): OWASP code reviews, ethical vulnerability assessments, and penetration testing for web and mobile systems.
- [Mobile App Development](https://ecotechservices.tech/services#mobile-app-development): Unified cross-platform builds for iOS and Android using React Native and Flutter.
- [Cloud & DevOps Engineering](https://ecotechservices.tech/services#cloud-devops): CI/CD pipeline automation, Docker container orchestration, AWS/GCP deployments, and 24x7 monitoring.
- [UI/UX Design Systems](https://ecotechservices.tech/services#ui-ux-design): Accessible, high-contrast, modern UI/UX design systems and interactive wireframes.
- [Digital Marketing & SEO](https://ecotechservices.tech/services#digital-marketing): Data-driven technical SEO, Generative Engine Optimization (GEO), and conversion rate optimization.

## Work & Delivered Portfolio
- [Pandey Reality](https://pandeyreality.com): Real estate portal featuring luxury property listings in Mumbai with MahaRERA verification.
- [Apna Cleaning](https://apnacleanig.in): High-speed booking application for residential and commercial cleaning services.
- [Kranti Furnitures & Electronics](https://krantifurniture.in): Modern e-commerce showroom for home appliances and furniture in Prayagraj.
- [Yaswant.co.in](https://yaswant.co.in): Developer ecosystem and portfolio with 26+ browser-based utilities.

## Technology Stack
- **Backend:** PHP 8+, Python, Node.js, REST APIs, MySQL, PostgreSQL
- **Frontend:** Vanilla CSS, Tailwind CSS, Modern JavaScript, React
- **DevOps & Security:** Linux, Apache, Nginx, Docker, Git CI/CD, OWASP Security Standards

## Career & Internship Tracks
Ecotech Services runs structured, mentor-reviewed internship programs across 11 disciplines: Full Stack, Frontend, Backend, Python, Java, Mobile Apps, UI/UX, Cybersecurity, IoT, AI/ML, and Data Science.
- [Apply for Internships](https://ecotechservices.tech/internships)

EOT;
        exit;
    }
}
