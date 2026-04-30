<?php
$host = 'localhost';
$db   = 'papelaria'; // Nome do novo banco de dados
$user = 'papelaria';
$pass = '1010'; // Coloque sua senha do MySQL aqui, se houver

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Erro na conexão: ' . $conn->connect_error);
}
?>