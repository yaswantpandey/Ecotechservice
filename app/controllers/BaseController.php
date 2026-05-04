<?php
// ============================================================
// Base Controller
// ============================================================

abstract class BaseController {

    protected PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Render a view file with data.
     * @param string $view  Path relative to app/views/ (use dots for subdirs)
     * @param array  $data  Variables to extract into the view scope
     */
    protected function view(string $view, array $data = []): void {
        extract($data, EXTR_SKIP);

        // Layout can be overridden per view by setting $layout = 'admin' etc.
        $layout = $data['layout'] ?? 'main';
        $viewFile = ROOT_PATH . '/app/views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            die('View not found: ' . Security::e($view));
        }

        // Capture view content
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Wrap in layout
        $layoutFile = ROOT_PATH . '/app/views/layouts/' . $layout . '.php';
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    /**
     * Send a JSON response.
     */
    protected function json(mixed $data, int $status = 200): never {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    /**
     * Validate CSRF token (for POST requests).
     */
    protected function validateCsrf(): void {
        $token = $_POST['csrf_token'] ?? '';
        if (!Security::verifyCsrf($token)) {
            http_response_code(403);
            die('Invalid or expired form token. Please go back and try again.');
        }
    }
}
