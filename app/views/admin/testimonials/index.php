<!-- ── ADMIN TESTIMONIALS LIST ─────────────────────────────── -->
<div class="pt-6">
  <div class="flex items-center justify-between mb-6">
    <h2 class="font-display font-semibold text-white text-xl">Testimonials</h2>
    <a href="<?= url('admin/testimonials/add') ?>" class="btn-primary text-sm py-2"><i class="fas fa-plus mr-2"></i>Add Testimonial</a>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <?php if ($testimonials): foreach ($testimonials as $t): ?>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="flex items-center space-x-3">
          <div class="w-9 h-9 rounded-full bg-eco-500 flex items-center justify-center text-white font-bold text-sm"><?= strtoupper(substr($t['name'],0,1)) ?></div>
          <div>
            <div class="text-white font-semibold text-sm"><?= Security::e($t['name']) ?></div>
            <div class="text-gray-500 text-xs"><?= Security::e(($t['position'] ?? '') . ($t['company'] ? ', ' . $t['company'] : '')) ?></div>
          </div>
        </div>
        <div class="flex items-center space-x-2">
          <a href="<?= url('admin/testimonials/edit?id=' . $t['id']) ?>" class="text-blue-400 hover:text-blue-300 text-xs transition"><i class="fas fa-edit"></i></a>
          <a href="<?= url('admin/testimonials/delete?id=' . $t['id']) ?>" onclick="return confirm('Delete?')" class="text-red-400 hover:text-red-300 text-xs transition"><i class="fas fa-trash"></i></a>
        </div>
      </div>
      <div class="flex space-x-0.5 mb-2"><?= stars((int)$t['rating']) ?></div>
      <p class="text-gray-400 text-sm leading-relaxed italic">"<?= Security::e(truncate($t['message'], 120)) ?>"</p>
    </div>
    <?php endforeach; else: ?>
    <div class="col-span-2 text-center py-10 text-gray-500">No testimonials yet.</div>
    <?php endif; ?>
  </div>
</div>
