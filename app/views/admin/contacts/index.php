<!-- ── ADMIN CONTACTS LIST ─────────────────────────────────── -->
<div class="pt-6">
  <h2 class="font-display font-semibold text-white text-xl mb-6">Contact Submissions</h2>
  <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-x-auto">
    <table class="w-full text-sm min-w-[700px]">
      <thead><tr class="border-b border-gray-800">
        <th class="text-left text-gray-400 font-medium px-5 py-3">Name</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Email</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Subject</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Date</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Status</th>
        <th class="text-left text-gray-400 font-medium px-5 py-3">Actions</th>
      </tr></thead>
      <tbody class="divide-y divide-gray-800">
        <?php if ($contacts): foreach ($contacts as $c): ?>
        <tr class="hover:bg-gray-800/50 transition <?= !$c['is_read'] ? 'bg-eco-500/5' : '' ?>">
          <td class="px-5 py-3 text-white font-medium"><?= Security::e($c['name']) ?></td>
          <td class="px-5 py-3 text-gray-400"><?= Security::e($c['email']) ?></td>
          <td class="px-5 py-3 text-gray-300"><?= Security::e(truncate($c['subject'], 40)) ?></td>
          <td class="px-5 py-3 text-gray-500 text-xs"><?= formatDate($c['created_at'], 'd M Y, H:i') ?></td>
          <td class="px-5 py-3">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?= $c['is_read'] ? 'bg-gray-700 text-gray-400' : 'bg-eco-500/20 text-eco-400' ?>">
              <?= $c['is_read'] ? 'Read' : 'New' ?>
            </span>
          </td>
          <td class="px-5 py-3">
            <div class="flex items-center space-x-3">
              <a href="<?= url('admin/contacts/view?id=' . $c['id']) ?>" class="text-eco-400 hover:text-eco-300 text-xs transition"><i class="fas fa-eye mr-1"></i>View</a>
              <a href="<?= url('admin/contacts/delete?id=' . $c['id']) ?>" onclick="return confirm('Delete message?')" class="text-red-400 hover:text-red-300 text-xs transition"><i class="fas fa-trash mr-1"></i>Delete</a>
            </div>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="6" class="text-center py-10 text-gray-500">No messages yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
