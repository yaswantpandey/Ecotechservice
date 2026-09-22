<?php
// ── PROJECTS / PORTFOLIO PAGE ───────────────────────────────

$categoryCounts = $categoryCounts ?? [];

$cats = [
    ''          => ['label' => 'All Projects', 'icon' => 'fa-th-large'],
    'website'   => ['label' => 'Websites',     'icon' => 'fa-globe'],
    'marketing' => ['label' => 'Marketing',    'icon' => 'fa-chart-bar'],
    'template'  => ['label' => 'Templates',    'icon' => 'fa-layer-group'],
    'mobile'    => ['label' => 'Mobile Apps',  'icon' => 'fa-mobile-alt'],
    'other'     => ['label' => 'Other',        'icon' => 'fa-star'],
];

$catIcons = [
    'website'   => 'fa-globe',
    'marketing' => 'fa-chart-bar',
    'template'  => 'fa-layer-group',
    'mobile'    => 'fa-mobile-alt',
    'other'     => 'fa-star',
];

$activeLabel = $cats[$activeCategory]['label'] ?? 'All Projects';
$shown       = count($projects);

$portfolioStats = [
    ['num' => '50+', 'label' => 'Projects Delivered'],
    ['num' => '98%', 'label' => 'Client Satisfaction'],
    ['num' => '12+', 'label' => 'Industries Served'],
];
?>

<style>
/* ==========================================================
   Projects listing refinement layer (scoped to #projectsPage)
   Matches the home page language: hairline grids, calm
   surfaces, uniform section headers, tighter type.
   ========================================================== */
#projectsPage {
  --pp-accent:   #22c55e;
  --pp-accent-2: #4ade80;
  --pp-line:     rgba(148, 163, 184, 0.14);
  --pp-line-str: rgba(148, 163, 184, 0.26);
  --pp-surface:  rgba(15, 23, 42, 0.55);
}

#projectsPage .pp-shell { max-width: 80rem; margin: 0 auto; padding: 0 1rem; }
@media (min-width: 640px) { #projectsPage .pp-shell { padding: 0 1.5rem; } }
@media (min-width: 1024px) { #projectsPage .pp-shell { padding: 0 2rem; } }
#projectsPage .pp-rule { border-top: 1px solid var(--pp-line); }

/* ── Header ───────────────────────────────────────────────── */
#projectsPage .pp-eyebrow {
  display: inline-flex; align-items: center; gap: 0.5rem;
  font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.14em;
  text-transform: uppercase; color: #94a3b8;
}
#projectsPage .pp-eyebrow::before {
  content: ''; width: 1.5rem; height: 1px; background: var(--pp-accent);
}
#projectsPage .pp-h1 {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-weight: 800; color: #fff; letter-spacing: -0.035em;
  font-size: clamp(2.25rem, 5.4vw, 3.75rem); line-height: 1.06;
  margin: 1.125rem 0 0;
}
#projectsPage .pp-accent-rule {
  width: 4.5rem; height: 3px; border-radius: 2px; margin-top: 1.75rem;
  background: linear-gradient(90deg, var(--pp-accent), rgba(34,197,94,0));
}
#projectsPage .pp-lead {
  color: #cbd5e1; font-size: 1.0625rem; line-height: 1.75;
  max-width: 38rem; margin: 1.5rem 0 0;
}
#projectsPage .pp-h2 {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-weight: 700; color: #fff; letter-spacing: -0.02em;
  font-size: clamp(1.5rem, 3vw, 2rem); line-height: 1.15; margin: 0;
}

/* Inline stat strip */
#projectsPage .pp-stats {
  display: grid; grid-template-columns: repeat(3, minmax(0, 1fr));
  border-top: 1px solid var(--pp-line); margin-top: 3.5rem; max-width: 40rem;
}
#projectsPage .pp-stat { padding: 1.5rem 1.25rem 0; }
#projectsPage .pp-stat + .pp-stat { border-left: 1px solid var(--pp-line); }
#projectsPage .pp-stat-num {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-size: 1.75rem; font-weight: 700; color: #fff; letter-spacing: -0.02em;
}
#projectsPage .pp-stat-label { font-size: 0.75rem; color: #94a3b8; margin-top: 0.25rem; }

/* ── Filter bar ───────────────────────────────────────────── */
#projectsPage .pp-filters {
  display: flex; flex-wrap: wrap; gap: 0.5rem;
}
#projectsPage .pp-pill {
  display: inline-flex; align-items: center; gap: 0.5rem;
  font-size: 0.8125rem; font-weight: 600; color: #94a3b8;
  padding: 0.5rem 0.875rem; border-radius: 0.5rem;
  background: rgba(2, 6, 23, 0.6); border: 1px solid var(--pp-line);
  transition: color .2s ease, border-color .2s ease, background-color .2s ease;
}
#projectsPage .pp-pill:hover { color: #e2e8f0; border-color: var(--pp-line-str); }
#projectsPage .pp-pill i { font-size: 0.6875rem; opacity: 0.8; }
#projectsPage .pp-pill--active {
  color: #04140a; background: var(--pp-accent); border-color: var(--pp-accent);
}
#projectsPage .pp-pill--active:hover { color: #04140a; background: var(--pp-accent-2); }
#projectsPage .pp-pill-count {
  font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  font-size: 0.6875rem; font-weight: 700; padding: 0.0625rem 0.375rem;
  border-radius: 0.25rem; background: rgba(148, 163, 184, 0.14); color: #cbd5e1;
}
#projectsPage .pp-pill--active .pp-pill-count { background: rgba(4, 20, 10, 0.22); color: #04140a; }
#projectsPage .pp-result {
  font-size: 0.8125rem; color: #94a3b8;
}
#projectsPage .pp-result strong { color: #f1f5f9; font-weight: 600; }

/* ── Card grid ────────────────────────────────────────────── */
#projectsPage .pp-grid {
  display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 1.5rem;
}
@media (min-width: 640px) { #projectsPage .pp-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (min-width: 1024px) { #projectsPage .pp-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }

#projectsPage .pp-card {
  display: flex; flex-direction: column; overflow: hidden;
  background: var(--pp-surface); border: 1px solid var(--pp-line);
  border-radius: 0.875rem;
  opacity: 0; transform: translateY(14px);
  transition: border-color .25s ease, transform .35s ease, opacity .35s ease;
}
#projectsPage .pp-card.revealed { opacity: 1; transform: translateY(0); }
#projectsPage .pp-card:hover { border-color: var(--pp-line-str); }

#projectsPage .pp-thumb {
  position: relative; aspect-ratio: 16 / 10; overflow: hidden;
  background: #020617; border-bottom: 1px solid var(--pp-line);
}
#projectsPage .pp-thumb img {
  width: 100%; height: 100%; object-fit: cover; display: block;
  transition: transform .5s cubic-bezier(0.22, 1, 0.36, 1);
}
#projectsPage .pp-card:hover .pp-thumb img { transform: scale(1.04); }

#projectsPage .pp-chip-cat {
  position: absolute; top: 0.75rem; left: 0.75rem;
  display: inline-flex; align-items: center; gap: 0.375rem;
  font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  font-size: 0.625rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: 0.08em; color: var(--pp-accent-2);
  background: rgba(2, 6, 23, 0.85); backdrop-filter: blur(8px);
  border: 1px solid rgba(148, 163, 184, 0.24);
  padding: 0.25rem 0.5rem; border-radius: 0.375rem;
}
#projectsPage .pp-chip-feat {
  position: absolute; top: 0.75rem; right: 0.75rem;
  display: inline-flex; align-items: center; gap: 0.25rem;
  font-size: 0.625rem; font-weight: 700; color: #fcd34d;
  background: rgba(2, 6, 23, 0.85); backdrop-filter: blur(8px);
  border: 1px solid rgba(245, 158, 11, 0.4);
  padding: 0.25rem 0.5rem; border-radius: 0.375rem;
}

#projectsPage .pp-body { padding: 1.25rem; display: flex; flex-direction: column; flex-grow: 1; }
#projectsPage .pp-title {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-size: 1.0625rem; font-weight: 700; color: #f1f5f9;
  letter-spacing: -0.01em; margin: 0 0 0.5rem;
  transition: color .2s ease;
}
#projectsPage .pp-card:hover .pp-title { color: var(--pp-accent-2); }
#projectsPage .pp-desc {
  color: #94a3b8; font-size: 0.875rem; line-height: 1.7; margin: 0 0 1rem;
  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
#projectsPage .pp-tech { display: flex; flex-wrap: wrap; gap: 0.375rem; margin-bottom: 1.25rem; }
#projectsPage .pp-tech span {
  font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  font-size: 0.6875rem; color: #cbd5e1;
  background: #020617; border: 1px solid var(--pp-line);
  padding: 0.125rem 0.5rem; border-radius: 0.375rem;
}
#projectsPage .pp-card-foot {
  margin-top: auto; padding-top: 0.875rem; border-top: 1px solid var(--pp-line);
  display: flex; align-items: center; justify-content: space-between;
  font-size: 0.75rem; font-weight: 600;
}
#projectsPage .pp-link {
  color: var(--pp-accent-2); display: inline-flex; align-items: center; gap: 0.375rem;
  transition: color .2s ease;
}
#projectsPage .pp-link:hover { color: #86efac; }
#projectsPage .pp-link-ext { color: #94a3b8; display: inline-flex; align-items: center; gap: 0.375rem; transition: color .2s ease; }
#projectsPage .pp-link-ext:hover { color: #fff; }

/* ── Empty state ──────────────────────────────────────────── */
#projectsPage .pp-empty {
  text-align: center; padding: 4.5rem 1.5rem;
  border: 1px dashed var(--pp-line-str); border-radius: 0.875rem;
  background: rgba(2, 6, 23, 0.4);
}
#projectsPage .pp-empty-icon {
  width: 3.5rem; height: 3.5rem; border-radius: 0.875rem; margin: 0 auto 1.25rem;
  display: flex; align-items: center; justify-content: center;
  color: #64748b; background: rgba(148, 163, 184, 0.08);
  border: 1px solid var(--pp-line); font-size: 1.25rem;
}

/* ── CTA ──────────────────────────────────────────────────── */
#projectsPage .pp-cta {
  border: 1px solid rgba(34, 197, 94, 0.28); border-radius: 1.125rem;
  background:
    radial-gradient(120% 140% at 50% 0%, rgba(34, 197, 94, 0.12), transparent 62%),
    rgba(2, 6, 23, 0.72);
  padding: 3.5rem 1.5rem; text-align: center;
}
@media (min-width: 640px) { #projectsPage .pp-cta { padding: 4rem 3rem; } }

@media (prefers-reduced-motion: reduce) {
  #projectsPage .pp-card { opacity: 1; transform: none; }
  #projectsPage * { transition: none !important; animation: none !important; }
}
</style>

<div id="projectsPage" class="relative">

<!-- ── Page header ──────────────────────────────────────────── -->
<header class="pt-36 pb-16 bg-slate-950 relative overflow-hidden">
  <div class="tech-grid-wrapper"><div class="tech-grid-subtle"></div></div>

  <div class="pp-shell relative z-10">
    <div class="max-w-4xl">
      <span class="pp-eyebrow">Our Work</span>
      <h1 class="pp-h1">Portfolio &amp; <span class="text-gradient">case studies</span></h1>
      <div class="pp-accent-rule"></div>
      <p class="pp-lead">
        Web applications, e-commerce platforms, mobile apps, and digital campaigns &mdash;
        built with modern stacks and shipped to production.
      </p>

      <div class="pp-stats">
        <?php foreach ($portfolioStats as $ps): ?>
        <div class="pp-stat">
          <div class="pp-stat-num" data-counter="<?= Security::e($ps['num']) ?>"><?= Security::e($ps['num']) ?></div>
          <div class="pp-stat-label"><?= Security::e($ps['label']) ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</header>

<!-- ── Filters + result summary ─────────────────────────────── -->
<section class="pp-rule bg-slate-950 py-7">
  <div class="pp-shell">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">

      <nav class="pp-filters" aria-label="Filter projects by category">
        <?php foreach ($cats as $cat => $meta):
          $isActive = ($activeCategory === $cat);
          $count    = (int)($categoryCounts[$cat] ?? 0);
          // Hide categories that have nothing in them (except "All")
          if ($cat !== '' && $count === 0 && !$isActive) { continue; }
        ?>
        <a href="<?= url('projects' . ($cat ? '?cat=' . urlencode($cat) : '')) ?>"
           class="pp-pill <?= $isActive ? 'pp-pill--active' : '' ?>"
           <?= $isActive ? 'aria-current="page"' : '' ?>>
          <i class="fas <?= Security::e($meta['icon']) ?>"></i>
          <span><?= Security::e($meta['label']) ?></span>
          <span class="pp-pill-count"><?= $count ?></span>
        </a>
        <?php endforeach; ?>
      </nav>

      <p class="pp-result shrink-0">
        <?php if ($shown): ?>
          Showing <strong><?= $shown ?></strong> <?= $shown === 1 ? 'project' : 'projects' ?>
          <?php if ($activeCategory): ?>
            in <strong><?= Security::e($activeLabel) ?></strong>
          <?php endif; ?>
        <?php else: ?>
          No projects to show
        <?php endif; ?>
      </p>

    </div>
  </div>
</section>

<!-- ── Project grid ─────────────────────────────────────────── -->
<section class="py-14">
  <div class="pp-shell">
    <?php if ($projects): ?>
    <div class="pp-grid" id="portfolioGrid">
      <?php foreach ($projects as $i => $p):
        $techList  = array_filter(array_map('trim', explode(',', (string)($p['tech_stack'] ?? ''))));
        $techShown = array_slice($techList, 0, 4);
        $techExtra = count($techList) - count($techShown);
        $icon      = $catIcons[$p['category']] ?? 'fa-star';
        $detailUrl = url('projects/view?slug=' . urlencode($p['slug']));
        $fallback  = uploadUrl(!empty($p['thumbnail']) ? $p['thumbnail'] : 'project_startup_landing.png');
      ?>
      <article class="pp-card reveal-card" style="transition-delay: <?= min($i, 8) * 0.05 ?>s">

        <a href="<?= $detailUrl ?>" class="pp-thumb block" aria-label="View <?= Security::e($p['title']) ?>">
          <?php if (!empty($p['live_url'])): ?>
          <img src="//image.thum.io/get/width/800/crop/500/noanimate/<?= Security::e(rtrim($p['live_url'], '/')) ?>"
               alt="<?= Security::e($p['title']) ?>"
               loading="lazy"
               onerror="this.onerror=null; this.src='<?= Security::e($fallback) ?>'">
          <?php else: ?>
          <img src="<?= Security::e($fallback) ?>" alt="<?= Security::e($p['title']) ?>" loading="lazy">
          <?php endif; ?>

          <span class="pp-chip-cat">
            <i class="fas <?= Security::e($icon) ?>"></i><?= Security::e(ucfirst((string)$p['category'])) ?>
          </span>

          <?php if (!empty($p['is_featured'])): ?>
          <span class="pp-chip-feat"><i class="fas fa-star"></i>Featured</span>
          <?php endif; ?>
        </a>

        <div class="pp-body">
          <h3 class="pp-title"><?= Security::e($p['title']) ?></h3>
          <p class="pp-desc"><?= Security::e(truncate((string)($p['description'] ?? ''), 110)) ?></p>

          <?php if ($techShown): ?>
          <div class="pp-tech">
            <?php foreach ($techShown as $tech): ?>
            <span><?= Security::e($tech) ?></span>
            <?php endforeach; ?>
            <?php if ($techExtra > 0): ?>
            <span>+<?= $techExtra ?></span>
            <?php endif; ?>
          </div>
          <?php endif; ?>

          <div class="pp-card-foot">
            <a href="<?= $detailUrl ?>" class="pp-link">
              <span>View case study</span>
              <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
            <?php if (!empty($p['live_url'])): ?>
            <a href="<?= Security::e($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="pp-link-ext">
              <span>Live site</span>
              <i class="fas fa-external-link-alt text-[10px]"></i>
            </a>
            <?php endif; ?>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <?php else: ?>
    <div class="pp-empty">
      <div class="pp-empty-icon"><i class="fas fa-folder-open"></i></div>
      <h3 class="font-display text-white text-xl font-semibold mb-2">
        <?php if ($activeCategory): ?>
          Nothing in <?= Security::e($activeLabel) ?> yet
        <?php else: ?>
          No projects published yet
        <?php endif; ?>
      </h3>
      <p class="text-slate-400 text-sm mb-7 max-w-sm mx-auto">
        <?php if ($activeCategory): ?>
          We haven't published work in this category yet &mdash; browse the full portfolio instead.
        <?php else: ?>
          Our case studies are on the way. In the meantime, tell us what you're building.
        <?php endif; ?>
      </p>
      <div class="flex flex-wrap gap-3 justify-center">
        <?php if ($activeCategory): ?>
        <a href="<?= url('projects') ?>" class="btn-primary text-sm py-2.5 px-6">View all projects</a>
        <?php endif; ?>
        <a href="<?= url('contact') ?>" class="btn-outline text-sm py-2.5 px-6 border-slate-800">Start a project</a>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- ── CTA ──────────────────────────────────────────────────── -->
<section class="pb-20">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="pp-cta">
      <span class="pp-eyebrow justify-center">Start a Project</span>
      <h2 class="pp-h2 mt-5">Have something in mind?</h2>
      <p class="text-slate-300 text-base max-w-xl mx-auto mt-5 leading-relaxed">
        Tell us what you're building and we'll come back with a transparent,
        non-binding technical proposal within 24 hours.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center mt-9">
        <a href="<?= url('contact') ?>" class="btn-primary py-3.5 px-8 justify-center">
          <i class="fas fa-paper-plane mr-2 text-sm"></i>Start a conversation
        </a>
        <a href="<?= url('services') ?>" class="btn-outline py-3.5 px-7 justify-center border-slate-800 text-slate-200 hover:bg-slate-900">
          <i class="fas fa-list mr-2 text-sm"></i>Our services
        </a>
      </div>
    </div>
  </div>
</section>

</div><!-- /#projectsPage -->

<script>
// ── Scroll reveal for project cards ─────────────────────────
(function initPortfolioReveal() {
  const cards = document.querySelectorAll('#projectsPage .reveal-card');
  if (!cards.length) return;

  if (!('IntersectionObserver' in window) ||
      window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    cards.forEach(card => card.classList.add('revealed'));
    return;
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('revealed');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

  cards.forEach(card => observer.observe(card));
})();
</script>
