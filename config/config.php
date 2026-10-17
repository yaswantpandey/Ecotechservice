<?php
// ============================================================
// Ecotech Service — Core Configuration
// ============================================================

// ── Paths ────────────────────────────────────────────────────
define('ROOT_PATH', dirname(__DIR__));

// ── Load .env ────────────────────────────────────────────────
$env = [];
if (file_exists(ROOT_PATH . '/.env')) {
    $env = parse_ini_file(ROOT_PATH . '/.env') ?: [];
}
// Mail credentials live in their own file so the deploy can write them
// without touching .env (which holds the database login). Raw scanning keeps
// passwords containing #, !, = etc. intact; values may be wrapped in quotes.
if (file_exists(ROOT_PATH . '/.env.mail')) {
    $env = array_merge($env, parse_ini_file(ROOT_PATH . '/.env.mail', false, INI_SCANNER_RAW) ?: []);
}

// ── Environment ──────────────────────────────────────────────
define('APP_ENV',  $env['APP_ENV'] ?? 'production'); // 'production' on live server
define('APP_NAME', 'Ecotech Service');
// Automatically detect protocol and host for safe deployment anywhere.
// Guarded with ?? so CLI scripts (migrations, cron, diagnostics) do not warn
// on the missing $_SERVER keys that only exist during a web request.
$protocol = (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || ($_SERVER['SERVER_PORT'] ?? null) == 443
) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$base_dir = ($host === 'localhost') ? '/Ecotechservice/public' : '';
define('APP_URL',  $protocol . $host . $base_dir);
define('APP_VERSION', '1.0.0');

// ── Database ─────────────────────────────────────────────────
define('DB_HOST',    $env['DB_HOST'] ?? 'localhost');
define('DB_NAME',    $env['DB_NAME'] ?? 'ecotech_service');
define('DB_USER',    $env['DB_USER'] ?? 'root');
define('DB_PASS',    $env['DB_PASS'] ?? '');
define('DB_CHARSET', 'utf8mb4');

// ── Security ─────────────────────────────────────────────────
// No hardcoded fallback: a secret committed to the repo is not a secret.
// CSRF tokens themselves are per-session random_bytes (Security.php); this
// constant is reserved, so a missing value only gets a per-process random one.
define('CSRF_SECRET', $env['CSRF_SECRET'] ?? bin2hex(random_bytes(32)));
define('SESSION_NAME', 'ecotech_session');
define('BCRYPT_COST',  12);

define('PUBLIC_PATH',  ROOT_PATH . '/public');
define('UPLOAD_PATH',  PUBLIC_PATH . '/uploads');
define('UPLOAD_URL',   APP_URL . '/uploads');

// ── Email (SMTP) ─────────────────────────────────────────────
// Defaults target the Hostinger mailbox. Hostinger only relays mail whose
// From address is the authenticated mailbox, so SMTP_FROM follows SMTP_USER.
define('SMTP_HOST',     $env['SMTP_HOST'] ?? 'smtp.hostinger.com');
define('SMTP_PORT',     $env['SMTP_PORT'] ?? 465);
define('SMTP_USER',     $env['SMTP_USER'] ?? '');
define('SMTP_PASS',     $env['SMTP_PASS'] ?? '');
define('SMTP_FROM',     $env['SMTP_FROM'] ?? SMTP_USER);
define('SMTP_FROM_NAME', $env['SMTP_FROM_NAME'] ?? 'Ecotech Service');

// Encryption: 'ssl' (implicit TLS, port 465) or 'tls' (STARTTLS, port 587).
// Hostinger and most cPanel hosts want 465/ssl; Gmail wants 587/tls.
// Defaults are derived from the port so an unset value still does the right thing.
define('SMTP_ENCRYPTION', strtolower(
    $env['SMTP_ENCRYPTION'] ?? ((int) SMTP_PORT === 465 ? 'ssl' : 'tls')
));

// ── WhatsApp ─────────────────────────────────────────────────
define('WHATSAPP_NUMBER', $env['WHATSAPP_NUMBER'] ?? '7398301184');

// ── Upload Limits ─────────────────────────────────────────────
define('MAX_FILE_SIZE',  5 * 1024 * 1024); // 5 MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg','image/png','image/webp','image/gif']);

// ── Internship Portal ────────────────────────────────────────────────────
// Resumes live OUTSIDE the web root and are streamed by an authenticated
// controller. Never place them under /public.
define('RESUME_PATH', ROOT_PATH . '/storage/resumes');

// Capped to PHP's own upload_max_filesize (2M on this server). Raising this
// constant alone will not work — raise upload_max_filesize in php.ini too.
define('MAX_RESUME_SIZE', 2 * 1024 * 1024); // 2 MB

define('ALLOWED_RESUME_TYPES', [
    'application/pdf'                                                         => 'pdf',
    'application/msword'                                                      => 'doc',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'  => 'docx',
]);

// Offer letter identity
define('OFFER_PREFIX',      'ECO-INT');
define('OFFER_SIGNATORY',   'Yaswant Kumar');
define('OFFER_SIGNATORY_TITLE', 'Founder & Technical Director');
define('COMPANY_LEGAL_NAME', 'Ecotech Services');
define('COMPANY_ADDRESS',    'Lucknow, Uttar Pradesh, India - 226001');
define('COMPANY_EMAIL',      'ecotech.servic@gmail.com');
define('COMPANY_PHONE',      '+91 7398301184');

// Outbound email for the portal (registration / application / status change)
define('MAIL_ENABLED', true);

// Intern login throttling
define('LOGIN_MAX_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_SECS', 300);

// ── Error Reporting ───────────────────────────────────────────
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', ROOT_PATH . '/logs/error.log');
}

// ── Session ──────────────────────────────────────────────────
// Skipped under CLI, where there are no cookies or headers to configure.
if (PHP_SAPI !== 'cli' && session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Lax');
    if ($protocol === 'https://') {
        ini_set('session.cookie_secure', 1);
    }
    session_name(SESSION_NAME);
    session_start();
}
