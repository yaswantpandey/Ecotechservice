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

<!-- How it works -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid" style="align-items:end">
      <div style="grid-column:span 5">
        <p class="s-eyebrow">Process</p>
        <h2 class="s-h2 mt-4">From template to live site in three steps.</h2>
      </div>
    </div>
    <div class="mt-10" data-reveal>
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:0;border-top:1px solid var(--ink);border-left:1px solid var(--rule)">
        <?php foreach ([
          ['01', 'Pick a template',   'Browse the list, filter by Free or Premium, and hit "Live preview" to see it in your browser before you commit.'],
          ['02', 'We customise it',   'Share your brand colours, logo, copy and images. We apply your identity to the template and send a staging link for review.'],
          ['03', 'You go live',       'Approve the result, we deploy to your domain and hand over the clean source files. Done — usually within a few days.'],
        ] as $step): ?>
        <div style="padding:2rem 1.75rem;border-right:1px solid var(--rule);border-bottom:1px solid var(--rule)">
          <span class="s-num" style="font-size:2rem;font-family:var(--f-display);color:var(--ink-3)"><?= $step[0] ?></span>
          <h3 class="s-h3 mt-4"><?= Security::e($step[1]) ?></h3>
          <p class="s-mute mt-3" style="font-size:.9375rem;line-height:1.6"><?= Security::e($step[2]) ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
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

<!-- Free vs Premium comparison -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5">
        <p class="s-eyebrow">Tier comparison</p>
        <h2 class="s-h2 mt-4">Free or Premium — what's the difference?</h2>
        <p class="s-mute mt-5" style="font-size:.9375rem;line-height:1.65">Free templates give you a solid, production-ready starting point. Premium templates add polish, more sections and priority support.</p>
      </div>
      <div style="grid-column:span 7" data-reveal>
        <div class="s-table-wrap mt-2">
          <table class="s-table" style="min-width:520px">
            <thead>
              <tr>
                <th style="width:52%">Feature</th>
                <th style="text-align:center">Free</th>
                <th style="text-align:center">Premium</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $compare = [
                ['Fully responsive layout',         true,  true],
                ['High PageSpeed score',            true,  true],
                ['Semantic HTML &amp; clean CSS',   true,  true],
                ['Cross-browser support',           true,  true],
                ['Email support',                   true,  true],
                ['Number of page templates',        '2–3', '6–10'],
                ['Dark mode variant',               false, true],
                ['Premium icon set',                false, true],
                ['Blog module',                     false, true],
                ['Contact form with anti-spam',     false, true],
                ['Interactive component library',   false, true],
                ['Priority WhatsApp support',       false, true],
                ['Free minor updates (12 months)',  false, true],
              ];
              $tick  = '<span style="color:var(--signal);font-size:1rem" aria-label="Yes">&#10003;</span>';
              $cross = '<span style="color:var(--ink-3);font-size:.85rem" aria-label="No">&#8212;</span>';
              foreach ($compare as $row): ?>
              <tr>
                <td><?= $row[0] ?></td>
                <td style="text-align:center"><?= $row[1] === true ? $tick : ($row[1] === false ? $cross : '<span class="s-mono s-mute">' . $row[1] . '</span>') ?></td>
                <td style="text-align:center"><?= $row[2] === true ? $tick : ($row[2] === false ? $cross : '<span class="s-mono s-mute">' . $row[2] . '</span>') ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="s-actions mt-8">
          <a href="<?= url('templates?type=free') ?>"    class="s-btn--line s-btn--sm">Browse free</a>
          <a href="<?= url('templates?type=premium') ?>" class="s-btn s-btn--sm">Browse premium</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Design Roadmap -->
<section class="s-sec">
  <div class="s-shell">

    <div class="s-grid">
      <div style="grid-column:span 5">
        <p class="s-eyebrow">Template roadmap</p>
        <h2 class="s-h2 mt-4">What's coming next.</h2>
        <p class="s-lede mt-5">We ship improvements continuously. Here is the current state of each planned feature across all templates.</p>
      </div>
      <div style="grid-column:span 7">
        <p class="s-mono s-mute" style="padding-top:.25rem">Last updated <?= date('F Y') ?></p>
      </div>
    </div>

    <!-- Phase 1 -->
    <div class="mt-12" data-reveal>
      <div style="display:flex;align-items:baseline;gap:1rem;padding-bottom:.75rem;border-bottom:1px solid var(--ink)">
        <span class="s-num">01</span>
        <h3 class="s-h3">Available now</h3>
        <span class="s-tag s-tag--signal" style="margin-left:auto">Live</span>
      </div>
      <ol class="s-list">
        <?php foreach ([
          ['Fully responsive layout',      'Tested on mobile, tablet and desktop. Fluid grids, no fixed-width hacks.'],
          ['High PageSpeed score',         'Minimal dependencies, deferred scripts, optimised images and critical-path CSS.'],
          ['Semantic HTML & clean CSS',    'Well-structured markup, BEM-inspired class names, easy to read and extend.'],
          ['Cross-browser compatible',     'Verified in Chrome, Firefox, Safari and Edge on both desktop and mobile.'],
          ['WhatsApp & email support',     'Direct line to the team for customisation requests, questions and bug fixes.'],
        ] as $ri => $r): ?>
        <li>
          <span class="s-num"><?= str_pad((string)($ri + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h4 class="s-h3"><?= Security::e($r[0]) ?></h4>
          <p><?= Security::e($r[1]) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <!-- Phase 2 -->
    <div class="mt-12" data-reveal>
      <div style="display:flex;align-items:baseline;gap:1rem;padding-bottom:.75rem;border-bottom:1px solid var(--ink)">
        <span class="s-num">02</span>
        <h3 class="s-h3">Coming soon &mdash; Q1 <?= date('Y') + (date('m') >= 10 ? 1 : 0) ?></h3>
        <span class="s-tag" style="margin-left:auto">In progress</span>
      </div>
      <ol class="s-list">
        <?php foreach ([
          ['Dark mode variant',             'Every template ships with a light/dark toggle and a matching dark-mode stylesheet.'],
          ['Blog module add-on',            'Drop-in blog pages (listing, post, tags) with RSS feed and schema markup.'],
          ['Contact form with anti-spam',   'Honeypot + rate-limit protected form, no third-party service required.'],
          ['Interactive component library', 'Documented accordion, tabs, modal and dropdown components for each template.'],
        ] as $ri => $r): ?>
        <li>
          <span class="s-num"><?= str_pad((string)($ri + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h4 class="s-h3"><?= Security::e($r[0]) ?></h4>
          <p><?= Security::e($r[1]) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <!-- Phase 3 -->
    <div class="mt-12" data-reveal>
      <div style="display:flex;align-items:baseline;gap:1rem;padding-bottom:.75rem;border-bottom:1px solid var(--ink)">
        <span class="s-num">03</span>
        <h3 class="s-h3">In development &mdash; Q2 <?= date('Y') + (date('m') >= 10 ? 1 : 0) ?></h3>
        <span class="s-tag s-tag--mute" style="margin-left:auto">Planned</span>
      </div>
      <ol class="s-list">
        <?php foreach ([
          ['CMS-ready architecture',       'Flat-file and headless CMS hooks so editors can update content without touching code.'],
          ['Multi-language / i18n support', 'Language switcher, RTL-safe layouts and per-locale metadata out of the box.'],
          ['E-commerce starter kit',        'Product grid, cart sidebar and checkout page scaffold built on the template system.'],
          ['SEO meta management',           'Per-page title, description, OG and structured-data fields exposed as front-matter.'],
        ] as $ri => $r): ?>
        <li>
          <span class="s-num"><?= str_pad((string)($ri + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h4 class="s-h3"><?= Security::e($r[0]) ?></h4>
          <p><?= Security::e($r[1]) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <!-- Phase 4 -->
    <div class="mt-12" data-reveal>
      <div style="display:flex;align-items:baseline;gap:1rem;padding-bottom:.75rem;border-bottom:1px solid var(--ink)">
        <span class="s-num">04</span>
        <h3 class="s-h3">On the horizon</h3>
        <span class="s-tag s-tag--mute" style="margin-left:auto">Exploring</span>
      </div>
      <ol class="s-list">
        <?php foreach ([
          ['PWA-ready builds',            'Service workers and web-app manifest so the site installs as a mobile app.'],
          ['One-click deploy scripts',    'Bash and GitHub Actions scripts to push any template to a shared host or VPS.'],
          ['Analytics starter pack',     'Privacy-first analytics (Plausible/Umami) wired up and pre-configured.'],
          ['AI content prefill',         'CLI tool that drafts first-pass copy for each section based on your business description.'],
        ] as $ri => $r): ?>
        <li>
          <span class="s-num"><?= str_pad((string)($ri + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h4 class="s-h3"><?= Security::e($r[0]) ?></h4>
          <p><?= Security::e($r[1]) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <!-- Suggest a feature nudge -->
    <div class="s-panel s-panel--deep mt-12" style="display:flex;flex-wrap:wrap;align-items:center;gap:1.5rem;justify-content:space-between">
      <div>
        <p class="s-eyebrow" style="margin-bottom:.35rem">Have a request?</p>
        <p class="s-h3" style="font-family:var(--f-display);font-weight:500;margin:0">Suggest a template feature.</p>
        <p class="s-mute s-small mt-2">Tell us what you need and we will prioritise accordingly.</p>
      </div>
      <a href="<?= url('contact') ?>" class="s-btn s-btn--sm">Send a suggestion</a>
    </div>

  </div>
</section>

<!-- FAQ -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 4">
        <p class="s-eyebrow">FAQ</p>
        <h2 class="s-h2 mt-4">Common questions.</h2>
      </div>
      <div style="grid-column:span 8" data-reveal>
        <?php
        $faqs = [
          ['Can I use a free template for a commercial project?',
           'Yes. All free templates are released under an open licence for commercial use. Attribution is appreciated but not required.'],
          ['How long does the customisation take?',
           'Most customisations are delivered within 3–5 business days. Complex requests or premium templates with many pages may take up to 7–10 days.'],
          ['Do I need to know how to code?',
           'No. We handle all code changes. You only need to supply your content (text, images, logo) and we do the rest.'],
          ['What if I want changes after the site goes live?',
           'Premium templates include free minor updates for 12 months. For free templates, small tweaks are quoted on request — usually very affordable.'],
          ['Can I switch to a different template later?',
           'Yes, though it requires a fresh customisation. If you are undecided, use the live preview links to compare before choosing.'],
          ['Do the templates include hosting?',
           'Templates are source-file deliveries, not hosted products. We can recommend or set up hosting for you as a separate service.'],
          ['Will you build me a custom design instead?',
           'Absolutely. If no template fits your brand or use case, we design and build from scratch. Use the "Request a custom design" button below.'],
        ];
        ?>
        <div class="s-acc">
          <?php foreach ($faqs as $qi => $qa): ?>
          <div class="s-acc-item">
            <button class="s-acc-btn" data-acc aria-expanded="false" aria-controls="faq-<?= $qi ?>">
              <?= Security::e($qa[0]) ?>
              <span class="s-acc-sign" aria-hidden="true">+</span>
            </button>
            <div class="s-acc-panel" id="faq-<?= $qi ?>" hidden>
              <p><?= Security::e($qa[1]) ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
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
