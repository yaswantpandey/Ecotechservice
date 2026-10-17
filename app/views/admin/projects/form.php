<?php
// ── ADMIN PROJECT FORM (add / edit) ─────────────────────────

$isEdit    = (bool)$project;
$formTitle = $isEdit ? 'Edit Project' : 'Add New Project';
$action    = url($isEdit ? 'admin/projects/update' : 'admin/projects/store');
$maxMb     = (int)round(MAX_FILE_SIZE / 1048576);
?>

<div id="adminProjectForm">

  <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div>
      <a href="<?= url('admin/projects') ?>" class="s-link text-sm">
        <i class="fas fa-arrow-left text-xs" aria-hidden="true"></i> Back to projects
      </a>
      <h2 class="s-h3 mt-2 mb-0"><?= $formTitle ?></h2>
      <p class="s-mute text-sm m-0">
        <?= $isEdit
              ? 'Update the details for this project entry.'
              : 'Add a new entry to the public projects list.' ?>
      </p>
    </div>
    <?php if ($isEdit && !empty($project['is_active'])): ?>
    <a href="<?= url('projects/view?slug=' . urlencode((string)$project['slug'])) ?>"
       target="_blank" rel="noopener" class="s-link text-sm">
      View on site <i class="fas fa-arrow-up-right-from-square text-[10px]" aria-hidden="true"></i>
    </a>
    <?php endif; ?>
  </div>

  <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
    <?= Security::csrfField() ?>
    <?php if ($isEdit): ?>
    <input type="hidden" name="id" value="<?= (int)$project['id'] ?>">
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

      <!-- ── Main fields ─────────────────────────────────────── -->
      <div class="lg:col-span-8 a-card a-card-pad">
        <p class="s-eyebrow mb-4">Project basics</p>

        <div class="a-form-grid">
          <div class="s-field">
            <label for="af_title" class="s-label">Title <span class="s-req">*</span></label>
            <input type="text" id="af_title" name="title" required
                   value="<?= Security::e($project['title'] ?? '') ?>"
                   class="s-input" placeholder="e.g. Pandey Reality Portal" autocomplete="off">
            <p class="s-help">URL slug: <b id="af_slug_preview" class="s-num"><?= Security::e($project['slug'] ?? '—') ?></b></p>
          </div>

          <div class="s-field">
            <label for="af_category" class="s-label">Category <span class="s-req">*</span></label>
            <select id="af_category" name="category" class="s-select">
              <?php foreach (['website','marketing','template','mobile','other'] as $cat): ?>
              <option value="<?= Security::e($cat) ?>" <?= (($project['category'] ?? '') === $cat) ? 'selected' : '' ?>>
                <?= Security::e(ucfirst($cat)) ?>
              </option>
              <?php endforeach; ?>
            </select>
            <p class="s-help">Controls which filter tab the project appears under.</p>
          </div>

          <div class="s-field a-span-2">
            <label for="af_description" class="s-label">Description <span class="s-req">*</span></label>
            <textarea id="af_description" name="description" required rows="5" class="s-textarea"
                      placeholder="What was built, for whom, and what problem it solved…"><?= Security::e($project['description'] ?? '') ?></textarea>
            <p class="s-help">
              The first ~110 characters appear on project cards and the first 155 in search results.
              <span id="af_desc_count" class="s-num"></span>
            </p>
          </div>

          <div class="s-field a-span-2">
            <label for="af_tech" class="s-label">Tech stack</label>
            <input type="text" id="af_tech" name="tech_stack"
                   value="<?= Security::e($project['tech_stack'] ?? '') ?>"
                   class="s-input" placeholder="PHP, MySQL, Tailwind CSS" autocomplete="off">
            <p class="s-help">Comma-separated. The first four are shown as chips on the card.</p>
          </div>
        </div>

        <p class="s-eyebrow mb-4">Links</p>
        <div class="a-form-grid">
          <div class="s-field">
            <label for="af_live" class="s-label">Live site URL</label>
            <input type="url" id="af_live" name="live_url"
                   value="<?= Security::e($project['live_url'] ?? '') ?>"
                   class="s-input" placeholder="https://example.com">
            <p class="s-help">If set, the card preview auto-generates a live screenshot of this URL.</p>
          </div>

          <div class="s-field">
            <label for="af_github" class="s-label">Repository URL</label>
            <input type="url" id="af_github" name="github_url"
                   value="<?= Security::e($project['github_url'] ?? '') ?>"
                   class="s-input" placeholder="https://github.com/...">
            <p class="s-help">Optional. Shown as a &ldquo;Source code&rdquo; button on the case study.</p>
          </div>
        </div>

        <div class="a-form-actions">
          <button type="submit" class="s-btn s-btn--sm">
            <i class="fas fa-save text-xs" aria-hidden="true"></i> <?= $isEdit ? 'Save changes' : 'Add project' ?>
          </button>
          <a href="<?= url('admin/projects') ?>" class="s-btn--line s-btn--sm">Cancel</a>
        </div>
      </div>

      <!-- ── Side column ─────────────────────────────────────── -->
      <div class="lg:col-span-4 space-y-5">
        <div class="a-card">
          <div class="a-card-head"><h2>Placement &amp; visibility</h2></div>
          <div class="a-card-pad">
            <div class="s-field">
              <label for="af_sort" class="s-label">Sort order</label>
              <input type="number" id="af_sort" name="sort_order" min="0" step="1"
                     value="<?= (int)($project['sort_order'] ?? 0) ?>" class="s-input">
              <p class="s-help">Lower numbers appear first.</p>
            </div>

            <label class="s-check mb-4" for="is_featured">
              <input type="checkbox" name="is_featured" id="is_featured" <?= !empty($project['is_featured']) ? 'checked' : '' ?>>
              <span>
                <span class="font-medium" style="color:var(--ink)">Featured</span>
                <span class="s-help block" style="margin-top:.1rem">Adds a featured badge on the card.</span>
              </span>
            </label>

            <label class="s-check" for="is_active">
              <input type="checkbox" name="is_active" id="is_active" <?= ($project['is_active'] ?? 1) ? 'checked' : '' ?>>
              <span>
                <span class="font-medium" style="color:var(--ink)">Visible</span>
                <span class="s-help block" style="margin-top:.1rem">Uncheck to hide from the public site.</span>
              </span>
            </label>
          </div>
        </div>

        <div class="a-card">
          <div class="a-card-head"><h2>Thumbnail</h2></div>
          <div class="a-card-pad">
            <?php if (empty($project['thumbnail'])): ?>
            <span id="af_preview_empty" class="a-preview flex items-center justify-center s-mute" style="margin:0 0 .75rem"><i class="fas fa-image" aria-hidden="true"></i></span>
            <?php endif; ?>

            <input type="file" id="af_thumb" name="thumbnail" accept="image/jpeg,image/png,image/webp,image/gif" class="text-sm block w-full"><?php if (!empty($project['thumbnail'])): ?><img id="af_preview" src="<?= Security::e(uploadUrl($project['thumbnail'])) ?>" class="a-preview" alt="Current thumbnail"><?php else: ?><img id="af_preview" src="" class="a-preview" alt="" hidden><?php endif; ?>

            <p class="s-help">
              JPEG, PNG, WebP, or GIF &middot; max <?= $maxMb ?> MB &middot; 16:10 crop recommended.
              <?= !empty($project['thumbnail']) ? 'Leave empty to keep the current image.' : '' ?>
            </p>
            <p id="af_thumb_error" class="s-help" style="color:var(--danger)" hidden></p>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
// ── Form helpers: slug preview, description counter, image preview ──
(function initProjectForm() {
  const titleEl = document.getElementById('af_title');
  const slugEl  = document.getElementById('af_slug_preview');
  const descEl  = document.getElementById('af_description');
  const countEl = document.getElementById('af_desc_count');
  const fileEl  = document.getElementById('af_thumb');
  const prevEl  = document.getElementById('af_preview');
  const emptyEl = document.getElementById('af_preview_empty');
  const errEl   = document.getElementById('af_thumb_error');
  const maxBytes = <?= (int)MAX_FILE_SIZE ?>;

  // Mirror the server-side slugify() in app/helpers/Helpers.php
  function slugify(text) {
    return text.toLowerCase().trim()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/[\s-]+/g, '-')
      .replace(/^-+|-+$/g, '');
  }

  if (titleEl && slugEl) {
    titleEl.addEventListener('input', () => {
      const slug = slugify(titleEl.value);
      slugEl.textContent = slug || '—';
    });
  }

  if (descEl && countEl) {
    const update = () => { countEl.textContent = `(${descEl.value.length} characters)`; };
    descEl.addEventListener('input', update);
    update();
  }

  if (fileEl && prevEl) {
    fileEl.addEventListener('change', () => {
      const file = fileEl.files && fileEl.files[0];
      if (errEl) { errEl.hidden = true; errEl.textContent = ''; }
      if (!file) return;

      if (file.size > maxBytes) {
        if (errEl) {
          errEl.textContent = `That file is ${(file.size / 1048576).toFixed(1)} MB, over the ${(maxBytes / 1048576).toFixed(0)} MB limit.`;
          errEl.hidden = false;
        }
        fileEl.value = '';
        return;
      }

      const url = URL.createObjectURL(file);
      prevEl.src = url;
      prevEl.hidden = false;
      prevEl.alt = 'Selected thumbnail preview';
      if (emptyEl) emptyEl.hidden = true;
      prevEl.addEventListener('load', () => URL.revokeObjectURL(url), { once: true });
    });
  }
})();
</script>
