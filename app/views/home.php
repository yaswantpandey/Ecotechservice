<?php
/* ==========================================================================
   Home — editorial layout on the site design system (assets/css/site.css).
   Hero: line-drawn Three.js globe (assets/js/home-scene.js), ink on paper.
   All content is server-rendered; the scene is decoration only.
   ========================================================================== */

$capabilities = [
    ['name' => 'Full-stack web apps',  'line' => 'Enterprise platforms, client portals and internal dashboards, built on a stack your team can hire for.'],
    ['name' => 'Mobile apps',          'line' => 'Cross-platform builds for Android and iOS that share one codebase and one release process.'],
    ['name' => 'Microservices',        'line' => 'Services split along real business boundaries, each with its own tests, deploy and owner.'],
    ['name' => 'Serverless workflows', 'line' => 'Event-driven jobs for imports, reports and notifications that cost nothing when idle.'],
    ['name' => 'Security engineering', 'line' => 'OWASP review on every merge, plus standalone audits and penetration tests for existing systems.'],
    ['name' => 'CI/CD and maintenance','line' => 'One-command releases with rollbacks, and a named engineer who keeps the system healthy after launch.'],
];

$lifecycle = [
    ['name' => 'Discovery',        'line' => 'We read your existing system, data and constraints before proposing anything.'],
    ['name' => 'Architecture',     'line' => 'Every significant decision is written down with the trade-off it accepts.'],
    ['name' => 'Secure build',     'line' => 'Code is reviewed and tested before it merges. No direct pushes to production.'],
    ['name' => 'CI/CD automation', 'line' => 'Releases run through a pipeline, not by hand, so they are repeatable and reversible.'],
    ['name' => 'Maintenance',      'line' => 'A named engineer who knows the codebase handles updates, fixes and monitoring.'],
];

$engagements = [
    ['name' => 'Project-based',  'line' => 'Fixed scope and staged delivery, quoted after a short discovery phase.'],
    ['name' => 'Retainer',       'line' => 'A monthly block of hours on a live system, with the same engineer each month.'],
    ['name' => 'Dedicated team', 'line' => 'Engineers embedded in your repository, your tracker and your release process.'],
];

$work   = (!empty($featuredProjects) && is_array($featuredProjects)) ? $featuredProjects : [];
$cards  = array_slice($work, 0, 4);
$quotes = (!empty($testimonials) && is_array($testimonials)) ? array_slice($testimonials, 0, 2) : [];

$stackList = static function (?string $raw, int $limit = 4): array {
    if (!$raw) return [];
    return array_slice(array_values(array_filter(array_map('trim', explode(',', $raw)))), 0, $limit);
};

$asset = static function (string $path): string {
    $file = PUBLIC_PATH . '/' . $path;
    return url($path) . '?v=' . (file_exists($file) ? filemtime($file) : APP_VERSION);
};
?>

<style>
/* Home-only: hero globe frame */
.h-globe { position: relative; aspect-ratio: 1 / 1; width: 100%; max-width: 620px; margin-left: auto; border: 1px solid var(--rule); background: var(--paper); }
.h-globe canvas { position: absolute; inset: 0; width: 100%; height: 100%; display: block; }
.h-globe-cap { position: absolute; left: 1rem; right: 1rem; bottom: .85rem; display: flex; justify-content: space-between; font-family: var(--f-mono); font-size: .72rem; color: var(--ink-3); pointer-events: none; }
.h-globe:not(.is-3d)::before {
  content: ''; position: absolute; inset: 12%; border: 1px solid var(--ink-3); border-radius: 50%;
}
.h-hero { padding: 3.5rem 0 4.5rem; }
@media (min-width: 1024px) { .h-hero { padding: 5rem 0 6rem; } }
.h-quote { margin: 0; }
.h-quote blockquote { margin: 0; font-family: var(--f-display); font-size: clamp(1.3rem, 2.2vw, 1.75rem); line-height: 1.3; letter-spacing: -.01em; }
.h-quote figcaption { margin-top: 1.25rem; font-size: .875rem; color: var(--ink-2); }
</style>

<!-- ══ Hero ═════════════════════════════════════════════════════════════ -->
<section class="h-hero">
  <div class="s-shell">
    <div class="s-grid" style="align-items:center">
      <div style="grid-column:span 6">
        <span class="s-eyebrow">Software engineering studio &middot; Lucknow, India</span>
        <h1 class="s-display">Software that <span class="s-it">stays</span> fast.</h1>
        <p class="s-lede" style="margin-top:1.75rem">
          We build web platforms, mobile apps and serverless systems, review them for security
          before every release, and stay on to maintain them.
        </p>
        <div class="s-actions" style="margin-top:2.25rem">
          <a href="<?= url('contact') ?>" class="s-btn">Talk to an engineer</a>
          <a href="<?= url('projects') ?>" class="s-btn--line">See the work</a>
        </div>
      </div>
      <div style="grid-column:span 6">
        <div class="h-globe" aria-hidden="true">
          <canvas data-hero-canvas></canvas>
          <div class="h-globe-cap"><span>26.85&deg; N, 80.95&deg; E</span><span>Lucknow</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ Figures (real counts only) ═══════════════════════════════════════ -->
<section class="s-sec--tight">
  <div class="s-shell">
    <div class="s-figs" data-reveal>
      <?php if (count($work) > 0): ?>
      <div class="s-fig"><b><span data-counter><?= count($work) ?></span></b><span>Projects live in production</span></div>
      <?php endif; ?>
      <?php if (!empty($services)): ?>
      <div class="s-fig"><b><span data-counter><?= count($services) ?></span></b><span>Service lines</span></div>
      <?php endif; ?>
      <div class="s-fig"><b>5</b><span>Stages on every build</span></div>
      <div class="s-fig"><b>11</b><span>Internship tracks open</span></div>
    </div>
  </div>
</section>

<!-- ══ Capabilities ═════════════════════════════════════════════════════ -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid" style="margin-bottom:2.5rem;align-items:end">
      <div style="grid-column:span 6">
        <span class="s-eyebrow">01 &mdash; Capabilities</span>
        <h2 class="s-h2">What we build</h2>
      </div>
      <div style="grid-column:span 6" class="lg:text-right">
        <a href="<?= url('services') ?>" class="s-link">All services</a>
      </div>
    </div>
    <ol class="s-list" data-reveal>
      <?php foreach ($capabilities as $i => $c): ?>
      <li>
        <span class="s-num"><?= sprintf('%02d', $i + 1) ?></span>
        <h3 class="s-h3"><?= Security::e($c['name']) ?></h3>
        <p><?= Security::e($c['line']) ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<!-- ══ Process (ink band) ═══════════════════════════════════════════════ -->
<section class="s-band s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 4">
        <span class="s-eyebrow">02 &mdash; Process</span>
        <h2 class="s-h2">How a project runs</h2>
        <p class="s-small" style="margin-top:1.25rem;max-width:32ch">Five stages, the same on every build. We do all of them ourselves.</p>
      </div>
      <div style="grid-column:span 8">
        <ol class="s-list" data-reveal>
          <?php foreach ($lifecycle as $i => $s): ?>
          <li>
            <span class="s-num"><?= sprintf('%02d', $i + 1) ?></span>
            <h3 class="s-h3"><?= Security::e($s['name']) ?></h3>
            <p><?= Security::e($s['line']) ?></p>
          </li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ══ Work ═════════════════════════════════════════════════════════════ -->
<?php if (!empty($cards)): ?>
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid" style="align-items:end">
      <div style="grid-column:span 6">
        <span class="s-eyebrow">03 &mdash; Selected work</span>
        <h2 class="s-h2">Live in production</h2>
      </div>
      <div style="grid-column:span 6" class="lg:text-right">
        <a href="<?= url('projects') ?>" class="s-link">All projects (<?= count($work) ?>)</a>
      </div>
    </div>

    <div style="margin-top:1rem">
      <?php foreach ($cards as $i => $p): ?>
      <a class="s-work" href="<?= url('projects/view?slug=' . urlencode($p['slug'] ?? '')) ?>" data-reveal>
        <div class="s-media s-media--16x10">
          <?php if (!empty($p['thumbnail'])): ?>
          <img src="<?= url('uploads/' . rawurlencode($p['thumbnail'])) ?>"
               alt="<?= Security::e($p['title'] ?? 'Project') ?> — delivered interface"
               width="1280" height="800" loading="<?= $i === 0 ? 'eager' : 'lazy' ?>" decoding="async">
          <?php endif; ?>
        </div>
        <div>
          <span class="s-num"><?= sprintf('%02d', $i + 1) ?></span>
          <h3 class="s-h2" style="margin:.6rem 0 1rem"><?= Security::e($p['title'] ?? '') ?></h3>
          <?php if (!empty($p['description'])): ?>
          <p class="s-mute" style="margin:0 0 1rem;max-width:46ch"><?= Security::e(mb_strimwidth(strip_tags($p['description']), 0, 160, '…')) ?></p>
          <?php endif; ?>
          <div class="s-tags">
            <?php foreach ($stackList($p['tech_stack'] ?? null) as $t): ?>
              <span class="s-tag"><?= Security::e($t) ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ══ Engagement ═══════════════════════════════════════════════════════ -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 4">
        <span class="s-eyebrow">04 &mdash; Engagement</span>
        <h2 class="s-h2">Ways to work with us</h2>
      </div>
      <div style="grid-column:span 8">
        <dl class="s-kv" data-reveal>
          <?php foreach ($engagements as $e): ?>
          <div>
            <dt class="s-h3" style="color:var(--ink);font-size:1.2rem"><?= Security::e($e['name']) ?></dt>
            <dd style="color:var(--ink-2)"><?= Security::e($e['line']) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>
        <p class="s-small s-mute" style="margin-top:1.25rem">Every engagement starts with a short discovery call. <a class="s-link" href="<?= url('contact') ?>">Book one</a>.</p>
      </div>
    </div>
  </div>
</section>

<!-- ══ Testimonials (from the database only) ════════════════════════════ -->
<?php if (!empty($quotes)): ?>
<section class="s-sec">
  <div class="s-shell">
    <span class="s-eyebrow">05 &mdash; Client words</span>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16" style="margin-top:1.5rem" data-reveal>
      <?php foreach ($quotes as $q): ?>
      <figure class="h-quote" style="border-top:1px solid var(--ink);padding-top:1.5rem">
        <blockquote>&ldquo;<?= Security::e($q['message'] ?? '') ?>&rdquo;</blockquote>
        <figcaption>
          <strong style="color:var(--ink);font-weight:500"><?= Security::e($q['name'] ?? '') ?></strong><?php
            $role = trim(($q['position'] ?? '') . (!empty($q['company']) ? ', ' . $q['company'] : ''), ', ');
            if ($role !== ''): ?> &mdash; <?= Security::e($role) ?><?php endif; ?>
        </figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ══ Internships ══════════════════════════════════════════════════════ -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-panel s-panel--deep" style="padding:clamp(1.75rem,4vw,3.5rem)" data-reveal>
      <div class="s-grid" style="align-items:end">
        <div style="grid-column:span 7">
          <span class="s-eyebrow">Internship programme <?= date('Y') ?></span>
          <h2 class="s-h2">Eleven internship tracks, open for applications</h2>
          <p style="color:var(--ink-2);margin:1.25rem 0 0;max-width:60ch">
            Full stack, frontend, backend, Python, Java, mobile app, UI/UX, cybersecurity, IoT,
            AI &amp; machine learning and data science. Apply online, track your application,
            and receive a formal offer letter on selection.
          </p>
        </div>
        <div style="grid-column:span 5">
          <ul class="s-small" style="list-style:none;margin:0 0 1.5rem;padding:0;color:var(--ink-2)">
            <li style="padding:.45rem 0;border-bottom:1px solid var(--rule)">&mdash; Remote and hybrid options</li>
            <li style="padding:.45rem 0;border-bottom:1px solid var(--rule)">&mdash; Mentor code review</li>
            <li style="padding:.45rem 0;border-bottom:1px solid var(--rule)">&mdash; Formal offer letter and completion certificate</li>
          </ul>
          <div class="s-actions">
            <a href="<?= url('internships') ?>" class="s-btn">Browse tracks</a>
            <?php if (isIntern()): ?>
              <a href="<?= url('internships/dashboard') ?>" class="s-btn--line">My dashboard</a>
            <?php else: ?>
              <a href="<?= url('internships/register') ?>" class="s-btn--line">Create an account</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="module" src="<?= $asset('assets/js/home-scene.js') ?>"></script>
