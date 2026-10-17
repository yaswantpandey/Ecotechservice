<?php // ── ADMIN — TRACK ADD / EDIT FORM ────────────────────────── ?>

<div>
  <div class="mb-5">
    <a href="<?= url('admin/tracks') ?>" class="s-link text-sm">
      <i class="fas fa-arrow-left text-xs" aria-hidden="true"></i> Back to tracks
    </a>
    <h2 class="s-h3 mt-2 mb-0">
      <?= $track ? 'Edit ' . Security::e($track['title']) : 'Add Internship Track' ?>
    </h2>
  </div>

  <form action="<?= url($track ? 'admin/tracks/update' : 'admin/tracks/store') ?>" method="POST">
    <?= Security::csrfField() ?>
    <?php if ($track): ?>
      <input type="hidden" name="id" value="<?= (int) $track['id'] ?>">
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
      <div class="lg:col-span-8 a-card a-card-pad">
        <div class="a-form-grid">
          <div class="s-field a-span-2">
            <label for="title" class="s-label">Track title <span class="s-req">*</span></label>
            <input type="text" id="title" name="title" required maxlength="150"
                   value="<?= Security::e($track['title'] ?? '') ?>" class="s-input"
                   placeholder="e.g. Full Stack Development">
          </div>

          <div class="s-field a-span-2">
            <label for="short_desc" class="s-label">Short description <span class="s-req">*</span> <span class="s-mute">(shown on cards, max 255)</span></label>
            <textarea id="short_desc" name="short_desc" rows="2" required maxlength="255"
                      class="s-textarea"
                      placeholder="One sentence summarising the track."><?= Security::e($track['short_desc'] ?? '') ?></textarea>
          </div>

          <div class="s-field a-span-2">
            <label for="description" class="s-label">Full description <span class="s-req">*</span></label>
            <textarea id="description" name="description" rows="6" required
                      class="s-textarea"
                      placeholder="What the intern will actually do, learn and deliver."><?= Security::e($track['description'] ?? '') ?></textarea>
          </div>

          <div class="s-field a-span-2">
            <label for="skills" class="s-label">Skills <span class="s-mute">(comma separated)</span></label>
            <input type="text" id="skills" name="skills" maxlength="500"
                   value="<?= Security::e($track['skills'] ?? '') ?>" class="s-input"
                   placeholder="HTML, CSS, JavaScript, MySQL, Git">
          </div>

          <div class="s-field">
            <label for="icon" class="s-label">Font Awesome icon <span class="s-req">*</span></label>
            <input type="text" id="icon" name="icon" required pattern="fa-[a-z0-9\-]+"
                   value="<?= Security::e($track['icon'] ?? 'fa-code') ?>" class="s-input"
                   placeholder="fa-code">
            <p class="s-help">Lowercase, starting with <code>fa-</code>, e.g. fa-shield-halved</p>
          </div>

          <div class="s-field">
            <label for="mode" class="s-label">Work mode</label>
            <input type="text" id="mode" name="mode" maxlength="40"
                   value="<?= Security::e($track['mode'] ?? 'Remote / Hybrid') ?>" class="s-input">
          </div>

          <div class="s-field">
            <label for="duration_weeks" class="s-label">Duration (weeks)</label>
            <input type="number" id="duration_weeks" name="duration_weeks" min="1" max="104"
                   value="<?= (int) ($track['duration_weeks'] ?? 8) ?>" class="s-input">
          </div>

          <div class="s-field">
            <label for="seats" class="s-label">Seats</label>
            <input type="number" id="seats" name="seats" min="0" max="9999"
                   value="<?= (int) ($track['seats'] ?? 10) ?>" class="s-input">
          </div>

          <div class="s-field a-span-2">
            <label for="stipend_text" class="s-label">Stipend text</label>
            <input type="text" id="stipend_text" name="stipend_text" maxlength="120"
                   value="<?= Security::e($track['stipend_text'] ?? 'Performance based') ?>" class="s-input">
          </div>
        </div>

        <div class="a-form-actions">
          <button type="submit" class="s-btn s-btn--sm">
            <i class="fas fa-save text-xs" aria-hidden="true"></i> <?= $track ? 'Update Track' : 'Add Track' ?>
          </button>
          <a href="<?= url('admin/tracks') ?>" class="s-btn--line s-btn--sm">Cancel</a>
        </div>
      </div>

      <div class="lg:col-span-4">
        <div class="a-card">
          <div class="a-card-head"><h2>Publish settings</h2></div>
          <div class="a-card-pad">
            <div class="s-field">
              <label for="sort_order" class="s-label">Sort order</label>
              <input type="number" id="sort_order" name="sort_order"
                     value="<?= (int) ($track['sort_order'] ?? 0) ?>" class="s-input">
            </div>

            <label class="s-check">
              <input type="checkbox" name="is_active" value="1"
                     <?= (!$track || (int) $track['is_active'] === 1) ? 'checked' : '' ?>>
              <span>
                Active
                <span class="s-help block" style="margin-top:.1rem">Unchecked tracks are hidden from the public listing.</span>
              </span>
            </label>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
