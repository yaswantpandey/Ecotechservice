<!-- ── INTERNSHIP TRACK DETAIL ──────────────────────────────── -->
<?php
$skills = array_filter(array_map('trim', explode(',', (string) $track['skills'])));
$applyUrl = url('internships/apply?slug=' . urlencode((string) $track['slug']));
?>

<div class="relative overflow-hidden hero-mesh-bg pt-28 pb-14 border-b border-slate-800/80">
  <div class="absolute inset-0 hero-grid opacity-15 pointer-events-none"></div>
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

    <nav class="text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
      <a href="<?= url('internships') ?>" class="hover:text-eco-400 transition">Internships</a>
      <span class="mx-2">/</span>
      <span class="text-slate-300"><?= Security::e($track['title']) ?></span>
    </nav>

    <div class="flex flex-col sm:flex-row sm:items-start gap-6">
      <div class="w-16 h-16 rounded-2xl bg-eco-500/10 border border-eco-500/30 flex items-center justify-center text-eco-400 shrink-0">
        <i class="fas <?= Security::e($track['icon']) ?> text-3xl"></i>
      </div>

      <div class="flex-1 space-y-4">
        <h1 class="font-display text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
          <?= Security::e($track['title']) ?>
          <span class="text-gradient">Internship</span>
        </h1>
        <p class="text-slate-300 text-base leading-relaxed max-w-2xl">
          <?= Security::e($track['short_desc']) ?>
        </p>

        <div class="flex flex-wrap items-center gap-3 pt-2">
          <?php if ($alreadyApplied): ?>
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-eco-500/15 border border-eco-500/30 text-eco-400 text-sm font-semibold">
              <i class="fas fa-circle-check"></i>You have applied for this track
            </span>
            <a href="<?= url('internships/dashboard') ?>" class="btn-outline py-2.5 px-6 text-sm">
              <i class="fas fa-gauge-high mr-2"></i>View Status
            </a>
          <?php else: ?>
            <a href="<?= Security::e($applyUrl) ?>" class="btn-primary py-3 px-7">
              <i class="fas fa-paper-plane mr-2"></i>Apply for This Track
            </a>
            <a href="<?= url('internships') ?>" class="btn-outline py-3 px-6 text-sm">
              All Tracks
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Key facts -->
<section class="py-8 border-b border-slate-800/80 bg-slate-900/40">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <dl class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <?php foreach ([
        ['icon' => 'fa-calendar-days', 'label' => 'Duration', 'value' => ((int) $track['duration_weeks']) . ' weeks'],
        ['icon' => 'fa-location-dot',  'label' => 'Work Mode', 'value' => (string) $track['mode']],
        ['icon' => 'fa-indian-rupee-sign', 'label' => 'Stipend', 'value' => (string) $track['stipend_text']],
        ['icon' => 'fa-users',         'label' => 'Seats', 'value' => (string) ((int) $track['seats'])],
      ] as $fact): ?>
        <div class="glass-card p-4 border-slate-800">
          <dt class="text-slate-500 text-[11px] uppercase tracking-wider flex items-center gap-1.5">
            <i class="fas <?= $fact['icon'] ?> text-eco-400"></i><?= Security::e($fact['label']) ?>
          </dt>
          <dd class="text-white font-semibold text-sm mt-1.5"><?= Security::e($fact['value']) ?></dd>
        </div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>

<section class="section-padding">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- Main column -->
    <div class="lg:col-span-2 space-y-8">
      <div class="glass-card p-7 border-slate-800">
        <h2 class="font-display font-bold text-white text-xl mb-4">About This Track</h2>
        <p class="text-slate-300 text-sm leading-relaxed"><?= Security::e($track['description']) ?></p>
      </div>

      <div class="glass-card p-7 border-slate-800">
        <h2 class="font-display font-bold text-white text-xl mb-5">What You Will Work With</h2>
        <?php if ($skills): ?>
          <div class="flex flex-wrap gap-2">
            <?php foreach ($skills as $skill): ?>
              <span class="text-xs px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-slate-200">
                <?= Security::e($skill) ?>
              </span>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="text-slate-400 text-sm">Details will be shared during onboarding.</p>
        <?php endif; ?>
      </div>

      <div class="glass-card p-7 border-slate-800">
        <h2 class="font-display font-bold text-white text-xl mb-5">Who Should Apply</h2>
        <ul class="space-y-3 text-sm text-slate-300">
          <?php foreach ([
            'Students and recent graduates who can commit to the full ' . ((int) $track['duration_weeks']) . '-week term.',
            'Anyone with working fundamentals in the areas listed above — you do not need professional experience.',
            'Candidates comfortable receiving code review and iterating on feedback.',
            'Applicants who can dedicate consistent weekly hours alongside their studies.',
          ] as $who): ?>
            <li class="flex gap-3">
              <i class="fas fa-circle-check text-eco-400 mt-0.5 shrink-0"></i>
              <span><?= Security::e($who) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="glass-card p-7 border-slate-800">
        <h2 class="font-display font-bold text-white text-xl mb-5">What You Receive</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <?php foreach ([
            ['icon' => 'fa-file-contract', 'title' => 'Formal offer letter', 'desc' => 'Generated automatically on selection.'],
            ['icon' => 'fa-certificate',   'title' => 'Completion certificate', 'desc' => 'Issued on finishing the full term.'],
            ['icon' => 'fa-user-tie',      'title' => 'Mentor reviews', 'desc' => 'Direct feedback on the work you produce.'],
            ['icon' => 'fa-folder-open',   'title' => 'Portfolio project', 'desc' => 'Real work you can show an employer.'],
          ] as $perk): ?>
            <div class="flex gap-3">
              <div class="w-10 h-10 rounded-xl bg-eco-500/10 border border-eco-500/30 flex items-center justify-center text-eco-400 shrink-0">
                <i class="fas <?= $perk['icon'] ?> text-sm"></i>
              </div>
              <div>
                <div class="text-white text-sm font-semibold"><?= $perk['title'] ?></div>
                <div class="text-slate-400 text-xs mt-0.5"><?= $perk['desc'] ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <aside class="space-y-6">
      <div class="glass-card p-6 border-eco-500/30 lg:sticky lg:top-24">
        <h3 class="font-display font-bold text-white text-lg mb-2">
          <?= $alreadyApplied ? 'Application Submitted' : 'Apply for This Track' ?>
        </h3>

        <?php if ($alreadyApplied): ?>
          <p class="text-slate-400 text-sm mb-5">
            Your application is on file. You can follow its progress from your dashboard.
          </p>
          <a href="<?= url('internships/dashboard') ?>" class="btn-primary w-full justify-center py-3">
            <i class="fas fa-gauge-high mr-2"></i>Go to Dashboard
          </a>
        <?php else: ?>
          <p class="text-slate-400 text-sm mb-5">
            <?php if (isIntern()): ?>
              You are signed in. Attach your resume and tell us why this track suits you.
            <?php else: ?>
              Create an account or sign in, then submit your resume for this track.
            <?php endif; ?>
          </p>

          <a href="<?= Security::e($applyUrl) ?>" class="btn-primary w-full justify-center py-3">
            <i class="fas fa-paper-plane mr-2"></i>Start Application
          </a>

          <?php if (!isIntern()): ?>
            <p class="text-slate-500 text-xs mt-4 text-center">
              Already registered?
              <a href="<?= url('internships/login') ?>" class="text-eco-400 hover:underline">Sign in</a>
            </p>
          <?php endif; ?>
        <?php endif; ?>

        <div class="mt-6 pt-5 border-t border-slate-800 space-y-2.5 text-xs text-slate-400">
          <div class="flex items-center gap-2">
            <i class="fas fa-file-pdf text-eco-400 w-4"></i>PDF, DOC or DOCX resume
          </div>
          <div class="flex items-center gap-2">
            <i class="fas fa-shield-halved text-eco-400 w-4"></i>Your resume stays private
          </div>
          <div class="flex items-center gap-2">
            <i class="fas fa-bell text-eco-400 w-4"></i>Email updates on every change
          </div>
        </div>
      </div>

      <div class="glass-card p-6 border-slate-800">
        <h3 class="font-display font-semibold text-white text-sm mb-3">Need help?</h3>
        <p class="text-slate-400 text-xs leading-relaxed mb-4">
          If you are unsure which track fits you best, get in touch and we will point you in the right direction.
        </p>
        <a href="<?= url('contact') ?>" class="text-eco-400 hover:underline text-xs font-semibold">
          Contact our team <i class="fas fa-arrow-right ml-1"></i>
        </a>
      </div>
    </aside>
  </div>
</section>
