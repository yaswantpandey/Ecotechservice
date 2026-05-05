<?php
require_once __DIR__ . '/../config/config.php';

try {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

$title = "Everton vs Man City: Premier League Updates, Standings & Where to Watch ⚽";
$slug = "everton-fc-vs-man-city-premier-league-games";
$excerpt = "Get the latest updates on Everton F.C. vs Man City, including Premier League standings, EPL results, and where to watch this epic football showdown.";

$body = <<<HTML
<p>The highly anticipated <strong>Everton F.C. vs Man City</strong> clash has fans of the <strong>Premier League</strong> on the edge of their seats! As the <strong>EPL</strong> season heats up, every match counts, and this showdown is no exception. Whether you are a die-hard <strong>Man City</strong> fan or supporting the Toffees, this match is a must-watch in the latest round of <strong>Premier League games</strong>.</p>

<h2>Everton F.C. vs Man City Standings</h2>
<p>Before heading into the match, looking at the <strong>Premier League standings</strong> is crucial. <strong>Manchester City F.C.</strong> has been dominating the <strong>Premier League table</strong>, looking to secure another title. On the other hand, <strong>Everton</strong> is fighting hard to improve their position. The <strong>Everton F.C. vs Man City standings</strong> context makes this fixture incredibly important for both clubs' seasonal goals.</p>

<h2>Match Preview: Man City vs Everton</h2>
<p>In the history of <strong>City vs Everton</strong>, we have seen some spectacular moments. When looking at recent <strong>Man City games</strong>, their attacking prowess is unmatched. However, <strong>Everton</strong> at Goodison Park can be a formidable opponent. Fans are constantly searching for <strong>EPL results</strong> to see how <strong>Mancity</strong> performs under pressure, especially in crucial <strong>football premier league</strong> fixtures like this.</p>

<h2>Where to Watch Everton F.C. vs Man City</h2>
<p>Are you wondering <strong>where to watch Everton F.C. vs Man City</strong>? The match will be broadcasted live on major sports networks and streaming platforms that cover <strong>Premier League games</strong>. Make sure to tune in early so you don't miss the kickoff of <strong>Man City vs Everton</strong>!</p>

<h2>Final Thoughts on City vs</h2>
<p>As we prepare for <strong>Man City vs</strong> the Merseyside Blues, the entire football world is watching. Will <strong>Man City</strong> continue their march to the top of the <strong>Premier League table</strong>, or will <strong>Everton</strong> pull off a stunning upset? Stay tuned to our blog for more <strong>EPL results</strong> and updates on <strong>Man City games</strong>!</p>
HTML;

$user_id = 1;

$stmt = $db->prepare("INSERT INTO blog_posts (user_id, title, slug, excerpt, body, is_published, published_at) VALUES (?, ?, ?, ?, ?, 1, NOW()) ON DUPLICATE KEY UPDATE body=VALUES(body), excerpt=VALUES(excerpt)");

if ($stmt->execute([$user_id, $title, $slug, $excerpt, $body])) {
    echo "<h3>Success! The 'Everton vs Man City' blog has been published.</h3>";
    echo "<a href='" . APP_URL . "blog'>Go to Blog Page</a>";
} else {
    echo "Failed to publish blog.";
}
?>
