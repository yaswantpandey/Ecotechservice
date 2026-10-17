<!-- ── ADMIN SERVICES LIST ────────────────────────────────── -->
<div class="a-card">
  <div class="a-card-head">
    <h2>All services</h2>
    <a href="<?= url('admin/services/add') ?>" class="s-btn s-btn--sm"><i class="fas fa-plus text-xs" aria-hidden="true"></i> Add service</a>
  </div>
  <div class="a-table-wrap">
    <table class="a-table">
      <thead><tr>
        <th>#</th>
        <th>Title</th>
        <th>Icon</th>
        <th>Order</th>
        <th>Status</th>
        <th class="a-right">Actions</th>
      </tr></thead>
      <tbody>
        <?php if ($services): foreach ($services as $i => $s): ?>
        <tr>
          <td class="s-num"><?= $i+1 ?></td>
          <td class="font-medium"><?= Security::e($s['title']) ?></td>
          <td><i class="fas <?= Security::e($s['icon']) ?>" aria-hidden="true"></i> <span class="s-num"><?= Security::e($s['icon']) ?></span></td>
          <td class="s-num"><?= $s['sort_order'] ?></td>
          <td>
            <span class="s-tag <?= $s['is_active'] ? 's-tag--signal' : 's-tag--mute' ?>">
              <?= $s['is_active'] ? 'Active' : 'Hidden' ?>
            </span>
          </td>
          <td class="a-right">
            <div class="a-row-actions">
              <a href="<?= url('admin/services/edit?id=' . $s['id']) ?>" class="a-icon-btn" title="Edit" aria-label="Edit service"><i class="fas fa-pen" aria-hidden="true"></i></a>
              <a href="<?= url('admin/services/delete?id=' . $s['id']) ?>" onclick="return confirm('Delete this service?')" class="a-icon-btn a-icon-btn--danger" title="Delete" aria-label="Delete service"><i class="fas fa-trash" aria-hidden="true"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="6"><div class="a-empty">No services yet.</div></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
