<?php
// ── ADMIN — APPLICATION REVIEW ───────────────────────────────
$statusList = applicationStatuses();
?>

<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
    <div>
      <a href="<?= url('admin/applications') ?>" class="s-link text-sm">
        <i class="fas fa-arrow-left mr-1"></i>Back to applications
      </a>

      <div class="flex flex-wrap items-center gap-3 mt-3">
        <h2 class="s-h3"><?= Security::e($app['intern_name']) ?></h2>
        <?= statusBadge((string) $app['status']) ?>
      </div>

      <p class="s-num mt-1"><?= Security::e($app['ref_no']) ?></p>
    </div>

    <div class="flex flex-wrap gap-2">
      <a href="<?= url('admin/applications/resume?id=' . (int) $app['id']) ?>" class="s-btn--line s-btn--sm">
        <i class="fas fa-file-arrow-down"></i>Resume
      </a>
      <?php if ($app['status'] === 'approved'): ?>
        <a href="<?= url('admin/applications/offer?id=' . (int) $app['id']) ?>" class="s-btn s-btn--sm">
          <i class="fas fa-file-contract"></i>Offer Letter
        </a>
      <?php endif; ?>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    <!-- Main -->
    <div class="lg:col-span-8 space-y-6">

      <!-- Candidate -->
      <div class="a-card">
        <div class="a-card-head"><h2>Candidate</h2></div>
        <div class="a-card-pad">
          <dl class="s-kv">
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
                <dt><?= Security::e((string) $label) ?></dt>
                <dd class="break-words"><?= Security::e((string) $value) ?></dd>
              </div>
            <?php endforeach; ?>
          </dl>
        </div>
      </div>

      <!-- Submission -->
      <div class="a-card">
        <div class="a-card-head"><h2>Cover note</h2></div>
        <div class="a-card-pad">
          <p class="s-prose whitespace-pre-line"><?= Security::e($app['cover_note']) ?></p>

          <?php if (!empty($app['portfolio_url'])): ?>
            <div class="mt-5 pt-5 border-t border-[color:var(--rule)]">
              <p class="s-eyebrow mb-2">Portfolio</p>
              <a href="<?= Security::e($app['portfolio_url']) ?>" target="_blank"
                 rel="noopener noreferrer nofollow"
                 class="s-link text-sm break-all">
                <?= Security::e($app['portfolio_url']) ?>
                <i class="fas fa-arrow-up-right-from-square ml-1 text-xs"></i>
              </a>
            </div>
          <?php endif; ?>

          <div class="mt-5 pt-5 border-t border-[color:var(--rule)]">
            <p class="s-eyebrow mb-2">Resume</p>
            <a href="<?= url('admin/applications/resume?id=' . (int) $app['id']) ?>" class="s-link text-sm inline-flex items-center gap-2">
              <i class="fas fa-download text-xs"></i>
              <span><?= Security::e($app['resume_original_name']) ?></span>
              <span class="s-num"><?= Security::e(Security::humanSize((int) $app['resume_size'])) ?></span>
            </a>
          </div>
        </div>
      </div>

      <!-- Update status -->
      <div class="a-card">
        <div class="a-card-head"><h2>Update status</h2></div>
        <div class="a-card-pad">
          <form action="<?= url('admin/applications/status') ?>" method="POST">
            <?= Security::csrfField() ?>
            <input type="hidden" name="id" value="<?= (int) $app['id'] ?>">

            <div class="a-form-grid">
              <div class="s-field">
                <label for="status" class="s-label">New status</label>
                <select id="status" name="status" class="s-select" required>
                  <?php foreach ($statusList as $key => $label): ?>
                    <option value="<?= Security::e($key) ?>" <?= $app['status'] === $key ? 'selected' : '' ?>>
                      <?= Security::e($label) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="s-field">
                <label for="start_date" class="s-label">Start date</label>
                <input type="date" id="start_date" name="start_date"
                       value="<?= Security::e((string) ($app['start_date'] ?? '')) ?>" class="s-input">
                <p class="s-help">Used on the offer letter.</p>
              </div>

              <div class="s-field a-span-2">
                <label for="note" class="s-label">Note</label>
                <textarea id="note" name="note" rows="3" maxlength="500" class="s-textarea"
                          placeholder="Optional message shown on the candidate's status timeline and included in the email."></textarea>
                <p class="s-help">Visible to the candidate.</p>
              </div>

              <div class="s-field a-span-2">
                <label class="s-check">
                  <input type="checkbox" name="notify" value="1" checked>
                  <span>
                    Email the candidate about this change
                    <span class="s-help block">Requires working SMTP credentials in .env. Failures are logged and will not block the update.</span>
                  </span>
                </label>
              </div>
            </div>

            <div class="a-form-actions items-center">
              <button type="submit" class="s-btn s-btn--sm">Save status</button>
              <?php if ($app['status'] !== 'approved'): ?>
                <span class="s-mute text-xs">
                  Selecting <strong>Approved</strong> generates the offer letter automatically.
                </span>
              <?php endif; ?>
            </div>
          </form>
        </div>
      </div>

      <!-- History -->
      <div class="a-card">
        <div class="a-card-head"><h2>History</h2></div>
        <div class="a-card-pad">
          <?php if ($history): ?>
            <ol class="border-l border-[color:var(--rule)] ml-1 space-y-5">
              <?php foreach (array_reverse($history) as $h): ?>
                <li class="pl-5">
                  <div class="flex flex-wrap items-center gap-2">
                    <i class="fas <?= statusIcon((string) $h['new_status']) ?> text-xs s-mute"></i>
                    <strong class="text-sm font-medium"><?= Security::e(statusLabel((string) $h['new_status'])) ?></strong>
                    <?php if (!empty($h['old_status'])): ?>
                      <span class="s-mute text-xs">from <?= Security::e(statusLabel((string) $h['old_status'])) ?></span>
                    <?php endif; ?>
                  </div>
                  <div class="s-num mt-0.5">
                    <?= formatDate((string) $h['created_at'], 'd M Y, g:i a') ?>
                    <?php if (!empty($h['changed_by_name'])): ?>
                      &middot; <?= Security::e($h['changed_by_name']) ?>
                    <?php endif; ?>
                  </div>
                  <?php if (!empty($h['note'])): ?>
                    <p class="text-sm mt-1.5"><?= Security::e($h['note']) ?></p>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ol>
          <?php else: ?>
            <p class="s-mute text-sm">No history recorded.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <aside class="lg:col-span-4 space-y-6">
      <div class="a-card">
        <div class="a-card-head"><h2>Application</h2></div>
        <div class="a-card-pad">
          <dl class="s-kv">
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
                <dt><?= Security::e((string) $label) ?></dt>
                <dd class="break-words"><?= Security::e((string) $value) ?></dd>
              </div>
            <?php endforeach; ?>
          </dl>
        </div>
      </div>

      <?php if (!empty($app['admin_notes'])): ?>
        <div class="a-card">
          <div class="a-card-head"><h2>Latest internal note</h2></div>
          <div class="a-card-pad">
            <p class="text-sm leading-relaxed"><?= Security::e($app['admin_notes']) ?></p>
          </div>
        </div>
      <?php endif; ?>

      <?php if ($otherApplications): ?>
        <div class="a-card">
          <div class="a-card-head"><h2>Other applications</h2></div>
          <div class="a-card-pad">
            <ul class="space-y-3">
              <?php foreach ($otherApplications as $o): ?>
                <li class="flex items-center justify-between gap-3">
                  <a href="<?= url('admin/applications/view?id=' . (int) $o['id']) ?>" class="s-link text-sm truncate">
                    <?= Security::e($o['track_title']) ?>
                  </a>
                  <?= statusBadge((string) $o['status']) ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endif; ?>

      <!-- Danger zone -->
      <div class="a-card">
        <div class="a-card-head"><h2>Delete application</h2></div>
        <div class="a-card-pad">
          <p class="s-mute text-sm mb-4">
            Permanently removes this application, its history and the stored resume file. This cannot be undone.
          </p>
          <form action="<?= url('admin/applications/delete') ?>" method="POST"
                onsubmit="return confirm('Permanently delete this application and its resume? This cannot be undone.');">
            <?= Security::csrfField() ?>
            <input type="hidden" name="id" value="<?= (int) $app['id'] ?>">
            <button type="submit" class="s-btn s-btn--danger s-btn--sm s-btn--block">
              <i class="fas fa-trash"></i>Delete Application
            </button>
          </form>
        </div>
      </div>
    </aside>
  </div>
</div>
