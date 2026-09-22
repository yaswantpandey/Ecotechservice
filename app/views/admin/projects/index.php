<?php
// ── ADMIN PROJECTS LIST ─────────────────────────────────────

$total    = count($projects);
$active   = 0;
$featured = 0;
foreach ($projects as $p) {
    if (!empty($p['is_active']))   { $active++; }
    if (!empty($p['is_featured'])) { $featured++; }
}

$catIcons = [
    'website'   => 'fa-globe',
    'marketing' => 'fa-chart-bar',
    'template'  => 'fa-layer-group',
    'mobile'    => 'fa-mobile-alt',
    'other'     => 'fa-star',
];
?>

<style>
/* ==========================================================
   Admin projects list (scoped to #adminProjects)
   ========================================================== */
#adminProjects { --ap-line: rgba(148, 163, 184, 0.14); --ap-line-str: rgba(148, 163, 184, 0.26); }

#adminProjects .ap-head-title {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-size: 1.375rem; font-weight: 700; color: #fff; letter-spacing: -0.02em; margin: 0;
}
#adminProjects .ap-sub { font-size: 0.8125rem; color: #94a3b8; margin-top: 0.25rem; }

/* Summary chips */
#adminProjects .ap-chips { display: flex; flex-wrap: wrap; gap: 0.5rem; }
#adminProjects .ap-chip {
  display: inline-flex; align-items: center; gap: 0.5rem;
  font-size: 0.75rem; font-weight: 600; color: #cbd5e1;
  padding: 0.375rem 0.75rem; border-radius: 0.5rem;
  background: rgba(2, 6, 23, 0.6); border: 1px solid var(--ap-line);
}
#adminProjects .ap-chip b {
  font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  color: #fff; font-weight: 700;
}

/* Toolbar */
#adminProjects .ap-toolbar {
  display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem;
  padding: 0.875rem 1rem; border-bottom: 1px solid var(--ap-line);
}
#adminProjects .ap-search {
  position: relative; flex: 1 1 16rem; min-width: 12rem;
}
#adminProjects .ap-search i {
  position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%);
  color: #64748b; font-size: 0.75rem; pointer-events: none;
}
#adminProjects .ap-search input {
  width: 100%; font-size: 0.8125rem; color: #e2e8f0;
  background: #020617; border: 1px solid var(--ap-line);
  border-radius: 0.5rem; padding: 0.5rem 0.75rem 0.5rem 2rem;
  transition: border-color .2s ease, box-shadow .2s ease;
}
#adminProjects .ap-search input::placeholder { color: #475569; }
#adminProjects .ap-search input:focus {
  outline: none; border-color: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,0.15);
}
#adminProjects .ap-select {
  font-size: 0.8125rem; color: #e2e8f0; background: #020617;
  border: 1px solid var(--ap-line); border-radius: 0.5rem; padding: 0.5rem 0.75rem;
}
#adminProjects .ap-select:focus { outline: none; border-color: #22c55e; }
#adminProjects .ap-select option { background: #0f172a; }

/* Table shell */
#adminProjects .ap-panel {
  background: rgba(15, 23, 42, 0.55); border: 1px solid var(--ap-line);
  border-radius: 0.875rem; overflow: hidden;
}
#adminProjects table { width: 100%; border-collapse: collapse; font-size: 0.8125rem; min-width: 52rem; }
#adminProjects thead th {
  text-align: left; padding: 0.75rem 1rem;
  font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.08em;
  text-transform: uppercase; color: #64748b;
  border-bottom: 1px solid var(--ap-line); white-space: nowrap;
}
#adminProjects tbody td { padding: 0.75rem 1rem; vertical-align: middle; }
#adminProjects tbody tr { border-bottom: 1px solid var(--ap-line); transition: background-color .15s ease; }
#adminProjects tbody tr:last-child { border-bottom: 0; }
#adminProjects tbody tr:hover { background: rgba(2, 6, 23, 0.5); }

#adminProjects .ap-thumb {
  width: 3.5rem; height: 2.25rem; border-radius: 0.375rem; object-fit: cover;
  background: #020617; border: 1px solid var(--ap-line); display: block;
}
#adminProjects .ap-thumb-empty {
  width: 3.5rem; height: 2.25rem; border-radius: 0.375rem;
  display: flex; align-items: center; justify-content: center;
  background: #020617; border: 1px solid var(--ap-line); color: #475569; font-size: 0.6875rem;
}
#adminProjects .ap-title { color: #f1f5f9; font-weight: 600; }
#adminProjects .ap-slug {
  font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  font-size: 0.6875rem; color: #64748b; margin-top: 0.125rem;
}
#adminProjects .ap-cat {
  display: inline-flex; align-items: center; gap: 0.375rem;
  font-size: 0.6875rem; font-weight: 600; color: #cbd5e1;
  background: #020617; border: 1px solid var(--ap-line);
  padding: 0.1875rem 0.5rem; border-radius: 0.375rem; white-space: nowrap;
}
#adminProjects .ap-badge {
  display: inline-flex; align-items: center; gap: 0.375rem;
  font-size: 0.6875rem; font-weight: 600;
  padding: 0.1875rem 0.5rem; border-radius: 0.375rem; white-space: nowrap;
}
#adminProjects .ap-badge--on  { color: #4ade80; background: rgba(34,197,94,0.12); border: 1px solid rgba(34,197,94,0.28); }
#adminProjects .ap-badge--off { color: #94a3b8; background: rgba(148,163,184,0.1); border: 1px solid var(--ap-line); }
#adminProjects .ap-order {
  font-family: ui-monospace, SFMono-Regular, Menlo, monospace; color: #94a3b8;
}

#adminProjects .ap-actions { display: flex; align-items: center; gap: 0.25rem; justify-content: flex-end; }
#adminProjects .ap-act {
  width: 2rem; height: 2rem; border-radius: 0.375rem;
  display: inline-flex; align-items: center; justify-content: center;
  font-size: 0.75rem; color: #94a3b8; background: transparent;
  border: 1px solid transparent; cursor: pointer;
  transition: color .15s ease, background-color .15s ease, border-color .15s ease;
}
#adminProjects .ap-act:hover { background: rgba(2,6,23,0.7); border-color: var(--ap-line); }
#adminProjects .ap-act--view:hover { color: #e2e8f0; }
#adminProjects .ap-act--edit:hover { color: #60a5fa; }
#adminProjects .ap-act--del:hover  { color: #f87171; border-color: rgba(248,113,113,0.35); }

#adminProjects .ap-empty { text-align: center; padding: 3.5rem 1.5rem; color: #64748b; }
#adminProjects .ap-empty-icon {
  width: 3rem; height: 3rem; border-radius: 0.75rem; margin: 0 auto 1rem;
  display: flex; align-items: center; justify-content: center;
  background: rgba(148,163,184,0.08); border: 1px solid var(--ap-line); color: #64748b;
}
#adminProjects tr[hidden] { display: none; }
</style>

<div id="adminProjects" class="pt-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-6">
    <div>
      <h2 class="ap-head-title">Projects</h2>
      <p class="ap-sub">Manage Projectntries shown on the public site.</p>
    </div>
    <a href="<?= url('admin/projects/add') ?>" class="btn-primary text-sm py-2 shrink-0">
      <i class="fas fa-plus mr-2 text-xs"></i>Add Project
    </a>
  </div>

  <!-- Summary -->
  <div class="ap-chips mb-5">
    <span class="ap-chip"><i class="fas fa-layer-group text-slate-500 text-[10px]"></i>Total <b><?= $total ?></b></span>
    <span class="ap-chip"><i class="fas fa-eye text-eco-400 text-[10px]"></i>Visible <b><?= $active ?></b></span>
    <span class="ap-chip"><i class="fas fa-eye-slash text-slate-500 text-[10px]"></i>Hidden <b><?= $total - $active ?></b></span>
    <span class="ap-chip"><i class="fas fa-star text-amber-400 text-[10px]"></i>Featured <b><?= $featured ?></b></span>
  </div>

  <div class="ap-panel">

    <?php if ($projects): ?>
    <!-- Toolbar: client-side filtering of the rows already on the page -->
    <div class="ap-toolbar">
      <div class="ap-search">
        <i class="fas fa-search"></i>
        <input type="search" id="apSearch" placeholder="Search by title, slug, or tech stack…" autocomplete="off" aria-label="Search projects">
      </div>
      <select id="apCategory" class="ap-select" aria-label="Filter by category">
        <option value="">All categories</option>
        <?php foreach (['website','marketing','template','mobile','other'] as $c): ?>
        <option value="<?= Security::e($c) ?>"><?= Security::e(ucfirst($c)) ?></option>
        <?php endforeach; ?>
      </select>
      <select id="apStatus" class="ap-select" aria-label="Filter by status">
        <option value="">Any status</option>
        <option value="1">Visible</option>
        <option value="0">Hidden</option>
      </select>
      <span id="apCount" class="text-xs text-slate-500 ml-auto shrink-0"></span>
    </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
      <table>
        <thead>
          <tr>
            <th style="width:4.5rem">Preview</th>
            <th>Title</th>
            <th>Category</th>
            <th style="width:5rem">Order</th>
            <th style="width:6rem">Featured</th>
            <th style="width:6rem">Status</th>
            <th style="width:8rem" class="text-right">Actions</th>
          </tr>
        </thead>
        <tbody id="apRows">
          <?php if ($projects): foreach ($projects as $p):
            $hasThumb = !empty($p['thumbnail']);
            $haystack = strtolower(trim(
                ($p['title'] ?? '') . ' ' . ($p['slug'] ?? '') . ' ' . ($p['tech_stack'] ?? '')
            ));
          ?>
          <tr data-search="<?= Security::e($haystack) ?>"
              data-category="<?= Security::e((string)$p['category']) ?>"
              data-status="<?= !empty($p['is_active']) ? '1' : '0' ?>">

            <td>
              <?php if ($hasThumb): ?>
              <img src="<?= Security::e(uploadUrl($p['thumbnail'])) ?>" class="ap-thumb" alt="" loading="lazy">
              <?php else: ?>
              <span class="ap-thumb-empty"><i class="fas fa-image"></i></span>
              <?php endif; ?>
            </td>

            <td>
              <div class="ap-title"><?= Security::e($p['title']) ?></div>
              <div class="ap-slug">/<?= Security::e((string)$p['slug']) ?></div>
            </td>

            <td>
              <span class="ap-cat">
                <i class="fas <?= Security::e($catIcons[$p['category']] ?? 'fa-star') ?> text-[9px]"></i>
                <?= Security::e(ucfirst((string)$p['category'])) ?>
              </span>
            </td>

            <td class="ap-order"><?= (int)($p['sort_order'] ?? 0) ?></td>

            <td>
              <?php if (!empty($p['is_featured'])): ?>
              <i class="fas fa-star text-amber-400 text-sm" title="Featured"></i>
              <?php else: ?>
              <i class="far fa-star text-slate-600 text-sm" title="Not featured"></i>
              <?php endif; ?>
            </td>

            <td>
              <span class="ap-badge <?= !empty($p['is_active']) ? 'ap-badge--on' : 'ap-badge--off' ?>">
                <?= !empty($p['is_active']) ? 'Visible' : 'Hidden' ?>
              </span>
            </td>

            <td>
              <div class="ap-actions">
                <?php if (!empty($p['is_active'])): ?>
                <a href="<?= url('projects/view?slug=' . urlencode((string)$p['slug'])) ?>"
                   target="_blank" rel="noopener"
                   class="ap-act ap-act--view" title="View on site" aria-label="View on site">
                  <i class="fas fa-arrow-up-right-from-square"></i>
                </a>
                <?php endif; ?>

                <a href="<?= url('admin/projects/edit?id=' . (int)$p['id']) ?>"
                   class="ap-act ap-act--edit" title="Edit" aria-label="Edit project">
                  <i class="fas fa-pen"></i>
                </a>

                <!-- Deletion goes through POST + CSRF -->
                <form action="<?= url('admin/projects/delete') ?>" method="POST" class="inline"
                      onsubmit="return confirm('Delete &quot;<?= Security::e(addslashes($p['title'])) ?>&quot;? This cannot be undone.');">
                  <?= Security::csrfField() ?>
                  <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                  <button type="submit" class="ap-act ap-act--del" title="Delete" aria-label="Delete project">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          <?php endforeach; else: ?>
          <tr>
            <td colspan="7">
              <div class="ap-empty">
                <div class="ap-empty-icon"><i class="fas fa-folder-open"></i></div>
                <p class="text-slate-300 text-sm font-medium mb-1">No projects yet</p>
                <p class="text-xs text-slate-500 mb-5">Add your first Projectntry to show it on the public site.</p>
                <a href="<?= url('admin/projects/add') ?>" class="btn-primary text-xs py-2 px-4">
                  <i class="fas fa-plus mr-1.5"></i>Add Project
                </a>
              </div>
            </td>
          </tr>
          <?php endif; ?>

          <tr id="apNoMatch" hidden>
            <td colspan="7">
              <div class="ap-empty">
                <div class="ap-empty-icon"><i class="fas fa-filter"></i></div>
                <p class="text-slate-300 text-sm font-medium mb-1">No matching projects</p>
                <p class="text-xs text-slate-500">Try a different search term or clear the filters.</p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
// ── Client-side search / filter over the rendered rows ──────
(function initProjectFilters() {
  const search  = document.getElementById('apSearch');
  const catSel  = document.getElementById('apCategory');
  const statSel = document.getElementById('apStatus');
  const countEl = document.getElementById('apCount');
  const noMatch = document.getElementById('apNoMatch');
  if (!search || !catSel || !statSel) return;

  const rows = Array.from(document.querySelectorAll('#apRows tr[data-search]'));
  if (!rows.length) return;

  function apply() {
    const term = search.value.trim().toLowerCase();
    const cat  = catSel.value;
    const stat = statSel.value;
    let visible = 0;

    rows.forEach(row => {
      const matches =
        (term === '' || row.dataset.search.includes(term)) &&
        (cat  === '' || row.dataset.category === cat) &&
        (stat === '' || row.dataset.status === stat);
      row.hidden = !matches;
      if (matches) visible++;
    });

    if (noMatch) noMatch.hidden = visible !== 0;
    if (countEl) {
      countEl.textContent = visible === rows.length
        ? `${rows.length} project${rows.length === 1 ? '' : 's'}`
        : `${visible} of ${rows.length} shown`;
    }
  }

  search.addEventListener('input', apply);
  catSel.addEventListener('change', apply);
  statSel.addEventListener('change', apply);
  apply();
})();
</script>
