<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title><?= Security::e($pageTitle ?? 'Admin — ' . APP_NAME) ?></title>
  <link rel="icon" type="image/svg+xml" href="<?= url('assets/img/favicon.svg?v=2') ?>">
  <link rel="alternate icon" href="<?= url('assets/img/favicon.svg?v=2') ?>">
  <link rel="apple-touch-icon" href="<?= url('assets/img/favicon.svg?v=2') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            paper:  { DEFAULT: '#EDEAE2', deep: '#E3DFD5' },
            ink:    { DEFAULT: '#191A17', soft: '#43453E', mute: '#6E7066' },
            rule:   { DEFAULT: '#C9C4B6' },
            signal: { DEFAULT: '#2C5F42' },
          },
          fontFamily: { sans: ['"IBM Plex Sans"', 'system-ui', 'sans-serif'], display: ['Fraunces', 'Georgia', 'serif'], mono: ['"IBM Plex Mono"', 'monospace'] },
          borderRadius: { DEFAULT: '2px', sm: '1px', md: '2px', lg: '2px', xl: '2px', '2xl': '2px', full: '9999px' },
        }
      }
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="<?= url('assets/css/site.css') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/css/site.css') ? filemtime(PUBLIC_PATH . '/assets/css/site.css') : APP_VERSION ?>">
  <link rel="stylesheet" href="<?= url('assets/css/admin.css') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/css/admin.css') ? filemtime(PUBLIC_PATH . '/assets/css/admin.css') : APP_VERSION ?>">

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-M86QQPKV');</script>
  <!-- End Google Tag Manager -->
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-YDLMY8N3C4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-YDLMY8N3C4');
  </script>
</head>
<body class="a-body">

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M86QQPKV"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <?php
  $adminNav = [
      ['icon' => 'fa-gauge',          'label' => 'Dashboard',    'path' => 'admin/dashboard'],
      ['icon' => 'fa-file-lines',     'label' => 'Applications', 'path' => 'admin/applications'],
      ['icon' => 'fa-layer-group',    'label' => 'Internships',  'path' => 'admin/tracks'],
      ['icon' => 'fa-user-graduate',  'label' => 'Interns',      'path' => 'admin/interns'],
      ['icon' => 'fa-briefcase',      'label' => 'Projects',     'path' => 'admin/projects'],
      ['icon' => 'fa-gears',          'label' => 'Services',     'path' => 'admin/services'],
      ['icon' => 'fa-quote-left',     'label' => 'Testimonials', 'path' => 'admin/testimonials'],
      ['icon' => 'fa-envelope',       'label' => 'Contacts',     'path' => 'admin/contacts'],
      ['icon' => 'fa-pen-nib',        'label' => 'Blog',         'path' => 'admin/blog'],
      ['icon' => 'fa-sliders',        'label' => 'Settings',     'path' => 'admin/settings'],
      ['icon' => 'fa-database',       'label' => 'Database check', 'path' => 'admin/database'],
  ];
  // Route relative to the app base, same approach as the public layout.
  $rawPath = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '', '/');
  $appPath = trim(parse_url(APP_URL, PHP_URL_PATH) ?: '', '/');
  $curPage = ($appPath && str_starts_with($rawPath, $appPath)) ? trim(substr($rawPath, strlen($appPath)), '/') : $rawPath;
  ?>
  <div class="a-app">
    <aside id="sidebar" class="a-side" aria-label="Admin navigation">
      <div class="a-side-head">
        <a href="<?= url('admin/dashboard') ?>">Ecotech</a>
        <small>Admin panel</small>
      </div>
      <ul class="a-nav">
        <?php foreach ($adminNav as $item): $active = str_starts_with($curPage, $item['path']); ?>
        <li>
          <a href="<?= url($item['path']) ?>"<?= $active ? ' aria-current="page"' : '' ?>>
            <i class="fas <?= $item['icon'] ?>" aria-hidden="true"></i><span><?= Security::e($item['label']) ?></span>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
      <div class="a-side-foot">
        <p style="color:var(--band-fg)"><?= Security::e($_SESSION['admin_name'] ?? '') ?></p>
        <p style="color:var(--band-mute);font-size:.75rem;text-transform:capitalize;margin-bottom:.75rem"><?= Security::e($_SESSION['admin_role'] ?? '') ?></p>
        <p><a href="<?= url() ?>" target="_blank" rel="noopener">View site</a> &middot; <a href="<?= url('admin/logout') ?>">Log out</a></p>
      </div>
    </aside>
    <div id="sidebarOverlay" class="a-overlay" aria-hidden="true"></div>

    <div class="a-main">
      <header class="a-top">
        <div style="display:flex;align-items:center;gap:.75rem">
          <button id="sidebarToggle" type="button" class="a-burger" aria-controls="sidebar" aria-expanded="false">Menu</button>
          <h1><?= Security::e($pageTitle ?? 'Admin panel') ?></h1>
        </div>
        <span class="s-mono s-mute"><?= date('d M Y') ?></span>
      </header>

      <div class="a-content">
        <?php if (hasFlash('success')): ?>
        <div class="a-flash" role="status"><?= Security::e(getFlash('success')) ?></div>
        <?php endif; ?>
        <?php if (hasFlash('error')): ?>
        <div class="a-flash a-flash--error" role="alert"><?= Security::e(getFlash('error')) ?></div>
        <?php endif; ?>

        <main>
          <?= $content ?>
        </main>
      </div>
    </div>
  </div>

  <script src="<?= url('assets/js/admin.js') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/js/admin.js') ? filemtime(PUBLIC_PATH . '/assets/js/admin.js') : APP_VERSION ?>"></script>
</body>
</html>
