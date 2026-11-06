<?php
/**
 * One-off: add SEO meta columns to blog_posts for existing databases.
 * Uses the project's own DB connection (reads .env via config). Idempotent:
 * only adds columns that are missing. Safe to re-run.
 *
 * Run: php scratch/migrate_blog_meta.php
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$columns = [
    'meta_title'       => "ADD COLUMN `meta_title`       VARCHAR(255) DEFAULT NULL AFTER `published_at`",
    'meta_description' => "ADD COLUMN `meta_description` VARCHAR(320) DEFAULT NULL AFTER `meta_title`",
    'meta_keywords'    => "ADD COLUMN `meta_keywords`    VARCHAR(255) DEFAULT NULL AFTER `meta_description`",
];

try {
    $db = Database::getInstance();
} catch (Throwable $e) {
    fwrite(STDERR, "Could not connect to database: " . $e->getMessage() . "\n");
    exit(1);
}

// Does the blog_posts table exist at all?
try {
    $exists = (int) $db->query("SELECT COUNT(*) FROM information_schema.TABLES
                                WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'blog_posts'")->fetchColumn();
} catch (Throwable $e) {
    fwrite(STDERR, "information_schema query failed: " . $e->getMessage() . "\n");
    exit(1);
}

if ($exists === 0) {
    fwrite(STDERR, "Table `blog_posts` does not exist in `" . DB_NAME . "`. Import database/ecotech.sql first.\n");
    exit(1);
}

// Which of the target columns are already present?
$present = [];
try {
    $stmt = $db->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS
                        WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'blog_posts'");
    foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $col) {
        $present[$col] = true;
    }
} catch (Throwable $e) {
    fwrite(STDERR, "Could not read columns: " . $e->getMessage() . "\n");
    exit(1);
}

$missing = array_diff(array_keys($columns), array_keys($present));

if (empty($missing)) {
    echo "All SEO meta columns already present in blog_posts. Nothing to do.\n";
    exit(0);
}

$alterSql = "ALTER TABLE `blog_posts` " . implode(', ', array_map(fn($c) => $columns[$c], $missing));
echo "Adding missing columns: " . implode(', ', $missing) . "\n";

try {
    $db->exec($alterSql);
    echo "Done. Added " . count($missing) . " column(s) to blog_posts.\n";
} catch (Throwable $e) {
    fwrite(STDERR, "ALTER failed: " . $e->getMessage() . "\n");
    exit(1);
}
