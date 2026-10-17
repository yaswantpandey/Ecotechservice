<!-- ── ADMIN CONTACTS LIST ─────────────────────────────────── -->
<div class="a-card">
  <div class="a-card-head">
    <h2>Contact submissions</h2>
  </div>
  <div class="a-table-wrap">
    <table class="a-table min-w-[700px]">
      <thead><tr>
        <th>Name</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Date</th>
        <th>Status</th>
        <th class="a-right">Actions</th>
      </tr></thead>
      <tbody>
        <?php if ($contacts): foreach ($contacts as $c): ?>
        <tr>
          <td class="<?= !$c['is_read'] ? 'font-semibold' : '' ?>"><?= Security::e($c['name']) ?></td>
          <td class="s-mute"><?= Security::e($c['email']) ?></td>
          <td><?= Security::e(truncate($c['subject'], 40)) ?></td>
          <td class="s-num whitespace-nowrap"><?= formatDate($c['created_at'], 'd M Y, H:i') ?></td>
          <td>
            <span class="s-tag <?= $c['is_read'] ? 's-tag--mute' : 's-tag--signal' ?>"><?= $c['is_read'] ? 'Read' : 'New' ?></span>
          </td>
          <td class="a-right">
            <div class="a-row-actions">
              <a href="<?= url('admin/contacts/view?id=' . $c['id']) ?>" class="a-icon-btn" title="View" aria-label="View"><i class="fas fa-eye"></i></a>
              <a href="<?= url('admin/contacts/delete?id=' . $c['id']) ?>" onclick="return confirm('Delete message?')" class="a-icon-btn a-icon-btn--danger" title="Delete" aria-label="Delete"><i class="fas fa-trash"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="6" class="a-empty">No messages yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
