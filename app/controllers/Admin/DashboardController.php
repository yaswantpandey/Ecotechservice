<?php
namespace Admin;

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class DashboardController extends \BaseController {

    public function index(): void {
        requireAdmin();

        // Quick stats
        $stats = [
            'projects'     => $this->count('projects'),
            'services'     => $this->count('services'),
            'testimonials' => $this->count('testimonials'),
            'blog_posts'   => $this->count('blog_posts'),
            'contacts'     => $this->count('contacts'),
            'unread'       => $this->count('contacts', 'is_read = 0'),
        ];

        // Latest 5 contacts
        $recentContacts = $this->safe('recentContacts', fn () => $this->db->query(
            "SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5"
        )->fetchAll(), []);

        // ── Internship portal ───────────────────────────────────────────
        // Every internship query degrades to zero/empty so a missing or
        // out-of-date internship schema cannot take the whole dashboard down.
        $internship = [
            'interns'      => $this->count('interns'),
            'applications' => $this->count('applications'),
            'pending'      => $this->count('applications', "status IN ('pending','under_review')"),
            'approved'     => $this->count('applications', "status = 'approved'"),
            'tracks'       => $this->count('internship_tracks', 'is_active = 1'),
        ];

        $recentApplications = $this->safe('recentApplications', fn () => $this->db->query(
            "SELECT a.id, a.ref_no, a.status, a.created_at,
                    t.title AS track_title, i.name AS intern_name
             FROM applications a
             JOIN internship_tracks t ON t.id = a.track_id
             JOIN interns i           ON i.id = a.intern_id
             ORDER BY a.created_at DESC
             LIMIT 5"
        )->fetchAll(), []);

        $emptySeries = ['labels' => [], 'values' => []];

        $this->view('admin.dashboard', [
            'layout'             => 'admin',
            'pageTitle'          => 'Dashboard — Admin',
            'stats'              => $stats,
            'recentContacts'     => $recentContacts,
            'internship'         => $internship,
            'recentApplications' => $recentApplications,
            'charts'             => [
                'status' => $this->safe('statusChart', fn () => $this->statusChart(), $emptySeries),
                'track'  => $this->safe('trackChart',  fn () => $this->trackChart(),  $emptySeries),
                'trend'  => $this->safe('trendChart',  fn () => $this->trendChart(),  $emptySeries),
            ],
        ]);
    }

    /**
     * Run a dashboard query; on any database failure log the exact error
     * (missing table, unknown column, …) and return the fallback instead.
     */
    private function safe(string $what, callable $fn, mixed $fallback): mixed {
        try {
            return $fn();
        } catch (\Throwable $e) {
            error_log(sprintf('[admin-dashboard:%s] %s: %s', $what, get_class($e), $e->getMessage()));
            return $fallback;
        }
    }

    /**
     * Applications grouped by status, in a fixed order so colours stay stable.
     *
     * @return array{labels:string[],values:int[]}
     */
    private function statusChart(): array {
        $counts = array_fill_keys(array_keys(applicationStatuses()), 0);

        $stmt = $this->db->query("SELECT status, COUNT(*) AS c FROM applications GROUP BY status");
        foreach ($stmt->fetchAll() as $row) {
            if (array_key_exists($row['status'], $counts)) {
                $counts[$row['status']] = (int) $row['c'];
            }
        }

        $labels = [];
        foreach (array_keys($counts) as $key) {
            $labels[] = statusLabel($key);
        }

        return ['labels' => $labels, 'values' => array_values($counts)];
    }

    /**
     * Application volume per track.
     *
     * @return array{labels:string[],values:int[]}
     */
    private function trackChart(): array {
        $stmt = $this->db->query(
            "SELECT t.title, COUNT(a.id) AS c
             FROM internship_tracks t
             LEFT JOIN applications a ON a.track_id = t.id
             GROUP BY t.id, t.title
             ORDER BY c DESC, t.title ASC"
        );

        $labels = [];
        $values = [];
        foreach ($stmt->fetchAll() as $row) {
            $labels[] = (string) $row['title'];
            $values[] = (int) $row['c'];
        }

        return ['labels' => $labels, 'values' => $values];
    }

    /**
     * Applications per day for the last 14 days, zero-filled so the line has
     * no gaps on quiet days.
     *
     * @return array{labels:string[],values:int[]}
     */
    private function trendChart(int $days = 14): array {
        $series = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $series[date('Y-m-d', strtotime("-{$i} days"))] = 0;
        }

        $stmt = $this->db->prepare(
            "SELECT DATE(created_at) AS d, COUNT(*) AS c
             FROM applications
             WHERE created_at >= ?
             GROUP BY DATE(created_at)"
        );
        $stmt->execute([date('Y-m-d 00:00:00', strtotime('-' . ($days - 1) . ' days'))]);

        foreach ($stmt->fetchAll() as $row) {
            $key = (string) $row['d'];
            if (array_key_exists($key, $series)) {
                $series[$key] = (int) $row['c'];
            }
        }

        $labels = [];
        foreach (array_keys($series) as $date) {
            $labels[] = date('d M', strtotime($date));
        }

        return ['labels' => $labels, 'values' => array_values($series)];
    }

    private function count(string $table, string $where = ''): int {
        $sql  = "SELECT COUNT(*) FROM `{$table}`";
        if ($where) $sql .= " WHERE {$where}";
        return (int) $this->safe("count:{$table}", fn () => $this->db->query($sql)->fetchColumn(), 0);
    }
}
