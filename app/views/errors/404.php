<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, follow">
  <title>404 - Page Not Found | Ecotech Service</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen flex items-center justify-center font-sans">
  <div class="text-center px-4">
    <div class="text-[120px] font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-green-600 leading-none mb-4">404</div>
    <h1 class="text-2xl font-bold text-white mb-2" style="font-family:'Space Grotesk',sans-serif">Page Not Found</h1>
    <p class="text-gray-400 mb-8">The page you're looking for doesn't exist or has been moved.</p>
    <a href="<?= defined('APP_URL') ? APP_URL : '/' ?>"
       class="inline-flex items-center px-6 py-3 bg-green-500 hover:bg-green-400 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-green-500/25">
      <i class="fas fa-home mr-2"></i>Go Home
    </a>
  </div>
</body>
</html>
