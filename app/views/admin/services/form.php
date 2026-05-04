<!-- ── ADMIN SERVICE FORM ─────────────────────────────────── -->
<div class="pt-6 max-w-2xl">
  <div class="flex items-center space-x-3 mb-6">
    <a href="<?= url('admin/services') ?>" class="text-gray-400 hover:text-white text-sm transition"><i class="fas fa-arrow-left mr-1"></i>Back</a>
    <h2 class="font-display font-semibold text-white text-xl"><?= $service ? 'Edit Service' : 'Add New Service' ?></h2>
  </div>
  <form action="<?= url($service ? 'admin/services/update' : 'admin/services/store') ?>" method="POST"
        class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-5">
    <?= Security::csrfField() ?>
    <?php if ($service): ?><input type="hidden" name="id" value="<?= $service['id'] ?>"><?php endif; ?>
    <div>
      <label class="form-label">Service Title *</label>
      <input type="text" name="title" required value="<?= Security::e($service['title'] ?? '') ?>" class="form-input" placeholder="e.g. Web Development">
    </div>
    <div>
      <label class="form-label">Description *</label>
      <textarea name="description" required rows="4" class="form-input resize-none"><?= Security::e($service['description'] ?? '') ?></textarea>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
      <div>
        <label class="form-label">FontAwesome Icon Class</label>
        <input type="text" name="icon" value="<?= Security::e($service['icon'] ?? 'fa-cog') ?>" class="form-input" placeholder="fa-code">
        <p class="text-gray-500 text-xs mt-1">e.g. fa-code, fa-chart-line, fa-mobile-alt</p>
      </div>
      <div>
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" value="<?= (int)($service['sort_order'] ?? 0) ?>" class="form-input" min="0">
      </div>
    </div>
    <div class="flex items-center space-x-3">
      <input type="checkbox" name="is_active" id="is_active" class="w-4 h-4 accent-green-500" <?= ($service['is_active'] ?? 1) ? 'checked' : '' ?>>
      <label for="is_active" class="text-gray-300 text-sm">Active (Visible on site)</label>
    </div>
    <div class="flex gap-3 pt-2">
      <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i><?= $service ? 'Update Service' : 'Add Service' ?></button>
      <a href="<?= url('admin/services') ?>" class="btn-outline">Cancel</a>
    </div>
  </form>
</div>
