<!-- ── ADMIN CONTACT DETAIL ──────────────────────────────── -->
<div class="pt-6 max-w-2xl">
  <a href="<?= url('admin/contacts') ?>" class="text-gray-400 hover:text-white text-sm transition mb-6 inline-flex items-center">
    <i class="fas fa-arrow-left mr-1"></i>Back to Messages
  </a>
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mt-4">
    <div class="flex items-start justify-between mb-6">
      <div>
        <h2 class="font-display font-bold text-white text-xl"><?= Security::e($contact['name']) ?></h2>
        <div class="flex flex-wrap gap-3 mt-1">
          <a href="mailto:<?= Security::e($contact['email']) ?>" class="text-eco-400 text-sm hover:text-eco-300 transition"><?= Security::e($contact['email']) ?></a>
          <?php if ($contact['phone']): ?>
          <span class="text-gray-500 text-sm"><?= Security::e($contact['phone']) ?></span>
          <?php endif; ?>
        </div>
      </div>
      <span class="text-gray-500 text-xs"><?= formatDate($contact['created_at'], 'd M Y, H:i') ?></span>
    </div>
    <div class="mb-4">
      <div class="text-gray-400 text-xs mb-1">Subject</div>
      <div class="text-white font-medium"><?= Security::e($contact['subject']) ?></div>
    </div>
    <div class="bg-gray-800 rounded-xl p-4">
      <div class="text-gray-400 text-xs mb-2">Message</div>
      <p class="text-gray-200 text-sm leading-relaxed whitespace-pre-wrap"><?= Security::e($contact['message']) ?></p>
    </div>
    <div class="flex gap-3 mt-6">
      <a href="mailto:<?= Security::e($contact['email']) ?>" class="btn-primary text-sm py-2"><i class="fas fa-reply mr-2"></i>Reply via Email</a>
      <a href="<?= url('admin/contacts/delete?id=' . $contact['id']) ?>" onclick="return confirm('Delete this message?')" class="btn-outline border-red-500/50 text-red-400 hover:text-red-300 text-sm py-2">
        <i class="fas fa-trash mr-2"></i>Delete
      </a>
    </div>
  </div>
</div>
