<?php // ── ADMIN — REGISTERED INTERNS ───────────────────────────── ?>

<div>

  <!-- Filters -->
  <form method="GET" action="<?= url('admin/interns') ?>" class="a-toolbar">
    <div class="a-toolbar-filters">
      <label for="q" class="sr-only">Search</label>
      <input type="search" id="q" name="q" value="<?= Security::e($search) ?>"
             class="s-input w-auto" placeholder="Name, email, college or course">
      <label for="state" class="sr-only">Account state</label>
      <select id="state" name="state" class="s-select w-auto">
        <option value="">All accounts</option>
        <option value="active"   <?= $state === 'active'   ? 'selected' : '' ?>>Active only</option>
        <option value="inactive" <?= $state === 'inactive' ? 'selected' : '' ?>>Deactivated only</option>
      </select>
      <button type="submit" class="s-btn s-btn--sm">Filter</button>
      <a href="<?= url('admin/interns') ?>" class="s-btn--line s-btn--sm">Reset</a>
    </div>
  </form>

  <div class="a-card">
    <div class="a-card-head">
      <div>
        <h2>Registered interns</h2>
        <p class="s-num mt-1"><?= (int) $totalAll ?> account<?= $totalAll === 1 ? '' : 's' ?> in total</p>
      </div>
      <a href="<?= url('admin/applications') ?>" class="s-btn--line s-btn--sm">
        <i class="fas fa-file-lines"></i>View Applications
      </a>
    </div>

    <div class="a-table-wrap">
      <table class="a-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Contact</th>
            <th>Academic</th>
            <th>Applications</th>
            <th>State</th>
            <th>Joined</th>
            <th class="a-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($interns): foreach ($interns as $i): ?>
            <tr>
              <td>
                <div><?= Security::e($i['name']) ?></div>
                <?php if (!empty($i['last_login_at'])): ?>
                  <div class="s-mute text-xs mt-0.5">
                    Last in <?= formatDate((string) $i['last_login_at'], 'd M Y') ?>
                  </div>
                <?php endif; ?>
              </td>

              <td>
                <div class="text-sm break-all"><?= Security::e($i['email']) ?></div>
                <?php if (!empty($i['phone'])): ?>
                  <div class="s-mute text-xs mt-0.5"><?= Security::e($i['phone']) ?></div>
                <?php endif; ?>
              </td>

              <td>
                <div class="text-sm"><?= Security::e($i['college'] ?: '—') ?></div>
                <?php if (!empty($i['course']) || !empty($i['graduation_year'])): ?>
                  <div class="s-mute text-xs mt-0.5">
                    <?= Security::e(trim((string) $i['course'] . ' ' . (string) $i['graduation_year'])) ?>
                  </div>
                <?php endif; ?>
              </td>

              <td>
                <a href="<?= url('admin/applications?q=' . urlencode((string) $i['email'])) ?>" class="s-link text-sm">
                  <?= (int) $i['application_count'] ?> total
                </a>
                <?php if ((int) $i['approved_count'] > 0): ?>
                  <div class="s-mute text-xs mt-0.5">
                    <?= (int) $i['approved_count'] ?> approved
                  </div>
                <?php endif; ?>
              </td>

              <td>
                <span class="s-tag <?= (int) $i['is_active'] === 1 ? 's-tag--signal' : 's-tag--mute' ?>">
                  <?= (int) $i['is_active'] === 1 ? 'Active' : 'Deactivated' ?>
                </span>
              </td>

              <td class="s-num whitespace-nowrap">
                <?= formatDate((string) $i['created_at'], 'd M Y') ?>
              </td>

              <td class="a-right">
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
                          class="a-icon-btn<?= (int) $i['is_active'] === 1 ? ' a-icon-btn--danger' : '' ?>"
                          title="<?= (int) $i['is_active'] === 1 ? 'Deactivate' : 'Reactivate' ?>"
                          aria-label="<?= (int) $i['is_active'] === 1 ? 'Deactivate' : 'Reactivate' ?>">
                    <i class="fas <?= (int) $i['is_active'] === 1 ? 'fa-user-slash' : 'fa-user-check' ?>"></i>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; else: ?>
            <tr>
              <td colspan="7" class="a-empty">
                <?= $totalAll === 0 ? 'No interns have registered yet.' : 'No accounts match your search.' ?>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php if ($page['pages'] > 1): ?>
    <nav class="flex flex-wrap items-center justify-between gap-4 mt-5" aria-label="Pagination">
      <p class="s-num">
        Showing <?= (int) $page['from'] ?>–<?= (int) $page['to'] ?> of <?= (int) $page['total'] ?>
      </p>
      <div class="a-pager">
        <?php for ($p = 1; $p <= $page['pages']; $p++): ?>
          <a href="<?= Security::e(queryUrl('admin/interns', ['page' => $p])) ?>"
             class="<?= $p === $page['page'] ? 'is-current' : '' ?>"<?= $p === $page['page'] ? ' aria-current="page"' : '' ?>>
            <?= $p ?>
          </a>
        <?php endfor; ?>
      </div>
    </nav>
  <?php endif; ?>
</div>
