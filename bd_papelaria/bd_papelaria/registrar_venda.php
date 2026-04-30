<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $ids_produtos = $_POST['id_produto'] ?? [];

    if (empty($id_cliente) || empty($ids_produtos)) {
        die("Erro: selecione um cliente e pelo menos um produto.");
    }

    // Cria a venda
    $conn->query("INSERT INTO vendas (id_cliente, data_venda) VALUES ($id_cliente, NOW())");
    $id_venda = $conn->insert_id;

    $total_geral = 0;
    $itens = [];

    foreach ($ids_produtos as $id_produto) {
        $quantidade = (int)$_POST["quantidade_$id_produto"];
        $res_produto = $conn->query("SELECT nome, marca, preco FROM produtos WHERE id_produto = $id_produto");
        $produto = $res_produto->fetch_assoc();

        $preco = $produto['preco'];
        $subtotal = $preco * $quantidade;
        $total_geral += $subtotal;

        // Salva na tabela de itens da venda
        $conn->query("INSERT INTO itens_venda (id_venda, id_produto, quantidade, preco_unitario) 
                      VALUES ($id_venda, $id_produto, $quantidade, $preco)");

        // Atualiza o estoque
        $conn->query("UPDATE produtos SET quantidade_estoque = quantidade_estoque - $quantidade WHERE id_produto = $id_produto");

        $itens[] = [
            'nome' => $produto['nome'],
            'marca' => $produto['marca'],
            'quantidade' => $quantidade,
            'preco' => $preco,
            'subtotal' => $subtotal
        ];
    }

    // Pega dados do cliente
    $res_cliente = $conn->query("SELECT nome, email FROM clientes WHERE id_cliente = $id_cliente");
    $cliente = $res_cliente->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Nota Fiscal - Venda #<?php echo $id_venda; ?></title>
<link rel="stylesheet" href="style.css">
<style>
.nota {
    max-width: 700px;
    margin: 50px auto;
    padding: 25px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 12px rgba(0,0,0,0.1);
}
.nota h2 {
    text-align: center;
    color: #2C3E50;
}
.nota table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
.nota table th, .nota table td {
    border: 1px solid #ccc;
    padding: 10px;
}
.nota table th {
    background-color: #2C3E50;
    color: white;
}
.total {
    text-align: right;
    margin-top: 20px;
    font-size: 18px;
    font-weight: bold;
}
.print-btn {
    display: block;
    margin: 30px auto;
    padding: 10px 20px;
    background: #2C3E50;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
.print-btn:hover {
    background: #1A252F;
}
</style>
</head>
<body>
<div class="nota">
    <h2>🧾 Nota Fiscal - Venda #<?php echo $id_venda; ?></h2>
    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($cliente['nome']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($cliente['email']); ?></p>
    <p><strong>Data:</strong> <?php echo date('d/m/Y H:i'); ?></p>

    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Marca</th>
                <th>Qtd</th>
                <th>Preço Unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itens as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['nome']) ?></td>
                <td><?= htmlspecialchars($item['marca']) ?></td>
                <td><?= $item['quantidade'] ?></td>
                <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                <td>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p class="total">Total: R$ <?= number_format($total_geral, 2, ',', '.') ?></p>

    <button class="print-btn" onclick="window.print()">Imprimir Nota Fiscal</button>
</div>
</body>
</html>
