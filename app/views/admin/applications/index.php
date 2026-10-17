<?php
// ── ADMIN — APPLICATIONS LIST ────────────────────────────────
$statusList = applicationStatuses();
?>

<div>

  <!-- Status filter -->
  <div class="overflow-x-auto mb-5">
    <nav class="s-filter" aria-label="Filter by status">
      <a href="<?= url('admin/applications') ?>" <?= $filters['status'] === '' ? 'aria-current="page"' : '' ?>>
        All <span class="s-num">(<?= (int) $statusCounts['all'] ?>)</span>
      </a>
      <?php foreach ($statusList as $key => $label): ?>
        <a href="<?= url('admin/applications?status=' . urlencode($key)) ?>" <?= $filters['status'] === $key ? 'aria-current="page"' : '' ?>>
          <?= Security::e($label) ?>
          <span class="s-num">(<?= (int) ($statusCounts[$key] ?? 0) ?>)</span>
        </a>
      <?php endforeach; ?>
    </nav>
  </div>

  <!-- Filters -->
  <form method="GET" action="<?= url('admin/applications') ?>" class="a-card a-card-pad mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-x-4">
      <div class="s-field lg:col-span-2">
        <label for="q" class="s-label">Search</label>
        <input type="search" id="q" name="q" value="<?= Security::e($filters['q']) ?>"
               class="s-input" placeholder="Name, email, reference or college">
      </div>

      <div class="s-field">
        <label for="track" class="s-label">Track</label>
        <select id="track" name="track" class="s-select">
          <option value="">All tracks</option>
          <?php foreach ($tracks as $t): ?>
            <option value="<?= (int) $t['id'] ?>" <?= $filters['track'] === (int) $t['id'] ? 'selected' : '' ?>>
              <?= Security::e($t['title']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="s-field">
        <label for="from" class="s-label">From</label>
        <input type="date" id="from" name="from" value="<?= Security::e($filters['from']) ?>" class="s-input">
      </div>

      <div class="s-field">
        <label for="to" class="s-label">To</label>
        <input type="date" id="to" name="to" value="<?= Security::e($filters['to']) ?>" class="s-input">
      </div>
    </div>

    <?php if ($filters['status'] !== ''): ?>
      <input type="hidden" name="status" value="<?= Security::e($filters['status']) ?>">
    <?php endif; ?>

    <div class="a-form-actions items-center">
      <button type="submit" class="s-btn s-btn--sm">Apply filters</button>
      <a href="<?= url('admin/applications') ?>" class="s-btn--line s-btn--sm">Reset</a>

      <a href="<?= Security::e(queryUrl('admin/applications/export')) ?>" class="s-link ml-auto text-sm">
        <i class="fas fa-file-csv mr-1"></i>Export this view to CSV
      </a>
    </div>
  </form>

  <!-- Table -->
  <div class="a-card">
    <div class="a-card-head">
      <h2>Applications</h2>
      <span class="s-num">
        <?php if ($page['total'] > 0): ?>
          Showing <?= (int) $page['from'] ?>–<?= (int) $page['to'] ?> of <?= (int) $page['total'] ?>
        <?php else: ?>
          No matching applications
        <?php endif; ?>
      </span>
    </div>

    <div class="a-table-wrap">
      <table class="a-table">
        <thead>
          <tr>
            <th>Reference</th>
            <th>Candidate</th>
            <th>Track</th>
            <th>Status</th>
            <th>Applied</th>
            <th class="a-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($applications): foreach ($applications as $a): ?>
            <tr>
              <td>
                <a href="<?= url('admin/applications/view?id=' . (int) $a['id']) ?>" class="s-link s-num">
                  <?= Security::e($a['ref_no']) ?>
                </a>
              </td>

              <td>
                <div><?= Security::e($a['intern_name']) ?></div>
                <div class="s-mute text-xs"><?= Security::e($a['intern_email']) ?></div>
                <?php if (!empty($a['intern_college'])): ?>
                  <div class="s-mute text-xs mt-0.5"><?= Security::e($a['intern_college']) ?></div>
                <?php endif; ?>
              </td>

              <td>
                <span class="inline-flex items-center gap-2 text-sm">
                  <i class="fas <?= Security::e($a['track_icon'] ?: 'fa-code') ?> s-mute text-xs"></i>
                  <?= Security::e($a['track_title']) ?>
                </span>
              </td>

              <td><?= statusBadge((string) $a['status']) ?></td>

              <td class="s-num whitespace-nowrap">
                <?= formatDate((string) $a['created_at'], 'd M Y') ?>
                <div><?= formatDate((string) $a['created_at'], 'g:i a') ?></div>
              </td>

              <td class="a-right">
                <div class="a-row-actions">
                  <a href="<?= url('admin/applications/view?id=' . (int) $a['id']) ?>" class="a-icon-btn" title="Review" aria-label="Review">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="<?= url('admin/applications/resume?id=' . (int) $a['id']) ?>" class="a-icon-btn" title="Download resume" aria-label="Download resume">
                    <i class="fas fa-file-arrow-down"></i>
                  </a>
                  <?php if ($a['status'] === 'approved'): ?>
                    <a href="<?= url('admin/applications/offer?id=' . (int) $a['id']) ?>" class="a-icon-btn" title="Offer letter" aria-label="Offer letter">
                      <i class="fas fa-file-contract"></i>
                    </a>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; else: ?>
            <tr>
              <td colspan="6" class="a-empty">
                <?php if ($statusCounts['all'] === 0): ?>
                  No applications have been submitted yet.
                <?php else: ?>
                  No applications match these filters.
                  <a href="<?= url('admin/applications') ?>" class="s-link">Clear filters</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  <?php if ($page['pages'] > 1): ?>
    <nav class="flex flex-wrap items-center justify-between gap-4 mt-5" aria-label="Pagination">
      <p class="s-num">
        Page <?= (int) $page['page'] ?> of <?= (int) $page['pages'] ?>
      </p>

      <div class="a-pager">
        <?php if ($page['page'] > 1): ?>
          <a href="<?= Security::e(queryUrl('admin/applications', ['page' => $page['page'] - 1])) ?>" aria-label="Previous page">
            <i class="fas fa-chevron-left"></i>
          </a>
        <?php endif; ?>

        <?php
        // A compact window around the current page.
        $start = max(1, $page['page'] - 2);
        $end   = min($page['pages'], $start + 4);
        $start = max(1, $end - 4);
        for ($p = $start; $p <= $end; $p++):
        ?>
          <a href="<?= Security::e(queryUrl('admin/applications', ['page' => $p])) ?>"
             class="<?= $p === $page['page'] ? 'is-current' : '' ?>"<?= $p === $page['page'] ? ' aria-current="page"' : '' ?>>
            <?= $p ?>
          </a>
        <?php endfor; ?>

        <?php if ($page['page'] < $page['pages']): ?>
          <a href="<?= Security::e(queryUrl('admin/applications', ['page' => $page['page'] + 1])) ?>" aria-label="Next page">
            <i class="fas fa-chevron-right"></i>
          </a>
        <?php endif; ?>
      </div>
    </nav>
  <?php endif; ?>
</div>
