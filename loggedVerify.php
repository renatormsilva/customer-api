<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');

session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    // Usuário está logado
    echo json_encode(array('authenticated' => true));
} else {
    // Usuário não está logado
    echo json_encode(array('authenticated' => false));
}
?>