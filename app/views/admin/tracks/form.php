<?php // ── ADMIN — TRACK ADD / EDIT FORM ────────────────────────── ?>

<div class="pt-6 max-w-3xl">
  <a href="<?= url('admin/tracks') ?>" class="text-gray-400 hover:text-white text-sm transition">
    <i class="fas fa-arrow-left mr-1"></i>Back to tracks
  </a>

  <h2 class="font-display font-semibold text-white text-xl mt-4 mb-6">
    <?= $track ? 'Edit ' . Security::e($track['title']) : 'Add Internship Track' ?>
  </h2>

  <form action="<?= url($track ? 'admin/tracks/update' : 'admin/tracks/store') ?>" method="POST"
        class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-5">
    <?= Security::csrfField() ?>
    <?php if ($track): ?>
      <input type="hidden" name="id" value="<?= (int) $track['id'] ?>">
    <?php endif; ?>

    <div>
      <label for="title" class="form-label">Track Title *</label>
      <input type="text" id="title" name="title" required maxlength="150"
             value="<?= Security::e($track['title'] ?? '') ?>" class="form-input"
             placeholder="e.g. Full Stack Development">
    </div>

    <div>
      <label for="short_desc" class="form-label">Short Description * <span class="text-gray-500">(shown on cards, max 255)</span></label>
      <textarea id="short_desc" name="short_desc" rows="2" required maxlength="255"
                class="form-input resize-y"
                placeholder="One sentence summarising the track."><?= Security::e($track['short_desc'] ?? '') ?></textarea>
    </div>

    <div>
      <label for="description" class="form-label">Full Description *</label>
      <textarea id="description" name="description" rows="6" required
                class="form-input resize-y"
                placeholder="What the intern will actually do, learn and deliver."><?= Security::e($track['description'] ?? '') ?></textarea>
    </div>

    <div>
      <label for="skills" class="form-label">Skills <span class="text-gray-500">(comma separated)</span></label>
      <input type="text" id="skills" name="skills" maxlength="500"
             value="<?= Security::e($track['skills'] ?? '') ?>" class="form-input"
             placeholder="HTML, CSS, JavaScript, MySQL, Git">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
      <div>
        <label for="icon" class="form-label">Font Awesome Icon *</label>
        <input type="text" id="icon" name="icon" required pattern="fa-[a-z0-9\-]+"
               value="<?= Security::e($track['icon'] ?? 'fa-code') ?>" class="form-input"
               placeholder="fa-code">
        <p class="text-gray-600 text-[11px] mt-1.5">Lowercase, starting with <code>fa-</code>, e.g. fa-shield-halved</p>
      </div>

      <div>
        <label for="mode" class="form-label">Work Mode</label>
        <input type="text" id="mode" name="mode" maxlength="40"
               value="<?= Security::e($track['mode'] ?? 'Remote / Hybrid') ?>" class="form-input">
      </div>

      <div>
        <label for="duration_weeks" class="form-label">Duration (weeks)</label>
        <input type="number" id="duration_weeks" name="duration_weeks" min="1" max="104"
               value="<?= (int) ($track['duration_weeks'] ?? 8) ?>" class="form-input">
      </div>

      <div>
        <label for="seats" class="form-label">Seats</label>
        <input type="number" id="seats" name="seats" min="0" max="9999"
               value="<?= (int) ($track['seats'] ?? 10) ?>" class="form-input">
      </div>

      <div>
        <label for="stipend_text" class="form-label">Stipend Text</label>
        <input type="text" id="stipend_text" name="stipend_text" maxlength="120"
               value="<?= Security::e($track['stipend_text'] ?? 'Performance based') ?>" class="form-input">
      </div>

      <div>
        <label for="sort_order" class="form-label">Sort Order</label>
        <input type="number" id="sort_order" name="sort_order"
               value="<?= (int) ($track['sort_order'] ?? 0) ?>" class="form-input">
      </div>
    </div>

    <label class="flex items-center gap-3 cursor-pointer pt-2">
      <input type="checkbox" name="is_active" value="1"
             <?= (!$track || (int) $track['is_active'] === 1) ? 'checked' : '' ?>
             class="w-4 h-4 rounded border-gray-600 bg-gray-950 text-eco-500 focus:ring-eco-500/40">
      <span class="text-gray-300 text-sm">
        Active
        <span class="block text-gray-500 text-xs">Unchecked tracks are hidden from the public listing.</span>
      </span>
    </label>

    <div class="flex gap-3 pt-2 border-t border-gray-800">
      <button type="submit" class="btn-primary">
        <i class="fas fa-save mr-2"></i><?= $track ? 'Update Track' : 'Add Track' ?>
      </button>
      <a href="<?= url('admin/tracks') ?>" class="btn-outline">Cancel</a>
    </div>
  </form>
</div>
