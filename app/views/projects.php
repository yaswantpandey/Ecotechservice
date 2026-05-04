<!-- ── PROJECTS / PORTFOLIO PAGE ─────────────────────────── -->

<!-- Page Hero -->
<div class="portfolio-hero">
  <div class="portfolio-hero-bg"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-40 pb-20 text-center relative z-10">
    <span class="section-tag animate-fadeInDown">Our Work</span>
    <h1 class="font-display text-5xl sm:text-6xl font-bold text-white mt-5 mb-5 animate-fadeInUp" style="animation-delay:0.1s">
      Our <span class="text-gradient">Portfolio</span>
    </h1>
    <p class="text-gray-400 text-lg max-w-2xl mx-auto animate-fadeInUp" style="animation-delay:0.2s">
      Explore our recent projects — from enterprise web apps to creative marketing campaigns.
    </p>

    <!-- Stats Bar -->
    <div class="portfolio-stats animate-fadeInUp" style="animation-delay:0.3s">
      <div class="stat-pill"><span class="stat-num">50+</span><span class="stat-label">Projects Delivered</span></div>
      <div class="stat-divider"></div>
      <div class="stat-pill"><span class="stat-num">98%</span><span class="stat-label">Client Satisfaction</span></div>
      <div class="stat-divider"></div>
      <div class="stat-pill"><span class="stat-num">12+</span><span class="stat-label">Industries Served</span></div>
    </div>
  </div>
</div>

<!-- ── Filter Tabs ─────────────────────────────────────────── -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
  <div class="portfolio-filter-bar">
    <?php
    $cats = ['' => ['label'=>'All Projects','icon'=>'fa-th-large'], 'website'=>['label'=>'Websites','icon'=>'fa-globe'], 'marketing'=>['label'=>'Marketing','icon'=>'fa-chart-bar'], 'template'=>['label'=>'Templates','icon'=>'fa-layer-group'], 'mobile'=>['label'=>'Mobile Apps','icon'=>'fa-mobile-alt']];
    foreach ($cats as $cat => $meta):
      $isActive = ($activeCategory === $cat);
    ?>
    <a href="<?= url('projects' . ($cat ? '?cat=' . $cat : '')) ?>"
       class="filter-pill <?= $isActive ? 'filter-pill--active' : '' ?>">
      <i class="fas <?= $meta['icon'] ?> mr-2 text-xs"></i><?= $meta['label'] ?>
    </a>
    <?php endforeach; ?>
  </div>
</div>

<!-- ── Project Grid ───────────────────────────────────────── -->
<section class="section-padding pt-0">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php if ($projects): ?>
    <div class="portfolio-grid" id="portfolioGrid">
      <?php foreach ($projects as $i => $p): ?>
      <article class="portfolio-card reveal-card" style="animation-delay: <?= $i * 0.08 ?>s">

        <!-- Thumbnail -->
        <div class="portfolio-thumb">
          <?php if ($p['thumbnail']): ?>
          <img src="<?= uploadUrl($p['thumbnail']) ?>"
               alt="<?= Security::e($p['title']) ?>"
               class="portfolio-img"
               loading="lazy">
          <?php else: ?>
          <div class="portfolio-placeholder">
            <i class="fas fa-code text-eco-400/20 text-6xl"></i>
          </div>
          <?php endif; ?>

          <!-- Category ribbon -->
          <div class="portfolio-ribbon">
            <?php
            $catIcons = ['website'=>'fa-globe','marketing'=>'fa-chart-bar','template'=>'fa-layer-group','mobile'=>'fa-mobile-alt','other'=>'fa-star'];
            $icon = $catIcons[$p['category']] ?? 'fa-star';
            ?>
            <i class="fas <?= $icon ?> mr-1"></i><?= ucfirst(Security::e($p['category'])) ?>
          </div>

          <?php if ($p['is_featured']): ?>
          <div class="portfolio-featured-badge">
            <i class="fas fa-star mr-1"></i>Featured
          </div>
          <?php endif; ?>

          <!-- Hover Overlay -->
          <div class="portfolio-overlay">
            <div class="portfolio-overlay-content">
              <a href="<?= url('projects/view?slug=' . urlencode($p['slug'])) ?>"
                 class="overlay-btn overlay-btn--primary">
                <i class="fas fa-eye mr-2"></i>View Project
              </a>
              <?php if ($p['live_url']): ?>
              <a href="<?= Security::e($p['live_url']) ?>" target="_blank" rel="noopener"
                 class="overlay-btn overlay-btn--outline">
                <i class="fas fa-external-link-alt mr-2"></i>Live Demo
              </a>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Card Body -->
        <div class="portfolio-body">
          <h3 class="portfolio-title"><?= Security::e($p['title']) ?></h3>
          <p class="portfolio-desc"><?= Security::e(truncate($p['description'], 110)) ?></p>

          <!-- Tech Stack -->
          <div class="portfolio-tech">
            <?php foreach (array_slice(explode(',', $p['tech_stack']), 0, 4) as $tech): ?>
            <span class="tech-chip"><?= Security::e(trim($tech)) ?></span>
            <?php endforeach; ?>
            <?php if (count(explode(',', $p['tech_stack'])) > 4): ?>
            <span class="tech-chip tech-chip--more">+<?= count(explode(',', $p['tech_stack'])) - 4 ?></span>
            <?php endif; ?>
          </div>

          <!-- Footer Link -->
          <a href="<?= url('projects/view?slug=' . urlencode($p['slug'])) ?>"
             class="portfolio-link">
            View Details <i class="fas fa-arrow-right ml-1 text-xs transition-transform group-hover:translate-x-1"></i>
          </a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <?php else: ?>
    <!-- Empty State -->
    <div class="portfolio-empty">
      <div class="portfolio-empty-icon">
        <i class="fas fa-folder-open"></i>
      </div>
      <h3 class="text-white font-display text-xl font-semibold mb-2">No projects found</h3>
      <p class="text-gray-500 mb-6">No projects in this category yet.</p>
      <a href="<?= url('projects') ?>" class="btn-primary">View All Projects</a>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- ── CTA ─────────────────────────────────────────────────── -->
<section class="section-padding pt-0">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="portfolio-cta">
      <div class="portfolio-cta-glow"></div>
      <div class="relative z-10 text-center">
        <span class="section-tag mb-4 inline-block">Start a Project</span>
        <h2 class="font-display text-3xl sm:text-4xl font-bold text-white mb-4">
          Have a project in mind?
        </h2>
        <p class="text-gray-400 mb-8 max-w-xl mx-auto">
          Let's collaborate and build something extraordinary together. Our team is ready to bring your vision to life.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
          <a href="<?= url('contact') ?>" class="btn-primary">
            <i class="fas fa-paper-plane mr-2"></i>Start a Conversation
          </a>
          <a href="<?= url('services') ?>" class="btn-outline">
            <i class="fas fa-list mr-2"></i>Our Services
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Scroll-reveal & filter animation script -->
<script>
(function() {
  // Intersection Observer for card reveal
  const cards = document.querySelectorAll('.reveal-card');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('revealed');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  cards.forEach(card => observer.observe(card));
})();
</script>
