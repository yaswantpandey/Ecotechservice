<?php
namespace Admin;

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class AuthController extends \BaseController {

    public function login(): void {
        if (isAdmin()) {
            redirect(url('admin/dashboard'));
        }
        $this->view('admin.auth.login', [
            'layout'    => 'admin_auth',
            'pageTitle' => 'Admin Login — ' . APP_NAME,
        ]);
    }

    public function doLogin(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/login'));
        }

        $this->validateCsrf();

        $email    = \Security::sanitize($_POST['email']    ?? '');
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            setFlash('error', 'Please enter your email and password.');
            redirect(url('admin/login'));
        }

        // Rate limiting (simple session-based)
        $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
        if ($_SESSION['login_attempts'] > 5) {
            setFlash('error', 'Too many failed attempts. Please wait a moment.');
            redirect(url('admin/login'));
        }

        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = ? AND is_active = 1 LIMIT 1"
        );
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && \Security::verifyPassword($password, $user['password'])) {
            // Reset attempts
            $_SESSION['login_attempts'] = 0;

            // Regenerate session ID to prevent fixation
            session_regenerate_id(true);

            $_SESSION['admin_id']   = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            $_SESSION['admin_role'] = $user['role'];

            redirect(url('admin/dashboard'));
        }

        setFlash('error', 'Invalid credentials. Please try again.');
        redirect(url('admin/login'));
    }

    public function logout(): void {
        session_destroy();
        redirect(url('admin/login'));
    }
}
