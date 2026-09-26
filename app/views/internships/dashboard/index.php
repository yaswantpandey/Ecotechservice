<!-- ── INTERN DASHBOARD ─────────────────────────────────────── -->

<div class="relative overflow-hidden hero-mesh-bg pt-28 pb-12 border-b border-slate-800/80">
  <div class="absolute inset-0 hero-grid opacity-15 pointer-events-none"></div>
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5">
      <div class="space-y-2">
        <div class="inline-flex items-center space-x-2 bg-slate-900/90 border border-eco-500/30 px-3 py-1 rounded-md text-eco-300 text-xs font-semibold">
          <span class="material-icons text-sm text-eco-400">dashboard</span>
          <span>My Dashboard</span>
        </div>
        <h1 class="font-display text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
          Hello, <span class="text-gradient"><?= Security::e(internName()) ?></span>
        </h1>
        <p class="text-slate-400 text-sm">
          <?php if ($summary['total'] === 0): ?>
            You have not applied for a track yet.
          <?php else: ?>
            You have <?= (int) $summary['total'] ?> application<?= $summary['total'] === 1 ? '' : 's' ?> on file.
          <?php endif; ?>
        </p>
      </div>

      <div class="flex flex-wrap gap-3">
        <a href="<?= url('internships') ?>" class="btn-primary py-2.5 px-6 text-sm">
          <i class="fas fa-plus mr-2"></i>New Application
        </a>
        <a href="<?= url('internships/logout') ?>" class="btn-outline py-2.5 px-5 text-sm">
          <i class="fas fa-right-from-bracket mr-2"></i>Sign Out
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Summary -->
<section class="py-8 border-b border-slate-800/80 bg-slate-900/40">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <?php foreach ([
        ['label' => 'Total Applications', 'value' => $summary['total'],    'icon' => 'fa-layer-group', 'tone' => 'text-white'],
        ['label' => 'In Progress',        'value' => $summary['active'],   'icon' => 'fa-hourglass-half', 'tone' => 'text-amber-300'],
        ['label' => 'Approved',           'value' => $summary['approved'], 'icon' => 'fa-circle-check', 'tone' => 'text-eco-400'],
        ['label' => 'Closed',             'value' => $summary['closed'],   'icon' => 'fa-circle-xmark', 'tone' => 'text-slate-400'],
      ] as $card): ?>
        <div class="glass-card p-5 border-slate-800">
          <div class="flex items-center justify-between mb-2">
            <span class="text-slate-500 text-[11px] uppercase tracking-wider"><?= Security::e($card['label']) ?></span>
            <i class="fas <?= $card['icon'] ?> <?= $card['tone'] ?> text-sm"></i>
          </div>
          <div class="font-display font-extrabold text-2xl <?= $card['tone'] ?>"><?= (int) $card['value'] ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section-padding">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- Applications -->
    <div class="lg:col-span-2 space-y-5">
      <h2 class="font-display font-bold text-white text-xl">My Applications</h2>

      <?php if (empty($applications)): ?>
        <div class="glass-card p-10 border-slate-800 text-center">
          <div class="w-14 h-14 rounded-2xl bg-eco-500/10 border border-eco-500/30 flex items-center justify-center text-eco-400 mx-auto mb-4">
            <i class="fas fa-folder-open text-xl"></i>
          </div>
          <h3 class="text-white font-semibold mb-2">No applications yet</h3>
          <p class="text-slate-400 text-sm mb-6 max-w-sm mx-auto">
            Browse the eleven internship tracks and submit your first application. You can apply to more than one.
          </p>
          <a href="<?= url('internships') ?>" class="btn-primary py-2.5 px-6 text-sm">
            Browse Internships <i class="fas fa-arrow-right ml-2 text-xs"></i>
          </a>
        </div>
      <?php else: ?>
        <?php foreach ($applications as $a): ?>
          <article class="glass-card p-6 border-slate-800">
            <div class="flex flex-col sm:flex-row sm:items-start gap-4">
              <div class="w-12 h-12 rounded-xl bg-eco-500/10 border border-eco-500/30 flex items-center justify-center text-eco-400 shrink-0">
                <i class="fas <?= Security::e($a['track_icon'] ?: 'fa-code') ?>"></i>
              </div>

              <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-3 mb-1.5">
                  <h3 class="font-display font-bold text-white text-base">
                    <?= Security::e($a['track_title']) ?>
                  </h3>
                  <?= statusBadge((string) $a['status']) ?>
                </div>

                <div class="text-slate-500 text-xs mb-3 flex flex-wrap gap-x-4 gap-y-1">
                  <span><i class="fas fa-hashtag mr-1"></i><?= Security::e($a['ref_no']) ?></span>
                  <span><i class="fas fa-calendar mr-1"></i>Applied <?= formatDate((string) $a['created_at']) ?></span>
                  <span><i class="fas fa-clock mr-1"></i><?= (int) $a['duration_weeks'] ?> weeks</span>
                </div>

                <div class="flex flex-wrap gap-2 text-xs">
                  <a href="<?= url('internships/dashboard/application?id=' . (int) $a['id']) ?>"
                     class="text-eco-400 hover:text-eco-300 font-semibold">
                    <i class="fas fa-eye mr-1"></i>View Details
                  </a>
                  <span class="text-slate-700">|</span>
                  <a href="<?= url('internships/dashboard/resume?id=' . (int) $a['id']) ?>"
                     class="text-slate-300 hover:text-white">
                    <i class="fas fa-file-arrow-down mr-1"></i>My Resume
                  </a>

                  <?php if ($a['status'] === 'approved'): ?>
                    <span class="text-slate-700">|</span>
                    <a href="<?= url('internships/dashboard/offer-letter?id=' . (int) $a['id']) ?>"
                       class="text-eco-400 hover:text-eco-300 font-semibold">
                      <i class="fas fa-file-contract mr-1"></i>Offer Letter (PDF)
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <?php if ($a['status'] === 'approved'): ?>
              <div class="mt-5 pt-4 border-t border-slate-800 flex items-start gap-3 text-sm">
                <i class="fas fa-party-horn text-eco-400 mt-0.5"></i>
                <p class="text-slate-300">
                  Congratulations — this application has been approved. Your offer letter is ready to download.
                </p>
              </div>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Profile -->
    <aside class="space-y-6">
      <div class="glass-card p-6 border-slate-800">
        <h2 class="font-display font-bold text-white text-base mb-5">My Profile</h2>
        <dl class="space-y-4 text-sm">
          <?php
          $fields = [
            'Name'       => $profile['name'] ?? '',
            'Email'      => $profile['email'] ?? '',
            'Phone'      => $profile['phone'] ?? '',
            'College'    => $profile['college'] ?? '',
            'Course'     => $profile['course'] ?? '',
            'Graduation' => $profile['graduation_year'] ?? '',
          ];
          foreach ($fields as $label => $value):
              if ((string) $value === '') { continue; }
          ?>
            <div>
              <dt class="text-slate-500 text-[11px] uppercase tracking-wider"><?= Security::e($label) ?></dt>
              <dd class="text-slate-200 mt-1 break-words"><?= Security::e((string) $value) ?></dd>
            </div>
          <?php endforeach; ?>

          <?php if (!empty($profile['created_at'])): ?>
            <div class="pt-3 border-t border-slate-800">
              <dt class="text-slate-500 text-[11px] uppercase tracking-wider">Member since</dt>
              <dd class="text-slate-400 mt-1 text-xs"><?= formatDate((string) $profile['created_at'], 'd M Y') ?></dd>
            </div>
          <?php endif; ?>
        </dl>
      </div>

      <div class="glass-card p-6 border-slate-800">
        <h3 class="font-display font-semibold text-white text-sm mb-3">What the statuses mean</h3>
        <ul class="space-y-2.5 text-xs text-slate-400">
          <?php foreach ([
            'pending'      => 'Received and queued for review.',
            'under_review' => 'Our team is actively assessing it.',
            'shortlisted'  => 'You are through to the next stage.',
            'approved'     => 'Selected — offer letter available.',
            'rejected'     => 'Not taken forward this time.',
          ] as $key => $meaning): ?>
            <li class="flex items-start gap-2">
              <i class="fas <?= statusIcon($key) ?> mt-0.5 w-3.5 text-center"></i>
              <span><strong class="text-slate-300"><?= Security::e(statusLabel($key)) ?></strong> &mdash; <?= Security::e($meaning) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </aside>
  </div>
</section>
