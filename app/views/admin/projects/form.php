<?php
// ── ADMIN PROJECT FORM (add / edit) ─────────────────────────

$isEdit    = (bool)$project;
$formTitle = $isEdit ? 'Edit Project' : 'Add New Project';
$action    = url($isEdit ? 'admin/projects/update' : 'admin/projects/store');
$maxMb     = (int)round(MAX_FILE_SIZE / 1048576);
?>

<style>
/* ==========================================================
   Admin project form (scoped to #adminProjectForm)
   ========================================================== */
#adminProjectForm { --af-line: rgba(148, 163, 184, 0.14); --af-line-str: rgba(148, 163, 184, 0.26); }

#adminProjectForm .af-title {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-size: 1.375rem; font-weight: 700; color: #fff; letter-spacing: -0.02em; margin: 0;
}
#adminProjectForm .af-sub { font-size: 0.8125rem; color: #94a3b8; margin-top: 0.25rem; }

#adminProjectForm .af-card {
  background: rgba(15, 23, 42, 0.55); border: 1px solid var(--af-line);
  border-radius: 0.875rem; overflow: hidden;
}
#adminProjectForm .af-section { padding: 1.5rem; }
#adminProjectForm .af-section + .af-section { border-top: 1px solid var(--af-line); }
#adminProjectForm .af-legend {
  font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.1em;
  text-transform: uppercase; color: #64748b; margin: 0 0 1.25rem;
  display: flex; align-items: center; gap: 0.5rem;
}
#adminProjectForm .af-legend::before {
  content: ''; width: 1rem; height: 1px; background: #22c55e;
}

#adminProjectForm .af-label {
  display: block; font-size: 0.8125rem; font-weight: 500;
  color: #cbd5e1; margin-bottom: 0.4375rem;
}
#adminProjectForm .af-req { color: #4ade80; margin-left: 0.125rem; }
#adminProjectForm .af-hint { font-size: 0.6875rem; color: #64748b; margin-top: 0.4375rem; line-height: 1.5; }

#adminProjectForm .af-input {
  width: 100%; font-size: 0.875rem; color: #e2e8f0;
  background: #020617; border: 1px solid var(--af-line);
  border-radius: 0.5rem; padding: 0.625rem 0.75rem;
  transition: border-color .2s ease, box-shadow .2s ease;
}
#adminProjectForm .af-input::placeholder { color: #475569; }
#adminProjectForm .af-input:focus {
  outline: none; border-color: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,0.15);
}
#adminProjectForm textarea.af-input { resize: vertical; min-height: 7rem; line-height: 1.7; }
#adminProjectForm select.af-input option { background: #0f172a; }

/* Slug preview */
#adminProjectForm .af-slug {
  font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  font-size: 0.6875rem; color: #64748b; margin-top: 0.4375rem;
}
#adminProjectForm .af-slug b { color: #4ade80; font-weight: 600; }

/* Thumbnail dropzone */
#adminProjectForm .af-drop {
  display: flex; align-items: center; gap: 1rem;
  padding: 1rem; border: 1px dashed var(--af-line-str);
  border-radius: 0.625rem; background: rgba(2, 6, 23, 0.5);
}
#adminProjectForm .af-preview {
  width: 6rem; height: 4rem; border-radius: 0.5rem; object-fit: cover;
  background: #020617; border: 1px solid var(--af-line); flex-shrink: 0; display: block;
}
#adminProjectForm .af-preview-empty {
  width: 6rem; height: 4rem; border-radius: 0.5rem; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  background: #020617; border: 1px solid var(--af-line); color: #475569;
}
#adminProjectForm .af-file {
  font-size: 0.8125rem; color: #cbd5e1;
}
#adminProjectForm .af-file::file-selector-button {
  font-size: 0.75rem; font-weight: 600; color: #cbd5e1; cursor: pointer;
  background: rgba(148,163,184,0.1); border: 1px solid var(--af-line);
  border-radius: 0.375rem; padding: 0.375rem 0.75rem; margin-right: 0.75rem;
  transition: color .2s ease, border-color .2s ease;
}
#adminProjectForm .af-file::file-selector-button:hover { color: #fff; border-color: var(--af-line-str); }

/* Toggle rows */
#adminProjectForm .af-toggle {
  display: flex; align-items: flex-start; gap: 0.75rem;
  padding: 0.875rem 1rem; border: 1px solid var(--af-line);
  border-radius: 0.625rem; background: rgba(2, 6, 23, 0.5);
  cursor: pointer; transition: border-color .2s ease;
}
#adminProjectForm .af-toggle:hover { border-color: var(--af-line-str); }
#adminProjectForm .af-toggle input { width: 1rem; height: 1rem; accent-color: #22c55e; margin-top: 0.125rem; flex-shrink: 0; }
#adminProjectForm .af-toggle-title { font-size: 0.8125rem; font-weight: 600; color: #e2e8f0; }
#adminProjectForm .af-toggle-desc { font-size: 0.6875rem; color: #64748b; margin-top: 0.1875rem; line-height: 1.5; }

#adminProjectForm .af-footer {
  display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem;
  padding: 1.25rem 1.5rem; border-top: 1px solid var(--af-line);
  background: rgba(2, 6, 23, 0.4);
}
</style>

<div id="adminProjectForm" class="pt-6 max-w-3xl">

  <!-- Header -->
  <div class="flex items-center gap-4 mb-6">
    <a href="<?= url('admin/projects') ?>"
       class="w-9 h-9 rounded-lg border border-slate-800 text-slate-400 hover:text-white hover:border-slate-700 flex items-center justify-center transition-colors shrink-0"
       title="Back to projects" aria-label="Back to projects">
      <i class="fas fa-arrow-left text-xs"></i>
    </a>
    <div>
      <h2 class="af-title"><?= $formTitle ?></h2>
      <p class="af-sub">
        <?= $isEdit
              ? 'Update the details for this portfolio entry.'
              : 'Add a new entry to the public portfolio.' ?>
      </p>
    </div>
  </div>

  <form action="<?= $action ?>" method="POST" enctype="multipart/form-data" class="af-card">
    <?= Security::csrfField() ?>
    <?php if ($isEdit): ?>
    <input type="hidden" name="id" value="<?= (int)$project['id'] ?>">
    <?php endif; ?>

    <!-- ── Basics ──────────────────────────────────────────── -->
    <div class="af-section">
      <h3 class="af-legend">Project basics</h3>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
          <label for="af_title" class="af-label">Title <span class="af-req">*</span></label>
          <input type="text" id="af_title" name="title" required
                 value="<?= Security::e($project['title'] ?? '') ?>"
                 class="af-input" placeholder="e.g. Pandey Reality Portal" autocomplete="off">
          <div class="af-slug">URL slug: <b id="af_slug_preview"><?= Security::e($project['slug'] ?? '—') ?></b></div>
        </div>

        <div>
          <label for="af_category" class="af-label">Category <span class="af-req">*</span></label>
          <select id="af_category" name="category" class="af-input">
            <?php foreach (['website','marketing','template','mobile','other'] as $cat): ?>
            <option value="<?= Security::e($cat) ?>" <?= (($project['category'] ?? '') === $cat) ? 'selected' : '' ?>>
              <?= Security::e(ucfirst($cat)) ?>
            </option>
            <?php endforeach; ?>
          </select>
          <p class="af-hint">Controls which filter tab the project appears under.</p>
        </div>
      </div>

      <div class="mt-5">
        <label for="af_description" class="af-label">Description <span class="af-req">*</span></label>
        <textarea id="af_description" name="description" required rows="5" class="af-input"
                  placeholder="What was built, for whom, and what problem it solved…"><?= Security::e($project['description'] ?? '') ?></textarea>
        <p class="af-hint">
          The first ~110 characters appear on portfolio cards and the first 155 in search results.
          <span id="af_desc_count" class="text-slate-500"></span>
        </p>
      </div>

      <div class="mt-5">
        <label for="af_tech" class="af-label">Tech stack</label>
        <input type="text" id="af_tech" name="tech_stack"
               value="<?= Security::e($project['tech_stack'] ?? '') ?>"
               class="af-input" placeholder="PHP, MySQL, Tailwind CSS" autocomplete="off">
        <p class="af-hint">Comma-separated. The first four are shown as chips on the card.</p>
      </div>
    </div>

    <!-- ── Links ───────────────────────────────────────────── -->
    <div class="af-section">
      <h3 class="af-legend">Links</h3>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
          <label for="af_live" class="af-label">Live site URL</label>
          <input type="url" id="af_live" name="live_url"
                 value="<?= Security::e($project['live_url'] ?? '') ?>"
                 class="af-input" placeholder="https://example.com">
          <p class="af-hint">If set, the card preview auto-generates a live screenshot of this URL.</p>
        </div>

        <div>
          <label for="af_github" class="af-label">Repository URL</label>
          <input type="url" id="af_github" name="github_url"
                 value="<?= Security::e($project['github_url'] ?? '') ?>"
                 class="af-input" placeholder="https://github.com/...">
          <p class="af-hint">Optional. Shown as a &ldquo;Source code&rdquo; button on the case study.</p>
        </div>
      </div>
    </div>

    <!-- ── Thumbnail ───────────────────────────────────────── -->
    <div class="af-section">
      <h3 class="af-legend">Thumbnail</h3>

      <div class="af-drop">
        <?php if (!empty($project['thumbnail'])): ?>
        <img id="af_preview" src="<?= Security::e(uploadUrl($project['thumbnail'])) ?>" class="af-preview" alt="Current thumbnail">
        <?php else: ?>
        <img id="af_preview" src="" class="af-preview" alt="" hidden>
        <span id="af_preview_empty" class="af-preview-empty"><i class="fas fa-image"></i></span>
        <?php endif; ?>

        <div class="min-w-0">
          <input type="file" id="af_thumb" name="thumbnail" accept="image/jpeg,image/png,image/webp,image/gif" class="af-file">
          <p class="af-hint">
            JPEG, PNG, WebP, or GIF &middot; max <?= $maxMb ?> MB &middot; 16:10 crop recommended.
            <?= !empty($project['thumbnail']) ? 'Leave empty to keep the current image.' : '' ?>
          </p>
          <p id="af_thumb_error" class="af-hint" style="color:#f87171" hidden></p>
        </div>
      </div>
    </div>

    <!-- ── Visibility ──────────────────────────────────────── -->
    <div class="af-section">
      <h3 class="af-legend">Placement &amp; visibility</h3>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div>
          <label for="af_sort" class="af-label">Sort order</label>
          <input type="number" id="af_sort" name="sort_order" min="0" step="1"
                 value="<?= (int)($project['sort_order'] ?? 0) ?>" class="af-input">
          <p class="af-hint">Lower numbers appear first.</p>
        </div>

        <label class="af-toggle sm:mt-7" for="is_featured">
          <input type="checkbox" name="is_featured" id="is_featured" <?= !empty($project['is_featured']) ? 'checked' : '' ?>>
          <span>
            <span class="af-toggle-title">Featured</span>
            <span class="af-toggle-desc">Adds a star badge on the card.</span>
          </span>
        </label>

        <label class="af-toggle sm:mt-7" for="is_active">
          <input type="checkbox" name="is_active" id="is_active" <?= ($project['is_active'] ?? 1) ? 'checked' : '' ?>>
          <span>
            <span class="af-toggle-title">Visible</span>
            <span class="af-toggle-desc">Uncheck to hide from the public site.</span>
          </span>
        </label>
      </div>
    </div>

    <!-- ── Actions ─────────────────────────────────────────── -->
    <div class="af-footer">
      <button type="submit" class="btn-primary text-sm py-2.5 px-6">
        <i class="fas fa-save mr-2 text-xs"></i><?= $isEdit ? 'Save changes' : 'Add project' ?>
      </button>
      <a href="<?= url('admin/projects') ?>" class="btn-outline text-sm py-2.5 px-5">Cancel</a>

      <?php if ($isEdit && !empty($project['is_active'])): ?>
      <a href="<?= url('projects/view?slug=' . urlencode((string)$project['slug'])) ?>"
         target="_blank" rel="noopener"
         class="text-xs font-semibold text-slate-400 hover:text-white transition-colors ml-auto inline-flex items-center gap-1.5">
        <span>View on site</span>
        <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
      </a>
      <?php endif; ?>
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
