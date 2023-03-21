<?php 

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');

include_once '../db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$id) {
    http_response_code(400);
    echo json_encode([
        'error' => true,
        'message' => 'Customer ID is missing or invalid',
    ]);
    exit;
}

try {
    $query_customer = 'DELETE FROM customers WHERE id = :id LIMIT 1';
    $delete_customer = $conn->prepare($query_customer);
    $delete_customer->bindParam(':id', $id);

    if ($delete_customer->execute()) {
        http_response_code(200);
        echo json_encode([
            'error' => false,
            'message' => 'Customer was deleted',
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'error' => true,
            'message' => 'Customer was not deleted',
        ]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage(),
    ]);
}

