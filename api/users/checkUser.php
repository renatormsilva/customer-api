<?php

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');

include_once '../db.php';

$json = file_get_contents('php://input');
$data = json_decode($json);

$email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
$username = filter_var($data->username, FILTER_SANITIZE_STRING);

$response = "";

$query_user = "SELECT uid FROM users WHERE username = :username LIMIT 1";
$result_user = $conn->prepare($query_user);
$result_user->bindParam(':username', $username);
$result_user->execute();

$query_email = "SELECT uid FROM users WHERE email = :email LIMIT 1";
$result_email = $conn->prepare($query_email);
$result_email->bindParam(':email', $email);
$result_email->execute();

if($result_user->rowCount() > 0 && $result_email->rowCount() > 0) {
    $response = [
        "exists" => true,
        "message" => "Username and email already exist"
    ];
} else if($result_user->rowCount() > 0) {
    $response = [
        "exists" => true,
        "message" => "Usuário já cadastrado"
    ];
} else if($result_email->rowCount() > 0) {
    $response = [
        "exists" => true,
        "message" => "Email já cadastrado"
    ];
} else {
    $response = [
        "exists" => false,
        "message" => "sucess"
    ];
}

http_response_code(200);
echo json_encode($response);

?>
