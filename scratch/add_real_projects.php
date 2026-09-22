<?php
/**
 * Insert 6 real client projects into the database
 * and remove the placeholder dummy projects.
 */
$host = '127.0.0.1';
$db   = 'ecotech_service';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    echo "✅ DB connected\n";
} catch (Exception $e) {
    die("❌ DB Error: " . $e->getMessage() . "\n");
}

// ── Step 1: Remove dummy/placeholder projects ──────────────────────────
$pdo->exec("DELETE FROM projects WHERE id IN (1,2,3,4,5,6)");
echo "🗑️  Removed 6 placeholder projects\n";

// ── Step 2: Insert real client projects ───────────────────────────────
$projects = [
    [
        'title'       => 'Pandey Reality',
        'slug'        => 'pandey-reality',
        'description' => 'Premium real estate website for Pandey Reality, Mumbai. Features MahaRERA-verified luxury property listings including 2, 3 & 4 BHK apartments in Bandra East, BKC, and Santacruz. Complete with property search, detailed listings, and consultant inquiry system.',
        'tech_stack'  => 'HTML5, CSS3, JavaScript, PHP, MySQL, SEO',
        'category'    => 'website',
        'live_url'    => 'https://pandeyreality.com/',
        'is_featured' => 1,
        'is_active'   => 1,
        'sort_order'  => 1,
    ],
    [
        'title'       => 'Apna Cleaning',
        'slug'        => 'apna-cleaning',
        'description' => 'Professional cleaning services booking platform built with React (Vite). Allows customers to schedule home, office, and industrial cleaning services online with an easy appointment booking flow and service catalog.',
        'tech_stack'  => 'React, Vite, JavaScript, CSS3, Hostinger Horizons',
        'category'    => 'website',
        'live_url'    => 'https://apnacleanig.in/',
        'is_featured' => 1,
        'is_active'   => 1,
        'sort_order'  => 2,
    ],
    [
        'title'       => 'Kranti Furnitures & Electronics',
        'slug'        => 'kranti-furniture',
        'description' => 'Digital showroom for Prayagraj\'s trusted furniture and electronics retailer. Showcases sofas, smart TVs, beds, recliners, refrigerators and appliances with a modern product catalog, dark mode support, and free delivery information.',
        'tech_stack'  => 'HTML5, Tailwind CSS, JavaScript, Google Fonts, Material Symbols',
        'category'    => 'website',
        'live_url'    => 'https://krantifurniture.in/',
        'is_featured' => 1,
        'is_active'   => 1,
        'sort_order'  => 3,
    ],
    [
        'title'       => 'Yaswant.co.in — Developer Project
        'slug'        => 'yaswant-Project
        'description' => 'Official Projectnd developer ecosystem for Yaswant Pandey. Features 26+ browser-based cybersecurity & developer utilities, online image editing tools, ATS resume studio, engineering study notes, and internship listings.',
        'tech_stack'  => 'React, TypeScript, Vite, Tailwind CSS, Google Analytics',
        'category'    => 'website',
        'live_url'    => 'https://yaswant.co.in/',
        'is_featured' => 0,
        'is_active'   => 1,
        'sort_order'  => 4,
    ],
    [
        'title'       => 'Ecotech AI Platform',
        'slug'        => 'ecotech-ai',
        'description' => 'AI-powered technology platform website with a clean, enterprise-grade design. Showcases artificial intelligence solutions and sustainable technology products with a professional corporate identity.',
        'tech_stack'  => 'HTML5, CSS3, JavaScript, AI Integration',
        'category'    => 'website',
        'live_url'    => 'https://ecotech.ai/',
        'is_featured' => 1,
        'is_active'   => 1,
        'sort_order'  => 5,
    ],
    [
        'title'       => 'Eco-Tech Engineering',
        'slug'        => 'ecotech-engineering',
        'description' => 'Corporate engineering services website for Eco-Tech Engineering. Built with Bootstrap 5 and animated with AOS (Animate on Scroll), featuring services showcase, project Projectand contact system for an engineering consultancy firm.',
        'tech_stack'  => 'Bootstrap 5, Font Awesome, AOS Animations, PHP, CSS3',
        'category'    => 'website',
        'live_url'    => 'https://www.ecotechengineering.in/',
        'is_featured' => 0,
        'is_active'   => 1,
        'sort_order'  => 6,
    ],
];

$sql = "INSERT INTO projects 
    (title, slug, description, tech_stack, category, live_url, is_featured, is_active, sort_order)
    VALUES 
    (:title, :slug, :description, :tech_stack, :category, :live_url, :is_featured, :is_active, :sort_order)";

$stmt = $pdo->prepare($sql);

foreach ($projects as $p) {
    $stmt->execute($p);
    echo "✅ Inserted: {$p['title']}\n";
}

echo "\n🎉 All 6 real projects inserted successfully!\n\n";

// ── Step 3: Verify ────────────────────────────────────────────────────
$rows = $pdo->query("SELECT id, title, slug, category, live_url FROM projects ORDER BY sort_order ASC")->fetchAll();
echo "── Final projects table ──\n";
foreach ($rows as $r) {
    echo "  [{$r['id']}] {$r['title']} ({$r['category']}) → {$r['live_url']}\n";
}
