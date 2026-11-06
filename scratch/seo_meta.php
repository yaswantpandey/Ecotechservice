<?php
$sql = file_get_contents('database/ecotech.sql');
preg_match_all("/^\('(services\/[^']+)', '([^']*)', '([^']*)', '([^']*)', '([^']*)', '([^']*)', '([^']*)'\)/m", $sql, $m, PREG_SET_ORDER);
echo "rows: " . count($m) . "\n";

$rows = [];
$tl = []; $dl = [];
foreach ($m as $r) {
    $rows[] = ['slug' => $r[1], 'svc' => $r[2], 'loc' => $r[3], 'kw' => $r[4], 'title' => $r[5], 'desc' => $r[6], 'h1' => $r[7]];
    $tl[] = strlen($r[5]); $dl[] = strlen($r[6]);
}
printf("titles: min %d max %d avg %.1f | >60: %d | >70: %d\n", min($tl), max($tl), array_sum($tl)/count($tl), count(array_filter($tl, fn($n) => $n > 60)), count(array_filter($tl, fn($n) => $n > 70)));
printf("descs : min %d max %d avg %.1f | >160: %d | >200: %d\n", min($dl), max($dl), array_sum($dl)/count($dl), count(array_filter($dl, fn($n) => $n > 160)), count(array_filter($dl, fn($n) => $n > 200)));

$svcs = array_values(array_unique(array_column($rows, 'svc')));
$locs = array_values(array_unique(array_column($rows, 'loc')));
echo "\ndistinct services: " . count($svcs) . " distinct locations: " . count($locs) . "\n";
echo "longest service names:\n";
usort($svcs, fn($a, $b) => strlen($b) <=> strlen($a));
foreach (array_slice($svcs, 0, 5) as $s) echo "  " . strlen($s) . " $s\n";
usort($locs, fn($a, $b) => strlen($b) <=> strlen($a));
echo "longest locations:\n";
foreach (array_slice($locs, 0, 5) as $l) echo "  " . strlen($l) . " $l\n";

echo "\nsample current rows:\n";
foreach ([0, 60, 200, 459] as $i) {
    printf("  [%d] %s\n    T(%d) %s\n    D(%d) %s\n", $i, $rows[$i]['slug'], strlen($rows[$i]['title']), $rows[$i]['title'], strlen($rows[$i]['desc']), $rows[$i]['desc']);
}

// candidate templates
$cands = [
    'A' => [fn($r) => "{$r['svc']} in {$r['loc']} | Ecotech Services"],
    'B' => [fn($r) => "{$r['svc']} Company in {$r['loc']} | Ecotech"],
    'C' => [fn($r) => "{$r['svc']} in {$r['loc']} | Ecotech"],
    'D' => [fn($r) => "{$r['svc']} in {$r['loc']} — Ecotech Services"],
];
foreach ($cands as $k => $set) {
    $lens = array_map(fn($r) => strlen($set[0]($r)), $rows);
    printf("title %s: max %d | >60: %d/%d | >62: %d\n", $k, max($lens), count(array_filter($lens, fn($n) => $n > 60)), count($lens), count(array_filter($lens, fn($n) => $n > 62)));
}

$descs = [
    'A' => fn($r) => "Looking for {$r['svc']} in {$r['loc']}? Ecotech Services delivers secure, high-performance builds with fixed pricing and post-launch support. Get a free quote.",
    'B' => fn($r) => "{$r['svc']} services in {$r['loc']}. Ecotech Services builds fast, secure, SEO-ready software with fixed pricing and ongoing support. Get a free quote.",
    'C' => fn($r) => "Need {$r['svc']} in {$r['loc']}? Ecotech Services builds fast, secure, SEO-ready products with fixed pricing and post-launch support. Get a free quote.",
];
foreach ($descs as $k => $f) {
    $lens = array_map($f, $rows);
    printf("desc %s: min %d max %d | >160: %d | >158: %d\n", $k, min($lens), max($lens), count(array_filter($lens, fn($n) => $n > 160)), count(array_filter($lens, fn($n) => $n > 158)));
    echo "   sample: " . $f($rows[459]) . "\n";
}
