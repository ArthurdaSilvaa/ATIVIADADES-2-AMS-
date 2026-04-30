<?php
include 'db.php';
header('Content-Type: application/json');

$id_produto = (int)$_POST['id_produto'];
$quantidade = (int)$_POST['quantidade'];
$acao = $_POST['acao'];

$res = $conn->query("SELECT quantidade_estoque FROM produtos WHERE id_produto = $id_produto");
if($res->num_rows == 0) {
    echo json_encode(['sucesso'=>false, 'mensagem'=>'Produto não encontrado']);
    exit;
}

$row = $res->fetch_assoc();
$nova_quantidade = $row['quantidade_estoque'];

if($acao === 'adicionar') {
    $nova_quantidade += $quantidade;
} elseif($acao === 'remover') {
    $nova_quantidade -= $quantidade;
    if($nova_quantidade < 0) $nova_quantidade = 0;
}

$conn->query("UPDATE produtos SET quantidade_estoque=$nova_quantidade WHERE id_produto=$id_produto");
echo json_encode(['sucesso'=>true, 'nova_quantidade'=>$nova_quantidade]);
