<?php 


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');


include_once 'db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$response = "";

$query_customer = "SELECT id, customer_name, birth_date, cpf, rg, phone, address FROM customers WHERE id =:id LIMIT 1";
$result_customer = $conn->prepare($query_customer);

$result_customer->bindParam(':id', $id);
$result_customer->execute();

if(($result_customer) AND ($result_customer->rowCount() != 0)) {
    $row_customer = $result_customer->fetch(PDO::FETCH_ASSOC);
    extract($row_customer);
    $customer = [
        'id' => $id,
        'customerName' => $customer_name,
        'birth' => $birth_date,
        'cpf' => $cpf,
        'rg' => $rg,
        'phone' => $phone,
        'address' => $address
    ];
    $response = [
        "erro" =>false,
        "customer" => $customer
    ];
} else {
    $response = [
        "erro" => true,
        "message" => "Customer not found"
    ];
}   

http_response_code(200);
echo json_encode($response);

