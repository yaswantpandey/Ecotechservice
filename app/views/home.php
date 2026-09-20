<?php
// ── Key Corporate Metrics ──────────────────────────────────
$stats = [
    ['num'=>'50+',  'label'=>'Projects Delivered',   'icon'=>'fa-rocket'],
    ['num'=>'99.9%','label'=>'Uptime SLA',           'icon'=>'fa-shield-halved'],
    ['num'=>'20+',  'label'=>'Tech Solutions',       'icon'=>'fa-cubes'],
    ['num'=>'100%', 'label'=>'Source Code Ownership','icon'=>'fa-circle-check'],
];

// Core 6 Corporate Capabilities
$coreServices = [
    [
        'title' => 'Web Application Development',
        'icon'  => 'fa-code',
        'desc'  => 'High-performance web platforms, enterprise dashboards, customer portals, and scalable digital systems built with clean code.',
        'badge' => 'High Performance'
    ],
    [
        'title' => 'Cybersecurity & Audits',
        'icon'  => 'fa-shield-halved',
        'desc'  => 'Vulnerability assessments, penetration testing, data encryption standards, and OWASP compliance protection.',
        'badge' => 'Enterprise Security'
    ],
    [
        'title' => 'Custom Software Engineering',
        'icon'  => 'fa-cubes',
        'desc'  => 'Bespoke software applications engineered around your exact corporate logic, internal workflows, and business goals.',
        'badge' => 'Custom Architecture'
    ],
    [
        'title' => 'AI & Workflow Automation',
        'icon'  => 'fa-robot',
        'desc'  => 'Intelligent process automation, AI assistant integrations, automated data pipelines, and smart background workflows.',
        'badge' => 'Intelligent Tech'
    ],
    [
        'title' => 'Mobile App Development',
        'icon'  => 'fa-mobile-screen-button',
        'desc'  => 'Modern Android and cross-platform mobile apps built with fluid touch performance, offline support, and clean APIs.',
        'badge' => 'Mobile First'
    ],
    [
        'title' => 'Data & Cloud Infrastructure',
        'icon'  => 'fa-database',
        'desc'  => 'Database design, cloud migration, server optimization, CI/CD deployment, and 24/7 technical monitoring.',
        'badge' => 'Cloud Ready'
    ],
];

// Frequently Asked Questions
$faqs = [
    [
        'q' => 'What services does EcoTech Services provide?',
        'a' => 'We specialize in enterprise web application development, custom software engineering, cybersecurity assessments, AI & workflow automation, mobile application development, and cloud IT infrastructure.'
    ],
    [
        'q' => 'What is your typical project delivery timeline?',
        'a' => 'Standard business platforms and landing applications typically ship within 1 to 2 weeks. Enterprise software systems, custom APIs, and AI integrations take 3 to 6 weeks depending on requirements.'
    ],
    [
        'q' => 'Do we retain full ownership of the source code?',
        'a' => 'Yes, 100%. You receive complete source code ownership, database schemas, and documentation with zero vendor lock-in, deployable on your own server environment.'
    ],
    [
        'q' => 'Do you provide ongoing technical support and maintenance after launch?',
        'a' => 'Yes. We provide 24/7 technical support, infrastructure monitoring, security patch management, and continuous feature scaling.'
    ],
];
?>

<div id="homePageRoot" class="relative overflow-hidden" data-grid-theme="emerald">

<!-- ═══════════════════════════════════════════════════════════
     1. MINIMAL CORPORATE HERO SECTION
     ═══════════════════════════════════════════════════════════ -->
<section id="heroSection" class="relative min-h-[84vh] flex items-center overflow-hidden pt-28 pb-16 bg-slate-950 border-b border-slate-800/80">
  <!-- Subtle Background Grid System -->
  <div class="tech-grid-wrapper" id="heroGridWrapper">
    <div class="tech-grid-orbs">
      <div class="grid-orb grid-orb-1"></div>
      <div class="grid-orb grid-orb-2"></div>
      <div class="grid-orb grid-orb-3"></div>
    </div>
    <div class="tech-grid-pattern"></div>
    <div class="tech-grid-spotlight" id="heroGridSpotlight"></div>
    <div class="tech-grid-spotlight-lines" id="heroGridSpotlightLines"></div>
    <div class="tech-grid-beam"></div>
  </div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10">
    <div class="max-w-4xl mx-auto text-center space-y-6">
      
      <!-- Minimalist Corporate Badge -->
      <div class="inline-flex items-center space-x-2 bg-slate-900/90 border border-slate-800 px-4 py-1.5 rounded-full text-slate-300 text-xs font-semibold tracking-wide backdrop-blur-md">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        <span>Enterprise Software Engineering &amp; IT Digital Solutions</span>
      </div>

      <!-- Main Clean Corporate Headline -->
      <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-extrabold text-white leading-tight tracking-tight">
        Building High-Performance <br>
        <span class="text-gradient">Digital Infrastructure &amp; Software</span>
      </h1>

      <!-- Supporting Corporate Text -->
      <p class="text-lg sm:text-xl text-slate-300 leading-relaxed max-w-3xl mx-auto font-normal">
        EcoTech Services partners with startups, growing businesses, and enterprises to engineer secure, fast, and scalable digital platforms built for long-term reliability and sustainable growth.
      </p>

      <!-- Clean Action Buttons -->
      <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
        <a href="<?= url('services') ?>" class="btn-primary py-3.5 px-8 text-base justify-center w-full sm:w-auto font-semibold">
          <span>Explore Services</span>
          <i class="fas fa-arrow-right ml-2 text-sm"></i>
        </a>
        <a href="<?= url('contact') ?>" class="btn-outline py-3.5 px-8 text-base justify-center w-full sm:w-auto font-semibold border-slate-800 text-slate-200 hover:bg-slate-900">
          <span>Schedule Consultation</span>
        </a>
        <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hi+EcoTech!+I+want+to+discuss+a+project." target="_blank"
           class="inline-flex items-center justify-center space-x-2 px-6 py-3.5 bg-[#25D366] hover:bg-[#20bd5a] text-white font-semibold rounded-xl transition-all duration-200 w-full sm:w-auto text-sm shadow">
          <i class="fab fa-whatsapp text-lg"></i>
          <span>WhatsApp Direct</span>
        </a>
      </div>

      <!-- Trust Metrics Bar -->
      <div class="pt-10 border-t border-slate-900 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto text-center">
        <?php foreach ($stats as $s): ?>
        <div class="p-3">
          <div class="font-display text-2xl sm:text-3xl font-extrabold text-white tracking-tight" data-counter="<?= $s['num'] ?>"><?= $s['num'] ?></div>
          <div class="text-xs text-slate-400 font-medium mt-1"><?= $s['label'] ?></div>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     2. TOP FEATURED PROJECTS (ONE-BY-ONE INTERACTIVE SLIDER)
     ═══════════════════════════════════════════════════════════ -->
<section class="py-16 bg-slate-950 border-b border-slate-900/80 relative overflow-hidden" id="featured-projects-section">
  <!-- Subtle Micro Grid Background -->
  <div class="tech-grid-wrapper"><div class="tech-grid-subtle"></div></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10 mb-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
      <div>
        <span class="section-tag"><i class="fas fa-layer-group text-xs mr-1"></i> Featured Portfolio</span>
        <h2 class="section-title text-left mt-2">Top Featured <span class="text-gradient">Client Projects</span></h2>
        <p class="section-desc text-left max-w-xl mt-1">Explore verified live websites, digital platforms, and custom software delivered by EcoTech Services.</p>
      </div>

      <!-- Slider Controls Header (Non-Circular, Sleek Rectangular) -->
      <div class="flex items-center space-x-3 self-start md:self-end">
        <!-- Live Slide Counter Badge -->
        <div id="projectSlideCounter" class="text-xs font-mono font-semibold text-emerald-400 bg-emerald-950/60 border border-emerald-500/30 px-3.5 py-2 rounded-lg tracking-wider">
          01 / <?= str_pad((string)count($featuredProjects), 2, '0', STR_PAD_LEFT) ?>
        </div>

        <!-- Navigation Buttons -->
        <button id="projPrevBtn" class="w-10 h-10 bg-slate-900/90 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-800 hover:border-emerald-500/50 rounded-lg transition-all shadow-sm active:scale-95 flex items-center justify-center cursor-pointer" aria-label="Previous project">
          <span class="material-symbols-outlined text-xl">arrow_back</span>
        </button>
        <button id="projNextBtn" class="w-10 h-10 bg-slate-900/90 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-800 hover:border-emerald-500/50 rounded-lg transition-all shadow-sm active:scale-95 flex items-center justify-center cursor-pointer" aria-label="Next project">
          <span class="material-symbols-outlined text-xl">arrow_forward</span>
        </button>

        <a href="<?= url('projects') ?>" class="btn-outline text-xs py-2.5 px-4 rounded-lg hidden sm:inline-flex items-center space-x-1.5 border-slate-800 hover:border-slate-700">
          <span>All Projects</span>
          <i class="fas fa-arrow-right text-[10px]"></i>
        </a>
      </div>
    </div>
  </div>

  <!-- One-by-One Project Slider Track Container -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="project-slider-viewport" id="projectSliderViewport">
      <div class="project-slider-track gap-6" id="projectSliderTrack">
        <?php foreach ($featuredProjects as $p): 
          $hasLive = !empty($p['live_url']);
          $localThumb = !empty($p['thumbnail']) ? $p['thumbnail'] : 'project_startup_landing.png';
          $thumbUrl = uploadUrl($localThumb);
          $categoryLabel = ucfirst($p['category'] ?? 'Website');
        ?>
        <div class="project-slide-card group flex-shrink-0">
          <div class="project-slide-inner">
            <!-- Thumbnail Viewport -->
            <div class="project-slide-thumb relative">
              <?php if ($hasLive): ?>
              <img src="//image.thum.io/get/width/800/crop/500/noanimate/<?= Security::e(rtrim($p['live_url'], '/')) ?>"
                   alt="<?= Security::e($p['title']) ?>"
                   class="project-slide-img"
                   loading="lazy"
                   onerror="this.onerror=null; this.src='<?= $thumbUrl ?>'">
              <?php else: ?>
              <img src="<?= $thumbUrl ?>"
                   alt="<?= Security::e($p['title']) ?>"
                   class="project-slide-img"
                   loading="lazy">
              <?php endif; ?>

              <!-- Clean Rectangular Category Badge (Non-circular) -->
              <span class="absolute top-3 left-3 bg-slate-950/85 backdrop-blur-md border border-slate-700/60 text-emerald-400 text-[10px] font-mono font-semibold uppercase tracking-wider px-2.5 py-1 rounded-md">
                <?= Security::e($categoryLabel) ?>
              </span>

              <?php if (!empty($p['is_featured'])): ?>
              <span class="absolute top-3 right-3 bg-amber-500/20 backdrop-blur-md border border-amber-500/40 text-amber-300 text-[10px] font-semibold px-2 py-0.5 rounded-md flex items-center gap-1">
                <i class="fas fa-star text-[9px] text-amber-400"></i> Featured
              </span>
              <?php endif; ?>
            </div>

            <!-- Card Body -->
            <div class="p-5 flex flex-col flex-grow justify-between">
              <div>
                <h3 class="font-display font-bold text-white text-lg mb-2 group-hover:text-emerald-300 transition-colors line-clamp-1">
                  <?= Security::e($p['title']) ?>
                </h3>
                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed mb-4 line-clamp-2">
                  <?= Security::e(truncate($p['description'] ?? '', 110)) ?>
                </p>

                <!-- Tech Stack Tags -->
                <?php if (!empty($p['tech_stack'])): ?>
                <div class="flex flex-wrap gap-1.5 mb-4">
                  <?php foreach (array_slice(explode(',', $p['tech_stack']), 0, 3) as $tech): ?>
                  <span class="text-[11px] font-mono px-2.5 py-0.5 rounded-md bg-slate-950 text-slate-300 border border-slate-800">
                    <?= Security::e(trim($tech)) ?>
                  </span>
                  <?php endforeach; ?>
                </div>
                <?php endif; ?>
              </div>

              <!-- Card Action Bar -->
              <div class="pt-3.5 border-t border-slate-800/80 flex items-center justify-between text-xs mt-auto">
                <a href="<?= url('projects/view?slug=' . urlencode($p['slug'])) ?>" class="text-emerald-400 font-semibold hover:text-emerald-300 flex items-center space-x-1 transition-colors">
                  <span>View Case Study</span>
                  <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
                <?php if ($hasLive): ?>
                <a href="<?= Security::e($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white flex items-center space-x-1 text-[11px] transition-colors">
                  <span>Live Site</span>
                  <span class="material-symbols-outlined text-xs">open_in_new</span>
                </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Bottom Indicator Pills (Non-Circular Bars) -->
    <div class="flex items-center justify-center gap-2 mt-8" id="projectSliderIndicators">
      <!-- Generated via JS -->
    </div>
  </div>
</section>

<script>
// ── Top Featured Projects One-by-One Interactive Slider ──────
(function initProjectSlider() {
  const container = document.getElementById('projectSliderViewport');
  const track = document.getElementById('projectSliderTrack');
  const prevBtn = document.getElementById('projPrevBtn');
  const nextBtn = document.getElementById('projNextBtn');
  const counter = document.getElementById('projectSlideCounter');
  const indicatorsContainer = document.getElementById('projectSliderIndicators');
  
  if (!container || !track) return;

  const originalCards = Array.from(track.children);
  const totalOriginal = originalCards.length;
  if (totalOriginal === 0) return;

  // Clone original cards once for seamless infinite loop
  originalCards.forEach(card => {
    const clone = card.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    track.appendChild(clone);
  });

  let currentIndex = 0;
  let isTransitioning = false;
  let autoplayTimer = null;
  const autoplayDelay = 3500; // 3.5s per card

  function getVisibleCount() {
    if (window.innerWidth >= 1024) return 3;
    if (window.innerWidth >= 640) return 2;
    return 1;
  }

  function getCardWidth() {
    const visible = getVisibleCount();
    const gap = 24; // gap-6
    const containerWidth = container.clientWidth;
    return (containerWidth - (visible - 1) * gap) / visible;
  }

  function updateLayout() {
    const cardWidth = getCardWidth();
    const allCards = Array.from(track.children);
    allCards.forEach(card => {
      card.style.width = `${cardWidth}px`;
      card.style.flexShrink = '0';
    });
    moveTo(currentIndex, false);
    updateCounterAndIndicators();
  }

  function moveTo(index, animate = true) {
    const cardWidth = getCardWidth();
    const gap = 24;
    const offset = index * (cardWidth + gap);
    
    if (animate) {
      track.style.transition = 'transform 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
      isTransitioning = true;
    } else {
      track.style.transition = 'none';
    }
    track.style.transform = `translateX(-${offset}px)`;
    currentIndex = index;
    updateCounterAndIndicators();
  }

  function updateCounterAndIndicators() {
    const activeIndex = currentIndex % totalOriginal;
    if (counter) {
      const displayNum = String(activeIndex + 1).padStart(2, '0');
      const totalNum = String(totalOriginal).padStart(2, '0');
      counter.textContent = `${displayNum} / ${totalNum}`;
    }
    if (indicatorsContainer) {
      const dots = indicatorsContainer.querySelectorAll('.slider-indicator-pill');
      dots.forEach((dot, idx) => {
        if (idx === activeIndex) {
          dot.classList.add('bg-emerald-400', 'w-8');
          dot.classList.remove('bg-slate-800', 'w-3');
        } else {
          dot.classList.remove('bg-emerald-400', 'w-8');
          dot.classList.add('bg-slate-800', 'w-3');
        }
      });
    }
  }

  function nextSlide() {
    if (isTransitioning) return;
    moveTo(currentIndex + 1, true);
  }

  function prevSlide() {
    if (isTransitioning) return;
    if (currentIndex <= 0) {
      moveTo(totalOriginal, false);
      track.offsetHeight; // Force reflow
      moveTo(totalOriginal - 1, true);
    } else {
      moveTo(currentIndex - 1, true);
    }
  }

  track.addEventListener('transitionend', () => {
    isTransitioning = false;
    if (currentIndex >= totalOriginal) {
      const target = currentIndex - totalOriginal;
      moveTo(target, false);
    }
  });

  if (nextBtn) nextBtn.addEventListener('click', () => {
    nextSlide();
    resetAutoplay();
  });
  if (prevBtn) prevBtn.addEventListener('click', () => {
    prevSlide();
    resetAutoplay();
  });

  function startAutoplay() {
    stopAutoplay();
    autoplayTimer = setInterval(nextSlide, autoplayDelay);
  }
  function stopAutoplay() {
    if (autoplayTimer) clearInterval(autoplayTimer);
  }
  function resetAutoplay() {
    stopAutoplay();
    startAutoplay();
  }

  container.addEventListener('mouseenter', stopAutoplay);
  container.addEventListener('mouseleave', startAutoplay);

  // Touch / swipe gestures
  let touchStartX = 0;
  let touchDeltaX = 0;

  container.addEventListener('touchstart', (e) => {
    stopAutoplay();
    touchStartX = e.touches[0].clientX;
    touchDeltaX = 0;
  }, { passive: true });

  container.addEventListener('touchmove', (e) => {
    touchDeltaX = e.touches[0].clientX - touchStartX;
  }, { passive: true });

  container.addEventListener('touchend', () => {
    if (Math.abs(touchDeltaX) > 40) {
      if (touchDeltaX < 0) {
        nextSlide();
      } else {
        prevSlide();
      }
    }
    startAutoplay();
  });

  window.addEventListener('resize', () => {
    updateLayout();
  });

  // Build indicators
  if (indicatorsContainer) {
    indicatorsContainer.innerHTML = '';
    for (let i = 0; i < totalOriginal; i++) {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = `slider-indicator-pill h-1.5 transition-all duration-300 rounded-md ${i === 0 ? 'bg-emerald-400 w-8' : 'bg-slate-800 w-3 hover:bg-slate-700'}`;
      btn.setAttribute('aria-label', `Go to project ${i + 1}`);
      btn.addEventListener('click', () => {
        moveTo(i, true);
        resetAutoplay();
      });
      indicatorsContainer.appendChild(btn);
    }
  }

  updateLayout();
  startAutoplay();
})();
</script>

<!-- ═══════════════════════════════════════════════════════════
     3. CORE SERVICES & CAPABILITIES (MINIMAL CORPORATE GRID)
     ═══════════════════════════════════════════════════════════ -->
<section class="section-padding bg-slate-950 relative overflow-hidden">
  <!-- Dot Matrix Grid Overlay -->
  <div class="tech-grid-wrapper"><div class="tech-grid-dots"></div></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
    <div class="text-center mb-16">
      <span class="section-tag"><i class="fas fa-layer-group text-xs mr-1"></i> Core Capabilities</span>
      <h2 class="section-title">Specialized <span class="text-gradient">Technology Services</span></h2>
      <p class="section-desc max-w-xl mx-auto">High-performance digital engineering solutions designed to meet complex corporate standards.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($coreServices as $sv): ?>
      <div class="glass-card p-8 flex flex-col justify-between group hover:border-emerald-500/40 transition-all duration-300">
        <div>
          <!-- Icon & Header Badge -->
          <div class="flex items-center justify-between mb-6">
            <div class="w-12 h-12 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
              <i class="fas <?= Security::e($sv['icon']) ?> text-xl"></i>
            </div>
            <span class="text-[11px] font-semibold uppercase tracking-wider px-2.5 py-1 rounded-full bg-slate-900 text-slate-300 border border-slate-800">
              <?= Security::e($sv['badge']) ?>
            </span>
          </div>

          <!-- Title & Description -->
          <h3 class="font-display font-bold text-white text-xl mb-3 group-hover:text-emerald-300 transition-colors"><?= Security::e($sv['title']) ?></h3>
          <p class="text-slate-400 text-sm leading-relaxed mb-6"><?= Security::e($sv['desc']) ?></p>
        </div>

        <!-- Card Footer -->
        <div class="pt-4 border-t border-slate-900 flex items-center justify-between text-xs font-semibold">
          <span class="text-emerald-400"><i class="fas fa-check-circle mr-1.5"></i>Production Ready</span>
          <a href="<?= url('services') ?>" class="text-slate-300 group-hover:text-white flex items-center hover:underline">
            <span>Learn More</span>
            <i class="fas fa-chevron-right ml-1 text-[10px] text-emerald-400"></i>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-12">
      <a href="<?= url('services') ?>" class="btn-outline border-slate-800">
        View All Services &amp; Packages <i class="fas fa-arrow-right ml-2 text-xs"></i>
      </a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     4. CORPORATE ADVANTAGE (WHY PARTNER WITH ECOTECH)
     ═══════════════════════════════════════════════════════════ -->
<section class="section-padding bg-slate-900/40 relative overflow-hidden">
  <!-- Blueprint Grid Overlay -->
  <div class="tech-grid-wrapper"><div class="tech-grid-blueprint"></div></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
      
      <!-- Left Column: Content -->
      <div class="lg:col-span-5 space-y-6">
        <span class="section-tag"><i class="fas fa-shield-heart text-xs mr-1"></i> Corporate Advantage</span>
        <h2 class="section-title text-3xl sm:text-4xl">Engineering Digital Solutions <span class="text-gradient">With Precision</span></h2>
        <p class="text-slate-300 text-base leading-relaxed">
          We eliminate technical bloat. Our team builds clean, optimized, and secure web platforms engineered to deliver maximum speed, enterprise security, and business reliability.
        </p>

        <div class="space-y-4 pt-2">
          <div class="flex items-start space-x-3.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400 shrink-0 mt-0.5">
              <i class="fas fa-bolt text-sm"></i>
            </div>
            <div>
              <h4 class="font-display font-semibold text-white text-base">Sub-Second Performance</h4>
              <p class="text-slate-400 text-xs sm:text-sm mt-0.5">Optimized database queries and efficient architecture for fast response times.</p>
            </div>
          </div>

          <div class="flex items-start space-x-3.5">
            <div class="w-8 h-8 rounded-lg bg-sky-500/20 border border-sky-500/40 flex items-center justify-center text-sky-400 shrink-0 mt-0.5">
              <i class="fas fa-shield-halved text-sm"></i>
            </div>
            <div>
              <h4 class="font-display font-semibold text-white text-base">Bank-Grade OWASP Security</h4>
              <p class="text-slate-400 text-xs sm:text-sm mt-0.5">Protection against CSRF, SQL Injection, XSS, and data leaks built in at every layer.</p>
            </div>
          </div>

          <div class="flex items-start space-x-3.5">
            <div class="w-8 h-8 rounded-lg bg-purple-500/20 border border-purple-500/40 flex items-center justify-center text-purple-400 shrink-0 mt-0.5">
              <i class="fas fa-headset text-sm"></i>
            </div>
            <div>
              <h4 class="font-display font-semibold text-white text-base">Dedicated Engineering Support</h4>
              <p class="text-slate-400 text-xs sm:text-sm mt-0.5">Work directly with senior software engineers with transparent progress reporting.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: 4 Minimal Grid Cards -->
      <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="glass-card p-6 border-slate-800 space-y-3">
          <div class="text-emerald-400 font-mono text-xl font-bold">01.</div>
          <h3 class="font-display font-bold text-white text-lg">Clean Architecture</h3>
          <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">No bloated page builders or slow plugins. Clean hand-written code designed for agility and security.</p>
        </div>

        <div class="glass-card p-6 border-slate-800 space-y-3">
          <div class="text-sky-400 font-mono text-xl font-bold">02.</div>
          <h3 class="font-display font-bold text-white text-lg">Programmatic SEO</h3>
          <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">Built-in programmatic landing structures to capture targeted Google search traffic organically.</p>
        </div>

        <div class="glass-card p-6 border-slate-800 space-y-3">
          <div class="text-purple-400 font-mono text-xl font-bold">03.</div>
          <h3 class="font-display font-bold text-white text-lg">Scalable Modular Tech</h3>
          <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">Modular MVC architecture easily allows adding new features as your client base expands.</p>
        </div>

        <div class="glass-card p-6 border-slate-800 space-y-3">
          <div class="text-teal-400 font-mono text-xl font-bold">04.</div>
          <h3 class="font-display font-bold text-white text-lg">Full Source Ownership</h3>
          <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">100% full source code ownership and seamless deployment on your server environment.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     5. READY-TO-LAUNCH TEMPLATES (IF AVAILABLE)
     ═══════════════════════════════════════════════════════════ -->
<?php if (!empty($templates)): ?>
<section class="section-padding bg-slate-900/40 relative overflow-hidden">
  <div class="tech-grid-wrapper"><div class="tech-grid-dots"></div></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
    <div class="text-center mb-16">
      <span class="section-tag"><i class="fas fa-cubes text-xs mr-1"></i> Instant Launch</span>
      <h2 class="section-title">Ready-to-Launch <span class="text-gradient">Website Templates</span></h2>
      <p class="section-desc max-w-xl mx-auto">Get your business online in under 48 hours with our pre-built, high-converting website themes.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <?php foreach ($templates as $tmpl): ?>
      <div class="glass-card p-6 flex flex-col justify-between group">
        <div>
          <div class="h-44 rounded-xl bg-slate-900 border border-slate-800 overflow-hidden mb-5 relative">
            <?php if (!empty($tmpl['thumbnail'])): ?>
            <img src="<?= uploadUrl($tmpl['thumbnail']) ?>" alt="<?= Security::e($tmpl['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <?php else: ?>
            <div class="w-full h-full flex items-center justify-center text-slate-600">
              <i class="fas fa-laptop-code text-3xl"></i>
            </div>
            <?php endif; ?>
            <span class="absolute top-3 right-3 bg-emerald-500 text-white font-bold text-xs px-2.5 py-1 rounded-full shadow">
              ₹<?= number_format($tmpl['price'] ?? 0) ?>
            </span>
          </div>

          <h3 class="font-display font-bold text-white text-lg mb-2 group-hover:text-emerald-300 transition-colors"><?= Security::e($tmpl['title']) ?></h3>
          <p class="text-slate-400 text-xs leading-relaxed mb-4"><?= Security::e(truncate($tmpl['description'] ?? '', 100)) ?></p>
        </div>

        <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
          <a href="<?= url('templates') ?>" class="text-xs text-emerald-400 font-semibold hover:underline">View Demo &rarr;</a>
          <a href="<?= url('contact') ?>" class="btn-primary text-xs py-2 px-4">Buy Now</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════
     6. AGILE 4-STEP PROCESS ROADMAP
     ═══════════════════════════════════════════════════════════ -->
<section class="section-padding relative overflow-hidden">
  <div class="tech-grid-wrapper"><div class="tech-grid-pattern opacity-40"></div></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
    <div class="text-center mb-16">
      <span class="section-tag"><i class="fas fa-diagram-project text-xs mr-1"></i> How We Work</span>
      <h2 class="section-title">Our Streamlined <span class="text-gradient">4-Step Development Process</span></h2>
      <p class="section-desc max-w-xl mx-auto">From initial roadmap to live deployment, we follow an agile development lifecycle.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="glass-card p-6 border-slate-800 relative">
        <div class="font-mono font-bold text-2xl text-emerald-400 mb-2">01</div>
        <h3 class="font-display font-bold text-white text-lg mb-2">Strategy &amp; Scope</h3>
        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">We analyze your business goals, target audience, and functional scope to craft a precise technical blueprint.</p>
      </div>

      <div class="glass-card p-6 border-slate-800 relative">
        <div class="font-mono font-bold text-2xl text-emerald-400 mb-2">02</div>
        <h3 class="font-display font-bold text-white text-lg mb-2">UI/UX &amp; Architecture</h3>
        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">Designing clean, responsive user interfaces focused on conversion rates, accessibility, and modern aesthetics.</p>
      </div>

      <div class="glass-card p-6 border-slate-800 relative">
        <div class="font-mono font-bold text-2xl text-emerald-400 mb-2">03</div>
        <h3 class="font-display font-bold text-white text-lg mb-2">Agile Engineering</h3>
        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">Developing your web application using clean code standards, secure database design, and fast API endpoints.</p>
      </div>

      <div class="glass-card p-6 border-slate-800 relative">
        <div class="font-mono font-bold text-2xl text-emerald-400 mb-2">04</div>
        <h3 class="font-display font-bold text-white text-lg mb-2">Deployment &amp; Growth</h3>
        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">Rigorous testing, cloud deployment, SEO setup, and continuous post-launch optimization to drive results.</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     7. CLIENT TESTIMONIALS
     ═══════════════════════════════════════════════════════════ -->
<?php if (!empty($testimonials)): ?>
<section class="section-padding bg-slate-900/40 relative overflow-hidden">
  <div class="tech-grid-wrapper"><div class="tech-grid-dots opacity-60"></div></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
    <div class="text-center mb-16">
      <span class="section-tag"><i class="fas fa-quote-left text-xs mr-1"></i> Client Feedback</span>
      <h2 class="section-title">Trusted By <span class="text-gradient">Founders &amp; Businesses</span></h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <?php foreach ($testimonials as $t): ?>
      <div class="glass-card p-7 flex flex-col justify-between">
        <div>
          <div class="flex items-center space-x-1 mb-4">
            <?= stars((int)$t['rating']) ?>
          </div>
          <p class="text-slate-200 text-sm sm:text-base leading-relaxed italic mb-6">"<?= Security::e($t['message']) ?>"</p>
        </div>

        <div class="flex items-center space-x-3.5 pt-4 border-t border-slate-800">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-sky-500 flex items-center justify-center text-white font-bold text-sm shadow">
            <?= strtoupper(substr($t['name'], 0, 1)) ?>
          </div>
          <div>
            <div class="font-display font-semibold text-white text-sm"><?= Security::e($t['name']) ?></div>
            <div class="text-slate-400 text-xs"><?= Security::e($t['position'] . ($t['company'] ? ', ' . $t['company'] : '')) ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════
     8. FREQUENTLY ASKED QUESTIONS
     ═══════════════════════════════════════════════════════════ -->
<section class="section-padding relative overflow-hidden">
  <div class="tech-grid-wrapper"><div class="tech-grid-subtle"></div></div>

  <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
    <div class="text-center mb-14">
      <span class="section-tag"><i class="fas fa-circle-question text-xs mr-1"></i> Got Questions?</span>
      <h2 class="section-title">Frequently Asked <span class="text-gradient">Questions</span></h2>
      <p class="section-desc">Clear answers regarding our development and cybersecurity processes.</p>
    </div>

    <div class="space-y-4">
      <?php foreach ($faqs as $idx => $f): ?>
      <div class="faq-item <?= $idx === 0 ? 'active' : '' ?>">
        <button type="button" class="faq-button">
          <span><?= Security::e($f['q']) ?></span>
          <i class="fas fa-chevron-down faq-icon text-sm ml-4"></i>
        </button>
        <div class="faq-answer">
          <p><?= Security::e($f['a']) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     9. CORPORATE CALL TO ACTION BANNER
     ═══════════════════════════════════════════════════════════ -->
<section class="section-padding relative overflow-hidden">
  <div class="tech-grid-wrapper"><div class="tech-grid-blueprint opacity-35"></div></div>

  <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
    <div class="glass-card cta-card relative p-8 sm:p-14 text-center overflow-hidden border border-emerald-500/30">
      <div class="relative z-10 space-y-6">
        <span class="inline-flex items-center space-x-2 bg-slate-900 border border-slate-800 px-3.5 py-1.5 rounded-full text-emerald-300 text-xs font-semibold">
          <span>✦ Partner With EcoTech Services</span>
        </span>

        <h2 class="font-display text-3xl sm:text-5xl font-extrabold text-white leading-tight">
          Ready to Build Your Next <br class="hidden sm:inline">
          <span class="text-gradient">Digital Technology Platform?</span>
        </h2>

        <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto font-normal">
          Get in touch with EcoTech Services today for a transparent, non-binding technical proposal within 24 hours.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
          <a href="<?= url('contact') ?>" class="btn-primary text-base py-3.5 px-8 w-full sm:w-auto">
            Get Started <i class="fas fa-arrow-right ml-2 text-sm"></i>
          </a>
          <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hi+EcoTech!+I+want+to+discuss+a+project." target="_blank"
             class="flex items-center justify-center space-x-2 px-7 py-3.5 bg-[#25D366] hover:bg-[#20bd5a] text-white font-semibold rounded-xl shadow-lg transition-all duration-200 w-full sm:w-auto text-base">
            <i class="fab fa-whatsapp text-xl"></i>
            <span>Chat on WhatsApp</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

</div><!-- /#homePageRoot -->

<!-- ═══════════════════════════════════════════════════════════
     10. INTERACTIVE MOUSE SPOTLIGHT ON HERO GRID
     ═══════════════════════════════════════════════════════════ -->
<script>
(function() {
  const hero = document.getElementById('heroSection');
  const spotlight = document.getElementById('heroGridSpotlight');

  // Dynamic mouse-following spotlight torch on hero grid
  if (hero && spotlight) {
    let ticking = false;

    hero.addEventListener('mousemove', function(e) {
      if (!ticking) {
        window.requestAnimationFrame(function() {
          const rect = hero.getBoundingClientRect();
          const x = ((e.clientX - rect.left) / rect.width) * 100;
          const y = ((e.clientY - rect.top) / rect.height) * 100;

          hero.style.setProperty('--mouse-x', x.toFixed(2) + '%');
          hero.style.setProperty('--mouse-y', y.toFixed(2) + '%');
          ticking = false;
        });
        ticking = true;
      }
    });

    hero.addEventListener('mouseleave', function() {
      hero.style.setProperty('--mouse-x', '50%');
      hero.style.setProperty('--mouse-y', '35%');
    });
  }
})();
</script>
