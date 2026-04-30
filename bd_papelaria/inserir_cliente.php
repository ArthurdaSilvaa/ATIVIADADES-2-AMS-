<?php
// Incluir a conexão com o banco
include 'db.php';

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura e sanitiza os dados
    $nome = isset($_POST['nome']) ? $conn->real_escape_string(trim($_POST['nome'])) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : '';

    // Validação básica
    if (empty($nome) || empty($email)) {
        echo "<script>alert('Por favor, preencha todos os campos!'); window.history.back();</script>";
        exit;
    }

    // Inserir cliente no banco de dados
    $sql = "INSERT INTO clientes (nome, email) VALUES ('$nome', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cliente cadastrado com sucesso!'); window.location.href='cadastrar_cliente.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar cliente: " . $conn->error . "'); window.history.back();</script>";
    }
} else {
    // Se acessar direto, redireciona para a página de cadastro
    header("Location: cadastrar_cliente.php");
    exit;
}
?>
