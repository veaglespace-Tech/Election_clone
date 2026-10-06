<?php
/**
 * Visitors API
 * Fetches all registered visitors
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/db.php';

try {
    $db = getDB();
    $stmt = $db->query("SELECT id, name, mobile, created_at FROM visitors ORDER BY id DESC");
    $visitors = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'data' => $visitors,
        'total' => count($visitors)
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
