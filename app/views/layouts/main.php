<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php $resolvedCanonicalUrl = canonicalUrl($canonicalPath ?? null); ?>
  <title><?= Security::e($pageTitle ?? APP_NAME) ?></title>
  <meta name="description" content="<?= Security::e($metaDescription ?? setting('meta_description')) ?>">
  <?php if (!empty($robotsMeta)): ?>
  <meta name="robots" content="<?= Security::e($robotsMeta) ?>">
  <?php endif; ?>
  <?php if (!empty($metaKeywords)): ?>
  <meta name="keywords" content="<?= Security::e($metaKeywords) ?>">
  <?php endif; ?>
  <link rel="canonical" href="<?= Security::e($resolvedCanonicalUrl) ?>">

  <!-- Open Graph -->
  <meta property="og:title"       content="<?= Security::e($pageTitle ?? APP_NAME) ?>">
  <meta property="og:description" content="<?= Security::e($metaDescription ?? setting('meta_description')) ?>">
  <meta property="og:type"        content="<?= Security::e($ogType ?? 'website') ?>">
  <meta property="og:url"         content="<?= Security::e($resolvedCanonicalUrl) ?>">
  <meta property="og:site_name"   content="<?= Security::e(APP_NAME) ?>">
  <meta property="og:locale"      content="en_US">
  <?php if (!empty($ogImage)): ?>
  <meta property="og:image"       content="<?= Security::e($ogImage) ?>">
  <?php endif; ?>
  <meta name="twitter:card" content="<?= !empty($ogImage) ? 'summary_large_image' : 'summary' ?>">
  <meta name="twitter:title" content="<?= Security::e($pageTitle ?? APP_NAME) ?>">
  <meta name="twitter:description" content="<?= Security::e($metaDescription ?? setting('meta_description')) ?>">

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="<?= url('assets/img/favicon.svg?v=2') ?>">
  <link rel="alternate icon" href="<?= url('assets/img/favicon.svg?v=2') ?>">
  <link rel="apple-touch-icon" href="<?= url('assets/img/favicon.svg?v=2') ?>">

  <!-- Google Fonts & Material Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined|Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            eco: {
              50:  '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0',
              300: '#86efac', 400: '#4ade80', 500: '#22c55e',
              600: '#16a34a', 700: '#15803d', 800: '#166534',
              900: '#14532d', 950: '#052e16',
            }
          },
          fontFamily: {
            sans:    ['Inter', 'system-ui', 'sans-serif'],
            display: ['Space Grotesk', 'Inter', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Custom CSS (with cache-busting timestamp) -->
  <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/css/style.css') ? filemtime(PUBLIC_PATH . '/assets/css/style.css') : '2.0' ?>">

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-YDLMY8N3C4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-YDLMY8N3C4');
  </script>

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-M86QQPKV');</script>
  <!-- End Google Tag Manager -->

  <!-- ── Page Loader CSS ──────────────────────────────────────── -->
  <style>
    #page-loader {
      position: fixed;
      inset: 0;
      z-index: 9999;
      background: #030712;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 1.5rem;
      transition: opacity 0.5s ease, visibility 0.5s ease;
    }
    #page-loader.loader-hidden {
      opacity: 0;
      visibility: hidden;
      pointer-events: none;
    }
    .loader-logo {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      animation: loaderPulse 1.4s ease-in-out infinite;
    }
    .loader-logo-icon {
      width: 42px;
      height: 42px;
      border-radius: 10px;
      background: #0f1a12;
      border: 1px solid rgba(74,222,128,0.25);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 6px;
    }
    .loader-logo-icon img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }
    .loader-logo-text {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 1.3rem;
      font-weight: 700;
      color: #f9fafb;
      letter-spacing: -0.01em;
    }
    .loader-logo-text span { color: #4ade80; }
    /* Spinner ring */
    .loader-ring {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      border: 2.5px solid rgba(74,222,128,0.12);
      border-top-color: #4ade80;
      animation: loaderSpin 0.85s linear infinite;
    }
    /* Dots progress bar */
    .loader-dots {
      display: flex;
      gap: 6px;
    }
    .loader-dots span {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: rgba(74,222,128,0.25);
      animation: loaderDot 1.2s ease-in-out infinite;
    }
    .loader-dots span:nth-child(2) { animation-delay: 0.2s; }
    .loader-dots span:nth-child(3) { animation-delay: 0.4s; }
    @keyframes loaderSpin {
      to { transform: rotate(360deg); }
    }
    @keyframes loaderPulse {
      0%, 100% { opacity: 1; }
      50%       { opacity: 0.6; }
    }
    @keyframes loaderDot {
      0%, 80%, 100% { background: rgba(74,222,128,0.2); transform: scale(0.8); }
      40%           { background: #4ade80;               transform: scale(1.3); }
    }
    /* Freeze scroll while loading */
    body.loading { overflow: hidden; }
  </style>
</head>
<body class="bg-gray-950 text-gray-100 font-sans antialiased loading">

  <!-- ── Page Loader ───────────────────────────────────────────── -->
  <div id="page-loader" role="status" aria-label="Loading">
    <div class="loader-logo">
      <img src="<?= url('assets/img/logo.png') ?>" alt="EcoTech Services" loading="eager"
           style="height:70px;width:auto;object-fit:contain;mix-blend-mode:screen;filter:brightness(1.3) contrast(1.1);">
    </div>
    <div class="loader-ring"></div>
    <div class="loader-dots">
      <span></span><span></span><span></span>
    </div>
  </div>

  <!-- Custom Pointer Cursor -->
  <div id="customCursor"></div>
  <div id="customCursorDot"></div>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M86QQPKV"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <!-- ══ ONE SIMPLE UNIFIED NAVBAR ════════════════════════════════════ -->
  <header id="navbar" class="site-navbar fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
      <div class="flex items-center justify-between h-[76px] md:h-[84px] lg:h-[88px]">

        <!-- ── 1. Company Logo (Significantly Increased Size) ──────────── -->
        <a href="<?= url() ?>" class="site-logo-link flex items-center shrink-0 py-1" aria-label="EcoTech Services Home">
          <img src="<?= url('assets/img/logo.png') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/img/logo.png') ? filemtime(PUBLIC_PATH . '/assets/img/logo.png') : '3' ?>"
               alt="EcoTech Services"
               class="site-logo"
               loading="eager">
        </a>

        <!-- ── 2. Center Nav Links (Desktop — Clean Rectangular, Material UI Icons) ── -->
        <nav class="hidden lg:flex items-center gap-1 xl:gap-2" aria-label="Main Navigation">
          <?php
          $current = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
          $base    = trim(parse_url(APP_URL, PHP_URL_PATH) ?? '', '/') . '/public/';
          $page    = str_replace($base, '', $current);

          $navItems = [
            ''          => ['label' => 'Home',      'icon' => 'home'],
            'about'     => ['label' => 'About',     'icon' => 'info'],
            'services'  => ['label' => 'Services',  'icon' => 'miscellaneous_services', 'hasDropdown' => true],
            'projects'  => ['label' => 'Portfolio', 'icon' => 'work_outline'],
            'templates' => ['label' => 'Templates', 'icon' => 'dashboard_customize'],
            'blog'      => ['label' => 'Blog',      'icon' => 'article'],
            'contact'   => ['label' => 'Contact',   'icon' => 'mail_outline'],
          ];

          foreach ($navItems as $path => $item):
            $isActive = ($page === $path);
            $hasDropdown = !empty($item['hasDropdown']);
          ?>

          <?php if ($hasDropdown): ?>
          <!-- Services Dropdown (Rectangular styling, No circular design) -->
          <div class="nav-dropdown-wrapper relative group" id="servicesDropdown">
            <a href="<?= url('services') ?>"
               class="nav-link <?= $isActive ? 'nav-link-active' : '' ?>"
               aria-expanded="false"
               aria-haspopup="true">
              <span class="material-icons-outlined nav-link-icon"><?= $item['icon'] ?></span>
              <span class="nav-link-text"><?= $item['label'] ?></span>
              <span class="material-icons-outlined nav-dropdown-arrow transition-transform duration-200 group-hover:rotate-180">expand_more</span>
            </a>

            <!-- Dropdown Panel (Sleek rectangular card, rounded-md) -->
            <div class="nav-dropdown-menu absolute top-full left-1/2 -translate-x-1/2 pt-2 opacity-0 invisible pointer-events-none group-hover:opacity-100 group-hover:visible group-hover:pointer-events-auto transition-all duration-200 transform translate-y-1 group-hover:translate-y-0 z-50">
              <div class="nav-dropdown-box w-[520px] p-4 bg-[#070d18]/95 backdrop-blur-xl border border-slate-800 shadow-2xl rounded-md">
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-800/80 px-2">
                  <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                    <span class="material-icons-outlined text-sm text-eco-400">layers</span>
                    Engineering &amp; IT Solutions
                  </span>
                  <span class="text-[11px] text-slate-500 font-medium">Enterprise Grade</span>
                </div>

                <div class="grid grid-cols-2 gap-2">
                  <a href="<?= url('services#web') ?>" class="nav-dropdown-item group/item">
                    <div class="nav-drop-icon bg-eco-500/10 border border-eco-500/20 text-eco-400 group-hover/item:bg-eco-500/20 group-hover/item:border-eco-500/40">
                      <span class="material-icons-outlined text-base">code</span>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-slate-200 group-hover/item:text-white">Web Development</div>
                      <div class="text-[11px] text-slate-400 line-clamp-1">Enterprise apps &amp; portals</div>
                    </div>
                  </a>

                  <a href="<?= url('services#mobile') ?>" class="nav-dropdown-item group/item">
                    <div class="nav-drop-icon bg-blue-500/10 border border-blue-500/20 text-blue-400 group-hover/item:bg-blue-500/20 group-hover/item:border-blue-500/40">
                      <span class="material-icons-outlined text-base">smartphone</span>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-slate-200 group-hover/item:text-white">Mobile Apps</div>
                      <div class="text-[11px] text-slate-400 line-clamp-1">iOS, Android &amp; Flutter</div>
                    </div>
                  </a>

                  <a href="<?= url('services#cloud') ?>" class="nav-dropdown-item group/item">
                    <div class="nav-drop-icon bg-purple-500/10 border border-purple-500/20 text-purple-400 group-hover/item:bg-purple-500/20 group-hover/item:border-purple-500/40">
                      <span class="material-icons-outlined text-base">cloud</span>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-slate-200 group-hover/item:text-white">Cloud &amp; DevOps</div>
                      <div class="text-[11px] text-slate-400 line-clamp-1">AWS, GCP &amp; CI/CD</div>
                    </div>
                  </a>

                  <a href="<?= url('services#security') ?>" class="nav-dropdown-item group/item">
                    <div class="nav-drop-icon bg-amber-500/10 border border-amber-500/20 text-amber-400 group-hover/item:bg-amber-500/20 group-hover/item:border-amber-500/40">
                      <span class="material-icons-outlined text-base">security</span>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-slate-200 group-hover/item:text-white">Web Security &amp; VAPT</div>
                      <div class="text-[11px] text-slate-400 line-clamp-1">OWASP audits &amp; pen-testing</div>
                    </div>
                  </a>

                  <a href="<?= url('services#seo') ?>" class="nav-dropdown-item group/item">
                    <div class="nav-drop-icon bg-rose-500/10 border border-rose-500/20 text-rose-400 group-hover/item:bg-rose-500/20 group-hover/item:border-rose-500/40">
                      <span class="material-icons-outlined text-base">trending_up</span>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-slate-200 group-hover/item:text-white">SEO &amp; Marketing</div>
                      <div class="text-[11px] text-slate-400 line-clamp-1">Growth &amp; search rankings</div>
                    </div>
                  </a>

                  <a href="<?= url('services#design') ?>" class="nav-dropdown-item group/item">
                    <div class="nav-drop-icon bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 group-hover/item:bg-cyan-500/20 group-hover/item:border-cyan-500/40">
                      <span class="material-icons-outlined text-base">palette</span>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-slate-200 group-hover/item:text-white">UI/UX Design</div>
                      <div class="text-[11px] text-slate-400 line-clamp-1">Design systems &amp; prototypes</div>
                    </div>
                  </a>
                </div>

                <div class="mt-3 pt-3 border-t border-slate-800/80 flex items-center justify-between px-2">
                  <a href="<?= url('services') ?>" class="text-xs font-semibold text-eco-400 hover:text-eco-300 flex items-center gap-1.5 transition-colors">
                    <span>View All Services</span>
                    <span class="material-icons-outlined text-sm">arrow_forward</span>
                  </a>
                  <a href="<?= url('contact') ?>" class="text-[11px] font-semibold text-slate-300 bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700 px-2.5 py-1 rounded-sm flex items-center gap-1 transition-colors">
                    <span class="material-icons-outlined text-xs text-amber-400">bolt</span>
                    <span>Free Tech Consultation</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <?php else: ?>
          <a href="<?= url($path) ?>"
             class="nav-link <?= $isActive ? 'nav-link-active' : '' ?>">
            <span class="material-icons-outlined nav-link-icon"><?= $item['icon'] ?></span>
            <span class="nav-link-text"><?= $item['label'] ?></span>
          </a>
          <?php endif; ?>
          <?php endforeach; ?>
        </nav>

        <!-- ── 3. Right Action Buttons (Rectangular, Strictly No Circular Design) ── -->
        <div class="flex items-center gap-2.5">
          <!-- WhatsApp Button (Desktop - Clean Rectangular) -->
          <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20project."
             target="_blank"
             class="hidden sm:inline-flex nav-btn-whatsapp"
             aria-label="Chat on WhatsApp">
            <span class="nav-status-square"></span>
            <span class="material-icons-outlined text-base">chat</span>
            <span>WhatsApp</span>
          </a>

          <!-- Primary CTA Button (Clean Rectangular) -->
          <a href="<?= url('contact') ?>" class="hidden md:inline-flex nav-btn-primary">
            <span>Get a Quote</span>
            <span class="material-icons-outlined text-sm">arrow_forward</span>
          </a>

          <!-- Mobile WhatsApp Icon Button (Square, No circle) -->
          <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20project."
             target="_blank"
             class="sm:hidden nav-icon-btn-whatsapp"
             aria-label="WhatsApp">
            <span class="material-icons-outlined text-lg">chat</span>
          </a>

          <!-- Mobile Hamburger Toggle Button (Clean Square, No circle) -->
          <button id="mobileDrawerOpen" type="button" aria-label="Open Navigation Menu"
                  class="lg:hidden nav-toggle-btn">
            <span class="material-icons-outlined text-2xl text-slate-200">menu</span>
          </button>
        </div>

      </div>
    </div>
  </header>

  <!-- ══ MOBILE DRAWER MENU (Responsive Slide Panel) ══════════════════ -->
  <div id="mobileDrawer" class="fixed inset-0 z-[60] lg:hidden" style="visibility:hidden;">
    <!-- Backdrop Overlay -->
    <div id="mobileDrawerOverlay" class="absolute inset-0 bg-black/75 backdrop-blur-sm transition-opacity"></div>

    <!-- Slide Panel (Clean Rectangular, No circular design) -->
    <div id="mobileDrawerContent"
         class="absolute top-0 right-0 bottom-0 w-[84%] max-w-[320px] bg-[#050a14] border-l border-slate-800 flex flex-col overflow-y-auto transform translate-x-full transition-transform duration-300 ease-out">

      <!-- Drawer Header (Enlarged Logo + Rectangular Close Button) -->
      <div class="p-4 border-b border-slate-800/80 flex items-center justify-between bg-slate-950/50">
        <a href="<?= url() ?>" class="flex items-center" aria-label="EcoTech Services">
          <img src="<?= url('assets/img/logo.png') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/img/logo.png') ? filemtime(PUBLIC_PATH . '/assets/img/logo.png') : '3' ?>"
               alt="EcoTech Services"
               class="site-logo-mobile"
               loading="eager">
        </a>
        <button id="mobileDrawerClose" type="button" aria-label="Close menu"
                class="w-9 h-9 rounded-md bg-slate-900 border border-slate-800 text-slate-400 hover:text-white hover:bg-slate-800 flex items-center justify-center transition-colors">
          <span class="material-icons-outlined text-xl">close</span>
        </button>
      </div>

      <!-- Drawer Nav Links (With Material UI Icons, Rectangular Cards) -->
      <nav class="p-3 flex-1 space-y-1">
        <?php
        $mobileDrawerList = [
          ['path' => '',          'label' => 'Home',         'icon' => 'home',                   'desc' => 'Main landing page'],
          ['path' => 'about',     'label' => 'About Us',     'icon' => 'info',                   'desc' => 'Company & mission'],
          ['path' => 'services',  'label' => 'Services',     'icon' => 'miscellaneous_services', 'desc' => 'IT & Engineering solutions'],
          ['path' => 'projects',  'label' => 'Portfolio',    'icon' => 'work_outline',           'desc' => 'Client work & case studies'],
          ['path' => 'templates', 'label' => 'Templates',    'icon' => 'dashboard_customize',   'desc' => 'Ready software systems'],
          ['path' => 'blog',      'label' => 'Blog & News',  'icon' => 'article',                'desc' => 'Technical insights'],
          ['path' => 'contact',   'label' => 'Contact Us',   'icon' => 'mail_outline',           'desc' => 'Reach our engineering team'],
        ];

        foreach ($mobileDrawerList as $mItem):
          $isActive = ($page === $mItem['path']);
        ?>
        <a href="<?= url($mItem['path']) ?>"
           class="flex items-center gap-3 p-2.5 rounded-md border transition-colors <?= $isActive ? 'bg-eco-500/10 border-eco-500/30 text-eco-400' : 'border-transparent text-slate-300 hover:bg-slate-900/80 hover:border-slate-800' ?>">
          <div class="w-9 h-9 rounded-md flex items-center justify-center shrink-0 <?= $isActive ? 'bg-eco-500/20 text-eco-400 border border-eco-500/40' : 'bg-slate-900 border border-slate-800 text-slate-400' ?>">
            <span class="material-icons-outlined text-lg"><?= $mItem['icon'] ?></span>
          </div>
          <div class="flex-1 min-w-0">
            <div class="text-sm font-semibold <?= $isActive ? 'text-eco-400' : 'text-slate-200' ?>"><?= $mItem['label'] ?></div>
            <div class="text-[11px] text-slate-500 truncate"><?= $mItem['desc'] ?></div>
          </div>
          <span class="material-icons-outlined text-base text-slate-600">chevron_right</span>
        </a>
        <?php endforeach; ?>
      </nav>

      <!-- Drawer Bottom Actions (Clean Rectangular, No circles) -->
      <div class="p-4 border-t border-slate-800/80 space-y-2.5 bg-slate-950/60">
        <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20project."
           target="_blank"
           class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-md bg-[#25D366] hover:bg-[#20ba59] text-white font-semibold text-xs tracking-wide shadow-md transition-colors">
          <span class="material-icons-outlined text-base">chat</span>
          <span>Chat on WhatsApp</span>
        </a>
        <a href="<?= url('contact') ?>"
           class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-md bg-eco-500/15 hover:bg-eco-500/25 border border-eco-500/30 text-eco-400 font-semibold text-xs tracking-wide transition-colors">
          <span>Request Free Quote</span>
          <span class="material-icons-outlined text-sm">arrow_forward</span>
        </a>
      </div>
    </div>
  </div>

  <!-- ══ ONE SIMPLE NAVBAR CSS ═════════════════════════════════════════ -->
  <style>
    /* ── One Simple Navbar Styling ───────────────────── */
    .site-navbar {
      background: rgba(3, 7, 18, 0.95);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.4);
    }
    .site-navbar.scrolled {
      background: rgba(2, 6, 14, 0.98);
      border-bottom: 1px solid rgba(255, 255, 255, 0.12);
      box-shadow: 0 6px 28px rgba(0, 0, 0, 0.6);
    }

    /* ── Company Logo Size (Significantly Enlarged) ─── */
    .site-logo {
      height: 78px;
      max-height: 80px;
      width: auto;
      object-fit: contain;
      mix-blend-mode: screen;
      filter: brightness(1.35) contrast(1.18);
      display: block;
      transition: transform 0.2s ease;
      transform: scale(1.16);
      transform-origin: left center;
    }
    .site-logo:hover {
      transform: scale(1.2);
    }
    .site-logo-mobile {
      height: 62px;
      max-height: 64px;
      width: auto;
      object-fit: contain;
      mix-blend-mode: screen;
      filter: brightness(1.35) contrast(1.18);
      display: block;
      transform: scale(1.12);
      transform-origin: left center;
    }
    @media (max-width: 768px) {
      .site-logo {
        height: 62px;
        max-height: 64px;
        transform: scale(1.12);
      }
    }

    /* ── Desktop Nav Links (No circular design) ──────── */
    .nav-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 12px;
      border-radius: 6px; /* Rectangular subtle rounded */
      border: 1px solid transparent;
      color: #94a3b8;
      font-size: 13.5px;
      font-weight: 500;
      text-decoration: none;
      transition: all 0.18s ease;
      white-space: nowrap;
    }
    .nav-link:hover {
      color: #ffffff;
      background: rgba(255, 255, 255, 0.06);
      border-color: rgba(255, 255, 255, 0.1);
    }
    .nav-link-active {
      color: #4ade80 !important;
      background: rgba(74, 222, 128, 0.08) !important;
      border-color: rgba(74, 222, 128, 0.25) !important;
      font-weight: 600 !important;
    }
    .nav-link-icon {
      font-size: 18px !important;
      line-height: 1 !important;
      vertical-align: middle;
      color: inherit;
    }
    .nav-dropdown-arrow {
      font-size: 16px !important;
      line-height: 1 !important;
      opacity: 0.7;
    }

    /* ── Dropdown Item ───────────────────────────────── */
    .nav-dropdown-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 10px;
      border-radius: 6px;
      border: 1px solid transparent;
      text-decoration: none;
      transition: all 0.15s ease;
    }
    .nav-dropdown-item:hover {
      background: rgba(255, 255, 255, 0.05);
      border-color: rgba(255, 255, 255, 0.08);
    }
    .nav-drop-icon {
      width: 32px;
      height: 32px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      transition: all 0.15s ease;
    }

    /* ── Action Buttons (No circular design) ─────────── */
    .nav-btn-whatsapp {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 8px 14px;
      border-radius: 6px; /* NO circle */
      background: rgba(37, 211, 102, 0.08);
      border: 1px solid rgba(37, 211, 102, 0.28);
      color: #25D366;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s ease;
      white-space: nowrap;
    }
    .nav-btn-whatsapp:hover {
      background: rgba(37, 211, 102, 0.16);
      border-color: rgba(37, 211, 102, 0.45);
      color: #4ade80;
    }
    .nav-status-square {
      width: 7px;
      height: 7px;
      border-radius: 2px; /* square status dot, strictly not circular */
      background: #22c55e;
      box-shadow: 0 0 6px #22c55e;
    }

    .nav-btn-primary {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      border-radius: 6px; /* NO circle */
      background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
      border: 1px solid rgba(74, 222, 128, 0.35);
      color: #ffffff;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      box-shadow: 0 2px 10px rgba(22, 163, 74, 0.25);
      transition: all 0.2s ease;
      white-space: nowrap;
    }
    .nav-btn-primary:hover {
      background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
      border-color: rgba(74, 222, 128, 0.6);
      box-shadow: 0 4px 16px rgba(34, 197, 94, 0.4);
      color: #ffffff;
      transform: translateY(-1px);
    }

    .nav-icon-btn-whatsapp {
      width: 38px;
      height: 38px;
      border-radius: 6px;
      background: rgba(37, 211, 102, 0.1);
      border: 1px solid rgba(37, 211, 102, 0.25);
      color: #25D366;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
    }

    .nav-toggle-btn {
      width: 38px;
      height: 38px;
      border-radius: 6px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .nav-toggle-btn:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: rgba(255, 255, 255, 0.2);
    }

    /* ── Responsive Display Rules (Strict Specificity) ── */
    @media (max-width: 1023px) {
      .site-navbar .nav-btn-whatsapp,
      .site-navbar .nav-btn-primary {
        display: none !important;
      }
      .site-navbar .nav-icon-btn-whatsapp,
      .site-navbar .nav-toggle-btn {
        display: flex !important;
      }
    }
    @media (min-width: 1024px) {
      .site-navbar .nav-btn-whatsapp,
      .site-navbar .nav-btn-primary {
        display: inline-flex !important;
      }
      .site-navbar .nav-icon-btn-whatsapp,
      .site-navbar .nav-toggle-btn {
        display: none !important;
      }
    }

    /* Laptop screens: slightly more compact links to fit without scroll */
    @media (min-width: 1024px) and (max-width: 1279px) {
      .site-navbar .nav-link {
        padding: 6px 8px;
        font-size: 12.5px;
        gap: 4px;
      }
      .site-navbar .nav-link-icon {
        font-size: 16px !important;
      }
      .site-navbar .nav-btn-whatsapp {
        padding: 6px 10px;
        font-size: 12px;
      }
      .site-navbar .nav-btn-primary {
        padding: 6px 12px;
        font-size: 12px;
      }
    }

    /* ── Mobile Drawer Open/Close Transitions ────────── */
    #mobileDrawer.active {
      visibility: visible !important;
    }
    #mobileDrawer.active #mobileDrawerContent {
      transform: translateX(0);
    }
    #mobileDrawer.open {
      visibility: visible !important;
    }
    #mobileDrawer.open #mobileDrawerContent {
      transform: translateX(0);
    }

    /* Material icons inline baseline fix */
    .material-icons,
    .material-icons-outlined,
    .material-symbols-outlined {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      vertical-align: middle;
      line-height: 1;
    }
  </style>

  <!-- ── Flash Messages ── -->


  <?php if (hasFlash('success')): ?>
  <div id="flashMsg" class="fixed top-24 right-4 z-50 flex items-center space-x-3 bg-eco-500 text-white px-5 py-3 rounded-xl shadow-xl shadow-eco-500/30 animate-slideIn">
    <i class="fas fa-check-circle text-lg"></i>
    <span class="text-sm font-medium"><?= Security::e(getFlash('success')) ?></span>
    <button onclick="this.parentElement.remove()" class="ml-2 text-white/70 hover:text-white"><i class="fas fa-times"></i></button>
  </div>
  <?php endif; ?>
  <?php if (hasFlash('error')): ?>
  <div id="flashMsg" class="fixed top-24 right-4 z-50 flex items-center space-x-3 bg-red-500 text-white px-5 py-3 rounded-xl shadow-xl shadow-red-500/30 animate-slideIn">
    <i class="fas fa-exclamation-circle text-lg"></i>
    <span class="text-sm font-medium"><?= Security::e(getFlash('error')) ?></span>
    <button onclick="this.parentElement.remove()" class="ml-2 text-white/70 hover:text-white"><i class="fas fa-times"></i></button>
  </div>
  <?php endif; ?>

  <!-- ── Page Content ── -->
  <main>
    <?= $content ?>
  </main>

  <!-- ── Ultra-Modern Footer ── -->
  <footer class="bg-slate-950 border-t border-slate-800/80 mt-24 relative overflow-hidden text-slate-300">
    <!-- Top Glow Line -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-3/4 h-[1px] bg-gradient-to-r from-transparent via-eco-500/50 to-transparent"></div>
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-eco-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12 relative z-10">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10">

        <!-- Column 1: Brand & Bio (Span 4) -->
        <div class="lg:col-span-4 space-y-5">
          <a href="<?= url() ?>" class="inline-block group">
            <img src="<?= url('assets/img/logo.png') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/img/logo.png') ? filemtime(PUBLIC_PATH . '/assets/img/logo.png') : '2.0' ?>" alt="Ecotech Service Logo" class="h-14 w-auto object-contain transition-opacity duration-300 group-hover:opacity-95" loading="lazy">
          </a>
          <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
            <?= Security::e(setting('site_tagline') ?: 'Sustainable Digital Engineering & Web Development') ?>. We build high-performance web systems, custom software, and scalable digital solutions for modern businesses.
          </p>

          <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-slate-900 border border-slate-800 text-xs text-eco-400 font-medium">
            <span class="w-2 h-2 rounded-full bg-eco-400 animate-pulse"></span>
            <span>Sustainable &amp; Eco-Friendly Cloud Engineering</span>
          </div>

          <!-- Social Media Pills -->
          <div class="flex items-center space-x-2.5 pt-2">
            <?php 
            $socials = [
              'facebook'  => ['icon' => 'fab fa-facebook-f',  'label' => 'Facebook'],
              'twitter'   => ['icon' => 'fab fa-x-twitter',   'label' => 'X / Twitter'],
              'linkedin'  => ['icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn'],
              'instagram' => ['icon' => 'fab fa-instagram',   'label' => 'Instagram'],
              'github'    => ['icon' => 'fab fa-github',      'label' => 'GitHub'],
            ];
            foreach ($socials as $key => $s):
              $sUrl = setting($key . '_url');
              if ($sUrl):
            ?>
            <a href="<?= Security::e($sUrl) ?>" target="_blank" aria-label="<?= $s['label'] ?>"
               class="w-9 h-9 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-eco-500/50 hover:bg-eco-500 hover:text-white flex items-center justify-center text-slate-400 transition-all duration-300 text-xs shadow-sm">
              <i class="<?= $s['icon'] ?>"></i>
            </a>
            <?php endif; endforeach; ?>

            <!-- WhatsApp Quick Social -->
            <a href="https://wa.me/<?= setting('whatsapp_number') ?>" target="_blank" aria-label="WhatsApp"
               class="w-9 h-9 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-[#25D366] hover:bg-[#25D366] hover:text-white flex items-center justify-center text-slate-400 transition-all duration-300 text-xs shadow-sm">
              <i class="fab fa-whatsapp"></i>
            </a>
          </div>
        </div>

        <!-- Column 2: Solutions & Services (Span 3) -->
        <div class="lg:col-span-3 space-y-4">
          <h3 class="font-display font-bold text-white text-base tracking-wide uppercase text-xs text-eco-400">Our Services</h3>
          <ul class="space-y-2.5 text-sm">
            <li><a href="<?= url('services') ?>" class="text-slate-400 hover:text-eco-300 transition-colors flex items-center"><i class="fas fa-angle-right text-xs text-eco-500 mr-2"></i>Custom Web Development</a></li>
            <li><a href="<?= url('services') ?>" class="text-slate-400 hover:text-eco-300 transition-colors flex items-center"><i class="fas fa-angle-right text-xs text-eco-500 mr-2"></i>Full-Stack Software Architecture</a></li>
            <li><a href="<?= url('templates') ?>" class="text-slate-400 hover:text-eco-300 transition-colors flex items-center"><i class="fas fa-angle-right text-xs text-eco-500 mr-2"></i>Ready-to-Launch Templates</a></li>
            <li><a href="<?= url('services') ?>" class="text-slate-400 hover:text-eco-300 transition-colors flex items-center"><i class="fas fa-angle-right text-xs text-eco-500 mr-2"></i>Programmatic SEO Systems</a></li>
            <li><a href="<?= url('services') ?>" class="text-slate-400 hover:text-eco-300 transition-colors flex items-center"><i class="fas fa-angle-right text-xs text-eco-500 mr-2"></i>Digital Marketing &amp; Growth</a></li>
          </ul>
        </div>

        <!-- Column 3: Navigation & Links (Span 2) -->
        <div class="lg:col-span-2 space-y-4">
          <h3 class="font-display font-bold text-white text-base tracking-wide uppercase text-xs text-eco-400">Company</h3>
          <ul class="space-y-2.5 text-sm">
            <li><a href="<?= url('about') ?>" class="text-slate-400 hover:text-white transition-colors">About Us</a></li>
            <li><a href="<?= url('projects') ?>" class="text-slate-400 hover:text-white transition-colors">Portfolio Work</a></li>
            <li><a href="<?= url('blog') ?>" class="text-slate-400 hover:text-white transition-colors">Blog &amp; Insights</a></li>
            <li><a href="<?= url('contact') ?>" class="text-slate-400 hover:text-white transition-colors">Contact Support</a></li>
            <li><a href="<?= url('admin/login') ?>" class="text-slate-400 hover:text-white transition-colors flex items-center"><i class="fas fa-lock text-[10px] mr-1.5 text-slate-500"></i>Admin Portal</a></li>
          </ul>
        </div>

        <!-- Column 4: Contact Details (Span 3) -->
        <div class="lg:col-span-3 space-y-4">
          <h3 class="font-display font-bold text-white text-base tracking-wide uppercase text-xs text-eco-400">Get in Touch</h3>
          <ul class="space-y-3 text-sm text-slate-400">
            <li class="flex items-start space-x-3">
              <div class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center text-eco-400 shrink-0 mt-0.5">
                <i class="fas fa-envelope text-xs"></i>
              </div>
              <div class="break-all">
                <div class="text-[11px] text-slate-500 uppercase font-semibold">Email Us</div>
                <a href="mailto:<?= Security::e(setting('site_email') ?: 'hello@ecotechservice.com') ?>" class="hover:text-eco-400 transition-colors font-medium">
                  <?= Security::e(setting('site_email') ?: 'hello@ecotechservice.com') ?>
                </a>
              </div>
            </li>

            <li class="flex items-start space-x-3">
              <div class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center text-eco-400 shrink-0 mt-0.5">
                <i class="fas fa-phone text-xs"></i>
              </div>
              <div>
                <div class="text-[11px] text-slate-500 uppercase font-semibold">Call / WhatsApp</div>
                <span class="font-medium"><?= Security::e(setting('site_phone') ?: '+91 1800-123-4567') ?></span>
              </div>
            </li>

            <li class="flex items-start space-x-3">
              <div class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center text-eco-400 shrink-0 mt-0.5">
                <i class="fas fa-location-dot text-xs"></i>
              </div>
              <div>
                <div class="text-[11px] text-slate-500 uppercase font-semibold">Location</div>
                <span><?= Security::e(setting('site_address') ?: 'Lucknow, India') ?></span>
              </div>
            </li>
          </ul>
        </div>

      </div>

      <!-- Footer Bottom Bar -->
      <div class="border-t border-slate-800/80 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
        <p>&copy; <?= date('Y') ?> <span class="text-white font-semibold">Ecotech Service</span>. All rights reserved. Built for sustainable growth.</p>
        
        <div class="flex items-center space-x-6">
          <a href="<?= url('contact') ?>" class="hover:text-eco-400 transition">Privacy Policy</a>
          <a href="<?= url('contact') ?>" class="hover:text-eco-400 transition">Terms of Service</a>
          <a href="<?= url('services/web-development-in-lucknow') ?>" class="hover:text-eco-400 transition">SEO Sitemap</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- WhatsApp Floating Action Button (Clean Rectangular, No circular design) -->
  <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%2C%20I%20have%20a%20project%20inquiry." target="_blank" aria-label="Chat on WhatsApp"
     class="fixed bottom-6 right-6 z-40 w-12 h-12 rounded-lg bg-[#25D366] hover:bg-[#20bd5a] flex items-center justify-center shadow-xl shadow-green-500/25 hover:scale-105 transition-all duration-300 group">
    <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5">
      <span class="animate-ping absolute inline-flex h-full w-full rounded-[2px] bg-white opacity-75"></span>
      <span class="relative inline-flex rounded-[2px] h-2.5 w-2.5 bg-white"></span>
    </span>
    <span class="material-icons-outlined text-white text-2xl group-hover:scale-110 transition-transform">chat</span>
  </a>

  <!-- Main JS (with cache-busting timestamp) -->
  <script src="<?= url('assets/js/app.js') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/js/app.js') ? filemtime(PUBLIC_PATH . '/assets/js/app.js') : '2.0' ?>"></script>

  <!-- ── Page Loader Dismiss ─────────────────────────────────── -->
  <script>
  (function () {
    var loader = document.getElementById('page-loader');
    function hideLoader() {
      if (!loader) return;
      loader.classList.add('loader-hidden');
      document.body.classList.remove('loading');
      // Remove from DOM after fade-out (500ms transition)
      setTimeout(function () { loader && loader.remove(); }, 550);
    }
    // Primary: hide shortly after DOM is ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function () {
        setTimeout(hideLoader, 300);
      });
    } else {
      // DOM already parsed (cached page)
      setTimeout(hideLoader, 150);
    }
    // Hard failsafe: never block user for more than 2.5s
    setTimeout(hideLoader, 2500);
  })();
  </script>
</body>
</html>
