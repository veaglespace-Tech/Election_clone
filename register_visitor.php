<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

define('DB_HOST', 'localhost');
define('DB_NAME', 'election_clone_db');
define('DB_USER', 'election_app');
define('DB_PASS', 'Veagle@12345');
define('DB_PORT', 3306);

function getDB(): PDO
{
    static $pdo = null;
    if ($pdo)
        return $pdo;
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4;port=' . DB_PORT;
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        $pdo = new PDO($dsn, 'election_app', 'Veagle@12345', $options);
    }
    return $pdo;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';

    if (empty($name) || empty($mobile)) {
        echo json_encode(['success' => false, 'error' => 'Name and Mobile are required.']);
        exit;
    }

    try {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO visitors (name, mobile) VALUES (:name, :mobile)");
        $stmt->execute([':name' => $name, ':mobile' => $mobile]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
