<!-- ── ADMIN SERVICE FORM ─────────────────────────────────── -->
<div>
  <div class="mb-5">
    <a href="<?= url('admin/services') ?>" class="s-link text-sm"><i class="fas fa-arrow-left text-xs" aria-hidden="true"></i> Back</a>
    <h2 class="s-h3 mt-2 mb-0"><?= $service ? 'Edit Service' : 'Add New Service' ?></h2>
  </div>
  <form action="<?= url($service ? 'admin/services/update' : 'admin/services/store') ?>" method="POST">
    <?= Security::csrfField() ?>
    <?php if ($service): ?><input type="hidden" name="id" value="<?= $service['id'] ?>"><?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
      <div class="lg:col-span-8 a-card a-card-pad">
        <div class="a-form-grid">
          <div class="s-field a-span-2">
            <label for="title" class="s-label">Service title <span class="s-req">*</span></label>
            <input type="text" id="title" name="title" required value="<?= Security::e($service['title'] ?? '') ?>" class="s-input" placeholder="e.g. Web Development">
          </div>
          <div class="s-field a-span-2">
            <label for="description" class="s-label">Description <span class="s-req">*</span></label>
            <textarea id="description" name="description" required rows="4" class="s-textarea"><?= Security::e($service['description'] ?? '') ?></textarea>
          </div>
          <div class="s-field a-span-2">
            <label for="icon" class="s-label">Font Awesome icon class</label>
            <input type="text" id="icon" name="icon" value="<?= Security::e($service['icon'] ?? 'fa-cog') ?>" class="s-input" placeholder="fa-code">
            <p class="s-help">e.g. fa-code, fa-chart-line, fa-mobile-alt</p>
          </div>
        </div>
        <div class="a-form-actions">
          <button type="submit" class="s-btn s-btn--sm"><i class="fas fa-save text-xs" aria-hidden="true"></i> <?= $service ? 'Update Service' : 'Add Service' ?></button>
          <a href="<?= url('admin/services') ?>" class="s-btn--line s-btn--sm">Cancel</a>
        </div>
      </div>

      <div class="lg:col-span-4">
        <div class="a-card">
          <div class="a-card-head"><h2>Publish settings</h2></div>
          <div class="a-card-pad">
            <div class="s-field">
              <label for="sort_order" class="s-label">Sort order</label>
              <input type="number" id="sort_order" name="sort_order" value="<?= (int)($service['sort_order'] ?? 0) ?>" class="s-input" min="0">
            </div>
            <label class="s-check" for="is_active">
              <input type="checkbox" name="is_active" id="is_active" <?= ($service['is_active'] ?? 1) ? 'checked' : '' ?>>
              <span>Active (visible on site)</span>
            </label>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
