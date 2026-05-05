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

$user_id = 1; // Assume admin ID is 1

$trends = [
    ["title" => "Nepal vs Oman Live Update 2026: Who is Winning the Match? 🏏", "slug" => "nepal-vs-oman-live-update-2026", "content" => "Nepal vs Oman is trending globally! Everyone is searching for the latest updates. Watch this space for more information on the match highlights and live scores."],
    ["title" => "स्मार्ट बिजली (Smart Electricity): How to cut your electricity bill by 50%! 💡", "slug" => "smart-bijli-electricity-bill", "content" => "स्मार्ट बिजली (Smart Electricity) is the future. By installing smart meters and IoT devices, you can save up to 50% on your electricity bills in 2026. Contact Ecotech Services to know how we use technology to make this happen."],
    ["title" => "Everton vs Man City 2026: Shocking Results & Highlights! ⚽", "slug" => "everton-vs-man-city-2026-highlights", "content" => "The Everton vs Man City match has left fans speechless. Check out the latest goals, player stats, and post-match reactions right here."],
    ["title" => "Lab Assistant Admit Card 2026 OUT NOW: Direct Download Link Here! 🚨", "slug" => "lab-assistant-admit-card-2026-download", "content" => "Good news for all candidates! The Lab Assistant Admit Card 2026 has been officially released. Click here to download your admit card directly without server issues. Hurry up!"],
    ["title" => "RB Choudary Latest News: What's Happening in 2026? 🎬", "slug" => "rb-choudary-latest-news-2026", "content" => "RB Choudary is trending all over the internet. Find out the latest updates about his upcoming projects, controversies, and viral news."],
    ["title" => "तमिलनाडु विधान सभा (Tamil Nadu Assembly) 2026: Biggest Breaking News Today! 📰", "slug" => "tamil-nadu-assembly-news-2026", "content" => "तमिलनाडु विधान सभा (Tamil Nadu Legislative Assembly) has some massive updates today. Stay tuned for the complete political coverage and what it means for the common man."],
    ["title" => "CUET Admit Card 2026 आ गया: ये रही Direct Link, जल्दी से डाउनलोड करें! 🔥", "slug" => "cuet-admit-card-2026-direct-link", "content" => "CUET Admit Card 2026 finally release ho gaya hai! Yahan di gayi direct link par click karein aur apna admit card turant download karein. Server down hone se pehle check karein!"],
    ["title" => "Met Gala 2026 Theme Revealed: Best & Worst Dressed Celebrities! 👗", "slug" => "met-gala-2026-theme-best-dressed", "content" => "The Met Gala 2026 Theme is finally here! From mind-blowing outfits to massive fashion disasters, here is everything you missed from the biggest night in fashion."],
    ["title" => "Rishabh Pant and Sanjiv Goenka LEAKED Message? Shocking Truth Revealed! 😱", "slug" => "rishabh-pant-sanjiv-goenka-leaked-message", "content" => "What really happened between Rishabh Pant and Sanjiv Goenka? The internet is going crazy over their alleged message exchange. Here is the full breakdown of the controversy."],
    ["title" => "Anu Sharma goes viral after leaving Google for Palantir: Salary details inside! 🚀", "slug" => "anu-sharma-leaves-google-for-palantir", "content" => "Anu Sharma has shocked the tech world by leaving Google to join Palantir. Why did she make the move? What is her new package? Read this tech analysis to find out."],
    ["title" => "Latest OFFs and Discounts You Can't Miss in 2026! 🛍️", "slug" => "latest-offs-and-discounts-2026", "content" => "Looking for the best OFFs? We have compiled a list of the most insane discounts running online right now. Save money before the sale ends!"],
    ["title" => "मार्क वुड (Mark Wood): Big Update on the Star Bowler! 🏏", "slug" => "mark-wood-cricket-update-2026", "content" => "मार्क वुड (Mark Wood) is making headlines again! Here is the latest update on his fitness, bowling speed, and whether he will play the next big tournament."],
    ["title" => "Ananya Birla's Next Big Move in 2026: Business Secrets! 💼", "slug" => "ananya-birla-business-secrets-2026", "content" => "Ananya Birla is setting new benchmarks in the business world. Discover the secrets behind her latest ventures and what entrepreneurs can learn from her."],
    ["title" => "Jamie Dimon Issues Huge Warning for 2026 Economy! 📉", "slug" => "jamie-dimon-warning-economy-2026", "content" => "JPMorgan CEO Jamie Dimon has issued a stark warning about the 2026 global economy. Should you be worried about a recession? Read the full analysis."],
    ["title" => "The Odyssey Explained: Why is it Trending Everywhere? 🌍", "slug" => "the-odyssey-trending-explained", "content" => "Everyone is searching for 'The Odyssey'. Whether it's the classic book or a new phenomenon, here is everything you need to know about why this word has taken over the internet."]
];

$stmt = $db->prepare("INSERT IGNORE INTO blog_posts (user_id, title, slug, excerpt, body, is_published, published_at) VALUES (?, ?, ?, ?, ?, 1, NOW())");

foreach ($trends as $trend) {
    $excerpt = substr($trend['content'], 0, 100) . '...';
    $stmt->execute([
        $user_id,
        $trend['title'],
        $trend['slug'],
        $excerpt,
        $trend['content']
    ]);
    echo "Inserted: " . $trend['title'] . "<br>\n";
}

echo "<h3>All trending topics injected successfully!</h3>\n";
echo "<a href='" . APP_URL . "blog'>Go to Blog</a>";
?>
