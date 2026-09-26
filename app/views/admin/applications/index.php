<?php
// ── ADMIN — APPLICATIONS LIST ────────────────────────────────
$statusList = applicationStatuses();
?>

<div class="pt-6">

  <!-- Status filter chips -->
  <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-5">
    <a href="<?= url('admin/applications') ?>"
       class="shrink-0 px-3 py-1.5 rounded-lg text-xs font-medium border transition
              <?= $filters['status'] === '' ? 'bg-eco-500/20 text-eco-400 border-eco-500/30' : 'bg-gray-900 text-gray-400 border-gray-800 hover:text-white' ?>">
      All <span class="opacity-60">(<?= (int) $statusCounts['all'] ?>)</span>
    </a>
    <?php foreach ($statusList as $key => $label): ?>
      <a href="<?= url('admin/applications?status=' . urlencode($key)) ?>"
         class="shrink-0 px-3 py-1.5 rounded-lg text-xs font-medium border transition
                <?= $filters['status'] === $key ? 'bg-eco-500/20 text-eco-400 border-eco-500/30' : 'bg-gray-900 text-gray-400 border-gray-800 hover:text-white' ?>">
        <?= Security::e($label) ?>
        <span class="opacity-60">(<?= (int) ($statusCounts[$key] ?? 0) ?>)</span>
      </a>
    <?php endforeach; ?>
  </div>

  <!-- Filters -->
  <form method="GET" action="<?= url('admin/applications') ?>"
        class="bg-gray-900 border border-gray-800 rounded-xl p-5 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
      <div class="lg:col-span-2">
        <label for="q" class="form-label">Search</label>
        <input type="search" id="q" name="q" value="<?= Security::e($filters['q']) ?>"
               class="form-input" placeholder="Name, email, reference or college">
      </div>

      <div>
        <label for="track" class="form-label">Track</label>
        <select id="track" name="track" class="form-input">
          <option value="">All tracks</option>
          <?php foreach ($tracks as $t): ?>
            <option value="<?= (int) $t['id'] ?>" <?= $filters['track'] === (int) $t['id'] ? 'selected' : '' ?>>
              <?= Security::e($t['title']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label for="from" class="form-label">From</label>
        <input type="date" id="from" name="from" value="<?= Security::e($filters['from']) ?>" class="form-input">
      </div>

      <div>
        <label for="to" class="form-label">To</label>
        <input type="date" id="to" name="to" value="<?= Security::e($filters['to']) ?>" class="form-input">
      </div>
    </div>

    <?php if ($filters['status'] !== ''): ?>
      <input type="hidden" name="status" value="<?= Security::e($filters['status']) ?>">
    <?php endif; ?>

    <div class="flex flex-wrap items-center gap-3 mt-4 pt-4 border-t border-gray-800">
      <button type="submit" class="btn-primary text-sm py-2">
        <i class="fas fa-filter mr-2"></i>Apply Filters
      </button>
      <a href="<?= url('admin/applications') ?>" class="btn-outline text-sm py-2">Reset</a>

      <a href="<?= Security::e(queryUrl('admin/applications/export')) ?>"
         class="ml-auto text-eco-400 hover:text-eco-300 text-xs font-semibold">
        <i class="fas fa-file-csv mr-1.5"></i>Export this view to CSV
      </a>
    </div>
  </form>

  <!-- Result summary -->
  <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <h2 class="font-display font-semibold text-white text-xl">Applications</h2>
    <p class="text-gray-500 text-xs">
      <?php if ($page['total'] > 0): ?>
        Showing <?= (int) $page['from'] ?>–<?= (int) $page['to'] ?> of <?= (int) $page['total'] ?>
      <?php else: ?>
        No matching applications
      <?php endif; ?>
    </p>
  </div>

  <!-- Table -->
  <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-800">
          <th class="text-left text-gray-400 font-medium px-5 py-3">Reference</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Candidate</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Track</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Status</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Applied</th>
          <th class="text-right text-gray-400 font-medium px-5 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-800">
        <?php if ($applications): foreach ($applications as $a): ?>
          <tr class="hover:bg-gray-800/50 transition">
            <td class="px-5 py-3.5">
              <a href="<?= url('admin/applications/view?id=' . (int) $a['id']) ?>"
                 class="text-eco-400 hover:text-eco-300 font-mono text-xs font-semibold">
                <?= Security::e($a['ref_no']) ?>
              </a>
            </td>

            <td class="px-5 py-3.5">
              <div class="text-white font-medium"><?= Security::e($a['intern_name']) ?></div>
              <div class="text-gray-500 text-xs"><?= Security::e($a['intern_email']) ?></div>
              <?php if (!empty($a['intern_college'])): ?>
                <div class="text-gray-600 text-[11px] mt-0.5"><?= Security::e($a['intern_college']) ?></div>
              <?php endif; ?>
            </td>

            <td class="px-5 py-3.5">
              <span class="inline-flex items-center gap-2 text-gray-300 text-xs">
                <i class="fas <?= Security::e($a['track_icon'] ?: 'fa-code') ?> text-eco-400"></i>
                <?= Security::e($a['track_title']) ?>
              </span>
            </td>

            <td class="px-5 py-3.5"><?= statusBadge((string) $a['status']) ?></td>

            <td class="px-5 py-3.5 text-gray-400 text-xs whitespace-nowrap">
              <?= formatDate((string) $a['created_at'], 'd M Y') ?>
              <div class="text-gray-600"><?= formatDate((string) $a['created_at'], 'g:i a') ?></div>
            </td>

            <td class="px-5 py-3.5 text-right whitespace-nowrap">
              <a href="<?= url('admin/applications/view?id=' . (int) $a['id']) ?>"
                 class="text-blue-400 hover:text-blue-300 text-xs transition">
                <i class="fas fa-eye mr-1"></i>Review
              </a>
              <a href="<?= url('admin/applications/resume?id=' . (int) $a['id']) ?>"
                 class="text-gray-400 hover:text-white text-xs transition ml-3">
                <i class="fas fa-file-arrow-down mr-1"></i>Resume
              </a>
              <?php if ($a['status'] === 'approved'): ?>
                <a href="<?= url('admin/applications/offer?id=' . (int) $a['id']) ?>"
                   class="text-eco-400 hover:text-eco-300 text-xs transition ml-3">
                  <i class="fas fa-file-contract mr-1"></i>Offer
                </a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; else: ?>
          <tr>
            <td colspan="6" class="text-center py-12 text-gray-500">
              <i class="fas fa-inbox text-3xl mb-3 block text-gray-600"></i>
              <?php if ($statusCounts['all'] === 0): ?>
                No applications have been submitted yet.
              <?php else: ?>
                No applications match these filters.
                <a href="<?= url('admin/applications') ?>" class="text-eco-400 hover:underline">Clear filters</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <?php if ($page['pages'] > 1): ?>
    <nav class="flex items-center justify-between gap-4 mt-5" aria-label="Pagination">
      <p class="text-gray-500 text-xs">
        Page <?= (int) $page['page'] ?> of <?= (int) $page['pages'] ?>
      </p>

      <div class="flex items-center gap-1.5">
        <?php if ($page['page'] > 1): ?>
          <a href="<?= Security::e(queryUrl('admin/applications', ['page' => $page['page'] - 1])) ?>"
             class="px-3 py-1.5 rounded-lg bg-gray-900 border border-gray-800 text-gray-400 hover:text-white text-xs transition">
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
             class="px-3 py-1.5 rounded-lg text-xs font-medium border transition
                    <?= $p === $page['page']
                        ? 'bg-eco-500/20 text-eco-400 border-eco-500/30'
                        : 'bg-gray-900 text-gray-400 border-gray-800 hover:text-white' ?>">
            <?= $p ?>
          </a>
        <?php endfor; ?>

        <?php if ($page['page'] < $page['pages']): ?>
          <a href="<?= Security::e(queryUrl('admin/applications', ['page' => $page['page'] + 1])) ?>"
             class="px-3 py-1.5 rounded-lg bg-gray-900 border border-gray-800 text-gray-400 hover:text-white text-xs transition">
            <i class="fas fa-chevron-right"></i>
          </a>
        <?php endif; ?>
      </div>
    </nav>
  <?php endif; ?>
</div>
