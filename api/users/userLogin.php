<?php

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');
    http_response_code(204);
    exit;
}

include_once '../../db.php';

$response_json = file_get_contents("php://input");
$data = json_decode($response_json, true);

if ($data) {
    // Verificar se a conexão com o banco de dados foi estabelecida corretamente
    if (!$conn) {
        $response = [
            "error" => true,
            "message" => "Erro ao conectar ao banco de dados",
        ];
        http_response_code(500);
        echo json_encode($response);
        exit;
    }

    // Prepare a consulta com tratamento de erros
    $query_user = "SELECT * FROM users WHERE username = :username";
    $get_user = $conn->prepare($query_user);
    if (!$get_user) {
        $response = [
            "error" => true,
            "message" => "Erro ao preparar a consulta",
        ];
        http_response_code(500);
        echo json_encode($response);
        exit;
    }

    // Use transações para garantir atomicidade
    $conn->beginTransaction();
    try {
        $get_user->bindParam(':username', $data['username']);
        $get_user->execute();

        if ($get_user->rowCount()) {
            $user = $get_user->fetch(PDO::FETCH_ASSOC);

            if (password_verify($data['password'], $user['password'])) {
                $conn->commit();
                
                session_start();
                $_SESSION['user_id'] = $user['uid'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['logged_in'] = true;
                
                $response = [
                    "error" => false,
                    "message" => "logado com sucesso",
                    "user" => [
                        "uid" => $user['uid'],
                        "username" => $user['username'],
                        "email" => $user['email']
                    ],
                ];
                

            } else {
                $conn->rollBack();
                $response = [
                    "error" => true,
                    "message" => "Nome de usuário ou senha incorretos",
                ];
            }
        } else {
            $conn->rollBack();
            $response = [
                "error" => true,
                "message" => "Nome de usuário ou senha incorretos",
            ];
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        $response = [
            "error" => true,
            "message" => "Erro ao buscar usuário",
        ];
    }

    echo json_encode($response);
} else {
    $response = [
        "error" => true,
        "message" => "Dados de entrada inválidos",
    ];
    http_response_code(400);
}

