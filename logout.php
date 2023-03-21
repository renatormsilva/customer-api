<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');

session_start();
$_SESSION['logged_in'] = false;
session_destroy();

$message = "Sua sessão foi encerrada com sucesso.";
http_response_code(200);

echo json_encode(array("success" => true, "message" => $message));