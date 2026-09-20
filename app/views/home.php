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

// Differentiators (left column of the advantage section)
$advantages = [
    [
        'icon'  => 'fa-bolt',
        'title' => 'Sub-Second Performance',
        'desc'  => 'Optimized database queries and efficient architecture for fast response times.',
    ],
    [
        'icon'  => 'fa-shield-halved',
        'title' => 'Bank-Grade OWASP Security',
        'desc'  => 'Protection against CSRF, SQL injection, XSS, and data leaks built in at every layer.',
    ],
    [
        'icon'  => 'fa-headset',
        'title' => 'Dedicated Engineering Support',
        'desc'  => 'Work directly with senior software engineers with transparent progress reporting.',
    ],
];

// Numbered proof points (right column of the advantage section)
$principles = [
    ['no'=>'01', 'title'=>'Clean Architecture',    'desc'=>'No bloated page builders or slow plugins. Clean hand-written code designed for agility and security.'],
    ['no'=>'02', 'title'=>'Programmatic SEO',      'desc'=>'Built-in programmatic landing structures to capture targeted Google search traffic organically.'],
    ['no'=>'03', 'title'=>'Scalable Modular Tech', 'desc'=>'Modular MVC architecture easily allows adding new features as your client base expands.'],
    ['no'=>'04', 'title'=>'Full Source Ownership', 'desc'=>'100% full source code ownership and seamless deployment on your server environment.'],
];

// Delivery process
$process = [
    ['no'=>'01', 'title'=>'Strategy & Scope',       'desc'=>'We analyze your business goals, target audience, and functional scope to craft a precise technical blueprint.'],
    ['no'=>'02', 'title'=>'UI/UX & Architecture',   'desc'=>'Designing clean, responsive user interfaces focused on conversion rates, accessibility, and modern aesthetics.'],
    ['no'=>'03', 'title'=>'Agile Engineering',      'desc'=>'Developing your web application using clean code standards, secure database design, and fast API endpoints.'],
    ['no'=>'04', 'title'=>'Deployment & Growth',    'desc'=>'Rigorous testing, cloud deployment, SEO setup, and continuous post-launch optimization to drive results.'],
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

$waNumber = rawurlencode(setting('whatsapp_number'));
$waText   = rawurlencode('Hi EcoTech! I want to discuss a project.');
$waLink   = 'https://wa.me/' . $waNumber . '?text=' . $waText;
?>

<style>
/* ==========================================================
   Home page refinement layer (scoped to #homePageRoot)
   Calmer surfaces, stronger type hierarchy, hairline rules.
   ========================================================== */
#homePageRoot {
  --hp-accent:   #22c55e;
  --hp-accent-2: #4ade80;
  --hp-line:     rgba(148, 163, 184, 0.14);
  --hp-line-str: rgba(148, 163, 184, 0.26);
  --hp-surface:  rgba(15, 23, 42, 0.55);
}

/* ── Rhythm ───────────────────────────────────────────────── */
#homePageRoot .hp-section { padding: 5.5rem 0; position: relative; }
#homePageRoot .hp-section--tight { padding: 4rem 0; }
#homePageRoot .hp-rule { border-top: 1px solid var(--hp-line); }
#homePageRoot .hp-shell { max-width: 80rem; margin: 0 auto; padding: 0 1rem; }
@media (min-width: 640px) { #homePageRoot .hp-shell { padding: 0 1.5rem; } }
@media (min-width: 1024px) { #homePageRoot .hp-shell { padding: 0 2rem; } }

/* ── Section headers ──────────────────────────────────────── */
#homePageRoot .hp-eyebrow {
  display: inline-flex; align-items: center; gap: 0.5rem;
  font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.14em;
  text-transform: uppercase; color: #94a3b8;
}
#homePageRoot .hp-eyebrow::before {
  content: ''; width: 1.5rem; height: 1px; background: var(--hp-accent);
}
#homePageRoot .hp-h2 {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-weight: 700; color: #fff; letter-spacing: -0.02em;
  font-size: clamp(1.75rem, 3.4vw, 2.5rem); line-height: 1.15;
  margin: 0.875rem 0 0;
}
#homePageRoot .hp-lead {
  color: #94a3b8; font-size: 0.9375rem; line-height: 1.7;
  margin: 0.875rem 0 0; max-width: 34rem;
}
#homePageRoot .hp-head-center { text-align: center; }
#homePageRoot .hp-head-center .hp-lead { margin-left: auto; margin-right: auto; }

/* ── Hero ─────────────────────────────────────────────────── */
#homePageRoot .hp-hero-title {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-weight: 800; color: #fff; letter-spacing: -0.035em;
  font-size: clamp(2.25rem, 6vw, 4.25rem); line-height: 1.04;
}
#homePageRoot .hp-hero-accent {
  width: 4.5rem; height: 3px; border-radius: 2px;
  background: linear-gradient(90deg, var(--hp-accent), rgba(34,197,94,0));
}
#homePageRoot .hp-hero-sub {
  color: #cbd5e1; font-size: 1.0625rem; line-height: 1.75; max-width: 38rem;
}
#homePageRoot .hp-status {
  display: inline-flex; align-items: center; gap: 0.5rem;
  font-size: 0.75rem; font-weight: 600; color: #cbd5e1;
  padding: 0.375rem 0.875rem; border-radius: 999px;
  background: rgba(2, 6, 23, 0.6); border: 1px solid var(--hp-line);
  backdrop-filter: blur(8px);
}
#homePageRoot .hp-status i { color: var(--hp-accent-2); font-size: 0.6875rem; }

/* Inline stat strip with hairline separators */
#homePageRoot .hp-stats {
  display: grid; grid-template-columns: repeat(2, minmax(0, 1fr));
  border-top: 1px solid var(--hp-line);
}
@media (min-width: 768px) { #homePageRoot .hp-stats { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
#homePageRoot .hp-stat { padding: 1.5rem 1.25rem 0; }
#homePageRoot .hp-stat + .hp-stat { border-left: 1px solid var(--hp-line); }
@media (max-width: 767px) {
  #homePageRoot .hp-stat:nth-child(odd) { border-left: 0; }
  #homePageRoot .hp-stat:nth-child(n+3) { border-top: 1px solid var(--hp-line); padding-top: 1.25rem; margin-top: 1.25rem; }
}
#homePageRoot .hp-stat-num {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-size: 1.875rem; font-weight: 700; color: #fff; letter-spacing: -0.02em;
}
#homePageRoot .hp-stat-label {
  font-size: 0.75rem; color: #94a3b8; margin-top: 0.25rem; line-height: 1.5;
}

/* ── Hairline card grid (services) ────────────────────────── */
#homePageRoot .hp-grid {
  display: grid; gap: 1px; background: var(--hp-line);
  border: 1px solid var(--hp-line); border-radius: 0.875rem; overflow: hidden;
}
@media (min-width: 640px) { #homePageRoot .hp-grid-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (min-width: 1024px) { #homePageRoot .hp-grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
@media (min-width: 640px) { #homePageRoot .hp-grid-4 { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (min-width: 1024px) { #homePageRoot .hp-grid-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); } }

#homePageRoot .hp-cell {
  background: #020617; padding: 2rem 1.75rem;
  display: flex; flex-direction: column;
  transition: background-color .25s ease;
}
#homePageRoot .hp-cell:hover { background: rgba(15, 23, 42, 0.75); }
#homePageRoot .hp-cell-icon {
  width: 2.75rem; height: 2.75rem; border-radius: 0.75rem;
  display: inline-flex; align-items: center; justify-content: center;
  color: var(--hp-accent-2); background: rgba(34, 197, 94, 0.08);
  border: 1px solid rgba(34, 197, 94, 0.2);
  transition: background-color .25s ease, color .25s ease;
}
#homePageRoot .hp-cell:hover .hp-cell-icon { background: var(--hp-accent); color: #04140a; }
#homePageRoot .hp-cell-title {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-size: 1.0625rem; font-weight: 700; color: #f1f5f9;
  margin: 1.25rem 0 0.625rem; letter-spacing: -0.01em;
}
#homePageRoot .hp-cell-desc { color: #94a3b8; font-size: 0.875rem; line-height: 1.7; }
#homePageRoot .hp-cell-meta {
  margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--hp-line);
  display: flex; align-items: center; justify-content: space-between;
  font-size: 0.75rem; font-weight: 600;
}
#homePageRoot .hp-cell-link { color: #cbd5e1; display: inline-flex; align-items: center; gap: 0.375rem; transition: color .2s; }
#homePageRoot .hp-cell:hover .hp-cell-link { color: var(--hp-accent-2); }
#homePageRoot .hp-num {
  font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  font-size: 0.8125rem; font-weight: 700; color: var(--hp-accent-2);
  letter-spacing: 0.08em;
}

/* ── Advantage list ───────────────────────────────────────── */
#homePageRoot .hp-adv { display: flex; gap: 1rem; padding: 1.5rem 0; border-top: 1px solid var(--hp-line); }
#homePageRoot .hp-adv-icon {
  width: 2.25rem; height: 2.25rem; border-radius: 0.625rem; flex-shrink: 0;
  display: inline-flex; align-items: center; justify-content: center;
  color: var(--hp-accent-2); background: rgba(34, 197, 94, 0.1);
  border: 1px solid rgba(34, 197, 94, 0.22); font-size: 0.8125rem;
}
#homePageRoot .hp-adv-title {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-size: 0.9375rem; font-weight: 600; color: #f1f5f9;
}
#homePageRoot .hp-adv-desc { color: #94a3b8; font-size: 0.8125rem; line-height: 1.65; margin-top: 0.25rem; }

/* ── Panels (templates / testimonials) ────────────────────── */
#homePageRoot .hp-panel {
  background: var(--hp-surface); border: 1px solid var(--hp-line);
  border-radius: 0.875rem; padding: 1.5rem;
  display: flex; flex-direction: column;
  transition: border-color .25s ease, transform .25s ease;
}
#homePageRoot .hp-panel:hover { border-color: var(--hp-line-str); transform: translateY(-2px); }
#homePageRoot .hp-thumb {
  height: 11rem; border-radius: 0.625rem; overflow: hidden; position: relative;
  background: #020617; border: 1px solid var(--hp-line);
}
#homePageRoot .hp-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
#homePageRoot .hp-panel:hover .hp-thumb img { transform: scale(1.04); }
#homePageRoot .hp-price {
  position: absolute; top: 0.625rem; right: 0.625rem;
  font-size: 0.6875rem; font-weight: 700; color: #04140a;
  background: var(--hp-accent); padding: 0.25rem 0.5rem; border-radius: 0.375rem;
}
#homePageRoot .hp-quote { color: #e2e8f0; font-size: 0.9375rem; line-height: 1.75; }
#homePageRoot .hp-avatar {
  width: 2.5rem; height: 2.5rem; border-radius: 999px; flex-shrink: 0;
  display: inline-flex; align-items: center; justify-content: center;
  font-weight: 700; font-size: 0.8125rem; color: #04140a;
  background: linear-gradient(135deg, var(--hp-accent-2), #0ea5e9);
}

/* ── CTA ──────────────────────────────────────────────────── */
#homePageRoot .hp-cta {
  border: 1px solid rgba(34, 197, 94, 0.28); border-radius: 1.125rem;
  background:
    radial-gradient(120% 140% at 50% 0%, rgba(34, 197, 94, 0.12), transparent 62%),
    rgba(2, 6, 23, 0.72);
  padding: 3.5rem 1.5rem; text-align: center; position: relative; overflow: hidden;
}
@media (min-width: 640px) { #homePageRoot .hp-cta { padding: 4.5rem 3.5rem; } }
#homePageRoot .hp-cta-title {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-weight: 800; color: #fff; letter-spacing: -0.03em;
  font-size: clamp(1.875rem, 4.2vw, 3rem); line-height: 1.1;
}

/* ── WhatsApp link (demoted from a solid button) ──────────── */
#homePageRoot .hp-wa {
  display: inline-flex; align-items: center; gap: 0.5rem;
  font-size: 0.875rem; font-weight: 600; color: #94a3b8;
  transition: color .2s ease;
}
#homePageRoot .hp-wa:hover { color: #25D366; }
#homePageRoot .hp-wa i { color: #25D366; font-size: 1.0625rem; }

/* ── Slider header controls ───────────────────────────────── */
#homePageRoot .hp-ctrl {
  width: 2.5rem; height: 2.5rem; border-radius: 0.5rem;
  display: inline-flex; align-items: center; justify-content: center;
  color: #cbd5e1; background: rgba(2, 6, 23, 0.7);
  border: 1px solid var(--hp-line); cursor: pointer;
  transition: border-color .2s ease, color .2s ease, background-color .2s ease;
}
#homePageRoot .hp-ctrl:hover { color: #fff; border-color: rgba(34,197,94,0.45); background: rgba(15,23,42,0.9); }
#homePageRoot .hp-ctrl:active { transform: scale(0.95); }
#homePageRoot .hp-counter {
  font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  font-size: 0.75rem; font-weight: 600; letter-spacing: 0.1em;
  color: var(--hp-accent-2); padding: 0.5rem 0.75rem; border-radius: 0.5rem;
  background: rgba(34, 197, 94, 0.08); border: 1px solid rgba(34, 197, 94, 0.22);
}

/* ── FAQ refinement (keeps .faq-* JS hooks intact) ────────── */
#homePageRoot .faq-item { border-radius: 0.75rem; }

@media (prefers-reduced-motion: reduce) {
  #homePageRoot * { transition: none !important; animation: none !important; }
}
</style>

<div id="homePageRoot" class="relative overflow-hidden" data-grid-theme="emerald">

<!-- ==========================================================
     1. HERO
     ========================================================== -->
<section id="heroSection" class="relative flex items-center overflow-hidden pt-28 pb-20 bg-slate-950 hp-rule" style="min-height:82vh">
  <!-- Single restrained grid texture + mouse spotlight -->
  <div class="tech-grid-wrapper" id="heroGridWrapper">
    <div class="tech-grid-pattern"></div>
    <div class="tech-grid-spotlight" id="heroGridSpotlight"></div>
  </div>

  <div class="hp-shell relative z-10 w-full">
    <div class="max-w-4xl">

      <div class="hp-status">
        <i class="fas fa-circle"></i>
        <span>Enterprise Software Engineering &amp; IT Solutions</span>
      </div>

      <h1 class="hp-hero-title mt-7">
        Web engineering &amp;<br>
        security, <span class="text-gradient">delivered.</span>
      </h1>

      <div class="hp-hero-accent mt-7"></div>

      <p class="hp-hero-sub mt-6">
        EcoTech Services engineers secure, fast, and scalable digital platforms for startups,
        growing businesses, and enterprises &mdash; built for long-term reliability.
      </p>

      <div class="flex flex-col sm:flex-row sm:items-center gap-4 mt-9">
        <a href="<?= url('contact') ?>" class="btn-primary py-3.5 px-8 text-base justify-center font-semibold">
          <span>Start a project</span>
          <i class="fas fa-arrow-right ml-2 text-sm"></i>
        </a>
        <a href="<?= url('projects') ?>" class="btn-outline py-3.5 px-7 text-base justify-center font-semibold border-slate-800 text-slate-200 hover:bg-slate-900">
          <span>See our work</span>
        </a>
        <a href="<?= Security::e($waLink) ?>" target="_blank" rel="noopener noreferrer" class="hp-wa sm:ml-2 justify-center sm:justify-start">
          <i class="fab fa-whatsapp"></i>
          <span>or message us on WhatsApp</span>
        </a>
      </div>

      <div class="hp-stats mt-14">
        <?php foreach ($stats as $s): ?>
        <div class="hp-stat">
          <div class="hp-stat-num" data-counter="<?= Security::e($s['num']) ?>"><?= Security::e($s['num']) ?></div>
          <div class="hp-stat-label"><?= Security::e($s['label']) ?></div>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</section>

<!-- ==========================================================
     2. FEATURED PROJECTS (one-by-one slider)
     ========================================================== -->
<section class="hp-section hp-section--tight bg-slate-950 hp-rule relative overflow-hidden" id="featured-projects-section">
  <div class="hp-shell relative z-10">

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
      <div>
        <span class="hp-eyebrow">Featured Portfolio</span>
        <h2 class="hp-h2">Selected <span class="text-gradient">client work</span></h2>
        <p class="hp-lead">Verified live websites, digital platforms, and custom software delivered by EcoTech Services.</p>
      </div>

      <div class="flex items-center gap-3 shrink-0">
        <div id="projectSlideCounter" class="hp-counter">
          01 / <?= str_pad((string)count($featuredProjects), 2, '0', STR_PAD_LEFT) ?>
        </div>
        <button id="projPrevBtn" type="button" class="hp-ctrl" aria-label="Previous project">
          <span class="material-symbols-outlined text-xl">arrow_back</span>
        </button>
        <button id="projNextBtn" type="button" class="hp-ctrl" aria-label="Next project">
          <span class="material-symbols-outlined text-xl">arrow_forward</span>
        </button>
        <a href="<?= url('projects') ?>" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-slate-300 hover:text-white transition-colors ml-1">
          <span>All projects</span>
          <i class="fas fa-arrow-right text-[10px] text-eco-400"></i>
        </a>
      </div>
    </div>

    <div class="project-slider-viewport" id="projectSliderViewport">
      <div class="project-slider-track gap-6" id="projectSliderTrack">
        <?php foreach ($featuredProjects as $p):
          $hasLive       = !empty($p['live_url']);
          $localThumb    = !empty($p['thumbnail']) ? $p['thumbnail'] : 'project_startup_landing.png';
          $thumbUrl      = uploadUrl($localThumb);
          $categoryLabel = ucfirst($p['category'] ?? 'Website');
        ?>
        <div class="project-slide-card group flex-shrink-0">
          <div class="project-slide-inner">
            <div class="project-slide-thumb relative">
              <?php if ($hasLive): ?>
              <img src="//image.thum.io/get/width/800/crop/500/noanimate/<?= Security::e(rtrim($p['live_url'], '/')) ?>"
                   alt="<?= Security::e($p['title']) ?>"
                   class="project-slide-img"
                   loading="lazy"
                   onerror="this.onerror=null; this.src='<?= Security::e($thumbUrl) ?>'">
              <?php else: ?>
              <img src="<?= Security::e($thumbUrl) ?>"
                   alt="<?= Security::e($p['title']) ?>"
                   class="project-slide-img"
                   loading="lazy">
              <?php endif; ?>

              <span class="absolute top-3 left-3 bg-slate-950/85 backdrop-blur-md border border-slate-700/60 text-eco-400 text-[10px] font-mono font-semibold uppercase tracking-wider px-2.5 py-1 rounded-md">
                <?= Security::e($categoryLabel) ?>
              </span>

              <?php if (!empty($p['is_featured'])): ?>
              <span class="absolute top-3 right-3 bg-slate-950/85 backdrop-blur-md border border-amber-500/40 text-amber-300 text-[10px] font-semibold px-2 py-1 rounded-md inline-flex items-center gap-1">
                <i class="fas fa-star text-[9px] text-amber-400"></i> Featured
              </span>
              <?php endif; ?>
            </div>

            <div class="p-5 flex flex-col flex-grow justify-between">
              <div>
                <h3 class="font-display font-bold text-white text-lg mb-2 group-hover:text-eco-300 transition-colors line-clamp-1">
                  <?= Security::e($p['title']) ?>
                </h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4 line-clamp-2">
                  <?= Security::e(truncate($p['description'] ?? '', 110)) ?>
                </p>

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

              <div class="pt-3.5 border-t border-slate-800/80 flex items-center justify-between text-xs mt-auto">
                <a href="<?= url('projects/view?slug=' . urlencode($p['slug'])) ?>" class="text-eco-400 font-semibold hover:text-eco-300 flex items-center gap-1 transition-colors">
                  <span>View case study</span>
                  <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
                <?php if ($hasLive): ?>
                <a href="<?= Security::e($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white flex items-center gap-1 text-[11px] transition-colors">
                  <span>Live site</span>
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

    <div class="flex items-center justify-center gap-2 mt-8" id="projectSliderIndicators">
      <!-- Generated via JS -->
    </div>

  </div>
</section>

<script>
// ── Featured projects: one-by-one infinite slider ────────────
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

  // Clone original cards once for a seamless infinite loop
  originalCards.forEach(card => {
    const clone = card.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    track.appendChild(clone);
  });

  let currentIndex = 0;
  let isTransitioning = false;
  let autoplayTimer = null;
  const autoplayDelay = 4500;
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

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
    Array.from(track.children).forEach(card => {
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

    if (animate && !prefersReducedMotion) {
      track.style.transition = 'transform 0.55s cubic-bezier(0.22, 1, 0.36, 1)';
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
      indicatorsContainer.querySelectorAll('.slider-indicator-pill').forEach((dot, idx) => {
        const active = idx === activeIndex;
        dot.style.width = active ? '2rem' : '0.75rem';
        dot.style.background = active ? '#4ade80' : 'rgba(148,163,184,0.28)';
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
      void track.offsetHeight; // force reflow
      moveTo(totalOriginal - 1, true);
    } else {
      moveTo(currentIndex - 1, true);
    }
  }

  track.addEventListener('transitionend', () => {
    isTransitioning = false;
    if (currentIndex >= totalOriginal) {
      moveTo(currentIndex - totalOriginal, false);
    }
  });

  if (nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); resetAutoplay(); });
  if (prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); resetAutoplay(); });

  function startAutoplay() {
    if (prefersReducedMotion) return;
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
  container.addEventListener('focusin', stopAutoplay);

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
      touchDeltaX < 0 ? nextSlide() : prevSlide();
    }
    startAutoplay();
  });

  window.addEventListener('resize', updateLayout);

  // Build indicators
  if (indicatorsContainer) {
    indicatorsContainer.innerHTML = '';
    for (let i = 0; i < totalOriginal; i++) {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'slider-indicator-pill';
      btn.style.cssText = 'height:0.375rem;border-radius:999px;border:0;padding:0;cursor:pointer;transition:width .3s ease,background-color .3s ease;' +
                          (i === 0 ? 'width:2rem;background:#4ade80;' : 'width:0.75rem;background:rgba(148,163,184,0.28);');
      btn.setAttribute('aria-label', `Go to project ${i + 1}`);
      btn.addEventListener('click', () => { moveTo(i, true); resetAutoplay(); });
      indicatorsContainer.appendChild(btn);
    }
  }

  updateLayout();
  startAutoplay();
})();
</script>

<!-- ==========================================================
     3. CORE CAPABILITIES
     ========================================================== -->
<section class="hp-section bg-slate-950 relative overflow-hidden">
  <div class="hp-shell relative z-10">

    <div class="hp-head-center mb-14">
      <span class="hp-eyebrow">Core Capabilities</span>
      <h2 class="hp-h2">Specialized <span class="text-gradient">technology services</span></h2>
      <p class="hp-lead">High-performance digital engineering built to meet complex corporate standards.</p>
    </div>

    <div class="hp-grid hp-grid-2 hp-grid-3">
      <?php foreach ($coreServices as $sv): ?>
      <div class="hp-cell group">
        <div class="flex items-start justify-between gap-4">
          <span class="hp-cell-icon">
            <i class="fas <?= Security::e($sv['icon']) ?> text-lg"></i>
          </span>
          <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-500 pt-1"><?= Security::e($sv['badge']) ?></span>
        </div>

        <h3 class="hp-cell-title"><?= Security::e($sv['title']) ?></h3>
        <p class="hp-cell-desc flex-grow"><?= Security::e($sv['desc']) ?></p>

        <div class="hp-cell-meta">
          <span class="text-slate-500"><i class="fas fa-circle-check mr-1.5 text-eco-500/70"></i>Production ready</span>
          <a href="<?= url('services') ?>" class="hp-cell-link">
            <span>Learn more</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-12">
      <a href="<?= url('services') ?>" class="btn-outline border-slate-800">
        View all services &amp; packages <i class="fas fa-arrow-right ml-2 text-xs"></i>
      </a>
    </div>

  </div>
</section>

<!-- ==========================================================
     4. WHY ECOTECH
     ========================================================== -->
<section class="hp-section hp-rule relative overflow-hidden">
  <div class="hp-shell relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-14 lg:gap-16 items-start">

      <div class="lg:col-span-5">
        <span class="hp-eyebrow">Why EcoTech</span>
        <h2 class="hp-h2">Engineering digital systems <span class="text-gradient">with precision</span></h2>
        <p class="hp-lead">
          We eliminate technical bloat. Clean, optimized, secure web platforms engineered for
          maximum speed, enterprise security, and business reliability.
        </p>

        <div class="mt-10">
          <?php foreach ($advantages as $a): ?>
          <div class="hp-adv">
            <span class="hp-adv-icon"><i class="fas <?= Security::e($a['icon']) ?>"></i></span>
            <div>
              <h4 class="hp-adv-title"><?= Security::e($a['title']) ?></h4>
              <p class="hp-adv-desc"><?= Security::e($a['desc']) ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="lg:col-span-7">
        <div class="hp-grid hp-grid-2">
          <?php foreach ($principles as $pr): ?>
          <div class="hp-cell">
            <span class="hp-num"><?= Security::e($pr['no']) ?></span>
            <h3 class="hp-cell-title"><?= Security::e($pr['title']) ?></h3>
            <p class="hp-cell-desc"><?= Security::e($pr['desc']) ?></p>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ==========================================================
     5. READY-TO-LAUNCH TEMPLATES
     ========================================================== -->
<?php if (!empty($templates)): ?>
<section class="hp-section hp-rule bg-slate-950 relative overflow-hidden">
  <div class="hp-shell relative z-10">

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
      <div>
        <span class="hp-eyebrow">Instant Launch</span>
        <h2 class="hp-h2">Ready-to-launch <span class="text-gradient">website templates</span></h2>
        <p class="hp-lead">Get your business online in under 48 hours with pre-built, high-converting themes.</p>
      </div>
      <a href="<?= url('templates') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-300 hover:text-white transition-colors shrink-0">
        <span>Browse all templates</span>
        <i class="fas fa-arrow-right text-[10px] text-eco-400"></i>
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php foreach ($templates as $tmpl): ?>
      <div class="hp-panel">
        <div class="hp-thumb">
          <?php if (!empty($tmpl['thumbnail'])): ?>
          <img src="<?= Security::e(uploadUrl($tmpl['thumbnail'])) ?>" alt="<?= Security::e($tmpl['title']) ?>" loading="lazy">
          <?php else: ?>
          <div class="w-full h-full flex items-center justify-center text-slate-700">
            <i class="fas fa-laptop-code text-3xl"></i>
          </div>
          <?php endif; ?>
          <span class="hp-price">&#8377;<?= number_format((float)($tmpl['price'] ?? 0)) ?></span>
        </div>

        <h3 class="hp-cell-title"><?= Security::e($tmpl['title']) ?></h3>
        <p class="hp-cell-desc flex-grow"><?= Security::e(truncate($tmpl['description'] ?? '', 100)) ?></p>

        <div class="hp-cell-meta">
          <a href="<?= url('templates') ?>" class="text-eco-400 hover:text-eco-300 transition-colors">View demo &rarr;</a>
          <a href="<?= url('contact') ?>" class="btn-primary text-xs py-2 px-4">Buy now</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
<?php endif; ?>

<!-- ==========================================================
     6. DELIVERY PROCESS
     ========================================================== -->
<section class="hp-section hp-rule relative overflow-hidden">
  <div class="hp-shell relative z-10">

    <div class="hp-head-center mb-14">
      <span class="hp-eyebrow">How We Work</span>
      <h2 class="hp-h2">A streamlined <span class="text-gradient">four-step process</span></h2>
      <p class="hp-lead">From initial roadmap to live deployment, we follow an agile development lifecycle.</p>
    </div>

    <div class="hp-grid hp-grid-4">
      <?php foreach ($process as $st): ?>
      <div class="hp-cell">
        <span class="hp-num"><?= Security::e($st['no']) ?></span>
        <h3 class="hp-cell-title"><?= Security::e($st['title']) ?></h3>
        <p class="hp-cell-desc"><?= Security::e($st['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- ==========================================================
     7. CLIENT TESTIMONIALS
     ========================================================== -->
<?php if (!empty($testimonials)): ?>
<section class="hp-section hp-rule bg-slate-950 relative overflow-hidden">
  <div class="hp-shell relative z-10">

    <div class="hp-head-center mb-14">
      <span class="hp-eyebrow">Client Feedback</span>
      <h2 class="hp-h2">Trusted by <span class="text-gradient">founders &amp; businesses</span></h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <?php foreach ($testimonials as $t):
        $role = trim((string)($t['position'] ?? ''));
        $org  = trim((string)($t['company'] ?? ''));
        $meta = $org ? ($role ? $role . ', ' . $org : $org) : $role;
      ?>
      <div class="hp-panel p-7">
        <div class="flex items-center gap-1 mb-4">
          <?= stars((int)$t['rating']) ?>
        </div>
        <p class="hp-quote flex-grow">&ldquo;<?= Security::e($t['message']) ?>&rdquo;</p>

        <div class="flex items-center gap-3.5 mt-6 pt-5 border-t border-slate-800/80">
          <span class="hp-avatar"><?= Security::e(strtoupper(substr((string)$t['name'], 0, 1))) ?></span>
          <div>
            <div class="font-display font-semibold text-white text-sm"><?= Security::e($t['name']) ?></div>
            <?php if ($meta): ?>
            <div class="text-slate-400 text-xs mt-0.5"><?= Security::e($meta) ?></div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
<?php endif; ?>

<!-- ==========================================================
     8. FAQ
     ========================================================== -->
<section class="hp-section hp-rule relative overflow-hidden">
  <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="hp-head-center mb-12">
      <span class="hp-eyebrow">Common Questions</span>
      <h2 class="hp-h2">Frequently asked <span class="text-gradient">questions</span></h2>
      <p class="hp-lead">Clear answers about our development and cybersecurity processes.</p>
    </div>

    <div class="space-y-3">
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

<!-- ==========================================================
     9. CALL TO ACTION
     ========================================================== -->
<section class="hp-section relative overflow-hidden">
  <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="hp-cta">
      <span class="hp-status">
        <i class="fas fa-circle"></i>
        <span>Partner with EcoTech Services</span>
      </span>

      <h2 class="hp-cta-title mt-7">
        Ready to build your next<br class="hidden sm:inline">
        <span class="text-gradient">digital platform?</span>
      </h2>

      <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto mt-6 leading-relaxed">
        Get a transparent, non-binding technical proposal within 24 hours.
      </p>

      <div class="flex flex-col sm:flex-row items-center justify-center gap-5 mt-10">
        <a href="<?= url('contact') ?>" class="btn-primary text-base py-3.5 px-8 w-full sm:w-auto justify-center">
          Get started <i class="fas fa-arrow-right ml-2 text-sm"></i>
        </a>
        <a href="<?= Security::e($waLink) ?>" target="_blank" rel="noopener noreferrer" class="hp-wa">
          <i class="fab fa-whatsapp"></i>
          <span>Chat on WhatsApp</span>
        </a>
      </div>
    </div>
  </div>
</section>

</div><!-- /#homePageRoot -->

<!-- ==========================================================
     10. HERO MOUSE SPOTLIGHT
     ========================================================== -->
<script>
(function initHeroSpotlight() {
  const hero = document.getElementById('heroSection');
  const spotlight = document.getElementById('heroGridSpotlight');
  if (!hero || !spotlight) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  let ticking = false;

  hero.addEventListener('mousemove', function (e) {
    if (ticking) return;
    ticking = true;
    window.requestAnimationFrame(function () {
      const rect = hero.getBoundingClientRect();
      const x = ((e.clientX - rect.left) / rect.width) * 100;
      const y = ((e.clientY - rect.top) / rect.height) * 100;
      hero.style.setProperty('--mouse-x', x.toFixed(2) + '%');
      hero.style.setProperty('--mouse-y', y.toFixed(2) + '%');
      ticking = false;
    });
  });

  hero.addEventListener('mouseleave', function () {
    hero.style.setProperty('--mouse-x', '50%');
    hero.style.setProperty('--mouse-y', '35%');
  });
})();
</script>
