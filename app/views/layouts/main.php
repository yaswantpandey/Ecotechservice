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

  <!-- ══ MOBILE TOP BAR (< md) ════════════════════════════════════════ -->
  <header id="mobileAppHeader"
          class="fixed top-0 left-0 right-0 z-50 md:hidden"
          style="background:rgba(3,7,18,0.92);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid rgba(255,255,255,0.06);">
    <div class="flex items-center justify-between h-[56px] px-4">

      <!-- Brand -->
      <a href="<?= url() ?>" style="display:flex;align-items:center;text-decoration:none;">
        <img src="<?= url('assets/img/logo.png') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/img/logo.png') ? filemtime(PUBLIC_PATH . '/assets/img/logo.png') : '2' ?>"
             alt="EcoTech Services" loading="eager"
             style="height:46px;width:auto;object-fit:contain;mix-blend-mode:screen;filter:brightness(1.3) contrast(1.1);">
      </a>

      <!-- Right: WA + Hamburger -->
      <div class="flex items-center gap-2">
        <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20project."
           target="_blank" aria-label="WhatsApp"
           style="width:34px;height:34px;border-radius:8px;background:rgba(37,211,102,0.1);border:1px solid rgba(37,211,102,0.22);display:flex;align-items:center;justify-content:center;color:#25D366;transition:.2s;">
          <i class="fab fa-whatsapp" style="font-size:14px;"></i>
        </a>
        <button id="mobileDrawerOpen" type="button" aria-label="Open menu"
                style="width:34px;height:34px;border-radius:8px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;color:#cbd5e1;transition:.2s;">
          <i class="fas fa-bars" style="font-size:13px;"></i>
        </button>
      </div>
    </div>
  </header>

  <!-- ══ MOBILE DRAWER (< md) ══════════════════════════════════════════ -->
  <div id="mobileDrawer" class="fixed inset-0 z-[60] md:hidden" style="visibility:hidden;">
    <!-- Backdrop -->
    <div id="mobileDrawerOverlay"
         style="position:absolute;inset:0;background:rgba(0,0,0,0.7);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);"></div>

    <!-- Slide Panel -->
    <div id="mobileDrawerContent"
         style="position:absolute;top:0;right:0;bottom:0;width:82%;max-width:300px;background:#050d0a;border-left:1px solid rgba(255,255,255,0.07);display:flex;flex-direction:column;overflow-y:auto;transform:translateX(100%);transition:transform .3s cubic-bezier(.4,0,.2,1);">

      <!-- Panel Header -->
      <div style="padding:18px 20px 16px;border-bottom:1px solid rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:space-between;">
        <a href="<?= url() ?>" style="display:flex;align-items:center;text-decoration:none;">
          <img src="<?= url('assets/img/logo.png') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/img/logo.png') ? filemtime(PUBLIC_PATH . '/assets/img/logo.png') : '2' ?>"
               alt="EcoTech Services"
               style="height:46px;width:auto;object-fit:contain;mix-blend-mode:screen;filter:brightness(1.3) contrast(1.1);">
        </a>
        <button id="mobileDrawerClose" type="button" aria-label="Close"
                style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:center;color:#64748b;cursor:pointer;">
          <i class="fas fa-times" style="font-size:12px;"></i>
        </button>
      </div>

      <!-- Nav Links -->
      <nav style="padding:12px 12px;flex:1;">
        <?php
        $current = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
        $base    = trim(parse_url(APP_URL, PHP_URL_PATH) ?? '', '/') . '/public/';
        $page    = str_replace($base, '', $current);

        $drawerItems = [
          ['path' => '',          'label' => 'Home',         'icon' => 'fa-house',       'desc' => 'Back to home'],
          ['path' => 'about',     'label' => 'About',        'icon' => 'fa-circle-info', 'desc' => 'Our story & team'],
          ['path' => 'services',  'label' => 'Services',     'icon' => 'fa-cubes',       'desc' => 'What we build'],
          ['path' => 'projects',  'label' => 'Portfolio',    'icon' => 'fa-briefcase',   'desc' => 'Client work'],
          ['path' => 'templates', 'label' => 'Templates',    'icon' => 'fa-layer-group', 'desc' => 'Ready-made themes'],
          ['path' => 'blog',      'label' => 'Blog',         'icon' => 'fa-newspaper',   'desc' => 'Tech insights'],
          ['path' => 'contact',   'label' => 'Contact',      'icon' => 'fa-envelope',    'desc' => 'Get in touch'],
        ];
        foreach ($drawerItems as $dItem):
          $isActive = ($page === $dItem['path']);
        ?>
        <a href="<?= url($dItem['path']) ?>"
           style="display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:10px;margin-bottom:2px;text-decoration:none;transition:.15s;<?= $isActive ? 'background:rgba(74,222,128,0.1);border:1px solid rgba(74,222,128,0.18);' : 'border:1px solid transparent;' ?>">
          <div style="width:34px;height:34px;border-radius:8px;<?= $isActive ? 'background:rgba(74,222,128,0.15);border:1px solid rgba(74,222,128,0.25);' : 'background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);' ?>display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas <?= $dItem['icon'] ?>" style="font-size:12px;<?= $isActive ? 'color:#4ade80;' : 'color:#64748b;' ?>"></i>
          </div>
          <div style="flex:1;min-width:0;">
            <div style="font-size:13px;font-weight:600;<?= $isActive ? 'color:#4ade80;' : 'color:#e2e8f0;' ?>"><?= $dItem['label'] ?></div>
            <div style="font-size:10px;color:rgba(255,255,255,0.3);margin-top:1px;"><?= $dItem['desc'] ?></div>
          </div>
          <i class="fas fa-chevron-right" style="font-size:9px;color:rgba(255,255,255,0.18);"></i>
        </a>
        <?php endforeach; ?>
      </nav>

      <!-- Footer CTAs -->
      <div style="padding:16px 16px 24px;border-top:1px solid rgba(255,255,255,0.06);display:flex;flex-direction:column;gap:8px;">
        <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20project."
           target="_blank"
           style="display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:11px;background:#25D366;border-radius:10px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;transition:.2s;">
          <i class="fab fa-whatsapp" style="font-size:15px;"></i>
          <span>Chat on WhatsApp</span>
        </a>
        <a href="<?= url('contact') ?>"
           style="display:flex;align-items:center;justify-content:center;gap:6px;width:100%;padding:11px;background:rgba(74,222,128,0.1);border:1px solid rgba(74,222,128,0.25);border-radius:10px;font-size:13px;font-weight:600;color:#4ade80;text-decoration:none;transition:.2s;">
          <span>Request Free Quote</span>
          <i class="fas fa-arrow-right" style="font-size:10px;"></i>
        </a>
      </div>
    </div>
  </div>

  <!-- ══ DESKTOP NAVBAR (≥ md) ═════════════════════════════════════════ -->
  <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
       style="background:transparent;">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
      <div class="hidden md:flex items-center justify-between" style="height:68px;">

        <!-- ── Brand ─────────────────────────────────────────────────── -->
        <a href="<?= url() ?>" style="display:flex;align-items:center;text-decoration:none;">
          <img src="<?= url('assets/img/logo.png') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/img/logo.png') ? filemtime(PUBLIC_PATH . '/assets/img/logo.png') : '2' ?>"
               alt="EcoTech Services"
               style="height:52px;width:auto;object-fit:contain;mix-blend-mode:screen;filter:brightness(1.3) contrast(1.1);"
               loading="eager">
        </a>

        <!-- ── Center Nav Links ───────────────────────────────────────── -->
        <div class="navbar-center-links" id="navbarLinks">
          <?php
          $navLinks = [
            ''          => 'Home',
            'about'     => 'About',
            'services'  => 'Services',
            'projects'  => 'Portfolio',
            'templates' => 'Templates',
            'blog'      => 'Blog',
            'contact'   => 'Contact',
          ];
          foreach ($navLinks as $path => $label):
            $isActive = ($page === $path);
          ?>
            <?php if ($path === 'services'): ?>
            <!-- Services Mega Dropdown -->
            <div class="navbar-item navbar-dropdown-trigger" id="servicesDropdown">
              <a href="<?= url('services') ?>" class="navbar-link <?= $isActive ? 'navbar-link--active' : '' ?>">
                <?= $label ?>
                <i class="fas fa-chevron-down navbar-chevron"></i>
              </a>

              <!-- Dropdown panel -->
              <div class="navbar-dropdown-panel" id="servicesPanel">
                <div class="navbar-dropdown-inner">
                  <div class="navbar-dropdown-header">Our Services</div>
                  <div class="navbar-dropdown-grid">
                    <a href="<?= url('services#web') ?>" class="navbar-service-item">
                      <div class="nsi-icon" style="--c:rgba(74,222,128,.15);--b:rgba(74,222,128,.25);--t:#4ade80;">
                        <i class="fas fa-code"></i>
                      </div>
                      <div class="nsi-text">
                        <span class="nsi-title">Web Development</span>
                        <span class="nsi-sub">Enterprise apps & portals</span>
                      </div>
                    </a>
                    <a href="<?= url('services#mobile') ?>" class="navbar-service-item">
                      <div class="nsi-icon" style="--c:rgba(96,165,250,.12);--b:rgba(96,165,250,.22);--t:#60a5fa;">
                        <i class="fas fa-mobile-screen-button"></i>
                      </div>
                      <div class="nsi-text">
                        <span class="nsi-title">Mobile Apps</span>
                        <span class="nsi-sub">iOS & Android, cross-platform</span>
                      </div>
                    </a>
                    <a href="<?= url('services#cloud') ?>" class="navbar-service-item">
                      <div class="nsi-icon" style="--c:rgba(167,139,250,.12);--b:rgba(167,139,250,.22);--t:#a78bfa;">
                        <i class="fas fa-cloud"></i>
                      </div>
                      <div class="nsi-text">
                        <span class="nsi-title">Cloud & DevOps</span>
                        <span class="nsi-sub">AWS, GCP, CI/CD pipelines</span>
                      </div>
                    </a>
                    <a href="<?= url('services#security') ?>" class="navbar-service-item">
                      <div class="nsi-icon" style="--c:rgba(251,191,36,.1);--b:rgba(251,191,36,.2);--t:#fbbf24;">
                        <i class="fas fa-shield-halved"></i>
                      </div>
                      <div class="nsi-text">
                        <span class="nsi-title">Cybersecurity</span>
                        <span class="nsi-sub">Pen-testing & OWASP audits</span>
                      </div>
                    </a>
                    <a href="<?= url('services#seo') ?>" class="navbar-service-item">
                      <div class="nsi-icon" style="--c:rgba(248,113,113,.1);--b:rgba(248,113,113,.2);--t:#f87171;">
                        <i class="fas fa-chart-line"></i>
                      </div>
                      <div class="nsi-text">
                        <span class="nsi-title">SEO & Marketing</span>
                        <span class="nsi-sub">Growth & performance ads</span>
                      </div>
                    </a>
                    <a href="<?= url('services#design') ?>" class="navbar-service-item">
                      <div class="nsi-icon" style="--c:rgba(34,211,238,.1);--b:rgba(34,211,238,.2);--t:#22d3ee;">
                        <i class="fas fa-pen-ruler"></i>
                      </div>
                      <div class="nsi-text">
                        <span class="nsi-title">UI/UX Design</span>
                        <span class="nsi-sub">Figma, prototyping & systems</span>
                      </div>
                    </a>
                  </div>
                  <div class="navbar-dropdown-footer">
                    <a href="<?= url('services') ?>" class="navbar-dropdown-cta">
                      <span>View all services</span>
                      <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="<?= url('contact') ?>" class="navbar-dropdown-badge">
                      <i class="fas fa-bolt"></i>
                      <span>Free Consultation</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <?php else: ?>
            <div class="navbar-item">
              <a href="<?= url($path) ?>" class="navbar-link <?= $isActive ? 'navbar-link--active' : '' ?>">
                <?= $label ?>
              </a>
            </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>

        <!-- ── Right Actions ─────────────────────────────────────────── -->
        <div class="flex items-center gap-3">
          <!-- WhatsApp pill -->
          <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20project."
             target="_blank" class="navbar-wa-pill hidden lg:inline-flex">
            <span class="navbar-wa-dot"></span>
            <i class="fab fa-whatsapp" style="color:#25D366;font-size:14px;"></i>
            <span>WhatsApp</span>
          </a>

          <!-- Primary CTA -->
          <a href="<?= url('contact') ?>" class="navbar-cta-btn">
            Get Started
            <i class="fas fa-arrow-right" style="font-size:10px;"></i>
          </a>
        </div>

      </div><!-- /inner flex -->
    </div><!-- /max-w -->
  </nav>

  <!-- ══ NAVBAR CSS ════════════════════════════════════════════════════ -->
  <style>
    /* ── Scrolled state ─────────────────────────────── */
    #navbar.nav-scrolled {
      background: rgba(3,7,18,0.88) !important;
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border-bottom: 1px solid rgba(255,255,255,0.06);
      box-shadow: 0 4px 32px rgba(0,0,0,0.4);
    }

    /* ── Center pill container ──────────────────────── */
    .navbar-center-links {
      display: flex;
      align-items: center;
      gap: 2px;
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.07);
      border-radius: 14px;
      padding: 5px 6px;
      backdrop-filter: blur(8px);
    }

    /* ── Nav item wrapper ───────────────────────────── */
    .navbar-item {
      position: relative;
    }
    .navbar-item.navbar-dropdown-trigger { position: relative; }

    /* ── Individual link ────────────────────────────── */
    .navbar-link {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 7px 13px;
      border-radius: 9px;
      font-size: 13.5px;
      font-weight: 500;
      color: rgba(255,255,255,0.6);
      text-decoration: none;
      white-space: nowrap;
      transition: color .18s, background .18s;
      position: relative;
      letter-spacing: -0.01em;
    }
    .navbar-link:hover {
      color: #fff;
      background: rgba(255,255,255,0.07);
    }
    .navbar-link--active {
      color: #fff;
      background: rgba(255,255,255,0.09);
      font-weight: 600;
    }
    .navbar-link--active::after {
      content: '';
      position: absolute;
      bottom: 4px;
      left: 50%;
      transform: translateX(-50%);
      width: 18px;
      height: 2px;
      border-radius: 2px;
      background: #4ade80;
    }
    .navbar-chevron {
      font-size: 9px;
      opacity: .5;
      transition: transform .2s;
    }
    .navbar-dropdown-trigger:hover .navbar-chevron,
    .navbar-dropdown-trigger.open .navbar-chevron {
      transform: rotate(180deg);
    }

    /* ── Mega dropdown panel ────────────────────────── */
    .navbar-dropdown-panel {
      position: absolute;
      top: calc(100% + 10px);
      left: 50%;
      transform: translateX(-50%);
      width: 480px;
      opacity: 0;
      visibility: hidden;
      pointer-events: none;
      transition: opacity .2s ease, transform .2s ease, visibility .2s;
      transform: translateX(-50%) translateY(6px);
      z-index: 100;
    }
    .navbar-dropdown-trigger:hover .navbar-dropdown-panel,
    .navbar-dropdown-trigger.open .navbar-dropdown-panel {
      opacity: 1;
      visibility: visible;
      pointer-events: auto;
      transform: translateX(-50%) translateY(0);
    }
    .navbar-dropdown-inner {
      background: rgba(5,8,16,0.97);
      border: 1px solid rgba(255,255,255,0.09);
      border-radius: 18px;
      padding: 16px;
      box-shadow: 0 24px 64px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.04) inset;
    }
    .navbar-dropdown-header {
      font-size: 10px;
      font-weight: 600;
      letter-spacing: .1em;
      text-transform: uppercase;
      color: rgba(255,255,255,0.25);
      padding: 0 4px 10px;
      border-bottom: 1px solid rgba(255,255,255,0.06);
      margin-bottom: 10px;
    }
    .navbar-dropdown-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4px;
    }
    .navbar-service-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 10px;
      border-radius: 10px;
      text-decoration: none;
      transition: background .15s;
      border: 1px solid transparent;
    }
    .navbar-service-item:hover {
      background: rgba(255,255,255,0.05);
      border-color: rgba(255,255,255,0.07);
    }
    .nsi-icon {
      width: 32px; height: 32px;
      border-radius: 8px;
      background: var(--c);
      border: 1px solid var(--b);
      color: var(--t);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
      font-size: 12px;
      transition: background .15s;
    }
    .navbar-service-item:hover .nsi-icon { background: var(--b); }
    .nsi-text { display: flex; flex-direction: column; gap: 2px; }
    .nsi-title { font-size: 12.5px; font-weight: 600; color: #e2e8f0; line-height: 1; }
    .nsi-sub   { font-size: 10.5px; color: rgba(255,255,255,0.32); line-height: 1.3; }
    .navbar-service-item:hover .nsi-title { color: #fff; }

    .navbar-dropdown-footer {
      display: flex; align-items: center; justify-content: space-between;
      margin-top: 10px;
      padding-top: 10px;
      border-top: 1px solid rgba(255,255,255,0.06);
    }
    .navbar-dropdown-cta {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: 12px; font-weight: 600; color: #4ade80;
      text-decoration: none;
      transition: gap .15s, color .15s;
    }
    .navbar-dropdown-cta:hover { color: #86efac; gap: 8px; }
    .navbar-dropdown-badge {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: 11px; font-weight: 600;
      padding: 5px 10px;
      border-radius: 20px;
      background: rgba(74,222,128,0.1);
      border: 1px solid rgba(74,222,128,0.22);
      color: #4ade80;
      text-decoration: none;
      transition: background .15s;
    }
    .navbar-dropdown-badge:hover { background: rgba(74,222,128,0.18); }

    /* ── Right action buttons ───────────────────────── */
    .navbar-wa-pill {
      display: inline-flex; align-items: center; gap: 7px;
      padding: 7px 13px;
      border-radius: 9px;
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.08);
      font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.65);
      text-decoration: none;
      transition: background .18s, color .18s, border-color .18s;
    }
    .navbar-wa-pill:hover {
      background: rgba(37,211,102,0.08);
      border-color: rgba(37,211,102,0.2);
      color: #fff;
    }
    .navbar-wa-dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: #4ade80;
      animation: pulse 2s infinite;
    }
    .navbar-cta-btn {
      display: inline-flex; align-items: center; gap: 7px;
      padding: 8px 18px;
      border-radius: 9px;
      background: #16a34a;
      background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
      color: #fff;
      font-size: 13px; font-weight: 600;
      text-decoration: none;
      letter-spacing: -0.01em;
      box-shadow: 0 2px 12px rgba(34,197,94,.3);
      transition: box-shadow .2s, transform .15s, background .2s;
    }
    .navbar-cta-btn:hover {
      background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
      box-shadow: 0 4px 20px rgba(34,197,94,.45);
      transform: translateY(-1px);
      color: #fff;
    }
    .navbar-cta-btn:active { transform: translateY(0); }

    /* ── Mobile drawer open/close anim ─────────────── */
    #mobileDrawerContent { transform: translateX(100%); transition: transform .28s cubic-bezier(.4,0,.2,1); }
    #mobileDrawer.open #mobileDrawerContent { transform: translateX(0); }
    #mobileDrawer.open { visibility: visible !important; }
  </style>
</nav>

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

  <!-- WhatsApp Floating Action Button -->
  <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%2C%20I%20have%20a%20project%20inquiry." target="_blank" aria-label="Chat on WhatsApp"
     class="fixed bottom-6 right-6 z-40 w-14 h-14 rounded-full bg-[#25D366] hover:bg-[#20bd5a] flex items-center justify-center shadow-xl shadow-green-500/30 hover:scale-110 transition-all duration-300 group">
    <span class="absolute -top-1 -right-1 flex h-3 w-3">
      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
      <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
    </span>
    <i class="fab fa-whatsapp text-white text-2xl group-hover:rotate-12 transition-transform"></i>
  </a>

  <!-- ── Mobile App Bottom Navigation Bar (Mobile Only: <= 768px) ── -->
  <?php
  $currentPath = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
  $baseDir    = trim(parse_url(APP_URL, PHP_URL_PATH) ?? '', '/') . '/public/';
  $activeRoute = str_replace($baseDir, '', $currentPath);

  $mobileNavItems = [
      ['route' => '',          'label' => 'Home',     'icon' => 'home'],
      ['route' => 'services',  'label' => 'Services', 'icon' => 'miscellaneous_services'],
      ['route' => 'projects',  'label' => 'Projects', 'icon' => 'work'],
      ['route' => 'about',     'label' => 'About',    'icon' => 'info'],
      ['route' => 'contact',   'label' => 'Contact',  'icon' => 'contact_support'],
  ];
  ?>
  <nav id="mobileBottomNav" aria-label="Mobile Navigation"
       class="fixed bottom-0 left-0 right-0 z-50 md:hidden bg-slate-950/95 backdrop-blur-xl border-t border-slate-800/80 px-2 py-2 shadow-2xl">
    <div class="grid grid-cols-5 gap-1 max-w-md mx-auto">
      <?php foreach ($mobileNavItems as $mItem):
        $isActive = ($activeRoute === $mItem['route']);
      ?>
      <a href="<?= url($mItem['route']) ?>"
         class="flex flex-col items-center justify-center py-1 px-1 rounded-xl transition-all duration-200 relative
                <?= $isActive ? 'text-eco-400 font-semibold' : 'text-slate-400 hover:text-slate-200' ?>">
        
        <!-- Active Background Pill -->
        <?php if ($isActive): ?>
        <span class="absolute inset-0 bg-eco-500/10 border border-eco-500/30 rounded-xl shadow-sm"></span>
        <?php endif; ?>

        <!-- Material UI Icon -->
        <span class="material-icons text-xl relative z-10 transition-transform duration-200 <?= $isActive ? 'scale-110 text-eco-400' : '' ?>">
          <?= $mItem['icon'] ?>
        </span>

        <!-- Label -->
        <span class="text-[10px] tracking-tight relative z-10 mt-0.5 <?= $isActive ? 'text-eco-300 font-bold' : 'text-slate-400' ?>">
          <?= $mItem['label'] ?>
        </span>
      </a>
      <?php endforeach; ?>
    </div>
  </nav>

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
