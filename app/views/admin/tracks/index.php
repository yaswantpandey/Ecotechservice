<?php // ── ADMIN — INTERNSHIP TRACKS ────────────────────────────── ?>

<div class="a-card">
  <div class="a-card-head">
    <div>
      <h2>Internship tracks</h2>
      <p class="s-num m-0"><?= count($tracks) ?> track<?= count($tracks) === 1 ? '' : 's' ?> configured</p>
    </div>
    <a href="<?= url('admin/tracks/add') ?>" class="s-btn s-btn--sm">
      <i class="fas fa-plus text-xs" aria-hidden="true"></i> Add track
    </a>
  </div>

  <div class="a-table-wrap">
    <table class="a-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Track</th>
          <th>Duration</th>
          <th>Seats</th>
          <th>Applications</th>
          <th>Status</th>
          <th class="a-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($tracks): foreach ($tracks as $t): ?>
          <tr>
            <td class="s-num"><?= (int) $t['sort_order'] ?></td>

            <td>
              <div class="flex items-center gap-3">
                <span class="a-icon-btn" aria-hidden="true" style="cursor:default">
                  <i class="fas <?= Security::e($t['icon']) ?>"></i>
                </span>
                <div class="min-w-0">
                  <div class="font-medium"><?= Security::e($t['title']) ?></div>
                  <div class="s-num" style="font-size:.7rem"><?= Security::e($t['slug']) ?></div>
                </div>
              </div>
            </td>

            <td class="whitespace-nowrap"><?= (int) $t['duration_weeks'] ?> weeks</td>
            <td class="s-num"><?= (int) $t['seats'] ?></td>

            <td>
              <?php if ((int) $t['application_count'] > 0): ?>
                <a href="<?= url('admin/applications?track=' . (int) $t['id']) ?>" class="s-link">
                  <?= (int) $t['application_count'] ?> received
                </a>
              <?php else: ?>
                <span class="s-mute">None</span>
              <?php endif; ?>
            </td>

            <td>
              <span class="s-tag <?= (int) $t['is_active'] === 1 ? 's-tag--signal' : 's-tag--mute' ?>">
                <?= (int) $t['is_active'] === 1 ? 'Active' : 'Hidden' ?>
              </span>
            </td>

            <td class="a-right whitespace-nowrap">
              <div class="a-row-actions">
                <a href="<?= url('internships/track?slug=' . urlencode((string) $t['slug'])) ?>"
                   target="_blank" rel="noopener"
                   class="a-icon-btn" title="View on site" aria-label="View track on site">
                  <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i>
                </a>
                <a href="<?= url('admin/tracks/edit?id=' . (int) $t['id']) ?>"
                   class="a-icon-btn" title="Edit" aria-label="Edit track">
                  <i class="fas fa-pen" aria-hidden="true"></i>
                </a>

                <?php if ((int) $t['application_count'] === 0): ?>
                  <form action="<?= url('admin/tracks/delete') ?>" method="POST" class="inline"
                        onsubmit="return confirm('Delete this track? This cannot be undone.');">
                    <?= Security::csrfField() ?>
                    <input type="hidden" name="id" value="<?= (int) $t['id'] ?>">
                    <button type="submit" class="a-icon-btn a-icon-btn--danger" title="Delete" aria-label="Delete track">
                      <i class="fas fa-trash" aria-hidden="true"></i>
                    </button>
                  </form>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach; else: ?>
          <tr><td colspan="7"><div class="a-empty">No tracks configured yet.</div></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<p class="s-help mt-4">
  A track with applications against it cannot be deleted. Set it to hidden instead to close it to new applicants.
</p>
