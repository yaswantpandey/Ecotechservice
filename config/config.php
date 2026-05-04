<?php
// ============================================================
// Ecotech Service — Core Configuration
// ============================================================

// ── Environment ──────────────────────────────────────────────
define('APP_ENV',  'production'); // 'production' on live server
define('APP_NAME', 'Ecotech Service');
// Automatically detect protocol and host for safe deployment anywhere
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$base_dir = ($host === 'localhost') ? '/Ecotechservice/public' : '';
define('APP_URL',  $protocol . $host . $base_dir);
define('APP_VERSION', '1.0.0');

// ── Database ─────────────────────────────────────────────────
define('DB_HOST',    'localhost');
define('DB_NAME',    'ecotech_service');
define('DB_USER',    'root');
define('DB_PASS',    '');
define('DB_CHARSET', 'utf8mb4');

// ── Security ─────────────────────────────────────────────────
define('CSRF_SECRET', 'EcoTech@CSRF#2024$Secret!Key');
define('SESSION_NAME', 'ecotech_session');
define('BCRYPT_COST',  12);

// ── Paths ────────────────────────────────────────────────────
define('ROOT_PATH',    dirname(__DIR__));
define('PUBLIC_PATH',  ROOT_PATH . '/public');
define('UPLOAD_PATH',  PUBLIC_PATH . '/uploads');
define('UPLOAD_URL',   APP_URL . '/uploads');

// ── Email (SMTP) ─────────────────────────────────────────────
define('SMTP_HOST',     'smtp.gmail.com');
define('SMTP_PORT',     587);
define('SMTP_USER',     'your_email@gmail.com');
define('SMTP_PASS',     'your_app_password');
define('SMTP_FROM',     'hello@ecotechservice.com');
define('SMTP_FROM_NAME', 'Ecotech Service');

// ── WhatsApp ─────────────────────────────────────────────────
define('WHATSAPP_NUMBER', '18001234567');

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
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'Lax');
session_name(SESSION_NAME);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
