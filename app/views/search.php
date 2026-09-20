<!-- ── SEARCH RESULTS / SITELINKS SEARCHBOX VIEW ──────────────── -->

<div class="relative overflow-hidden hero-mesh-bg pt-28 pb-14 border-b border-slate-800/80">
  <div class="absolute inset-0 hero-grid opacity-15 pointer-events-none"></div>
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-4">
    <div class="inline-flex items-center space-x-2 bg-slate-900/90 border border-eco-500/30 px-3.5 py-1.5 rounded-md text-eco-300 text-xs font-semibold badge-glow">
      <span class="material-icons text-sm text-eco-400">search</span>
      <span>Search Solutions &amp; Case Studies</span>
    </div>
    <h1 class="font-display text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
      Search <span class="text-gradient"><?= APP_NAME ?></span>
    </h1>
    <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto">
      Find web development capabilities, cybersecurity audits, client case studies, and digital templates.
    </p>

    <!-- Search Form -->
    <form action="<?= url('search') ?>" method="GET" class="mt-6 max-w-2xl mx-auto relative flex items-center">
      <div class="relative w-full">
        <span class="material-icons-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-xl pointer-events-none">search</span>
        <input type="text"
               name="q"
               value="<?= Security::e($query) ?>"
               placeholder="Search services, projects, cybersecurity, templates..."
               class="w-full pl-12 pr-28 py-3.5 bg-slate-900/90 border border-slate-800 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-white rounded-lg text-sm sm:text-base outline-none transition-all placeholder:text-slate-500 shadow-inner"
               autocomplete="off"
               required>
        <button type="submit"
                class="absolute right-2 top-1/2 -translate-y-1/2 btn-primary py-2 px-5 text-xs font-semibold rounded-md flex items-center space-x-1.5 cursor-pointer">
          <span>Search</span>
          <span class="material-icons-outlined text-sm">arrow_forward</span>
        </button>
      </div>
    </form>

    <!-- Quick search pills -->
    <div class="flex flex-wrap items-center justify-center gap-2 pt-2 text-xs">
      <span class="text-slate-500">Popular:</span>
      <?php foreach (['Web Development', 'Penetration Testing', 'Mobile Apps', 'Pandey Reality', 'Templates', 'Contact'] as $tag): ?>
      <a href="<?= url('search?q=' . urlencode($tag)) ?>"
         class="px-2.5 py-1 bg-slate-900 border border-slate-800 text-slate-300 hover:text-emerald-300 hover:border-emerald-500/40 rounded-md transition-colors font-mono text-[11px]">
        <?= $tag ?>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<section class="section-padding relative">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

    <?php if (!empty($query)): ?>
      <div class="flex items-center justify-between border-b border-slate-800/80 pb-4">
        <p class="text-sm text-slate-300">
          Showing <span class="text-emerald-400 font-semibold"><?= $totalCount ?></span> results for "<strong class="text-white"><?= Security::e($query) ?></strong>"
        </p>
        <a href="<?= url('search') ?>" class="text-xs text-slate-400 hover:text-emerald-400 transition-colors flex items-center gap-1">
          <span class="material-icons-outlined text-sm">refresh</span> Clear search
        </a>
      </div>
    <?php endif; ?>

    <?php if (!empty($query) && $totalCount === 0): ?>
      <!-- No Results State -->
      <div class="text-center py-16 px-4 bg-slate-900/40 border border-slate-800/80 rounded-xl space-y-4">
        <div class="w-14 h-14 mx-auto bg-slate-800/80 border border-slate-700/60 rounded-lg flex items-center justify-center text-slate-400">
          <span class="material-icons-outlined text-2xl">search_off</span>
        </div>
        <h2 class="text-xl font-display font-bold text-white">No exact matches found</h2>
        <p class="text-slate-400 text-sm max-w-md mx-auto">
          We couldn't find any results matching "<strong><?= Security::e($query) ?></strong>". Try searching for general terms like "web", "security", "mobile", or "portfolio".
        </p>
        <div class="pt-4 flex flex-wrap justify-center gap-3">
          <a href="<?= url('services') ?>" class="btn-primary py-2.5 px-6 text-xs rounded-md">View All Services</a>
          <a href="<?= url('projects') ?>" class="btn-outline py-2.5 px-6 text-xs rounded-md">View Portfolio</a>
          <a href="<?= url('contact') ?>" class="btn-outline py-2.5 px-6 text-xs rounded-md">Contact Us</a>
        </div>
      </div>
    <?php endif; ?>

    <!-- 1. Services Results -->
    <?php if (!empty($servicesResults)): ?>
    <div class="space-y-4">
      <div class="flex items-center space-x-2 text-emerald-400 border-b border-slate-800/80 pb-2">
        <span class="material-icons-outlined text-lg">miscellaneous_services</span>
        <h2 class="text-base font-display font-bold text-white uppercase tracking-wider text-xs">Matching Services (<?= count($servicesResults) ?>)</h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php foreach ($servicesResults as $sv): ?>
        <a href="<?= url('services#' . $sv['slug']) ?>" class="p-5 bg-slate-900/70 hover:bg-slate-900 border border-slate-800/90 hover:border-emerald-500/40 rounded-lg transition-all flex flex-col justify-between group">
          <div>
            <div class="flex items-center justify-between mb-2">
              <h3 class="text-base font-bold text-white group-hover:text-emerald-300 transition-colors flex items-center gap-2">
                <i class="fas <?= Security::e($sv['icon']) ?> text-sm text-emerald-400"></i>
                <span><?= Security::e($sv['title']) ?></span>
              </h3>
              <span class="text-[10px] font-mono text-emerald-400 bg-emerald-950/60 border border-emerald-500/30 px-2 py-0.5 rounded">Service</span>
            </div>
            <p class="text-xs text-slate-400 leading-relaxed line-clamp-2">
              <?= Security::e($sv['description']) ?>
            </p>
          </div>
          <div class="mt-4 pt-3 border-t border-slate-800/60 flex items-center justify-between text-xs text-emerald-400 font-semibold">
            <span>Explore Service Details</span>
            <span class="material-icons-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- 2. Projects / Portfolio Results -->
    <?php if (!empty($projectsResults)): ?>
    <div class="space-y-4">
      <div class="flex items-center space-x-2 text-blue-400 border-b border-slate-800/80 pb-2">
        <span class="material-icons-outlined text-lg">work</span>
        <h2 class="text-base font-display font-bold text-white uppercase tracking-wider text-xs">Portfolio Case Studies (<?= count($projectsResults) ?>)</h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php foreach ($projectsResults as $p): ?>
        <div class="p-4 bg-slate-900/70 border border-slate-800/90 hover:border-blue-500/40 rounded-lg transition-all flex gap-4 group">
          <div class="w-24 h-20 bg-slate-950 rounded-md overflow-hidden shrink-0">
            <img src="<?= uploadUrl(!empty($p['thumbnail']) ? $p['thumbnail'] : 'project_startup_landing.png') ?>"
                 alt="<?= Security::e($p['title']) ?>"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                 loading="lazy">
          </div>
          <div class="flex flex-col justify-between flex-grow">
            <div>
              <div class="flex items-center justify-between">
                <h3 class="text-sm font-bold text-white group-hover:text-blue-300 transition-colors line-clamp-1">
                  <?= Security::e($p['title']) ?>
                </h3>
                <span class="text-[10px] font-mono text-blue-400 bg-blue-950/60 border border-blue-500/30 px-1.5 py-0.5 rounded">
                  <?= Security::e(ucfirst($p['category'])) ?>
                </span>
              </div>
              <p class="text-xs text-slate-400 line-clamp-1 mt-1">
                <?= Security::e($p['description']) ?>
              </p>
            </div>
            <div class="pt-2 flex items-center justify-between text-xs">
              <a href="<?= url('projects/view?slug=' . urlencode($p['slug'])) ?>" class="text-blue-400 hover:text-blue-300 font-semibold flex items-center gap-1">
                <span>View Case Study</span>
                <span class="material-icons-outlined text-xs">arrow_forward</span>
              </a>
              <?php if (!empty($p['live_url'])): ?>
              <a href="<?= Security::e($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white flex items-center gap-1 text-[11px]">
                <span>Live Site</span>
                <span class="material-icons-outlined text-xs">open_in_new</span>
              </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- 3. Core Pages Results -->
    <?php if (!empty($pagesResults)): ?>
    <div class="space-y-4">
      <div class="flex items-center space-x-2 text-purple-400 border-b border-slate-800/80 pb-2">
        <span class="material-icons-outlined text-lg">alt_route</span>
        <h2 class="text-base font-display font-bold text-white uppercase tracking-wider text-xs">Matching Company Pages (<?= count($pagesResults) ?>)</h2>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        <?php foreach ($pagesResults as $cp): ?>
        <a href="<?= $cp['url'] ?>" class="p-4 bg-slate-900/60 hover:bg-slate-900 border border-slate-800 hover:border-purple-500/40 rounded-lg transition-all group block">
          <div class="flex items-center justify-between mb-1.5">
            <h3 class="text-sm font-bold text-white group-hover:text-purple-300 transition-colors">
              <?= $cp['title'] ?>
            </h3>
            <span class="material-icons-outlined text-slate-500 group-hover:text-purple-400 text-sm transition-colors">north_east</span>
          </div>
          <p class="text-xs text-slate-400 line-clamp-2">
            <?= $cp['desc'] ?>
          </p>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- 4. Templates Results -->
    <?php if (!empty($templatesResults)): ?>
    <div class="space-y-4">
      <div class="flex items-center space-x-2 text-amber-400 border-b border-slate-800/80 pb-2">
        <span class="material-icons-outlined text-lg">dashboard_customize</span>
        <h2 class="text-base font-display font-bold text-white uppercase tracking-wider text-xs">Website Templates (<?= count($templatesResults) ?>)</h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <?php foreach ($templatesResults as $t): ?>
        <div class="p-4 bg-slate-900/70 border border-slate-800 rounded-lg flex flex-col justify-between">
          <div>
            <h3 class="text-sm font-bold text-white mb-1"><?= Security::e($t['title']) ?></h3>
            <p class="text-xs text-slate-400 line-clamp-2 mb-3"><?= Security::e($t['description']) ?></p>
          </div>
          <div class="flex items-center justify-between pt-2 border-t border-slate-800/80 text-xs">
            <span class="font-mono text-amber-400"><?= $t['is_free'] ? 'Free' : '$' . number_format($t['price'], 2) ?></span>
            <a href="<?= url('templates') ?>" class="text-slate-300 hover:text-white font-semibold">View Templates &rarr;</a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- 5. Default Top Sitelinks Grid (Shown when query is empty or for direct navigation) -->
    <?php if (empty($query)): ?>
    <div class="space-y-6 pt-4">
      <div class="text-center max-w-xl mx-auto space-y-2">
        <h2 class="text-xl font-display font-bold text-white">Top Website Portals &amp; Core Services</h2>
        <p class="text-xs text-slate-400">Quickly navigate to verified EcoTech Service engineering verticals.</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="<?= url('services') ?>" class="p-5 bg-slate-900/70 hover:bg-slate-900 border border-slate-800/80 hover:border-emerald-500/40 rounded-lg transition-all group block">
          <div class="w-10 h-10 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-md flex items-center justify-center mb-3">
            <span class="material-icons-outlined text-xl">miscellaneous_services</span>
          </div>
          <h3 class="font-display font-bold text-base text-white group-hover:text-emerald-300 transition-colors">Technology Services</h3>
          <p class="text-xs text-slate-400 mt-1">Full-stack web apps, mobile solutions, cloud DevOps, and cybersecurity.</p>
        </a>

        <a href="<?= url('services#web-security-penetration-testing') ?>" class="p-5 bg-slate-900/70 hover:bg-slate-900 border border-slate-800/80 hover:border-amber-500/40 rounded-lg transition-all group block">
          <div class="w-10 h-10 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-md flex items-center justify-center mb-3">
            <span class="material-icons-outlined text-xl">security</span>
          </div>
          <h3 class="font-display font-bold text-base text-white group-hover:text-amber-300 transition-colors">Web Security &amp; VAPT</h3>
          <p class="text-xs text-slate-400 mt-1">Vulnerability assessment, ethical hacking audits, and CVE scoring.</p>
        </a>

        <a href="<?= url('projects') ?>" class="p-5 bg-slate-900/70 hover:bg-slate-900 border border-slate-800/80 hover:border-blue-500/40 rounded-lg transition-all group block">
          <div class="w-10 h-10 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-md flex items-center justify-center mb-3">
            <span class="material-icons-outlined text-xl">work</span>
          </div>
          <h3 class="font-display font-bold text-base text-white group-hover:text-blue-300 transition-colors">Portfolio &amp; Case Studies</h3>
          <p class="text-xs text-slate-400 mt-1">Verified live platforms including Pandey Reality, Apna Cleaning, and more.</p>
        </a>

        <a href="<?= url('templates') ?>" class="p-5 bg-slate-900/70 hover:bg-slate-900 border border-slate-800/80 hover:border-cyan-500/40 rounded-lg transition-all group block">
          <div class="w-10 h-10 bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 rounded-md flex items-center justify-center mb-3">
            <span class="material-icons-outlined text-xl">dashboard_customize</span>
          </div>
          <h3 class="font-display font-bold text-base text-white group-hover:text-cyan-300 transition-colors">Website Templates</h3>
          <p class="text-xs text-slate-400 mt-1">Ready-to-deploy HTML5 &amp; PHP responsive business website kits.</p>
        </a>

        <a href="<?= url('about') ?>" class="p-5 bg-slate-900/70 hover:bg-slate-900 border border-slate-800/80 hover:border-purple-500/40 rounded-lg transition-all group block">
          <div class="w-10 h-10 bg-purple-500/10 border border-purple-500/20 text-purple-400 rounded-md flex items-center justify-center mb-3">
            <span class="material-icons-outlined text-xl">info</span>
          </div>
          <h3 class="font-display font-bold text-base text-white group-hover:text-purple-300 transition-colors">About Us</h3>
          <p class="text-xs text-slate-400 mt-1">Our engineering team, company culture, and development standards.</p>
        </a>

        <a href="<?= url('contact') ?>" class="p-5 bg-slate-900/70 hover:bg-slate-900 border border-slate-800/80 hover:border-rose-500/40 rounded-lg transition-all group block">
          <div class="w-10 h-10 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-md flex items-center justify-center mb-3">
            <span class="material-icons-outlined text-xl">mail</span>
          </div>
          <h3 class="font-display font-bold text-base text-white group-hover:text-rose-300 transition-colors">Contact &amp; Quotes</h3>
          <p class="text-xs text-slate-400 mt-1">Get in touch with our engineers for custom project consultations.</p>
        </a>
      </div>
    </div>
    <?php endif; ?>

  </div>
</section>
