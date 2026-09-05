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
     2. TOP FEATURED PROJECTS (WITH MARQUEE TAG)
     ═══════════════════════════════════════════════════════════ -->
<section class="py-14 bg-slate-950 border-b border-slate-900/80 relative overflow-hidden">
  <!-- Subtle Micro Grid Background -->
  <div class="tech-grid-wrapper"><div class="tech-grid-subtle"></div></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10 mb-8 text-center">
    <span class="section-tag"><i class="fas fa-laptop-code text-xs mr-1"></i> Top Projects Showcase</span>
    <h2 class="section-title">Top Featured <span class="text-gradient">Client Projects</span></h2>
    <p class="section-desc max-w-xl mx-auto">Explore recent web platforms, enterprise systems, and custom software delivered by EcoTech Services.</p>
  </div>

  <!-- Marquee Container (Continuous Left Scroll with Hover Pause) -->
  <div class="project-marquee-wrapper relative z-10">
    <marquee behavior="scroll" direction="left" scrollamount="6" onmouseover="this.stop();" onmouseout="this.start();">
      <?php 
      $marqueeList = !empty($featuredProjects) ? $featuredProjects : [];
      if (empty($marqueeList)) {
          $marqueeList = [
              [
                  'title' => 'Enterprise Healthcare Telehealth Platform',
                  'category' => 'Web Platform',
                  'description' => 'HIPAA-compliant web portal for real-time doctor appointments and medical telemetry.',
                  'tech_stack' => 'Next.js, Node.js, WebRTC, PostgreSQL',
                  'slug' => 'healthcare-telehealth-platform',
                  'thumbnail' => '',
                  'live_url' => ''
              ],
              [
                  'title' => 'Fintech Real-Time Payment & Analytics Engine',
                  'category' => 'Fintech Software',
                  'description' => 'High-throughput transactional API system with fraud prevention and merchant dashboards.',
                  'tech_stack' => 'React, Python, Redis, AWS',
                  'slug' => 'fintech-payment-engine',
                  'thumbnail' => '',
                  'live_url' => ''
              ],
              [
                  'title' => 'B2B Logistics & Fleet Management System',
                  'category' => 'Enterprise System',
                  'description' => 'Live vehicle telemetry, route optimization, automated invoicing, and ERP synchronization.',
                  'tech_stack' => 'TypeScript, PHP MVC, Docker, MySQL',
                  'slug' => 'logistics-management-system',
                  'thumbnail' => '',
                  'live_url' => ''
              ],
              [
                  'title' => 'Green Energy Smart Grid IoT Platform',
                  'category' => 'IoT & Analytics',
                  'description' => 'Real-time telemetry, power consumption metrics, and predictive anomaly alerts.',
                  'tech_stack' => 'React, Python, Cloudflare, PostgreSQL',
                  'slug' => 'smart-grid-platform',
                  'thumbnail' => '',
                  'live_url' => ''
              ],
          ];
      }
      // Duplicate list if small so marquee looks rich and continuous
      if (count($marqueeList) < 6) {
          $marqueeList = array_merge($marqueeList, $marqueeList);
      }


      foreach ($marqueeList as $p):
        // Use live_url for real screenshot, else local thumbnail
        $hasLive = !empty($p['live_url']);
        $localThumb = !empty($p['thumbnail']) ? $p['thumbnail'] : 'project_startup_landing.png';
      ?>
      <div class="project-marquee-card group">
        <div class="project-marquee-thumb">
          <?php if ($hasLive): ?>
          <img src="//image.thum.io/get/width/800/crop/500/noanimate/<?= Security::e(rtrim($p['live_url'], '/')) ?>"
               alt="<?= Security::e($p['title']) ?>"
               class="project-marquee-img"
               loading="lazy"
               onerror="this.src='<?= uploadUrl($localThumb) ?>'">
          <?php else: ?>
          <img src="<?= uploadUrl($localThumb) ?>" alt="<?= Security::e($p['title']) ?>" class="project-marquee-img" loading="lazy">
          <?php endif; ?>

          <span class="project-marquee-badge"><?= Security::e(ucfirst($p['category'] ?? 'Project')) ?></span>
        </div>

        <div class="project-marquee-body">
          <h3 class="font-display font-bold text-white text-base mb-1.5 group-hover:text-emerald-300 transition-colors line-clamp-1">
            <?= Security::e($p['title']) ?>
          </h3>
          <p class="text-slate-400 text-xs leading-relaxed mb-3 line-clamp-2">
            <?= Security::e(truncate($p['description'] ?? '', 85)) ?>
          </p>

          <?php if (!empty($p['tech_stack'])): ?>
          <div class="flex flex-wrap gap-1.5 mb-3">
            <?php foreach (array_slice(explode(',', $p['tech_stack']), 0, 3) as $tech): ?>
            <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300 border border-slate-800">
              <?= Security::e(trim($tech)) ?>
            </span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

          <div class="pt-2.5 border-t border-slate-800 flex items-center justify-between text-xs">
            <a href="<?= url('projects/view?slug=' . urlencode($p['slug'])) ?>" class="text-emerald-400 font-semibold hover:underline flex items-center">
              <span>View Details</span>
              <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
            </a>
            <?php if (!empty($p['live_url'])): ?>
            <a href="<?= Security::e($p['live_url']) ?>" target="_blank" class="text-slate-400 hover:text-white flex items-center text-[11px]">
              <i class="fas fa-external-link-alt mr-1"></i> Live Site
            </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </marquee>
  </div>

  <div class="text-center mt-6 relative z-10">
    <a href="<?= url('projects') ?>" class="btn-outline text-xs py-2.5 px-6 border-slate-800">
      <span>View Full Portfolio Gallery</span>
      <i class="fas fa-arrow-right ml-2 text-[11px]"></i>
    </a>
  </div>
</section>

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
