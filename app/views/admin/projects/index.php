<!-- ── ADMIN PROJECTS LIST ────────────────────────────────── -->
<div class="pt-6">
  <div class="flex items-center justify-between mb-6">
    <h2 class="font-display font-semibold text-white text-xl">All Projects</h2>
    <a href="<?= url('admin/projects/add') ?>" class="btn-primary text-sm py-2"><i class="fas fa-plus mr-2"></i>Add Project</a>
  </div>
  <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-x-auto">
    <table class="w-full text-sm min-w-[700px]">
      <thead><tr class="border-b border-gray-800">
        <th class="text-left text-gray-400 font-medium px-5 py-3">#</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Title</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Category</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Featured</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Status</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Actions</th>
      </tr></thead>
      <tbody class="divide-y divide-gray-800">
        <?php if ($projects): foreach ($projects as $i => $p): ?>
        <tr class="hover:bg-gray-800/50 transition">
          <td class="px-5 py-3 text-gray-500"><?= $i+1 ?></td>
          <td class="px-5 py-3 text-white font-medium"><?= Security::e($p['title']) ?></td>
          <td class="px-5 py-3"><span class="project-badge"><?= ucfirst($p['category']) ?></span></td>
          <td class="px-5 py-3">
            <?php if ($p['is_featured']): ?>
            <i class="fas fa-star text-yellow-400 text-sm"></i>
            <?php else: ?>
            <i class="far fa-star text-gray-600 text-sm"></i>
            <?php endif; ?>
          </td>
          <td class="px-5 py-3">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?= $p['is_active'] ? 'bg-eco-500/20 text-eco-400' : 'bg-gray-700 text-gray-400' ?>">
              <?= $p['is_active'] ? 'Active' : 'Hidden' ?>
            </span>
          </td>
          <td class="px-5 py-3">
            <div class="flex items-center space-x-3">
              <a href="<?= url('admin/projects/edit?id=' . $p['id']) ?>" class="text-blue-400 hover:text-blue-300 text-xs transition"><i class="fas fa-edit mr-1"></i>Edit</a>
              <a href="<?= url('admin/projects/delete?id=' . $p['id']) ?>"
                 onclick="return confirm('Delete this project?')"
                 class="text-red-400 hover:text-red-300 text-xs transition"><i class="fas fa-trash mr-1"></i>Delete</a>
            </div>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="6" class="text-center py-10 text-gray-500">No projects yet. <a href="<?= url('admin/projects/add') ?>" class="text-eco-400 hover:text-eco-300">Add one →</a></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
