<?php
/**
 * Add real client projects to the database
 */
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
    die("DB Error: " . $e->getMessage() . "\n");
}

// Describe projects table
$cols = $pdo->query("DESCRIBE projects")->fetchAll();
foreach ($cols as $c) {
    echo $c['Field'] . ' | ' . $c['Type'] . ' | ' . $c['Null'] . "\n";
}
echo "\n--- Existing Projects ---\n";
$existing = $pdo->query("SELECT id, title, slug, live_url, category FROM projects")->fetchAll();
foreach ($existing as $p) {
    echo "ID:{$p['id']} | {$p['title']} | {$p['slug']} | {$p['category']}\n";
}
