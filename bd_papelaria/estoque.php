<?php
include 'db.php';

// Função para buscar produtos (para o JS atualizar)
function buscarProdutos($conn) {
    $res = $conn->query("SELECT id_produto, nome, marca, quantidade_estoque, preco FROM produtos ORDER BY nome ASC");
    $produtos = [];
    while($row = $res->fetch_assoc()) {
        $produtos[] = $row;
    }
    return $produtos;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Estoque Completo</title>
<style>
* { box-sizing: border-box; }
body {
    font-family: Arial, sans-serif;
    background-color: #ecf0f1;
    margin: 0; padding: 0;
    display: flex; justify-content: center; align-items: flex-start; min-height: 100vh;
}
.menu-lateral {
    position: fixed; top: 0; left: 0; width: 220px; height: 100vh;
    background-color: #2C3E50; padding: 20px; color: white; overflow-y: auto;
}
.menu-lateral h2 { margin-top:0; font-size:22px; margin-bottom:20px; }
.menu-lateral a { color:white; text-decoration:none; display:block; margin-bottom:12px; font-weight:600; transition:color 0.2s ease; }
.menu-lateral a:hover { color:#1ABC9C; text-decoration:underline; }
.main-content {
    width: 100%; max-width: 1000px; background:#fff; border-radius:8px; box-shadow:0 0 12px rgba(0,0,0,0.1); padding:30px; margin-top:30px; margin-left:240px;
}
.main-content h1 { margin-bottom:20px; }
table { width: 100%; border-collapse: collapse; }
table th, table td { padding:12px 15px; border:1px solid #ccc; text-align:left; }
table thead { background-color:#2C3E50; color:white; }
table tbody tr:nth-child(even) { background-color:#f9f9f9; }
button { padding:5px 10px; border:none; border-radius:4px; cursor:pointer; margin-top:2px; }
button.excluir { background-color:#e74c3c; color:white; }
button.excluir:hover { background-color:#c0392b; }
button.adicionar { background-color:#2C3E50; color:white; }
button.adicionar:hover { background-color:#1A252F; }
button.remover { background-color:#f39c12; color:white; }
button.remover:hover { background-color:#e67e22; }
input[type="number"] { width:70px; padding:5px; }
</style>
</head>
<body>

<nav class="menu-lateral">
    <h2>Papelaria Online</h2>
    <a href="index.php">Registrar Venda</a>
    <a href="estoque.php">Ver Estoque Completo</a>
    <a href="cadastrar_produto.php">Cadastrar Novo Produto</a>
    <a href="cadastrar_cliente.php">Cadastrar Novo Cliente</a>
    <a href="entrada_mercadoria.php">Registrar Entrada de Mercadoria</a>
</nav>

<main class="main-content">
<h1>Estoque Completo</h1>

<table id="tabela-estoque">
<thead>
<tr>
    <th>ID</th>
    <th>Produto</th>
    <th>Marca</th>
    <th>Qtd Estoque</th>
    <th>Preço (R$)</th>
    <th>Ações</th>
</tr>
</thead>
<tbody>
<?php
$produtos = buscarProdutos($conn);
foreach($produtos as $row) {
    echo "<tr id='produto-{$row['id_produto']}'>";
    echo "<td>{$row['id_produto']}</td>";
    echo "<td>".htmlspecialchars($row['nome'])."</td>";
    echo "<td>".htmlspecialchars($row['marca'])."</td>";
    echo "<td class='quantidade'>{$row['quantidade_estoque']}</td>";
    echo "<td>R$ ".number_format($row['preco'],2,',','.')."</td>";
    echo "<td>
        <input type='number' class='qtd-input' value='1' min='1'>
        <button class='adicionar' onclick='alterarQuantidade({$row['id_produto']}, \"adicionar\")'>Adicionar</button>
        <button class='remover' onclick='alterarQuantidade({$row['id_produto']}, \"remover\")'>Remover</button>
        <button class='excluir' onclick='excluirProduto({$row['id_produto']})'>Excluir</button>
    </td>";
    echo "</tr>";
}
?>
</tbody>
</table>

<p><a href="cadastrar_produto.php"><button class="adicionar">Cadastrar Novo Produto</button></a></p>

<script>
function alterarQuantidade(id, acao) {
    const row = document.getElementById('produto-' + id);
    const quantidadeInput = row.querySelector('.qtd-input');
    const quantidade = quantidadeInput.value;

    fetch('alterar_estoque.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id_produto=${id}&quantidade=${quantidade}&acao=${acao}`
    })
    .then(response => response.json())
    .then(data => {
        if(data.sucesso) {
            row.querySelector('.quantidade').textContent = data.nova_quantidade;
        } else {
            alert(data.mensagem);
        }
    });
}

function excluirProduto(id) {
    if(confirm('Deseja realmente excluir este produto?')) {
        fetch('excluir_produto.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_produto=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if(data.sucesso) {
                const row = document.getElementById('produto-' + id);
                row.remove();
            } else {
                alert(data.mensagem);
            }
        });
    }
}
</script>

</main>
</body>
</html>
