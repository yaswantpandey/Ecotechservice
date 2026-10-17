<?php
namespace Admin;

require_once ROOT_PATH . '/app/controllers/BaseController.php';

/**
 * Database check / repair for the internship portal schema.
 *
 * The internship tables come from database/internship_migration.sql. On hosts
 * where that file was never imported (or failed on its foreign keys) every
 * internship page breaks. This screen shows what is missing and can create it
 * from the same migration — additive only: CREATE TABLE IF NOT EXISTS,
 * ADD COLUMN for missing columns, and the track seed only into an empty table.
 */
class DatabaseController extends \BaseController {

    // Deployed copy of database/internship_migration.sql (database/ is not deployed).
    private const MIGRATION = ROOT_PATH . '/app/schema/internship_migration.sql';

    public function index(): void {
        requireAdmin();

        $this->view('admin.database', [
            'layout'    => 'admin',
            'pageTitle' => 'Database check — Admin',
            'report'    => $this->inspect(),
            'logLines'  => $this->recentLogLines(),
            'results'   => $_SESSION['db_repair_results'] ?? null,
        ]);
        unset($_SESSION['db_repair_results']);
    }

    public function repair(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(url('admin/database'));
        $this->validateCsrf();

        $results = [];
        $schema  = $this->expectedSchema();

        foreach ($schema as $table => $def) {
            $existing = $this->columnsOf($table);

            if ($existing === []) {
                // Create the table; if MySQL rejects a foreign key (e.g. the
                // admin table is not `users` or its id type differs), retry
                // without constraints so the portal still works.
                try {
                    $this->db->exec($def['sql']);
                    $results[] = ['ok', "Created table `{$table}`."];
                } catch (\Throwable $e) {
                    try {
                        $this->db->exec($this->withoutForeignKeys($def['sql']));
                        $results[] = ['ok', "Created table `{$table}` without foreign keys (MySQL rejected them: " . $e->getMessage() . ').'];
                    } catch (\Throwable $e2) {
                        $results[] = ['error', "Could not create `{$table}`: " . $e2->getMessage()];
                    }
                }
                continue;
            }

            foreach ($def['columns'] as $col => $colSql) {
                if (in_array($col, $existing, true)) continue;
                try {
                    $this->db->exec("ALTER TABLE `{$table}` ADD COLUMN {$colSql}");
                    $results[] = ['ok', "Added column `{$table}`.`{$col}`."];
                } catch (\Throwable $e) {
                    $results[] = ['error', "Could not add `{$table}`.`{$col}`: " . $e->getMessage()];
                }
            }
        }

        // Seed the tracks only when the table exists and is empty — never
        // overwrite tracks an admin has already edited.
        try {
            $count = (int) $this->db->query('SELECT COUNT(*) FROM `internship_tracks`')->fetchColumn();
            if ($count === 0 && ($seed = $this->seedStatement()) !== null) {
                $this->db->exec($seed);
                $added = (int) $this->db->query('SELECT COUNT(*) FROM `internship_tracks`')->fetchColumn();
                $results[] = ['ok', "Added {$added} internship tracks."];
            } elseif ($count > 0) {
                $results[] = ['ok', "Internship tracks already present ({$count}); left unchanged."];
            }
        } catch (\Throwable $e) {
            $results[] = ['error', 'Could not seed internship tracks: ' . $e->getMessage()];
        }

        if ($results === []) {
            $results[] = ['ok', 'Nothing to do — every internship table and column is already present.'];
        }

        foreach ($results as [$kind, $msg]) {
            error_log('[admin-database:repair] ' . strtoupper($kind) . ' ' . $msg);
        }
        $_SESSION['db_repair_results'] = $results;
        redirect(url('admin/database'));
    }

    // ── Internals ────────────────────────────────────────────────────────

    /**
     * Current state of every expected table/column.
     *
     * @return array<string, array{exists:bool, missing:string[], rows:?int}>
     */
    private function inspect(): array {
        $report = [];
        foreach ($this->expectedSchema() as $table => $def) {
            $existing = $this->columnsOf($table);
            $rows = null;
            if ($existing !== []) {
                try {
                    $rows = (int) $this->db->query("SELECT COUNT(*) FROM `{$table}`")->fetchColumn();
                } catch (\Throwable $e) {
                    $rows = null;
                }
            }
            $report[$table] = [
                'exists'  => $existing !== [],
                'missing' => $existing === [] ? [] : array_values(array_diff(array_keys($def['columns']), $existing)),
                'rows'    => $rows,
            ];
        }
        return $report;
    }

    /** @return string[] column names, or [] if the table does not exist */
    private function columnsOf(string $table): array {
        try {
            $stmt = $this->db->prepare(
                'SELECT COLUMN_NAME FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?'
            );
            $stmt->execute([$table]);
            return array_map('strval', $stmt->fetchAll(\PDO::FETCH_COLUMN));
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Parse the migration's CREATE TABLE statements into
     * table => [sql, columns => [name => column definition]].
     *
     * @return array<string, array{sql:string, columns:array<string,string>}>
     */
    private function expectedSchema(): array {
        static $schema = null;
        if ($schema !== null) return $schema;

        $schema = [];
        $sql = is_readable(self::MIGRATION) ? (string) file_get_contents(self::MIGRATION) : '';
        if (!preg_match_all('/CREATE TABLE IF NOT EXISTS `(\w+)` \((.*?)\n\) ENGINE=[^;]+;/s', $sql, $m, PREG_SET_ORDER)) {
            return $schema;
        }
        foreach ($m as $match) {
            $columns = [];
            foreach ($this->definitionLines($match[2]) as $line) {
                if (preg_match('/^`(\w+)`\s+(.+)$/s', $line, $c)) {
                    $columns[$c[1]] = '`' . $c[1] . '` ' . $c[2];
                }
            }
            $schema[$match[1]] = ['sql' => rtrim($match[0], ';'), 'columns' => $columns];
        }
        return $schema;
    }

    /**
     * Split a CREATE TABLE body into one entry per column / key, joining
     * wrapped continuation lines (a line not ending in "," continues).
     *
     * @return string[]
     */
    private function definitionLines(string $body): array {
        $out = [];
        $buf = '';
        foreach (explode("\n", $body) as $raw) {
            $line = trim($raw);
            if ($line === '') continue;
            $buf = $buf === '' ? $line : $buf . ' ' . $line;
            if (str_ends_with($buf, ',')) {
                $out[] = rtrim($buf, ',');
                $buf = '';
            }
        }
        if ($buf !== '') $out[] = $buf;
        return $out;
    }

    private function withoutForeignKeys(string $createSql): string {
        $sql = preg_replace('/^\s*CONSTRAINT\s+`[^`]+`\s+FOREIGN\s+KEY.*\R?/mi', '', $createSql);
        // The line before the removed constraints may now end in a dangling comma.
        return (string) preg_replace('/,(\s*\R\))/', '$1', (string) $sql);
    }

    private function seedStatement(): ?string {
        $sql = is_readable(self::MIGRATION) ? (string) file_get_contents(self::MIGRATION) : '';
        if (preg_match('/INSERT INTO `internship_tracks`.*?;\s*$/sm', $sql, $m)) {
            return rtrim(trim($m[0]), ';');
        }
        return null;
    }

    /** Last internship / dashboard / repair lines from logs/error.log. */
    private function recentLogLines(int $limit = 15): array {
        $file = ROOT_PATH . '/logs/error.log';
        if (!is_readable($file)) return [];
        $size = filesize($file);
        $fh = fopen($file, 'rb');
        if (!$fh) return [];
        fseek($fh, max(0, $size - 200000));
        $chunk = (string) stream_get_contents($fh);
        fclose($fh);
        $lines = preg_grep('/\[(internships|admin-dashboard|admin-database)[:\]]|SQLSTATE/', explode("\n", $chunk));
        return array_slice(array_values($lines), -$limit);
    }
}
