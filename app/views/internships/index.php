<!-- ── INTERNSHIPS — TRACK LISTING ──────────────────────────── -->

<div class="relative overflow-hidden hero-mesh-bg pt-28 pb-16 border-b border-slate-800/80">
  <div class="absolute inset-0 hero-grid opacity-15 pointer-events-none"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-4">
    <div class="inline-flex items-center space-x-2 bg-slate-900/90 border border-eco-500/30 px-4 py-1.5 rounded-md text-eco-300 text-xs font-semibold badge-glow">
      <span class="material-icons text-sm text-eco-400">school</span>
      <span>Internship Programme <?= date('Y') ?></span>
    </div>
    <h1 class="font-display text-4xl sm:text-6xl font-extrabold text-white tracking-tight">
      Build Real Software. <span class="text-gradient">Get Mentored.</span>
    </h1>
    <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto font-normal leading-relaxed">
      Eleven engineering tracks, each built around production-style work rather than tutorials.
      Apply online, track your application, and receive a formal offer letter on selection.
    </p>

    <div class="flex flex-wrap items-center justify-center gap-3 pt-4">
      <?php if (isIntern()): ?>
        <a href="<?= url('internships/dashboard') ?>" class="btn-primary py-3 px-7">
          <i class="fas fa-gauge-high mr-2"></i>My Dashboard
        </a>
      <?php else: ?>
        <a href="<?= url('internships/register') ?>" class="btn-primary py-3 px-7">
          <i class="fas fa-user-plus mr-2"></i>Create an Account
        </a>
        <a href="<?= url('internships/login') ?>" class="btn-outline py-3 px-7">
          <i class="fas fa-right-to-bracket mr-2"></i>Sign In
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Programme facts -->
<section class="py-10 border-b border-slate-800/80 bg-slate-900/40">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <?php foreach ([
        ['icon' => 'fa-diagram-project', 'value' => count($tracks), 'label' => 'Engineering tracks'],
        ['icon' => 'fa-laptop-code',     'value' => 'Remote',       'label' => 'Remote and hybrid'],
        ['icon' => 'fa-user-tie',        'value' => '1:1',          'label' => 'Mentor guidance'],
        ['icon' => 'fa-certificate',     'value' => 'Certificate',  'label' => 'On completion'],
      ] as $fact): ?>
        <div class="glass-card p-5 border-slate-800">
          <div class="w-11 h-11 rounded-xl bg-eco-500/10 border border-eco-500/30 flex items-center justify-center text-eco-400 mb-3">
            <i class="fas <?= $fact['icon'] ?>"></i>
          </div>
          <div class="font-display font-extrabold text-white text-xl"><?= Security::e((string) $fact['value']) ?></div>
          <div class="text-slate-400 text-xs mt-1"><?= Security::e($fact['label']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Track grid -->
<section class="section-padding relative">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14">
      <span class="section-tag"><i class="fas fa-layer-group text-xs mr-1"></i> Choose Your Track</span>
      <h2 class="section-title">Available <span class="text-gradient">Internships</span></h2>
      <p class="text-slate-400 text-sm max-w-xl mx-auto mt-3">
        Every track runs on real deliverables with code review. Pick the one closest to the work you want to do.
      </p>
    </div>

    <?php if (!empty($tracks)): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
        <?php foreach ($tracks as $t):
            $applied = in_array((int) $t['id'], $appliedIds, true);
            $skills  = array_filter(array_map('trim', explode(',', (string) $t['skills'])));
        ?>
          <article class="glass-card glass-card-hover p-7 flex flex-col justify-between group card-spotlight">
            <div>
              <div class="flex items-start justify-between mb-5">
                <div class="w-14 h-14 rounded-2xl bg-eco-500/10 border border-eco-500/30 flex items-center justify-center text-eco-400 group-hover:bg-eco-500 group-hover:text-white transition-all duration-300">
                  <i class="fas <?= Security::e($t['icon']) ?> text-2xl"></i>
                </div>
                <?php if ($applied): ?>
                  <span class="text-[11px] uppercase font-bold tracking-wider px-2.5 py-1 rounded-full bg-eco-500/15 text-eco-400 border border-eco-500/30">
                    <i class="fas fa-check mr-1"></i>Applied
                  </span>
                <?php else: ?>
                  <span class="text-[11px] uppercase font-bold tracking-wider px-2.5 py-1 rounded-full bg-slate-900 text-slate-300 border border-slate-700">
                    <?= (int) $t['seats'] ?> seats
                  </span>
                <?php endif; ?>
              </div>

              <h3 class="font-display font-bold text-white text-lg mb-2 group-hover:text-eco-300 transition-colors">
                <?= Security::e($t['title']) ?>
              </h3>
              <p class="text-slate-400 text-sm leading-relaxed mb-5"><?= Security::e($t['short_desc']) ?></p>

              <?php if ($skills): ?>
                <div class="flex flex-wrap gap-1.5 mb-5">
                  <?php foreach (array_slice($skills, 0, 4) as $skill): ?>
                    <span class="text-[11px] px-2 py-1 rounded-md bg-slate-900 border border-slate-700 text-slate-300">
                      <?= Security::e($skill) ?>
                    </span>
                  <?php endforeach; ?>
                  <?php if (count($skills) > 4): ?>
                    <span class="text-[11px] px-2 py-1 rounded-md bg-slate-900 border border-slate-700 text-slate-400">
                      +<?= count($skills) - 4 ?>
                    </span>
                  <?php endif; ?>
                </div>
              <?php endif; ?>

              <dl class="grid grid-cols-2 gap-3 text-xs mb-5">
                <div>
                  <dt class="text-slate-500">Duration</dt>
                  <dd class="text-slate-200 font-semibold mt-0.5"><?= (int) $t['duration_weeks'] ?> weeks</dd>
                </div>
                <div>
                  <dt class="text-slate-500">Mode</dt>
                  <dd class="text-slate-200 font-semibold mt-0.5"><?= Security::e($t['mode']) ?></dd>
                </div>
              </dl>
            </div>

            <div class="pt-4 border-t border-slate-800 flex items-center justify-between text-xs font-semibold">
              <a href="<?= url('internships/track?slug=' . urlencode((string) $t['slug'])) ?>"
                 class="text-slate-200 group-hover:text-white flex items-center hover:underline">
                <span>View Details</span>
                <i class="fas fa-arrow-right ml-1.5 text-xs text-eco-400 transition-transform group-hover:translate-x-1"></i>
              </a>

              <?php if ($applied): ?>
                <a href="<?= url('internships/dashboard') ?>" class="text-eco-400 hover:text-eco-300">
                  Track Status
                </a>
              <?php else: ?>
                <a href="<?= url('internships/apply?slug=' . urlencode((string) $t['slug'])) ?>"
                   class="text-eco-400 hover:text-eco-300">
                  Apply <i class="fas fa-paper-plane ml-1"></i>
                </a>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="text-center py-16 text-slate-500">
        <i class="fas fa-folder-open text-4xl mb-4 text-slate-600"></i>
        <p>No internship tracks are open at the moment. Please check back soon.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- How it works -->
<section class="section-padding bg-slate-900/40 relative">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14">
      <span class="section-tag"><i class="fas fa-route text-xs mr-1"></i> Application Process</span>
      <h2 class="section-title">How It <span class="text-gradient">Works</span></h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <?php foreach ([
        ['num' => '01', 'icon' => 'fa-user-plus',   'title' => 'Register',        'desc' => 'Create your account with your academic details. It takes under a minute.'],
        ['num' => '02', 'icon' => 'fa-file-arrow-up','title' => 'Apply & Upload', 'desc' => 'Pick a track, tell us why you fit, and attach your resume as a PDF or DOC.'],
        ['num' => '03', 'icon' => 'fa-magnifying-glass','title' => 'Review',      'desc' => 'Our engineering team reviews your profile and updates your status.'],
        ['num' => '04', 'icon' => 'fa-file-contract','title' => 'Offer Letter',   'desc' => 'On approval your formal offer letter is generated for you to download.'],
      ] as $step): ?>
        <div class="glass-card p-6 border-slate-800 text-center relative card-spotlight">
          <div class="w-14 h-14 rounded-2xl bg-eco-500/10 border border-eco-500/30 flex items-center justify-center mx-auto mb-4 text-eco-400">
            <i class="fas <?= $step['icon'] ?> text-xl"></i>
          </div>
          <span class="font-display font-extrabold text-2xl text-eco-400 block mb-1"><?= $step['num'] ?>.</span>
          <h3 class="font-display font-bold text-white text-lg mb-2"><?= $step['title'] ?></h3>
          <p class="text-slate-400 text-xs sm:text-sm leading-relaxed"><?= $step['desc'] ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section-padding relative">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <div class="glass-card cta-card relative p-8 sm:p-12 text-center overflow-hidden border border-eco-500/30 card-spotlight">
      <div class="relative z-10 space-y-4">
        <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-white">
          <?= isIntern() ? 'Ready for your next application?' : 'Ready to start your internship?' ?>
        </h2>
        <p class="text-slate-300 text-base max-w-xl mx-auto">
          <?= isIntern()
              ? 'You can apply to more than one track. Each application is reviewed on its own merit.'
              : 'Create your account once, then apply to any track that fits your goals.' ?>
        </p>
        <div class="pt-2">
          <a href="<?= isIntern() ? url('internships') . '#tracks' : url('internships/register') ?>"
             class="btn-primary py-3.5 px-8 text-base">
            <?= isIntern() ? 'Browse Tracks' : 'Create Your Account' ?>
            <i class="fas fa-arrow-right ml-2 text-xs"></i>
          </a>
        </div>
        <p class="text-slate-500 text-xs pt-2">
          Questions? Email <a href="mailto:<?= Security::e(COMPANY_EMAIL) ?>" class="text-eco-400 hover:underline"><?= Security::e(COMPANY_EMAIL) ?></a>
        </p>
      </div>
    </div>
  </div>
</section>
