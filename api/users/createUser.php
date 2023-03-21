<?php

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');


include_once '../db.php';


$response_json = file_get_contents("php://input");
$data = json_decode($response_json, true);

if ($data) {
    if (!$conn) {
        $response = [
            "error" => true,
            "message" => "Erro ao conectar ao banco de dados",
        ];
        http_response_code(500);
        echo json_encode($response);
        exit;
    }

    $query_user = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $register_user = $conn->prepare($query_user);
    if (!$register_user) {
        $response = [
            "error" => true,
            "message" => "Erro ao preparar a consulta",
        ];
        http_response_code(500);
        echo json_encode($response);
        exit;
    }

    $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
    
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $response = [
            "error" => true,
            "message" => "Endereço de e-mail inválido",
        ];
        http_response_code(400);
        echo json_encode($response);
        exit;
    }

    $conn->beginTransaction();
    try {
        $register_user->bindParam(':username', $data['username']);
        $register_user->bindParam(':email', $data['email']);
        $register_user->bindParam(':password', $password_hash);
        $register_user->execute();

        if ($register_user->rowCount()) {
            $conn->commit();
            $response = [
                "error" => false,
                "message" => "success",
            ];
        } else {
            $conn->rollBack();
            $response = [
                "error" => true,
                "message" => "Erro ao registrar usuário",
            ];
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        $response = [
            "error" => true,
            "message" => "Erro ao inserir dados no banco de dados",
        ];
    }
} else {
    $response = [
        "error" => true,
        "message" => "Dados de entrada inválidos",
    ];
    http_response_code(400);
}
http_response_code(200);
echo json_encode($response);
