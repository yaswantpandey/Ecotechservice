<!-- ── SERVICES PAGE ─────────────────────────────────────── -->

<div class="relative overflow-hidden hero-mesh-bg pt-28 pb-16 border-b border-slate-800/80">
  <div class="absolute inset-0 hero-grid opacity-15 pointer-events-none"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-4">
    <div class="inline-flex items-center space-x-2 bg-slate-900/90 border border-eco-500/30 px-4 py-1.5 rounded-full text-eco-300 text-xs font-semibold badge-glow">
      <span class="material-icons text-sm text-eco-400">miscellaneous_services</span>
      <span>Specialized Digital Engineering Capabilities</span>
    </div>
    <h1 class="font-display text-4xl sm:text-6xl font-extrabold text-white tracking-tight">
      Our Technology <span class="text-gradient">Services</span>
    </h1>
    <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto font-normal leading-relaxed">
      End-to-end digital solutions crafted to elevate your business through high-performance web development, cybersecurity, software engineering, and AI automation.
    </p>
  </div>
</div>

<section class="section-padding relative">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php if (!empty($services)): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($services as $sv): ?>
      <div class="glass-card glass-card-hover p-8 flex flex-col justify-between group card-spotlight">
        <div>
          <!-- Icon & Header Badge -->
          <div class="flex items-center justify-between mb-6">
            <div class="w-14 h-14 rounded-2xl bg-eco-500/10 border border-eco-500/30 flex items-center justify-center text-eco-400 group-hover:bg-eco-500 group-hover:text-white transition-all duration-300">
              <i class="fas <?= Security::e($sv['icon']) ?> text-2xl"></i>
            </div>
            <span class="text-[11px] uppercase font-bold tracking-wider px-2.5 py-1 rounded-full bg-slate-900 text-eco-400 border border-eco-500/30">
              Production Ready
            </span>
          </div>

          <!-- Title & Description -->
          <h2 class="font-display font-bold text-white text-xl mb-3 group-hover:text-eco-300 transition-colors"><?= Security::e($sv['title']) ?></h2>
          <p class="text-slate-400 text-sm leading-relaxed mb-6"><?= Security::e($sv['description']) ?></p>
        </div>

        <!-- Footer Action -->
        <div class="pt-4 border-t border-slate-800 flex items-center justify-between text-xs font-semibold">
          <span class="text-eco-400"><i class="fas fa-circle-check mr-1.5"></i>Included Support</span>
          <a href="<?= url('contact') ?>" class="text-slate-200 group-hover:text-white flex items-center hover:underline group">
            <span>Inquire Now</span>
            <i class="fas fa-arrow-right ml-1.5 text-xs text-eco-400 transition-transform group-hover:translate-x-1"></i>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-16 text-slate-500">
      <i class="fas fa-tools text-4xl mb-4 text-slate-600"></i>
      <p>Services coming soon.</p>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- Process Section -->
<section class="section-padding bg-slate-900/40 relative">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <span class="section-tag"><i class="fas fa-diagram-project text-xs mr-1"></i> Development Lifecycle</span>
      <h2 class="section-title">Our Development <span class="text-gradient">Process</span></h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
      <?php foreach ([
        ['num'=>'01', 'icon'=>'fa-comments',    'title'=>'Discovery & Scope', 'desc'=>'We understand your business goals, target audience, and technical specs.'],
        ['num'=>'02', 'icon'=>'fa-pencil-ruler','title'=>'UI/UX Design',      'desc'=>'We build responsive wireframes, glassmorphic prototypes, and user flows.'],
        ['num'=>'03', 'icon'=>'fa-code',        'title'=>'Agile Development', 'desc'=>'We engineer your solution using clean, secure, and scalable code standards.'],
        ['num'=>'04', 'icon'=>'fa-rocket',      'title'=>'Launch & Scale',    'desc'=>'We deploy to cloud infrastructure, optimize SEO, and provide 24/7 support.'],
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
        <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-white">Need a Custom Software Solution?</h2>
        <p class="text-slate-300 text-base max-w-xl mx-auto">Let's discuss your requirements and build something extraordinary for your business.</p>
        <div class="pt-2">
          <a href="<?= url('contact') ?>" class="btn-primary py-3.5 px-8 text-base">
            Contact Us Today <i class="fas fa-arrow-right ml-2 text-xs"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
