<!-- ── APPLICATION DETAIL + STATUS TIMELINE ─────────────────── -->

<div class="relative overflow-hidden hero-mesh-bg pt-28 pb-12 border-b border-slate-800/80">
  <div class="absolute inset-0 hero-grid opacity-15 pointer-events-none"></div>
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <nav class="text-xs text-slate-500 mb-5" aria-label="Breadcrumb">
      <a href="<?= url('internships/dashboard') ?>" class="hover:text-eco-400 transition">My Dashboard</a>
      <span class="mx-2">/</span>
      <span class="text-slate-300"><?= Security::e($app['ref_no']) ?></span>
    </nav>

    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
      <div class="space-y-3">
        <h1 class="font-display text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
          <?= Security::e($app['track_title']) ?>
        </h1>
        <div class="flex flex-wrap items-center gap-3">
          <?= statusBadge((string) $app['status']) ?>
          <span class="text-slate-500 text-xs">
            <i class="fas fa-hashtag mr-1"></i><?= Security::e($app['ref_no']) ?>
          </span>
        </div>
      </div>

      <?php if ($app['status'] === 'approved'): ?>
        <a href="<?= url('internships/dashboard/offer-letter?id=' . (int) $app['id']) ?>"
           class="btn-primary py-3 px-6 text-sm shrink-0">
          <i class="fas fa-file-contract mr-2"></i>Download Offer Letter
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<section class="section-padding">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

    <div class="lg:col-span-2 space-y-8">

      <?php if ($app['status'] === 'approved'): ?>
        <div class="glass-card p-6 border-eco-500/30">
          <div class="flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-eco-500/15 border border-eco-500/30 flex items-center justify-center text-eco-400 shrink-0">
              <i class="fas fa-circle-check"></i>
            </div>
            <div>
              <h2 class="text-white font-semibold mb-1">You have been selected</h2>
              <p class="text-slate-300 text-sm leading-relaxed">
                Your offer letter for the <?= Security::e($app['track_title']) ?> track is ready.
                Download it, then reply to
                <a href="mailto:<?= Security::e(COMPANY_EMAIL) ?>" class="text-eco-400 hover:underline"><?= Security::e(COMPANY_EMAIL) ?></a>
                to confirm your acceptance.
              </p>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Submission -->
      <div class="glass-card p-7 border-slate-800">
        <h2 class="font-display font-bold text-white text-lg mb-5">Your Submission</h2>

        <div class="mb-6">
          <div class="text-slate-500 text-[11px] uppercase tracking-wider mb-2">Why you are a good fit</div>
          <p class="text-slate-300 text-sm leading-relaxed whitespace-pre-line"><?= Security::e($app['cover_note']) ?></p>
        </div>

        <?php if (!empty($app['portfolio_url'])): ?>
          <div class="mb-6">
            <div class="text-slate-500 text-[11px] uppercase tracking-wider mb-2">Portfolio</div>
            <a href="<?= Security::e($app['portfolio_url']) ?>"
               target="_blank" rel="noopener noreferrer nofollow"
               class="text-eco-400 hover:underline text-sm break-all">
              <?= Security::e($app['portfolio_url']) ?>
              <i class="fas fa-arrow-up-right-from-square ml-1 text-xs"></i>
            </a>
          </div>
        <?php endif; ?>

        <div class="pt-5 border-t border-slate-800">
          <div class="text-slate-500 text-[11px] uppercase tracking-wider mb-3">Resume</div>
          <a href="<?= url('internships/dashboard/resume?id=' . (int) $app['id']) ?>"
             class="inline-flex items-center gap-3 bg-slate-900/60 border border-slate-800 hover:border-eco-500/40 rounded-xl px-4 py-3 transition-colors group">
            <i class="fas fa-file-lines text-eco-400"></i>
            <span class="text-slate-200 text-sm group-hover:text-white">
              <?= Security::e($app['resume_original_name']) ?>
            </span>
            <span class="text-slate-500 text-xs"><?= Security::e(Security::humanSize((int) $app['resume_size'])) ?></span>
            <i class="fas fa-download text-slate-500 text-xs"></i>
          </a>
        </div>
      </div>

      <!-- Timeline -->
      <div class="glass-card p-7 border-slate-800">
        <h2 class="font-display font-bold text-white text-lg mb-6">Status History</h2>

        <?php if (empty($history)): ?>
          <p class="text-slate-400 text-sm">No updates recorded yet.</p>
        <?php else: ?>
          <ol class="relative border-l border-slate-800 ml-3 space-y-7">
            <?php foreach ($history as $h): ?>
              <li class="ml-6">
                <span class="absolute -left-[11px] flex items-center justify-center w-[22px] h-[22px] rounded-full bg-slate-900 border <?= $h['new_status'] === 'approved' ? 'text-eco-400 border-eco-500/40' : 'text-slate-400 border-slate-700' ?> text-[10px]">
                  <i class="fas <?= statusIcon((string) $h['new_status']) ?>"></i>
                </span>

                <div class="flex flex-wrap items-center gap-2 mb-1">
                  <span class="text-white text-sm font-semibold">
                    <?= Security::e(statusLabel((string) $h['new_status'])) ?>
                  </span>
                  <?php if (!empty($h['old_status'])): ?>
                    <span class="text-slate-600 text-xs">
                      from <?= Security::e(statusLabel((string) $h['old_status'])) ?>
                    </span>
                  <?php endif; ?>
                </div>

                <time class="text-slate-500 text-xs block mb-1.5">
                  <?= formatDate((string) $h['created_at'], 'd M Y, g:i a') ?>
                </time>

                <?php if (!empty($h['note'])): ?>
                  <p class="text-slate-300 text-sm leading-relaxed"><?= Security::e($h['note']) ?></p>
                <?php endif; ?>

                <?php if (!empty($h['changed_by_name'])): ?>
                  <p class="text-slate-600 text-[11px] mt-1">
                    by <?= Security::e($h['changed_by_name']) ?>
                  </p>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ol>
        <?php endif; ?>
      </div>
    </div>

    <!-- Sidebar -->
    <aside class="space-y-6">
      <div class="glass-card p-6 border-slate-800">
        <h2 class="font-display font-bold text-white text-base mb-5">Details</h2>
        <dl class="space-y-4 text-sm">
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
              <dt class="text-slate-500 text-[11px] uppercase tracking-wider"><?= Security::e((string) $label) ?></dt>
              <dd class="text-slate-200 mt-1 break-words"><?= Security::e((string) $value) ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>
      </div>

      <?php if (!in_array($app['status'], ['approved', 'rejected', 'withdrawn'], true)): ?>
        <div class="glass-card p-6 border-slate-800">
          <h3 class="font-display font-semibold text-white text-sm mb-2">Withdraw application</h3>
          <p class="text-slate-400 text-xs leading-relaxed mb-4">
            If you no longer want to be considered for this track, you can withdraw. This cannot be undone.
          </p>
          <form action="<?= url('internships/dashboard/withdraw') ?>" method="POST"
                onsubmit="return confirm('Withdraw this application? This cannot be undone.');">
            <?= Security::csrfField() ?>
            <input type="hidden" name="id" value="<?= (int) $app['id'] ?>">
            <button type="submit"
                    class="w-full text-center text-red-300 hover:text-red-200 border border-red-500/30 hover:border-red-500/50 rounded-lg py-2.5 text-xs font-semibold transition-colors">
              <i class="fas fa-ban mr-1.5"></i>Withdraw Application
            </button>
          </form>
        </div>
      <?php endif; ?>

      <a href="<?= url('internships/dashboard') ?>"
         class="block text-center text-slate-400 hover:text-white text-sm transition">
        <i class="fas fa-arrow-left mr-1"></i>Back to dashboard
      </a>
    </aside>
  </div>
</section>
