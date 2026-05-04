<?php
// ============================================================
// Security Helper — CSRF, XSS, Input Sanitization
// ============================================================

class Security {

    // ── CSRF ────────────────────────────────────────────────

    /**
     * Generate a CSRF token and store it in the session.
     */
    public static function generateCsrf(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verify a submitted CSRF token.
     */
    public static function verifyCsrf(string $token): bool {
        return isset($_SESSION['csrf_token'])
            && hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Render a hidden CSRF input field.
     */
    public static function csrfField(): string {
        $token = self::generateCsrf();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }

    // ── XSS ─────────────────────────────────────────────────

    /**
     * Sanitize output to prevent XSS.
     */
    public static function e(mixed $value): string {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    // ── Input ────────────────────────────────────────────────

    /**
     * Sanitize a plain-text string (strip tags + trim).
     */
    public static function sanitize(string $input): string {
        return trim(strip_tags($input));
    }

    /**
     * Validate an email address.
     */
    public static function validEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate a URL.
     */
    public static function validUrl(string $url): bool {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    // ── Password ─────────────────────────────────────────────

    /**
     * Hash a password using bcrypt.
     */
    public static function hashPassword(string $plain): string {
        return password_hash($plain, PASSWORD_BCRYPT, ['cost' => BCRYPT_COST]);
    }

    /**
     * Verify a plain password against a hash.
     */
    public static function verifyPassword(string $plain, string $hash): bool {
        return password_verify($plain, $hash);
    }

    // ── Image Upload ─────────────────────────────────────────

    /**
     * Validate and move an uploaded image.
     * Returns the new filename or throws RuntimeException on failure.
     */
    public static function uploadImage(array $file, string $subDir = 'general'): string {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Upload error code: ' . $file['error']);
        }
        if ($file['size'] > MAX_FILE_SIZE) {
            throw new RuntimeException('File exceeds the maximum allowed size of 5 MB.');
        }

        // Verify MIME type from file content (not extension)
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->file($file['tmp_name']);
        if (!in_array($mime, ALLOWED_IMAGE_TYPES, true)) {
            throw new RuntimeException('Invalid file type. Only JPEG, PNG, WebP, and GIF are allowed.');
        }

        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('img_', true) . '.' . strtolower($ext);
        $destDir  = UPLOAD_PATH . '/' . $subDir;

        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $destDir . '/' . $filename)) {
            throw new RuntimeException('Failed to save uploaded file.');
        }

        return $subDir . '/' . $filename;
    }
}
