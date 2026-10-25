<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>500 - System Maintenance | Ecotech Service</title>
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
            <p class="s-display s-mute">500</p>
          </div>
          <div style="grid-column:span 7">
            <p class="s-eyebrow"><?= !empty($isDatabaseError) ? 'Database Configuration' : 'System Notice' ?></p>
            <h1 class="s-h1" style="margin-top:1rem">Temporary system maintenance</h1>
            <p class="s-lede" style="margin-top:1.25rem">
              <?= !empty($isDatabaseError) 
                  ? 'We are currently connecting and synchronizing database services. If you are the system administrator, please ensure the production database credentials in your server environment (.env) are configured.' 
                  : 'The server encountered an unexpected condition and is temporarily unable to fulfill your request. Our engineering team has been notified.' ?>
            </p>
            <ul class="s-list" style="margin-top:2.5rem">
              <li><span class="s-num">01</span><h2 class="s-h3"><a class="s-link" href="<?= url('') ?>">Refresh</a></h2><p>Retry loading the page.</p></li>
              <li><span class="s-num">02</span><h2 class="s-h3"><a class="s-link" href="https://wa.me/917398301184" target="_blank" rel="noopener">WhatsApp Support</a></h2><p>Reach out directly for urgent assistance (+91 7398301184).</p></li>
              <li><span class="s-num">03</span><h2 class="s-h3"><a class="s-link" href="mailto:ecotech.servic@gmail.com">Email Us</a></h2><p>ecotech.servic@gmail.com</p></li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
