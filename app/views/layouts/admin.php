<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= Security::e($pageTitle ?? 'Admin — ' . APP_NAME) ?></title>
  <link rel="icon" type="image/svg+xml" href="<?= url('assets/img/favicon.svg') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { eco: { 400:'#4ade80', 500:'#22c55e', 600:'#16a34a' } },
          fontFamily: { sans:['Inter','sans-serif'], display:['Space Grotesk','Inter','sans-serif'] }
        }
      }
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="<?= url('assets/css/admin.css') ?>">

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-M86QQPKV');</script>
  <!-- End Google Tag Manager -->
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-4ZPQCKJ3EL"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-4ZPQCKJ3EL');
  </script>
</head>
<body class="bg-gray-950 text-gray-100 font-sans antialiased">

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M86QQPKV"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <div class="flex h-screen overflow-hidden">

    <!-- ── Sidebar ── -->
    <aside id="sidebar" class="w-64 bg-gray-900 border-r border-gray-800 flex flex-col fixed lg:relative inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
      <!-- Logo -->
      <div class="flex items-center space-x-3 px-6 py-5 border-b border-gray-800">
        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-eco-400 to-eco-600 flex items-center justify-center">
          <i class="fas fa-leaf text-white"></i>
        </div>
        <span class="font-display font-bold text-white">Ecotech <span class="text-eco-400">Admin</span></span>
      </div>

      <!-- Nav -->
      <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
        <?php
        $adminNav = [
          ['icon'=>'fa-tachometer-alt','label'=>'Dashboard',    'path'=>'admin/dashboard'],
          ['icon'=>'fa-briefcase',      'label'=>'Projects',     'path'=>'admin/projects'],
          ['icon'=>'fa-cogs',           'label'=>'Services',     'path'=>'admin/services'],
          ['icon'=>'fa-star',           'label'=>'Testimonials', 'path'=>'admin/testimonials'],
          ['icon'=>'fa-envelope',       'label'=>'Contacts',     'path'=>'admin/contacts'],
          ['icon'=>'fa-pen-nib',        'label'=>'Blog',         'path'=>'admin/blog'],
          ['icon'=>'fa-sliders-h',      'label'=>'Settings',     'path'=>'admin/settings'],
        ];
        $curUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $base   = trim(parse_url(APP_URL, PHP_URL_PATH) ?? '', '/') . '/public/';
        $curPage = str_replace($base, '', $curUri);
        foreach ($adminNav as $item):
          $active = str_starts_with($curPage, $item['path']);
        ?>
        <a href="<?= url($item['path']) ?>"
           class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                  <?= $active ? 'bg-eco-500/20 text-eco-400 border border-eco-500/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' ?>">
          <i class="fas <?= $item['icon'] ?> w-4 text-center"></i>
          <span><?= $item['label'] ?></span>
        </a>
        <?php endforeach; ?>
      </nav>

      <!-- Admin info + logout -->
      <div class="px-4 py-4 border-t border-gray-800">
        <div class="flex items-center space-x-3 mb-3">
          <div class="w-8 h-8 rounded-full bg-eco-500 flex items-center justify-center text-white font-semibold text-sm">
            <?= strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)) ?>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-white truncate"><?= Security::e($_SESSION['admin_name'] ?? '') ?></p>
            <p class="text-xs text-gray-500 capitalize"><?= Security::e($_SESSION['admin_role'] ?? '') ?></p>
          </div>
        </div>
        <a href="<?= url('admin/logout') ?>"
           class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm text-red-400 hover:bg-red-500/10 transition w-full">
          <i class="fas fa-sign-out-alt"></i><span>Logout</span>
        </a>
        <a href="<?= url() ?>" target="_blank"
           class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-white/5 transition w-full mt-1">
          <i class="fas fa-external-link-alt"></i><span>View Site</span>
        </a>
      </div>
    </aside>

    <!-- ── Main Content ── -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
      <!-- Top Bar -->
      <header class="bg-gray-900 border-b border-gray-800 px-6 py-4 flex items-center justify-between flex-shrink-0">
        <button id="sidebarToggle" class="lg:hidden p-2 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition">
          <i class="fas fa-bars"></i>
        </button>
        <h1 class="font-display font-semibold text-lg text-white">
          <?= Security::e($pageTitle ?? 'Admin Panel') ?>
        </h1>
        <div class="text-sm text-gray-400"><?= date('d M Y') ?></div>
      </header>

      <!-- Flash Messages -->
      <div class="px-6 pt-4">
        <?php if (hasFlash('success')): ?>
        <div class="flex items-center space-x-3 bg-eco-500/20 border border-eco-500/30 text-eco-400 px-4 py-3 rounded-xl mb-4 text-sm">
          <i class="fas fa-check-circle"></i>
          <span><?= Security::e(getFlash('success')) ?></span>
        </div>
        <?php endif; ?>
        <?php if (hasFlash('error')): ?>
        <div class="flex items-center space-x-3 bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-4 text-sm">
          <i class="fas fa-exclamation-circle"></i>
          <span><?= Security::e(getFlash('error')) ?></span>
        </div>
        <?php endif; ?>
      </div>

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto px-6 pb-8">
        <?= $content ?>
      </main>
    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });
  </script>
  <script src="<?= url('assets/js/admin.js') ?>"></script>
</body>
</html>
