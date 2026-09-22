<?php
// ── PROJECT DETAIL / CASE STUDY ─────────────────────────────

$related  = $related ?? [];
$techList = array_filter(array_map('trim', explode(',', (string)($project['tech_stack'] ?? ''))));
$category = ucfirst((string)($project['category'] ?? ''));
$heroAlt  = Security::e($project['title']);
$fallback = uploadUrl(!empty($project['thumbnail']) ? $project['thumbnail'] : 'project_startup_landing.png');

$catIcons = [
    'website'   => 'fa-globe',
    'marketing' => 'fa-chart-bar',
    'template'  => 'fa-layer-group',
    'mobile'    => 'fa-mobile-alt',
    'other'     => 'fa-star',
];
?>

<style>
/* ==========================================================
   Project detail refinement layer (scoped to #projectDetail)
   ========================================================== */
#projectDetail {
  --pd-accent:   #22c55e;
  --pd-accent-2: #4ade80;
  --pd-line:     rgba(148, 163, 184, 0.14);
  --pd-line-str: rgba(148, 163, 184, 0.26);
  --pd-surface:  rgba(15, 23, 42, 0.55);
}

#projectDetail .pd-shell { max-width: 75rem; margin: 0 auto; padding: 0 1rem; }
@media (min-width: 640px) { #projectDetail .pd-shell { padding: 0 1.5rem; } }
@media (min-width: 1024px) { #projectDetail .pd-shell { padding: 0 2rem; } }
#projectDetail .pd-rule { border-top: 1px solid var(--pd-line); }

/* ── Breadcrumb ───────────────────────────────────────────── */
#projectDetail .pd-crumbs {
  display: flex; align-items: center; flex-wrap: wrap; gap: 0.5rem;
  font-size: 0.75rem; color: #64748b;
}
#projectDetail .pd-crumbs a { color: #94a3b8; transition: color .2s ease; }
#projectDetail .pd-crumbs a:hover { color: var(--pd-accent-2); }
#projectDetail .pd-crumbs i { font-size: 0.5rem; opacity: 0.6; }
#projectDetail .pd-crumbs .pd-crumb-current { color: #e2e8f0; font-weight: 500; }

/* ── Header ───────────────────────────────────────────────── */
#projectDetail .pd-eyebrow {
  display: inline-flex; align-items: center; gap: 0.5rem;
  font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.14em;
  text-transform: uppercase; color: #94a3b8;
}
#projectDetail .pd-eyebrow::before {
  content: ''; width: 1.5rem; height: 1px; background: var(--pd-accent);
}
#projectDetail .pd-h1 {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-weight: 800; color: #fff; letter-spacing: -0.035em;
  font-size: clamp(2rem, 4.8vw, 3.25rem); line-height: 1.08;
  margin: 1.125rem 0 0;
}
#projectDetail .pd-h2 {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-weight: 700; color: #fff; letter-spacing: -0.02em;
  font-size: 1.375rem; line-height: 1.25; margin: 0;
}
#projectDetail .pd-tech { display: flex; flex-wrap: wrap; gap: 0.375rem; }
#projectDetail .pd-tech span {
  font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  font-size: 0.6875rem; color: #cbd5e1;
  background: #020617; border: 1px solid var(--pd-line);
  padding: 0.1875rem 0.5rem; border-radius: 0.375rem;
}

/* ── Hero shot ────────────────────────────────────────────── */
#projectDetail .pd-hero {
  position: relative; overflow: hidden; aspect-ratio: 16 / 9;
  border: 1px solid var(--pd-line); border-radius: 1rem; background: #020617;
}
#projectDetail .pd-hero img { width: 100%; height: 100%; object-fit: cover; display: block; }

/* ── Body copy ────────────────────────────────────────────── */
#projectDetail .pd-prose {
  color: #cbd5e1; font-size: 1rem; line-height: 1.8;
}
#projectDetail .pd-prose p { margin: 0 0 1rem; }

/* ── Meta rail ────────────────────────────────────────────── */
#projectDetail .pd-rail {
  background: var(--pd-surface); border: 1px solid var(--pd-line);
  border-radius: 0.875rem; overflow: hidden;
}
#projectDetail .pd-rail-row { padding: 1rem 1.25rem; }
#projectDetail .pd-rail-row + .pd-rail-row { border-top: 1px solid var(--pd-line); }
#projectDetail .pd-rail-key {
  font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.1em;
  text-transform: uppercase; color: #64748b;
}
#projectDetail .pd-rail-val { color: #f1f5f9; font-size: 0.875rem; font-weight: 500; margin-top: 0.375rem; }
@media (min-width: 1024px) { #projectDetail .pd-sticky { position: sticky; top: 7rem; } }

/* ── Gallery ──────────────────────────────────────────────── */
#projectDetail .pd-gallery {
  display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem;
}
@media (min-width: 768px) { #projectDetail .pd-gallery { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
#projectDetail .pd-shot {
  position: relative; aspect-ratio: 16 / 10; overflow: hidden; padding: 0; border: 0;
  border: 1px solid var(--pd-line); border-radius: 0.75rem;
  background: #020617; cursor: zoom-in; display: block; width: 100%;
  transition: border-color .2s ease;
}
#projectDetail .pd-shot:hover { border-color: var(--pd-line-str); }
#projectDetail .pd-shot:focus-visible { outline: 2px solid var(--pd-accent); outline-offset: 2px; }
#projectDetail .pd-shot img {
  width: 100%; height: 100%; object-fit: cover; display: block;
  transition: transform .4s ease;
}
#projectDetail .pd-shot:hover img { transform: scale(1.05); }

/* ── Related cards ────────────────────────────────────────── */
#projectDetail .pd-related {
  display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 1.25rem;
}
@media (min-width: 640px) { #projectDetail .pd-related { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
#projectDetail .pd-rel-card {
  display: flex; flex-direction: column; overflow: hidden;
  background: var(--pd-surface); border: 1px solid var(--pd-line);
  border-radius: 0.875rem; transition: border-color .25s ease, transform .25s ease;
}
#projectDetail .pd-rel-card:hover { border-color: var(--pd-line-str); transform: translateY(-2px); }
#projectDetail .pd-rel-thumb {
  aspect-ratio: 16 / 10; overflow: hidden; background: #020617;
  border-bottom: 1px solid var(--pd-line);
}
#projectDetail .pd-rel-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
#projectDetail .pd-rel-title {
  font-family: 'Space Grotesk', Inter, sans-serif;
  font-size: 0.9375rem; font-weight: 700; color: #f1f5f9; margin: 0 0 0.375rem;
  transition: color .2s ease;
}
#projectDetail .pd-rel-card:hover .pd-rel-title { color: var(--pd-accent-2); }

/* ── Lightbox ─────────────────────────────────────────────── */
#pdLightbox[hidden] { display: none; }
#pdLightbox {
  position: fixed; inset: 0; z-index: 100;
  background: rgba(2, 6, 23, 0.96); backdrop-filter: blur(6px);
  display: flex; align-items: center; justify-content: center; padding: 1.5rem;
}
#pdLightbox img { max-width: 100%; max-height: 88vh; object-fit: contain; border-radius: 0.75rem; }
#pdLightboxClose {
  position: absolute; top: 1.25rem; right: 1.25rem;
  width: 2.5rem; height: 2.5rem; border-radius: 0.5rem;
  display: flex; align-items: center; justify-content: center;
  color: #cbd5e1; background: rgba(15, 23, 42, 0.8);
  border: 1px solid var(--pd-line-str); cursor: pointer;
  transition: color .2s ease, border-color .2s ease;
}
#pdLightboxClose:hover { color: #fff; border-color: #fff; }
#pdLightboxCount {
  position: absolute; bottom: 1.5rem; left: 50%; transform: translateX(-50%);
  font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  font-size: 0.75rem; color: #94a3b8;
}

@media (prefers-reduced-motion: reduce) {
  #projectDetail * { transition: none !important; animation: none !important; }
}
</style>

<div id="projectDetail" class="relative">

<!-- ── Header ───────────────────────────────────────────────── -->
<header class="pt-32 pb-12 bg-slate-950 relative overflow-hidden">
  <div class="tech-grid-wrapper"><div class="tech-grid-subtle"></div></div>

  <div class="pd-shell relative z-10">
    <nav class="pd-crumbs" aria-label="Breadcrumb">
      <a href="<?= url('') ?>">Home</a>
      <i class="fas fa-chevron-right"></i>
      <a href="<?= url('projects') ?>">Portfolio</a>
      <?php if ($project['category']): ?>
      <i class="fas fa-chevron-right"></i>
      <a href="<?= url('projects?cat=' . urlencode((string)$project['category'])) ?>"><?= Security::e($category) ?></a>
      <?php endif; ?>
      <i class="fas fa-chevron-right"></i>
      <span class="pd-crumb-current"><?= Security::e($project['title']) ?></span>
    </nav>

    <div class="mt-8 max-w-3xl">
      <span class="pd-eyebrow">
        <i class="fas <?= Security::e($catIcons[$project['category']] ?? 'fa-star') ?> text-[10px]"></i>
        <?= Security::e($category) ?> Case Study
      </span>
      <h1 class="pd-h1"><?= Security::e($project['title']) ?></h1>

      <?php if ($techList): ?>
      <div class="pd-tech mt-6">
        <?php foreach ($techList as $tech): ?>
        <span><?= Security::e($tech) ?></span>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <div class="flex flex-wrap gap-3 mt-8">
        <?php if (!empty($project['live_url'])): ?>
        <a href="<?= Security::e($project['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn-primary text-sm py-2.5 px-6">
          <i class="fas fa-external-link-alt mr-2 text-xs"></i>Visit live site
        </a>
        <?php endif; ?>
        <?php if (!empty($project['github_url'])): ?>
        <a href="<?= Security::e($project['github_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn-outline text-sm py-2.5 px-6 border-slate-800 text-slate-200 hover:bg-slate-900">
          <i class="fab fa-github mr-2"></i>Source code
        </a>
        <?php endif; ?>
        <a href="<?= url('contact') ?>" class="btn-outline text-sm py-2.5 px-6 border-slate-800 text-slate-200 hover:bg-slate-900">
          <i class="fas fa-paper-plane mr-2 text-xs"></i>Request something similar
        </a>
      </div>
    </div>
  </div>
</header>

<!-- ── Hero shot + meta rail ────────────────────────────────── -->
<section class="pd-rule bg-slate-950 py-14">
  <div class="pd-shell">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

      <div class="lg:col-span-8">
        <div class="pd-hero">
          <?php if (!empty($project['live_url'])): ?>
          <img src="//image.thum.io/get/width/1200/crop/750/noanimate/<?= Security::e(rtrim($project['live_url'], '/')) ?>"
               alt="<?= $heroAlt ?>" loading="lazy"
               onerror="this.onerror=null; this.src='<?= Security::e($fallback) ?>'">
          <?php else: ?>
          <img src="<?= Security::e($fallback) ?>" alt="<?= $heroAlt ?>" loading="lazy">
          <?php endif; ?>
        </div>

        <div class="mt-12">
          <h2 class="pd-h2">About this project</h2>
          <div class="pd-prose mt-5">
            <p><?= nl2br(Security::e((string)($project['description'] ?? ''))) ?></p>
          </div>
        </div>
      </div>

      <aside class="lg:col-span-4">
        <div class="pd-sticky">
          <div class="pd-rail">
            <div class="pd-rail-row">
              <div class="pd-rail-key">Category</div>
              <div class="pd-rail-val"><?= Security::e($category ?: '—') ?></div>
            </div>
            <div class="pd-rail-row">
              <div class="pd-rail-key">Tech stack</div>
              <div class="pd-rail-val"><?= $techList ? Security::e(implode(', ', $techList)) : '—' ?></div>
            </div>
            <div class="pd-rail-row">
              <div class="pd-rail-key">Completed</div>
              <div class="pd-rail-val"><?= !empty($project['created_at']) ? Security::e(formatDate($project['created_at'])) : '—' ?></div>
            </div>
            <?php if (!empty($project['live_url'])): ?>
            <div class="pd-rail-row">
              <div class="pd-rail-key">Live URL</div>
              <div class="pd-rail-val break-all">
                <a href="<?= Security::e($project['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="text-eco-400 hover:text-eco-300 transition-colors">
                  <?= Security::e(preg_replace('#^https?://#', '', rtrim($project['live_url'], '/'))) ?>
                </a>
              </div>
            </div>
            <?php endif; ?>
          </div>

          <a href="<?= url('projects') ?>" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-white transition-colors mt-6">
            <i class="fas fa-arrow-left text-[10px]"></i>
            <span>Back to portfolio</span>
          </a>
        </div>
      </aside>

    </div>
  </div>
</section>

<!-- ── Gallery ──────────────────────────────────────────────── -->
<?php if ($images): ?>
<section class="pd-rule py-14">
  <div class="pd-shell">
    <h2 class="pd-h2 mb-6">Gallery</h2>
    <div class="pd-gallery">
      <?php foreach ($images as $gi => $img):
        $shotUrl = uploadUrl($img['image_path']);
        $shotAlt = trim((string)($img['alt_text'] ?? '')) ?: $project['title'] . ' screenshot ' . ($gi + 1);
      ?>
      <button type="button" class="pd-shot"
              data-lightbox-src="<?= Security::e($shotUrl) ?>"
              data-lightbox-index="<?= $gi ?>"
              aria-label="Open image <?= $gi + 1 ?> of <?= count($images) ?> full size">
        <img src="<?= Security::e($shotUrl) ?>" alt="<?= Security::e($shotAlt) ?>" loading="lazy">
      </button>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── Related work ─────────────────────────────────────────── -->
<?php if ($related): ?>
<section class="pd-rule bg-slate-950 py-14">
  <div class="pd-shell">
    <div class="flex items-end justify-between gap-4 mb-7">
      <h2 class="pd-h2">More work</h2>
      <a href="<?= url('projects') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-300 hover:text-white transition-colors shrink-0">
        <span>All projects</span>
        <i class="fas fa-arrow-right text-[10px] text-eco-400"></i>
      </a>
    </div>

    <div class="pd-related">
      <?php foreach ($related as $r):
        $rUrl      = url('projects/view?slug=' . urlencode($r['slug']));
        $rFallback = uploadUrl(!empty($r['thumbnail']) ? $r['thumbnail'] : 'project_startup_landing.png');
      ?>
      <a href="<?= $rUrl ?>" class="pd-rel-card">
        <div class="pd-rel-thumb">
          <?php if (!empty($r['live_url'])): ?>
          <img src="//image.thum.io/get/width/600/crop/375/noanimate/<?= Security::e(rtrim($r['live_url'], '/')) ?>"
               alt="<?= Security::e($r['title']) ?>" loading="lazy"
               onerror="this.onerror=null; this.src='<?= Security::e($rFallback) ?>'">
          <?php else: ?>
          <img src="<?= Security::e($rFallback) ?>" alt="<?= Security::e($r['title']) ?>" loading="lazy">
          <?php endif; ?>
        </div>
        <div class="p-4">
          <h3 class="pd-rel-title"><?= Security::e($r['title']) ?></h3>
          <p class="text-slate-400 text-xs leading-relaxed">
            <?= Security::e(truncate((string)($r['description'] ?? ''), 72)) ?>
          </p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

</div><!-- /#projectDetail -->

<!-- ── Lightbox ─────────────────────────────────────────────── -->
<?php if ($images): ?>
<div id="pdLightbox" hidden role="dialog" aria-modal="true" aria-label="Project image viewer">
  <button type="button" id="pdLightboxClose" aria-label="Close image viewer">
    <i class="fas fa-times"></i>
  </button>
  <img id="pdLightboxImg" src="" alt="">
  <div id="pdLightboxCount"></div>
</div>

<script>
// ── Accessible gallery lightbox ─────────────────────────────
(function initLightbox() {
  const box      = document.getElementById('pdLightbox');
  const img      = document.getElementById('pdLightboxImg');
  const closeBtn = document.getElementById('pdLightboxClose');
  const countEl  = document.getElementById('pdLightboxCount');
  const shots    = Array.from(document.querySelectorAll('#projectDetail .pd-shot'));
  if (!box || !img || !shots.length) return;

  let current = 0;
  let lastFocused = null;

  function render(index) {
    current = (index + shots.length) % shots.length;
    const shot = shots[current];
    img.src = shot.dataset.lightboxSrc;
    const inner = shot.querySelector('img');
    img.alt = inner ? inner.alt : '';
    if (countEl) countEl.textContent = `${current + 1} / ${shots.length}`;
  }

  function open(index) {
    lastFocused = document.activeElement;
    render(index);
    box.hidden = false;
    document.body.style.overflow = 'hidden';
    closeBtn.focus();
  }

  function close() {
    box.hidden = true;
    img.src = '';
    document.body.style.overflow = '';
    if (lastFocused) lastFocused.focus();
  }

  shots.forEach((shot, i) => shot.addEventListener('click', () => open(i)));
  closeBtn.addEventListener('click', close);

  // Click the backdrop (but not the image) to dismiss
  box.addEventListener('click', (e) => {
    if (e.target === box) close();
  });

  document.addEventListener('keydown', (e) => {
    if (box.hidden) return;
    if (e.key === 'Escape') { close(); }
    else if (e.key === 'ArrowRight') { render(current + 1); }
    else if (e.key === 'ArrowLeft')  { render(current - 1); }
    else if (e.key === 'Tab')        { e.preventDefault(); closeBtn.focus(); }
  });
})();
</script>
<?php endif; ?>
