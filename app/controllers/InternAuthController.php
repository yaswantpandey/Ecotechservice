<?php
// ============================================================
// InternAuthController — public registration & login for the
// internship portal.
//
// Completely separate from Admin\AuthController: different table (`interns`),
// different session key (`intern_id`), different routes. An intern session can
// never satisfy isAdmin().
// ============================================================

require_once ROOT_PATH . '/app/controllers/BaseController.php';
require_once ROOT_PATH . '/app/helpers/Mailer.php';

class InternAuthController extends BaseController {

    // ── Registration ─────────────────────────────────────────────────────

    public function register(): void {
        if (isIntern()) {
            redirect(url('internships/dashboard'));
        }

        $this->view('internships.auth.register', [
            'pageTitle'       => 'Create Your Internship Account | ' . APP_NAME,
            'metaDescription' => 'Register for the Ecotech Services internship programme to apply for '
                . 'full stack, cybersecurity, data science, AI and other engineering tracks.',
            'canonicalPath'   => 'internships/register',
            'robotsMeta'      => 'noindex, follow',
            'old'             => $this->oldInput(),
        ]);
    }

    public function doRegister(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('internships/register'));
        }
        $this->validateCsrf();

        $name     = Security::sanitize($_POST['name'] ?? '');
        $email    = strtolower(Security::sanitize($_POST['email'] ?? ''));
        $phone    = Security::sanitize($_POST['phone'] ?? '');
        $college  = Security::sanitize($_POST['college'] ?? '');
        $course   = Security::sanitize($_POST['course'] ?? '');
        $gradYear = Security::sanitize($_POST['graduation_year'] ?? '');
        $password = (string) ($_POST['password'] ?? '');
        $confirm  = (string) ($_POST['password_confirm'] ?? '');

        $errors = [];

        if (mb_strlen($name) < 2 || mb_strlen($name) > 120) {
            $errors[] = 'Please enter your full name.';
        }
        if (!Security::validEmail($email) || mb_strlen($email) > 190) {
            $errors[] = 'Please enter a valid email address.';
        }
        if ($phone !== '' && !preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
            $errors[] = 'Please enter a valid phone number.';
        }
        if ($gradYear !== '' && (!ctype_digit($gradYear) || (int) $gradYear < 1980 || (int) $gradYear > 2040)) {
            $errors[] = 'Please enter a valid graduation year.';
        }

        $errors = array_merge($errors, $this->passwordErrors($password, $confirm));

        if ($errors) {
            $this->rememberInput(compact('name', 'email', 'phone', 'college', 'course', 'gradYear'));
            setFlash('error', implode(' ', $errors));
            redirect(url('internships/register'));
        }

        // Pre-check for a friendlier message, but the UNIQUE index below is the
        // real guarantee against a race between two simultaneous signups.
        $stmt = $this->db->prepare("SELECT id FROM interns WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $this->rememberInput(compact('name', 'phone', 'college', 'course', 'gradYear'));
            setFlash('error', 'An account with that email already exists. Please sign in instead.');
            redirect(url('internships/login'));
        }

        try {
            $stmt = $this->db->prepare(
                "INSERT INTO interns (name, email, phone, password, college, course, graduation_year)
                 VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $name,
                $email,
                $phone !== '' ? $phone : null,
                Security::hashPassword($password),
                $college !== '' ? $college : null,
                $course !== '' ? $course : null,
                $gradYear !== '' ? (int) $gradYear : null,
            ]);
        } catch (PDOException $e) {
            // 23000 = integrity constraint, i.e. the unique email index fired.
            if ($e->getCode() === '23000') {
                setFlash('error', 'An account with that email already exists. Please sign in.');
                redirect(url('internships/login'));
            }
            error_log('Intern registration failed: ' . $e->getMessage());
            setFlash('error', 'We could not create your account right now. Please try again.');
            redirect(url('internships/register'));
        }

        $internId = (int) $this->db->lastInsertId();

        $this->establishSession($internId, $name, $email);
        Mailer::welcome($email, $name);

        setFlash('success', 'Welcome aboard, ' . $name . '. Your account is ready.');
        redirect(url($this->consumeRedirect('internships')));
    }

    // ── Login ────────────────────────────────────────────────────────────

    public function login(): void {
        if (isIntern()) {
            redirect(url('internships/dashboard'));
        }

        $this->view('internships.auth.login', [
            'pageTitle'       => 'Intern Sign In | ' . APP_NAME,
            'metaDescription' => 'Sign in to your Ecotech Services internship account to apply for a '
                . 'track and track your application status.',
            'canonicalPath'   => 'internships/login',
            'robotsMeta'      => 'noindex, follow',
            'old'             => $this->oldInput(),
        ]);
    }

    public function doLogin(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('internships/login'));
        }
        $this->validateCsrf();

        $email    = strtolower(Security::sanitize($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            setFlash('error', 'Please enter your email and password.');
            redirect(url('internships/login'));
        }

        if ($this->isThrottled()) {
            redirect(url('internships/login'));
        }

        $stmt = $this->db->prepare(
            "SELECT id, name, email, password, is_active FROM interns WHERE email = ? LIMIT 1"
        );
        $stmt->execute([$email]);
        $intern = $stmt->fetch();

        // Always run a verify so the response time does not reveal whether the
        // address exists. Deliberately vague failure message for the same reason.
        $hash  = $intern['password'] ?? '$2y$12$invalidinvalidinvalidinvalidinvalidinvalidinvalidinvalidinv';
        $valid = Security::verifyPassword($password, $hash);

        if (!$intern || !$valid) {
            $this->recordFailure();
            setFlash('error', 'Those credentials do not match our records.');
            $this->rememberInput(['email' => $email]);
            redirect(url('internships/login'));
        }

        if ((int) $intern['is_active'] !== 1) {
            $this->recordFailure();
            setFlash('error', 'This account has been deactivated. Please contact ' . COMPANY_EMAIL . '.');
            redirect(url('internships/login'));
        }

        $this->clearThrottle();
        $this->establishSession((int) $intern['id'], (string) $intern['name'], (string) $intern['email']);

        $stmt = $this->db->prepare("UPDATE interns SET last_login_at = NOW() WHERE id = ?");
        $stmt->execute([(int) $intern['id']]);

        setFlash('success', 'Signed in. Welcome back, ' . $intern['name'] . '.');
        redirect(url($this->consumeRedirect('internships/dashboard')));
    }

    public function logout(): void {
        // Clears only the intern keys — an admin signed in in the same browser
        // keeps their session.
        internLogout();
        session_regenerate_id(true);

        setFlash('success', 'You have been signed out.');
        redirect(url('internships'));
    }

    // ── Internals ────────────────────────────────────────────────────────

    /**
     * Start an authenticated intern session, rotating the id to defeat fixation.
     */
    private function establishSession(int $id, string $name, string $email): void {
        session_regenerate_id(true);
        $_SESSION['intern_id']    = $id;
        $_SESSION['intern_name']  = $name;
        $_SESSION['intern_email'] = $email;
    }

    /**
     * Password policy. Kept strict but explainable.
     *
     * @return string[]
     */
    private function passwordErrors(string $password, string $confirm): array {
        $errors = [];

        if (mb_strlen($password) < 8) {
            $errors[] = 'Your password must be at least 8 characters.';
        }
        if (mb_strlen($password) > 200) {
            $errors[] = 'That password is too long.';
        }
        if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $errors[] = 'Your password must include at least one letter and one number.';
        }
        if ($password !== $confirm) {
            $errors[] = 'The two passwords do not match.';
        }

        return $errors;
    }

    /**
     * Session-based login throttle, mirroring the admin panel's approach but
     * under its own keys.
     */
    private function isThrottled(): bool {
        $now  = time();
        $last = $_SESSION['intern_last_attempt'] ?? 0;

        if ($now - $last > LOGIN_LOCKOUT_SECS) {
            $_SESSION['intern_attempts'] = 0;
        }

        if (($_SESSION['intern_attempts'] ?? 0) >= LOGIN_MAX_ATTEMPTS) {
            $wait = max(1, (int) ceil((LOGIN_LOCKOUT_SECS - ($now - $last)) / 60));
            setFlash('error', "Too many failed attempts. Please wait {$wait} minute(s) and try again.");
            return true;
        }

        return false;
    }

    private function recordFailure(): void {
        $_SESSION['intern_attempts']     = ($_SESSION['intern_attempts'] ?? 0) + 1;
        $_SESSION['intern_last_attempt'] = time();
    }

    private function clearThrottle(): void {
        unset($_SESSION['intern_attempts'], $_SESSION['intern_last_attempt']);
    }

    /**
     * Where to send the user after authenticating. Only ever an internal path.
     */
    private function consumeRedirect(string $fallback): string {
        $target = $_SESSION['intern_redirect'] ?? '';
        unset($_SESSION['intern_redirect']);

        if ($target === '') {
            return $fallback;
        }

        // Reject anything that is not a same-site path, to avoid an open redirect.
        $path = parse_url($target, PHP_URL_PATH) ?: '';
        if ($path === '' || parse_url($target, PHP_URL_HOST) !== null) {
            return $fallback;
        }

        $base = trim(parse_url(APP_URL, PHP_URL_PATH) ?? '', '/');
        $path = trim($path, '/');
        if ($base !== '' && str_starts_with($path, $base)) {
            $path = trim(substr($path, strlen($base)), '/');
        }

        // Only allow the portal's own routes back.
        if (!str_starts_with($path, 'internships')) {
            return $fallback;
        }

        $query = parse_url($target, PHP_URL_QUERY);
        return $path . ($query ? '?' . $query : '');
    }

    /**
     * Repopulate a form after a validation failure.
     */
    private function rememberInput(array $data): void {
        $_SESSION['intern_old'] = $data;
    }

    private function oldInput(): array {
        $old = $_SESSION['intern_old'] ?? [];
        unset($_SESSION['intern_old']);
        return is_array($old) ? $old : [];
    }
}
