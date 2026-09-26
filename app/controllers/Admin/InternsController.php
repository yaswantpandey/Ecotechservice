<?php
namespace Admin;

// ============================================================
// Admin\InternsController — registered candidate accounts.
// ============================================================

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class InternsController extends \BaseController {

    private const PER_PAGE = 20;

    public function index(): void {
        requireAdmin();

        $search  = trim((string) ($_GET['q'] ?? ''));
        $clauses = [];
        $params  = [];

        if ($search !== '') {
            $clauses[] = '(i.name LIKE ? OR i.email LIKE ? OR i.college LIKE ? OR i.course LIKE ?)';
            $like      = '%' . $search . '%';
            array_push($params, $like, $like, $like, $like);
        }

        $status = (string) ($_GET['state'] ?? '');
        if ($status === 'active') {
            $clauses[] = 'i.is_active = 1';
        } elseif ($status === 'inactive') {
            $clauses[] = 'i.is_active = 0';
        }

        $where = $clauses ? 'WHERE ' . implode(' AND ', $clauses) : '';

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM interns i {$where}");
        $stmt->execute($params);
        $total = (int) $stmt->fetchColumn();

        $page = paginate($total, self::PER_PAGE);

        $stmt = $this->db->prepare(
            "SELECT i.*,
                    (SELECT COUNT(*) FROM applications a WHERE a.intern_id = i.id) AS application_count,
                    (SELECT COUNT(*) FROM applications a WHERE a.intern_id = i.id AND a.status = 'approved') AS approved_count
             FROM interns i
             {$where}
             ORDER BY i.created_at DESC
             LIMIT " . (int) $page['perPage'] . " OFFSET " . (int) $page['offset']
        );
        $stmt->execute($params);
        $interns = $stmt->fetchAll();

        $this->view('admin.interns.index', [
            'layout'    => 'admin',
            'pageTitle' => 'Registered Interns — Admin',
            'interns'   => $interns,
            'page'      => $page,
            'search'    => $search,
            'state'     => $status,
            'totalAll'  => (int) $this->db->query("SELECT COUNT(*) FROM interns")->fetchColumn(),
        ]);
    }

    /**
     * Enable or disable an account. A disabled intern cannot sign in, but
     * their applications are preserved.
     */
    public function toggle(): void {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/interns'));
        }
        $this->validateCsrf();

        $id = (int) ($_POST['id'] ?? 0);

        $stmt = $this->db->prepare("SELECT id, name, is_active FROM interns WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $intern = $stmt->fetch();

        if (!$intern) {
            setFlash('error', 'That account no longer exists.');
            redirect(url('admin/interns'));
        }

        $newState = ((int) $intern['is_active'] === 1) ? 0 : 1;

        $stmt = $this->db->prepare("UPDATE interns SET is_active = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$newState, $id]);

        setFlash(
            'success',
            $intern['name'] . ' has been ' . ($newState === 1 ? 'reactivated' : 'deactivated') . '.'
        );
        redirect(queryUrl('admin/interns'));
    }
}
