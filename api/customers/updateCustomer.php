<?php 

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');


include_once '../db.php';

$response_json = file_get_contents("php://input");
$data = json_decode($response_json, true);

if($data) {
    $query_customer = "UPDATE customers SET customer_name=:customerName, birth_date=:birth, cpf=:cpf, rg=:rg, phone=:phone, address=:address WHERE id=:id";
    $update_customer = $conn->prepare($query_customer);

    $update_customer->bindParam(':id', $data['id']);
    $update_customer->bindParam(':customerName', $data['customerName']);
    $update_customer->bindParam(':birth', $data['birth']);
    $update_customer->bindParam(':cpf', $data['cpf']);
    $update_customer->bindParam(':rg', $data['rg']);
    $update_customer->bindParam(':phone', $data['phone']);
    $update_customer->bindParam(':address', $data['address']);
    

    $update_customer->execute();

    if($update_customer->rowCount()) {
        $response = [
            "error" => false,
            "message" => "success"
        ];
    } else {
        $response = [
            "error" => true,
            "message" => "error"
        ];
    }

$response = [
    "error" => false,
    "message" => "success",
    "customerData" => $data
];

}

http_response_code(200);
echo json_encode($response);