<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

try {
    $db = Database::getInstance();
    
    // Hash the password 'Admin@123'
    $hashedPassword = password_hash('Admin@123', PASSWORD_BCRYPT, ['cost' => 12]);
    $email = 'admin@ecotech.com';

    // 1. Delete the user if it exists to make sure we are starting fresh
    $stmt = $db->prepare("DELETE FROM users WHERE email = ? OR role = 'admin'");
    $stmt->execute([$email]);

    // 2. Create a brand new admin user
    $stmt = $db->prepare("
        INSERT INTO users (name, email, password, role, is_active) 
        VALUES ('Super Admin', ?, ?, 'admin', 1)
    ");
    $stmt->execute([$email, $hashedPassword]);

    echo "<h1 style='color:green; font-family:sans-serif;'>Admin Account Successfully Fixed!</h1>";
    echo "<p style='font-family:sans-serif; font-size:18px;'>Your Database is working and a fresh Admin account has been created.</p>";
    echo "<ul style='font-family:sans-serif; font-size:18px;'>";
    echo "<li><b>Email:</b> admin@ecotech.com</li>";
    echo "<li><b>Password:</b> Admin@123</li>";
    echo "</ul>";
    echo "<p style='font-family:sans-serif;'><a href='public/admin/login' style='padding:10px 20px; background:#22c55e; color:white; text-decoration:none; border-radius:5px;'>Click Here to Login</a></p>";

} catch (Exception $e) {
    echo "<h1 style='color:red; font-family:sans-serif;'>Database Error</h1>";
    echo "<p style='font-family:sans-serif;'>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p style='font-family:sans-serif;'>Apka database connect nahi ho pa raha hai. Kripya InfinityFree par apni .env file ke details check karein.</p>";
}
