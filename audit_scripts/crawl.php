<?php
// Crawler for live SEO audit of ecotechservices.tech
// Usage: php crawl.php crawl_all.php handled inside; writes live_pages/*.html and live_pages/results.jsonl
$ck = '__test=e54b9f411d9f741e64b508d9aa0f022e';
$ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; Chrome/126)';
$sitemapFile = __DIR__ . '/../live__sitemap_xml';
$outDir = __DIR__ . '/../live_pages';
if (!is_dir($outDir)) mkdir($outDir, 0777, true);

$xml = file_get_contents($sitemapFile);
preg_match_all('#<loc>([^<]+)</loc>#', $xml, $m);
$urls = $m[1];
echo count($urls), " urls in sitemap\n";

$batch = 5;
$delayMs = 400;
$fh = fopen($outDir . '/results.jsonl', 'w');
$all = array_values($urls);
for ($i = 0; $i < count($all); $i += $batch) {
    $slice = array_slice($all, $i, $batch);
    $mh = curl_multi_init();
    $handles = [];
    foreach ($slice as $idx => $url) {
        $n = $i + $idx;
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => $ua,
            CURLOPT_HTTPHEADER => ["Cookie: $ck", 'Referer: https://ecotechservices.tech/', 'Accept: text/html'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HEADER => true,
        ]);
        array_push($handles, ['ch' => $ch, 'n' => $n, 'url' => $url]);
        curl_multi_add_handle($mh, $ch);
    }
    // run all in the batch
    do { curl_multi_exec($mh, $run); if ($run) usleep(50000); } while ($run > 0);
    foreach ($handles as $h) {
        $body = curl_multi_getcontent($h['ch']);
        $code = curl_getinfo($h['ch'], CURLINFO_RESPONSE_CODE);
        $bytes = strlen((string)$body);
        $ttfbc = curl_getinfo($h['ch'], CURLINFO_TOTAL_TIME);
        $err = curl_error($h['ch']);
        $isChallenge = strpos((string)$body, 'aes.js') !== false;
        file_put_contents($outDir . '/p' . $h['n'] . '.html', (string)$body);
        fwrite($fh, json_encode([
            'n' => $h['n'], 'url' => $h['url'], 'code' => $code, 'bytes' => $bytes,
            'sec' => round($ttfbc, 2), 'err' => $err === '' ? null : $err,
            'challenge' => $isChallenge,
        ]) . "\n");
        curl_multi_remove_handle($mh, $h['ch']);
        curl_close($h['ch']);
    }
    curl_multi_close($mh);
    // header cleanup: strip headers line
    usleep($delayMs * 1000);
    if (($i / $batch) % 5 === 0) echo "progress: ", ($i + count($slice)), "/", count($all), "\n";
}
fclose($fh);
echo "done\n";
