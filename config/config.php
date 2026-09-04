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

// ── Environment ──────────────────────────────────────────────
define('APP_ENV',  $env['APP_ENV'] ?? 'production'); // 'production' on live server
define('APP_NAME', 'Ecotech Service');
// Automatically detect protocol and host for safe deployment anywhere
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
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
define('CSRF_SECRET', $env['CSRF_SECRET'] ?? 'EcoTech@CSRF#2024$Secret!Key');
define('SESSION_NAME', 'ecotech_session');
define('BCRYPT_COST',  12);

define('PUBLIC_PATH',  ROOT_PATH . '/public');
define('UPLOAD_PATH',  PUBLIC_PATH . '/uploads');
define('UPLOAD_URL',   APP_URL . '/uploads');

// ── Email (SMTP) ─────────────────────────────────────────────
define('SMTP_HOST',     $env['SMTP_HOST'] ?? 'smtp.gmail.com');
define('SMTP_PORT',     $env['SMTP_PORT'] ?? 587);
define('SMTP_USER',     $env['SMTP_USER'] ?? 'your_email@gmail.com');
define('SMTP_PASS',     $env['SMTP_PASS'] ?? 'your_app_password');
define('SMTP_FROM',     $env['SMTP_FROM'] ?? 'hello@ecotechservice.com');
define('SMTP_FROM_NAME', $env['SMTP_FROM_NAME'] ?? 'Ecotech Service');

// ── WhatsApp ─────────────────────────────────────────────────
define('WHATSAPP_NUMBER', $env['WHATSAPP_NUMBER'] ?? '18001234567');

// ── Upload Limits ─────────────────────────────────────────────
define('MAX_FILE_SIZE',  5 * 1024 * 1024); // 5 MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg','image/png','image/webp','image/gif']);

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

// ── Session ───────────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Lax');
    session_name(SESSION_NAME);
    session_start();
}
