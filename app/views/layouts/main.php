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
  <link rel="icon" type="image/svg+xml" href="<?= url('assets/img/favicon.svg') ?>">

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
</head>
<body class="bg-gray-950 text-gray-100 font-sans antialiased">

  <!-- Custom Pointer Cursor -->
  <div id="customCursor"></div>
  <div id="customCursorDot"></div>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M86QQPKV"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <!-- ── Mobile App Top Header (Mobile Only) ── -->
  <header id="mobileAppHeader" class="fixed top-0 left-0 right-0 z-50 bg-slate-950/95 backdrop-blur-xl border-b border-slate-800/80 px-4 h-14 md:hidden flex items-center justify-between shadow-lg">
    <a href="<?= url() ?>" class="flex items-center space-x-2.5">
      <div class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center p-1">
        <img src="<?= url('assets/img/logo.png') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/img/logo.png') ? filemtime(PUBLIC_PATH . '/assets/img/logo.png') : '2.0' ?>" alt="EcoTech Services Logo" class="w-full h-full object-contain" loading="eager">
      </div>
      <span class="font-display font-bold text-white text-base tracking-tight">EcoTech <span class="text-emerald-400">Services</span></span>
    </a>
    <div class="flex items-center space-x-2">
      <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20project." target="_blank" aria-label="WhatsApp Support"
         class="w-8 h-8 rounded-lg bg-[#25D366]/15 border border-[#25D366]/30 flex items-center justify-center text-[#25D366] hover:bg-[#25D366]/25 transition">
        <i class="fab fa-whatsapp text-sm"></i>
      </a>
      <a href="<?= url('contact') ?>" aria-label="Get Started"
         class="px-2.5 py-1.5 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs flex items-center shadow-sm">
        <span>Get Started</span>
      </a>
      <button id="mobileDrawerOpen" type="button" aria-label="Open Navigation Menu"
              class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-300 hover:text-white transition">
        <i class="fas fa-bars text-xs"></i>
      </button>
    </div>
  </header>

  <!-- ── Mobile Drawer Sheet (Mobile Only) ── -->
  <div id="mobileDrawer" class="fixed inset-0 z-[60] md:hidden" style="visibility: hidden;">
    <!-- Backdrop overlay -->
    <div id="mobileDrawerOverlay" class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm"></div>

    <!-- Slide Panel -->
    <div id="mobileDrawerContent" class="absolute top-0 right-0 bottom-0 w-4/5 max-w-xs bg-slate-950 border-l border-slate-800 shadow-2xl flex flex-col justify-between p-5 overflow-y-auto">
      <div>
        <!-- Drawer Top Header -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
          <div class="flex items-center space-x-2">
            <div class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center p-1">
              <img src="<?= url('assets/img/logo.png') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/img/logo.png') ? filemtime(PUBLIC_PATH . '/assets/img/logo.png') : '2.0' ?>" alt="Logo" class="w-full h-full object-contain">
            </div>
            <div class="flex flex-col">
              <span class="font-display font-bold text-white text-sm leading-tight">EcoTech <span class="text-emerald-400">Services</span></span>
              <span class="text-[9px] text-slate-400 tracking-wider uppercase leading-none mt-0.5">Enterprise IT</span>
            </div>
          </div>
          <button id="mobileDrawerClose" type="button" aria-label="Close Navigation Menu"
                  class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-white transition">
            <i class="fas fa-times text-xs"></i>
          </button>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-4 space-y-1">
          <?php
          $current = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
          $base    = trim(parse_url(APP_URL, PHP_URL_PATH) ?? '', '/') . '/public/';
          $page    = str_replace($base, '', $current);

          $drawerItems = [
            ['path' => '',          'label' => 'Home',              'icon' => 'fa-house'],
            ['path' => 'about',     'label' => 'About Us',          'icon' => 'fa-circle-info'],
            ['path' => 'services',  'label' => 'Services & Tech',   'icon' => 'fa-cubes'],
            ['path' => 'projects',  'label' => 'Client Portfolio',  'icon' => 'fa-briefcase'],
            ['path' => 'templates', 'label' => 'Templates',         'icon' => 'fa-layer-group'],
            ['path' => 'blog',      'label' => 'Tech Blog',         'icon' => 'fa-newspaper'],
            ['path' => 'contact',   'label' => 'Contact Us',        'icon' => 'fa-envelope'],
          ];
          foreach ($drawerItems as $dItem):
            $isActive = ($page === $dItem['path']);
          ?>
          <a href="<?= url($dItem['path']) ?>"
             class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium transition-all <?= $isActive ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 font-semibold' : 'text-slate-300 hover:bg-slate-900 hover:text-white' ?>">
            <span class="flex items-center space-x-3">
              <i class="fas <?= $dItem['icon'] ?> text-xs text-slate-400 w-4 text-center"></i>
              <span><?= $dItem['label'] ?></span>
            </span>
            <i class="fas fa-chevron-right text-[9px] text-slate-500"></i>
          </a>
          <?php endforeach; ?>
        </nav>
      </div>

      <!-- Drawer Footer Quick CTAs -->
      <div class="pt-5 border-t border-slate-800 space-y-2 mt-6">
        <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20project." target="_blank"
           class="flex items-center justify-center space-x-2 w-full py-2.5 bg-[#25D366] hover:bg-[#20bd5a] text-white rounded-xl font-semibold text-xs transition shadow-sm">
          <i class="fab fa-whatsapp text-sm"></i>
          <span>Chat on WhatsApp</span>
        </a>
        <a href="<?= url('contact') ?>"
           class="flex items-center justify-center space-x-2 w-full py-2.5 bg-slate-900 hover:bg-slate-800 border border-slate-800 text-white rounded-xl font-semibold text-xs transition">
          <span>Request Free Quote</span>
          <i class="fas fa-arrow-right text-[9px]"></i>
        </a>
      </div>
    </div>
  </div>

  <!-- ── Desktop Navigation Bar (>= 769px) ── -->
  <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-[68px]">

        <!-- Logo / Brand Identity -->
        <a href="<?= url() ?>" class="flex items-center space-x-3 group">
          <div class="relative w-9 h-9 rounded-xl bg-slate-900/90 border border-slate-800 flex items-center justify-center p-1 shadow-sm group-hover:border-emerald-500/40 transition-colors">
            <img src="<?= url('assets/img/logo.png') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/img/logo.png') ? filemtime(PUBLIC_PATH . '/assets/img/logo.png') : '2.0' ?>" alt="Ecotech Service Logo" class="w-full h-full object-contain" loading="eager">
          </div>
          <div class="flex flex-col">
            <div class="flex items-center space-x-1.5 leading-none">
              <span class="font-display font-bold text-white text-base tracking-tight">EcoTech</span>
              <span class="text-emerald-400 font-bold text-base tracking-tight">Services</span>
            </div>
            <span class="text-[10px] text-slate-400 font-medium tracking-wider uppercase leading-none mt-1">Enterprise IT Solutions</span>
          </div>
        </a>

        <!-- Desktop Center Links (Frosted Capsule) -->
        <div class="hidden md:flex items-center space-x-1 bg-slate-900/60 p-1 rounded-xl border border-slate-800/80 backdrop-blur-md">
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
            <!-- Services with Submenu Preview -->
            <div class="relative group/nav">
              <a href="<?= url('services') ?>"
                 class="flex items-center space-x-1 px-3.5 py-1.5 text-xs font-medium rounded-lg transition-all duration-200
                        <?= $isActive ? 'bg-slate-800 text-white shadow-sm border border-slate-700/60 font-semibold' : 'text-slate-300 hover:text-white hover:bg-slate-800/50' ?>">
                <span><?= $label ?></span>
                <i class="fas fa-chevron-down text-[9px] opacity-60 group-hover/nav:rotate-180 transition-transform duration-200"></i>
              </a>
              
              <!-- Dropdown Menu Card -->
              <div class="absolute top-full left-1/2 -translate-x-1/2 pt-3 opacity-0 pointer-events-none group-hover/nav:opacity-100 group-hover/nav:pointer-events-auto transition-all duration-200 w-80 z-50">
                <div class="bg-slate-950/95 backdrop-blur-xl border border-slate-800 rounded-2xl p-3 shadow-2xl shadow-black/50 space-y-1">
                  <a href="<?= url('services#web') ?>" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-900 transition text-left group/item">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 group-hover/item:bg-emerald-500/20 shrink-0">
                      <i class="fas fa-code text-xs"></i>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-white group-hover/item:text-emerald-400 transition">Web Applications</div>
                      <div class="text-[10px] text-slate-400">Enterprise SaaS & High-speed Portals</div>
                    </div>
                  </a>
                  <a href="<?= url('services#mobile') ?>" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-900 transition text-left group/item">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 group-hover/item:bg-blue-500/20 shrink-0">
                      <i class="fas fa-mobile-screen-button text-xs"></i>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-white group-hover/item:text-blue-400 transition">Mobile App Development</div>
                      <div class="text-[10px] text-slate-400">Cross-platform iOS & Android</div>
                    </div>
                  </a>
                  <a href="<?= url('services#cloud') ?>" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-900 transition text-left group/item">
                    <div class="w-8 h-8 rounded-lg bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 group-hover/item:bg-purple-500/20 shrink-0">
                      <i class="fas fa-cloud text-xs"></i>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-white group-hover/item:text-purple-400 transition">Cloud & DevOps</div>
                      <div class="text-[10px] text-slate-400">AWS, GCP, CI/CD & 99.9% Uptime</div>
                    </div>
                  </a>
                  <a href="<?= url('services#security') ?>" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-900 transition text-left group/item">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 group-hover/item:bg-amber-500/20 shrink-0">
                      <i class="fas fa-shield-halved text-xs"></i>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-white group-hover/item:text-amber-400 transition">Cybersecurity & Audits</div>
                      <div class="text-[10px] text-slate-400">Pen-testing & OWASP Security</div>
                    </div>
                  </a>
                  <div class="border-t border-slate-800/80 pt-2 px-2">
                    <a href="<?= url('services') ?>" class="text-[11px] font-semibold text-emerald-400 hover:text-emerald-300 flex items-center justify-between">
                      <span>Explore All 6 Services</span>
                      <i class="fas fa-arrow-right text-[9px]"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <?php else: ?>
            <a href="<?= url($path) ?>"
               class="px-3.5 py-1.5 text-xs font-medium rounded-lg transition-all duration-200
                      <?= $isActive ? 'bg-slate-800 text-white shadow-sm border border-slate-700/60 font-semibold' : 'text-slate-300 hover:text-white hover:bg-slate-800/50' ?>">
              <?= $label ?>
            </a>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>

        <!-- Right Action Buttons -->
        <div class="hidden md:flex items-center space-x-3">
          <!-- WhatsApp Support Pill -->
          <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20project." target="_blank"
             class="hidden lg:inline-flex items-center space-x-2 px-3 py-1.5 rounded-lg border border-slate-800 bg-slate-900/70 hover:bg-slate-800 text-slate-300 hover:text-white text-xs font-medium transition">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <i class="fab fa-whatsapp text-emerald-400 text-sm"></i>
            <span>WhatsApp</span>
          </a>

          <!-- Primary Corporate CTA -->
          <a href="<?= url('contact') ?>"
             class="inline-flex items-center space-x-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 text-xs font-semibold rounded-lg shadow-sm shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-200">
            <span>Get Started</span>
            <i class="fas fa-arrow-right text-[10px]"></i>
          </a>
        </div>

      </div>
    </div>
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
</body>
</html>
