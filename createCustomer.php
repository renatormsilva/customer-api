<?php


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');



include_once 'db.php';

$response_json = file_get_contents("php://input");
$data =json_decode($response_json, true);

if($data){
    
    
    $query_customer = "INSERT INTO customers (user_id, customer_name, birth_date, cpf, rg, phone, address) VALUES (:userId, :customerName, :birth, :cpf, :rg, :phone, :address)";
    $register_customer = $conn->prepare($query_customer);

    session_start();
    $register_customer->bindParam(':userId', $_SESSION['user_id']);
    $register_customer->bindParam(':customerName', $data['customerName']);
    $register_customer->bindParam(':birth', $data['birth']);
    $register_customer->bindParam(':cpf', $data['cpf']);
    $register_customer->bindParam(':rg', $data['rg']);
    $register_customer->bindParam(':phone', $data['phone']);
    $register_customer->bindParam(':address', $data['address']);

    $register_customer->execute();

    if($register_customer->rowCount()) {
        $response = [
            "error" => false,
            "message" => "success",
        ];
    } else {
        $response = [
            "error" => true,
            "message" => "error",
        ];
    }
}
http_response_code(200);
echo json_encode($response);