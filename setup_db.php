<?php
/**
 * Consolidated Database Setup Script
 * Creates Database and necessary tables
 */

// Function to parse .env file
function loadEnv($path) {
    if (!file_exists($path)) return false;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            putenv(trim($name) . '=' . trim($value));
        }
    }
    return true;
}

loadEnv(__DIR__ . '/.env');

$host = getenv('DB_HOST') ?: 'localhost';
$db   = getenv('DB_NAME') ?: 'election_clone';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : 'Veagle@123';
$port = getenv('DB_PORT') ?: 3306;
$charset = 'utf8mb4';

try {
    // 1. Create Database
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET $charset COLLATE {$charset}_unicode_ci;");
    echo "1. Database '$db' created (or already exists).\n";

    // 2. Connect to the new database
    $pdo->exec("USE `$db`");

    // 3. Create Visitors Table
    $pdo->exec('CREATE TABLE IF NOT EXISTS visitors (
        id INT AUTO_INCREMENT PRIMARY KEY, 
        name VARCHAR(255) NOT NULL, 
        mobile VARCHAR(50) NOT NULL, 
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );');
    echo "2. Visitors table created successfully.\n";

    // (Electors table is usually imported via SQL, but we could add it here if needed)

    echo "Setup Complete!\n";

} catch (PDOException $e) {
    echo "Setup failed: " . $e->getMessage() . "\n";
}
?>
