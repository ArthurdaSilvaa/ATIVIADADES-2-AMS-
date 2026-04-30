<?php
// incluir conexão com o banco
include 'db.php';

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura e sanitiza os dados
    $id_produto = isset($_POST['id_produto']) ? intval($_POST['id_produto']) : 0;
    $quantidade = isset($_POST['quantidade']) ? intval($_POST['quantidade']) : 0;

    // Validação básica
    if ($id_produto <= 0 || $quantidade <= 0) {
        echo "<script>alert('Selecione um produto válido e insira uma quantidade maior que zero!'); window.history.back();</script>";
        exit;
    }

    // Atualiza a quantidade no estoque
    $sql = "UPDATE produtos SET quantidade_estoque = quantidade_estoque + $quantidade WHERE id_produto = $id_produto";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Entrada registrada com sucesso! Estoque atualizado.'); window.location.href='entrada_mercadoria.php';</script>";
    } else {
        echo "<script>alert('Erro ao registrar entrada: " . $conn->error . "'); window.history.back();</script>";
    }
} else {
    // Se alguém acessar a página diretamente
    header("Location: entrada_mercadoria.php");
    exit;
}
?>
