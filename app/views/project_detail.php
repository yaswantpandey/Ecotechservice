<?php
// ── PROJECT DETAIL / CASE STUDY ─────────────────────────────

$related  = $related ?? [];
$techList = array_filter(array_map('trim', explode(',', (string)($project['tech_stack'] ?? ''))));
$category = ucfirst((string)($project['category'] ?? ''));
$heroAlt  = Security::e($project['title']);
$fallback = uploadUrl(!empty($project['thumbnail']) ? $project['thumbnail'] : 'project_startup_landing.png');
?>

<style>
@media (min-width: 1024px) { #projectDetail .pd-sticky { position: sticky; top: calc(var(--nav-h) + 2rem); } }
#projectDetail .pd-gallery { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.5rem; }
#projectDetail .pd-shot { display: block; width: 100%; padding: 0; cursor: zoom-in; }
#projectDetail .pd-shot:hover { border-color: var(--ink); }
#projectDetail .pd-related { display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 1.5rem; }
@media (min-width: 640px)  { #projectDetail .pd-related { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (min-width: 1024px) { #projectDetail .pd-related { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
#projectDetail .pd-rel { text-decoration: none; color: inherit; display: block; }
#projectDetail .pd-rel:hover .s-h3 { text-decoration: underline; text-underline-offset: .15em; text-decoration-thickness: 1px; }
#pdLightbox img { max-height: 86vh; }
</style>

<div id="projectDetail">

<!-- ── Header ───────────────────────────────────────────────── -->
<section class="s-sec">
  <div class="s-shell">
    <nav class="s-crumbs" aria-label="Breadcrumb">
      <a href="<?= url('') ?>">Home</a>
      <span aria-hidden="true">/</span>
      <a href="<?= url('projects') ?>">Projects</a>
      <?php if ($project['category']): ?>
      <span aria-hidden="true">/</span>
      <a href="<?= url('projects?cat=' . urlencode((string)$project['category'])) ?>"><?= Security::e($category) ?></a>
      <?php endif; ?>
      <span aria-hidden="true">/</span>
      <span aria-current="page"><?= Security::e($project['title']) ?></span>
    </nav>

    <div class="s-grid mt-10">
      <div style="grid-column:span 9">
        <p class="s-eyebrow"><?= Security::e($category) ?> case study</p>
        <h1 class="s-h1"><?= Security::e($project['title']) ?></h1>
      </div>
    </div>

    <?php if ($techList): ?>
    <div class="s-tags mt-6">
      <?php foreach ($techList as $tech): ?>
      <span class="s-tag"><?= Security::e($tech) ?></span>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="s-actions mt-8">
      <?php if (!empty($project['live_url'])): ?>
      <a href="<?= Security::e($project['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="s-btn">Visit live site</a>
      <?php endif; ?>
      <?php if (!empty($project['github_url'])): ?>
      <a href="<?= Security::e($project['github_url']) ?>" target="_blank" rel="noopener noreferrer" class="s-btn--line"><i class="fab fa-github mr-2" aria-hidden="true"></i>Source code</a>
      <?php endif; ?>
      <a href="<?= url('contact') ?>" class="s-btn--line">Request something similar</a>
    </div>
  </div>
</section>

<!-- ── Hero shot + meta rail ────────────────────────────────── -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 8">
        <div class="s-media s-media--16x10">
          <?php if (!empty($project['live_url'])): ?>
          <img src="//image.thum.io/get/width/1200/crop/750/noanimate/<?= Security::e(rtrim($project['live_url'], '/')) ?>"
               alt="<?= $heroAlt ?>" width="1200" height="750" loading="eager"
               fetchpriority="high" decoding="async"
               onerror="this.onerror=null; this.src='<?= Security::e($fallback) ?>'">
          <?php else: ?>
          <img src="<?= Security::e($fallback) ?>" alt="<?= $heroAlt ?>" width="1200" height="750" loading="eager" fetchpriority="high" decoding="async">
          <?php endif; ?>
        </div>

        <div class="mt-12">
          <h2 class="s-h2">About this project</h2>
          <div class="s-prose mt-5">
            <p><?= nl2br(Security::e((string)($project['description'] ?? ''))) ?></p>
          </div>
        </div>
      </div>

      <aside style="grid-column:span 4">
        <div class="pd-sticky">
          <dl class="s-kv">
            <div>
              <dt>Category</dt>
              <dd><?= Security::e($category ?: '—') ?></dd>
            </div>
            <div>
              <dt>Tech stack</dt>
              <dd><?= $techList ? Security::e(implode(', ', $techList)) : '—' ?></dd>
            </div>
            <div>
              <dt>Completed</dt>
              <dd><?= !empty($project['created_at']) ? Security::e(formatDate($project['created_at'])) : '—' ?></dd>
            </div>
            <?php if (!empty($project['live_url'])): ?>
            <div>
              <dt>Live URL</dt>
              <dd class="break-all">
                <a href="<?= Security::e($project['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="s-link">
                  <?= Security::e(preg_replace('#^https?://#', '', rtrim($project['live_url'], '/'))) ?>
                </a>
              </dd>
            </div>
            <?php endif; ?>
          </dl>

          <p class="mt-6"><a href="<?= url('projects') ?>" class="s-link s-small">Back to all projects</a></p>
        </div>
      </aside>
    </div>
  </div>
</section>

<!-- ── Gallery ──────────────────────────────────────────────── -->
<?php if ($images): ?>
<section class="s-sec">
  <div class="s-shell">
    <div class="flex items-baseline justify-between gap-4 mb-8">
      <h2 class="s-h2">Gallery</h2>
      <span class="s-num"><?= count($images) ?> images</span>
    </div>
    <div class="pd-gallery">
      <?php foreach ($images as $gi => $img):
        $shotUrl = uploadUrl($img['image_path']);
        $shotAlt = trim((string)($img['alt_text'] ?? '')) ?: $project['title'] . ' screenshot ' . ($gi + 1);
      ?>
      <button type="button" class="pd-shot s-media s-media--16x10"
              data-lightbox-src="<?= Security::e($shotUrl) ?>"
              data-lightbox-index="<?= $gi ?>"
              aria-label="Open image <?= $gi + 1 ?> of <?= count($images) ?> full size">
        <img src="<?= Security::e($shotUrl) ?>" alt="<?= Security::e($shotAlt) ?>" width="800" height="500" loading="lazy">
      </button>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── Related work ─────────────────────────────────────────── -->
<?php if ($related): ?>
<section class="s-sec">
  <div class="s-shell">
    <div class="flex items-baseline justify-between gap-4 mb-8">
      <h2 class="s-h2">More work</h2>
      <a href="<?= url('projects') ?>" class="s-link s-small">All projects</a>
    </div>

    <div class="pd-related">
      <?php foreach ($related as $r):
        $rUrl      = url('projects/view?slug=' . urlencode($r['slug']));
        $rFallback = uploadUrl(!empty($r['thumbnail']) ? $r['thumbnail'] : 'project_startup_landing.png');
      ?>
      <a href="<?= $rUrl ?>" class="pd-rel" data-reveal>
        <div class="s-media s-media--16x10">
          <?php if (!empty($r['live_url'])): ?>
          <img src="//image.thum.io/get/width/600/crop/375/noanimate/<?= Security::e(rtrim($r['live_url'], '/')) ?>"
               alt="<?= Security::e($r['title']) ?>" width="600" height="375" loading="lazy"
               onerror="this.onerror=null; this.src='<?= Security::e($rFallback) ?>'">
          <?php else: ?>
          <img src="<?= Security::e($rFallback) ?>" alt="<?= Security::e($r['title']) ?>" width="600" height="375" loading="lazy">
          <?php endif; ?>
        </div>
        <h3 class="s-h3 mt-4"><?= Security::e($r['title']) ?></h3>
        <p class="s-mute s-small mt-2"><?= Security::e(truncate((string)($r['description'] ?? ''), 72)) ?></p>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── CTA ──────────────────────────────────────────────────── -->
<section class="s-band s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 7">
        <h2 class="s-h1">Want something like this?</h2>
      </div>
      <div style="grid-column:span 5" class="flex flex-col justify-end">
        <p class="s-lede">Send a short brief. We reply with scope, timeline and a fixed quote.</p>
        <div class="s-actions mt-6">
          <a href="<?= url('contact') ?>" class="s-btn--light">Start a conversation</a>
        </div>
      </div>
    </div>
  </div>
</section>

</div><!-- /#projectDetail -->

<!-- ── Lightbox ─────────────────────────────────────────────── -->
<?php if ($images): ?>
<div id="pdLightbox" class="s-lightbox" hidden role="dialog" aria-modal="true" aria-label="Project image viewer">
  <div class="s-lightbox-bar">
    <span id="pdLightboxCount"></span>
    <button type="button" id="pdLightboxClose" aria-label="Close image viewer">Close</button>
  </div>
  <img id="pdLightboxImg" src="" alt="">
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
    box.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    closeBtn.focus();
  }

  function close() {
    box.classList.remove('is-open');
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
