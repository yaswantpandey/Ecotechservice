<?php
// ============================================================
// Ecotech Service — Front Controller (index.php)
// All public requests routed through here.
// ============================================================

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/helpers/Security.php';
require_once __DIR__ . '/../app/helpers/Helpers.php';

// ── HTML minification in production ─────────────────────────────
// Collapses whitespace and strips comments to reduce transfer size
// without touching <pre>, <textarea>, <script>, <style> content.
if (defined('APP_ENV') && APP_ENV !== 'development') {
    ob_start(static function (string $buffer): string {
        if ($buffer === '' || strncasecmp($buffer, '<?xml', 5) === 0) {
            return $buffer; // don't touch XML sitemaps / non-HTML output
        }

        // Protect blocks that must preserve their whitespace/formatting.
        $saved = [];
        $buffer = preg_replace_callback(
            '#<(pre|textarea|script|style|code)\b[^>]*>.*?</\1>#is',
            static function (array $m) use (&$saved): string {
                $key = "\x00P" . count($saved) . "\x00";
                $saved[$key] = $m[0];
                return $key;
            },
            $buffer
        );

        // Strip HTML comments (the site uses no IE conditionals).
        $buffer = preg_replace('#<!--.*?-->#s', '', $buffer);

        // Collapse whitespace runs to a single space.
        $buffer = preg_replace('#[ \t]+#', ' ', $buffer);
        $buffer = preg_replace('#\s*\n\s*#', "\n", $buffer);
        $buffer = preg_replace('#\n{2,}#', "\n", $buffer);

        // Tidy inter-tag spacing.
        $buffer = preg_replace('#>\s+#', '> ', $buffer);
        $buffer = preg_replace('#\s+<#', ' <', $buffer);

        // Restore protected blocks.
        $buffer = strtr($buffer, $saved);

        return trim($buffer);
    });
}

// ── Simple Router ─────────────────────────────────────────────
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '', '/');

// Strip the project sub-folder prefix if running under XAMPP / WAMP
$base = trim(parse_url(APP_URL, PHP_URL_PATH) ?? '', '/');
if ($base && str_starts_with(strtolower($uri), strtolower($base))) {
    $uri = trim(substr($uri, strlen($base)), '/');
}

// Also strip base folder name (e.g. Ecotechservice/public or Ecotechservice) if accessed directly
$scriptDir = trim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
if ($scriptDir && $scriptDir !== '.' && str_starts_with(strtolower($uri), strtolower($scriptDir))) {
    $uri = trim(substr($uri, strlen($scriptDir)), '/');
}
$parentDir = trim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME'] ?? ''))), '/');
if ($parentDir && $parentDir !== '.' && str_starts_with(strtolower($uri), strtolower($parentDir))) {
    $uri = trim(substr($uri, strlen($parentDir)), '/');
}

// The hosting document root contains the project wrapper, so root requests
// are internally rewritten to /public/. Do not treat that wrapper as a route.
if (strtolower($uri) === 'public' || str_starts_with(strtolower($uri), 'public/')) {
    $uri = trim(substr($uri, strlen('public')), '/');
}

// Route map  [uri_pattern => [controller, method]]
$routes = [
    ''                  => ['HomeController',        'index'],
    'about'             => ['AboutController',       'index'],
    'services'          => ['ServicesController',    'index'],
    'projects'          => ['ProjectsController',    'index'],
    'projects/view'     => ['ProjectsController',    'showDetail'],
    'templates'         => ['TemplatesController',   'index'],
    'contact'           => ['ContactController',     'index'],
    'contact/send'      => ['ContactController',     'send'],
    'blog'              => ['BlogController',         'index'],
    'blog/post'         => ['BlogController',         'post'],
    'search'            => ['SearchController',       'index'],
    'privacy'           => ['LegalController',        'privacy'],
    'terms'             => ['LegalController',        'terms'],
    'sitemap.xml'       => ['SitemapController',      'index'],
    'robots.txt'        => ['SitemapController',      'robots'],
    // Internship Portal (public)
    'internships'               => ['InternshipsController',    'index'],
    'internships/track'         => ['InternshipsController',    'show'],
    'internships/apply'         => ['InternshipsController',    'apply'],
    'internships/apply/store'   => ['InternshipsController',    'store'],
    'internships/register'      => ['InternAuthController',     'register'],
    'internships/register/post' => ['InternAuthController',     'doRegister'],
    'internships/login'         => ['InternAuthController',     'login'],
    'internships/login/post'    => ['InternAuthController',     'doLogin'],
    'internships/logout'        => ['InternAuthController',     'logout'],
    // Internship Portal (intern dashboard)
    'internships/dashboard'              => ['InternDashboardController', 'index'],
    'internships/dashboard/application'  => ['InternDashboardController', 'application'],
    'internships/dashboard/withdraw'     => ['InternDashboardController', 'withdraw'],
    'internships/dashboard/resume'       => ['InternDashboardController', 'resume'],
    'internships/dashboard/offer-letter' => ['InternDashboardController', 'offerLetter'],
    // Admin
    'admin'             => ['Admin\AuthController',  'login'],
    'admin/login'       => ['Admin\AuthController',  'login'],
    'admin/login/post'  => ['Admin\AuthController',  'doLogin'],
    'admin/logout'      => ['Admin\AuthController',  'logout'],
    'admin/dashboard'   => ['Admin\DashboardController','index'],
    'admin/projects'    => ['Admin\ProjectsController','index'],
    'admin/projects/add'    => ['Admin\ProjectsController','add'],
    'admin/projects/store'  => ['Admin\ProjectsController','store'],
    'admin/projects/edit'   => ['Admin\ProjectsController','edit'],
    'admin/projects/update' => ['Admin\ProjectsController','update'],
    'admin/projects/delete' => ['Admin\ProjectsController','delete'],
    'admin/services'    => ['Admin\ServicesController','index'],
    'admin/services/add'    => ['Admin\ServicesController','add'],
    'admin/services/store'  => ['Admin\ServicesController','store'],
    'admin/services/edit'   => ['Admin\ServicesController','edit'],
    'admin/services/update' => ['Admin\ServicesController','update'],
    'admin/services/delete' => ['Admin\ServicesController','delete'],
    'admin/testimonials'    => ['Admin\TestimonialsController','index'],
    'admin/testimonials/add'    => ['Admin\TestimonialsController','add'],
    'admin/testimonials/store'  => ['Admin\TestimonialsController','store'],
    'admin/testimonials/edit'   => ['Admin\TestimonialsController','edit'],
    'admin/testimonials/update' => ['Admin\TestimonialsController','update'],
    'admin/testimonials/delete' => ['Admin\TestimonialsController','delete'],
    'admin/contacts'    => ['Admin\ContactsController','index'],
    'admin/contacts/view'   => ['Admin\ContactsController','show'],
    'admin/contacts/reply'  => ['Admin\ContactsController','reply'],
    'admin/contacts/delete' => ['Admin\ContactsController','delete'],
    'admin/settings'    => ['Admin\SettingsController','index'],
    'admin/settings/update' => ['Admin\SettingsController','update'],
    'admin/database'        => ['Admin\DatabaseController','index'],
    'admin/database/repair' => ['Admin\DatabaseController','repair'],
    // Admin Blog
    'admin/blog'            => ['Admin\BlogController','index'],
    'admin/blog/add'        => ['Admin\BlogController','add'],
    'admin/blog/store'      => ['Admin\BlogController','store'],
    'admin/blog/edit'       => ['Admin\BlogController','edit'],
    'admin/blog/update'     => ['Admin\BlogController','update'],
    'admin/blog/delete'     => ['Admin\BlogController','delete'],
    // Admin Internships
    'admin/applications'        => ['Admin\ApplicationsController','index'],
    'admin/applications/view'   => ['Admin\ApplicationsController','show'],
    'admin/applications/status' => ['Admin\ApplicationsController','updateStatus'],
    'admin/applications/resume' => ['Admin\ApplicationsController','resume'],
    'admin/applications/offer'  => ['Admin\ApplicationsController','offerLetter'],
    'admin/applications/export' => ['Admin\ApplicationsController','export'],
    'admin/applications/delete' => ['Admin\ApplicationsController','delete'],
    'admin/interns'         => ['Admin\InternsController','index'],
    'admin/interns/toggle'  => ['Admin\InternsController','toggle'],
    'admin/tracks'          => ['Admin\TracksController','index'],
    'admin/tracks/add'      => ['Admin\TracksController','add'],
    'admin/tracks/store'    => ['Admin\TracksController','store'],
    'admin/tracks/edit'     => ['Admin\TracksController','edit'],
    'admin/tracks/update'   => ['Admin\TracksController','update'],
    'admin/tracks/delete'   => ['Admin\TracksController','delete'],
];

// Autoloader for controllers
spl_autoload_register(function (string $class): void {
    // Convert namespace separator to directory separator
    $file = ROOT_PATH . '/app/controllers/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Dispatch
try {
    if (isset($routes[$uri])) {
        [$controllerClass, $method] = $routes[$uri];
        $controller = new $controllerClass();
        $controller->$method();
    } elseif (str_starts_with($uri, 'services/') && str_contains($uri, '-in-')) {
        // Programmatic SEO Route Fallback
        $controller = new SeoController();
        $controller->show($uri);
    } else {
        // 404
        http_response_code(404);
        require_once ROOT_PATH . '/app/views/errors/404.php';
    }
} catch (Throwable $e) {
    error_log(sprintf('[%s] %s in %s:%d', get_class($e), $e->getMessage(), $e->getFile(), $e->getLine()));
    http_response_code(500);

    if (defined('APP_ENV') && APP_ENV === 'development') {
        echo '<h1>500 - Application Error</h1>';
        echo '<p><strong>' . htmlspecialchars($e->getMessage()) . '</strong></p>';
        echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    } else {
        $isDatabaseError = ($e instanceof PDOException);
        $error500 = ROOT_PATH . '/app/views/errors/500.php';
        if (file_exists($error500)) {
            require $error500;
        } else {
            echo '<h1>500 - Internal Server Error</h1>';
            echo '<p>Temporary system maintenance. Please try again shortly.</p>';
        }
    }
}
