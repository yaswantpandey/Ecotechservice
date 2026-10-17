<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title><?= Security::e($pageTitle ?? 'Admin Login') ?></title>
  <link rel="icon" type="image/svg+xml" href="<?= url('assets/img/favicon.svg?v=2') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="<?= url('assets/css/site.css') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/css/site.css') ? filemtime(PUBLIC_PATH . '/assets/css/site.css') : APP_VERSION ?>">
  <link rel="stylesheet" href="<?= url('assets/css/admin.css') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/css/admin.css') ? filemtime(PUBLIC_PATH . '/assets/css/admin.css') : APP_VERSION ?>">
</head>
<body class="a-body">
  <?= $content ?>
</body>
</html>
