<?php
// ============================================================
// Ecotech Service — Front Controller (index.php)
// All public requests routed through here.
// ============================================================

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/helpers/Security.php';
require_once __DIR__ . '/../app/helpers/Helpers.php';

// ── Simple Router ─────────────────────────────────────────────
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Strip the project sub-folder prefix if running under XAMPP
$base = trim(parse_url(APP_URL, PHP_URL_PATH) ?? '', '/');
if ($base && str_starts_with($uri, $base)) {
    $uri = trim(substr($uri, strlen($base)), '/');
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
    'sitemap.xml'       => ['SitemapController',      'index'],
    'robots.txt'        => ['SitemapController',      'robots'],
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
    'admin/contacts/delete' => ['Admin\ContactsController','delete'],
    'admin/settings'    => ['Admin\SettingsController','index'],
    'admin/settings/update' => ['Admin\SettingsController','update'],
    // Admin Blog
    'admin/blog'            => ['Admin\BlogController','index'],
    'admin/blog/add'        => ['Admin\BlogController','add'],
    'admin/blog/store'      => ['Admin\BlogController','store'],
    'admin/blog/edit'       => ['Admin\BlogController','edit'],
    'admin/blog/update'     => ['Admin\BlogController','update'],
    'admin/blog/delete'     => ['Admin\BlogController','delete'],
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
