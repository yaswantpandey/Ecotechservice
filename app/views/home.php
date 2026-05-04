<?php
// ── Hero counters ──────────────────────────────────────────
$stats = [
    ['num'=>'150+', 'label'=>'Projects Delivered'],
    ['num'=>'80+',  'label'=>'Happy Clients'],
    ['num'=>'5+',   'label'=>'Years Experience'],
    ['num'=>'99%',  'label'=>'Client Satisfaction'],
];
?>

<!-- ── HERO ─────────────────────────────────────────────── -->
<section class="relative min-h-screen flex items-center overflow-hidden pt-20">
  <!-- Animated background grid -->
  <div class="absolute inset-0 hero-grid opacity-20"></div>
  <!-- Gradient orbs -->
  <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-eco-500/20 rounded-full blur-[120px] animate-pulse-slow"></div>
  <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-eco-700/20 rounded-full blur-[100px] animate-pulse-slow" style="animation-delay:1.5s"></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="max-w-4xl mx-auto text-center">
      <!-- Badge -->
      <div class="inline-flex items-center space-x-2 bg-eco-500/10 border border-eco-500/30 px-4 py-2 rounded-full text-eco-400 text-sm font-medium mb-8 animate-fadeInDown">
        <span class="w-2 h-2 rounded-full bg-eco-400 animate-pulse"></span>
        <span>Building Sustainable Digital Futures</span>
      </div>

      <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6 animate-fadeInUp">
        We Build <span class="text-gradient">Eco-Powered</span><br>Digital Experiences
      </h1>

      <p class="text-xl text-gray-400 leading-relaxed mb-10 max-w-2xl mx-auto animate-fadeInUp" style="animation-delay:.15s">
        From stunning websites to powerful apps and data-driven marketing — Ecotech Service delivers end-to-end digital solutions that grow your business sustainably.
      </p>

      <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fadeInUp" style="animation-delay:.3s">
        <a href="<?= url('projects') ?>"
           class="btn-primary w-full sm:w-auto">
          <i class="fas fa-rocket mr-2"></i>View Our Work
        </a>
        <a href="<?= url('contact') ?>"
           class="btn-outline w-full sm:w-auto">
          Start Your Project <i class="fas fa-arrow-right ml-2 text-sm"></i>
        </a>
      </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mt-20 animate-fadeInUp" style="animation-delay:.45s">
      <?php foreach ($stats as $s): ?>
      <div class="stat-card text-center">
        <div class="font-display text-3xl font-bold text-eco-400 mb-1"><?= $s['num'] ?></div>
        <div class="text-sm text-gray-400"><?= $s['label'] ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Scroll indicator -->
  <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center space-y-2 text-gray-500 animate-bounce">
    <span class="text-xs">Scroll</span>
    <i class="fas fa-chevron-down text-xs"></i>
  </div>
</section>

<!-- ── SERVICES PREVIEW ──────────────────────────────────── -->
<section class="section-padding bg-gray-900/50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="section-header text-center mb-16">
      <span class="section-tag">What We Do</span>
      <h2 class="section-title">Comprehensive <span class="text-gradient">Digital Services</span></h2>
      <p class="section-desc">Tailored technology solutions for startups, SMEs, and enterprises.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($services as $sv): ?>
      <div class="service-card group">
        <div class="w-12 h-12 rounded-xl bg-eco-500/10 border border-eco-500/20 flex items-center justify-center mb-5 group-hover:bg-eco-500/20 transition-colors duration-300">
          <i class="fas <?= Security::e($sv['icon']) ?> text-eco-400 text-xl"></i>
        </div>
        <h3 class="font-display font-semibold text-white text-lg mb-2"><?= Security::e($sv['title']) ?></h3>
        <p class="text-gray-400 text-sm leading-relaxed"><?= Security::e(truncate($sv['description'], 120)) ?></p>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-12">
      <a href="<?= url('services') ?>" class="btn-outline">
        All Services <i class="fas fa-arrow-right ml-2 text-sm"></i>
      </a>
    </div>
  </div>
</section>

<!-- ── FEATURED PROJECTS ─────────────────────────────────── -->
<?php if ($featuredProjects): ?>
<section class="section-padding">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="section-header text-center mb-16">
      <span class="section-tag">Our Work</span>
      <h2 class="section-title">Featured <span class="text-gradient">Projects</span></h2>
      <p class="section-desc">A selection of our recent work across various industries.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($featuredProjects as $p): ?>
      <article class="project-card group">
        <!-- Thumbnail -->
        <div class="project-thumb">
          <?php if ($p['thumbnail']): ?>
          <img src="<?= uploadUrl($p['thumbnail']) ?>" alt="<?= Security::e($p['title']) ?>"
               class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
          <?php else: ?>
          <div class="w-full h-full bg-gradient-to-br from-eco-900 to-gray-800 flex items-center justify-center">
            <i class="fas fa-code text-eco-400/40 text-4xl"></i>
          </div>
          <?php endif; ?>
          <div class="project-overlay">
            <a href="<?= url('projects/view?slug=' . urlencode($p['slug'])) ?>"
               class="px-4 py-2 bg-eco-500 hover:bg-eco-400 text-white text-sm font-semibold rounded-lg transition">View Project</a>
            <?php if ($p['live_url']): ?>
            <a href="<?= Security::e($p['live_url']) ?>" target="_blank"
               class="px-4 py-2 border border-white/20 hover:border-white/50 text-white text-sm font-semibold rounded-lg transition">
              <i class="fas fa-external-link-alt mr-1"></i>Live Demo
            </a>
            <?php endif; ?>
          </div>
        </div>
        <div class="p-5">
          <span class="project-badge"><?= ucfirst(Security::e($p['category'])) ?></span>
          <h3 class="font-display font-semibold text-white mt-2 mb-1"><?= Security::e($p['title']) ?></h3>
          <p class="text-gray-400 text-sm leading-relaxed mb-3"><?= Security::e(truncate($p['description'], 100)) ?></p>
          <div class="flex flex-wrap gap-1">
            <?php foreach (explode(',', $p['tech_stack']) as $tech): ?>
            <span class="tech-tag"><?= Security::e(trim($tech)) ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-12">
      <a href="<?= url('projects') ?>" class="btn-primary">
        View All Projects <i class="fas fa-arrow-right ml-2"></i>
      </a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── TESTIMONIALS ──────────────────────────────────────── -->
<?php if ($testimonials): ?>
<section class="section-padding bg-gray-900/50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <span class="section-tag">Client Love</span>
      <h2 class="section-title">What Our <span class="text-gradient">Clients Say</span></h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <?php foreach ($testimonials as $t): ?>
      <div class="testimonial-card">
        <div class="flex items-center space-x-1 mb-4">
          <?= stars((int)$t['rating']) ?>
        </div>
        <p class="text-gray-300 text-sm leading-relaxed mb-5 italic">"<?= Security::e($t['message']) ?>"</p>
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 rounded-full bg-eco-500 flex items-center justify-center text-white font-bold text-sm">
            <?= strtoupper(substr($t['name'], 0, 1)) ?>
          </div>
          <div>
            <div class="font-semibold text-white text-sm"><?= Security::e($t['name']) ?></div>
            <div class="text-gray-500 text-xs"><?= Security::e($t['position'] . ($t['company'] ? ', ' . $t['company'] : '')) ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── CTA SECTION ───────────────────────────────────────── -->
<section class="section-padding">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <div class="cta-card">
      <div class="absolute inset-0 bg-gradient-to-br from-eco-600/20 to-eco-900/20 rounded-2xl"></div>
      <div class="relative">
        <h2 class="font-display text-3xl sm:text-4xl font-bold text-white mb-4">
          Ready to <span class="text-eco-400">Start Your Project?</span>
        </h2>
        <p class="text-gray-400 mb-8 text-lg">Let's build something amazing together. Get in touch today for a free consultation.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="<?= url('contact') ?>" class="btn-primary">Get Free Quote</a>
          <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hi+Ecotech!+I+want+to+discuss+a+project." target="_blank"
             class="flex items-center justify-center space-x-2 px-6 py-3 bg-[#25D366] hover:bg-[#22c35e] text-white font-semibold rounded-xl transition-all duration-200">
            <i class="fab fa-whatsapp text-lg"></i><span>Chat on WhatsApp</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
