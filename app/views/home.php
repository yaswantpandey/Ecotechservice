<?php
/* ==========================================================================
   Home — card-led layout, short copy, real project imagery.
   Palette unchanged: #030712 base, #111827 panels, eco-green accent.
   Fonts: Fraunces (warm display) + Figtree (humanist body). No mono.
   ========================================================================== */

// ── What we do — short lines only ─────────────────────────────────────────
$capabilities = [
    ['icon' => 'fa-layer-group',        'name' => 'Full-stack web apps',  'line' => 'Enterprise platforms, portals and dashboards.'],
    ['icon' => 'fa-mobile-screen',      'name' => 'Mobile apps',          'line' => 'Cross-platform builds for Android and iOS.'],
    ['icon' => 'fa-diagram-project',    'name' => 'Microservices',        'line' => 'Automated services with clean boundaries.'],
    ['icon' => 'fa-bolt',               'name' => 'Serverless workflows', 'line' => 'Event-driven jobs that scale to zero.'],
    ['icon' => 'fa-shield-halved',      'name' => 'Security engineering', 'line' => 'OWASP review built into every merge.'],
    ['icon' => 'fa-arrows-rotate',      'name' => 'CI/CD + maintenance',  'line' => 'One-command releases, and rollbacks.'],
];

// ── The real 5-stage lifecycle — one line each ────────────────────────────
$lifecycle = [
    ['no' => '01', 'name' => 'Discovery',         'line' => 'We read your existing system first.'],
    ['no' => '02', 'name' => 'Architecture',      'line' => 'Every decision written down with its trade-off.'],
    ['no' => '03', 'name' => 'Secure build',      'line' => 'Reviewed code, tested before merge.'],
    ['no' => '04', 'name' => 'CI/CD automation',  'line' => 'Releases run by pipeline, not by hand.'],
    ['no' => '05', 'name' => 'Maintenance',       'line' => 'A named engineer who knows the codebase.'],
];

// ── How to hire us — one line each ────────────────────────────────────────
$engagements = [
    ['icon' => 'fa-cube',   'name' => 'Project-based',  'line' => 'Fixed scope, staged delivery, quoted after discovery.'],
    ['icon' => 'fa-repeat', 'name' => 'Retainer',       'line' => 'Monthly hours on a live system, named engineer.'],
    ['icon' => 'fa-users',  'name' => 'Dedicated team', 'line' => 'Engineers embedded in your repo and your process.'],
];

// ── Real projects from the database ───────────────────────────────────────
$work = (!empty($featuredProjects) && is_array($featuredProjects)) ? $featuredProjects : [];
$hero = $work[0] ?? null;                 // hero image
$cards = array_slice($work, 0, 6);        // work grid

/** First 3 stack items, trimmed. */
$stackList = static function (?string $raw, int $limit = 3): array {
    if (!$raw) return [];
    return array_slice(array_values(array_filter(array_map('trim', explode(',', $raw)))), 0, $limit);
};
?>

<style>
/* ========== Scoped to .hm — existing palette, card-led structure ========== */
.hm {
  --bg:     #030712;
  --card:   #0C111A;
  --card-2: #111827;
  --line:   rgba(255,255,255,0.09);
  --fg:     #f9fafb;
  --fg-2:   #A2ABB8;
  --fg-3:   #6b7280;
  --eco:    #22c55e;
  --eco-br: #4ade80;
  background: var(--bg);
  color: var(--fg);
  font-family: 'Figtree', 'Inter', system-ui, sans-serif;
  font-size: 16px; line-height: 1.6;
  -webkit-font-smoothing: antialiased;
}
.hm ::selection { background: var(--eco); color: #04120A; }

/* Warm display face — nothing geometric or mono */
.hm-h {
  font-family: 'Fraunces', Georgia, serif;
  font-weight: 500; letter-spacing: -0.015em; line-height: 1.08;
  text-wrap: balance;
}
.hm-eyebrow {
  font-size: .8125rem; font-weight: 600; letter-spacing: .01em;
  color: var(--eco-br);
}
.hm-lede { font-size: 1.0625rem; color: var(--fg-2); }

.hm-shell { max-width: 1280px; margin: 0 auto; padding: 0 1.25rem; }
@media (min-width: 1024px) { .hm-shell { padding: 0 2.5rem; } }
.hm-band { border-top: 1px solid var(--line); }

/* ── Cards ───────────────────────────────────────────────────────────── */
.hm-card {
  background: var(--card);
  border: 1px solid var(--line);
  border-radius: 6px;
  padding: 1.5rem;
  transition: border-color .2s ease, background .2s ease;
}
.hm-card:hover { border-color: rgba(34,197,94,.45); background: var(--card-2); }
.hm-ico {
  width: 40px; height: 40px; border-radius: 6px;
  background: rgba(34,197,94,.1); border: 1px solid rgba(34,197,94,.22);
  color: var(--eco-br); display: flex; align-items: center; justify-content: center;
  font-size: .9375rem; margin-bottom: 1rem;
}
.hm-card h3 { font-family: 'Fraunces', Georgia, serif; font-weight: 500; font-size: 1.125rem; margin-bottom: .35rem; }
.hm-card p { font-size: .875rem; color: var(--fg-2); }

/* Work card */
.hm-work { display: block; text-decoration: none; color: inherit; overflow: hidden; }
.hm-work .hm-shot { aspect-ratio: 16/10; }
.hm-work h3 { margin-top: 1rem; }
.hm-tag {
  font-size: .6875rem; font-weight: 500; color: var(--fg-2);
  border: 1px solid var(--line); border-radius: 999px; padding: .18rem .55rem;
}

/* Images + real skeleton loaders */
.hm-shot { position: relative; background: var(--card-2); border: 1px solid var(--line); border-radius: 6px; overflow: hidden; }
.hm-shot img { display: block; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity .35s ease; }
.hm-shot img.is-loaded { opacity: 1; }
.hm-skel { position: absolute; inset: 0; background: var(--card-2); }
.hm-skel::after {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,.055), transparent);
  transform: translateX(-100%); animation: hmSweep 1.3s linear infinite;
}
@keyframes hmSweep { to { transform: translateX(100%); } }

/* Lifecycle step card — number fills as it scrolls into view */
.hm-step { position: relative; }
.hm-step-no {
  font-family: 'Fraunces', Georgia, serif; font-size: 1.5rem; font-weight: 600;
  color: rgba(255,255,255,.2); transition: color .35s ease;
}
.hm-step[data-reached="1"] .hm-step-no { color: var(--eco-br); }
.hm-step-bar { height: 2px; background: var(--line); margin: .7rem 0 1rem; overflow: hidden; border-radius: 2px; }
.hm-step-bar > i { display: block; height: 100%; width: 0; background: var(--eco); transition: width .6s cubic-bezier(.2,.7,.2,1); }
.hm-step[data-reached="1"] .hm-step-bar > i { width: 100%; }

/* Actions */
.hm-cta {
  display: inline-flex; align-items: center; gap: .5rem;
  background: var(--eco); color: #04120A; border: 1px solid var(--eco);
  border-radius: 6px; padding: .8rem 1.35rem; font-weight: 600; font-size: .9375rem;
  text-decoration: none; transition: background .2s ease;
}
.hm-cta:hover { background: var(--eco-br); }
.hm-ghost {
  display: inline-flex; align-items: center; gap: .5rem;
  border: 1px solid var(--line); border-radius: 6px; color: var(--fg);
  padding: .8rem 1.35rem; font-weight: 500; font-size: .9375rem;
  text-decoration: none; transition: border-color .2s ease, color .2s ease;
}
.hm-ghost:hover { border-color: var(--eco); color: var(--eco-br); }
.hm-link { color: var(--eco-br); text-decoration: none; font-weight: 500; font-size: .9375rem; }
.hm-link:hover { text-decoration: underline; }

.hm-live { display: inline-flex; align-items: center; gap: .5rem; font-size: .8125rem; color: var(--fg-2); }
.hm-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--eco); animation: hmPulse 2.4s ease-in-out infinite; }
@keyframes hmPulse { 0%,100% { opacity: 1; } 50% { opacity: .3; } }

.hm-rise { opacity: 0; transform: translateY(10px); }
.hm-rise.is-in { opacity: 1; transform: none; transition: opacity .45s ease, transform .45s ease; }
@media (prefers-reduced-motion: reduce) {
  .hm-rise, .hm-rise.is-in { opacity: 1; transform: none; transition: none; }
  .hm-dot, .hm-skel::after { animation: none; }
  .hm-step-bar > i { transition: none; }
}
</style>

<div class="hm">

  <!-- ══ HERO — short copy + a real project shot ═════════════════════════ -->
  <section class="hm-shell pt-[104px] md:pt-[124px] lg:pt-[136px] pb-14 lg:pb-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">

      <div class="lg:col-span-6">
        <p class="hm-eyebrow mb-4">Software engineering · Lucknow, India</p>
        <h1 class="hm-h text-[2.4rem] sm:text-[3.1rem] lg:text-[3.7rem] mb-5">
          Software that stays fast.
        </h1>
        <p class="hm-lede max-w-[46ch] mb-8">
          We build web platforms, mobile apps and serverless systems — and we stay on
          to maintain them.
        </p>
        <div class="flex flex-wrap items-center gap-3">
          <a href="<?= url('contact') ?>" class="hm-cta">Talk to an engineer <i class="fas fa-arrow-right text-xs"></i></a>
          <a href="<?= url('projects') ?>" class="hm-ghost">See our work</a>
        </div>
      </div>

      <?php if ($hero): ?>
      <div class="lg:col-span-6">
        <div class="hm-shot" style="aspect-ratio:16/11">
          <div class="hm-skel" data-skel aria-hidden="true"></div>
          <img data-shot src="<?= url('uploads/' . rawurlencode($hero['thumbnail'] ?? '')) ?>"
               alt="<?= Security::e($hero['title'] ?? 'Project') ?> — delivered interface"
               width="1280" height="880" loading="eager" decoding="async" fetchpriority="high">
        </div>
        <p class="text-xs mt-3" style="color:var(--fg-3)">
          Live client build — <?= Security::e($hero['title'] ?? '') ?>
        </p>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- ══ CAPABILITIES — cards, one line each ════════════════════════════ -->
  <section class="hm-band">
    <div class="hm-shell py-14 lg:py-18">
      <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
        <h2 class="hm-h text-[1.75rem] lg:text-[2.2rem]">What we build</h2>
        <a href="<?= url('services') ?>" class="hm-link">All services <i class="fas fa-arrow-right text-[10px]"></i></a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($capabilities as $c): ?>
        <div class="hm-card hm-rise">
          <div class="hm-ico"><i class="fas <?= $c['icon'] ?>"></i></div>
          <h3><?= Security::e($c['name']) ?></h3>
          <p><?= Security::e($c['line']) ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ══ LIFECYCLE — 5 compact cards, progress fills as you scroll ══════ -->
  <section class="hm-band">
    <div class="hm-shell py-14 lg:py-18">
      <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
        <div>
          <h2 class="hm-h text-[1.75rem] lg:text-[2.2rem] mb-2">How a project runs</h2>
          <p class="hm-lede">Five stages. We do all of them.</p>
        </div>
        <span class="hm-live"><span class="hm-dot"></span> Same process on every build</span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <?php foreach ($lifecycle as $s): ?>
        <div class="hm-card hm-step" data-step data-reached="0">
          <div class="hm-step-no"><?= $s['no'] ?></div>
          <div class="hm-step-bar" aria-hidden="true"><i></i></div>
          <h3><?= Security::e($s['name']) ?></h3>
          <p><?= Security::e($s['line']) ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ══ WORK — real project cards with real screenshots ════════════════ -->
  <section class="hm-band">
    <div class="hm-shell py-14 lg:py-18">
      <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
        <div>
          <h2 class="hm-h text-[1.75rem] lg:text-[2.2rem] mb-2">Live work</h2>
          <p class="hm-lede">Every one of these is in production.</p>
        </div>
        <a href="<?= url('projects') ?>" class="hm-link">Full Project <i class="fas fa-arrow-right text-[10px]"></i></a>
      </div>

      <?php if (empty($cards)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <?php for ($i = 0; $i < 3; $i++): ?>
          <div class="hm-card">
            <div class="hm-shot" style="aspect-ratio:16/10"><div class="hm-skel" aria-hidden="true"></div></div>
          </div>
          <?php endfor; ?>
        </div>
      <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <?php foreach ($cards as $p): ?>
          <a class="hm-card hm-work hm-rise" href="<?= url('projects/view?slug=' . urlencode($p['slug'] ?? '')) ?>">
            <div class="hm-shot">
              <div class="hm-skel" data-skel aria-hidden="true"></div>
              <img data-shot src="<?= url('uploads/' . rawurlencode($p['thumbnail'] ?? '')) ?>"
                   alt="<?= Security::e($p['title'] ?? 'Project') ?> — delivered interface"
                   width="640" height="400" loading="lazy" decoding="async">
            </div>
            <h3><?= Security::e($p['title'] ?? '') ?></h3>
            <div class="flex flex-wrap gap-1.5 mt-3">
              <?php foreach ($stackList($p['tech_stack'] ?? null) as $t): ?>
                <span class="hm-tag"><?= Security::e($t) ?></span>
              <?php endforeach; ?>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- ══ ENGAGEMENT — three short cards ═════════════════════════════════ -->
  <section class="hm-band">
    <div class="hm-shell py-14 lg:py-18">
      <h2 class="hm-h text-[1.75rem] lg:text-[2.2rem] mb-8">Ways to work with us</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($engagements as $e): ?>
        <div class="hm-card hm-rise">
          <div class="hm-ico"><i class="fas <?= $e['icon'] ?>"></i></div>
          <h3><?= Security::e($e['name']) ?></h3>
          <p><?= Security::e($e['line']) ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ══ CONTACT — short ════════════════════════════════════════════════ -->
  <section class="hm-band" style="background:var(--card)">
    <div class="hm-shell py-16 lg:py-20">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-8">
          <h2 class="hm-h text-[1.9rem] sm:text-[2.5rem] mb-3">Send us what you already have.</h2>
          <p class="hm-lede max-w-[52ch]">
            A repo link, a staging URL, or the page that's slow. An engineer replies —
            <?= Security::e(setting('business_hours') ?: 'Mon – Sat, 09:00 – 18:00 IST') ?>.
          </p>
        </div>
        <div class="lg:col-span-4 flex flex-wrap gap-3 lg:justify-end">
          <a href="<?= url('contact') ?>" class="hm-cta">Talk to an engineer <i class="fas fa-arrow-right text-xs"></i></a>
          <a href="mailto:<?= Security::e(setting('site_email') ?: 'ecotech.internships@gmail.com') ?>" class="hm-ghost">Email us</a>
        </div>
      </div>
    </div>
  </section>

</div>

<script>
/* Skeletons clear on real image decode; cards and step progress reveal on scroll. */
(function () {
  'use strict';
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  document.querySelectorAll('[data-shot]').forEach(function (img) {
    function settle() {
      img.classList.add('is-loaded');
      var skel = img.parentNode.querySelector('[data-skel]');
      if (skel) skel.remove();
    }
    if (img.complete && img.naturalWidth > 0) { settle(); return; }
    img.addEventListener('load', settle, { once: true });
    img.addEventListener('error', function () {
      var skel = img.parentNode.querySelector('[data-skel]');
      if (skel) skel.style.animation = 'none';
    }, { once: true });
  });

  var steps = document.querySelectorAll('[data-step]');
  var rises = document.querySelectorAll('.hm-rise');

  if (!('IntersectionObserver' in window) || reduced) {
    steps.forEach(function (s) { s.setAttribute('data-reached', '1'); });
    rises.forEach(function (r) { r.classList.add('is-in'); });
    return;
  }

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      if (entry.target.hasAttribute('data-step')) entry.target.setAttribute('data-reached', '1');
      entry.target.classList.add('is-in');
      io.unobserve(entry.target);
    });
  }, { rootMargin: '0px 0px -12% 0px', threshold: 0.15 });

  steps.forEach(function (s) { io.observe(s); });
  rises.forEach(function (r) { io.observe(r); });
})();
</script>
