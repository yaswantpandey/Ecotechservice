<?php // ── ADMIN — REGISTERED INTERNS ───────────────────────────── ?>

<div class="pt-6">

  <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
      <h2 class="font-display font-semibold text-white text-xl">Registered Interns</h2>
      <p class="text-gray-500 text-xs mt-1"><?= (int) $totalAll ?> account<?= $totalAll === 1 ? '' : 's' ?> in total</p>
    </div>
    <a href="<?= url('admin/applications') ?>" class="btn-outline text-sm py-2">
      <i class="fas fa-file-lines mr-2"></i>View Applications
    </a>
  </div>

  <!-- Filters -->
  <form method="GET" action="<?= url('admin/interns') ?>"
        class="bg-gray-900 border border-gray-800 rounded-xl p-5 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="sm:col-span-2">
        <label for="q" class="form-label">Search</label>
        <input type="search" id="q" name="q" value="<?= Security::e($search) ?>"
               class="form-input" placeholder="Name, email, college or course">
      </div>
      <div>
        <label for="state" class="form-label">Account State</label>
        <select id="state" name="state" class="form-input">
          <option value="">All accounts</option>
          <option value="active"   <?= $state === 'active'   ? 'selected' : '' ?>>Active only</option>
          <option value="inactive" <?= $state === 'inactive' ? 'selected' : '' ?>>Deactivated only</option>
        </select>
      </div>
    </div>
    <div class="flex gap-3 mt-4 pt-4 border-t border-gray-800">
      <button type="submit" class="btn-primary text-sm py-2"><i class="fas fa-filter mr-2"></i>Filter</button>
      <a href="<?= url('admin/interns') ?>" class="btn-outline text-sm py-2">Reset</a>
    </div>
  </form>

  <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-800">
          <th class="text-left text-gray-400 font-medium px-5 py-3">Name</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Contact</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Academic</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Applications</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">State</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Joined</th>
          <th class="text-right text-gray-400 font-medium px-5 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-800">
        <?php if ($interns): foreach ($interns as $i): ?>
          <tr class="hover:bg-gray-800/50 transition">
            <td class="px-5 py-3.5">
              <div class="text-white font-medium"><?= Security::e($i['name']) ?></div>
              <?php if (!empty($i['last_login_at'])): ?>
                <div class="text-gray-600 text-[11px] mt-0.5">
                  Last in <?= formatDate((string) $i['last_login_at'], 'd M Y') ?>
                </div>
              <?php endif; ?>
            </td>

            <td class="px-5 py-3.5">
              <div class="text-gray-300 text-xs break-all"><?= Security::e($i['email']) ?></div>
              <?php if (!empty($i['phone'])): ?>
                <div class="text-gray-500 text-xs mt-0.5"><?= Security::e($i['phone']) ?></div>
              <?php endif; ?>
            </td>

            <td class="px-5 py-3.5">
              <div class="text-gray-300 text-xs"><?= Security::e($i['college'] ?: '—') ?></div>
              <?php if (!empty($i['course']) || !empty($i['graduation_year'])): ?>
                <div class="text-gray-500 text-[11px] mt-0.5">
                  <?= Security::e(trim((string) $i['course'] . ' ' . (string) $i['graduation_year'])) ?>
                </div>
              <?php endif; ?>
            </td>

            <td class="px-5 py-3.5">
              <a href="<?= url('admin/applications?q=' . urlencode((string) $i['email'])) ?>"
                 class="text-gray-200 hover:text-eco-400 text-xs transition">
                <?= (int) $i['application_count'] ?> total
              </a>
              <?php if ((int) $i['approved_count'] > 0): ?>
                <div class="text-eco-400 text-[11px] mt-0.5">
                  <?= (int) $i['approved_count'] ?> approved
                </div>
              <?php endif; ?>
            </td>

            <td class="px-5 py-3.5">
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                <?= (int) $i['is_active'] === 1 ? 'bg-eco-500/20 text-eco-400' : 'bg-gray-700 text-gray-400' ?>">
                <?= (int) $i['is_active'] === 1 ? 'Active' : 'Deactivated' ?>
              </span>
            </td>

            <td class="px-5 py-3.5 text-gray-400 text-xs whitespace-nowrap">
              <?= formatDate((string) $i['created_at'], 'd M Y') ?>
            </td>

            <td class="px-5 py-3.5 text-right">
              <form action="<?= url('admin/interns/toggle') ?>" method="POST" class="inline"
                    onsubmit="return confirm('<?= (int) $i['is_active'] === 1 ? 'Deactivate' : 'Reactivate' ?> this account?');">
                <?= Security::csrfField() ?>
                <input type="hidden" name="id" value="<?= (int) $i['id'] ?>">
                <?php foreach (['q' => $search, 'state' => $state, 'page' => $page['page']] as $k => $v): ?>
                  <?php if ((string) $v !== ''): ?>
                    <input type="hidden" name="<?= Security::e($k) ?>" value="<?= Security::e((string) $v) ?>">
                  <?php endif; ?>
                <?php endforeach; ?>
                <button type="submit"
                        class="<?= (int) $i['is_active'] === 1 ? 'text-red-400 hover:text-red-300' : 'text-eco-400 hover:text-eco-300' ?> text-xs transition">
                  <i class="fas <?= (int) $i['is_active'] === 1 ? 'fa-user-slash' : 'fa-user-check' ?> mr-1"></i>
                  <?= (int) $i['is_active'] === 1 ? 'Deactivate' : 'Reactivate' ?>
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; else: ?>
          <tr>
            <td colspan="7" class="text-center py-12 text-gray-500">
              <i class="fas fa-users text-3xl mb-3 block text-gray-600"></i>
              <?= $totalAll === 0 ? 'No interns have registered yet.' : 'No accounts match your search.' ?>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if ($page['pages'] > 1): ?>
    <nav class="flex items-center justify-between gap-4 mt-5" aria-label="Pagination">
      <p class="text-gray-500 text-xs">
        Showing <?= (int) $page['from'] ?>–<?= (int) $page['to'] ?> of <?= (int) $page['total'] ?>
      </p>
      <div class="flex items-center gap-1.5">
        <?php for ($p = 1; $p <= $page['pages']; $p++): ?>
          <a href="<?= Security::e(queryUrl('admin/interns', ['page' => $p])) ?>"
             class="px-3 py-1.5 rounded-lg text-xs font-medium border transition
                    <?= $p === $page['page']
                        ? 'bg-eco-500/20 text-eco-400 border-eco-500/30'
                        : 'bg-gray-900 text-gray-400 border-gray-800 hover:text-white' ?>">
            <?= $p ?>
          </a>
        <?php endfor; ?>
      </div>
    </nav>
  <?php endif; ?>
</div>
