<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');

include_once 'db.php';


session_start();
$user_id = $_SESSION['user_id'];


$query_customers = "SELECT id, customer_name, birth_date, cpf, rg, phone, address FROM customers WHERE user_id = :user_id ORDER BY id DESC";
$result_customers = $conn->prepare($query_customers);
$result_customers->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$result_customers->execute();

if(($result_customers) AND ($result_customers->rowCount() != 0)) {
    while($row_customers = $result_customers->fetch(PDO::FETCH_ASSOC)) {
        extract($row_customers);

        $customers_list["records"][$id] = [
            'id' => $id,
            'customer_name' => $customer_name,
            'birth_date' => $birth_date,
            'cpf' => $cpf,
            'rg' => $rg,
            'phone' => $phone,
            'address' => $address
        ];
    }

    $response = [
        "erro" => false,
        "message" => $_SESSION,
        "customers" => $customers_list
    ];
    
    
} else {
    $response = [
        "erro" => false,
        "message" => $_SESSION,
        "customers" => ""
    ];
    
}

http_response_code(200);
    
echo json_encode($response);


