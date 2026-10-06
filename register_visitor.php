<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/db.php';

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
