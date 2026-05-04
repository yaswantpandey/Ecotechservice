<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= Security::e($pageTitle ?? 'Admin Login') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
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
</head>
<body class="bg-gray-950 text-gray-100 font-sans antialiased">
  <?= $content ?>
</body>
</html>
