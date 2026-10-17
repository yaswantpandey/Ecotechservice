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
            <a href="mailto:<?= Security::e($contact['email']) ?>" class="s-btn--line s-btn--sm"><i class="fas fa-envelope"></i>Open in mail app</a>
            <a href="<?= url('admin/contacts/delete?id=' . $contact['id']) ?>" onclick="return confirm('Delete this message?')" class="s-btn s-btn--danger s-btn--sm">
              <i class="fas fa-trash"></i>Delete
            </a>
          </div>
        </div>
      </div>

      <?php
      $draft = $_SESSION['contact_reply_draft'] ?? null;
      if ($draft && (int) $draft['id'] !== (int) $contact['id']) $draft = null;
      unset($_SESSION['contact_reply_draft']);
      $replySubject = $draft['subject'] ?? ('Re: ' . $contact['subject']);
      ?>
      <div class="a-card" style="margin-top:1.25rem" id="reply">
        <div class="a-card-head">
          <h2>Reply</h2>
          <span class="s-small s-mute">From <?= Security::e(SMTP_FROM ?: 'site mailbox not configured') ?></span>
        </div>
        <form method="POST" action="<?= url('admin/contacts/reply') ?>" class="a-card-pad">
          <?= Security::csrfField() ?>
          <input type="hidden" name="id" value="<?= (int) $contact['id'] ?>">
          <div class="s-field">
            <label for="reply_to" class="s-label">To</label>
            <input id="reply_to" type="text" class="s-input" value="<?= Security::e($contact['name'] . ' <' . $contact['email'] . '>') ?>" readonly>
          </div>
          <div class="s-field">
            <label for="reply_subject" class="s-label">Subject</label>
            <input id="reply_subject" name="subject" type="text" class="s-input" maxlength="200" required value="<?= Security::e($replySubject) ?>">
          </div>
          <div class="s-field">
            <label for="reply_body" class="s-label">Message</label>
            <textarea id="reply_body" name="body" class="s-textarea" rows="8" maxlength="10000" required
                      placeholder="Write your reply. The original message is quoted below it automatically."><?= Security::e($draft['body'] ?? '') ?></textarea>
          </div>
          <div class="a-form-actions">
            <button type="submit" class="s-btn s-btn--sm"><i class="fas fa-paper-plane"></i>Send reply</button>
          </div>
        </form>
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
