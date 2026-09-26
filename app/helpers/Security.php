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

    // ── Resume / Document Upload ─────────────────────────────────────────

    /**
     * Validate and store an uploaded resume OUTSIDE the web root.
     *
     * Trust order matters: we check the upload error, then the real size, then
     * the MIME type sniffed from file *content* (never the client-supplied
     * name or type), and only then derive the extension from our own whitelist
     * rather than from the original filename.
     *
     * @return array{path:string,original:string,mime:string,size:int}
     * @throws RuntimeException on any validation failure.
     */
    public static function uploadResume(array $file): array {
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new RuntimeException('Invalid upload. Please attach your resume again.');
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('Please attach your resume.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException(
                    'That file is larger than the ' . self::humanSize(self::maxResumeBytes()) . ' limit.'
                );
            case UPLOAD_ERR_PARTIAL:
                throw new RuntimeException('The upload was interrupted. Please try again.');
            default:
                throw new RuntimeException('Your resume could not be uploaded. Please try again.');
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            throw new RuntimeException('Invalid upload source.');
        }

        $size = (int) filesize($file['tmp_name']);
        if ($size <= 0) {
            throw new RuntimeException('That file appears to be empty.');
        }
        if ($size > self::maxResumeBytes()) {
            throw new RuntimeException(
                'That file is larger than the ' . self::humanSize(self::maxResumeBytes()) . ' limit.'
            );
        }

        // Sniff the real MIME from content. A .php renamed to .pdf fails here.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->file($file['tmp_name']) ?: '';

        $allowed = ALLOWED_RESUME_TYPES;
        if (!array_key_exists($mime, $allowed)) {
            throw new RuntimeException('Only PDF, DOC or DOCX resumes are accepted.');
        }

        // Extension comes from OUR whitelist, not from the uploaded filename.
        $ext = $allowed[$mime];

        // Cross-check the claimed extension so a .docx of MIME application/msword
        // and other mismatches do not slip through silently.
        $claimedExt = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
        if ($claimedExt !== '' && !in_array($claimedExt, ['pdf', 'doc', 'docx'], true)) {
            throw new RuntimeException('Only PDF, DOC or DOCX resumes are accepted.');
        }

        if (!is_dir(RESUME_PATH) && !mkdir(RESUME_PATH, 0755, true) && !is_dir(RESUME_PATH)) {
            throw new RuntimeException('Resume storage is unavailable. Please contact support.');
        }

        // Unguessable filename — the original name is kept in the database only.
        $filename = date('Ymd') . '_' . bin2hex(random_bytes(16)) . '.' . $ext;
        $dest     = RESUME_PATH . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            throw new RuntimeException('Failed to save your resume. Please try again.');
        }

        @chmod($dest, 0644);

        return [
            'path'     => $filename,
            'original' => self::safeFilename((string) $file['name'], $ext),
            'mime'     => $mime,
            'size'     => $size,
        ];
    }

    /**
     * Effective resume size cap — the lower of our constant and PHP's own limit,
     * so we never promise a size the server will silently reject.
     */
    public static function maxResumeBytes(): int {
        $iniBytes = self::iniBytes((string) ini_get('upload_max_filesize'));
        $postMax  = self::iniBytes((string) ini_get('post_max_size'));
        $limits   = array_filter([MAX_RESUME_SIZE, $iniBytes, $postMax]);
        return $limits ? (int) min($limits) : MAX_RESUME_SIZE;
    }

    /**
     * Convert a php.ini shorthand size (e.g. "2M") to bytes.
     */
    private static function iniBytes(string $value): int {
        $value = trim($value);
        if ($value === '') {
            return 0;
        }

        $unit   = strtolower($value[strlen($value) - 1]);
        $number = (int) $value;

        return match ($unit) {
            'g'     => $number * 1024 * 1024 * 1024,
            'm'     => $number * 1024 * 1024,
            'k'     => $number * 1024,
            default => (int) $value,
        };
    }

    /**
     * Human-readable byte size.
     */
    public static function humanSize(int $bytes): string {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }
        if ($bytes >= 1024) {
            return round($bytes / 1024) . ' KB';
        }
        return $bytes . ' B';
    }

    /**
     * Strip a user-supplied filename down to something safe to echo and to
     * send back in a Content-Disposition header.
     */
    public static function safeFilename(string $name, string $forceExt = ''): string {
        $base = pathinfo($name, PATHINFO_FILENAME);
        $base = preg_replace('/[^A-Za-z0-9 _.-]/', '', $base) ?? '';
        $base = trim(preg_replace('/\s+/', ' ', $base) ?? '');
        if ($base === '') {
            $base = 'resume';
        }
        $base = mb_substr($base, 0, 80);
        $ext  = $forceExt !== '' ? $forceExt : strtolower(pathinfo($name, PATHINFO_EXTENSION));
        return $ext !== '' ? $base . '.' . $ext : $base;
    }
}
