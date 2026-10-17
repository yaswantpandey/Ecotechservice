<!-- ── ADMIN TESTIMONIALS LIST ─────────────────────────────── -->
<div class="a-card">
  <div class="a-card-head">
    <h2>Testimonials</h2>
    <a href="<?= url('admin/testimonials/add') ?>" class="s-btn s-btn--sm"><i class="fas fa-plus text-xs" aria-hidden="true"></i> Add testimonial</a>
  </div>
  <div class="a-table-wrap">
    <table class="a-table">
      <thead><tr>
        <th>Client</th>
        <th>Rating</th>
        <th>Message</th>
        <th class="a-right">Actions</th>
      </tr></thead>
      <tbody>
        <?php if ($testimonials): foreach ($testimonials as $t): ?>
        <tr>
          <td>
            <div class="flex items-center gap-3">
              <span class="a-thumb flex items-center justify-center font-medium" style="width:36px;height:36px"><?= Security::e(strtoupper(substr($t['name'],0,1))) ?></span>
              <div>
                <div class="font-medium"><?= Security::e($t['name']) ?></div>
                <div class="s-mute text-xs"><?= Security::e(($t['position'] ?? '') . ($t['company'] ? ', ' . $t['company'] : '')) ?></div>
              </div>
            </div>
          </td>
          <td class="whitespace-nowrap">
            <span style="color:var(--ink)" aria-hidden="true"><?= str_repeat('★', max(0, min(5, (int)$t['rating']))) ?></span>
            <span class="s-num"><?= (int)$t['rating'] ?>/5</span>
          </td>
          <td class="s-mute" style="max-width:32rem">"<?= Security::e(truncate($t['message'], 120)) ?>"</td>
          <td class="a-right">
            <div class="a-row-actions">
              <a href="<?= url('admin/testimonials/edit?id=' . $t['id']) ?>" class="a-icon-btn" title="Edit" aria-label="Edit testimonial"><i class="fas fa-pen" aria-hidden="true"></i></a>
              <a href="<?= url('admin/testimonials/delete?id=' . $t['id']) ?>" onclick="return confirm('Delete?')" class="a-icon-btn a-icon-btn--danger" title="Delete" aria-label="Delete testimonial"><i class="fas fa-trash" aria-hidden="true"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="4"><div class="a-empty">No testimonials yet.</div></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
