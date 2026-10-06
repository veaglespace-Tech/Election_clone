<?php
$host = 'localhost';
$db   = 'election_clone';
$user = 'root';
$pass = 'Veagle@123';
$port = 3306;
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    $sql = file_get_contents(__DIR__ . '/database/vps_seed_data.sql');
    if ($sql === false) {
        die("Could not read SQL file.");
    }
    
    $pdo->exec($sql);
    echo "Database imported successfully.\n";
} catch (\PDOException $e) {
    echo "Import failed: " . $e->getMessage() . "\n";
}
?>
