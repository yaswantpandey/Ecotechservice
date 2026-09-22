<!-- ── TEMPLATES PAGE ─────────────────────────────────────── -->

<!-- ══════════════════════════════════════════════════════════
     HERO SECTION
     ══════════════════════════════════════════════════════════ -->
<div class="tmpl-hero">
  <div class="tmpl-hero-bg"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-40 pb-20 relative z-10 text-center">
    <span class="section-tag animate-fadeInDown">
      <i class="fas fa-layer-group text-xs mr-1"></i> Ready-Made Designs
    </span>
    <h1 class="font-display text-5xl sm:text-6xl font-bold text-white mt-5 mb-5 animate-fadeInUp" style="animation-delay:0.1s">
      Launch with a<br><span class="text-gradient">Premium Template</span>
    </h1>
    <p class="text-gray-400 text-lg max-w-2xl mx-auto animate-fadeInUp mb-8" style="animation-delay:0.2s">
      Professionally crafted, pixel-perfect, fully responsive templates built to convert — save weeks of design work and go live fast.
    </p>

    <!-- Stats Bar -->
    <div class="Project-stats animate-fadeInUp mx-auto" style="animation-delay:0.3s">
      <div class="stat-pill"><span class="stat-num"><?= count($templates) ?>+</span><span class="stat-label">Templates</span></div>
      <div class="stat-divider"></div>
      <div class="stat-pill"><span class="stat-num">100%</span><span class="stat-label">Responsive</span></div>
      <div class="stat-divider"></div>
      <div class="stat-pill"><span class="stat-num">Free</span><span class="stat-label">Source Code</span></div>
      <div class="stat-divider"></div>
      <div class="stat-pill"><span class="stat-num">24/7</span><span class="stat-label">Support</span></div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════════════════
     FILTER TABS
     ══════════════════════════════════════════════════════════ -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 mt-10">
  <div class="Project-filter-bar">
    <a href="<?= url('templates') ?>" class="filter-pill <?= empty($_GET['type'] ?? '') ? 'filter-pill--active' : '' ?>">
      <i class="fas fa-th-large mr-2 text-xs"></i>All Templates
    </a>
    <a href="<?= url('templates?type=free') ?>" class="filter-pill <?= ($_GET['type'] ?? '') === 'free' ? 'filter-pill--active' : '' ?>">
      <i class="fas fa-gift mr-2 text-xs"></i>Free
    </a>
    <a href="<?= url('templates?type=premium') ?>" class="filter-pill <?= ($_GET['type'] ?? '') === 'premium' ? 'filter-pill--active' : '' ?>">
      <i class="fas fa-crown mr-2 text-xs"></i>Premium
    </a>
  </div>
</div>

<!-- ══════════════════════════════════════════════════════════
     TEMPLATES GRID
     ══════════════════════════════════════════════════════════ -->
<section class="section-padding pt-0">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php
    // Apply client-side filter from query param
    $typeFilter = $_GET['type'] ?? '';
    $filteredTemplates = $templates;
    if ($typeFilter === 'free') {
        $filteredTemplates = array_filter($templates, fn($t) => $t['is_free']);
    } elseif ($typeFilter === 'premium') {
        $filteredTemplates = array_filter($templates, fn($t) => !$t['is_free']);
    }
    ?>

    <?php if ($filteredTemplates): ?>
    <div class="tmpl-grid">
      <?php foreach (array_values($filteredTemplates) as $i => $t): ?>
      <div class="tmpl-card reveal-card" style="animation-delay: <?= $i * 0.1 ?>s">

        <!-- Thumbnail: live preview via thum.io, local upload as fallback -->
        <div class="tmpl-thumb">
          <?php if (!empty($t['preview_url'])): ?>
          <img src="//image.thum.io/get/width/800/crop/500/noanimate/<?= Security::e(rtrim($t['preview_url'], '/')) ?>"
               alt="<?= Security::e($t['title']) ?>"
               class="tmpl-img"
               loading="lazy"
               onerror="this.src='<?= uploadUrl(!empty($t['thumbnail']) ? $t['thumbnail'] : 'template_business_pro.png') ?>'">
          <?php elseif (!empty($t['thumbnail'])): ?>
          <img src="<?= uploadUrl($t['thumbnail']) ?>"
               alt="<?= Security::e($t['title']) ?>"
               class="tmpl-img"
               loading="lazy">
          <?php else: ?>
          <div class="tmpl-placeholder">
            <i class="fas fa-palette text-5xl"></i>
          </div>
          <?php endif; ?>

          <!-- Badges -->
          <div class="tmpl-badge-row">
            <span class="tmpl-type-badge <?= $t['is_free'] ? 'tmpl-type-badge--free' : 'tmpl-type-badge--premium' ?>">
              <i class="fas <?= $t['is_free'] ? 'fa-gift' : 'fa-crown' ?> mr-1 text-[9px]"></i>
              <?= $t['is_free'] ? 'Free' : 'Premium' ?>
            </span>
          </div>

          <!-- Hover Overlay -->
          <div class="tmpl-overlay">
            <div class="tmpl-overlay-actions">
              <?php if (!empty($t['preview_url'])): ?>
              <a href="<?= Security::e($t['preview_url']) ?>" target="_blank" rel="noopener"
                 class="tmpl-overlay-btn tmpl-overlay-btn--primary">
                <i class="fas fa-eye mr-2"></i>Live Preview
              </a>
              <?php endif; ?>
              <a href="<?= url('contact') ?>" class="tmpl-overlay-btn tmpl-overlay-btn--outline">
                <i class="fas fa-download mr-2"></i>Get Template
              </a>
            </div>
          </div>
        </div>

        <!-- Card Body -->
        <div class="tmpl-body">
          <div class="flex items-start justify-between gap-2 mb-2">
            <h3 class="tmpl-title"><?= Security::e($t['title']) ?></h3>
            <?php if (!$t['is_free']): ?>
            <span class="tmpl-price">₹<?= number_format((float)$t['price']) ?></span>
            <?php else: ?>
            <span class="tmpl-price tmpl-price--free">Free</span>
            <?php endif; ?>
          </div>
          <p class="tmpl-desc"><?= Security::e(truncate($t['description'], 110)) ?></p>

          <!-- Footer -->
          <div class="tmpl-footer">
            <?php if (!empty($t['preview_url'])): ?>
            <a href="<?= Security::e($t['preview_url']) ?>" target="_blank" rel="noopener" class="tmpl-link">
              <i class="fas fa-external-link-alt mr-1 text-[11px]"></i>Preview
            </a>
            <?php endif; ?>
            <a href="<?= url('contact') ?>" class="btn-primary text-xs py-2 px-4 ml-auto">
              Get Template
            </a>
          </div>
        </div>

      </div>
      <?php endforeach; ?>
    </div>

    <?php else: ?>
    <!-- Empty State -->
    <div class="text-center py-24">
      <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-slate-900 border border-slate-800 mb-6">
        <i class="fas fa-layer-group text-3xl text-slate-600"></i>
      </div>
      <h3 class="font-display text-xl font-semibold text-white mb-2">No templates found</h3>
      <p class="text-gray-500 mb-6">No templates in this category yet.</p>
      <a href="<?= url('templates') ?>" class="btn-outline">View All Templates</a>
    </div>
    <?php endif; ?>

  </div>
</section>

<!-- ══════════════════════════════════════════════════════════
     WHY OUR TEMPLATES
     ══════════════════════════════════════════════════════════ -->
<section class="section-padding bg-slate-950/50 border-y border-slate-900">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <span class="section-tag"><i class="fas fa-star text-xs mr-1"></i> Why Choose Us</span>
      <h2 class="section-title mt-4">Everything you need to <span class="text-gradient">launch fast</span></h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php
      $features = [
        ['icon' => 'fa-mobile-screen-button', 'title' => 'Fully Responsive',    'desc' => 'Flawless on every screen — mobile, tablet, and desktop out of the box.'],
        ['icon' => 'fa-bolt',                 'title' => 'Blazing Fast',         'desc' => 'Optimized for 90+ PageSpeed scores with minimal dependencies.'],
        ['icon' => 'fa-code',                 'title' => 'Clean Source Code',    'desc' => 'Well-structured HTML, CSS & JS — easy to customize and maintain.'],
        ['icon' => 'fa-headset',              'title' => 'Dedicated Support',    'desc' => '24/7 WhatsApp & email support for customization, bugs, and queries.'],
      ];
      foreach ($features as $f): ?>
      <div class="tmpl-feature-card">
        <div class="tmpl-feature-icon">
          <i class="fas <?= $f['icon'] ?>"></i>
        </div>
        <h4 class="font-display font-bold text-white text-base mb-2"><?= $f['title'] ?></h4>
        <p class="text-gray-500 text-sm leading-relaxed"><?= $f['desc'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════════
     CTA SECTION
     ══════════════════════════════════════════════════════════ -->
<section class="section-padding">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="tmpl-cta">
      <div class="tmpl-cta-glow"></div>
      <div class="relative z-10 text-center">
        <span class="section-tag mb-4 inline-block"><i class="fas fa-paint-brush mr-1 text-xs"></i> Custom Design</span>
        <h2 class="font-display text-3xl sm:text-4xl font-bold text-white mb-4 mt-4">
          Need a Fully Custom Design?
        </h2>
        <p class="text-gray-400 mb-8 max-w-xl mx-auto">
          None of our templates fit? We design and build bespoke websites from scratch — perfectly tailored to your brand, audience, and business goals.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
          <a href="<?= url('contact') ?>" class="btn-primary">
            <i class="fas fa-paper-plane mr-2"></i>Request Custom Design
          </a>
          <a href="<?= url('projects') ?>" class="btn-outline">
            <i class="fas fa-eye mr-2"></i>See Our Work
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Scroll reveal script -->
<script>
(function() {
  const cards = document.querySelectorAll('.reveal-card');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('revealed');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.08 });
  cards.forEach(card => observer.observe(card));
})();
</script>
