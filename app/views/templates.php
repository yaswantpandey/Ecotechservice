<!-- TEMPLATES PAGE -->
<?php
// Apply filter from query param
$typeFilter = $_GET['type'] ?? '';
$filteredTemplates = $templates;
if ($typeFilter === 'free') {
    $filteredTemplates = array_filter($templates, fn($t) => $t['is_free']);
} elseif ($typeFilter === 'premium') {
    $filteredTemplates = array_filter($templates, fn($t) => !$t['is_free']);
}
?>

<!-- Intro -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 7">
        <p class="s-eyebrow">Ready-made designs</p>
        <h1 class="s-h1 mt-4">Launch with a ready template.</h1>
      </div>
      <div style="grid-column:span 5" class="lg:pt-10">
        <p class="s-lede">Responsive, production-ready website templates. Pick one, we customise it, and you go live in days instead of weeks.</p>
        <p class="s-mono s-mute mt-5"><span data-counter><?= (int)count($templates) ?></span> templates available</p>
      </div>
    </div>
  </div>
</section>

<!-- Filter + list -->
<section class="s-sec">
  <div class="s-shell">
    <nav class="s-filter" aria-label="Filter templates">
      <a href="<?= url('templates') ?>" <?= $typeFilter === '' ? 'aria-current="page"' : '' ?>>All templates</a>
      <a href="<?= url('templates?type=free') ?>" <?= $typeFilter === 'free' ? 'aria-current="page"' : '' ?>>Free</a>
      <a href="<?= url('templates?type=premium') ?>" <?= $typeFilter === 'premium' ? 'aria-current="page"' : '' ?>>Premium</a>
    </nav>

    <?php if ($filteredTemplates): ?>
    <div class="mt-10">
      <?php foreach (array_values($filteredTemplates) as $i => $t): ?>
      <article class="s-work" data-reveal>
        <div class="s-media s-media--16x10">
          <?php if (!empty($t['preview_url'])): ?>
          <img src="//image.thum.io/get/width/800/crop/500/noanimate/<?= Security::e(rtrim($t['preview_url'], '/')) ?>"
               alt="<?= Security::e($t['title']) ?>" width="800" height="500" loading="lazy"
               onerror="this.onerror=null;this.src='<?= Security::e(uploadUrl(!empty($t['thumbnail']) ? $t['thumbnail'] : 'template_business_pro.png')) ?>'">
          <?php elseif (!empty($t['thumbnail'])): ?>
          <img src="<?= uploadUrl($t['thumbnail']) ?>" alt="<?= Security::e($t['title']) ?>" width="800" height="500" loading="lazy">
          <?php endif; ?>
        </div>
        <div>
          <div class="flex items-center gap-3">
            <span class="s-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <span class="s-tag <?= $t['is_free'] ? 's-tag--signal' : 's-tag--solid' ?>"><?= $t['is_free'] ? 'Free' : 'Premium' ?></span>
          </div>
          <h2 class="s-h2 mt-4"><?= Security::e($t['title']) ?></h2>
          <p class="s-mute mt-3"><?= Security::e(truncate($t['description'], 110)) ?></p>
          <p class="s-mono mt-4"><?= $t['is_free'] ? 'Free' : '&#8377;' . Security::e(number_format((float)$t['price'])) ?></p>
          <div class="s-actions mt-6">
            <a href="<?= url('contact') ?>" class="s-btn s-btn--sm">Get template</a>
            <?php if (!empty($t['preview_url'])): ?>
            <a href="<?= Security::e($t['preview_url']) ?>" target="_blank" rel="noopener" class="s-btn--line s-btn--sm">Live preview</a>
            <?php endif; ?>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <?php else: ?>
    <!-- Empty state -->
    <div class="s-panel s-panel--deep mt-10">
      <h2 class="s-h3">No templates found</h2>
      <p class="s-mute mt-2">No templates in this category yet.</p>
      <div class="s-actions mt-6"><a href="<?= url('templates') ?>" class="s-btn--line s-btn--sm">View all templates</a></div>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- What's included -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5">
        <p class="s-eyebrow">What you get</p>
        <h2 class="s-h2 mt-4">Everything needed to launch.</h2>
      </div>
      <div style="grid-column:span 7" data-reveal>
        <?php
        $features = [
          ['title' => 'Fully responsive',  'desc' => 'Works on mobile, tablet and desktop out of the box.'],
          ['title' => 'Fast loading',      'desc' => 'Built for high PageSpeed scores with minimal dependencies.'],
          ['title' => 'Clean source code', 'desc' => 'Well-structured HTML, CSS and JS that is easy to customise and maintain.'],
          ['title' => 'Dedicated support', 'desc' => 'WhatsApp and email support for customisation, bugs and questions.'],
        ];
        ?>
        <ol class="s-list">
          <?php foreach ($features as $fi => $f): ?>
          <li><span class="s-num"><?= str_pad((string)($fi + 1), 2, '0', STR_PAD_LEFT) ?></span><h3 class="s-h3"><?= Security::e($f['title']) ?></h3><p><?= Security::e($f['desc']) ?></p></li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="s-sec s-band">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 7">
        <p class="s-eyebrow">Custom design</p>
        <h2 class="s-h2 mt-4">Need a fully custom design?</h2>
      </div>
      <div style="grid-column:span 5">
        <p>If no template fits, we design and build a site from scratch around your brand, audience and goals.</p>
        <div class="s-actions mt-6">
          <a href="<?= url('contact') ?>" class="s-btn--light">Request a custom design</a>
          <a href="<?= url('projects') ?>" class="s-btn--line">See our work</a>
        </div>
      </div>
    </div>
  </div>
</section>
