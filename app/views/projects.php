<?php
// ── PROJECTS / WORK INDEX ─────────────────────────────────

$categoryCounts = $categoryCounts ?? [];

$cats = [
    ''          => ['label' => 'All work'],
    'website'   => ['label' => 'Websites'],
    'marketing' => ['label' => 'Marketing'],
    'template'  => ['label' => 'Templates'],
    'mobile'    => ['label' => 'Mobile apps'],
    'other'     => ['label' => 'Other'],
];

$activeLabel = $cats[$activeCategory]['label'] ?? 'All work';
$shown       = count($projects);

// Real figures only, derived from the published data
$totalPublished = (int)($categoryCounts[''] ?? 0);
if ($totalPublished === 0) {
    foreach ($categoryCounts as $k => $v) { if ($k !== '') { $totalPublished += (int)$v; } }
}
$activeCats = 0;
foreach ($categoryCounts as $k => $v) { if ($k !== '' && (int)$v > 0) { $activeCats++; } }
$liveCount = 0;
foreach ($projects as $p) { if (!empty($p['live_url'])) { $liveCount++; } }

$ProjectStats = [];
if ($totalPublished > 0) {
    $ProjectStats[] = ['num' => $totalPublished, 'label' => 'Published projects'];
    $ProjectStats[] = ['num' => $activeCats,     'label' => 'Categories'];
    $ProjectStats[] = ['num' => $shown,          'label' => 'Shown in this view'];
    $ProjectStats[] = ['num' => $liveCount,      'label' => 'With a live link'];
}
?>

<!-- ── Header ───────────────────────────────────────────────── -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 8" data-reveal>
        <p class="s-eyebrow">Our work</p>
        <h1 class="s-display">Projects and case studies.</h1>
      </div>
      <div style="grid-column:span 4" class="flex items-end" data-reveal>
        <p class="s-lede">Web applications, e-commerce, mobile apps and campaigns, built on current stacks and shipped to production.</p>
      </div>
    </div>

    <?php if ($ProjectStats): ?>
    <div class="s-figs mt-14" data-reveal>
      <?php foreach ($ProjectStats as $ps): ?>
      <div class="s-fig">
        <b><span data-counter><?= (int)$ps['num'] ?></span></b>
        <span><?= Security::e($ps['label']) ?></span>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- ── Filters ──────────────────────────────────────────────── -->
<section class="s-sec--tight" style="border-top:1px solid var(--rule)">
  <div class="s-shell">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
      <nav class="s-filter" aria-label="Filter projects by category">
        <?php foreach ($cats as $cat => $meta):
          $isActive = ($activeCategory === $cat);
          $count    = (int)($categoryCounts[$cat] ?? 0);
          // Hide categories that have nothing in them (except "All")
          if ($cat !== '' && $count === 0 && !$isActive) { continue; }
        ?>
        <a href="<?= url('projects' . ($cat ? '?cat=' . urlencode($cat) : '')) ?>"<?= $isActive ? ' aria-current="page"' : '' ?>>
          <span><?= Security::e($meta['label']) ?></span>
          <span class="s-num"><?= $count ?></span>
        </a>
        <?php endforeach; ?>
      </nav>

      <p class="s-small s-mute">
        <?php if ($shown): ?>
          Showing <?= $shown ?> <?= $shown === 1 ? 'project' : 'projects' ?><?php if ($activeCategory): ?> in <?= Security::e($activeLabel) ?><?php endif; ?>
        <?php else: ?>
          No projects to show
        <?php endif; ?>
      </p>
    </div>
  </div>
</section>

<!-- ── Work rows ────────────────────────────────────────────── -->
<section class="s-sec" style="padding-top:0">
  <div class="s-shell">
    <?php if ($projects): ?>
    <div id="ProjectGrid" style="border-top:1px solid var(--ink)">
      <?php foreach ($projects as $i => $p):
        $techList  = array_filter(array_map('trim', explode(',', (string)($p['tech_stack'] ?? ''))));
        $techShown = array_slice($techList, 0, 4);
        $techExtra = count($techList) - count($techShown);
        $detailUrl = url('projects/view?slug=' . urlencode($p['slug']));
        $fallback  = uploadUrl(!empty($p['thumbnail']) ? $p['thumbnail'] : 'project_startup_landing.png');
      ?>
      <article class="s-work" data-reveal>
        <a href="<?= $detailUrl ?>" class="s-media s-media--16x10" aria-label="View <?= Security::e($p['title']) ?>">
          <?php if (!empty($p['live_url'])): ?>
          <img src="//image.thum.io/get/width/800/crop/500/noanimate/<?= Security::e(rtrim($p['live_url'], '/')) ?>"
               alt="<?= Security::e($p['title']) ?>" width="800" height="500"
               loading="<?= $i === 0 ? 'eager' : 'lazy' ?>"
               onerror="this.onerror=null; this.src='<?= Security::e($fallback) ?>'">
          <?php else: ?>
          <img src="<?= Security::e($fallback) ?>" alt="<?= Security::e($p['title']) ?>" width="800" height="500"
               loading="<?= $i === 0 ? 'eager' : 'lazy' ?>">
          <?php endif; ?>
        </a>

        <div>
          <p class="s-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?> &mdash; <?= Security::e(ucfirst((string)$p['category'])) ?><?php if (!empty($p['is_featured'])): ?> &middot; Featured<?php endif; ?></p>
          <h2 class="s-h2 mt-3"><a href="<?= $detailUrl ?>" style="text-decoration:none"><?= Security::e($p['title']) ?></a></h2>
          <p class="s-mute mt-3"><?= Security::e(truncate((string)($p['description'] ?? ''), 110)) ?></p>

          <?php if ($techShown): ?>
          <div class="s-tags mt-5">
            <?php foreach ($techShown as $tech): ?>
            <span class="s-tag"><?= Security::e($tech) ?></span>
            <?php endforeach; ?>
            <?php if ($techExtra > 0): ?>
            <span class="s-tag">+<?= $techExtra ?></span>
            <?php endif; ?>
          </div>
          <?php endif; ?>

          <p class="s-actions mt-6">
            <a href="<?= $detailUrl ?>" class="s-link">View case study</a>
            <?php if (!empty($p['live_url'])): ?>
            <a href="<?= Security::e($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="s-link">Live site <i class="fas fa-up-right-from-square text-[10px]" aria-hidden="true"></i></a>
            <?php endif; ?>
          </p>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <?php else: ?>
    <div class="s-panel s-panel--deep" style="max-width:40rem">
      <h2 class="s-h3">
        <?php if ($activeCategory): ?>
          Nothing in <?= Security::e($activeLabel) ?> yet
        <?php else: ?>
          No projects published yet
        <?php endif; ?>
      </h2>
      <p class="s-mute mt-3">
        <?php if ($activeCategory): ?>
          We haven't published work in this category yet. Browse the full list instead.
        <?php else: ?>
          Case studies are on the way. In the meantime, tell us what you're building.
        <?php endif; ?>
      </p>
      <div class="s-actions mt-6">
        <?php if ($activeCategory): ?>
        <a href="<?= url('projects') ?>" class="s-btn s-btn--sm">View all projects</a>
        <?php endif; ?>
        <a href="<?= url('contact') ?>" class="s-btn--line s-btn--sm">Start a project</a>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- ── CTA ──────────────────────────────────────────────────── -->
<section class="s-band s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 7">
        <p class="s-eyebrow">Start a project</p>
        <h2 class="s-h1">Have something in mind?</h2>
      </div>
      <div style="grid-column:span 5" class="flex flex-col justify-end">
        <p class="s-lede">Tell us what you're building. We reply with a non-binding technical proposal within 24 hours.</p>
        <div class="s-actions mt-6">
          <a href="<?= url('contact') ?>" class="s-btn--light">Start a conversation</a>
          <a href="<?= url('services') ?>" class="s-btn--line">Our services</a>
        </div>
      </div>
    </div>
  </div>
</section>
