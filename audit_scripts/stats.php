<?php
if (!function_exists('mb_strlen')) { function mb_strlen($s) { return function_exists('iconv_strlen') ? iconv_strlen($s ?? '', 'UTF-8') : strlen($s ?? ''); } }
error_reporting(E_ALL & ~E_DEPRECATED);
$lines = array_map(fn($l) => json_decode($l, true), file(__DIR__ . '/../live_pages/analysis.jsonl', FILE_IGNORE_NEW_LINES));
$corePaths = ['/', '/services', '/projects', '/about', '/templates', '/blog', '/contact'];
$stats = [];
$total = 0;
foreach ($lines as $a) {
    if (!isset($a['title'])) continue;
    $total++;
    $u = $a['url'];
    $host = parse_url($u, PHP_URL_HOST) ?: '';
    $path = parse_url($u, PHP_URL_PATH);
    if (!is_string($path)) { $path = ''; }
    if ($path === '' || $path === '/') { $cat = 'core'; }
    elseif (preg_match('{^/services/web-development-in-}', $path)) $cat = 'geo_web';
    elseif (preg_match('{^/services/mobile-app-development-in-}', $path)) $cat = 'geo_mobile';
    elseif (preg_match('{^/services/.+-in-[^/]+}', $path)) $cat = 'geo_other_service_city';
    elseif (preg_match('{^/services/}', $path)) $cat = 'service_other';
    elseif (preg_match('{^/projects/view}', $path)) $cat = 'project';
    elseif (preg_match('{^/blog/}', $path)) $cat = 'blog_post';
    elseif (in_array($path, $corePaths, true)) $cat = 'core';
    else $cat = 'other:' . $path;
    if (!isset($stats[$cat])) { $stats[$cat] = ['n' => 0, 'tl' => 0, 'dl' => 0, 'w' => 0, 'thin' => 0, 't60' => 0, 'd160' => 0]; }
    $st =& $stats[$cat];
    $st['n']++;
    $st['tl'] += $a['title_len'];
    $st['dl'] += ($a['desc_len'] ?? 0);
    $st['w'] += $a['word_count'];
    if ($a['word_count'] < 150) { $st['thin']++; echo "THIN {$a['word_count']}w {$u}\n"; }
    if ($a['title_len'] > 60) { $st['t60']++; }
    if (($a['desc_len'] ?? 0) > 160) { $st['d160']++; }
    unset($st);
}
echo "TOTAL classified: $total / buckets: " . count($stats) . "\n\n";
$sum = 0;
foreach ($stats as $c => $s) {
    $sum += $s['n'];
    printf("%-42s n:%4d avgTitle:%6.1f avgDesc:%6.1f avgWords:%7.1f thin:%d titles>60:%d descs>160:%d\n",
        $c, $s['n'], $s['tl'] / $s['n'], $s['dl'] / $s['n'], $s['w'] / $s['n'], $s['thin'], $s['t60'], $s['d160']);
}
echo "\nCHECKSUM: $sum\n";
