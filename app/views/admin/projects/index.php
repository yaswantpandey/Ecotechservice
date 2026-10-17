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

<div id="adminProjects">

  <!-- Summary -->
  <div class="a-stats mb-6">
    <div class="a-stat"><b><?= $total ?></b><span>Total</span></div>
    <div class="a-stat"><b><?= $active ?></b><span>Visible</span></div>
    <div class="a-stat"><b><?= $total - $active ?></b><span>Hidden</span></div>
    <div class="a-stat"><b><?= $featured ?></b><span>Featured</span></div>
  </div>

  <div class="a-card">
    <div class="a-card-head">
      <div>
        <h2>Projects</h2>
        <p class="s-mute text-sm m-0">Manage project entries shown on the public site.</p>
      </div>
      <a href="<?= url('admin/projects/add') ?>" class="s-btn s-btn--sm">
        <i class="fas fa-plus text-xs" aria-hidden="true"></i> Add project
      </a>
    </div>

    <?php if ($projects): ?>
    <!-- Toolbar: client-side filtering of the rows already on the page -->
    <div class="a-toolbar a-card-pad" style="margin-bottom:0;border-bottom:1px solid var(--rule)">
      <div class="a-toolbar-filters" style="flex:1">
        <input type="search" id="apSearch" class="s-input" style="max-width:22rem" placeholder="Search by title, slug, or tech stack…" autocomplete="off" aria-label="Search projects">
        <select id="apCategory" class="s-select" style="width:auto" aria-label="Filter by category">
          <option value="">All categories</option>
          <?php foreach (['website','marketing','template','mobile','other'] as $c): ?>
          <option value="<?= Security::e($c) ?>"><?= Security::e(ucfirst($c)) ?></option>
          <?php endforeach; ?>
        </select>
        <select id="apStatus" class="s-select" style="width:auto" aria-label="Filter by status">
          <option value="">Any status</option>
          <option value="1">Visible</option>
          <option value="0">Hidden</option>
        </select>
      </div>
      <span id="apCount" class="s-num"></span>
    </div>
    <?php endif; ?>

    <div class="a-table-wrap">
      <table class="a-table">
        <thead>
          <tr>
            <th style="width:5rem">Preview</th>
            <th>Title</th>
            <th>Category</th>
            <th style="width:5rem">Order</th>
            <th style="width:6rem">Featured</th>
            <th style="width:6rem">Status</th>
            <th style="width:9rem" class="a-right">Actions</th>
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
              <img src="<?= Security::e(uploadUrl($p['thumbnail'])) ?>" class="a-thumb" alt="" loading="lazy">
              <?php else: ?>
              <span class="a-thumb flex items-center justify-center s-mute text-xs"><i class="fas fa-image" aria-hidden="true"></i></span>
              <?php endif; ?>
            </td>

            <td>
              <div class="font-medium"><?= Security::e($p['title']) ?></div>
              <div class="s-num" style="font-size:.7rem">/<?= Security::e((string)$p['slug']) ?></div>
            </td>

            <td>
              <span class="s-tag">
                <i class="fas <?= Security::e($catIcons[$p['category']] ?? 'fa-star') ?> text-[9px]" aria-hidden="true"></i>
                <?= Security::e(ucfirst((string)$p['category'])) ?>
              </span>
            </td>

            <td class="s-num"><?= (int)($p['sort_order'] ?? 0) ?></td>

            <td>
              <?php if (!empty($p['is_featured'])): ?>
              <span class="s-tag s-tag--solid" title="Featured">Featured</span>
              <?php else: ?>
              <span class="s-mute" title="Not featured">—</span>
              <?php endif; ?>
            </td>

            <td>
              <span class="s-tag <?= !empty($p['is_active']) ? 's-tag--signal' : 's-tag--mute' ?>">
                <?= !empty($p['is_active']) ? 'Visible' : 'Hidden' ?>
              </span>
            </td>

            <td class="a-right">
              <div class="a-row-actions">
                <?php if (!empty($p['is_active'])): ?>
                <a href="<?= url('projects/view?slug=' . urlencode((string)$p['slug'])) ?>"
                   target="_blank" rel="noopener"
                   class="a-icon-btn" title="View on site" aria-label="View on site">
                  <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i>
                </a>
                <?php endif; ?>

                <a href="<?= url('admin/projects/edit?id=' . (int)$p['id']) ?>"
                   class="a-icon-btn" title="Edit" aria-label="Edit project">
                  <i class="fas fa-pen" aria-hidden="true"></i>
                </a>

                <!-- Deletion goes through POST + CSRF -->
                <form action="<?= url('admin/projects/delete') ?>" method="POST" class="inline"
                      onsubmit="return confirm('Delete &quot;<?= Security::e(addslashes($p['title'])) ?>&quot;? This cannot be undone.');">
                  <?= Security::csrfField() ?>
                  <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                  <button type="submit" class="a-icon-btn a-icon-btn--danger" title="Delete" aria-label="Delete project">
                    <i class="fas fa-trash" aria-hidden="true"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          <?php endforeach; else: ?>
          <tr>
            <td colspan="7">
              <div class="a-empty">
                <p class="font-medium mb-1" style="color:var(--ink)">No projects yet</p>
                <p class="text-sm mb-5">Add your first project entry to show it on the public site.</p>
                <a href="<?= url('admin/projects/add') ?>" class="s-btn s-btn--sm">
                  <i class="fas fa-plus text-xs" aria-hidden="true"></i> Add project
                </a>
              </div>
            </td>
          </tr>
          <?php endif; ?>

          <tr id="apNoMatch" hidden>
            <td colspan="7">
              <div class="a-empty">
                <p class="font-medium mb-1" style="color:var(--ink)">No matching projects</p>
                <p class="text-sm">Try a different search term or clear the filters.</p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>#adminProjects tr[hidden] { display: none; }</style>

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
