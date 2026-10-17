<!-- SEARCH RESULTS / SITELINKS SEARCHBOX VIEW -->

<!-- Intro + form -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5">
        <p class="s-eyebrow">Search</p>
        <h1 class="s-h1 mt-4">Search <?= Security::e(APP_NAME) ?></h1>
        <p class="s-lede mt-5">Find services, security audits, case studies and website templates.</p>
      </div>
      <div style="grid-column:span 7" class="lg:pt-10">
        <form action="<?= url('search') ?>" method="GET" role="search">
          <label class="s-label" for="site-search-q">Search term</label>
          <div class="flex gap-2">
            <input type="text" id="site-search-q" name="q" value="<?= Security::e($query) ?>"
                   placeholder="Services, projects, cybersecurity, templates"
                   class="s-input" autocomplete="off" required>
            <button type="submit" class="s-btn">Search</button>
          </div>
        </form>
        <div class="flex flex-wrap items-center gap-2 mt-5">
          <span class="s-mute s-small">Popular:</span>
          <div class="s-tags">
            <?php foreach (['Web Development', 'Penetration Testing', 'Mobile Apps', 'Pandey Reality', 'Templates', 'Contact'] as $tag): ?>
            <a href="<?= url('search?q=' . urlencode($tag)) ?>" class="s-tag"><?= Security::e($tag) ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="s-sec">
  <div class="s-shell">

    <?php if (!empty($query)): ?>
    <div class="flex flex-wrap items-baseline justify-between gap-4 pb-6">
      <p>Showing <span class="s-num" style="color:inherit"><?= (int)$totalCount ?></span> results for &ldquo;<strong><?= Security::e($query) ?></strong>&rdquo;</p>
      <a href="<?= url('search') ?>" class="s-link s-small">Clear search</a>
    </div>
    <?php endif; ?>

    <?php if (!empty($query) && $totalCount === 0): ?>
    <!-- No results -->
    <div class="s-panel s-panel--deep">
      <h2 class="s-h3">No exact matches found</h2>
      <p class="s-mute mt-3">Nothing matched &ldquo;<strong><?= Security::e($query) ?></strong>&rdquo;. Try broader terms such as &ldquo;web&rdquo;, &ldquo;security&rdquo;, &ldquo;mobile&rdquo; or &ldquo;project&rdquo;.</p>
      <div class="s-actions mt-6">
        <a href="<?= url('services') ?>" class="s-btn s-btn--sm">View all services</a>
        <a href="<?= url('projects') ?>" class="s-btn--line s-btn--sm">View projects</a>
        <a href="<?= url('contact') ?>" class="s-btn--line s-btn--sm">Contact us</a>
      </div>
    </div>
    <?php endif; ?>

    <!-- 1. Services -->
    <?php if (!empty($servicesResults)): ?>
    <div class="mt-12" data-reveal>
      <h2 class="s-eyebrow mb-4">Services <span class="s-num">(<?= count($servicesResults) ?>)</span></h2>
      <div class="s-list">
        <?php foreach ($servicesResults as $i => $sv): ?>
        <a href="<?= url('services#' . $sv['slug']) ?>">
          <span class="s-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h3 class="s-h3"><?= Security::e($sv['title']) ?></h3>
          <p><?= Security::e($sv['description']) ?></p>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- 2. Projects -->
    <?php if (!empty($projectsResults)): ?>
    <div class="mt-12" data-reveal>
      <h2 class="s-eyebrow mb-4">Project case studies <span class="s-num">(<?= count($projectsResults) ?>)</span></h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php foreach ($projectsResults as $p): ?>
        <article class="flex gap-4 pt-4" style="border-top:1px solid var(--rule)">
          <div class="s-media s-media--4x3 shrink-0" style="width:7rem">
            <img src="<?= uploadUrl(!empty($p['thumbnail']) ? $p['thumbnail'] : 'project_startup_landing.png') ?>"
                 alt="<?= Security::e($p['title']) ?>" width="112" height="84" loading="lazy">
          </div>
          <div class="min-w-0">
            <div class="flex flex-wrap items-baseline gap-2">
              <h3 class="s-h3"><?= Security::e($p['title']) ?></h3>
              <span class="s-tag"><?= Security::e(ucfirst($p['category'])) ?></span>
            </div>
            <p class="s-mute s-small mt-1"><?= Security::e($p['description']) ?></p>
            <div class="flex flex-wrap gap-4 mt-2 s-small">
              <a href="<?= url('projects/view?slug=' . urlencode($p['slug'])) ?>" class="s-link">View case study</a>
              <?php if (!empty($p['live_url'])): ?>
              <a href="<?= Security::e($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="s-link">Live site <i class="fas fa-arrow-up-right-from-square" aria-hidden="true" style="font-size:.7rem"></i></a>
              <?php endif; ?>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- 3. Pages -->
    <?php if (!empty($pagesResults)): ?>
    <div class="mt-12" data-reveal>
      <h2 class="s-eyebrow mb-4">Company pages <span class="s-num">(<?= count($pagesResults) ?>)</span></h2>
      <div class="s-list">
        <?php foreach ($pagesResults as $i => $cp): ?>
        <a href="<?= Security::e($cp['url']) ?>">
          <span class="s-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h3 class="s-h3"><?= Security::e($cp['title']) ?></h3>
          <p><?= Security::e($cp['desc']) ?></p>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- 4. Templates -->
    <?php if (!empty($templatesResults)): ?>
    <div class="mt-12" data-reveal>
      <h2 class="s-eyebrow mb-4">Website templates <span class="s-num">(<?= count($templatesResults) ?>)</span></h2>
      <div class="s-table-wrap">
        <table class="s-table">
          <thead><tr><th>Template</th><th>Description</th><th>Price</th><th></th></tr></thead>
          <tbody>
            <?php foreach ($templatesResults as $t): ?>
            <tr>
              <td><strong><?= Security::e($t['title']) ?></strong></td>
              <td class="s-mute"><?= Security::e($t['description']) ?></td>
              <td class="s-mono"><?= $t['is_free'] ? 'Free' : '$' . Security::e(number_format((float)$t['price'], 2)) ?></td>
              <td><a href="<?= url('templates') ?>" class="s-link">View</a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php endif; ?>

    <!-- 5. Default sitelinks when query is empty -->
    <?php if (empty($query)): ?>
    <div class="s-grid" data-reveal>
      <div style="grid-column:span 5">
        <p class="s-eyebrow">Browse</p>
        <h2 class="s-h2 mt-4">Core services and pages.</h2>
      </div>
      <div style="grid-column:span 7">
        <div class="s-list">
          <a href="<?= url('services') ?>"><span class="s-num">01</span><h3 class="s-h3">Technology services</h3><p>Full-stack web apps, mobile, cloud DevOps and cybersecurity.</p></a>
          <a href="<?= url('services#web-security-penetration-testing') ?>"><span class="s-num">02</span><h3 class="s-h3">Web security &amp; VAPT</h3><p>Vulnerability assessment, ethical hacking audits and CVE scoring.</p></a>
          <a href="<?= url('projects') ?>"><span class="s-num">03</span><h3 class="s-h3">Projects &amp; case studies</h3><p>Live platforms including Pandey Reality, Apna Cleaning and more.</p></a>
          <a href="<?= url('templates') ?>"><span class="s-num">04</span><h3 class="s-h3">Website templates</h3><p>Ready-to-deploy responsive HTML5 and PHP business website kits.</p></a>
          <a href="<?= url('about') ?>"><span class="s-num">05</span><h3 class="s-h3">About us</h3><p>Our engineering team, culture and development standards.</p></a>
          <a href="<?= url('contact') ?>"><span class="s-num">06</span><h3 class="s-h3">Contact &amp; quotes</h3><p>Talk to our engineers about a custom project.</p></a>
        </div>
      </div>
    </div>
    <?php endif; ?>

  </div>
</section>

<!-- CTA -->
<section class="s-sec s-band">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 7"><h2 class="s-h2">Can&rsquo;t find what you need?</h2></div>
      <div style="grid-column:span 5">
        <p>Describe the problem and we will tell you whether we can help.</p>
        <div class="s-actions mt-6"><a href="<?= url('contact') ?>" class="s-btn--light">Contact us</a></div>
      </div>
    </div>
  </div>
</section>
