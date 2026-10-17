<!-- ── APPLICATION DETAIL + STATUS TIMELINE ─────────────────── -->

<section class="s-sec s-sec--tight">
  <div class="s-shell">
    <nav class="s-crumbs" aria-label="Breadcrumb" style="margin-bottom:2rem">
      <a href="<?= url('internships/dashboard') ?>">My dashboard</a>
      <span>/</span>
      <span aria-current="page"><?= Security::e($app['ref_no']) ?></span>
    </nav>

    <div class="s-grid">
      <div style="grid-column:span 8">
        <span class="s-eyebrow">Application <?= Security::e($app['ref_no']) ?></span>
        <h1 class="s-h1"><?= Security::e($app['track_title']) ?></h1>
        <div class="s-tags" style="margin-top:1.25rem">
          <?php $__st = (string) $app['status']; ?><span class="s-tag<?= $__st === 'approved' ? ' s-tag--solid' : ($__st === 'shortlisted' ? ' s-tag--signal' : '') ?>"<?= in_array($__st, ['rejected', 'withdrawn'], true) ? ' style="color:var(--ink-3)"' : '' ?>><?= Security::e(statusLabel($__st)) ?></span>
        </div>
      </div>
      <?php if ($app['status'] === 'approved'): ?>
        <div style="grid-column:span 4;align-self:end">
          <a href="<?= url('internships/dashboard/offer-letter?id=' . (int) $app['id']) ?>" class="s-btn">Download offer letter</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid" style="gap:3rem 1.5rem">

      <div style="grid-column:span 8">

        <?php if ($app['status'] === 'approved'): ?>
          <div class="s-notice" style="margin-bottom:3rem">
            <h2 class="s-h3" style="margin-bottom:.4rem">You have been selected</h2>
            <p style="margin:0;color:var(--ink-2)">
              Your offer letter for the <?= Security::e($app['track_title']) ?> track is ready.
              Download it, then reply to
              <a href="mailto:<?= Security::e(COMPANY_EMAIL) ?>" class="s-link"><?= Security::e(COMPANY_EMAIL) ?></a>
              to confirm your acceptance.
            </p>
          </div>
        <?php endif; ?>

        <!-- Submission -->
        <div style="margin-bottom:3.5rem">
          <h2 class="s-h2" style="margin-bottom:1.5rem">Your submission</h2>

          <span class="s-eyebrow" style="margin-bottom:.6rem">Why you are a good fit</span>
          <p class="s-prose" style="white-space:pre-line;margin:0 0 2rem"><?= Security::e($app['cover_note']) ?></p>

          <dl class="s-kv">
            <?php if (!empty($app['portfolio_url'])): ?>
              <div>
                <dt>Portfolio</dt>
                <dd>
                  <a href="<?= Security::e($app['portfolio_url']) ?>"
                     target="_blank" rel="noopener noreferrer nofollow"
                     class="s-link break-all"><?= Security::e($app['portfolio_url']) ?></a>
                </dd>
              </div>
            <?php endif; ?>
            <div>
              <dt>Resume</dt>
              <dd>
                <a href="<?= url('internships/dashboard/resume?id=' . (int) $app['id']) ?>" class="s-link break-all"><?= Security::e($app['resume_original_name']) ?></a>
                <span class="s-num">&nbsp;<?= Security::e(Security::humanSize((int) $app['resume_size'])) ?></span>
              </dd>
            </div>
          </dl>
        </div>

        <!-- Timeline -->
        <div>
          <h2 class="s-h2" style="margin-bottom:1.5rem">Status history</h2>

          <?php if (empty($history)): ?>
            <p class="s-mute">No updates recorded yet.</p>
          <?php else: ?>
            <ol class="s-list">
              <?php foreach ($history as $h): ?>
                <li>
                  <time class="s-num"><?= formatDate((string) $h['created_at'], 'd M Y, g:i a') ?></time>
                  <div>
                    <h3 class="s-h3" style="font-size:1.1rem<?= $h['new_status'] === 'approved' ? ';color:var(--signal)' : '' ?>">
                      <?= Security::e(statusLabel((string) $h['new_status'])) ?>
                    </h3>
                    <?php if (!empty($h['old_status'])): ?>
                      <span class="s-small s-mute">from <?= Security::e(statusLabel((string) $h['old_status'])) ?></span>
                    <?php endif; ?>
                  </div>
                  <div>
                    <?php if (!empty($h['note'])): ?>
                      <p><?= Security::e($h['note']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($h['changed_by_name'])): ?>
                      <p class="s-small s-mute" style="margin-top:.3rem">by <?= Security::e($h['changed_by_name']) ?></p>
                    <?php endif; ?>
                  </div>
                </li>
              <?php endforeach; ?>
            </ol>
          <?php endif; ?>
        </div>
      </div>

      <!-- Sidebar -->
      <aside style="grid-column:span 4">
        <h2 class="s-h3" style="margin-bottom:1rem">Details</h2>
        <dl class="s-kv">
          <?php
          $rows = [
            'Reference' => $app['ref_no'],
            'Track'     => $app['track_title'],
            'Duration'  => ((int) $app['duration_weeks']) . ' weeks',
            'Work Mode' => $app['mode'],
            'Stipend'   => $app['stipend_text'],
            'Submitted' => formatDate((string) $app['created_at'], 'd M Y'),
          ];
          if (!empty($app['start_date'])) {
              $rows['Start Date'] = formatDate((string) $app['start_date'], 'd M Y');
          }
          if (!empty($app['offer_letter_no'])) {
              $rows['Offer No.'] = $app['offer_letter_no'];
          }
          foreach ($rows as $label => $value):
          ?>
            <div>
              <dt><?= Security::e((string) $label) ?></dt>
              <dd class="break-words"><?= Security::e((string) $value) ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>

        <?php if (!in_array($app['status'], ['approved', 'rejected', 'withdrawn'], true)): ?>
          <div style="margin-top:2.5rem;padding-top:1.5rem;border-top:1px solid var(--rule)">
            <h3 class="s-h3" style="font-size:1.1rem;margin-bottom:.5rem">Withdraw application</h3>
            <p class="s-small s-mute" style="margin:0 0 1rem">
              If you no longer want to be considered for this track, you can withdraw. This cannot be undone.
            </p>
            <form action="<?= url('internships/dashboard/withdraw') ?>" method="POST"
                  onsubmit="return confirm('Withdraw this application? This cannot be undone.');">
              <?= Security::csrfField() ?>
              <input type="hidden" name="id" value="<?= (int) $app['id'] ?>">
              <button type="submit" class="s-btn--line s-btn--danger s-btn--sm s-btn--block">Withdraw application</button>
            </form>
          </div>
        <?php endif; ?>

        <p style="margin-top:2rem">
          <a href="<?= url('internships/dashboard') ?>" class="s-link s-small">Back to dashboard</a>
        </p>
      </aside>
    </div>
  </div>
</section>
