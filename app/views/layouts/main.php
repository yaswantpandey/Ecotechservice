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

  <!-- Google Fonts & Material Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Editorial type pair: Instrument Serif (display) + IBM Plex Sans/Mono (workhorse) -->
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
  <!-- Home + footer pair: Fraunces (warm display) + Figtree (friendly humanist body) -->
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined|Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

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
            },
            // Editorial palette (home + legal pages): graphite ink on warm paper
            paper:  { DEFAULT: '#EDEAE2', deep: '#E3DFD5', dark: '#1B1C19' },
            ink:    { DEFAULT: '#191A17', soft: '#43453E', mute: '#6E7066' },
            rule:   { DEFAULT: '#C9C4B6', soft: '#D8D4C8' },
            signal: { DEFAULT: '#2C5F42', bright: '#3C7E56' },
          },
          fontFamily: {
            sans:    ['Inter', 'system-ui', 'sans-serif'],
            display: ['Space Grotesk', 'Inter', 'sans-serif'],
            edit:    ['"Instrument Serif"', 'Georgia', 'serif'],
            plex:    ['"IBM Plex Sans"', 'system-ui', 'sans-serif'],
            spec:    ['"IBM Plex Mono"', 'ui-monospace', 'monospace'],
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

  <!-- ── Page Loader CSS ──────────────────────────────────────── -->
  <style>
    #page-loader {
      position: fixed;
      inset: 0;
      z-index: 9999;
      background: #030712;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 1.5rem;
      transition: opacity 0.5s ease, visibility 0.5s ease;
    }
    #page-loader.loader-hidden {
      opacity: 0;
      visibility: hidden;
      pointer-events: none;
    }
    .loader-logo {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      animation: loaderPulse 1.4s ease-in-out infinite;
    }
    .loader-logo-icon {
      width: 42px;
      height: 42px;
      border-radius: 10px;
      background: #0f1a12;
      border: 1px solid rgba(74,222,128,0.25);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 6px;
    }
    .loader-logo-icon img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }
    .loader-logo-text {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 1.3rem;
      font-weight: 700;
      color: #f9fafb;
      letter-spacing: -0.01em;
    }
    .loader-logo-text span { color: #4ade80; }
    /* Spinner ring */
    .loader-ring {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      border: 2.5px solid rgba(74,222,128,0.12);
      border-top-color: #4ade80;
      animation: loaderSpin 0.85s linear infinite;
    }
    /* Dots progress bar */
    .loader-dots {
      display: flex;
      gap: 6px;
    }
    .loader-dots span {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: rgba(74,222,128,0.25);
      animation: loaderDot 1.2s ease-in-out infinite;
    }
    .loader-dots span:nth-child(2) { animation-delay: 0.2s; }
    .loader-dots span:nth-child(3) { animation-delay: 0.4s; }
    @keyframes loaderSpin {
      to { transform: rotate(360deg); }
    }
    @keyframes loaderPulse {
      0%, 100% { opacity: 1; }
      50%       { opacity: 0.6; }
    }
    @keyframes loaderDot {
      0%, 80%, 100% { background: rgba(74,222,128,0.2); transform: scale(0.8); }
      40%           { background: #4ade80;               transform: scale(1.3); }
    }
    /* Freeze scroll while loading */
    body.loading { overflow: hidden; }
  </style>
</head>
<body class="bg-gray-950 text-gray-100 font-sans antialiased loading">

  <!-- ── Page Loader ───────────────────────────────────────────── -->
  <div id="page-loader" role="status" aria-label="Loading">
    <div class="loader-logo">
      <img src="<?= url('assets/img/logo.png') ?>" alt="EcoTech Services" loading="eager"
           style="height:70px;width:auto;object-fit:contain;mix-blend-mode:screen;filter:brightness(1.3) contrast(1.1);">
    </div>
    <div class="loader-ring"></div>
    <div class="loader-dots">
      <span></span><span></span><span></span>
    </div>
  </div>

  <!-- Custom Pointer Cursor -->
  <div id="customCursor"></div>
  <div id="customCursorDot"></div>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M86QQPKV"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <!-- ══ ONE SIMPLE UNIFIED NAVBAR ════════════════════════════════════ -->
  <?php
  $rawPath = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '', '/');
  $appPath = trim(parse_url(APP_URL, PHP_URL_PATH) ?: '', '/');
  if ($appPath && str_starts_with($rawPath, $appPath)) {
      $currentRoute = trim(substr($rawPath, strlen($appPath)), '/');
  } else {
      $currentRoute = $rawPath;
  }
  ?>
  <header id="navbar" class="site-navbar fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
      <div class="flex items-center justify-between h-[76px] md:h-[84px] lg:h-[88px]">

        <!-- ── 1. Company Logo (Significantly Increased Size) ──────────── -->
        <a href="<?= url() ?>" class="site-logo-link flex items-center shrink-0 py-1" aria-label="EcoTech Services Home">
          <img src="<?= url('assets/img/logo.png') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/img/logo.png') ? filemtime(PUBLIC_PATH . '/assets/img/logo.png') : '3' ?>"
               alt="EcoTech Services"
               class="site-logo"
               loading="eager">
        </a>

        <!-- ── 2. Center Nav Links (Desktop — Clean Rectangular, Material UI Icons) ── -->
        <nav class="hidden lg:flex items-center gap-1 xl:gap-2" aria-label="Main Navigation">
          <?php
          $navItems = [
            ''          => ['label' => 'Home',      'icon' => 'home'],
            'about'     => ['label' => 'About',     'icon' => 'info'],
            'services'  => ['label' => 'Services',  'icon' => 'miscellaneous_services', 'hasDropdown' => true],
  'projects'  => ['label' => 'Portfolio', 'icon' => 'work_outline'],
  'internships' => ['label' => 'Internships', 'icon' => 'school'],
  'templates' => ['label' => 'Templates', 'icon' => 'dashboard_customize'],
            'blog'      => ['label' => 'Blog',      'icon' => 'article'],
            'contact'   => ['label' => 'Contact',   'icon' => 'mail_outline'],
          ];

          foreach ($navItems as $path => $item):
            $isActive = ($currentRoute === $path || ($path !== '' && str_starts_with($currentRoute, $path)));
            $hasDropdown = !empty($item['hasDropdown']);
          ?>

          <?php if ($hasDropdown): ?>
          <!-- Services Dropdown (Rectangular styling, No circular design) -->
          <div class="nav-dropdown-wrapper relative group" id="servicesDropdown">
            <a href="<?= url('services') ?>"
               class="nav-link <?= $isActive ? 'nav-link-active' : '' ?>"
               aria-expanded="false"
               aria-haspopup="true">
              <span class="material-icons-outlined nav-link-icon"><?= $item['icon'] ?></span>
              <span class="nav-link-text"><?= $item['label'] ?></span>
              <span class="material-icons-outlined nav-dropdown-arrow transition-transform duration-200 group-hover:rotate-180">expand_more</span>
            </a>

            <!-- Dropdown Panel (Sleek rectangular card, rounded-md) -->
            <div class="nav-dropdown-menu absolute top-full left-1/2 -translate-x-1/2 pt-2 opacity-0 invisible pointer-events-none group-hover:opacity-100 group-hover:visible group-hover:pointer-events-auto transition-all duration-200 transform translate-y-1 group-hover:translate-y-0 z-50">
              <div class="nav-dropdown-box w-[520px] p-4 bg-[#070d18]/95 backdrop-blur-xl border border-slate-800 shadow-2xl rounded-md">
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-800/80 px-2">
                  <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                    <span class="material-icons-outlined text-sm text-eco-400">layers</span>
                    Engineering &amp; IT Solutions
                  </span>
                  <span class="text-[11px] text-slate-500 font-medium">Enterprise Grade</span>
                </div>

                <div class="grid grid-cols-2 gap-2">
                  <a href="<?= url('services#web') ?>" class="nav-dropdown-item group/item">
                    <div class="nav-drop-icon bg-eco-500/10 border border-eco-500/20 text-eco-400 group-hover/item:bg-eco-500/20 group-hover/item:border-eco-500/40">
                      <span class="material-icons-outlined text-base">code</span>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-slate-200 group-hover/item:text-white">Web Development</div>
                      <div class="text-[11px] text-slate-400 line-clamp-1">Enterprise apps &amp; portals</div>
                    </div>
                  </a>

                  <a href="<?= url('services#mobile') ?>" class="nav-dropdown-item group/item">
                    <div class="nav-drop-icon bg-blue-500/10 border border-blue-500/20 text-blue-400 group-hover/item:bg-blue-500/20 group-hover/item:border-blue-500/40">
                      <span class="material-icons-outlined text-base">smartphone</span>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-slate-200 group-hover/item:text-white">Mobile Apps</div>
                      <div class="text-[11px] text-slate-400 line-clamp-1">iOS, Android &amp; Flutter</div>
                    </div>
                  </a>

                  <a href="<?= url('services#cloud') ?>" class="nav-dropdown-item group/item">
                    <div class="nav-drop-icon bg-purple-500/10 border border-purple-500/20 text-purple-400 group-hover/item:bg-purple-500/20 group-hover/item:border-purple-500/40">
                      <span class="material-icons-outlined text-base">cloud</span>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-slate-200 group-hover/item:text-white">Cloud &amp; DevOps</div>
                      <div class="text-[11px] text-slate-400 line-clamp-1">AWS, GCP &amp; CI/CD</div>
                    </div>
                  </a>

                  <a href="<?= url('services#security') ?>" class="nav-dropdown-item group/item">
                    <div class="nav-drop-icon bg-amber-500/10 border border-amber-500/20 text-amber-400 group-hover/item:bg-amber-500/20 group-hover/item:border-amber-500/40">
                      <span class="material-icons-outlined text-base">security</span>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-slate-200 group-hover/item:text-white">Web Security &amp; VAPT</div>
                      <div class="text-[11px] text-slate-400 line-clamp-1">OWASP audits &amp; pen-testing</div>
                    </div>
                  </a>

                  <a href="<?= url('services#seo') ?>" class="nav-dropdown-item group/item">
                    <div class="nav-drop-icon bg-rose-500/10 border border-rose-500/20 text-rose-400 group-hover/item:bg-rose-500/20 group-hover/item:border-rose-500/40">
                      <span class="material-icons-outlined text-base">trending_up</span>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-slate-200 group-hover/item:text-white">SEO &amp; Marketing</div>
                      <div class="text-[11px] text-slate-400 line-clamp-1">Growth &amp; search rankings</div>
                    </div>
                  </a>

                  <a href="<?= url('services#design') ?>" class="nav-dropdown-item group/item">
                    <div class="nav-drop-icon bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 group-hover/item:bg-cyan-500/20 group-hover/item:border-cyan-500/40">
                      <span class="material-icons-outlined text-base">palette</span>
                    </div>
                    <div>
                      <div class="text-xs font-semibold text-slate-200 group-hover/item:text-white">UI/UX Design</div>
                      <div class="text-[11px] text-slate-400 line-clamp-1">Design systems &amp; prototypes</div>
                    </div>
                  </a>
                </div>

                <div class="mt-3 pt-3 border-t border-slate-800/80 flex items-center justify-between px-2">
                  <a href="<?= url('services') ?>" class="text-xs font-semibold text-eco-400 hover:text-eco-300 flex items-center gap-1.5 transition-colors">
                    <span>View All Services</span>
                    <span class="material-icons-outlined text-sm">arrow_forward</span>
                  </a>
                  <a href="<?= url('contact') ?>" class="text-[11px] font-semibold text-slate-300 bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700 px-2.5 py-1 rounded-sm flex items-center gap-1 transition-colors">
                    <span class="material-icons-outlined text-xs text-amber-400">bolt</span>
                    <span>Free Tech Consultation</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <?php else: ?>
          <a href="<?= url($path) ?>"
             class="nav-link <?= $isActive ? 'nav-link-active' : '' ?>">
            <span class="material-icons-outlined nav-link-icon"><?= $item['icon'] ?></span>
            <span class="nav-link-text"><?= $item['label'] ?></span>
          </a>
          <?php endif; ?>
          <?php endforeach; ?>
        </nav>

        <!-- ── 3. Right Action Buttons (Rectangular, Strictly No Circular Design) ── -->
        <div class="flex items-center gap-2 sm:gap-2.5">
          <!-- Search Button (Google Sitelinks Search Access) -->
          <a href="<?= url('search') ?>"
             class="p-2 sm:p-2.5 text-slate-300 hover:text-white bg-slate-900/90 hover:bg-slate-800 border border-slate-800 hover:border-emerald-500/40 rounded-md transition-all flex items-center justify-center cursor-pointer shadow-sm"
             aria-label="Search EcoTech Service"
             title="Search services, projects and pages">
            <span class="material-symbols-outlined text-lg sm:text-xl">search</span>
          </a>

          <!-- WhatsApp Button (Desktop - Clean Rectangular) -->
          <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20project."
             target="_blank"
             class="hidden sm:inline-flex nav-btn-whatsapp"
             aria-label="Chat on WhatsApp">
            <span class="nav-status-square"></span>
            <span class="material-icons-outlined text-base">chat</span>
            <span>WhatsApp</span>
          </a>

          <!-- Internship portal — auth aware -->
          <?php if (isIntern()): ?>
            <a href="<?= url('internships/dashboard') ?>"
               class="hidden md:inline-flex items-center gap-1.5 px-3 py-2 rounded-md border border-eco-500/40 text-eco-300 hover:text-white hover:border-eco-500 text-sm font-semibold transition-colors"
               title="<?= Security::e(internName()) ?>">
              <span class="material-icons-outlined text-base">dashboard</span>
              <span>Dashboard</span>
            </a>
          <?php else: ?>
            <a href="<?= url('internships/login') ?>"
               class="hidden md:inline-flex items-center gap-1.5 px-3 py-2 rounded-md border border-slate-700 text-slate-300 hover:text-white hover:border-slate-500 text-sm font-semibold transition-colors">
              <span class="material-icons-outlined text-base">login</span>
              <span>Intern Login</span>
            </a>
          <?php endif; ?>

          <!-- Primary CTA Button (Clean Rectangular) -->
          <a href="<?= url('contact') ?>" class="hidden md:inline-flex nav-btn-primary">
            <span>Get a Quote</span>
            <span class="material-icons-outlined text-sm">arrow_forward</span>
          </a>

          <!-- Mobile WhatsApp Icon Button (Square, No circle) -->
          <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20project."
             target="_blank"
             class="sm:hidden nav-icon-btn-whatsapp"
             aria-label="WhatsApp">
            <span class="material-icons-outlined text-lg">chat</span>
          </a>

          <!-- Mobile Hamburger Toggle Button (Clean Square, No circle) -->
          <button id="mobileDrawerOpen" type="button" aria-label="Open Navigation Menu"
                  class="lg:hidden nav-toggle-btn">
            <span class="material-icons-outlined text-2xl text-slate-200">menu</span>
          </button>
        </div>

      </div>
    </div>
  </header>

  <!-- ══ MOBILE DRAWER MENU (Responsive Slide Panel) ══════════════════ -->
  <div id="mobileDrawer" class="fixed inset-0 z-[60] lg:hidden" style="visibility:hidden;">
    <!-- Backdrop Overlay -->
    <div id="mobileDrawerOverlay" class="absolute inset-0 bg-black/75 backdrop-blur-sm transition-opacity"></div>

    <!-- Slide Panel (Clean Rectangular, No circular design) -->
    <div id="mobileDrawerContent"
         class="absolute top-0 right-0 bottom-0 w-[84%] max-w-[320px] bg-[#050a14] border-l border-slate-800 flex flex-col overflow-y-auto transform translate-x-full transition-transform duration-300 ease-out">

      <!-- Drawer Header (Enlarged Logo + Rectangular Close Button) -->
      <div class="p-4 border-b border-slate-800/80 flex items-center justify-between bg-slate-950/50">
        <a href="<?= url() ?>" class="flex items-center" aria-label="EcoTech Services">
          <img src="<?= url('assets/img/logo.png') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/img/logo.png') ? filemtime(PUBLIC_PATH . '/assets/img/logo.png') : '3' ?>"
               alt="EcoTech Services"
               class="site-logo-mobile"
               loading="eager">
        </a>
        <button id="mobileDrawerClose" type="button" aria-label="Close menu"
                class="w-9 h-9 rounded-md bg-slate-900 border border-slate-800 text-slate-400 hover:text-white hover:bg-slate-800 flex items-center justify-center transition-colors">
          <span class="material-icons-outlined text-xl">close</span>
        </button>
      </div>

      <!-- Drawer Nav Links (With Material UI Icons, Rectangular Cards) -->
      <nav class="p-3 flex-1 space-y-1">
        <?php
        $mobileDrawerList = [
          ['path' => '',          'label' => 'Home',         'icon' => 'home',                   'desc' => 'Main landing page'],
          ['path' => 'about',     'label' => 'About Us',     'icon' => 'info',                   'desc' => 'Company & mission'],
          ['path' => 'services',  'label' => 'Services',     'icon' => 'miscellaneous_services', 'desc' => 'IT & Engineering solutions'],
          ['path' => 'projects',  'label' => 'Portfolio',    'icon' => 'work_outline',           'desc' => 'Client work & case studies'],
          ['path' => 'templates', 'label' => 'Templates',    'icon' => 'dashboard_customize',   'desc' => 'Ready software systems'],
          ['path' => 'blog',      'label' => 'Blog & News',  'icon' => 'article',                'desc' => 'Technical insights'],
          ['path' => 'contact',   'label' => 'Contact Us',   'icon' => 'mail_outline',           'desc' => 'Reach our engineering team'],
          ['path' => 'search',    'label' => 'Search',       'icon' => 'search',                 'desc' => 'Find services & projects'],
        ];

        foreach ($mobileDrawerList as $mItem):
          $isActive = ($currentRoute === $mItem['path'] || ($mItem['path'] !== '' && str_starts_with($currentRoute, $mItem['path'])));
        ?>
        <a href="<?= url($mItem['path']) ?>"
           class="flex items-center gap-3 p-2.5 rounded-md border transition-colors <?= $isActive ? 'bg-eco-500/10 border-eco-500/30 text-eco-400' : 'border-transparent text-slate-300 hover:bg-slate-900/80 hover:border-slate-800' ?>">
          <div class="w-9 h-9 rounded-md flex items-center justify-center shrink-0 <?= $isActive ? 'bg-eco-500/20 text-eco-400 border border-eco-500/40' : 'bg-slate-900 border border-slate-800 text-slate-400' ?>">
            <span class="material-icons-outlined text-lg"><?= $mItem['icon'] ?></span>
          </div>
          <div class="flex-1 min-w-0">
            <div class="text-sm font-semibold <?= $isActive ? 'text-eco-400' : 'text-slate-200' ?>"><?= $mItem['label'] ?></div>
            <div class="text-[11px] text-slate-500 truncate"><?= $mItem['desc'] ?></div>
          </div>
          <span class="material-icons-outlined text-base text-slate-600">chevron_right</span>
        </a>
        <?php endforeach; ?>
      </nav>

      <!-- Drawer Bottom Actions (Clean Rectangular, No circles) -->
      <div class="p-4 border-t border-slate-800/80 space-y-2.5 bg-slate-950/60">
        <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20project."
           target="_blank"
           class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-md bg-[#25D366] hover:bg-[#20ba59] text-white font-semibold text-xs tracking-wide shadow-md transition-colors">
          <span class="material-icons-outlined text-base">chat</span>
          <span>Chat on WhatsApp</span>
        </a>
        <a href="<?= url('contact') ?>"
           class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-md bg-eco-500/15 hover:bg-eco-500/25 border border-eco-500/30 text-eco-400 font-semibold text-xs tracking-wide transition-colors">
          <span>Request Free Quote</span>
          <span class="material-icons-outlined text-sm">arrow_forward</span>
        </a>
      </div>
    </div>
  </div>

  <!-- ══ ONE SIMPLE NAVBAR CSS ═════════════════════════════════════════ -->
  <style>
    /* ── One Simple Navbar Styling ───────────────────── */
    .site-navbar {
      background: rgba(3, 7, 18, 0.95);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.4);
    }
    .site-navbar.scrolled {
      background: rgba(2, 6, 14, 0.98);
      border-bottom: 1px solid rgba(255, 255, 255, 0.12);
      box-shadow: 0 6px 28px rgba(0, 0, 0, 0.6);
    }

    /* ── Company Logo Size (Significantly Enlarged) ─── */
    .site-logo {
      height: 78px;
      max-height: 80px;
      width: auto;
      object-fit: contain;
      mix-blend-mode: screen;
      filter: brightness(1.35) contrast(1.18);
      display: block;
      transition: transform 0.2s ease;
      transform: scale(1.16);
      transform-origin: left center;
    }
    .site-logo:hover {
      transform: scale(1.2);
    }
    .site-logo-mobile {
      height: 62px;
      max-height: 64px;
      width: auto;
      object-fit: contain;
      mix-blend-mode: screen;
      filter: brightness(1.35) contrast(1.18);
      display: block;
      transform: scale(1.12);
      transform-origin: left center;
    }
    @media (max-width: 768px) {
      .site-logo {
        height: 62px;
        max-height: 64px;
        transform: scale(1.12);
      }
    }

    /* ── Desktop Nav Links (No circular design) ──────── */
    .nav-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 12px;
      border-radius: 6px; /* Rectangular subtle rounded */
      border: 1px solid transparent;
      color: #94a3b8;
      font-size: 13.5px;
      font-weight: 500;
      text-decoration: none;
      transition: all 0.18s ease;
      white-space: nowrap;
    }
    .nav-link:hover {
      color: #ffffff;
      background: rgba(255, 255, 255, 0.06);
      border-color: rgba(255, 255, 255, 0.1);
    }
    .nav-link-active {
      color: #4ade80 !important;
      background: rgba(74, 222, 128, 0.08) !important;
      border-color: rgba(74, 222, 128, 0.25) !important;
      font-weight: 600 !important;
    }
    .nav-link-icon {
      font-size: 18px !important;
      line-height: 1 !important;
      vertical-align: middle;
      color: inherit;
    }
    .nav-dropdown-arrow {
      font-size: 16px !important;
      line-height: 1 !important;
      opacity: 0.7;
    }

    /* ── Dropdown Item ───────────────────────────────── */
    .nav-dropdown-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 10px;
      border-radius: 6px;
      border: 1px solid transparent;
      text-decoration: none;
      transition: all 0.15s ease;
    }
    .nav-dropdown-item:hover {
      background: rgba(255, 255, 255, 0.05);
      border-color: rgba(255, 255, 255, 0.08);
    }
    .nav-drop-icon {
      width: 32px;
      height: 32px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      transition: all 0.15s ease;
    }

    /* ── Action Buttons (No circular design) ─────────── */
    .nav-btn-whatsapp {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 8px 14px;
      border-radius: 6px; /* NO circle */
      background: rgba(37, 211, 102, 0.08);
      border: 1px solid rgba(37, 211, 102, 0.28);
      color: #25D366;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s ease;
      white-space: nowrap;
    }
    .nav-btn-whatsapp:hover {
      background: rgba(37, 211, 102, 0.16);
      border-color: rgba(37, 211, 102, 0.45);
      color: #4ade80;
    }
    .nav-status-square {
      width: 7px;
      height: 7px;
      border-radius: 2px; /* square status dot, strictly not circular */
      background: #22c55e;
      box-shadow: 0 0 6px #22c55e;
    }

    .nav-btn-primary {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      border-radius: 6px; /* NO circle */
      background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
      border: 1px solid rgba(74, 222, 128, 0.35);
      color: #ffffff;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      box-shadow: 0 2px 10px rgba(22, 163, 74, 0.25);
      transition: all 0.2s ease;
      white-space: nowrap;
    }
    .nav-btn-primary:hover {
      background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
      border-color: rgba(74, 222, 128, 0.6);
      box-shadow: 0 4px 16px rgba(34, 197, 94, 0.4);
      color: #ffffff;
      transform: translateY(-1px);
    }

    .nav-icon-btn-whatsapp {
      width: 38px;
      height: 38px;
      border-radius: 6px;
      background: rgba(37, 211, 102, 0.1);
      border: 1px solid rgba(37, 211, 102, 0.25);
      color: #25D366;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
    }

    .nav-toggle-btn {
      width: 38px;
      height: 38px;
      border-radius: 6px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .nav-toggle-btn:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: rgba(255, 255, 255, 0.2);
    }

    /* ── Responsive Display Rules (Strict Specificity) ── */
    @media (max-width: 1023px) {
      .site-navbar .nav-btn-whatsapp,
      .site-navbar .nav-btn-primary {
        display: none !important;
      }
      .site-navbar .nav-icon-btn-whatsapp,
      .site-navbar .nav-toggle-btn {
        display: flex !important;
      }
    }
    @media (min-width: 1024px) {
      .site-navbar .nav-btn-whatsapp,
      .site-navbar .nav-btn-primary {
        display: inline-flex !important;
      }
      .site-navbar .nav-icon-btn-whatsapp,
      .site-navbar .nav-toggle-btn {
        display: none !important;
      }
    }

    /* Laptop screens: slightly more compact links to fit without scroll */
    @media (min-width: 1024px) and (max-width: 1279px) {
      .site-navbar .nav-link {
        padding: 6px 8px;
        font-size: 12.5px;
        gap: 4px;
      }
      .site-navbar .nav-link-icon {
        font-size: 16px !important;
      }
      .site-navbar .nav-btn-whatsapp {
        padding: 6px 10px;
        font-size: 12px;
      }
      .site-navbar .nav-btn-primary {
        padding: 6px 12px;
        font-size: 12px;
      }
    }

    /* ── Mobile Drawer Open/Close Transitions ────────── */
    #mobileDrawer.active {
      visibility: visible !important;
    }
    #mobileDrawer.active #mobileDrawerContent {
      transform: translateX(0);
    }
    #mobileDrawer.open {
      visibility: visible !important;
    }
    #mobileDrawer.open #mobileDrawerContent {
      transform: translateX(0);
    }

    /* Material icons inline baseline fix */
    .material-icons,
    .material-icons-outlined,
    .material-symbols-outlined {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      vertical-align: middle;
      line-height: 1;
    }
  </style>

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
  <style>
    /* Ported from the shadcn `footer-section` component. The React original used
       framer-motion + lucide-react; here the same staggered blur-in is done with
       CSS + IntersectionObserver (no bundler in this PHP app), and lucide glyphs
       are swapped for Font Awesome, which is already loaded. */
    .ftr {
      --line: rgba(255,255,255,0.09);
      --fg: #f9fafb; --fg-2: #9CA3AF; --fg-3: #6b7280;
      --eco: #22c55e; --eco-br: #4ade80;
      font-family: 'Figtree', 'Inter', system-ui, sans-serif;
      background: #030712;
      color: var(--fg-2);
      position: relative;
      border-top: 1px solid var(--line);
      border-top-left-radius: 28px;
      border-top-right-radius: 28px;
      margin-top: 6rem;
      overflow: hidden;
    }
    @media (min-width: 768px) { .ftr { border-top-left-radius: 44px; border-top-right-radius: 44px; } }
    /* The component's soft top wash + blurred centre seam */
    .ftr::before {
      content: ''; position: absolute; inset: 0; pointer-events: none;
      background: radial-gradient(35% 128px at 50% 0%, rgba(255,255,255,0.07), transparent);
    }
    .ftr-seam {
      position: absolute; top: 0; left: 50%; transform: translateX(-50%) translateY(-50%);
      width: 33%; height: 1px; border-radius: 999px; filter: blur(1px);
      background: rgba(34,197,94,0.55); pointer-events: none;
    }
    .ftr-inner { position: relative; max-width: 1152px; margin: 0 auto; padding: 3rem 1.5rem; }
    @media (min-width: 1024px) { .ftr-inner { padding: 4rem 1.5rem 3rem; } }

    .ftr-brand { font-family: 'Fraunces', Georgia, serif; font-weight: 600; font-size: 1.35rem; color: var(--fg); letter-spacing: -0.01em; }
    .ftr-label { font-size: .75rem; font-weight: 600; color: var(--fg); letter-spacing: .02em; }
    .ftr-list { list-style: none; margin: 1rem 0 0; padding: 0; }
    .ftr-list li + li { margin-top: .5rem; }
    .ftr-list a {
      display: inline-flex; align-items: center; gap: .45rem;
      font-size: .875rem; color: var(--fg-2); text-decoration: none;
      transition: color .3s ease;
    }
    .ftr-list a:hover { color: var(--fg); }
    .ftr-list a i { width: 1rem; font-size: .75rem; color: var(--eco-br); }
    .ftr-meta { font-size: .8125rem; color: var(--fg-3); }
    .ftr-meta a { color: var(--fg-2); text-decoration: none; }
    .ftr-meta a:hover { color: var(--eco-br); }
    .ftr-bottom { border-top: 1px solid var(--line); margin-top: 2.5rem; padding-top: 1.5rem; }

    /* Equivalent of the component's <AnimatedContainer> stagger */
    .ftr-anim { opacity: 0; filter: blur(4px); transform: translateY(-8px); }
    .ftr-anim.is-in {
      opacity: 1; filter: blur(0); transform: none;
      transition: opacity .8s ease, filter .8s ease, transform .8s ease;
      transition-delay: var(--d, 0s);
    }
    @media (prefers-reduced-motion: reduce) {
      .ftr-anim, .ftr-anim.is-in { opacity: 1; filter: none; transform: none; transition: none; }
    }
  </style>

  <footer class="ftr">
    <div class="ftr-seam" aria-hidden="true"></div>

    <div class="ftr-inner">
      <div class="grid w-full gap-8 xl:grid-cols-3">

        <!-- Brand block (component's left column) -->
        <div class="ftr-anim" style="--d:0s">
          <a href="<?= url() ?>" class="inline-flex items-center gap-2.5">
            <i class="fas fa-leaf text-eco-400 text-xl"></i>
            <span class="ftr-brand">Ecotech Services</span>
          </a>
          <p class="mt-4 text-sm max-w-xs" style="color:var(--fg-2)">
            Software engineering — web platforms, mobile apps and serverless systems, maintained after launch.
          </p>

          <div class="flex items-center gap-4 mt-5 text-base">
            <?php
            $socials = [
              'linkedin'  => ['icon' => 'fab fa-linkedin',    'label' => 'LinkedIn'],
              'github'    => ['icon' => 'fab fa-github',      'label' => 'GitHub'],
              'facebook'  => ['icon' => 'fab fa-facebook',    'label' => 'Facebook'],
              'twitter'   => ['icon' => 'fab fa-x-twitter',   'label' => 'X / Twitter'],
              'instagram' => ['icon' => 'fab fa-instagram',   'label' => 'Instagram'],
            ];
            foreach ($socials as $key => $s):
              $sUrl = setting($key . '_url');
              if ($sUrl):
            ?>
            <a href="<?= Security::e($sUrl) ?>" target="_blank" rel="noopener" aria-label="<?= $s['label'] ?>"
               class="text-slate-400 hover:text-eco-400 transition-colors duration-300">
              <i class="<?= $s['icon'] ?>"></i>
            </a>
            <?php endif; endforeach; ?>
            <a href="https://wa.me/<?= setting('whatsapp_number') ?>" target="_blank" rel="noopener" aria-label="WhatsApp"
               class="text-slate-400 hover:text-[#25D366] transition-colors duration-300">
              <i class="fab fa-whatsapp"></i>
            </a>
          </div>

          <p class="ftr-meta mt-6">&copy; <?= date('Y') ?> Ecotech Services. All rights reserved.</p>
        </div>

        <!-- Four link columns (component's right block) -->
        <div class="mt-10 grid grid-cols-2 gap-8 md:grid-cols-4 xl:col-span-2 xl:mt-0">
          <?php
          $fEmail = setting('site_email') ?: 'ecotech.internships@gmail.com';
          $fPhone = setting('site_phone') ?: '+91 7398301184';
          $footerGroups = [
            [
              'label' => 'Services',
              'links' => [
                ['Web development',  url('services'), 'fa-window-maximize'],
                ['Mobile apps',      url('services'), 'fa-mobile-screen'],
                ['Cloud &amp; DevOps', url('services'), 'fa-cloud'],
                ['Cybersecurity',    url('services'), 'fa-shield-halved'],
              ],
            ],
            [
              'label' => 'Company',
              'links' => [
                ['About us',    url('about'),       'fa-circle-info'],
                ['Portfolio',   url('projects'),    'fa-folder-open'],
                ['Internships', url('internships'), 'fa-graduation-cap'],
                ['Contact',     url('contact'),     'fa-envelope-open-text'],
              ],
            ],
            [
              'label' => 'Legal',
              'links' => [
                ['Privacy Policy',   url('privacy'),          'fa-shield-halved'],
                ['Terms of Service', url('terms'),            'fa-file-contract'],
                ['Security',         url('privacy#security'), 'fa-lock'],
                ['Cookie Policy',    url('privacy#cookies'),  'fa-cookie-bite'],
              ],
            ],
            [
              'label' => 'Get in touch',
              'links' => [
                [Security::e($fEmail), 'mailto:' . Security::e($fEmail), 'fa-envelope'],
                [Security::e($fPhone), 'tel:' . Security::e(preg_replace('/\s+/', '', $fPhone)), 'fa-phone'],
                [Security::e(setting('site_address') ?: 'Lucknow, India'), url('contact'), 'fa-location-dot'],
                [Security::e(setting('business_hours') ?: 'Mon - Sat, 9-6'), url('contact'), 'fa-clock'],
              ],
            ],
          ];
          foreach ($footerGroups as $gi => $group):
          ?>
          <div class="ftr-anim" style="--d:<?= number_format(0.1 + $gi * 0.1, 1) ?>s">
            <h3 class="ftr-label"><?= $group['label'] ?></h3>
            <ul class="ftr-list">
              <?php foreach ($group['links'] as $l): ?>
              <li><a href="<?= $l[1] ?>"><i class="fas <?= $l[2] ?>"></i><?= $l[0] ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="ftr-bottom flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="ftr-meta">Built and maintained in Lucknow, India.</p>
        <div class="flex items-center gap-6 ftr-meta">
          <a href="<?= url('privacy') ?>">Privacy</a>
          <a href="<?= url('terms') ?>">Terms</a>
          <a href="<?= url('services/web-development-in-lucknow') ?>">Sitemap</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
  /* whileInView + viewport.once equivalent for the footer stagger */
  (function () {
    var items = document.querySelectorAll('.ftr-anim');
    if (!items.length) return;
    if (!('IntersectionObserver' in window)) {
      items.forEach(function (el) { el.classList.add('is-in'); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-in');
        io.unobserve(entry.target);
      });
    }, { threshold: 0.15 });
    items.forEach(function (el) { io.observe(el); });
  })();
  </script>

  <!-- WhatsApp Floating Action Button (Clean Rectangular, No circular design) -->
  <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%2C%20I%20have%20a%20project%20inquiry." target="_blank" aria-label="Chat on WhatsApp"
     class="fixed bottom-6 right-6 z-40 w-12 h-12 rounded-lg bg-[#25D366] hover:bg-[#20bd5a] flex items-center justify-center shadow-xl shadow-green-500/25 hover:scale-105 transition-all duration-300 group">
    <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5">
      <span class="animate-ping absolute inline-flex h-full w-full rounded-[2px] bg-white opacity-75"></span>
      <span class="relative inline-flex rounded-[2px] h-2.5 w-2.5 bg-white"></span>
    </span>
    <span class="material-icons-outlined text-white text-2xl group-hover:scale-110 transition-transform">chat</span>
  </a>

  <!-- ── Mobile App Bottom Navigation Bar (Mobile Only: < md) ── -->
  <?php
  $mobileNavItems = [
      ['route' => '',          'label' => 'Home',      'icon' => 'home'],
      ['route' => 'services',  'label' => 'Services',  'icon' => 'miscellaneous_services'],
      ['route' => 'internships', 'label' => 'Interns', 'icon' => 'school'],
      ['route' => 'projects',  'label' => 'Portfolio', 'icon' => 'work_outline'],
      ['route' => 'contact',   'label' => 'Contact',   'icon' => 'mail_outline'],
  ];
  ?>
  <nav id="mobileBottomNav" aria-label="Mobile Bottom Navigation"
       class="fixed bottom-0 left-0 right-0 z-50 md:hidden bg-[#040914]/95 backdrop-blur-xl border-t border-slate-800/80 px-2 py-1.5 shadow-2xl">
    <div class="grid grid-cols-5 gap-1.5 max-w-md mx-auto">
      <?php foreach ($mobileNavItems as $mItem):
        $isActive = ($currentRoute === $mItem['route'] || ($mItem['route'] !== '' && str_starts_with($currentRoute, $mItem['route'])));
      ?>
      <a href="<?= url($mItem['route']) ?>"
         class="flex flex-col items-center justify-center py-1.5 px-1 rounded-md transition-all duration-180 relative text-decoration-none <?= $isActive ? 'text-eco-400 font-semibold bg-eco-500/10 border border-eco-500/30' : 'text-slate-400 hover:text-slate-200 border border-transparent' ?>">
        
        <!-- Material UI Icon (Clean Rectangular, No circles) -->
        <span class="material-icons-outlined text-[21px] relative z-10 transition-transform duration-180 <?= $isActive ? 'scale-105 text-eco-400' : 'text-slate-400' ?>">
          <?= $mItem['icon'] ?>
        </span>

        <!-- Label -->
        <span class="text-[10px] tracking-tight relative z-10 mt-0.5 leading-none <?= $isActive ? 'text-eco-300 font-bold' : 'text-slate-400' ?>">
          <?= $mItem['label'] ?>
        </span>
      </a>
      <?php endforeach; ?>
    </div>
  </nav>

  <!-- Main JS (with cache-busting timestamp) -->
  <script src="<?= url('assets/js/app.js') ?>?v=<?= file_exists(PUBLIC_PATH . '/assets/js/app.js') ? filemtime(PUBLIC_PATH . '/assets/js/app.js') : '2.0' ?>"></script>

  <!-- ── Page Loader Dismiss ─────────────────────────────────── -->
  <script>
  (function () {
    var loader = document.getElementById('page-loader');
    function hideLoader() {
      if (!loader) return;
      loader.classList.add('loader-hidden');
      document.body.classList.remove('loading');
      // Remove from DOM after fade-out (500ms transition)
      setTimeout(function () { loader && loader.remove(); }, 550);
    }
    // Primary: hide shortly after DOM is ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function () {
        setTimeout(hideLoader, 300);
      });
    } else {
      // DOM already parsed (cached page)
      setTimeout(hideLoader, 150);
    }
    // Hard failsafe: never block user for more than 2.5s
    setTimeout(hideLoader, 2500);
  })();
  </script>
</body>
</html>
