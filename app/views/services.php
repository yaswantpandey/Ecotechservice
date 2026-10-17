<!-- SERVICES PAGE -->
<?php
// Map nav/footer anchors (services#web, #mobile, ...) onto the first service whose slug/title matches.
$anchorKeywords = [
  'web'      => ['web-dev', 'website', 'web development', 'web'],
  'mobile'   => ['mobile', 'app'],
  'cloud'    => ['cloud', 'devops', 'hosting'],
  'security' => ['security', 'penetration', 'vapt', 'cyber'],
  'seo'      => ['seo', 'marketing'],
  'design'   => ['design', 'ui', 'ux'],
];
$serviceAnchors = [];   // index => anchor id
$usedAnchors    = [];
if (!empty($services)) {
  foreach ($anchorKeywords as $anchor => $words) {
    foreach (array_values($services) as $idx => $sv) {
      if (isset($serviceAnchors[$idx])) continue;
      $hay = strtolower(($sv['slug'] ?? '') . ' ' . ($sv['title'] ?? ''));
      $hit = false;
      foreach ($words as $w) {
        if (strpos($hay, $w) !== false) { $hit = true; break; }
      }
      if ($hit) { $serviceAnchors[$idx] = $anchor; $usedAnchors[] = $anchor; break; }
    }
  }
}
$unusedAnchors = array_diff(array_keys($anchorKeywords), $usedAnchors);
?>

<!-- Intro -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 7">
        <p class="s-eyebrow">Services</p>
        <h1 class="s-h1 mt-4">Engineering services, end to end.</h1>
      </div>
      <div style="grid-column:span 5" class="lg:pt-10">
        <p class="s-lede">Web development, cybersecurity, software engineering and automation &mdash; scoped, built and supported by the same team.</p>
        <div class="s-actions mt-6">
          <a href="<?= url('contact') ?>" class="s-btn">Discuss a project</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Service index -->
<section class="s-sec" id="all">
  <div class="s-shell">
    <?php foreach ($unusedAnchors as $ua): ?><span id="<?= Security::e($ua) ?>"></span><?php endforeach; ?>
    <?php if (!empty($services)): ?>
    <ol class="s-list" data-reveal>
      <?php foreach (array_values($services) as $idx => $sv): ?>
      <li id="<?= Security::e($sv['slug'] ?? ('service-' . ($idx + 1))) ?>">
        <?php if (isset($serviceAnchors[$idx])): ?><span id="<?= Security::e($serviceAnchors[$idx]) ?>" class="s-sr"></span><?php endif; ?>
        <span class="s-num"><?= str_pad((string)($idx + 1), 2, '0', STR_PAD_LEFT) ?></span>
        <h2 class="s-h3">
          <?php if (!empty($sv['icon'])): ?><i class="fas <?= Security::e($sv['icon']) ?> s-mute" aria-hidden="true" style="font-size:.9rem;margin-right:.5rem"></i><?php endif; ?>
          <?= Security::e($sv['title']) ?>
        </h2>
        <div>
          <p><?= Security::e($sv['description']) ?></p>
          <p class="mt-3"><a href="<?= url('contact') ?>" class="s-link">Enquire about <?= Security::e($sv['title']) ?></a></p>
        </div>
      </li>
      <?php endforeach; ?>
    </ol>
    <?php else: ?>
    <div class="s-notice">Services coming soon.</div>
    <?php endif; ?>
  </div>
</section>

<!-- Process -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5">
        <p class="s-eyebrow">Development lifecycle</p>
        <h2 class="s-h2 mt-4">Our development process.</h2>
      </div>
      <div style="grid-column:span 7" data-reveal>
        <ol class="s-list">
          <?php foreach ([
            ['num'=>'01', 'title'=>'Discovery &amp; scope', 'desc'=>'We map your business goals, audience and technical requirements.'],
            ['num'=>'02', 'title'=>'UI/UX design',         'desc'=>'Wireframes, responsive prototypes and user flows, reviewed with you.'],
            ['num'=>'03', 'title'=>'Agile development',    'desc'=>'Clean, secure, scalable code delivered in short reviewed iterations.'],
            ['num'=>'04', 'title'=>'Launch &amp; scale',   'desc'=>'Cloud deployment, SEO optimisation and ongoing support.'],
          ] as $step): ?>
          <li><span class="s-num"><?= $step['num'] ?></span><h3 class="s-h3"><?= $step['title'] ?></h3><p><?= $step['desc'] ?></p></li>
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
        <h2 class="s-h2">Need a custom software solution?</h2>
      </div>
      <div style="grid-column:span 5">
        <p>Tell us your requirements and we will come back with a scope and an approach.</p>
        <div class="s-actions mt-6">
          <a href="<?= url('contact') ?>" class="s-btn--light">Contact us</a>
        </div>
      </div>
    </div>
  </div>
</section>
