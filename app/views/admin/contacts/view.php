<!-- ── ADMIN CONTACT DETAIL ──────────────────────────────── -->
<div class="space-y-6">
  <a href="<?= url('admin/contacts') ?>" class="s-link text-sm inline-flex items-center">
    <i class="fas fa-arrow-left mr-1"></i>Back to Messages
  </a>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <div class="lg:col-span-8">
      <div class="a-card">
        <div class="a-card-head">
          <h2><?= Security::e($contact['subject']) ?></h2>
        </div>
        <div class="a-card-pad">
          <p class="s-eyebrow mb-2">Message</p>
          <p class="text-sm leading-relaxed whitespace-pre-wrap"><?= Security::e($contact['message']) ?></p>

          <div class="a-form-actions mt-6">
            <a href="mailto:<?= Security::e($contact['email']) ?>" class="s-btn s-btn--sm"><i class="fas fa-reply"></i>Reply via Email</a>
            <a href="<?= url('admin/contacts/delete?id=' . $contact['id']) ?>" onclick="return confirm('Delete this message?')" class="s-btn s-btn--danger s-btn--sm">
              <i class="fas fa-trash"></i>Delete
            </a>
          </div>
        </div>
      </div>
    </div>

    <aside class="lg:col-span-4">
      <div class="a-card">
        <div class="a-card-head"><h2>Sender</h2></div>
        <div class="a-card-pad">
          <dl class="s-kv">
            <div><dt>Name</dt><dd><?= Security::e($contact['name']) ?></dd></div>
            <div><dt>Email</dt><dd class="break-all"><a href="mailto:<?= Security::e($contact['email']) ?>" class="s-link"><?= Security::e($contact['email']) ?></a></dd></div>
            <?php if ($contact['phone']): ?>
            <div><dt>Phone</dt><dd><?= Security::e($contact['phone']) ?></dd></div>
            <?php endif; ?>
            <div><dt>Received</dt><dd class="s-num"><?= formatDate($contact['created_at'], 'd M Y, H:i') ?></dd></div>
          </dl>
        </div>
      </div>
    </aside>
  </div>
</div>
