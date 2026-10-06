<?php
$host = 'localhost';
$db   = 'election_clone';
$user = 'root';
$pass = 'Veagle@123';
$port = 3306;
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('CREATE TABLE IF NOT EXISTS visitors (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL, mobile VARCHAR(50) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);');
    echo "Visitors table created successfully.\n";
} catch (\PDOException $e) {
    echo "Failed: " . $e->getMessage() . "\n";
}
?>
