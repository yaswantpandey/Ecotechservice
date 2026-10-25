<?php
/**
 * Comprehensive Ecotech Service Integration Test Suite
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$baseUrl = 'http://localhost/Ecotechservice/public';
$cleanBaseUrl = 'http://localhost/Ecotechservice';

$tests = [
    // Core routes with clean URLs (via root rewrite)
    ['name' => 'Clean URL: Home',          'url' => $cleanBaseUrl . '/'],
    ['name' => 'Clean URL: About',         'url' => $cleanBaseUrl . '/about'],
    ['name' => 'Clean URL: Services',      'url' => $cleanBaseUrl . '/services'],
    ['name' => 'Clean URL: Projects',      'url' => $cleanBaseUrl . '/projects'],
    ['name' => 'Clean URL: Contact',       'url' => $cleanBaseUrl . '/contact'],

    // Secondary public routes
    ['name' => 'Search Page (empty)',      'url' => $baseUrl . '/search'],
    ['name' => 'Search Page (query)',      'url' => $baseUrl . '/search?q=web'],
    ['name' => 'Privacy Policy',           'url' => $baseUrl . '/privacy'],
    ['name' => 'Terms of Service',         'url' => $baseUrl . '/terms'],
    ['name' => 'Sitemap XML',              'url' => $baseUrl . '/sitemap.xml'],
    ['name' => 'Robots TXT',               'url' => $baseUrl . '/robots.txt'],

    // Internships portal
    ['name' => 'Internships Landing',      'url' => $baseUrl . '/internships'],
    ['name' => 'Internships Login',        'url' => $baseUrl . '/internships/login'],
    ['name' => 'Internships Register',     'url' => $baseUrl . '/internships/register'],

    // Admin Auth
    ['name' => 'Admin Login Form',         'url' => $baseUrl . '/admin/login'],
    ['name' => 'Admin Protected Redirect', 'url' => $baseUrl . '/admin/dashboard', 'expect_redirect' => true],
];

echo "========================================================\n";
echo "   ECOTECH SERVICE — COMPREHENSIVE INTEGRATION SUITE     \n";
echo "========================================================\n\n";

$passed = 0;
$failed = 0;

foreach ($tests as $t) {
    $ch = curl_init($t['url']);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_USERAGENT => 'IntegrationTester/1.0',
    ]);
    
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        $failed++;
        echo "❌ {$t['name']} failed: $error\n";
        continue;
    }

    if (!empty($t['expect_redirect'])) {
        if ($code === 302) {
            $passed++;
            echo "✅ {$t['name']} [HTTP $code Redirect as expected]\n";
        } else {
            $failed++;
            echo "❌ {$t['name']} [Expected 302, got HTTP $code]\n";
        }
    } else {
        $hasPhpError = preg_match('/(<b>(Fatal error|Warning|Parse error|Notice)<\/b>|Uncaught PDOException|Stack trace:)/i', $res);
        if ($code === 200 && !$hasPhpError) {
            $passed++;
            echo "✅ {$t['name']} [HTTP 200 OK | " . strlen($res) . " bytes]\n";
        } else {
            $failed++;
            echo "❌ {$t['name']} [HTTP $code | PHP Error: " . ($hasPhpError ? 'Yes' : 'No') . "]\n";
        }
    }
}

echo "\n========================================================\n";
echo "RESULT: Passed: $passed / " . count($tests) . " (" . round(($passed / count($tests)) * 100) . "%)\n";
echo "========================================================\n";
