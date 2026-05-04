<!-- ── ADMIN TESTIMONIAL FORM ─────────────────────────────── -->
<div class="pt-6 max-w-2xl">
  <div class="flex items-center space-x-3 mb-6">
    <a href="<?= url('admin/testimonials') ?>" class="text-gray-400 hover:text-white text-sm transition"><i class="fas fa-arrow-left mr-1"></i>Back</a>
    <h2 class="font-display font-semibold text-white text-xl"><?= $testimonial ? 'Edit Testimonial' : 'Add Testimonial' ?></h2>
  </div>
  <form action="<?= url($testimonial ? 'admin/testimonials/update' : 'admin/testimonials/store') ?>" method="POST"
        class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-5">
    <?= Security::csrfField() ?>
    <?php if ($testimonial): ?><input type="hidden" name="id" value="<?= $testimonial['id'] ?>"><?php endif; ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
      <div>
        <label class="form-label">Client Name *</label>
        <input type="text" name="name" required value="<?= Security::e($testimonial['name'] ?? '') ?>" class="form-input">
      </div>
      <div>
        <label class="form-label">Position/Title</label>
        <input type="text" name="position" value="<?= Security::e($testimonial['position'] ?? '') ?>" class="form-input" placeholder="e.g. CEO">
      </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
      <div>
        <label class="form-label">Company</label>
        <input type="text" name="company" value="<?= Security::e($testimonial['company'] ?? '') ?>" class="form-input">
      </div>
      <div>
        <label class="form-label">Rating (1-5)</label>
        <select name="rating" class="form-input">
          <?php for ($r=5;$r>=1;$r--): ?>
          <option value="<?= $r ?>" <?= (($testimonial['rating'] ?? 5) == $r) ? 'selected' : '' ?>><?= $r ?> Star<?= $r>1?'s':'' ?></option>
          <?php endfor; ?>
        </select>
      </div>
    </div>
    <div>
      <label class="form-label">Testimonial Message *</label>
      <textarea name="message" required rows="4" class="form-input resize-none"><?= Security::e($testimonial['message'] ?? '') ?></textarea>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
      <div>
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" value="<?= (int)($testimonial['sort_order'] ?? 0) ?>" class="form-input" min="0">
      </div>
      <div class="flex items-center space-x-3 pt-6">
        <input type="checkbox" name="is_active" id="is_active" class="w-4 h-4 accent-green-500" <?= ($testimonial['is_active'] ?? 1) ? 'checked' : '' ?>>
        <label for="is_active" class="text-gray-300 text-sm">Active</label>
      </div>
    </div>
    <div class="flex gap-3 pt-2">
      <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i><?= $testimonial ? 'Update' : 'Add Testimonial' ?></button>
      <a href="<?= url('admin/testimonials') ?>" class="btn-outline">Cancel</a>
    </div>
  </form>
</div>
