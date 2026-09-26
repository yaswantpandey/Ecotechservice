<?php
// ── ADMIN — APPLICATION REVIEW ───────────────────────────────
$statusList = applicationStatuses();
?>

<div class="pt-6 space-y-6">

  <!-- Header -->
  <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
    <div>
      <a href="<?= url('admin/applications') ?>" class="text-gray-400 hover:text-white text-sm transition">
        <i class="fas fa-arrow-left mr-1"></i>Back to applications
      </a>

      <div class="flex flex-wrap items-center gap-3 mt-3">
        <h2 class="font-display font-semibold text-white text-xl">
          <?= Security::e($app['intern_name']) ?>
        </h2>
        <?= statusBadge((string) $app['status']) ?>
      </div>

      <p class="text-gray-500 text-xs mt-1.5 font-mono"><?= Security::e($app['ref_no']) ?></p>
    </div>

    <div class="flex flex-wrap gap-2">
      <a href="<?= url('admin/applications/resume?id=' . (int) $app['id']) ?>" class="btn-outline text-sm py-2">
        <i class="fas fa-file-arrow-down mr-2"></i>Resume
      </a>
      <?php if ($app['status'] === 'approved'): ?>
        <a href="<?= url('admin/applications/offer?id=' . (int) $app['id']) ?>" class="btn-primary text-sm py-2">
          <i class="fas fa-file-contract mr-2"></i>Offer Letter
        </a>
      <?php endif; ?>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Main -->
    <div class="lg:col-span-2 space-y-6">

      <!-- Candidate -->
      <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
        <h3 class="text-white font-semibold text-sm mb-5">Candidate</h3>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
          <?php
          $candidate = [
            'Email'          => $app['intern_email'],
            'Phone'          => $app['intern_phone'] ?: '—',
            'College'        => $app['intern_college'] ?: '—',
            'Course'         => $app['intern_course'] ?: '—',
            'Graduation'     => $app['intern_grad_year'] ?: '—',
            'Applied From IP' => $app['ip_address'] ?: '—',
          ];
          foreach ($candidate as $label => $value):
          ?>
            <div>
              <dt class="text-gray-500 text-[11px] uppercase tracking-wider"><?= Security::e((string) $label) ?></dt>
              <dd class="text-gray-200 mt-1 break-words"><?= Security::e((string) $value) ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>
      </div>

      <!-- Submission -->
      <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
        <h3 class="text-white font-semibold text-sm mb-4">Cover Note</h3>
        <p class="text-gray-300 text-sm leading-relaxed whitespace-pre-line"><?= Security::e($app['cover_note']) ?></p>

        <?php if (!empty($app['portfolio_url'])): ?>
          <div class="mt-5 pt-5 border-t border-gray-800">
            <div class="text-gray-500 text-[11px] uppercase tracking-wider mb-2">Portfolio</div>
            <a href="<?= Security::e($app['portfolio_url']) ?>" target="_blank"
               rel="noopener noreferrer nofollow"
               class="text-eco-400 hover:underline text-sm break-all">
              <?= Security::e($app['portfolio_url']) ?>
              <i class="fas fa-arrow-up-right-from-square ml-1 text-xs"></i>
            </a>
          </div>
        <?php endif; ?>

        <div class="mt-5 pt-5 border-t border-gray-800">
          <div class="text-gray-500 text-[11px] uppercase tracking-wider mb-3">Resume</div>
          <a href="<?= url('admin/applications/resume?id=' . (int) $app['id']) ?>"
             class="inline-flex items-center gap-3 bg-gray-950 border border-gray-800 hover:border-eco-500/40 rounded-lg px-4 py-2.5 transition">
            <i class="fas fa-file-lines text-eco-400"></i>
            <span class="text-gray-200 text-sm"><?= Security::e($app['resume_original_name']) ?></span>
            <span class="text-gray-500 text-xs"><?= Security::e(Security::humanSize((int) $app['resume_size'])) ?></span>
            <i class="fas fa-download text-gray-500 text-xs"></i>
          </a>
        </div>
      </div>

      <!-- Update status -->
      <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
        <h3 class="text-white font-semibold text-sm mb-5">Update Status</h3>

        <form action="<?= url('admin/applications/status') ?>" method="POST" class="space-y-5">
          <?= Security::csrfField() ?>
          <input type="hidden" name="id" value="<?= (int) $app['id'] ?>">

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="status" class="form-label">New Status</label>
              <select id="status" name="status" class="form-input" required>
                <?php foreach ($statusList as $key => $label): ?>
                  <option value="<?= Security::e($key) ?>" <?= $app['status'] === $key ? 'selected' : '' ?>>
                    <?= Security::e($label) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div>
              <label for="start_date" class="form-label">
                Start Date <span class="text-gray-500">(used on the offer letter)</span>
              </label>
              <input type="date" id="start_date" name="start_date"
                     value="<?= Security::e((string) ($app['start_date'] ?? '')) ?>" class="form-input">
            </div>
          </div>

          <div>
            <label for="note" class="form-label">
              Note <span class="text-gray-500">(visible to the candidate)</span>
            </label>
            <textarea id="note" name="note" rows="3" maxlength="500" class="form-input resize-y"
                      placeholder="Optional message shown on the candidate's status timeline and included in the email."></textarea>
          </div>

          <label class="flex items-start gap-3 cursor-pointer">
            <input type="checkbox" name="notify" value="1" checked
                   class="mt-1 w-4 h-4 rounded border-gray-600 bg-gray-950 text-eco-500 focus:ring-eco-500/40">
            <span class="text-gray-300 text-sm">
              Email the candidate about this change
              <span class="block text-gray-500 text-xs mt-0.5">
                Requires working SMTP credentials in .env. Failures are logged and will not block the update.
              </span>
            </span>
          </label>

          <div class="pt-2 border-t border-gray-800 flex flex-wrap gap-3">
            <button type="submit" class="btn-primary text-sm py-2">
              <i class="fas fa-save mr-2"></i>Save Status
            </button>
            <?php if ($app['status'] !== 'approved'): ?>
              <span class="text-gray-500 text-xs self-center">
                Selecting <strong class="text-eco-400">Approved</strong> generates the offer letter automatically.
              </span>
            <?php endif; ?>
          </div>
        </form>
      </div>

      <!-- History -->
      <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
        <h3 class="text-white font-semibold text-sm mb-5">History</h3>

        <?php if ($history): ?>
          <ol class="relative border-l border-gray-800 ml-2 space-y-6">
            <?php foreach (array_reverse($history) as $h): ?>
              <li class="ml-5">
                <span class="absolute -left-[9px] w-[18px] h-[18px] rounded-full bg-gray-950 border border-gray-700 flex items-center justify-center text-[9px] <?= $h['new_status'] === 'approved' ? 'text-eco-400' : 'text-gray-400' ?>">
                  <i class="fas <?= statusIcon((string) $h['new_status']) ?>"></i>
                </span>
                <div class="flex flex-wrap items-center gap-2">
                  <span class="text-white text-sm font-medium"><?= Security::e(statusLabel((string) $h['new_status'])) ?></span>
                  <?php if (!empty($h['old_status'])): ?>
                    <span class="text-gray-600 text-xs">from <?= Security::e(statusLabel((string) $h['old_status'])) ?></span>
                  <?php endif; ?>
                </div>
                <div class="text-gray-500 text-xs mt-0.5">
                  <?= formatDate((string) $h['created_at'], 'd M Y, g:i a') ?>
                  <?php if (!empty($h['changed_by_name'])): ?>
                    &middot; <?= Security::e($h['changed_by_name']) ?>
                  <?php endif; ?>
                </div>
                <?php if (!empty($h['note'])): ?>
                  <p class="text-gray-300 text-sm mt-1.5"><?= Security::e($h['note']) ?></p>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ol>
        <?php else: ?>
          <p class="text-gray-500 text-sm">No history recorded.</p>
        <?php endif; ?>
      </div>
    </div>

    <!-- Sidebar -->
    <aside class="space-y-6">
      <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
        <h3 class="text-white font-semibold text-sm mb-5">Application</h3>
        <dl class="space-y-4 text-sm">
          <?php
          $meta = [
            'Track'     => $app['track_title'],
            'Duration'  => ((int) $app['duration_weeks']) . ' weeks',
            'Mode'      => $app['mode'],
            'Stipend'   => $app['stipend_text'],
            'Submitted' => formatDate((string) $app['created_at'], 'd M Y, g:i a'),
          ];
          if (!empty($app['reviewed_at'])) {
              $meta['Last Reviewed'] = formatDate((string) $app['reviewed_at'], 'd M Y, g:i a');
          }
          if (!empty($app['reviewer_name'])) {
              $meta['Reviewed By'] = $app['reviewer_name'];
          }
          if (!empty($app['offer_letter_no'])) {
              $meta['Offer No.'] = $app['offer_letter_no'];
          }
          if (!empty($app['start_date'])) {
              $meta['Start Date'] = formatDate((string) $app['start_date'], 'd M Y');
          }
          foreach ($meta as $label => $value):
          ?>
            <div>
              <dt class="text-gray-500 text-[11px] uppercase tracking-wider"><?= Security::e((string) $label) ?></dt>
              <dd class="text-gray-200 mt-1 break-words"><?= Security::e((string) $value) ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>
      </div>

      <?php if (!empty($app['admin_notes'])): ?>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
          <h3 class="text-white font-semibold text-sm mb-3">Latest Internal Note</h3>
          <p class="text-gray-300 text-sm leading-relaxed"><?= Security::e($app['admin_notes']) ?></p>
        </div>
      <?php endif; ?>

      <?php if ($otherApplications): ?>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
          <h3 class="text-white font-semibold text-sm mb-4">
            Other applications from this candidate
          </h3>
          <ul class="space-y-3">
            <?php foreach ($otherApplications as $o): ?>
              <li class="flex items-center justify-between gap-3">
                <a href="<?= url('admin/applications/view?id=' . (int) $o['id']) ?>"
                   class="text-gray-300 hover:text-white text-xs transition truncate">
                  <?= Security::e($o['track_title']) ?>
                </a>
                <?= statusBadge((string) $o['status']) ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <!-- Danger zone -->
      <div class="bg-gray-900 border border-red-500/20 rounded-xl p-6">
        <h3 class="text-white font-semibold text-sm mb-2">Delete application</h3>
        <p class="text-gray-500 text-xs leading-relaxed mb-4">
          Permanently removes this application, its history and the stored resume file. This cannot be undone.
        </p>
        <form action="<?= url('admin/applications/delete') ?>" method="POST"
              onsubmit="return confirm('Permanently delete this application and its resume? This cannot be undone.');">
          <?= Security::csrfField() ?>
          <input type="hidden" name="id" value="<?= (int) $app['id'] ?>">
          <button type="submit"
                  class="w-full text-red-300 hover:text-red-200 border border-red-500/30 hover:border-red-500/50 rounded-lg py-2.5 text-xs font-semibold transition">
            <i class="fas fa-trash mr-1.5"></i>Delete Application
          </button>
        </form>
      </div>
    </aside>
  </div>
</div>
