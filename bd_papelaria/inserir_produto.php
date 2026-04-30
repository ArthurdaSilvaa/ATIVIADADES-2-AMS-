<?php
// incluir conexão com o banco
include 'db.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura e sanitiza os dados
    $nome = isset($_POST['nome']) ? $conn->real_escape_string($_POST['nome']) : '';
    $marca = isset($_POST['marca']) ? $conn->real_escape_string($_POST['marca']) : '';
    $preco = isset($_POST['preco']) ? floatval($_POST['preco']) : 0;
    $quantidade_estoque = isset($_POST['quantidade_estoque']) ? intval($_POST['quantidade_estoque']) : 0;

    // Validação básica
    if (empty($nome) || empty($marca) || $preco <= 0 || $quantidade_estoque < 0) {
        echo "<script>alert('Preencha todos os campos corretamente!'); window.history.back();</script>";
        exit;
    }

    // Inserir no banco
    $sql = "INSERT INTO produtos (nome, marca, preco, quantidade_estoque) VALUES ('$nome', '$marca', $preco, $quantidade_estoque)";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Produto cadastrado com sucesso!'); window.location.href='cadastrar_produto.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar produto: ".$conn->error."'); window.history.back();</script>";
    }
} else {
    // caso alguém acesse diretamente a página
    header("Location: cadastrar_produto.php");
    exit;
}
?>
