<?php
// Content-quality look at one programmatic geo page
$gf = '98b2da648f';
$h = file_get_contents(__DIR__ . "/../live_pages/{$gf}.html");
$t = preg_replace(['#<script[^>]*>.*?</script>#is', '#<style[^>]*>.*?</style>#is', '#<[^>]+>#'], [' ', ' ', ' '], $h);
$text = trim(preg_replace('/\s+/', ' ', html_entity_decode($t, ENT_QUOTES)));
echo "WORDS: ", str_word_count($text), "\n";
preg_match_all('#<h1[^>]*>(.*?)</h1>#is', $h, $h1);
preg_match_all('#<h2[^>]*>(.*?)</h2>#is', $h, $h2);
echo "H1: ", trim(strip_tags($h1[1][0] ?? '(none)')), "\n";
echo "H2s:\n";
foreach (array_slice($h2[1], 0, 14) as $x) echo "  - ", trim(strip_tags($x)), "\n";
echo "ld+json blocks: ", preg_match_all('#ld\+json#', $h), " imgs: ", preg_match_all('#<img[ >]#', $h), "\n";
echo "internal links: ", preg_match_all('#href="https://ecotechservices\.tech#', $h), "\n";
echo "\nTEXT SAMPLE: ", substr($text, 0, 700), "\n";
