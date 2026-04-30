<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Papelaria Online - Registrar Venda</title>
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background-color: #ecf0f1;
            margin: 0; padding: 0;

            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .menu-lateral {
            position: fixed;
            top: 0; left: 0;
            width: 220px;
            height: 100vh;
            background-color: #2C3E50;
            padding: 20px;
            color: white;
            overflow-y: auto;
        }
        .menu-lateral h2 { margin-top: 0; font-size: 22px; margin-bottom: 20px; }
        .menu-lateral a { color: white; text-decoration: none; display: block; margin-bottom: 12px; font-weight: 600; transition: color 0.2s ease; }
        .menu-lateral a:hover { color: #1ABC9C; text-decoration: underline; }

        .main-content {
            width: 100%;
            max-width: 700px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .main-content > * { margin-bottom: 20px; }

        form { display: flex; flex-direction: column; }

        form label { margin-bottom: 6px; font-weight: 600; }

        form input[type="text"],
        form input[type="email"],
        form input[type="number"],
        form select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
            width: 100%;
        }

        form input[type="submit"], form button {
            background-color: #2C3E50;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            width: fit-content;
           margin-top: 30px;
}
        

        form input[type="submit"]:hover, form button:hover { background-color: #1A252F; }

        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 12px 15px; border: 1px solid #ccc; text-align: left; }
        table thead { background-color: #2C3E50; color: white; }
        table tbody tr:nth-child(even) { background-color: #f9f9f9; }
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
        <h1>Registrar Nova Venda</h1>
        <form action="registrar_venda.php" method="post">
            <label for="id_cliente"><strong>Cliente:</strong></label>
            <select name="id_cliente" id="id_cliente" required>
                <option value="">-- Selecione um cliente --</option>
                <?php
                $res_clientes = $conn->query("SELECT id_cliente, nome FROM clientes ORDER BY nome ASC");
                while ($row = $res_clientes->fetch_assoc()) {
                    echo "<option value='{$row['id_cliente']}'>" . htmlspecialchars($row['nome']) . "</option>";
                }
                ?>
            </select>

            <hr style="margin: 20px 0;">

            <h2>Selecionar Produtos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Selecionar</th>
                        <th>Produto</th>
                        <th>Marca</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $res_produtos = $conn->query("SELECT id_produto, nome, marca, preco FROM produtos WHERE quantidade_estoque > 0 ORDER BY nome ASC");
                while ($row = $res_produtos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='id_produto[]' value='{$row['id_produto']}'></td>";
                    echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['marca']) . "</td>";
                    echo "<td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>";
                    echo "<td><input type='number' name='quantidade_{$row['id_produto']}' value='1' min='1' style='width: 60px;'></td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>

            <input type="submit" value="Registrar Venda">
        </form>
    </main>
</body>
</html>
