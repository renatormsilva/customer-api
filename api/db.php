<?php 

require_once('../../config/config.php');

try {
    // conexão com a porta;
    $conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);
} catch(PDOException $e) {
    // tratamento de erro
    echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
    exit();
}