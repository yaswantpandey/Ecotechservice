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

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

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

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">

  <!-- Google Analytics -->
  <?php if ($ga = setting('google_analytics_id')): ?>
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?= Security::e($ga) ?>"></script>
  <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= Security::e($ga) ?>');</script>
  <?php endif; ?>

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-M86QQPKV');</script>
  <!-- End Google Tag Manager -->
</head>
<body class="bg-gray-950 text-gray-100 font-sans antialiased">

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M86QQPKV"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <!-- ── Navigation ── -->
  <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-20">

        <!-- Logo -->
        <a href="<?= url() ?>" class="flex items-center space-x-3 group">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-eco-400 to-eco-600 flex items-center justify-center shadow-lg shadow-eco-500/30 group-hover:shadow-eco-500/50 transition-shadow duration-300">
            <i class="fas fa-leaf text-white text-lg"></i>
          </div>
          <span class="font-display font-bold text-xl text-white">Ecotech <span class="text-eco-400">Service</span></span>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-1">
          <?php
          $current = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
          $base    = trim(parse_url(APP_URL, PHP_URL_PATH) ?? '', '/') . '/public/';
          $page    = str_replace($base, '', $current);
          $nav = [
            ''          => 'Home',
            'about'     => 'About',
            'services'  => 'Services',
            'projects'  => 'Portfolio',
            'templates' => 'Templates',
            'blog'      => 'Blog',
            'contact'   => 'Contact',
          ];
          foreach ($nav as $path => $label):
            $active = ($page === $path);
          ?>
          <a href="<?= url($path) ?>"
             class="relative px-4 py-2 text-sm font-medium transition-all duration-200 rounded-lg
                    <?= $active ? 'text-eco-400' : 'text-gray-300 hover:text-white hover:bg-white/5' ?>">
            <?= $label ?>
            <?php if ($active): ?>
            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-4 h-0.5 bg-eco-400 rounded-full"></span>
            <?php endif; ?>
          </a>
          <?php endforeach; ?>
        </div>

        <!-- CTA -->
        <div class="hidden md:flex items-center space-x-3">
          <a href="https://wa.me/<?= setting('whatsapp_number') ?>" target="_blank"
             class="flex items-center space-x-2 px-4 py-2 bg-eco-500 hover:bg-eco-400 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-lg shadow-eco-500/25 hover:shadow-eco-400/40">
            <i class="fab fa-whatsapp text-base"></i>
            <span>WhatsApp</span>
          </a>
        </div>

        <!-- Mobile Toggle -->
        <button id="menuToggle" class="md:hidden p-2 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition">
          <i class="fas fa-bars text-xl"></i>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-gray-900/98 backdrop-blur border-t border-gray-800">
      <div class="px-4 py-4 space-y-1">
        <?php foreach ($nav as $path => $label): ?>
        <a href="<?= url($path) ?>"
           class="block px-4 py-3 text-sm font-medium rounded-lg <?= ($page === $path) ? 'bg-eco-500/20 text-eco-400' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?> transition">
          <?= $label ?>
        </a>
        <?php endforeach; ?>
        <a href="https://wa.me/<?= setting('whatsapp_number') ?>" target="_blank"
           class="flex items-center space-x-2 px-4 py-3 mt-2 bg-eco-500 text-white rounded-lg font-semibold text-sm">
          <i class="fab fa-whatsapp"></i><span>Chat on WhatsApp</span>
        </a>
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

  <!-- ── Footer ── -->
  <footer class="bg-gray-900 border-t border-gray-800 mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

        <!-- Brand -->
        <div class="lg:col-span-2">
          <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-eco-400 to-eco-600 flex items-center justify-center">
              <i class="fas fa-leaf text-white text-lg"></i>
            </div>
            <span class="font-display font-bold text-xl text-white">Ecotech <span class="text-eco-400">Service</span></span>
          </div>
          <p class="text-gray-400 text-sm leading-relaxed max-w-md mb-6">
            <?= Security::e(setting('site_tagline')) ?> — We build digital solutions that drive growth and sustainability for modern businesses.
          </p>
          <div class="flex items-center space-x-3">
            <?php foreach (['facebook'=>'fab fa-facebook-f','twitter'=>'fab fa-twitter','linkedin'=>'fab fa-linkedin-in','instagram'=>'fab fa-instagram'] as $net => $icon): ?>
            <?php $su = setting($net . '_url'); if ($su): ?>
            <a href="<?= Security::e($su) ?>" target="_blank"
               class="w-9 h-9 rounded-lg bg-gray-800 hover:bg-eco-500 flex items-center justify-center text-gray-400 hover:text-white transition-all duration-200 text-sm">
              <i class="<?= $icon ?>"></i>
            </a>
            <?php endif; endforeach; ?>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="font-display font-semibold text-white mb-5">Quick Links</h3>
          <ul class="space-y-3">
            <?php foreach (['About Us'=>'about','Services'=>'services','Portfolio'=>'projects','Templates'=>'templates','Blog'=>'blog','Contact'=>'contact'] as $label => $path): ?>
            <li><a href="<?= url($path) ?>" class="text-gray-400 hover:text-eco-400 text-sm transition"><?= $label ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h3 class="font-display font-semibold text-white mb-5">Contact</h3>
          <ul class="space-y-3 text-sm text-gray-400">
            <li class="flex items-start space-x-2">
              <i class="fas fa-envelope text-eco-400 mt-0.5 text-xs"></i>
              <a href="mailto:<?= Security::e(setting('site_email')) ?>" class="hover:text-eco-400 transition"><?= Security::e(setting('site_email')) ?></a>
            </li>
            <li class="flex items-start space-x-2">
              <i class="fas fa-phone text-eco-400 mt-0.5 text-xs"></i>
              <span><?= Security::e(setting('site_phone')) ?></span>
            </li>
            <li class="flex items-start space-x-2">
              <i class="fas fa-map-marker-alt text-eco-400 mt-0.5 text-xs"></i>
              <span><?= Security::e(setting('site_address')) ?></span>
            </li>
          </ul>
        </div>
      </div>

      <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
        <p class="text-gray-500 text-sm">&copy; <?= date('Y') ?> Ecotech Service. All rights reserved.</p>
        <a href="<?= url('admin') ?>" class="text-gray-600 hover:text-gray-400 text-xs transition">Admin Panel</a>
      </div>
    </div>
  </footer>

  <!-- WhatsApp Floating Button -->
  <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%2C%20I%20have%20a%20project%20inquiry." target="_blank"
     class="fixed bottom-6 right-6 z-40 w-14 h-14 rounded-full bg-[#25D366] flex items-center justify-center shadow-xl shadow-green-500/40 hover:scale-110 transition-transform duration-200">
    <i class="fab fa-whatsapp text-white text-2xl"></i>
  </a>

  <!-- Main JS -->
  <script src="<?= url('assets/js/app.js') ?>"></script>
</body>
</html>
