<?php
include 'db.php';
header('Content-Type: application/json');

$id_produto = (int)$_POST['id_produto'];

$res = $conn->query("DELETE FROM produtos WHERE id_produto = $id_produto");
if($res) {
    echo json_encode(['sucesso'=>true]);
} else {
    echo json_encode(['sucesso'=>false, 'mensagem'=>'Erro ao excluir produto']);
}
