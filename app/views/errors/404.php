<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, follow">
  <title>404 - Page Not Found | Ecotech Service</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;1,9..144,400;1,9..144,500&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= url('assets/css/site.css') ?>">
</head>
<body class="s-body">
  <main>
    <section class="s-sec" style="min-height:100vh;display:flex;align-items:center">
      <div class="s-shell" style="width:100%">
        <div class="s-grid">
          <div style="grid-column:span 5">
            <p class="s-display s-mute">404</p>
          </div>
          <div style="grid-column:span 7">
            <p class="s-eyebrow">Error 404</p>
            <h1 class="s-h1" style="margin-top:1rem">Page not found</h1>
            <p class="s-lede" style="margin-top:1.25rem">The page you were looking for does not exist or has moved.</p>
            <ul class="s-list" style="margin-top:2.5rem">
              <li><span class="s-num">01</span><h2 class="s-h3"><a class="s-link" href="<?= url('') ?>">Home</a></h2><p>Start from the front page.</p></li>
              <li><span class="s-num">02</span><h2 class="s-h3"><a class="s-link" href="<?= url('services') ?>">Services</a></h2><p>What we build and support.</p></li>
              <li><span class="s-num">03</span><h2 class="s-h3"><a class="s-link" href="<?= url('projects') ?>">Projects</a></h2><p>Recent case studies.</p></li>
              <li><span class="s-num">04</span><h2 class="s-h3"><a class="s-link" href="<?= url('contact') ?>">Contact</a></h2><p>Tell us what you were looking for.</p></li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
