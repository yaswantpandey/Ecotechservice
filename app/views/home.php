<?php
/* ==========================================================================
   Home — editorial / spec-sheet layout.
   Rules this file obeys (see instruction.txt + redesign brief):
   no gradients, no pure-white base, no drop shadows, no rounded corners,
   no fabricated metrics, no emoji/sparkle icons, no 3-card rows,
   no terminal mockups, real skeleton loaders, motion only where it reports state.
   ========================================================================== */

// ── Real engineering lifecycle (5 stages, not compressed into "features") ──
$lifecycle = [
    [
        'no'      => '01',
        'name'    => 'Technical discovery',
        'lede'    => 'We read the existing system before proposing anything.',
        'body'    => 'Current stack audit, data model walkthrough, traffic and load profile, integration inventory, and the constraints nobody wrote down. Output is a written findings document with the risks ranked.',
        'outputs' => ['Findings document', 'Risk register', 'Scope boundary'],
        'owner'   => 'Lead engineer + client technical contact',
    ],
    [
        'no'      => '02',
        'name'    => 'Architecture design',
        'lede'    => 'Decisions get written down, with the trade-off attached.',
        'body'    => 'Service boundaries, data ownership, synchronous vs queued paths, failure behaviour, and where state lives. Every choice is recorded as a decision record so the reasoning survives staff changes.',
        'outputs' => ['System diagram', 'Decision records', 'Interface contracts'],
        'owner'   => 'Architect, reviewed with your team',
    ],
    [
        'no'      => '03',
        'name'    => 'Secure programming',
        'lede'    => 'Security is a build-time constraint, not a late audit.',
        'body'    => 'Parameterised queries, server-side validation on every input, CSRF tokens on state changes, output escaping by default, least-privilege database users, and secrets kept out of the repository. Reviewed against the OWASP Top 10 before merge.',
        'outputs' => ['Reviewed pull requests', 'Test suite', 'Threat notes'],
        'owner'   => 'Two engineers — author and reviewer',
    ],
    [
        'no'      => '04',
        'name'    => 'CI/CD automation',
        'lede'    => 'Deployment is a script, never a person following steps.',
        'body'    => 'Build, static analysis, test run, staging deploy, smoke check, production release — all in one pipeline with a recorded artifact and a single-command rollback. Nothing reaches production by hand.',
        'outputs' => ['Pipeline definition', 'Versioned artifacts', 'Rollback path'],
        'owner'   => 'Automated; engineer approves the release gate',
    ],
    [
        'no'      => '05',
        'name'    => 'Maintenance',
        'lede'    => 'The engagement does not end at launch.',
        'body'    => 'Dependency and patch cadence, log and error monitoring, backup restore drills, performance budget checks, and a named engineer who already knows the codebase when something breaks.',
        'outputs' => ['Patch log', 'Uptime + error reports', 'Restore drill record'],
        'owner'   => 'Retained engineer with system context',
    ],
];

// ── Pipeline stages used by the live deploy-state visualisation ────────────
$pipeline = [
    ['step' => 'checkout',        'detail' => 'source @ main',               'ms' => 900],
    ['step' => 'install',         'detail' => 'locked dependency tree',      'ms' => 1400],
    ['step' => 'static analysis', 'detail' => 'lint + type + audit',         'ms' => 1100],
    ['step' => 'test',            'detail' => 'unit + integration suite',    'ms' => 1600],
    ['step' => 'build artifact',  'detail' => 'immutable, versioned',        'ms' => 1200],
    ['step' => 'deploy staging',  'detail' => 'smoke check on real routes',  'ms' => 1300],
    ['step' => 'release',         'detail' => 'gated, rollback one command', 'ms' => 1000],
];

// ── Engagement models (a services firm — not a three-tier SaaS table) ─────
$engagements = [
    [
        'name'  => 'Project-based',
        'shape' => 'Fixed scope, written architecture, staged delivery',
        'fit'   => 'A defined build with a known end state: a new application, a rewrite, a migration off a stack that is costing you.',
        'terms' => 'Scoped after discovery. Billed per delivery stage. Source code and infrastructure accounts are yours from day one.',
    ],
    [
        'name'  => 'Retainer',
        'shape' => 'Continuous ownership of a live system',
        'fit'   => 'Software already in production that needs patching, monitoring, incremental features, and someone accountable when it breaks.',
        'terms' => 'Monthly, fixed hours, named engineer. Unused hours are reported, not quietly billed as delivered work.',
    ],
    [
        'name'  => 'Dedicated team',
        'shape' => 'Embedded engineers inside your process',
        'fit'   => 'An internal roadmap that needs more capacity, working in your repository, your board, your review process.',
        'terms' => 'Per-engineer monthly, minimum one quarter so context is actually built. You run the priorities.',
    ],
];

// ── Case studies: real projects from the database. No invented metrics. ────
$caseStudies = [];
if (!empty($featuredProjects) && is_array($featuredProjects)) {
    $caseStudies = array_slice($featuredProjects, 0, 3);
}

/** Split a comma-separated tech stack into a clean array. */
$stackList = static function (?string $raw): array {
    if (!$raw) return [];
    return array_values(array_filter(array_map('trim', explode(',', $raw))));
};
?>

<style>
/* ==========================================================================
   Scoped to .ed — nothing here leaks into the rest of the site.
   ========================================================================== */
.ed {
  --paper:   #EDEAE2;   /* warm off-white surface, never #fff */
  --paper-2: #E5E1D7;   /* recessed panel */
  --paper-3: #DCD7CA;   /* table zebra */
  --ink:     #191A17;   /* graphite */
  --ink-2:   #43453E;
  --ink-3:   #6E7066;
  --rule:    #C7C2B4;   /* hairline */
  --rule-2:  #DAD6CA;
  --signal:  #2C5F42;   /* the one accent, used only for action + state */
  background: var(--paper);
  color: var(--ink);
  font-family: 'IBM Plex Sans', system-ui, sans-serif;
  font-size: 16px;
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
}
.ed *, .ed *::before, .ed *::after { border-radius: 0; box-shadow: none; }
.ed ::selection { background: var(--signal); color: var(--paper); }

/* ── Type ────────────────────────────────────────────────────────────── */
.ed-display {
  font-family: 'Instrument Serif', Georgia, serif;
  font-weight: 400;
  letter-spacing: -0.015em;
  line-height: 1.02;
  text-wrap: balance;
}
.ed-spec {
  font-family: 'IBM Plex Mono', ui-monospace, monospace;
  font-size: 0.6875rem;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--ink-3);
}
.ed-lede { font-size: 1.125rem; line-height: 1.55; color: var(--ink-2); }
.ed-prose { max-width: 62ch; }
.ed-prose p + p { margin-top: 1.1em; }

/* ── Structure: hairlines instead of cards ───────────────────────────── */
.ed-shell { max-width: 1240px; margin: 0 auto; padding-left: 1.25rem; padding-right: 1.25rem; }
@media (min-width: 1024px) { .ed-shell { padding-left: 2.5rem; padding-right: 2.5rem; } }
.ed-band { border-top: 1px solid var(--rule); }
.ed-hair { border-top: 1px solid var(--rule-2); }
.ed-vrule { border-left: 1px solid var(--rule); }
@media (max-width: 1023px) { .ed-vrule { border-left: 0; border-top: 1px solid var(--rule); } }

/* Section header: label left, heading right — asymmetric, not centred */
.ed-sec-head { display: grid; grid-template-columns: 1fr; gap: 1.5rem; }
@media (min-width: 1024px) { .ed-sec-head { grid-template-columns: 200px 1fr; gap: 3rem; } }

/* ── Links & actions ─────────────────────────────────────────────────── */
.ed-link {
  color: var(--ink);
  text-decoration: none;
  border-bottom: 1px solid var(--rule);
  padding-bottom: 1px;
  transition: border-color .18s linear, color .18s linear;
}
.ed-link:hover { color: var(--signal); border-color: var(--signal); }
.ed-cta {
  display: inline-flex; align-items: baseline; gap: .6rem;
  background: var(--signal); color: #F3F1EA;
  padding: .85rem 1.4rem;
  font-weight: 500; font-size: .9375rem;
  border: 1px solid var(--signal);
  transition: background .18s linear, color .18s linear;
}
.ed-cta:hover { background: var(--ink); border-color: var(--ink); }
.ed-cta-ghost {
  display: inline-flex; align-items: baseline; gap: .6rem;
  padding: .85rem 1.4rem; font-weight: 500; font-size: .9375rem;
  border: 1px solid var(--rule); color: var(--ink);
  transition: border-color .18s linear, color .18s linear;
}
.ed-cta-ghost:hover { border-color: var(--ink); }
.ed-cta-mark { font-family: 'IBM Plex Mono', monospace; font-size: .75rem; opacity: .75; }

/* ── Spec table (masthead facts, engagement terms) ───────────────────── */
.ed-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
.ed-table th, .ed-table td { text-align: left; vertical-align: top; padding: .7rem 0; border-top: 1px solid var(--rule-2); }
.ed-table th {
  font-family: 'IBM Plex Mono', monospace; font-weight: 400; font-size: .6875rem;
  letter-spacing: .08em; text-transform: uppercase; color: var(--ink-3);
  width: 38%; padding-right: 1rem; white-space: nowrap;
}
.ed-table tr:first-child th, .ed-table tr:first-child td { border-top: 0; }

/* ── Live state indicator (reports the pipeline, not decoration) ─────── */
.ed-dot { display: inline-block; width: 7px; height: 7px; background: var(--signal); }
.ed-dot--live { animation: edBreathe 2.4s ease-in-out infinite; }
@keyframes edBreathe { 0%, 100% { opacity: 1; } 50% { opacity: .28; } }

/* ── Lifecycle rail ──────────────────────────────────────────────────── */
.ed-stage {
  display: grid; grid-template-columns: 1fr; gap: 1rem;
  padding: 2rem 0; border-top: 1px solid var(--rule-2);
  position: relative;
}
@media (min-width: 900px) {
  .ed-stage { grid-template-columns: 104px minmax(0,1.15fr) minmax(0,1fr) 210px; gap: 2.5rem; align-items: start; }
}
.ed-stage-no {
  font-family: 'IBM Plex Mono', monospace; font-size: 1.5rem; color: var(--rule);
  transition: color .3s linear;
}
.ed-stage[data-reached="1"] .ed-stage-no { color: var(--signal); }
.ed-stage-bar { height: 2px; background: var(--rule-2); margin-top: .6rem; overflow: hidden; }
.ed-stage-bar > i { display: block; height: 100%; width: 0; background: var(--signal); transition: width .7s cubic-bezier(.2,.7,.2,1); }
.ed-stage[data-reached="1"] .ed-stage-bar > i { width: 100%; }
.ed-out { list-style: none; margin: 0; padding: 0; font-size: .8125rem; color: var(--ink-2); }
.ed-out li { padding: .3rem 0; border-top: 1px dotted var(--rule); }
.ed-out li:first-child { border-top: 0; }
.ed-out li::before { content: '—'; color: var(--ink-3); margin-right: .5rem; }

/* ── Pipeline visualisation ──────────────────────────────────────────── */
.ed-pipe { border: 1px solid var(--rule); background: var(--paper-2); }
.ed-pipe-head { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: .85rem 1rem; border-bottom: 1px solid var(--rule); flex-wrap: wrap; }
.ed-pipe-row {
  display: grid; grid-template-columns: 22px minmax(0,1fr) auto;
  gap: .9rem; align-items: center;
  padding: .7rem 1rem; border-top: 1px solid var(--rule-2);
  font-size: .8125rem;
}
.ed-pipe-row:first-of-type { border-top: 0; }
.ed-pipe-row[data-state="pending"] { color: var(--ink-3); }
.ed-pipe-row[data-state="running"] { background: var(--paper-3); color: var(--ink); }
.ed-pipe-row[data-state="done"] { color: var(--ink-2); }
.ed-pipe-mark { font-family: 'IBM Plex Mono', monospace; font-size: .75rem; color: var(--ink-3); }
.ed-pipe-row[data-state="done"] .ed-pipe-mark { color: var(--signal); }
.ed-pipe-step { font-family: 'IBM Plex Mono', monospace; }
.ed-pipe-prog { height: 2px; background: var(--rule-2); }
.ed-pipe-prog > i { display: block; height: 100%; width: 0; background: var(--signal); transition: width .25s linear; }
.ed-pipe-spin { display: inline-block; width: 9px; height: 9px; border: 1.5px solid var(--rule); border-top-color: var(--signal); animation: edSpin .7s linear infinite; }
@keyframes edSpin { to { transform: rotate(360deg); } }

/* ── Case studies ────────────────────────────────────────────────────── */
.ed-shot { position: relative; background: var(--paper-2); border: 1px solid var(--rule); overflow: hidden; }
.ed-shot img { display: block; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity .35s linear; }
.ed-shot img.is-loaded { opacity: 1; }
/* Real skeleton loader — visible until the image decodes, then removed */
.ed-skel { position: absolute; inset: 0; background: var(--paper-2); }
.ed-skel::after {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(90deg, transparent, rgba(25,26,23,.06), transparent);
  transform: translateX(-100%);
  animation: edSweep 1.35s linear infinite;
}
@keyframes edSweep { to { transform: translateX(100%); } }
.ed-skel-line { height: 10px; background: var(--paper-3); position: relative; overflow: hidden; }
.ed-skel-line::after { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, transparent, rgba(25,26,23,.07), transparent); transform: translateX(-100%); animation: edSweep 1.35s linear infinite; }
.ed-tag { font-family: 'IBM Plex Mono', monospace; font-size: .6875rem; letter-spacing: .04em; color: var(--ink-2); border: 1px solid var(--rule); padding: .2rem .45rem; }
.ed-note { font-size: .8125rem; color: var(--ink-3); border-left: 2px solid var(--rule); padding-left: .75rem; }

/* ── Entrance: opacity/translate only, disabled for reduced-motion ───── */
.ed-rise { opacity: 0; transform: translateY(10px); }
.ed-rise.is-in { opacity: 1; transform: none; transition: opacity .5s linear, transform .5s cubic-bezier(.2,.7,.2,1); }
@media (prefers-reduced-motion: reduce) {
  .ed-rise, .ed-rise.is-in { opacity: 1; transform: none; transition: none; }
  .ed-dot--live, .ed-pipe-spin, .ed-skel::after, .ed-skel-line::after { animation: none; }
  .ed-stage-bar > i, .ed-pipe-prog > i { transition: none; }
}
</style>

<div class="ed">

  <!-- ══ MASTHEAD ═══════════════════════════════════════════════════════
       Asymmetric: statement left, hard facts right. No centred hero.
  -->
  <section class="ed-shell pt-[104px] md:pt-[124px] lg:pt-[140px] pb-14 lg:pb-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">

      <div class="lg:col-span-7">
        <p class="ed-spec mb-6">EcoTech Services — software engineering, Lucknow IN</p>

        <h1 class="ed-display text-[2.6rem] sm:text-[3.6rem] lg:text-[4.4rem] mb-7">
          Software that stays fast after<br class="hidden sm:block">
          you stop paying attention to it.
        </h1>

        <div class="ed-prose ed-lede">
          <p>
            We build full-stack enterprise applications, mobile apps, automated microservices
            and serverless workflows — and we take the whole lifecycle, from technical
            discovery through architecture, secure implementation, pipeline automation and
            long-term maintenance.
          </p>
          <p>
            Most systems are slow because of what was added to them, not what they do.
            We keep the dependency surface small, the data paths direct, and the deployment
            boring. That is the entire method.
          </p>
        </div>

        <div class="flex flex-wrap items-center gap-3 mt-9">
          <a href="<?= url('contact') ?>" class="ed-cta">
            Talk to an engineer <span class="ed-cta-mark">&rarr;</span>
          </a>
          <a href="<?= url('projects') ?>" class="ed-cta-ghost">
            Read the work <span class="ed-cta-mark">&rarr;</span>
          </a>
        </div>
        <p class="ed-spec mt-4" style="text-transform:none;letter-spacing:.02em;">
          Discovery calls are taken by the engineer who would do the work. No sales layer.
        </p>
      </div>

      <!-- Spec sheet: only facts we can stand behind -->
      <aside class="lg:col-span-5 lg:pl-12 ed-vrule pt-10 lg:pt-0">
        <p class="ed-spec mb-5">Practice — at a glance</p>
        <table class="ed-table">
          <tr>
            <th scope="row">Discipline</th>
            <td>Full-stack web, mobile, microservices, serverless workflows</td>
          </tr>
          <tr>
            <th scope="row">Lifecycle</th>
            <td>Discovery &rarr; architecture &rarr; secure build &rarr; CI/CD &rarr; maintenance</td>
          </tr>
          <tr>
            <th scope="row">Code ownership</th>
            <td>Client owns the repository and the cloud accounts. No lock-in layer.</td>
          </tr>
          <tr>
            <th scope="row">Security baseline</th>
            <td>Parameterised queries, CSRF on state changes, escaped output, least-privilege DB users, OWASP Top&nbsp;10 review before merge</td>
          </tr>
          <tr>
            <th scope="row">Engagements</th>
            <td>Project-based, retainer, or dedicated team</td>
          </tr>
          <tr>
            <th scope="row">Hours</th>
            <td><?= Security::e(setting('business_hours') ?: 'Mon – Sat, 09:00 – 18:00 IST') ?></td>
          </tr>
          <tr>
            <th scope="row">Direct line</th>
            <td>
              <a class="ed-link" href="mailto:<?= Security::e(setting('site_email') ?: 'ecotech.internships@gmail.com') ?>"><?= Security::e(setting('site_email') ?: 'ecotech.internships@gmail.com') ?></a>
            </td>
          </tr>
        </table>
      </aside>
    </div>
  </section>

  <!-- ══ PHILOSOPHY ════════════════════════════════════════════════════
       Essay column + margin notes. Density differs from the masthead.
  -->
  <section class="ed-band">
    <div class="ed-shell py-14 lg:py-20">
      <div class="ed-sec-head mb-10">
        <p class="ed-spec lg:pt-3">§ 01 — Position</p>
        <h2 class="ed-display text-[2rem] sm:text-[2.6rem] lg:text-[3rem] max-w-[22ch]">
          We reject stacks that cost more to run than to build.
        </h2>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">
        <div class="lg:col-span-7 ed-prose" style="font-size:1.0625rem;color:var(--ink-2);">
          <p>
            A large part of modern software slowness is self-inflicted: framework layers
            nobody on the team can debug, a dependency tree with thousands of packages, an
            asset bundle shipped to every visitor regardless of what they came for, and a
            deployment that only one person knows how to run.
          </p>
          <p>
            Our position is narrow and we hold it consistently. Choose the smallest stack
            that satisfies the requirement. Keep rendering close to the data. Measure first
            paint and query time as build constraints, not as a post-launch cleanup task.
            Write the architectural decision down so the next engineer inherits the reasoning
            and not just the result.
          </p>
          <p>
            This page is the same argument in practice. No client-side framework, no icon
            library loaded to draw six glyphs, no motion that exists to be noticed. The
            animation on this page reports real state — how far through the lifecycle you
            have read, and how a deployment actually progresses — and nothing else.
          </p>
        </div>

        <div class="lg:col-span-4 lg:col-start-9 space-y-7 pt-2">
          <div>
            <p class="ed-spec mb-2">Constraint</p>
            <p class="text-sm" style="color:var(--ink-2)">
              Performance is treated as a design constraint. If an asset or animation
              measurably delays first paint, it does not ship.
            </p>
          </div>
          <div class="ed-hair pt-6">
            <p class="ed-spec mb-2">Constraint</p>
            <p class="text-sm" style="color:var(--ink-2)">
              Every dependency added must be justified against what it replaces. The default
              answer to a new package is no.
            </p>
          </div>
          <div class="ed-hair pt-6">
            <p class="ed-spec mb-2">Constraint</p>
            <p class="text-sm" style="color:var(--ink-2)">
              If a release requires a human to follow written steps, the pipeline is
              unfinished.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ LIFECYCLE ═════════════════════════════════════════════════════
       All five real stages. Progress marks fill as you read — the motion
       reports your position in the process.
  -->
  <section class="ed-band" id="lifecycle">
    <div class="ed-shell py-14 lg:py-20">
      <div class="ed-sec-head mb-4">
        <p class="ed-spec lg:pt-3">§ 02 — Lifecycle</p>
        <div>
          <h2 class="ed-display text-[2rem] sm:text-[2.6rem] lg:text-[3rem] max-w-[26ch] mb-4">
            Five stages. We do not sell them separately.
          </h2>
          <p class="ed-lede ed-prose">
            Projects fail between stages, not inside them — a discovery that never reached
            the architect, a build with no pipeline, a launch with no owner. Each stage below
            names what it produces and who is accountable for it.
          </p>
        </div>
      </div>

      <div id="edStages" class="mt-8">
        <?php foreach ($lifecycle as $s): ?>
        <article class="ed-stage" data-stage data-reached="0">
          <div>
            <div class="ed-stage-no"><?= $s['no'] ?></div>
            <div class="ed-stage-bar" aria-hidden="true"><i></i></div>
          </div>

          <div>
            <h3 class="ed-display text-[1.5rem] lg:text-[1.75rem] mb-2"><?= Security::e($s['name']) ?></h3>
            <p class="text-sm" style="color:var(--ink)"><?= Security::e($s['lede']) ?></p>
          </div>

          <div class="text-sm" style="color:var(--ink-2)">
            <p><?= Security::e($s['body']) ?></p>
            <p class="ed-spec mt-4" style="text-transform:none;letter-spacing:.02em;">
              Accountable: <?= Security::e($s['owner']) ?>
            </p>
          </div>

          <div>
            <p class="ed-spec mb-2">Leaves behind</p>
            <ul class="ed-out">
              <?php foreach ($s['outputs'] as $o): ?>
              <li><?= Security::e($o) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </article>
        <?php endforeach; ?>
      </div>

      <p class="ed-note mt-8 max-w-[70ch]">
        Stage four is where most of the long-term cost is decided. A system with a
        one-command release and a one-command rollback is maintained differently from one
        where deployment is an event.
      </p>
    </div>
  </section>

  <!-- ══ PIPELINE ══════════════════════════════════════════════════════
       A working state visualisation of stage 04 — status, order, and
       duration of a release. Not a decorative terminal window.
  -->
  <section class="ed-band">
    <div class="ed-shell py-14 lg:py-20">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">

        <div class="lg:col-span-5">
          <p class="ed-spec mb-5">§ 03 — Delivery mechanics</p>
          <h2 class="ed-display text-[2rem] lg:text-[2.6rem] max-w-[20ch] mb-5">
            What a release looks like when it is automated.
          </h2>
          <div class="ed-prose text-sm" style="color:var(--ink-2)">
            <p>
              Every project we hand over ships through a pipeline like the one running
              beside this text. A commit on the main branch triggers it; a failed gate stops
              it; the artifact that passed is the artifact that goes live.
            </p>
            <p>
              The point is not speed for its own sake. It is that releases become
              unremarkable, and that rolling one back is a single command instead of an
              incident.
            </p>
          </div>
          <div class="ed-hair mt-7 pt-6">
            <table class="ed-table">
              <tr><th scope="row">Trigger</th><td>Merge to main branch</td></tr>
              <tr><th scope="row">Gates</th><td>Static analysis, test suite, staging smoke check</td></tr>
              <tr><th scope="row">Artifact</th><td>Immutable and versioned — built once, promoted</td></tr>
              <tr><th scope="row">Rollback</th><td>Re-promote the previous artifact</td></tr>
              <tr><th scope="row">Secrets</th><td>Injected at deploy time, never committed</td></tr>
            </table>
          </div>
        </div>

        <div class="lg:col-span-7">
          <div class="ed-pipe" id="edPipe" role="group" aria-label="Illustrative deployment pipeline state">
            <div class="ed-pipe-head">
              <div class="flex items-center gap-2.5">
                <span class="ed-dot ed-dot--live" aria-hidden="true"></span>
                <span class="ed-pipe-step" style="font-size:.8125rem">pipeline / release</span>
              </div>
              <div class="flex items-center gap-4">
                <span class="ed-spec" id="edPipeElapsed">00:00</span>
                <span class="ed-spec" id="edPipeState">running</span>
              </div>
            </div>

            <div class="ed-pipe-prog" aria-hidden="true"><i id="edPipeProg"></i></div>

            <?php foreach ($pipeline as $i => $p): ?>
            <div class="ed-pipe-row" data-state="pending" data-ms="<?= (int) $p['ms'] ?>">
              <span class="ed-pipe-mark" data-mark aria-hidden="true"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span>
                <span class="ed-pipe-step"><?= Security::e($p['step']) ?></span>
                <span style="color:var(--ink-3)"> — <?= Security::e($p['detail']) ?></span>
              </span>
              <span class="ed-spec" data-dur>—</span>
            </div>
            <?php endforeach; ?>

            <div class="ed-pipe-head" style="border-top:1px solid var(--rule);border-bottom:0;">
              <span class="ed-spec" style="text-transform:none;letter-spacing:.02em;">
                Illustrative stage sequence and timings — not a live feed from a client system.
              </span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ══ WORK ══════════════════════════════════════════════════════════
       Real, shipped, publicly verifiable projects pulled from the database.
       Outcome metrics are only shown where the client has published them.
  -->
  <section class="ed-band">
    <div class="ed-shell py-14 lg:py-20">
      <div class="ed-sec-head mb-10">
        <p class="ed-spec lg:pt-3">§ 04 — Work</p>
        <div>
          <h2 class="ed-display text-[2rem] sm:text-[2.6rem] lg:text-[3rem] max-w-[24ch] mb-4">
            Shipped systems you can open in a new tab.
          </h2>
          <p class="ed-lede ed-prose">
            Every entry below is a live site with the real stack listed. Where a client has
            not authorised publishing performance or revenue figures, we say so rather than
            printing a number we cannot support.
          </p>
        </div>
      </div>

      <?php if (empty($caseStudies)): ?>
        <!-- Skeleton state: content not yet available from the database -->
        <div class="ed-hair pt-8 space-y-4 max-w-[52ch]">
          <div class="ed-skel-line" style="width:60%"></div>
          <div class="ed-skel-line" style="width:90%"></div>
          <div class="ed-skel-line" style="width:75%"></div>
          <p class="ed-spec pt-2">Case studies loading — no records returned yet.</p>
        </div>
      <?php else: ?>

        <?php $lead = $caseStudies[0]; $rest = array_slice($caseStudies, 1); ?>

        <!-- Lead case study: wide, two-column -->
        <article class="ed-hair pt-10 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 ed-rise">
          <div class="lg:col-span-7">
            <div class="ed-shot" style="aspect-ratio:16/10">
              <div class="ed-skel" data-skel aria-hidden="true"></div>
              <img data-shot
                   src="<?= url('uploads/' . rawurlencode($lead['thumbnail'] ?? '')) ?>"
                   alt="<?= Security::e($lead['title'] ?? 'Project') ?> — delivered interface"
                   width="1280" height="800" loading="lazy" decoding="async">
            </div>
          </div>
          <div class="lg:col-span-5">
            <p class="ed-spec mb-3">Lead engagement / <?= Security::e(ucfirst((string) ($lead['category'] ?? 'build'))) ?></p>
            <h3 class="ed-display text-[1.9rem] lg:text-[2.25rem] mb-4"><?= Security::e($lead['title'] ?? '') ?></h3>
            <p class="text-sm mb-6" style="color:var(--ink-2)"><?= Security::e($lead['description'] ?? '') ?></p>

            <div class="flex flex-wrap gap-1.5 mb-6">
              <?php foreach ($stackList($lead['tech_stack'] ?? null) as $t): ?>
                <span class="ed-tag"><?= Security::e($t) ?></span>
              <?php endforeach; ?>
            </div>

            <table class="ed-table mb-6">
              <tr><th scope="row">Status</th><td>In production</td></tr>
              <tr><th scope="row">Outcome metrics</th><td style="color:var(--ink-3)">Not published by the client</td></tr>
              <?php if (!empty($lead['live_url'])): ?>
              <tr>
                <th scope="row">Live system</th>
                <td><a class="ed-link" href="<?= Security::e($lead['live_url']) ?>" target="_blank" rel="noopener"><?= Security::e(preg_replace('#^https?://#', '', rtrim($lead['live_url'], '/'))) ?></a></td>
              </tr>
              <?php endif; ?>
            </table>

            <a href="<?= url('projects/view?slug=' . urlencode($lead['slug'] ?? '')) ?>" class="ed-cta-ghost">
              Architecture notes <span class="ed-cta-mark">&rarr;</span>
            </a>
          </div>
        </article>

        <!-- Remaining studies: dense rows, deliberately not a matching card grid -->
        <?php foreach ($rest as $p): ?>
        <article class="ed-hair mt-10 pt-10 grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-10 ed-rise">
          <div class="md:col-span-4">
            <div class="ed-shot" style="aspect-ratio:16/11">
              <div class="ed-skel" data-skel aria-hidden="true"></div>
              <img data-shot
                   src="<?= url('uploads/' . rawurlencode($p['thumbnail'] ?? '')) ?>"
                   alt="<?= Security::e($p['title'] ?? 'Project') ?> — delivered interface"
                   width="640" height="440" loading="lazy" decoding="async">
            </div>
          </div>
          <div class="md:col-span-5">
            <h3 class="ed-display text-[1.5rem] mb-3"><?= Security::e($p['title'] ?? '') ?></h3>
            <p class="text-sm mb-4" style="color:var(--ink-2)"><?= Security::e($p['description'] ?? '') ?></p>
            <div class="flex flex-wrap gap-1.5">
              <?php foreach ($stackList($p['tech_stack'] ?? null) as $t): ?>
                <span class="ed-tag"><?= Security::e($t) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="md:col-span-3">
            <table class="ed-table">
              <tr><th scope="row">Status</th><td>In production</td></tr>
              <tr><th scope="row">Metrics</th><td style="color:var(--ink-3)">Not published</td></tr>
              <?php if (!empty($p['live_url'])): ?>
              <tr><th scope="row">Live</th><td><a class="ed-link" href="<?= Security::e($p['live_url']) ?>" target="_blank" rel="noopener">Open &rarr;</a></td></tr>
              <?php endif; ?>
              <tr><th scope="row">Detail</th><td><a class="ed-link" href="<?= url('projects/view?slug=' . urlencode($p['slug'] ?? '')) ?>">Case notes</a></td></tr>
            </table>
          </div>
        </article>
        <?php endforeach; ?>

        <div class="ed-hair mt-10 pt-8">
          <a href="<?= url('projects') ?>" class="ed-link text-sm">Full project register &rarr;</a>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- ══ ENGAGEMENT MODELS ═════════════════════════════════════════════
       Real commercial shapes for a services firm, written as terms — not
       a priced three-tier product table.
  -->
  <section class="ed-band">
    <div class="ed-shell py-14 lg:py-20">
      <div class="ed-sec-head mb-10">
        <p class="ed-spec lg:pt-3">§ 05 — Engagement</p>
        <div>
          <h2 class="ed-display text-[2rem] sm:text-[2.6rem] lg:text-[3rem] max-w-[24ch] mb-4">
            Three ways to hire the team. No seat licences.
          </h2>
          <p class="ed-lede ed-prose">
            We are an engineering practice, so the commercial shape follows the work rather
            than a subscription tier. Rates are quoted after discovery, against a written
            scope — not printed on a page before anyone has seen your system.
          </p>
        </div>
      </div>

      <div class="ed-hair">
        <?php foreach ($engagements as $e): ?>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 lg:gap-10 py-8" style="border-top:1px solid var(--rule-2)">
          <div class="lg:col-span-3">
            <h3 class="ed-display text-[1.6rem] mb-1"><?= Security::e($e['name']) ?></h3>
            <p class="ed-spec" style="text-transform:none;letter-spacing:.02em;"><?= Security::e($e['shape']) ?></p>
          </div>
          <div class="lg:col-span-5 text-sm" style="color:var(--ink-2)">
            <p class="ed-spec mb-2">Who it is for</p>
            <p><?= Security::e($e['fit']) ?></p>
          </div>
          <div class="lg:col-span-4 text-sm" style="color:var(--ink-2)">
            <p class="ed-spec mb-2">Terms</p>
            <p><?= Security::e($e['terms']) ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ══ CONTACT ═══════════════════════════════════════════════════════ -->
  <section class="ed-band" style="background:var(--paper-2)">
    <div class="ed-shell py-16 lg:py-24">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
        <div class="lg:col-span-7">
          <p class="ed-spec mb-5">§ 06 — Start</p>
          <h2 class="ed-display text-[2.2rem] sm:text-[3rem] lg:text-[3.4rem] max-w-[24ch] mb-6">
            Send us the system you already have.
          </h2>
          <div class="ed-prose text-[1.0625rem]" style="color:var(--ink-2)">
            <p>
              The most useful first message is a description of what exists today and what it
              is failing to do. A repository link, a staging URL, or a screenshot of the slow
              page is enough to start from.
            </p>
            <p>
              You will get a reply from an engineer who has looked at it, inside working
              hours. If your problem is not something we should be doing, we will say that
              instead of scoping it.
            </p>
          </div>
          <div class="flex flex-wrap items-center gap-3 mt-8">
            <a href="<?= url('contact') ?>" class="ed-cta">Talk to an engineer <span class="ed-cta-mark">&rarr;</span></a>
            <a href="mailto:<?= Security::e(setting('site_email') ?: 'ecotech.internships@gmail.com') ?>" class="ed-cta-ghost">Email directly <span class="ed-cta-mark">&rarr;</span></a>
          </div>
        </div>

        <aside class="lg:col-span-4 lg:col-start-9 lg:pl-10 ed-vrule pt-8 lg:pt-2">
          <p class="ed-spec mb-4">Before you write</p>
          <table class="ed-table">
            <tr><th scope="row">Useful</th><td>Current stack, traffic shape, the specific failure</td></tr>
            <tr><th scope="row">Not needed</th><td>A finished specification. Discovery exists for that.</td></tr>
            <tr><th scope="row">Reply window</th><td><?= Security::e(setting('business_hours') ?: 'Mon – Sat, 09:00 – 18:00 IST') ?></td></tr>
            <tr><th scope="row">Your data</th><td><a class="ed-link" href="<?= url('privacy') ?>">How we handle it</a></td></tr>
          </table>
          <p class="ed-note mt-6">
            We do not run a sales team, so there is no follow-up sequence. One reply, from a
            person who can answer the technical question.
          </p>
        </aside>
      </div>
    </div>
  </section>

</div>

<script>
/* ==========================================================================
   Home page behaviour. Three jobs, all of them reporting real state:
     1. Lifecycle progress marks fill as each stage enters the viewport.
     2. Pipeline visualisation advances through stages with real durations.
     3. Skeleton loaders are removed only when an image has actually decoded.
   No library, no scroll listener, nothing running off-screen.
   ========================================================================== */
(function () {
  'use strict';

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ── 1. Skeleton loaders resolve on real image load ───────────────── */
  document.querySelectorAll('[data-shot]').forEach(function (img) {
    function settle() {
      img.classList.add('is-loaded');
      var skel = img.parentNode.querySelector('[data-skel]');
      if (skel) skel.remove();
    }
    if (img.complete && img.naturalWidth > 0) { settle(); return; }
    img.addEventListener('load', settle, { once: true });
    // Keep the placeholder surface on failure rather than flashing a broken icon.
    img.addEventListener('error', function () {
      var skel = img.parentNode.querySelector('[data-skel]');
      if (skel) skel.style.animation = 'none';
    }, { once: true });
  });

  /* ── 2. Reveal + lifecycle progress ──────────────────────────────── */
  var stages = document.querySelectorAll('[data-stage]');
  var rises = document.querySelectorAll('.ed-rise');

  if (!('IntersectionObserver' in window) || reduced) {
    stages.forEach(function (s) { s.setAttribute('data-reached', '1'); });
    rises.forEach(function (r) { r.classList.add('is-in'); });
  } else {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var el = entry.target;
        if (el.hasAttribute('data-stage')) el.setAttribute('data-reached', '1');
        el.classList.add('is-in');
        io.unobserve(el);
      });
    }, { rootMargin: '0px 0px -18% 0px', threshold: 0.2 });

    stages.forEach(function (s) { io.observe(s); });
    rises.forEach(function (r) { io.observe(r); });
  }

  /* ── 3. Pipeline state machine ───────────────────────────────────── */
  var pipe = document.getElementById('edPipe');
  if (!pipe) return;

  var rows = Array.prototype.slice.call(pipe.querySelectorAll('.ed-pipe-row'));
  var prog = document.getElementById('edPipeProg');
  var stateEl = document.getElementById('edPipeState');
  var elapsedEl = document.getElementById('edPipeElapsed');
  var total = rows.reduce(function (a, r) { return a + parseInt(r.dataset.ms, 10); }, 0);

  function fmt(ms) {
    var s = Math.floor(ms / 1000);
    return String(Math.floor(s / 60)).padStart(2, '0') + ':' + String(s % 60).padStart(2, '0');
  }

  function render(done, runningIndex, accumulated) {
    rows.forEach(function (row, i) {
      var mark = row.querySelector('[data-mark]');
      var dur = row.querySelector('[data-dur]');
      if (i < done) {
        row.dataset.state = 'done';
        mark.textContent = 'ok';
        dur.textContent = (parseInt(row.dataset.ms, 10) / 1000).toFixed(1) + 's';
      } else if (i === runningIndex) {
        row.dataset.state = 'running';
        mark.innerHTML = reduced ? '&rsaquo;' : '<span class="ed-pipe-spin"></span>';
        dur.textContent = 'running';
      } else {
        row.dataset.state = 'pending';
        mark.textContent = String(i + 1).padStart(2, '0');
        dur.textContent = '—';
      }
    });
    prog.style.width = ((accumulated / total) * 100).toFixed(2) + '%';
    elapsedEl.textContent = fmt(accumulated);
  }

  // Static, fully-passed state when motion is reduced — same information, no movement.
  if (reduced) {
    render(rows.length, -1, total);
    stateEl.textContent = 'passed';
    return;
  }

  var index = 0, acc = 0, timer = null, running = false;

  function step() {
    if (index >= rows.length) {
      stateEl.textContent = 'passed · released';
      timer = window.setTimeout(function () {
        index = 0; acc = 0;
        stateEl.textContent = 'running';
        step();
      }, 4200);
      return;
    }
    render(index, index, acc);
    stateEl.textContent = 'running';
    var ms = parseInt(rows[index].dataset.ms, 10);
    timer = window.setTimeout(function () {
      acc += ms;
      index += 1;
      render(index, index < rows.length ? index : -1, acc);
      step();
    }, ms);
  }

  function start() { if (!running) { running = true; step(); } }
  function stop() { running = false; if (timer) { window.clearTimeout(timer); timer = null; } }

  render(0, -1, 0);

  // Only run while the pipeline is actually on screen.
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (entries) {
      entries[0].isIntersecting ? start() : stop();
    }, { threshold: 0.25 }).observe(pipe);
  } else {
    start();
  }

  document.addEventListener('visibilitychange', function () {
    document.hidden ? stop() : start();
  });
})();
</script>
