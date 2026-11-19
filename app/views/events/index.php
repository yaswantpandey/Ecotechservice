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
        <b>₹20,000</b>
        <span>Cash prize pool + $400 credits</span>
      </div>
      <div class="s-fig">
        <b>100% Online</b>
        <span>Remote Pan-India challenge</span>
      </div>
      <div class="s-fig">
        <b>Free Entry</b>
        <span>Zero registration fee for builders</span>
      </div>
    </div>
  </div>
</section>

<!-- ── FEATURED EVENT SPOTLIGHT ─────────────────────────────── -->
<section class="s-sec" id="featured">
  <div class="s-shell">
    <div class="s-grid mb-10">
      <div style="grid-column:span 6" data-reveal>
        <p class="s-eyebrow">Featured Hackathon &middot; Live Challenge</p>
        <h2 class="s-h2 mt-3">Upcoming flagship sprint</h2>
      </div>
      <div style="grid-column:span 6" class="flex items-end justify-start lg:justify-end" data-reveal>
        <span class="s-tag" style="background:rgba(239,68,68,0.15);color:#ef4444;border-color:rgba(239,68,68,0.3);font-size:0.875rem;padding:0.4rem 0.9rem">
          ● Registration Closes 19 Nov 2026, 23:59 IST
        </span>
      </div>
    </div>

    <!-- Spotlight Card -->
    <article class="s-panel s-panel--deep" style="padding:2.5rem;border-color:rgba(110,231,183,0.25)" data-reveal>
      <div class="s-grid">
        <div style="grid-column:span 8">
          <div class="flex items-center gap-3 flex-wrap">
            <span class="s-mono s-mute" style="font-size:0.85rem">19 – 23 NOV 2026</span>
            <span class="s-mute">&middot;</span>
            <span class="s-mono s-mute" style="font-size:0.85rem">100% ONLINE / REMOTE (PAN-INDIA)</span>
            <span class="s-mute">&middot;</span>
            <span class="s-mono s-mute" style="font-size:0.85rem">VIBE CODING &amp; AI SPRINT</span>
          </div>

          <h3 class="s-h1 mt-4">
            <a href="<?= url('events/promptwars-x-sudarshan') ?>" style="text-decoration:none">
              PromptWars &times; Sudarshan
            </a>
          </h3>

          <p class="s-lede mt-4" style="color:var(--band-mute)">
            The Ultimate Vibe-Coding &amp; Rapid Prototyping Hackathon. Organized by Sudarshana in collaboration with Ecotech Services, Google for Developers, and Hack2Skill.
          </p>

          <p class="s-prose mt-4" style="max-width:65ch">
            Ecotech Services leadership sits on the official jury and mentor panel. Solo builders solve real-world challenges with generative AI models and multi-agent systems to compete for ₹20,000 cash, $400 AI credits, and exclusive fast-track internship offers.
          </p>

          <div class="mt-8">
            <p class="s-eyebrow" style="margin-bottom:0.75rem">Challenge tracks</p>
            <div class="s-tags">
              <span class="s-tag">AI Multi-Agent Crisis Command Centre</span>
              <span class="s-tag">Adaptive AI Tutor</span>
              <span class="s-tag">Fake News &amp; Deepfake Verifier</span>
              <span class="s-tag">Open Innovation</span>
            </div>
          </div>

          <div class="s-actions mt-10">
            <a href="<?= url('events/promptwars-x-sudarshan') ?>" class="s-btn">
              View event brief, tracks &amp; jury &rarr;
            </a>
            <a href="https://hack2skill.com/event/promptwars-x-sudarshan/registration" target="_blank" rel="noopener noreferrer" class="s-btn--line">
              Register on Hack2Skill
            </a>
            <a href="https://chat.whatsapp.com/Kvfa52JBqCM25KGW5qNk2G?s=cl&p=a&mlu=4&ilr=4&iam=2" target="_blank" rel="noopener noreferrer" class="s-btn--line" style="border-color:#25D366;color:#25D366">
              💬 WhatsApp Group
            </a>
          </div>
        </div>

        <aside style="grid-column:span 4" class="mt-8 lg:mt-0 lg:border-l lg:border-[var(--line)] lg:pl-8">
          <p class="s-eyebrow">Quick specs</p>
          <dl class="s-kv mt-4">
            <div>
              <dt>Hosts &amp; Partners</dt>
              <dd>Sudarshana, Ecotech &amp; Hack2Skill</dd>
            </div>
            <div>
              <dt>Jury Panel</dt>
              <dd>Ecotech Leadership &amp; AIMT</dd>
            </div>
            <div>
              <dt>Total rewards</dt>
              <dd><strong>₹20,000 INR + $400 Credits</strong></dd>
            </div>
            <div>
              <dt>Career Track</dt>
              <dd>Ecotech Engineering Internships</dd>
            </div>
            <div>
              <dt>Format</dt>
              <dd>100% Online (Remote)</dd>
            </div>
            <div>
              <dt>Team size</dt>
              <dd>Solo (1 Member)</dd>
            </div>
            <div>
              <dt>Eligibility</dt>
              <dd>Builders across India (16+)</dd>
            </div>
            <div>
              <dt>Registration</dt>
              <dd>Free &middot; Closes 19 Nov 2026</dd>
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
                'name' => 'PromptWars × Sudarshan Hackathon',
                'url' => url('events/promptwars-x-sudarshan')
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
