<?php
// ============================================================
// Ecotech Service — Events & Builder Sprints Hub (/events)
// ============================================================
?>

<!-- ── HERO ─────────────────────────────────────────────────── -->
<section class="s-sec">
  <div class="s-shell">
    <nav class="s-crumbs" aria-label="Breadcrumb">
      <a href="<?= url('') ?>">Home</a><span>/</span>
      <span aria-current="page">Events</span>
    </nav>

    <div class="s-grid mt-8">
      <div style="grid-column:span 8" data-reveal>
        <p class="s-eyebrow">Developer Community &middot; Builder Sprints</p>
        <h1 class="s-display mt-4">Where we build, mentor &amp; <span class="s-it">compete.</span></h1>
        <p class="s-lede mt-6">
          Hackathons, architecture review clinics, and technical build sprints where Ecotech Service mentors teams, evaluates real-world systems, and helps engineers ship production-grade software.
        </p>
        <div class="s-actions mt-8">
          <a href="#featured" class="s-btn">View upcoming hackathon</a>
          <a href="<?= url('contact') ?>" class="s-btn--line">Partner with us</a>
        </div>
      </div>

      <div style="grid-column:span 4" class="flex flex-col justify-end" data-reveal>
        <div class="s-panel s-panel--deep">
          <p class="s-num">Mentorship focus</p>
          <h2 class="s-h3 mt-2">Working software over slide decks.</h2>
          <p class="s-mute mt-3" style="font-size:0.95rem;line-height:1.6">
            We judge and mentor teams based on verifiable engineering: clean data models, resilient error handling, fast TTFB, and software that actually survives real user traffic.
          </p>
        </div>
      </div>
    </div>

    <div class="s-figs mt-14" data-reveal>
      <div class="s-fig">
        <b>01</b>
        <span>Active hackathon sprint</span>
      </div>
      <div class="s-fig">
        <b>₹1.1L+</b>
        <span>Cash prize &amp; reward pool</span>
      </div>
      <div class="s-fig">
        <b>36h</b>
        <span>Hands-on build window</span>
      </div>
      <div class="s-fig">
        <b>100% Free</b>
        <span>Zero entry fee for teams</span>
      </div>
    </div>
  </div>
</section>

<!-- ── FEATURED EVENT SPOTLIGHT ─────────────────────────────── -->
<section class="s-sec" id="featured">
  <div class="s-shell">
    <div class="s-grid mb-10">
      <div style="grid-column:span 6" data-reveal>
        <p class="s-eyebrow">Featured Hackathon</p>
        <h2 class="s-h2 mt-3">Upcoming flagship sprint</h2>
      </div>
      <div style="grid-column:span 6" class="flex items-end justify-start lg:justify-end" data-reveal>
        <span class="s-tag" style="background:rgba(110,231,183,0.15);color:#6ee7b7;border-color:rgba(110,231,183,0.3);font-size:0.875rem;padding:0.4rem 0.9rem">
          ● Registration Open &middot; Closes 18 Dec 2026
        </span>
      </div>
    </div>

    <!-- Spotlight Card -->
    <article class="s-panel s-panel--deep" style="padding:2.5rem;border-color:rgba(110,231,183,0.25)" data-reveal>
      <div class="s-grid">
        <div style="grid-column:span 8">
          <div class="flex items-center gap-3 flex-wrap">
            <span class="s-mono s-mute" style="font-size:0.85rem">09 – 10 JAN 2027</span>
            <span class="s-mute">&middot;</span>
            <span class="s-mono s-mute" style="font-size:0.85rem">PUNE, MAHARASHTRA &amp; ONLINE</span>
            <span class="s-mute">&middot;</span>
            <span class="s-mono s-mute" style="font-size:0.85rem">HYBRID FORMAT</span>
          </div>

          <h3 class="s-h1 mt-4">
            <a href="<?= url('events/hack2skill-x-sudarshan') ?>" style="text-decoration:none">
              Hack2Skill &times; Sudarshan Hackathon
            </a>
          </h3>

          <p class="s-lede mt-4" style="color:var(--band-mute)">
            A 36-hour build sprint for engineers solving real-world challenges in chemical manufacturing, formulation science, and resilient industrial supply chains.
          </p>

          <p class="s-prose mt-4" style="max-width:65ch">
            Ecotech Service sits on the official mentor panel. We will be on site for the entire build window &mdash; unblocking architectures, advising on API resilience, and helping teams deliver deployed, functioning systems.
          </p>

          <div class="mt-8">
            <p class="s-eyebrow" style="margin-bottom:0.75rem">Challenge tracks</p>
            <div class="s-tags">
              <span class="s-tag">Plant-floor intelligence</span>
              <span class="s-tag">Materials &amp; formulation</span>
              <span class="s-tag">Supply chain visibility</span>
              <span class="s-tag">Sustainability reporting</span>
            </div>
          </div>

          <div class="s-actions mt-10">
            <a href="<?= url('events/hack2skill-x-sudarshan') ?>" class="s-btn">
              View event brief, prizes &amp; criteria &rarr;
            </a>
            <a href="https://hack2skill.com/hackathons-listing" target="_blank" rel="noopener noreferrer" class="s-btn--line">
              Register on Hack2Skill
            </a>
          </div>
        </div>

        <aside style="grid-column:span 4" class="mt-8 lg:mt-0 lg:border-l lg:border-[var(--line)] lg:pl-8">
          <p class="s-eyebrow">Quick specs</p>
          <dl class="s-kv mt-4">
            <div>
              <dt>Hosts</dt>
              <dd>Sudarshan &amp; Hack2Skill</dd>
            </div>
            <div>
              <dt>Mentors</dt>
              <dd>Ecotech Service Engineering</dd>
            </div>
            <div>
              <dt>Total rewards</dt>
              <dd><strong>₹1,10,000+</strong></dd>
            </div>
            <div>
              <dt>Top prize</dt>
              <dd>₹50,000 + Interview slot</dd>
            </div>
            <div>
              <dt>Team size</dt>
              <dd>2 to 4 members</dd>
            </div>
            <div>
              <dt>Eligibility</dt>
              <dd>Students &amp; professionals (India)</dd>
            </div>
            <div>
              <dt>Registration</dt>
              <dd>Free &middot; Closes 18 Dec 2026</dd>
            </div>
          </dl>
        </aside>
      </div>
    </article>
  </div>
</section>

<!-- ── COMMUNITY SPRINTS & MENTORSHIP ───────────────────────── -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid mb-10">
      <div style="grid-column:span 6" data-reveal>
        <p class="s-eyebrow">Ongoing Programs</p>
        <h2 class="s-h2 mt-3">Community engineering initiatives</h2>
      </div>
      <div style="grid-column:span 6" class="flex items-end" data-reveal>
        <p class="s-lede">
          Beyond major hackathons, we run ongoing technical clinics and open architecture reviews for student teams and early-stage startup builders.
        </p>
      </div>
    </div>

    <div class="s-grid lg:grid-cols-2 gap-8">
      <!-- Program 1 -->
      <article class="s-panel" data-reveal>
        <p class="s-num">Program 01 &middot; Continuous</p>
        <h3 class="s-h3 mt-3">Open Architecture &amp; Security Clinics</h3>
        <p class="s-mute mt-3" style="line-height:1.6">
          Building a project for a hackathon, student competition, or portfolio? Book a complimentary 45-minute architecture sprint with our team. We evaluate data modeling, OWASP vulnerability risks, caching strategies, and production readiness before you pitch.
        </p>
        <div class="s-tags mt-6">
          <span class="s-tag">System Design</span>
          <span class="s-tag">OWASP Top 10</span>
          <span class="s-tag">Database Schema</span>
          <span class="s-tag">API Performance</span>
        </div>
        <p class="s-actions mt-8">
          <a href="<?= url('contact') ?>" class="s-link">Request a review slot &rarr;</a>
        </p>
      </article>

      <!-- Program 2 -->
      <article class="s-panel" data-reveal>
        <p class="s-num">Program 02 &middot; Engineering Workshops</p>
        <h3 class="s-h3 mt-3">Production Performance &amp; Cloud Masterclass</h3>
        <p class="s-mute mt-3" style="line-height:1.6">
          Interactive masterclasses on building software that remains lightning fast under stress. Learn how to diagnose Core Web Vitals, write framework-free vanilla JavaScript components, architect server-rendered PHP 8 backends, and configure continuous automated CI/CD deployments.
        </p>
        <div class="s-tags mt-6">
          <span class="s-tag">Core Web Vitals</span>
          <span class="s-tag">Vanilla JS</span>
          <span class="s-tag">PHP 8 &amp; MySQL</span>
          <span class="s-tag">Docker CI/CD</span>
        </div>
        <p class="s-actions mt-8">
          <a href="<?= url('contact') ?>" class="s-link">Inquire for your campus / team &rarr;</a>
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ── PARTNER CTA ─────────────────────────────────────────── -->
<section class="s-sec s-band">
  <div class="s-shell">
    <div class="s-grid items-center">
      <div style="grid-column:span 7" data-reveal>
        <p class="s-eyebrow" style="color:var(--band-mute)">Collaboration</p>
        <h2 class="s-h2 mt-2">Organizing a hackathon or technical fest?</h2>
        <p class="mt-4" style="color:var(--band-mute);max-width:55ch">
          We collaborate with university tech clubs, developer communities, and corporate innovation teams as technical mentors, problem statement curators, and jury panelists. Let&rsquo;s discuss how we can support your builders.
        </p>
      </div>
      <div style="grid-column:span 5" class="flex flex-col lg:items-end justify-center mt-6 lg:mt-0" data-reveal>
        <div class="s-actions">
          <a href="<?= url('contact') ?>" class="s-btn--light">Propose a collaboration</a>
          <a href="mailto:ecotech.servic@gmail.com" class="s-btn--line" style="color:var(--band-fg);border-color:var(--band-fg)">Email event desk</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Structured Data ─────────────────────────────────────── -->
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'CollectionPage',
    '@id'      => url('events#webpage'),
    'url'      => url('events'),
    'name'     => 'Tech Events, Hackathons & Builder Sprints | Ecotech Service',
    'description' => 'Explore upcoming hackathons, engineering clinics, and developer workshops mentored and hosted by Ecotech Service.',
    'isPartOf' => [
        '@id' => url('#website')
    ],
    'mainEntity' => [
        '@type' => 'ItemList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Hack2Skill × Sudarshan Hackathon',
                'url' => url('events/hack2skill-x-sudarshan')
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Open Architecture & Security Clinics',
                'url' => url('contact')
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => 'Production Performance & Cloud Masterclass',
                'url' => url('contact')
            ]
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
