<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php 
    $resolvedCanonicalUrl = canonicalUrl($canonicalPath ?? null);
    $resolvedTitle = Security::e($pageTitle ?? APP_NAME);
    $resolvedDesc = Security::e($metaDescription ?? setting('meta_description', 'Ecotech Service — Full-stack web development, digital marketing, cybersecurity, and eco-technology solutions.'));
    $resolvedKeywords = !empty($metaKeywords) 
      ? Security::e($metaKeywords) 
      : 'web development, web security, penetration testing, mobile apps, UI UX design, digital marketing, software company, Lucknow, Ecotech Service';
    $resolvedOgImage = !empty($ogImage) ? $ogImage : url('assets/img/logo.png');
    $resolvedOgType = Security::e($ogType ?? 'website');
  ?>
  <title><?= $resolvedTitle ?></title>
  <meta name="description" content="<?= $resolvedDesc ?>">
  <meta name="keywords" content="<?= $resolvedKeywords ?>">
  <meta name="author" content="Ecotech Service">
  <meta name="robots" content="<?= !empty($robotsMeta) ? Security::e($robotsMeta) : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' ?>">
  <link rel="canonical" href="<?= Security::e($resolvedCanonicalUrl) ?>">

  <!-- Browser UI & Mobile Meta -->
  <meta name="theme-color" content="#030712">
  <meta name="msapplication-TileColor" content="#030712">
  <meta name="format-detection" content="telephone=no">

  <!-- Local SEO & Geo Tags -->
  <meta name="geo.region" content="IN-UP">
  <meta name="geo.placename" content="Lucknow">
  <meta name="geo.position" content="26.8467;80.9462">
  <meta name="ICBM" content="26.8467, 80.9462">

  <!-- Open Graph / Facebook / WhatsApp -->
  <meta property="og:type"        content="<?= $resolvedOgType ?>">
  <meta property="og:url"         content="<?= Security::e($resolvedCanonicalUrl) ?>">
  <meta property="og:title"       content="<?= $resolvedTitle ?>">
  <meta property="og:description" content="<?= $resolvedDesc ?>">
  <meta property="og:site_name"   content="<?= Security::e(setting('site_name', APP_NAME)) ?>">
  <meta property="og:locale"      content="en_US">
  <meta property="og:image"       content="<?= Security::e($resolvedOgImage) ?>">
  <meta property="og:image:alt"   content="<?= $resolvedTitle ?>">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">

  <!-- Twitter Cards -->
  <meta name="twitter:card"        content="summary_large_image">
  <meta name="twitter:url"         content="<?= Security::e($resolvedCanonicalUrl) ?>">
  <meta name="twitter:title"       content="<?= $resolvedTitle ?>">
  <meta name="twitter:description" content="<?= $resolvedDesc ?>">
  <meta name="twitter:image"       content="<?= Security::e($resolvedOgImage) ?>">
  <meta name="twitter:site"        content="@ecotechservice">

  <!-- ── Structured Data (Schema.org JSON-LD) ────────────────────── -->
  <?php
    $breadcrumbsSchema = [
        [
            "@type" => "ListItem",
            "position" => 1,
            "name" => "Home",
            "item" => url()
        ]
    ];

    $currPath = trim($canonicalPath ?? '', '/');
    if (!empty($currPath)) {
        $cleanPath = strtok($currPath, '?');
        $segments = explode('/', $cleanPath);
        $accumulated = '';
        $pos = 2;
        foreach ($segments as $seg) {
            $accumulated .= ($accumulated ? '/' : '') . $seg;
            $segName = ucwords(str_replace(['-', '_'], ' ', $seg));
            if ($seg === 'projects') $segName = 'Portfolio';
            elseif ($seg === 'view' && !empty($project['title'])) $segName = $project['title'];
            elseif ($seg === 'post' && !empty($post['title'])) $segName = $post['title'];
            elseif ($seg === 'services' && !empty($page['service_name'])) $segName = $page['service_name'];

            $breadcrumbsSchema[] = [
                "@type" => "ListItem",
                "position" => $pos++,
                "name" => $segName,
                "item" => url($accumulated)
            ];
        }
    }

    $schemaGraph = [
        [
            "@type" => ["Organization", "ProfessionalService"],
            "@id" => url('#organization'),
            "name" => setting('site_name', APP_NAME),
            "url" => url(),
            "logo" => [
                "@type" => "ImageObject",
                "@id" => url('#logo'),
                "url" => url('assets/img/logo.png'),
                "caption" => setting('site_name', APP_NAME)
            ],
            "image" => url('assets/img/logo.png'),
            "description" => setting('meta_description', 'Ecotech Service provides full-stack web development, digital marketing, cybersecurity, and eco-technology solutions.'),
            "telephone" => setting('site_phone', '+917398301184'),
            "email" => setting('site_email', 'ecotech.servic@gmail.com'),
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => setting('site_address', 'Lucknow uttar pradesh'),
                "addressLocality" => "Lucknow",
                "addressRegion" => "Uttar Pradesh",
                "postalCode" => "226001",
                "addressCountry" => "IN"
            ],
            "geo" => [
                "@type" => "GeoCoordinates",
                "latitude" => 26.8467,
                "longitude" => 80.9462
            ],
            "priceRange" => "$$",
            "openingHoursSpecification" => [
                [
                    "@type" => "OpeningHoursSpecification",
                    "dayOfWeek" => ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                    "opens" => "09:00",
                    "closes" => "19:00"
                ]
            ],
            "sameAs" => array_values(array_filter([
                setting('facebook_url', 'https://facebook.com/ecotechservice'),
                setting('twitter_url', 'https://twitter.com/ecotechservice'),
                setting('linkedin_url', 'https://linkedin.com/company/ecotechservice'),
                setting('instagram_url', 'https://instagram.com/ecotech.service')
            ])),
            "hasOfferCatalog" => [
                "@type" => "OfferCatalog",
                "name" => "Core Technology Services",
                "itemListElement" => [
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "Service",
                            "name" => "Web Development",
                            "url" => url('services#web-development'),
                            "description" => "Full-stack scalable website development, API architecture, and enterprise software."
                        ]
                    ],
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "Service",
                            "name" => "Web Security & Penetration Testing",
                            "url" => url('services#web-security-penetration-testing'),
                            "description" => "Ethical penetration testing, CVE vulnerability assessments, and OWASP security audits."
                        ]
                    ],
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "Service",
                            "name" => "Mobile App Development",
                            "url" => url('services#mobile-app-development'),
                            "description" => "Cross-platform iOS and Android apps built with React Native and Flutter."
                        ]
                    ],
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "Service",
                            "name" => "Cloud & DevOps",
                            "url" => url('services#cloud-devops'),
                            "description" => "AWS, GCP, CI/CD pipeline automation, Docker orchestration, and 24x7 monitoring."
                        ]
                    ],
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "Service",
                            "name" => "UI/UX Design Systems",
                            "url" => url('services#ui-ux-design'),
                            "description" => "Interactive prototypes, design systems, and user-centric wireframes."
                        ]
                    ],
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "Service",
                            "name" => "Digital Marketing & SEO",
                            "url" => url('services#digital-marketing'),
                            "description" => "Data-driven SEO, PPC campaigns, and conversion optimization."
                        ]
                    ]
                ]
            ]
        ],
        [
            "@type" => "WebSite",
            "@id" => url('#website'),
            "url" => url(),
            "name" => setting('site_name', APP_NAME),
            "publisher" => [
                "@id" => url('#organization')
            ],
            "inLanguage" => "en-US",
            "potentialAction" => [
                "@type" => "SearchAction",
                "target" => [
                    "@type" => "EntryPoint",
                    "urlTemplate" => url('search') . '?q={search_term_string}'
                ],
                "query-input" => "required name=search_term_string"
            ]
        ],
        [
            "@type" => "ItemList",
            "@id" => url('#sitenav'),
            "name" => "Top Pages & Core Services",
            "itemListElement" => [
                [
                    "@type" => "SiteNavigationElement",
                    "position" => 1,
                    "name" => "Technology Services",
                    "description" => "Explore custom web development, mobile apps, DevOps, and cybersecurity solutions.",
                    "url" => url('services')
                ],
                [
                    "@type" => "SiteNavigationElement",
                    "position" => 2,
                    "name" => "Web Security & Penetration Testing",
                    "description" => "Ethical security audits, vulnerability assessments, and OWASP compliance testing.",
                    "url" => url('services#web-security-penetration-testing')
                ],
                [
                    "@type" => "SiteNavigationElement",
                    "position" => 3,
                    "name" => "Web Development",
                    "description" => "Scalable websites, custom software, and enterprise web applications.",
                    "url" => url('services#web-development')
                ],
                [
                    "@type" => "SiteNavigationElement",
                    "position" => 4,
                    "name" => "Portfolio & Projects",
                    "description" => "Browse verified live client websites, mobile apps, and case studies.",
                    "url" => url('projects')
                ],
                [
                    "@type" => "SiteNavigationElement",
                    "position" => 5,
                    "name" => "Website Templates",
                    "description" => "Modern responsive HTML5, CSS3, and PHP business website templates.",
                    "url" => url('templates')
                ],
                [
                    "@type" => "SiteNavigationElement",
                    "position" => 6,
                    "name" => "About Us",
                    "description" => "Learn about our company mission, software engineers, and culture.",
                    "url" => url('about')
                ],
                [
                    "@type" => "SiteNavigationElement",
                    "position" => 7,
                    "name" => "Contact Us",
                    "description" => "Get in touch for custom development quotes and consultations.",
                    "url" => url('contact')
                ]
            ]
        ],
        [
            "@type" => "BreadcrumbList",
            "@id" => $resolvedCanonicalUrl . "#breadcrumb",
            "itemListElement" => $breadcrumbsSchema
        ]
    ];

    if (!empty($post) && ($ogType ?? '') === 'article') {
        $schemaGraph[] = [
            "@type" => "BlogPosting",
            "@id" => $resolvedCanonicalUrl . "#article",
            "isPartOf" => [
                "@id" => url('#website')
            ],
            "headline" => $pageTitle ?? $post['title'],
            "description" => $metaDescription ?? '',
            "inLanguage" => "en-US",
            "mainEntityOfPage" => $resolvedCanonicalUrl,
            "datePublished" => date('c', strtotime($post['published_at'] ?? $post['created_at'])),
            "dateModified" => date('c', strtotime($post['updated_at'] ?? $post['published_at'] ?? $post['created_at'])),
            "author" => [
                "@type" => "Person",
                "name" => $post['author_name'] ?? 'Ecotech Service Team'
            ],
            "publisher" => [
                "@id" => url('#organization')
            ],
            "image" => !empty($post['thumbnail']) ? uploadUrl($post['thumbnail']) : url('assets/img/logo.png')
        ];
    }

    if (!empty($page)) {
        $schemaGraph[] = [
            "@type" => "Service",
            "@id" => $resolvedCanonicalUrl . "#service",
            "name" => $page['service_name'] ?? 'IT Services',
            "serviceType" => $page['service_name'] ?? 'Software & Web Development',
            "provider" => [
                "@id" => url('#organization')
            ],
            "areaServed" => [
                "@type" => "AdministrativeArea",
                "name" => $page['location'] ?? 'Lucknow'
            ],
            "description" => $page['meta_description'] ?? ''
        ];
    }
  ?>
  <script type="application/ld+json">
  <?= json_encode(['@context' => 'https://schema.org', '@graph' => $schemaGraph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
  </script>

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="<?= url('assets/img/favicon.svg?v=2') ?>">
  <link rel="alternate icon" href="<?= url('assets/img/favicon.svg?v=2') ?>">
  <link rel="apple-touch-icon" href="<?= url('assets/img/favicon.svg?v=2') ?>">

  <!-- Resource hints for external origins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
  <link rel="dns-prefetch" href="https://www.googletagmanager.com">
  <link rel="dns-prefetch" href="https://image.thum.io">

  <!-- Design system — loaded first, critical path -->
  <?php $siteCssV = file_exists(PUBLIC_PATH . '/assets/css/site.css') ? filemtime(PUBLIC_PATH . '/assets/css/site.css') : APP_VERSION; ?>
  <link rel="preload" href="<?= url('assets/css/site.css') ?>?v=<?= $siteCssV ?>" as="style">
  <link rel="stylesheet" href="<?= url('assets/css/site.css') ?>?v=<?= $siteCssV ?>">

  <!-- Type: Fraunces + IBM Plex Sans / Mono — non-blocking -->
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;1,9..144,400;1,9..144,500&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;1,9..144,400;1,9..144,500&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet"></noscript>

  <!-- Font Awesome — non-blocking -->
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></noscript>
  <script>document.documentElement.classList.add('s-js');</script>

  <!-- Google tag (gtag.js) — async, non-blocking -->
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
<body class="s-body">

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M86QQPKV"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <a class="s-skip" href="#main">Skip to content</a>

  <?php
  $rawPath = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '', '/');
  $appPath = trim(parse_url(APP_URL, PHP_URL_PATH) ?: '', '/');
  if ($appPath && str_starts_with($rawPath, $appPath)) {
      $currentRoute = trim(substr($rawPath, strlen($appPath)), '/');
  } else {
      $currentRoute = $rawPath;
  }

  $navItems = [
      'about'       => 'About',
      'services'    => 'Services',
      'projects'    => 'Work',
      'internships' => 'Internships',
      'templates'   => 'Templates',
      'blog'        => 'Journal',
      'contact'     => 'Contact',
  ];
  $isCurrent = static function (string $path) use ($currentRoute): bool {
      if ($path === '') return $currentRoute === '';
      return $currentRoute === $path || str_starts_with($currentRoute, $path . '/');
  };

  $siteEmail    = setting('site_email')    ?: 'ecotech.internships@gmail.com';
  $sitePhone    = setting('site_phone')    ?: '+91 7398301184';
  $siteAddr     = setting('site_address')  ?: 'Lucknow, Uttar Pradesh, India';
  $siteHours    = setting('business_hours') ?: 'Mon – Sat, 09:00 – 18:00 IST';
  $waNumber     = preg_replace('/\D+/', '', (string) (setting('whatsapp_number') ?: WHATSAPP_NUMBER));
  $linkedinUrl  = setting('linkedin_url',  '');
  $twitterUrl   = setting('twitter_url',   '');
  $instagramUrl = setting('instagram_url', '');
  $githubUrl    = setting('github_url',    '');
  ?>

  <!-- ══ Header ════════════════════════════════════════════════════════ -->
  <header id="navbar" class="s-nav">
    <div class="s-shell s-nav-in">
      <a href="<?= url() ?>" class="s-logo" aria-label="Ecotech Service — home">
        <?php /* Inline SVG logo — no HTTP request, crisp at all resolutions */ ?>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40" aria-hidden="true" focusable="false">
          <path d="M6 28C4 22 7 14 13 9L23 5C27 3 32 6 33 12C34 18 31 24 25 29L16 34C11 36 7 34 6 28Z" fill="#2C5F42"/>
          <line x1="7" y1="32" x2="32" y2="9" stroke="#6ee7b7" stroke-width="1.8" stroke-linecap="round"/>
          <path d="M13 25L10 20L14 13" fill="none" stroke="#6ee7b7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M20 18L18 13L23 9" fill="none" stroke="#6ee7b7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M21 27L26 27L29 22" fill="none" stroke="#6ee7b7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="14" cy="13" r="1.8" fill="#fff"/>
          <circle cx="23" cy="9"  r="1.8" fill="#fff"/>
          <circle cx="29" cy="22" r="1.8" fill="#fff"/>
        </svg>
        <span class="s-logo-text">
          <span class="s-logo-name">Ecotech</span>
          <span class="s-logo-tag">Service</span>
        </span>
      </a>

      <nav aria-label="Main">
        <ul class="s-nav-links">
          <?php foreach ($navItems as $path => $label): ?>
          <li><a href="<?= url($path) ?>"<?= $isCurrent($path) ? ' aria-current="page"' : '' ?>><?= Security::e($label) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <div class="s-nav-end">
        <a href="<?= url('search') ?>" class="s-nav-search" aria-label="Search the site">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        </a>
        <?php if (function_exists('isIntern') && isIntern()): ?>
          <a href="<?= url('internships/dashboard') ?>" class="s-btn--line s-btn--sm s-nav-cta">My dashboard</a>
        <?php endif; ?>
        <a href="<?= url('contact') ?>" class="s-btn s-btn--sm s-nav-cta">Start a project</a>
        <button id="mobileDrawerOpen" type="button" class="s-burger" aria-controls="mobileDrawer" aria-expanded="false">Menu</button>
      </div>
    </div>
  </header>

  <!-- ══ Mobile drawer (hooks used by app.js) ══════════════════════════ -->
  <div id="mobileDrawerOverlay" aria-hidden="true"></div>
  <aside id="mobileDrawer" aria-label="Menu" aria-hidden="true">
    <div class="s-drawer-head">
      <a href="<?= url() ?>" class="s-logo" aria-label="Ecotech Service — home">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="36" height="36" aria-hidden="true" focusable="false">
          <path d="M6 28C4 22 7 14 13 9L23 5C27 3 32 6 33 12C34 18 31 24 25 29L16 34C11 36 7 34 6 28Z" fill="#2C5F42"/>
          <line x1="7" y1="32" x2="32" y2="9" stroke="#6ee7b7" stroke-width="1.8" stroke-linecap="round"/>
          <path d="M13 25L10 20L14 13" fill="none" stroke="#6ee7b7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M20 18L18 13L23 9" fill="none" stroke="#6ee7b7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M21 27L26 27L29 22" fill="none" stroke="#6ee7b7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="14" cy="13" r="1.8" fill="#fff"/>
          <circle cx="23" cy="9"  r="1.8" fill="#fff"/>
          <circle cx="29" cy="22" r="1.8" fill="#fff"/>
        </svg>
        <span class="s-logo-text">
          <span class="s-logo-name">Ecotech</span>
          <span class="s-logo-tag">Service</span>
        </span>
      </a>
      <button id="mobileDrawerClose" type="button" class="s-burger" style="display:inline-flex">Close</button>
    </div>
    <ul class="s-drawer-nav">
      <li><a href="<?= url() ?>"<?= $isCurrent('') ? ' aria-current="page"' : '' ?>>Home <span class="s-num">00</span></a></li>
      <?php $n = 0; foreach ($navItems as $path => $label): $n++; ?>
      <li><a href="<?= url($path) ?>"<?= $isCurrent($path) ? ' aria-current="page"' : '' ?>><?= Security::e($label) ?> <span class="s-num"><?= sprintf('%02d', $n) ?></span></a></li>
      <?php endforeach; ?>
      <li><a href="<?= url('search') ?>">Search <span class="s-num"><?= sprintf('%02d', $n + 1) ?></span></a></li>
    </ul>
    <div class="s-drawer-foot">
      <p style="margin:0 0 .25rem"><a class="s-link" href="mailto:<?= Security::e($siteEmail) ?>"><?= Security::e($siteEmail) ?></a></p>
      <p style="margin:0 0 1rem"><a class="s-link" href="tel:<?= Security::e(preg_replace('/\s+/', '', $sitePhone)) ?>"><?= Security::e($sitePhone) ?></a></p>
      <div class="s-actions">
        <a href="<?= url('contact') ?>" class="s-btn s-btn--sm">Start a project</a>
        <?php if ($waNumber): ?>
        <a href="https://wa.me/<?= Security::e($waNumber) ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20project." class="s-btn--line s-btn--sm" target="_blank" rel="noopener">WhatsApp</a>
        <?php endif; ?>
      </div>
    </div>
  </aside>

  <!-- ══ Flash messages (hook: #flashMsg) ══════════════════════════════ -->
  <?php if (hasFlash('success')): ?>
  <div id="flashMsg" class="s-flash" role="status">
    <span><?= Security::e(getFlash('success')) ?></span>
    <button type="button" onclick="this.parentElement.remove()" aria-label="Dismiss">&times;</button>
  </div>
  <?php endif; ?>
  <?php if (hasFlash('error')): ?>
  <div id="flashMsg" class="s-flash s-flash--error" role="alert">
    <span><?= Security::e(getFlash('error')) ?></span>
    <button type="button" onclick="this.parentElement.remove()" aria-label="Dismiss">&times;</button>
  </div>
  <?php endif; ?>

  <!-- ══ Page ══════════════════════════════════════════════════════════ -->
  <main id="main" class="s-main">
    <?= $content ?>
  </main>

  <!-- ══ Footer ════════════════════════════════════════════════════════ -->
  <footer class="s-foot">
    <div class="s-shell">
      <div class="s-grid" style="align-items:end">
        <p class="s-foot-big" style="grid-column:span 8;margin:0">A platform to build, a product to ship, or a system that needs fixing &mdash; let&rsquo;s talk.</p>
        <div style="grid-column:span 4" class="s-actions lg:justify-end">
          <a href="<?= url('contact') ?>" class="s-btn--light">Start a project</a>
          <a href="mailto:<?= Security::e($siteEmail) ?>" class="s-btn--line" style="color:var(--band-fg);border-color:var(--band-fg)">Email us</a>
        </div>
      </div>

      <div class="s-foot-cols">
        <div>
          <a href="<?= url() ?>" class="s-logo" aria-label="Ecotech Service — home" style="display:inline-flex">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="36" height="36" aria-hidden="true" focusable="false">
              <path d="M6 28C4 22 7 14 13 9L23 5C27 3 32 6 33 12C34 18 31 24 25 29L16 34C11 36 7 34 6 28Z" fill="#2C5F42"/>
              <line x1="7" y1="32" x2="32" y2="9" stroke="#6ee7b7" stroke-width="1.8" stroke-linecap="round"/>
              <path d="M13 25L10 20L14 13" fill="none" stroke="#6ee7b7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M20 18L18 13L23 9" fill="none" stroke="#6ee7b7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M21 27L26 27L29 22" fill="none" stroke="#6ee7b7" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
              <circle cx="14" cy="13" r="1.8" fill="#fff"/>
              <circle cx="23" cy="9"  r="1.8" fill="#fff"/>
              <circle cx="29" cy="22" r="1.8" fill="#fff"/>
            </svg>
            <span class="s-logo-text">
              <span class="s-logo-name" style="color:var(--band-fg)">Ecotech</span>
              <span class="s-logo-tag" style="color:var(--band-mute)">Service</span>
            </span>
          </a>
          <p class="s-small" style="color:var(--band-mute);margin-top:1rem;max-width:34ch">
            Software engineering studio in Lucknow. We build web platforms, mobile apps and
            serverless systems, then maintain them.
          </p>
          <!-- Social links -->
          <?php
          $socials = array_filter([
            'LinkedIn'  => $linkedinUrl,
            'Twitter'   => $twitterUrl,
            'Instagram' => $instagramUrl,
            'GitHub'    => $githubUrl,
            'WhatsApp'  => $waNumber ? "https://wa.me/{$waNumber}" : '',
          ]);
          $socialIcons = [
            'LinkedIn'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>',
            'Twitter'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>',
            'Instagram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
            'GitHub'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.4 5.4 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/></svg>',
            'WhatsApp'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>',
          ]);
          if ($socials): ?>
          <div class="s-foot-social">
            <?php foreach ($socials as $name => $href): ?>
            <a href="<?= Security::e($href) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= Security::e($name) ?>" title="<?= Security::e($name) ?>">
              <?= $socialIcons[$name] ?? '' ?>
            </a>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
        <div>
          <h2>Services</h2>
          <ul>
            <li><a href="<?= url('services#web') ?>">Web development</a></li>
            <li><a href="<?= url('services#mobile') ?>">Mobile apps</a></li>
            <li><a href="<?= url('services#cloud') ?>">Cloud &amp; DevOps</a></li>
            <li><a href="<?= url('services#security') ?>">Security testing</a></li>
            <li><a href="<?= url('templates') ?>">Templates</a></li>
          </ul>
        </div>
        <div>
          <h2>Studio</h2>
          <ul>
            <li><a href="<?= url('about') ?>">About</a></li>
            <li><a href="<?= url('projects') ?>">Work</a></li>
            <li><a href="<?= url('blog') ?>">Journal</a></li>
            <li><a href="<?= url('internships') ?>">Internships</a></li>
            <li><a href="<?= url('search') ?>">Search</a></li>
          </ul>
        </div>
        <div>
          <h2>Contact</h2>
          <ul>
            <li><a href="mailto:<?= Security::e($siteEmail) ?>"><?= Security::e($siteEmail) ?></a></li>
            <li><a href="tel:<?= Security::e(preg_replace('/\s+/', '', $sitePhone)) ?>"><?= Security::e($sitePhone) ?></a></li>
            <?php if ($waNumber): ?>
            <li><a href="https://wa.me/<?= Security::e($waNumber) ?>" target="_blank" rel="noopener">WhatsApp</a></li>
            <?php endif; ?>
            <li style="color:var(--band-mute)"><?= Security::e($siteHours) ?></li>
          </ul>
        </div>
        <div>
          <h2>Legal</h2>
          <ul>
            <li><a href="<?= url('terms') ?>">Terms of Service</a></li>
            <li><a href="<?= url('privacy') ?>">Privacy Policy</a></li>
            <li><a href="<?= url('privacy#cookies') ?>">Cookies</a></li>
            <li><a href="<?= url('privacy#security') ?>">Security</a></li>
          </ul>
        </div>
      </div>

      <div class="s-foot-base">
        <span>&copy; <?= date('Y') ?> <?= Security::e(defined('COMPANY_LEGAL_NAME') ? COMPANY_LEGAL_NAME : APP_NAME) ?> &middot; <?= Security::e($siteAddr) ?></span>
        <span><a href="<?= url('terms') ?>">Terms</a> &middot; <a href="<?= url('privacy') ?>">Privacy</a> &middot; <a href="<?= url('services/web-development-in-lucknow') ?>">Sitemap</a></span>
      </div>
    </div>
  </footer>

  <!-- ══ Mobile bottom bar ═════════════════════════════════════════════ -->
  <nav id="mobileBottomNav" class="s-bottom" aria-label="Quick links">
    <a href="<?= url('') ?>"<?= $isCurrent('') ? ' aria-current="page"' : '' ?>>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Home
    </a>
    <a href="<?= url('services') ?>"<?= $isCurrent('services') ? ' aria-current="page"' : '' ?>>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
      Services
    </a>
    <a href="<?= url('projects') ?>"<?= $isCurrent('projects') ? ' aria-current="page"' : '' ?>>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
      Work
    </a>
    <a href="<?= url('contact') ?>"<?= $isCurrent('contact') ? ' aria-current="page"' : '' ?>>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
      Contact
    </a>
  </nav>

  <script src="<?= url('assets/js/app.js') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/js/app.js') ? filemtime(PUBLIC_PATH . '/assets/js/app.js') : APP_VERSION ?>"></script>
</body>
</html>
