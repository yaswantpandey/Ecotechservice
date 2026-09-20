<?php
// ============================================================
// Ecotech Service — Search Controller (Google Sitelinks Searchbox)
// ============================================================

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class SearchController extends BaseController {

    public function index(): void {
        $rawQuery = $_GET['q'] ?? $_GET['query'] ?? $_GET['search'] ?? '';
        $query = trim(Security::sanitize($rawQuery));

        $servicesResults = [];
        $projectsResults = [];
        $templatesResults = [];
        $blogResults = [];
        $pagesResults = [];

        if (mb_strlen($query) >= 2) {
            $searchTerm = '%' . $query . '%';

            // 1. Services search
            try {
                $stmt = $this->db->prepare(
                    "SELECT id, title, slug, description, icon 
                     FROM services 
                     WHERE is_active = 1 AND (title LIKE ? OR description LIKE ?) 
                     ORDER BY sort_order ASC LIMIT 6"
                );
                $stmt->execute([$searchTerm, $searchTerm]);
                $servicesResults = $stmt->fetchAll();
            } catch (Throwable $e) {}

            // 2. Projects search
            try {
                $stmt = $this->db->prepare(
                    "SELECT id, title, slug, description, tech_stack, category, thumbnail, live_url 
                     FROM projects 
                     WHERE is_active = 1 AND (title LIKE ? OR description LIKE ? OR tech_stack LIKE ? OR category LIKE ?) 
                     ORDER BY sort_order ASC, id DESC LIMIT 6"
                );
                $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
                $projectsResults = $stmt->fetchAll();
            } catch (Throwable $e) {}

            // 3. Templates search
            try {
                $stmt = $this->db->prepare(
                    "SELECT id, title, slug, description, thumbnail, price, is_free 
                     FROM templates 
                     WHERE is_active = 1 AND (title LIKE ? OR description LIKE ?) 
                     ORDER BY id DESC LIMIT 6"
                );
                $stmt->execute([$searchTerm, $searchTerm]);
                $templatesResults = $stmt->fetchAll();
            } catch (Throwable $e) {}

            // 4. Blog search
            try {
                $stmt = $this->db->prepare(
                    "SELECT id, title, slug, excerpt, body, thumbnail, published_at 
                     FROM blog_posts 
                     WHERE is_published = 1 AND (title LIKE ? OR excerpt LIKE ? OR body LIKE ?) 
                     ORDER BY published_at DESC LIMIT 6"
                );
                $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
                $blogResults = $stmt->fetchAll();
            } catch (Throwable $e) {}

            // 5. Core pages matching
            $corePages = [
                ['title' => 'Technology Services', 'url' => url('services'), 'desc' => 'Explore custom web development, mobile apps, DevOps, and cybersecurity penetration testing.', 'keywords' => ['service', 'services', 'development', 'security', 'pentest', 'app', 'mobile', 'cloud', 'devops', 'ui', 'ux']],
                ['title' => 'Client Portfolio & Case Studies', 'url' => url('projects'), 'desc' => 'Browse real client websites, web platforms, and mobile apps delivered by Ecotech.', 'keywords' => ['project', 'projects', 'portfolio', 'work', 'case study', 'client', 'clients']],
                ['title' => 'Website Templates', 'url' => url('templates'), 'desc' => 'Download high-performance, responsive HTML5 and PHP website templates.', 'keywords' => ['template', 'templates', 'theme', 'themes', 'landing page', 'saas kit']],
                ['title' => 'About Ecotech Service', 'url' => url('about'), 'desc' => 'Learn about our engineering culture, cybersecurity focus, and company mission.', 'keywords' => ['about', 'company', 'team', 'who we are', 'mission', 'culture']],
                ['title' => 'Contact Us & Hire Developers', 'url' => url('contact'), 'desc' => 'Reach out to our team for custom quotes, consultation, and project kickoff.', 'keywords' => ['contact', 'hire', 'quote', 'email', 'phone', 'consultation', 'talk', 'touch']],
                ['title' => 'Tech Blog & Insights', 'url' => url('blog'), 'desc' => 'Read insights on web development, cybersecurity, design, and digital strategy.', 'keywords' => ['blog', 'article', 'articles', 'news', 'insights', 'tips']]
            ];

            $qLower = mb_strtolower($query);
            foreach ($corePages as $cp) {
                if (str_contains(mb_strtolower($cp['title']), $qLower) || str_contains(mb_strtolower($cp['desc']), $qLower)) {
                    $pagesResults[] = $cp;
                    continue;
                }
                foreach ($cp['keywords'] as $kw) {
                    if (str_contains($qLower, $kw) || str_contains($kw, $qLower)) {
                        $pagesResults[] = $cp;
                        break;
                    }
                }
            }
        }

        $totalCount = count($servicesResults) + count($projectsResults) + count($templatesResults) + count($blogResults) + count($pagesResults);

        // AJAX live autocomplete response
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' || isset($_GET['ajax'])) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'query' => $query,
                'total' => $totalCount,
                'services' => $servicesResults,
                'projects' => $projectsResults,
                'templates' => $templatesResults,
                'blog' => $blogResults,
                'pages' => $pagesResults
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            exit;
        }

        $pageTitle = $query 
            ? 'Search Results for "' . Security::e($query) . '" — ' . APP_NAME 
            : 'Search Services, Projects & Pages — ' . APP_NAME;

        $this->view('search', [
            'query'            => $query,
            'servicesResults'  => $servicesResults,
            'projectsResults'  => $projectsResults,
            'templatesResults' => $templatesResults,
            'blogResults'      => $blogResults,
            'pagesResults'     => $pagesResults,
            'totalCount'       => $totalCount,
            'pageTitle'        => $pageTitle,
            'metaDescription'  => 'Search across Ecotech Service solutions, web development services, client portfolio case studies, and articles.',
            'robotsMeta'       => 'noindex, follow',
            'canonicalPath'    => 'search' . ($query ? '?q=' . urlencode($query) : '')
        ]);
    }
}
