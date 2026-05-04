<!-- ── ADMIN SERVICES LIST ────────────────────────────────── -->
<div class="pt-6">
  <div class="flex items-center justify-between mb-6">
    <h2 class="font-display font-semibold text-white text-xl">All Services</h2>
    <a href="<?= url('admin/services/add') ?>" class="btn-primary text-sm py-2"><i class="fas fa-plus mr-2"></i>Add Service</a>
  </div>
  <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-x-auto">
    <table class="w-full text-sm">
      <thead><tr class="border-b border-gray-800">
        <th class="text-left text-gray-400 font-medium px-5 py-3">#</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Title</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Icon</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Order</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Status</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Actions</th>
      </tr></thead>
      <tbody class="divide-y divide-gray-800">
        <?php if ($services): foreach ($services as $i => $s): ?>
        <tr class="hover:bg-gray-800/50 transition">
          <td class="px-5 py-3 text-gray-500"><?= $i+1 ?></td>
          <td class="px-5 py-3 text-white font-medium"><?= Security::e($s['title']) ?></td>
          <td class="px-5 py-3"><i class="fas <?= Security::e($s['icon']) ?> text-eco-400"></i></td>
          <td class="px-5 py-3 text-gray-400"><?= $s['sort_order'] ?></td>
          <td class="px-5 py-3">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?= $s['is_active'] ? 'bg-eco-500/20 text-eco-400' : 'bg-gray-700 text-gray-400' ?>">
              <?= $s['is_active'] ? 'Active' : 'Hidden' ?>
            </span>
          </td>
          <td class="px-5 py-3">
            <div class="flex items-center space-x-3">
              <a href="<?= url('admin/services/edit?id=' . $s['id']) ?>" class="text-blue-400 hover:text-blue-300 text-xs transition"><i class="fas fa-edit mr-1"></i>Edit</a>
              <a href="<?= url('admin/services/delete?id=' . $s['id']) ?>" onclick="return confirm('Delete this service?')" class="text-red-400 hover:text-red-300 text-xs transition"><i class="fas fa-trash mr-1"></i>Delete</a>
            </div>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="6" class="text-center py-10 text-gray-500">No services yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
