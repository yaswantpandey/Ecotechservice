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
 * Tailwind classes for a status badge.
 */
function statusClasses(string $status): string {
    return match ($status) {
        'approved'     => 'bg-eco-500/20 text-eco-400 border border-eco-500/30',
        'shortlisted'  => 'bg-blue-500/20 text-blue-300 border border-blue-500/30',
        'under_review' => 'bg-amber-500/20 text-amber-300 border border-amber-500/30',
        'rejected'     => 'bg-red-500/20 text-red-300 border border-red-500/30',
        'withdrawn'    => 'bg-gray-700 text-gray-400 border border-gray-600',
        default        => 'bg-gray-700/60 text-gray-300 border border-gray-600',
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
 * Render a status badge.
 */
function statusBadge(string $status): string {
    return '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium '
        . statusClasses($status) . '">'
        . '<i class="fas ' . statusIcon($status) . '"></i>'
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
