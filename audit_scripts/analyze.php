<?php
// Per-page on-page SEO analysis of crawled pages
if (!function_exists('mb_strlen')) { function mb_strlen($s) { return function_exists('iconv_strlen') ? iconv_strlen($s ?? '', 'UTF-8') : strlen($s ?? ''); } }
$base = __DIR__ . '/..';
$log = file($base . '/live_pages/crawl_log.txt', FILE_IGNORE_NEW_LINES);
// pairs: "code:200 bytes:X sec:Y" followed by "url:U file:H"
$pages = [];
for ($i = 0; $i < count($log); $i += 2) {
    preg_match('/code:(\d+) bytes:(\d+) sec:([\d.]+)/', $log[$i], $m);
    preg_match('/url:(\S+) file:(\S+)/', $log[$i + 1], $u);
    $pages[] = ['url' => $u[1], 'file' => $u[2], 'code' => $m[1], 'bytes' => $m[2], 'sec' => $m[3]];
}
echo count($pages), " pages\n";
$ar = fopen($base . '/live_pages/analysis.jsonl', 'w');

$vis = function ($html) {
    $t = preg_replace('#<script[^>]*>.*?</script>#is', ' ', $html);
    $t = preg_replace('#<style[^>]*>.*?</style>#is', ' ', $t);
    $t = preg_replace('#<[^>]+>#', ' ', $t);
    $t = html_entity_decode($t, ENT_QUOTES, 'UTF-8');
    $t = preg_replace('/\s+/u', ' ', $t);
    return trim($t);
};
foreach ($pages as $p) {
    $path = $base . "/live_pages/{$p['file']}.html";
    if (!is_file($path)) { fwrite($ar, json_encode(['url' => $p['url'], 'fetch' => 'missing' ]) . "\n"); continue; }
    $html = file_get_contents($path);
    $a = ['url' => $p['url'], 'code' => $p['code'], 'bytes' => $p['bytes'], 'sec' => $p['sec'], 'challenge' => strpos($html, 'aes.js') !== false];
    if ($a['challenge']) { fwrite($ar, json_encode($a) . "\n"); continue; }
    preg_match('#<title>\s*(.*?)\s*</title>#is', $html, $t);
    $a['title'] = isset($t[1]) ? trim(html_entity_decode($t[1], ENT_QUOTES)) : null;
    $a['title_len'] = $a['title'] ? mb_strlen($a['title']) : 0;
    preg_match('#name="description"\s+content="([^"]*)"#i', $html, $d);
    $a['desc'] = $d[1] ?? null;
    $a['desc_len'] = $a['desc'] !== null ? mb_strlen(html_entity_decode($a['desc'], ENT_QUOTES)) : null;
    preg_match('#rel="canonical"\s+href="([^"]+)"#i', $html, $c);
    $a['canonical'] = $c[1] ?? null;
    $a['canonical_self'] = $c[1] ? (rtrim($c[1], '/?') === rtrim($p['url'], '?')) : null;
    $a['h1_count'] = preg_match_all('#<h1[ >]#i', $html);
    $a['word_count'] = str_word_count($vis($html));
    $a['has_robots_meta'] = 0;
    if (preg_match('#<meta[^>]+name="robots"[^>]+content="([^"]*)"#i', $html, $r)) {
        $a['has_robots_meta'] = 1;
        $a['robots_meta'] = $r[1];
    }
    $a['hreflang'] = preg_match_all('#hreflang#i', $html);
    $a['ld_types'] = [];
    if (preg_match_all('#<script[^>]*application/ld\+json[^>]*>(.*?)</script>#is', $html, $ld)) {
        foreach ($ld[1] as $b) {
            $j = json_decode(trim($b), true);
            if ($j === null) { $a['ld_parse_error'] = 1; continue; }
            foreach ([[$j], $j['@graph'] ?? []] as $set) {
                foreach ($set as $node) {
                    if (!is_array($node)) continue;
                    $ty = $node['@type'] ?? null;
                    if ($ty) { foreach ((array)$ty as $tyone) $a['ld_types'][] = $tyone; }
                }
            }
        }
    }
    $a['imgs'] = preg_match_all('#<img[ >]#i', $html);
    $a['imgs_no_alt'] = preg_match_all('#<img[^>]*>#i', $html) - preg_match_all('#<img[^>]*\salt=\S#i', $html);
    $a['h2_count'] = preg_match_all('#<h2[ >]#i', $html);
    fwrite($ar, json_encode($a) . "\n");
}
fclose($ar);

// aggregates
$lines = array_map(fn($l) => json_decode($l, true), file($base . '/live_pages/analysis.jsonl', FILE_IGNORE_NEW_LINES));
$agg = ['n' => count($lines)];
$dupT = $dupD = [];
foreach (['no_title' => 0, 'title_dupes' => 0, 'title_long' => 0, 'title_short' => 0,
          'no_desc' => 0, 'desc_dupes' => 0, 'desc_long' => 0, 'desc_short' => 0,
          'no_canonical' => 0, 'canonical_mismatch' => 0, 'no_h1' => 0, 'multi_h1' => 0,
          'thin' => 0, 'noindex' => 0, 'no_ld' => 0, 'imgs' => 0, 'imgs_no_alt' => 0,
          'hreflang' => 0, 'challenge' => 0, 'non200' => 0] as $k => $v) $agg[$k] = 0;
$secSum = 0; $secN = 0; $secs = []; $wordSum = 0;
foreach ($lines as $a) {
    if (!isset($a['title'])) { $agg['challenge']++; continue; }
    $secs[] = $a['sec']; $secSum += $a['sec']; $secN++;
    $wordSum += $a['word_count'];
    if ($a['title_len'] == 0) $agg['no_title']++;
    if ($a['title_len'] > 60) $agg['title_long']++;
    if ($a['title_len'] && $a['title_len'] < 15) $agg['title_short']++;
    if ($a['desc'] === null || $a['desc_len'] == 0) $agg['no_desc']++;
    elseif ($a['desc_len'] > 160) $agg['desc_long']++;
    elseif ($a['desc_len'] < 70) $agg['desc_short']++;
    if (!$a['canonical']) $agg['no_canonical']++;
    elseif ($a['canonical_self'] === false) $agg['canonical_mismatch']++;
    if ($a['h1_count'] == 0) $agg['no_h1']++;
    if ($a['h1_count'] > 1) $agg['multi_h1']++;
    if ($a['word_count'] < 200) $agg['thin']++;
    if (($a['robots_meta'] ?? '') !== '' && stripos($a['robots_meta'], 'noindex') !== false) $agg['noindex']++;
    if (empty($a['ld_types'])) $agg['no_ld']++;
    $agg['imgs'] += $a['imgs']; $agg['imgs_no_alt'] += $a['imgs_no_alt'];
    if ($a['hreflang'] > 0) $agg['hreflang']++;
    if ($a['code'] != 200) $agg['non200']++;
    if ($a['title']) $dupT[$a['title']][] = $a['url'];
    if ($a['desc']) $dupD[$a['desc']][] = $a['url'];
}
sort($secs);
$agg['avg_sec'] = round($secSum / max(1, $secN), 2);
$agg['p95_sec'] = $secs ? $secs[intval(count($secs) * 0.95)] : null;
$agg['max_sec'] = $secs ? end($secs) : null;
$agg['avg_words'] = round($wordSum / max(1, count($lines)));
$agg['title_dupes'] = count(array_filter($dupT, fn($x) => count($x) > 1));
$agg['desc_dupes'] = count(array_filter($dupD, fn($x) => count($x) > 1));
file_put_contents($base . '/live_pages/aggregate.json', json_encode(['agg' => $agg, 'url_counts' => [
    'geo_pages' => preg_match_all('#/services/web-development-in-#', file_get_contents($base . '/live_pages/crawl_log.txt')) ,
],], JSON_PRETTY_PRINT));
print_r($agg['avg_sec'] ? $agg : []);
// list counts by URL category
$cats = [];
foreach ($pages as $p) {
    $u = $p['url'];
    $cat = 'other';
    if (preg_match('#/services/web-development-in-#', $u)) $cat = 'geo_city_service';
    elseif (preg_match('#/projects/view\?slug=#', $u)) $cat = 'project';
    elseif (preg_match('#/blog(?!$)#', $u)) $cat = 'blog';
    elseif (count(parse_url($u, PHP_URL_PATH) === false ? [] : explode('/', trim(parse_url($u, PHP_URL_PATH), '/'))) === 0 ||
            parse_url($u, PHP_URL_PATH) === '/') $cat = 'home';
    else $cat = parse_url($u, PHP_URL_PATH);
    $cats[$cat] = ($cats[$cat] ?? 0) + 1;
}
arsort($cats);
echo json_encode($cats, JSON_PRETTY_PRINT), "\n";
