<?php
/**
 * Test All Admin Panel Routes With Authenticated Session
 */
$cookieFile = __DIR__ . '/admin_cookie.txt';
if (file_exists($cookieFile)) unlink($cookieFile);

$loginUrl = 'http://localhost/Ecotechservice/public/admin/login';
$postUrl  = 'http://localhost/Ecotechservice/public/admin/login/post';

// Step 1: GET login page
$ch = curl_init($loginUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEJAR      => $cookieFile,
    CURLOPT_COOKIEFILE     => $cookieFile,
]);
$loginHtml = curl_exec($ch);
curl_close($ch);

preg_match('/name="csrf_token"\s+value="([^"]+)"/', $loginHtml, $m);
$csrfToken = $m[1] ?? '';

// Step 2: Login
$ch = curl_init($postUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query([
        'csrf_token' => $csrfToken,
        'email'      => 'admin@ecotech.com',
        'password'   => 'Admin@123'
    ]),
    CURLOPT_COOKIEJAR      => $cookieFile,
    CURLOPT_COOKIEFILE     => $cookieFile,
    CURLOPT_FOLLOWLOCATION => true,
]);
curl_exec($ch);
curl_close($ch);

$adminRoutes = [
    'Dashboard'         => 'http://localhost/Ecotechservice/public/admin/dashboard',
    'Projects CRUD'     => 'http://localhost/Ecotechservice/public/admin/projects',
    'Projects Add'      => 'http://localhost/Ecotechservice/public/admin/projects/add',
    'Services CRUD'     => 'http://localhost/Ecotechservice/public/admin/services',
    'Services Add'      => 'http://localhost/Ecotechservice/public/admin/services/add',
    'Testimonials CRUD' => 'http://localhost/Ecotechservice/public/admin/testimonials',
    'Testimonials Add'  => 'http://localhost/Ecotechservice/public/admin/testimonials/add',
    'Contacts Inbox'    => 'http://localhost/Ecotechservice/public/admin/contacts',
    'Site Settings'     => 'http://localhost/Ecotechservice/public/admin/settings',
    'Database Status'   => 'http://localhost/Ecotechservice/public/admin/database',
    'Blog CRUD'         => 'http://localhost/Ecotechservice/public/admin/blog',
    'Blog Add'          => 'http://localhost/Ecotechservice/public/admin/blog/add',
    'Applications'      => 'http://localhost/Ecotechservice/public/admin/applications',
    'Interns'           => 'http://localhost/Ecotechservice/public/admin/interns',
    'Tracks'            => 'http://localhost/Ecotechservice/public/admin/tracks',
    'Tracks Add'        => 'http://localhost/Ecotechservice/public/admin/tracks/add',
];

echo "========================================================\n";
echo "   ECOTECH SERVICE — ADMIN PANEL AUDIT                  \n";
echo "========================================================\n\n";

$passed = 0;
$failed = 0;

foreach ($adminRoutes as $name => $url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEFILE     => $cookieFile,
        CURLOPT_TIMEOUT        => 5,
    ]);
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $hasPhpError = preg_match('/(<b>(Fatal error|Warning|Parse error|Notice)<\/b>|Uncaught PDOException|Stack trace:)/i', $res);

    if ($code === 200 && !$hasPhpError) {
        $passed++;
        echo "✅ [Admin {$name}] HTTP 200 OK | " . number_format(strlen($res)) . " bytes\n";
    } else {
        $failed++;
        echo "❌ [Admin {$name}] HTTP $code | PHP Error: " . ($hasPhpError ? 'Yes' : 'No') . "\n";
    }
}

if (file_exists($cookieFile)) unlink($cookieFile);

echo "\n========================================================\n";
echo "ADMIN AUDIT: Passed: $passed / " . count($adminRoutes) . " (" . round(($passed / count($adminRoutes)) * 100) . "%)\n";
echo "========================================================\n";
