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

// ── Intern (internship portal) session ───────────────────────────────────
// Deliberately a separate session key from admin_id. An intern session can
// never satisfy isAdmin(), and vice versa.

/**
 * Check if an intern is logged in.
 */
function isIntern(): bool {
    return !empty($_SESSION['intern_id']);
}

/**
 * Current intern id, or null.
 */
function internId(): ?int {
    return isIntern() ? (int) $_SESSION['intern_id'] : null;
}

/**
 * Current intern display name.
 */
function internName(): string {
    return (string) ($_SESSION['intern_name'] ?? '');
}

/**
 * Require an intern session. Remembers where they were headed so login can
 * bounce them back.
 */
function requireIntern(): void {
    if (!isIntern()) {
        $_SESSION['intern_redirect'] = $_SERVER['REQUEST_URI'] ?? '';
        setFlash('error', 'Please sign in to continue.');
        redirect(url('internships/login'));
    }
}

/**
 * Clear ONLY the intern keys. Using session_destroy() here would also log out
 * an admin who happens to be signed in in the same browser.
 */
function internLogout(): void {
    unset(
        $_SESSION['intern_id'],
        $_SESSION['intern_name'],
        $_SESSION['intern_email'],
        $_SESSION['intern_redirect']
    );
}

// ── Application status presentation ──────────────────────────────────────

/**
 * All selectable application statuses with their human labels.
 *
 * @return array<string,string>
 */
function applicationStatuses(): array {
    return [
        'pending'      => 'Pending',
        'under_review' => 'Under Review',
        'shortlisted'  => 'Shortlisted',
        'approved'     => 'Approved',
        'rejected'     => 'Rejected',
        'withdrawn'    => 'Withdrawn',
    ];
}

/**
 * Human label for a status key.
 */
function statusLabel(string $status): string {
    return applicationStatuses()[$status] ?? ucfirst(str_replace('_', ' ', $status));
}

/**
 * Design-system tag classes for a status (assets/css/site.css).
 */
function statusClasses(string $status): string {
    return match ($status) {
        'approved'     => 's-tag s-tag--solid',
        'shortlisted'  => 's-tag s-tag--signal',
        'rejected'     => 's-tag s-tag--danger',
        'withdrawn'    => 's-tag s-tag--mute',
        default        => 's-tag',
    };
}

/**
 * Font Awesome icon for a status key.
 */
function statusIcon(string $status): string {
    return match ($status) {
        'approved'     => 'fa-circle-check',
        'shortlisted'  => 'fa-star',
        'under_review' => 'fa-hourglass-half',
        'rejected'     => 'fa-circle-xmark',
        'withdrawn'    => 'fa-ban',
        default        => 'fa-clock',
    };
}

/**
 * Render a status tag (text only — no icon, no colour fill).
 */
function statusBadge(string $status): string {
    return '<span class="' . statusClasses($status) . '">'
        . Security::e(statusLabel($status))
        . '</span>';
}

// ── Pagination ───────────────────────────────────────────────────────────

/**
 * Compute pagination metadata.
 *
 * @return array{page:int,perPage:int,total:int,pages:int,offset:int,from:int,to:int}
 */
function paginate(int $total, int $perPage = 15, ?int $page = null): array {
    $perPage = max(1, $perPage);
    $pages   = max(1, (int) ceil($total / $perPage));
    $page    = $page ?? (int) ($_GET['page'] ?? 1);
    $page    = max(1, min($page, $pages));
    $offset  = ($page - 1) * $perPage;

    return [
        'page'    => $page,
        'perPage' => $perPage,
        'total'   => $total,
        'pages'   => $pages,
        'offset'  => $offset,
        'from'    => $total === 0 ? 0 : $offset + 1,
        'to'      => min($offset + $perPage, $total),
    ];
}

/**
 * Build a URL for the current route preserving existing query params but
 * overriding some of them (used by pagination links and filter forms).
 */
function queryUrl(string $path, array $overrides = []): string {
    $params = array_merge($_GET, $overrides);
    $params = array_filter(
        $params,
        static fn($v) => $v !== '' && $v !== null
    );
    return url($path) . ($params ? '?' . http_build_query($params) : '');
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

/**
 * Compute an aggregate rating from the active testimonials table for use in
 * Schema.org structured data. Unlocks review star snippets in Google SERPs.
 *
 * @return array{name:string,ratingValue:float,reviewCount:int,bestRating:int,worstRating:int}|null
 */
function aggregateRating(): ?array {
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    try {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            "SELECT COUNT(*) AS cnt, COALESCE(AVG(rating), 0) AS avg
             FROM testimonials
             WHERE is_active = 1 AND rating BETWEEN 1 AND 5"
        );
        $stmt->execute();
        $row = $stmt->fetch();
        $count = (int) ($row['cnt'] ?? 0);
        if ($count < 1) {
            return null;
        }
        $cache = [
            'name'        => 'Customer Reviews',
            'ratingValue' => round((float) $row['avg'], 1),
            'reviewCount' => $count,
            'bestRating'  => 5,
            'worstRating' => 1,
        ];
        return $cache;
    } catch (Throwable $e) {
        return null;
    }
}

/**
 * Submit one or multiple URLs to the IndexNow protocol (Bing, Yandex, Naver, Seznam).
 *
 * @param string|array $urls Single URL or array of URLs.
 * @return array ['success' => bool, 'statusCode' => int, 'message' => string]
 */
function submitIndexNow(string|array $urls): array {
    $key = defined('INDEXNOW_KEY') ? INDEXNOW_KEY : '';
    if (empty($key)) {
        return ['success' => false, 'statusCode' => 0, 'message' => 'INDEXNOW_KEY is not configured'];
    }

    $urlList = is_array($urls) ? $urls : [$urls];
    if (empty($urlList)) {
        return ['success' => false, 'statusCode' => 0, 'message' => 'No URLs provided'];
    }

    $firstUrl = $urlList[0];
    $host = parse_url($firstUrl, PHP_URL_HOST);
    if (!$host) {
        $host = parse_url(APP_URL, PHP_URL_HOST) ?: 'ecotechservices.tech';
    }

    $keyLocation = defined('INDEXNOW_KEY_LOCATION') && !empty(INDEXNOW_KEY_LOCATION)
        ? INDEXNOW_KEY_LOCATION
        : "https://{$host}/{$key}.txt";

    $payload = json_encode([
        'host'        => $host,
        'key'         => $key,
        'keyLocation' => $keyLocation,
        'urlList'     => array_values($urlList)
    ], JSON_UNESCAPED_SLASHES);

    $endpoint = 'https://api.indexnow.org/indexnow';
    $ch = curl_init($endpoint);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json; charset=utf-8',
            'User-Agent: EcotechService-IndexNow/1.0'
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 10,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr  = curl_error($ch);
    curl_close($ch);

    if ($curlErr) {
        return ['success' => false, 'statusCode' => $httpCode, 'message' => "cURL error: {$curlErr}"];
    }

    // 200 = OK, 202 = Accepted
    $isOk = in_array($httpCode, [200, 202], true);
    return [
        'success'    => $isOk,
        'statusCode' => $httpCode,
        'message'    => $isOk ? 'URLs submitted successfully to IndexNow' : "IndexNow returned HTTP {$httpCode}: {$response}"
    ];
}
