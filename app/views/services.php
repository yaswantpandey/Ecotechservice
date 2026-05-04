<!-- ── SERVICES PAGE ─────────────────────────────────────── -->

<div class="page-hero">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-36 pb-16 text-center">
    <span class="section-tag">What We Offer</span>
    <h1 class="font-display text-4xl sm:text-5xl font-bold text-white mt-4 mb-4">
      Our <span class="text-gradient">Services</span>
    </h1>
    <p class="text-gray-400 text-lg max-w-2xl mx-auto">
      End-to-end digital solutions crafted to elevate your business in the modern world.
    </p>
  </div>
</div>

<section class="section-padding">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php if ($services): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($services as $sv): ?>
      <div class="service-card group">
        <div class="w-14 h-14 rounded-2xl bg-eco-500/10 border border-eco-500/20 flex items-center justify-center mb-6 group-hover:bg-eco-500/20 transition-colors duration-300">
          <i class="fas <?= Security::e($sv['icon']) ?> text-eco-400 text-2xl"></i>
        </div>
        <h3 class="font-display font-bold text-white text-xl mb-3"><?= Security::e($sv['title']) ?></h3>
        <p class="text-gray-400 text-sm leading-relaxed"><?= Security::e($sv['description']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-16 text-gray-500">
      <i class="fas fa-tools text-4xl mb-4"></i>
      <p>Services coming soon.</p>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- Process Section -->
<section class="section-padding bg-gray-900/50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <span class="section-tag">How We Work</span>
      <h2 class="section-title">Our <span class="text-gradient">Process</span></h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
      <div class="hidden md:block absolute top-8 left-1/4 right-1/4 h-0.5 bg-gradient-to-r from-eco-500/30 via-eco-500 to-eco-500/30"></div>
      <?php foreach ([
        ['num'=>'01','icon'=>'fa-comments',   'title'=>'Discovery',    'desc'=>'We understand your goals, audience, and technical needs.'],
        ['num'=>'02','icon'=>'fa-pencil-ruler','title'=>'Design',       'desc'=>'We craft wireframes, prototypes, and visual designs.'],
        ['num'=>'03','icon'=>'fa-code',        'title'=>'Development',  'desc'=>'We build your product with clean, scalable code.'],
        ['num'=>'04','icon'=>'fa-rocket',      'title'=>'Launch & Grow','desc'=>'We deploy, monitor, and help you grow continuously.'],
      ] as $step): ?>
      <div class="text-center relative">
        <div class="w-16 h-16 rounded-2xl bg-eco-500/10 border border-eco-500/30 flex items-center justify-center mx-auto mb-4">
          <i class="fas <?= $step['icon'] ?> text-eco-400 text-xl"></i>
        </div>
        <span class="absolute top-1 left-1/2 -translate-x-1/2 text-xs font-bold text-eco-500 bg-gray-950 px-1"><?= $step['num'] ?></span>
        <h3 class="font-display font-semibold text-white mb-2"><?= $step['title'] ?></h3>
        <p class="text-gray-400 text-sm"><?= $step['desc'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section-padding">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <div class="cta-card">
      <div class="absolute inset-0 bg-gradient-to-br from-eco-600/20 to-eco-900/20 rounded-2xl"></div>
      <div class="relative">
        <h2 class="font-display text-3xl font-bold text-white mb-4">Need a Custom Solution?</h2>
        <p class="text-gray-400 mb-8">Let's discuss your requirements and build something great.</p>
        <a href="<?= url('contact') ?>" class="btn-primary">Contact Us Today</a>
      </div>
    </div>
  </div>
</section>
