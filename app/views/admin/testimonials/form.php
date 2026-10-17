<!-- ── ADMIN TESTIMONIAL FORM ─────────────────────────────── -->
<div>
  <div class="mb-5">
    <a href="<?= url('admin/testimonials') ?>" class="s-link text-sm"><i class="fas fa-arrow-left text-xs" aria-hidden="true"></i> Back</a>
    <h2 class="s-h3 mt-2 mb-0"><?= $testimonial ? 'Edit Testimonial' : 'Add Testimonial' ?></h2>
  </div>
  <form action="<?= url($testimonial ? 'admin/testimonials/update' : 'admin/testimonials/store') ?>" method="POST">
    <?= Security::csrfField() ?>
    <?php if ($testimonial): ?><input type="hidden" name="id" value="<?= $testimonial['id'] ?>"><?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
      <div class="lg:col-span-8 a-card a-card-pad">
        <div class="a-form-grid">
          <div class="s-field">
            <label for="name" class="s-label">Client name <span class="s-req">*</span></label>
            <input type="text" id="name" name="name" required value="<?= Security::e($testimonial['name'] ?? '') ?>" class="s-input">
          </div>
          <div class="s-field">
            <label for="position" class="s-label">Position / title</label>
            <input type="text" id="position" name="position" value="<?= Security::e($testimonial['position'] ?? '') ?>" class="s-input" placeholder="e.g. CEO">
          </div>
          <div class="s-field">
            <label for="company" class="s-label">Company</label>
            <input type="text" id="company" name="company" value="<?= Security::e($testimonial['company'] ?? '') ?>" class="s-input">
          </div>
          <div class="s-field">
            <label for="rating" class="s-label">Rating (1-5)</label>
            <select id="rating" name="rating" class="s-select">
              <?php for ($r=5;$r>=1;$r--): ?>
              <option value="<?= $r ?>" <?= (($testimonial['rating'] ?? 5) == $r) ? 'selected' : '' ?>><?= $r ?> Star<?= $r>1?'s':'' ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="s-field a-span-2">
            <label for="message" class="s-label">Testimonial message <span class="s-req">*</span></label>
            <textarea id="message" name="message" required rows="4" class="s-textarea"><?= Security::e($testimonial['message'] ?? '') ?></textarea>
          </div>
        </div>
        <div class="a-form-actions">
          <button type="submit" class="s-btn s-btn--sm"><i class="fas fa-save text-xs" aria-hidden="true"></i> <?= $testimonial ? 'Update' : 'Add Testimonial' ?></button>
          <a href="<?= url('admin/testimonials') ?>" class="s-btn--line s-btn--sm">Cancel</a>
        </div>
      </div>

      <div class="lg:col-span-4">
        <div class="a-card">
          <div class="a-card-head"><h2>Publish settings</h2></div>
          <div class="a-card-pad">
            <div class="s-field">
              <label for="sort_order" class="s-label">Sort order</label>
              <input type="number" id="sort_order" name="sort_order" value="<?= (int)($testimonial['sort_order'] ?? 0) ?>" class="s-input" min="0">
            </div>
            <label class="s-check" for="is_active">
              <input type="checkbox" name="is_active" id="is_active" <?= ($testimonial['is_active'] ?? 1) ? 'checked' : '' ?>>
              <span>Active</span>
            </label>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
