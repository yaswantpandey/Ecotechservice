<?php
/**
 * Comprehensive Page Health Checker for Ecotech Service
 * Tests all static, dynamic, SEO, and admin pages via HTTP requests to Apache.
 */

// Load DB directly
$host = '127.0.0.1';
$db   = 'ecotech_service';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage() . "\n");
}

// Gather dynamic URLs from database
$projectSlugs = $pdo->query("SELECT slug FROM projects WHERE is_active = 1 LIMIT 5")->fetchAll(PDO::FETCH_COLUMN);
$blogSlugs    = $pdo->query("SELECT slug FROM blog_posts WHERE is_published = 1 LIMIT 5")->fetchAll(PDO::FETCH_COLUMN);
$seoSlugs     = $pdo->query("SELECT slug FROM seo_pages LIMIT 5")->fetchAll(PDO::FETCH_COLUMN);

$pagesToTest = [
    // Core Public Pages
    ['name' => 'Home Page',           'url' => 'http://localhost/Ecotechservice/public/'],
    ['name' => 'About Us',            'url' => 'http://localhost/Ecotechservice/public/about'],
    ['name' => 'Services',            'url' => 'http://localhost/Ecotechservice/public/services'],
    ['name' => 'Projects (All)',      'url' => 'http://localhost/Ecotechservice/public/projects'],
    ['name' => 'Projects (Websites)', 'url' => 'http://localhost/Ecotechservice/public/projects?cat=website'],
    ['name' => 'Templates',           'url' => 'http://localhost/Ecotechservice/public/templates'],
    ['name' => 'Contact Us',          'url' => 'http://localhost/Ecotechservice/public/contact'],
    ['name' => 'Blog Index',          'url' => 'http://localhost/Ecotechservice/public/blog'],
];

// Dynamic project detail pages
foreach ($projectSlugs as $pslug) {
    $pagesToTest[] = [
        'name' => 'Project Detail (' . $pslug . ')',
        'url'  => 'http://localhost/Ecotechservice/public/projects/view?slug=' . urlencode($pslug)
    ];
}

// Dynamic blog post pages
foreach ($blogSlugs as $bslug) {
    $pagesToTest[] = [
        'name' => 'Blog Post (' . $bslug . ')',
        'url'  => 'http://localhost/Ecotechservice/public/blog/post?slug=' . urlencode($bslug)
    ];
}

// Programmatic SEO landing pages
foreach ($seoSlugs as $sslug) {
    $pagesToTest[] = [
        'name' => 'SEO Page (' . $sslug . ')',
        'url'  => 'http://localhost/Ecotechservice/public/' . $sslug
    ];
}

// Admin Pages
$pagesToTest[] = ['name' => 'Admin Login', 'url' => 'http://localhost/Ecotechservice/public/admin/login'];

echo "=======================================================\n";
echo "      ECOTECH SERVICE — ALL PAGES HEALTH AUDIT         \n";
echo "=======================================================\n\n";

$passed = 0;
$failed = 0;
$issues = [];

foreach ($pagesToTest as $page) {
    $ch = curl_init($page['url']);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) HealthChecker/1.0',
    ]);
    
    $start = microtime(true);
    $response = curl_exec($ch);
    $duration = round((microtime(true) - $start) * 1000, 1);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        $failed++;
        echo "❌ [{$page['name']}] {$page['url']}\n   Error: $error\n\n";
        $issues[] = "{$page['name']}: cURL error $error";
        continue;
    }

    // Check for PHP warnings/errors in response
    $hasPhpError = preg_match('/(<b>(Fatal error|Warning|Parse error|Notice)<\/b>|Uncaught PDOException|Stack trace:)/i', $response, $matches);
    $len = strlen($response);

    if ($httpCode === 200 && !$hasPhpError && $len > 500) {
        $passed++;
        echo "✅ [{$page['name']}]\n";
        echo "   URL:    {$page['url']}\n";
        echo "   Status: {$httpCode} OK | Size: " . number_format($len) . " bytes | Time: {$duration}ms\n\n";
    } else {
        $failed++;
        echo "⚠️  [{$page['name']}]\n";
        echo "   URL:    {$page['url']}\n";
        echo "   Status: {$httpCode} | Size: {$len} bytes\n";
        if ($hasPhpError) {
            echo "   PHP Error Detected: " . ($matches[0] ?? 'Unknown') . "\n";
        }
        echo "\n";
        $issues[] = "{$page['name']} returned HTTP $httpCode" . ($hasPhpError ? " with PHP error" : "");
    }
}

echo "=======================================================\n";
echo "AUDIT SUMMARY: Passed: $passed | Failed: $failed | Total: " . count($pagesToTest) . "\n";
echo "=======================================================\n";
if (empty($issues)) {
    echo "🎉 ALL PAGES ARE FULLY OPERATIONAL AND WORKING PROPERLY!\n";
} else {
    echo "Issues found:\n" . implode("\n", $issues) . "\n";
}
