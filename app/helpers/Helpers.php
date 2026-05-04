<?php
// ============================================================
// General Helpers
// ============================================================

/**
 * Build a URL relative to APP_URL.
 */
function url(string $path = ''): string {
    return rtrim(APP_URL, '/') . ($path ? '/' . ltrim($path, '/') : '');
}

/**
 * Build an absolute canonical URL for the current public request or a given route.
 */
function canonicalUrl(?string $path = null): string {
    if ($path === null) {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $requestPath = parse_url($requestUri, PHP_URL_PATH) ?: '/';
        $basePath = trim(parse_url(APP_URL, PHP_URL_PATH) ?: '', '/');
        $path = trim($requestPath, '/');

        if ($basePath && str_starts_with($path, $basePath)) {
            $path = trim(substr($path, strlen($basePath)), '/');
        }

        parse_str(parse_url($requestUri, PHP_URL_QUERY) ?: '', $query);
        $allowedQuery = array_intersect_key($query, array_flip(['cat', 'slug', 'page']));

        if ($allowedQuery) {
            ksort($allowedQuery);
            $path .= '?' . http_build_query($allowedQuery);
        }
    }

    return url($path);
}

/**
 * Redirect to a URL.
 */
function redirect(string $url): never {
    header('Location: ' . $url);
    exit;
}

/**
 * Slug generator.
 */
function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

/**
 * Truncate a string to $length characters.
 */
function truncate(string $text, int $length = 150, string $suffix = '…'): string {
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return rtrim(mb_substr($text, 0, $length)) . $suffix;
}

/**
 * Flash message helpers.
 */
function setFlash(string $key, string $message): void {
    $_SESSION['flash'][$key] = $message;
}

function getFlash(string $key): string {
    $msg = $_SESSION['flash'][$key] ?? '';
    unset($_SESSION['flash'][$key]);
    return $msg;
}

function hasFlash(string $key): bool {
    return !empty($_SESSION['flash'][$key]);
}

/**
 * Return safe upload URL for an image path.
 */
function uploadUrl(string $path): string {
    return UPLOAD_URL . '/' . ltrim($path, '/');
}

/**
 * Fetch a site setting from the database.
 */
function setting(string $key, string $default = ''): string {
    static $cache = [];
    if (!isset($cache[$key])) {
        $db   = Database::getInstance();
        $stmt = $db->prepare("SELECT `value` FROM `site_settings` WHERE `key` = ?");
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        $cache[$key] = $row ? $row['value'] : $default;
    }
    return $cache[$key];
}

/**
 * Check if admin is authenticated.
 */
function isAdmin(): bool {
    return !empty($_SESSION['admin_id']);
}

/**
 * Require admin auth — redirect to login if not.
 */
function requireAdmin(): void {
    if (!isAdmin()) {
        redirect(url('admin/login'));
    }
}

/**
 * Format a MySQL timestamp to a human-readable date.
 */
function formatDate(string $date, string $format = 'd M Y'): string {
    return date($format, strtotime($date));
}

/**
 * Render star rating HTML.
 */
function stars(int $rating): string {
    $html = '';
    for ($i = 1; $i <= 5; $i++) {
        $html .= $i <= $rating
            ? '<i class="fas fa-star text-yellow-400"></i>'
            : '<i class="far fa-star text-gray-500"></i>';
    }
    return $html;
}
