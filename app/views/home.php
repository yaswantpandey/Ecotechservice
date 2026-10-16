<?php
/* ==========================================================================
   Home — immersive redesign.
   Three.js network globe in the hero (assets/js/home-scene.js), GSAP +
   ScrollTrigger + Lenis motion (assets/js/home-motion.js).
   Everything is readable with JS off; motion is layered on via .is-motion.
   Palette unchanged: #030712 base, eco-green accent.
   ========================================================================== */

// ── What we do ────────────────────────────────────────────────────────────
$capabilities = [
    ['icon' => 'fa-layer-group',     'name' => 'Full-stack web apps',  'line' => 'Enterprise platforms, portals and dashboards.'],
    ['icon' => 'fa-mobile-screen',   'name' => 'Mobile apps',          'line' => 'Cross-platform builds for Android and iOS.'],
    ['icon' => 'fa-diagram-project', 'name' => 'Microservices',        'line' => 'Automated services with clean boundaries.'],
    ['icon' => 'fa-bolt',            'name' => 'Serverless workflows', 'line' => 'Event-driven jobs that scale to zero.'],
    ['icon' => 'fa-shield-halved',   'name' => 'Security engineering', 'line' => 'OWASP review built into every merge.'],
    ['icon' => 'fa-arrows-rotate',   'name' => 'CI/CD + maintenance',  'line' => 'One-command releases, and rollbacks.'],
];

// ── The 5-stage lifecycle ─────────────────────────────────────────────────
$lifecycle = [
    ['no' => '01', 'icon' => 'fa-magnifying-glass', 'name' => 'Discovery',        'line' => 'We read your existing system first.'],
    ['no' => '02', 'icon' => 'fa-compass-drafting', 'name' => 'Architecture',     'line' => 'Every decision written down with its trade-off.'],
    ['no' => '03', 'icon' => 'fa-code',             'name' => 'Secure build',     'line' => 'Reviewed code, tested before merge.'],
    ['no' => '04', 'icon' => 'fa-rocket',           'name' => 'CI/CD automation', 'line' => 'Releases run by pipeline, not by hand.'],
    ['no' => '05', 'icon' => 'fa-heart-pulse',      'name' => 'Maintenance',      'line' => 'A named engineer who knows the codebase.'],
];

// ── How to hire us ────────────────────────────────────────────────────────
$engagements = [
    ['icon' => 'fa-cube',   'name' => 'Project-based',  'line' => 'Fixed scope, staged delivery, quoted after discovery.'],
    ['icon' => 'fa-repeat', 'name' => 'Retainer',       'line' => 'Monthly hours on a live system, named engineer.'],
    ['icon' => 'fa-users',  'name' => 'Dedicated team', 'line' => 'Engineers embedded in your repo and your process.'],
];

// ── Real data from the controller ─────────────────────────────────────────
$work   = (!empty($featuredProjects) && is_array($featuredProjects)) ? $featuredProjects : [];
$cards  = array_slice($work, 0, 8);
$quotes = (!empty($testimonials) && is_array($testimonials)) ? $testimonials : [];

/** First N stack items, trimmed. */
$stackList = static function (?string $raw, int $limit = 3): array {
    if (!$raw) return [];
    return array_slice(array_values(array_filter(array_map('trim', explode(',', $raw)))), 0, $limit);
};

// Marquee: the stack we actually shipped, from real projects.
$stack = [];
foreach ($work as $p) {
    foreach ($stackList($p['tech_stack'] ?? null, 20) as $t) {
        $stack[strtolower($t)] = $t;
    }
}
$stack = array_values($stack);
if (count($stack) < 6) {
    $stack = array_values(array_unique(array_merge($stack, ['PHP', 'Laravel', 'React', 'Node.js', 'Flutter', 'MySQL', 'AWS', 'Docker', 'Python', 'Tailwind'])));
}

/** Escaped words wrapped in masks for the line-slide animation. */
$split = static function (string $text): string {
    $out = [];
    foreach (preg_split('/\s+/', trim($text)) as $w) {
        $out[] = '<span class="w"><span>' . Security::e($w) . '</span></span>';
    }
    return implode(' ', $out);
};

$asset = static function (string $path): string {
    $file = PUBLIC_PATH . '/' . $path;
    return url($path) . '?v=' . (file_exists($file) ? filemtime($file) : APP_VERSION);
};
?>

<style>
/* ========== Scoped to .hx ========== */
.hx {
  --bg:     #030712;
  --card:   #0A0F18;
  --card-2: #111827;
  --line:   rgba(255,255,255,0.08);
  --fg:     #f9fafb;
  --fg-2:   #A2ABB8;
  --fg-3:   #6b7280;
  --eco:    #22c55e;
  --eco-br: #4ade80;
  --teal:   #2dd4bf;
  background: var(--bg);
  color: var(--fg);
  font-family: 'Figtree', 'Inter', system-ui, sans-serif;
  font-size: 16px; line-height: 1.6;
  -webkit-font-smoothing: antialiased;
  overflow-x: clip;
  position: relative;
}
.hx ::selection { background: var(--eco); color: #04120A; }
.hx-shell { max-width: 1320px; margin: 0 auto; padding: 0 1.25rem; }
@media (min-width: 1024px) { .hx-shell { padding: 0 2.5rem; } }

.hx-h {
  font-family: 'Fraunces', Georgia, serif;
  font-weight: 500; letter-spacing: -0.025em; line-height: 1.02;
  text-wrap: balance;
}
.hx-eyebrow {
  display: inline-flex; align-items: center; gap: .55rem;
  font-size: .78rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
  color: var(--eco-br);
}
.hx-eyebrow::before { content: ''; width: 22px; height: 1px; background: currentColor; }
.hx-lede { font-size: 1.0625rem; color: var(--fg-2); }
.hx-grad {
  background: linear-gradient(100deg, var(--eco-br) 0%, var(--teal) 55%, #a7f3d0 100%);
  -webkit-background-clip: text; background-clip: text; color: transparent;
}

/* Word masks (animated only under .is-motion) */
.hx .w { display: inline-block; overflow: hidden; vertical-align: top; padding-bottom: .08em; margin-bottom: -.08em; }
.hx .w > span { display: inline-block; will-change: transform; }

/* Grain + cursor spotlight */
.hx-grain {
  pointer-events: none; position: fixed; inset: 0; z-index: 1; opacity: .05; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
}
.hx-spot {
  pointer-events: none; position: fixed; left: 0; top: 0; z-index: 0;
  width: 560px; height: 560px; margin: -280px 0 0 -280px; border-radius: 50%;
  background: radial-gradient(circle, rgba(34,197,94,.10), transparent 62%);
  opacity: 0; transition: opacity .6s ease;
}
.hx.is-motion .hx-spot { opacity: 1; }
@media (hover: none) { .hx-spot { display: none; } }
.hx > section { position: relative; z-index: 2; }

/* ── Hero ──────────────────────────────────────────────────────────────── */
.hx-hero { position: relative; min-height: 100svh; display: flex; align-items: center; overflow: hidden; }
.hx-hero-bg {
  position: absolute; inset: 0; z-index: 0;
  background:
    radial-gradient(60% 60% at 75% 45%, rgba(34,197,94,.18), transparent 70%),
    radial-gradient(40% 40% at 15% 85%, rgba(45,212,191,.10), transparent 70%),
    var(--bg);
}
.hx-hero-bg canvas { position: absolute; inset: 0; width: 100%; height: 100%; display: block; }
.hx-hero-bg::after {
  content: ''; position: absolute; inset: 0; pointer-events: none;
  background: linear-gradient(180deg, transparent 60%, var(--bg) 100%);
}
/* Grid floor fades in only when WebGL is unavailable (no .is-3d) */
.hx-hero-bg:not(.is-3d)::before {
  content: ''; position: absolute; inset: 0;
  background-image: linear-gradient(var(--line) 1px, transparent 1px), linear-gradient(90deg, var(--line) 1px, transparent 1px);
  background-size: 56px 56px;
  mask-image: radial-gradient(70% 60% at 70% 50%, #000 20%, transparent 75%);
}
.hx-hero-copy { position: relative; z-index: 2; padding: 128px 0 96px; max-width: 760px; }
.hx-hero h1 { font-size: clamp(2.7rem, 7.2vw, 6.2rem); margin: 1.2rem 0 1.5rem; }
.hx-hero .hx-lede { font-size: clamp(1.05rem, 1.4vw, 1.2rem); max-width: 48ch; }
.hx-meta { display: flex; flex-wrap: wrap; gap: .5rem 1.5rem; margin-top: 2.5rem; font-size: .82rem; color: var(--fg-3); }
.hx-meta span { display: inline-flex; align-items: center; gap: .45rem; }
.hx-meta i { color: var(--eco-br); font-size: .75rem; }
.hx-scroll {
  position: absolute; left: 50%; bottom: 28px; z-index: 2; transform: translateX(-50%);
  display: flex; flex-direction: column; align-items: center; gap: .5rem;
  font-size: .7rem; letter-spacing: .2em; text-transform: uppercase; color: var(--fg-3);
}
.hx-scroll i { width: 1px; height: 44px; background: linear-gradient(var(--eco), transparent); position: relative; overflow: hidden; }
.hx-scroll i::after { content: ''; position: absolute; left: 0; top: -40%; width: 1px; height: 40%; background: #fff; animation: hxDrip 2s cubic-bezier(.6,0,.3,1) infinite; }
@keyframes hxDrip { to { top: 110%; } }

/* ── Buttons ───────────────────────────────────────────────────────────── */
.hx-cta, .hx-ghost {
  position: relative; display: inline-flex; align-items: center; gap: .6rem;
  border-radius: 999px; padding: .95rem 1.6rem; font-weight: 600; font-size: .95rem;
  text-decoration: none; isolation: isolate; overflow: hidden;
  transition: color .3s ease, border-color .3s ease, box-shadow .3s ease;
}
.hx-cta { background: var(--eco); color: #04120A; box-shadow: 0 0 0 0 rgba(34,197,94,.5), 0 10px 40px -10px rgba(34,197,94,.6); }
.hx-cta::before {
  content: ''; position: absolute; inset: 0; z-index: -1; border-radius: inherit;
  background: linear-gradient(100deg, var(--eco-br), var(--teal));
  transform: translateY(101%); transition: transform .45s cubic-bezier(.7,0,.2,1);
}
.hx-cta:hover::before { transform: none; }
.hx-cta:hover { box-shadow: 0 0 0 6px rgba(34,197,94,.12), 0 14px 50px -10px rgba(45,212,191,.7); }
.hx-cta i { transition: transform .3s ease; }
.hx-cta:hover i { transform: translateX(3px); }
.hx-ghost { border: 1px solid rgba(255,255,255,.16); color: var(--fg); background: rgba(255,255,255,.02); backdrop-filter: blur(8px); }
.hx-ghost:hover { border-color: var(--eco); color: var(--eco-br); }
.hx-link { color: var(--eco-br); text-decoration: none; font-weight: 500; font-size: .95rem; display: inline-flex; align-items: center; gap: .45rem; }
.hx-link i { transition: transform .3s ease; }
.hx-link:hover i { transform: translateX(4px); }

/* ── Marquee ───────────────────────────────────────────────────────────── */
.hx-marquee { border-block: 1px solid var(--line); overflow: hidden; padding: 1.1rem 0; background: rgba(10,15,24,.6); }
.hx-marquee-track { display: flex; width: max-content; gap: 3rem; animation: hxMarquee 38s linear infinite; }
.hx-marquee:hover .hx-marquee-track { animation-play-state: paused; }
.hx-marquee-track span { display: inline-flex; align-items: center; gap: 3rem; white-space: nowrap; font-family: 'Fraunces', Georgia, serif; font-size: 1.5rem; color: var(--fg-2); }
.hx-marquee-track span::after { content: '✦'; font-size: .8rem; color: var(--eco); }
@keyframes hxMarquee { to { transform: translateX(-50%); } }

/* ── Stats ─────────────────────────────────────────────────────────────── */
.hx-stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1px; background: var(--line); border: 1px solid var(--line); border-radius: 20px; overflow: hidden; }
@media (min-width: 768px) { .hx-stats { grid-template-columns: repeat(4, 1fr); } }
.hx-stat { background: var(--bg); padding: 2rem 1.5rem; }
.hx-stat b { display: block; font-family: 'Fraunces', Georgia, serif; font-weight: 500; font-size: clamp(2.4rem, 4vw, 3.4rem); line-height: 1; }
.hx-stat b sup { font-size: .45em; color: var(--eco-br); margin-left: .1em; vertical-align: super; }
.hx-stat span { display: block; margin-top: .6rem; font-size: .85rem; color: var(--fg-2); }

/* ── Section scaffolding ───────────────────────────────────────────────── */
.hx-sec { padding: 6rem 0; }
@media (min-width: 1024px) { .hx-sec { padding: 8rem 0; } }
.hx-sec-head { display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 1.5rem; margin-bottom: 3rem; }
.hx-sec-head h2 { font-size: clamp(2.1rem, 4.6vw, 3.8rem); margin-top: .9rem; }

/* ── Cards (tilt + glow) ───────────────────────────────────────────────── */
.hx-card {
  --mx: 50%; --my: 50%;
  position: relative; border-radius: 18px; padding: 1.75rem;
  background: linear-gradient(180deg, rgba(17,24,39,.85), rgba(10,15,24,.85));
  border: 1px solid var(--line);
  transform-style: preserve-3d;
  transition: border-color .3s ease;
}
.hx-card::before {
  content: ''; position: absolute; inset: 0; border-radius: inherit; pointer-events: none;
  background: radial-gradient(420px circle at var(--mx) var(--my), rgba(34,197,94,.16), transparent 45%);
  opacity: 0; transition: opacity .3s ease;
}
.hx-card:hover { border-color: rgba(34,197,94,.4); }
.hx-card:hover::before { opacity: 1; }
.hx-card > * { position: relative; }
.hx-ico {
  width: 48px; height: 48px; border-radius: 14px; margin-bottom: 1.4rem;
  display: flex; align-items: center; justify-content: center; font-size: 1.05rem;
  color: var(--eco-br); background: rgba(34,197,94,.08); border: 1px solid rgba(34,197,94,.22);
  box-shadow: inset 0 0 20px rgba(34,197,94,.08);
  transform: translateZ(30px);
}
.hx-card h3 { font-family: 'Fraunces', Georgia, serif; font-weight: 500; font-size: 1.3rem; margin-bottom: .4rem; transform: translateZ(20px); }
.hx-card p { font-size: .92rem; color: var(--fg-2); }
.hx-card-no { position: absolute; top: 1.5rem; right: 1.6rem; font-size: .75rem; color: var(--fg-3); font-variant-numeric: tabular-nums; }

/* Animated gradient border (engagement cards) */
.hx-ring { position: relative; border-radius: 18px; padding: 1px; background: var(--line); overflow: hidden; }
.hx-ring::before {
  content: ''; position: absolute; inset: -60%;
  background: conic-gradient(from 0deg, transparent 0 70%, var(--eco) 80%, var(--teal) 88%, transparent 96%);
  animation: hxSpin 6s linear infinite; opacity: .0; transition: opacity .4s ease;
}
.hx-ring:hover::before { opacity: 1; }
.hx-ring > .hx-card { border: 0; height: 100%; background: linear-gradient(180deg, #0E1522, #090D15); }
@keyframes hxSpin { to { transform: rotate(1turn); } }

/* ── Lifecycle ─────────────────────────────────────────────────────────── */
.hx-life { min-height: 100svh; display: flex; align-items: center; }
.hx-life-grid { display: grid; grid-template-columns: 1fr; gap: 1rem; position: relative; }
@media (min-width: 640px)  { .hx-life-grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .hx-life-grid { grid-template-columns: repeat(5, 1fr); padding-top: 2.5rem; } }
.hx-life-rail { display: none; }
@media (min-width: 1024px) {
  .hx-life-rail-wrap { position: absolute; left: 0; right: 0; top: 0; height: 2px; background: var(--line); border-radius: 2px; }
  .hx-life-rail { display: block; height: 100%; transform-origin: left; background: linear-gradient(90deg, var(--eco), var(--teal)); box-shadow: 0 0 18px var(--eco); }
}
.hx-step { position: relative; }
.hx-step .hx-step-no { font-family: 'Fraunces', Georgia, serif; font-size: 2.6rem; line-height: 1; color: rgba(255,255,255,.12); transition: color .5s ease; margin-bottom: 1rem; }
.hx-step.is-on .hx-step-no, .hx:not(.is-motion) .hx-step .hx-step-no { color: var(--eco-br); text-shadow: 0 0 30px rgba(34,197,94,.45); }
@media (min-width: 1024px) {
  .hx-step::before {
    content: ''; position: absolute; top: -2.5rem; left: 1.75rem; width: 12px; height: 12px; margin-top: -5px;
    border-radius: 50%; background: var(--bg); border: 2px solid rgba(255,255,255,.2); transition: all .4s ease;
  }
  .hx-step.is-on::before { background: var(--eco); border-color: var(--eco-br); box-shadow: 0 0 0 6px rgba(34,197,94,.15), 0 0 20px var(--eco); }
}

/* ── Work (horizontal on desktop) ──────────────────────────────────────── */
.hx-work { overflow: hidden; }
.hx-work-track { display: grid; grid-template-columns: 1fr; gap: 1.25rem; }
@media (min-width: 640px) { .hx-work-track { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) {
  .hx-work.is-h { min-height: 100svh; display: flex; flex-direction: column; justify-content: center; }
  .hx-work.is-h .hx-work-track { display: flex; gap: 1.5rem; width: max-content; padding-right: 2.5rem; }
  .hx-work.is-h .hx-work-card { width: min(46vw, 620px); flex: none; }
}
.hx-work-card { display: block; text-decoration: none; color: inherit; padding: 0; overflow: hidden; }
.hx-work-card .hx-shot { aspect-ratio: 16/10; border-radius: 18px 18px 0 0; border: 0; border-bottom: 1px solid var(--line); }
.hx-work-card .hx-shot img { width: 116%; max-width: none; margin-left: -8%; transition: opacity .4s ease, transform .8s cubic-bezier(.2,.7,.2,1); }
.hx-work-card:hover .hx-shot img.is-loaded { transform: scale(1.04); }
.hx-work-body { padding: 1.4rem 1.6rem 1.6rem; display: flex; align-items: flex-end; justify-content: space-between; gap: 1rem; }
.hx-work-body h3 { margin: 0 0 .7rem; }
.hx-arrow {
  flex: none; width: 46px; height: 46px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
  border: 1px solid var(--line); color: var(--fg); transition: all .35s ease;
}
.hx-work-card:hover .hx-arrow { background: var(--eco); border-color: var(--eco); color: #04120A; transform: rotate(-45deg); }
.hx-tag { font-size: .7rem; font-weight: 500; color: var(--fg-2); border: 1px solid var(--line); border-radius: 999px; padding: .2rem .6rem; }
.hx-progress { margin-top: 2rem; height: 2px; background: var(--line); border-radius: 2px; overflow: hidden; display: none; }
.hx-progress i { display: block; height: 100%; background: linear-gradient(90deg, var(--eco), var(--teal)); transform-origin: left; transform: scaleX(0); }
@media (min-width: 1024px) { .hx-work.is-h .hx-progress { display: block; } }

/* Images + skeletons */
.hx-shot { position: relative; background: var(--card-2); overflow: hidden; }
.hx-shot img { display: block; height: 100%; object-fit: cover; opacity: 0; }
.hx-shot img.is-loaded { opacity: 1; }
.hx-skel { position: absolute; inset: 0; background: var(--card-2); }
.hx-skel::after {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,.055), transparent);
  transform: translateX(-100%); animation: hxSweep 1.3s linear infinite;
}
@keyframes hxSweep { to { transform: translateX(100%); } }

/* ── Testimonials ──────────────────────────────────────────────────────── */
.hx-quotes { position: relative; display: grid; }
.hx-quote { grid-area: 1 / 1; opacity: 0; visibility: hidden; transform: translateY(14px); transition: opacity .7s ease, transform .7s ease, visibility 0s .7s; }
.hx-quote.is-on { opacity: 1; visibility: visible; transform: none; transition: opacity .7s ease, transform .7s ease, visibility 0s; }
.hx-quote blockquote { font-family: 'Fraunces', Georgia, serif; font-size: clamp(1.5rem, 3vw, 2.4rem); line-height: 1.25; letter-spacing: -.01em; }
.hx-quote blockquote::before { content: '“'; display: block; font-size: 4rem; line-height: .6; color: var(--eco); margin-bottom: .6rem; }
.hx-who { display: flex; align-items: center; gap: .9rem; margin-top: 2rem; }
.hx-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 1px solid var(--line); background: var(--card-2); display: flex; align-items: center; justify-content: center; font-weight: 600; color: var(--eco-br); }
.hx-stars { color: #facc15; font-size: .75rem; letter-spacing: .15em; }
.hx-dots { display: flex; gap: .5rem; margin-top: 2.5rem; }
.hx-dots button { width: 28px; height: 4px; border-radius: 4px; background: rgba(255,255,255,.15); border: 0; cursor: pointer; transition: all .3s ease; }
.hx-dots button[aria-current="true"] { width: 52px; background: var(--eco); }

/* ── Final CTA ─────────────────────────────────────────────────────────── */
.hx-final { text-align: center; overflow: hidden; }
.hx-final::before {
  content: ''; position: absolute; left: 50%; top: 50%; width: 900px; height: 900px; transform: translate(-50%, -50%);
  background: radial-gradient(circle, rgba(34,197,94,.14), transparent 60%); pointer-events: none;
}
.hx-fill {
  font-size: clamp(2.6rem, 8vw, 7rem);
  color: transparent; -webkit-text-fill-color: transparent;
  background-image: linear-gradient(100deg, var(--fg), var(--eco-br));
  background-repeat: no-repeat; background-size: 100% 100%;
  -webkit-background-clip: text; background-clip: text;
}
.hx.is-motion .hx-fill { -webkit-text-fill-color: transparent; color: transparent; background-color: rgba(255,255,255,.14); background-size: 0% 100%; }

/* ── Motion-gated initial states (only when the motion module is live) ─── */
.hx.is-motion [data-reveal] { opacity: 0; }

@media (prefers-reduced-motion: reduce) {
  .hx-marquee-track, .hx-skel::after, .hx-scroll i::after, .hx-ring::before { animation: none; }
  .hx-quote, .hx-quote.is-on { transition: none; }
}
</style>

<div class="hx">
  <div class="hx-grain" aria-hidden="true"></div>
  <div class="hx-spot" data-spot aria-hidden="true"></div>

  <!-- ══ HERO — Three.js network globe ═════════════════════════════════════ -->
  <section class="hx-hero" data-hero>
    <div class="hx-hero-bg" aria-hidden="true">
      <canvas data-hero-canvas></canvas>
    </div>

    <div class="hx-shell w-full">
      <div class="hx-hero-copy" data-hero-copy>
        <span class="hx-eyebrow" data-hero-eyebrow>Software engineering · Lucknow, India</span>
        <h1 class="hx-h" data-split>
          <?= $split('Software that') ?><br>
          <span class="w"><span class="hx-grad">stays</span></span> <?= $split('fast.') ?>
        </h1>
        <p class="hx-lede" data-hero-lede>
          We build web platforms, mobile apps and serverless systems — secured from the first
          commit, and maintained by the engineers who wrote them.
        </p>
        <div class="flex flex-wrap items-center gap-3 mt-9" data-hero-cta>
          <a href="<?= url('contact') ?>" class="hx-cta" data-magnetic>Talk to an engineer <i class="fas fa-arrow-right text-xs"></i></a>
          <a href="<?= url('projects') ?>" class="hx-ghost" data-magnetic>See our work</a>
        </div>
        <div class="hx-meta" data-hero-meta>
          <span><i class="fas fa-shield-halved"></i> OWASP-reviewed builds</span>
          <span><i class="fas fa-code-branch"></i> CI/CD on every project</span>
          <span><i class="fas fa-user-gear"></i> Named maintenance engineer</span>
        </div>
      </div>
    </div>

    <div class="hx-scroll" aria-hidden="true">Scroll <i></i></div>
  </section>

  <!-- ══ MARQUEE — stack we've shipped ═════════════════════════════════════ -->
  <section class="hx-marquee" aria-label="Technologies we use">
    <div class="hx-marquee-track">
      <?php for ($loop = 0; $loop < 2; $loop++): ?>
        <?php foreach ($stack as $t): ?>
          <span <?= $loop ? 'aria-hidden="true"' : '' ?>><?= Security::e($t) ?></span>
        <?php endforeach; ?>
      <?php endfor; ?>
    </div>
  </section>

  <!-- ══ STATS ═════════════════════════════════════════════════════════════ -->
  <section class="hx-shell pt-20 lg:pt-28">
    <div class="hx-stats" data-reveal>
      <div class="hx-stat"><b><span data-count="<?= count($work) ?>"><?= count($work) ?></span><sup>+</sup></b><span>Live projects in production</span></div>
      <div class="hx-stat"><b><span data-count="<?= count($services ?? []) ?>"><?= count($services ?? []) ?></span></b><span>Service lines</span></div>
      <div class="hx-stat"><b><span data-count="5">5</span></b><span>Stage delivery process</span></div>
      <div class="hx-stat"><b><span data-count="11">11</span></b><span>Internship tracks open</span></div>
    </div>
  </section>

  <!-- ══ CAPABILITIES ══════════════════════════════════════════════════════ -->
  <section class="hx-sec">
    <div class="hx-shell">
      <div class="hx-sec-head">
        <div>
          <span class="hx-eyebrow">Capabilities</span>
          <h2 class="hx-h" data-heading><?= $split('What we build') ?></h2>
        </div>
        <a href="<?= url('services') ?>" class="hx-link">All services <i class="fas fa-arrow-right text-[11px]"></i></a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($capabilities as $i => $c): ?>
        <div class="hx-card" data-tilt data-reveal>
          <span class="hx-card-no"><?= sprintf('%02d', $i + 1) ?></span>
          <div class="hx-ico"><i class="fas <?= Security::e($c['icon']) ?>"></i></div>
          <h3><?= Security::e($c['name']) ?></h3>
          <p><?= Security::e($c['line']) ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ══ LIFECYCLE — pinned, rail draws as you scroll ══════════════════════ -->
  <section class="hx-life" data-life>
    <div class="hx-shell w-full py-20">
      <div class="hx-sec-head">
        <div>
          <span class="hx-eyebrow">Process</span>
          <h2 class="hx-h" data-heading><?= $split('How a project runs') ?></h2>
        </div>
        <p class="hx-lede max-w-[34ch]">Five stages. We do all of them — the same way on every build.</p>
      </div>

      <div class="hx-life-grid">
        <div class="hx-life-rail-wrap" aria-hidden="true"><div class="hx-life-rail" data-life-rail></div></div>
        <?php foreach ($lifecycle as $s): ?>
        <div class="hx-card hx-step" data-life-step>
          <div class="hx-step-no"><?= Security::e($s['no']) ?></div>
          <h3><i class="fas <?= Security::e($s['icon']) ?> text-sm mr-2" style="color:var(--eco-br)"></i><?= Security::e($s['name']) ?></h3>
          <p><?= Security::e($s['line']) ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ══ WORK — horizontal scroll on desktop ═══════════════════════════════ -->
  <section class="hx-work <?= count($cards) > 2 ? 'is-h' : '' ?>" data-work>
    <div class="hx-shell w-full py-20">
      <div class="hx-sec-head">
        <div>
          <span class="hx-eyebrow">Selected work</span>
          <h2 class="hx-h" data-heading><?= $split('Live in production') ?></h2>
        </div>
        <a href="<?= url('projects') ?>" class="hx-link">All projects <i class="fas fa-arrow-right text-[11px]"></i></a>
      </div>

      <?php if (empty($cards)): ?>
        <div class="hx-work-track">
          <?php for ($i = 0; $i < 3; $i++): ?>
          <div class="hx-card hx-work-card"><div class="hx-shot"><div class="hx-skel" aria-hidden="true"></div></div><div class="hx-work-body"><span class="hx-tag">Coming soon</span></div></div>
          <?php endfor; ?>
        </div>
      <?php else: ?>
        <div class="hx-work-track" data-work-track>
          <?php foreach ($cards as $p): ?>
          <a class="hx-card hx-work-card" data-work-card href="<?= url('projects/view?slug=' . urlencode($p['slug'] ?? '')) ?>">
            <div class="hx-shot">
              <div class="hx-skel" data-skel aria-hidden="true"></div>
              <img data-shot data-work-img src="<?= url('uploads/' . rawurlencode($p['thumbnail'] ?? '')) ?>"
                   alt="<?= Security::e($p['title'] ?? 'Project') ?> — delivered interface"
                   width="720" height="450" loading="lazy" decoding="async">
            </div>
            <div class="hx-work-body">
              <div>
                <h3><?= Security::e($p['title'] ?? '') ?></h3>
                <div class="flex flex-wrap gap-1.5">
                  <?php foreach ($stackList($p['tech_stack'] ?? null) as $t): ?>
                    <span class="hx-tag"><?= Security::e($t) ?></span>
                  <?php endforeach; ?>
                </div>
              </div>
              <span class="hx-arrow" aria-hidden="true"><i class="fas fa-arrow-right text-xs"></i></span>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
        <div class="hx-progress" aria-hidden="true"><i data-work-progress></i></div>
      <?php endif; ?>
    </div>
  </section>

  <!-- ══ ENGAGEMENT ════════════════════════════════════════════════════════ -->
  <section class="hx-sec">
    <div class="hx-shell">
      <div class="hx-sec-head">
        <div>
          <span class="hx-eyebrow">Engagement</span>
          <h2 class="hx-h" data-heading><?= $split('Ways to work with us') ?></h2>
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <?php foreach ($engagements as $e): ?>
        <div class="hx-ring" data-reveal>
          <div class="hx-card" data-tilt>
            <div class="hx-ico"><i class="fas <?= Security::e($e['icon']) ?>"></i></div>
            <h3><?= Security::e($e['name']) ?></h3>
            <p><?= Security::e($e['line']) ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ══ TESTIMONIALS ══════════════════════════════════════════════════════ -->
  <?php if (!empty($quotes)): ?>
  <section class="hx-sec" style="padding-top:0">
    <div class="hx-shell">
      <div class="hx-card" style="padding:clamp(2rem,5vw,4.5rem)" data-reveal>
        <span class="hx-eyebrow mb-8">Client words</span>
        <div class="hx-quotes mt-6" data-quotes aria-roledescription="carousel" aria-label="Testimonials">
          <?php foreach ($quotes as $qi => $q): ?>
          <figure class="hx-quote <?= $qi === 0 ? 'is-on' : '' ?>" data-quote aria-hidden="<?= $qi === 0 ? 'false' : 'true' ?>">
            <blockquote><?= Security::e($q['message'] ?? '') ?></blockquote>
            <figcaption class="hx-who">
              <?php if (!empty($q['avatar'])): ?>
                <img class="hx-avatar" src="<?= url('uploads/' . rawurlencode($q['avatar'])) ?>" alt="" width="48" height="48" loading="lazy">
              <?php else: ?>
                <span class="hx-avatar" aria-hidden="true"><?= Security::e(mb_strtoupper(mb_substr($q['name'] ?? '?', 0, 1))) ?></span>
              <?php endif; ?>
              <div>
                <div class="font-semibold"><?= Security::e($q['name'] ?? '') ?></div>
                <div class="text-sm" style="color:var(--fg-2)">
                  <?= Security::e(trim(($q['position'] ?? '') . (!empty($q['company']) ? ', ' . $q['company'] : ''), ', ')) ?>
                </div>
                <?php $stars = max(0, min(5, (int)($q['rating'] ?? 5))); ?>
                <div class="hx-stars" aria-label="<?= $stars ?> out of 5"><?= str_repeat('★', $stars) ?></div>
              </div>
            </figcaption>
          </figure>
          <?php endforeach; ?>

          <?php if (count($quotes) > 1): ?>
          <div class="hx-dots">
            <?php foreach ($quotes as $qi => $q): ?>
              <button type="button" data-quote-dot aria-label="Show testimonial <?= $qi + 1 ?>" aria-current="<?= $qi === 0 ? 'true' : 'false' ?>"></button>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ══ INTERNSHIPS ═══════════════════════════════════════════════════════ -->
  <section class="hx-sec" style="padding-top:0">
    <div class="hx-shell">
      <div class="hx-ring" data-reveal>
        <div class="hx-card" style="padding:clamp(2rem,4vw,3.5rem)">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-center">
            <div class="lg:col-span-2">
              <span class="hx-eyebrow"><i class="fas fa-graduation-cap"></i> Internship Programme <?= date('Y') ?></span>
              <h2 class="hx-h text-[2rem] lg:text-[2.8rem] mt-4 mb-4">Eleven internship tracks, open for applications</h2>
              <p class="hx-lede max-w-2xl mb-7">
                Full stack, frontend, backend, Python, Java, mobile app, UI/UX, cybersecurity, IoT,
                AI &amp; machine learning and data science. Apply online, track your application, and
                receive a formal offer letter on selection.
              </p>
              <div class="flex flex-wrap gap-3">
                <a href="<?= url('internships') ?>" class="hx-cta" data-magnetic>Browse internships <i class="fas fa-arrow-right text-xs"></i></a>
                <?php if (isIntern()): ?>
                  <a href="<?= url('internships/dashboard') ?>" class="hx-ghost">My dashboard</a>
                <?php else: ?>
                  <a href="<?= url('internships/register') ?>" class="hx-ghost">Create an account</a>
                <?php endif; ?>
              </div>
            </div>
            <ul class="space-y-3 text-sm">
              <?php foreach ([
                ['fa-laptop-code',   'Remote and hybrid options'],
                ['fa-user-tie',      'Direct mentor code review'],
                ['fa-file-contract', 'Formal offer letter'],
                ['fa-certificate',   'Completion certificate'],
              ] as $point): ?>
                <li class="flex items-center gap-3" style="color:var(--fg-2)">
                  <span class="hx-ico" style="width:36px;height:36px;margin:0;border-radius:10px;font-size:.8rem"><i class="fas <?= $point[0] ?>"></i></span>
                  <?= Security::e($point[1]) ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ FINAL CTA — headline fills as you scroll ══════════════════════════ -->
  <section class="hx-sec hx-final">
    <div class="hx-shell relative">
      <span class="hx-eyebrow">Start here</span>
      <h2 class="hx-h hx-fill mt-6 mb-8" data-fill>Send us what you already have.</h2>
      <p class="hx-lede max-w-[54ch] mx-auto mb-10">
        A repo link, a staging URL, or the page that's slow. An engineer replies —
        <?= Security::e(setting('business_hours') ?: 'Mon – Sat, 09:00 – 18:00 IST') ?>.
      </p>
      <div class="flex flex-wrap gap-3 justify-center">
        <a href="<?= url('contact') ?>" class="hx-cta" data-magnetic>Talk to an engineer <i class="fas fa-arrow-right text-xs"></i></a>
        <a href="mailto:<?= Security::e(setting('site_email') ?: 'ecotech.internships@gmail.com') ?>" class="hx-ghost" data-magnetic>Email us</a>
      </div>
    </div>
  </section>

</div>

<script>
/* Skeletons clear on real image decode (independent of the motion modules). */
(function () {
  'use strict';
  document.querySelectorAll('.hx [data-shot]').forEach(function (img) {
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
})();
</script>
<script type="module" src="<?= $asset('assets/js/home-motion.js') ?>"></script>
<script type="module" src="<?= $asset('assets/js/home-scene.js') ?>"></script>
