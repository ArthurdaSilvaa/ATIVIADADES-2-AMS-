<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Novo Produto</title>
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
        .menu-lateral h2 { margin-top:0; font-size:22px; margin-bottom:20px; }
        .menu-lateral a {
            color:white; text-decoration:none; display:block; margin-bottom:12px; font-weight:600;
            transition: color 0.2s ease;
        }
        .menu-lateral a:hover { color:#1ABC9C; text-decoration:underline; }

        .main-content {
            width: 100%;
            max-width: 700px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            padding: 30px;
        }

        form { display:flex; flex-direction:column; }
        form label { margin-bottom:6px; font-weight:600; }
        form input[type="text"], form input[type="number"] {
            padding:10px; font-size:16px; border:1px solid #ccc; border-radius:4px; margin-bottom:15px; width:100%;
        }
        form input[type="submit"], form button {
            background-color:#2C3E50; color:white; border:none; padding:12px; border-radius:6px; cursor:pointer; font-size:16px; width:fit-content;
            transition: background-color 0.3s ease;
        }
        form input[type="submit"]:hover, form button:hover { background-color:#1A252F; }
        a { color:#2C3E50; text-decoration:none; } a:hover { text-decoration:underline; }
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
        <h1>Cadastrar Novo Produto</h1>
        <form action="inserir_produto.php" method="post">
            <label for="nome">Nome do Produto:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" required>

            <label for="preco">Preço (R$):</label>
            <input type="number" step="0.01" min="0" id="preco" name="preco" required>

            <label for="quantidade_estoque">Quantidade em Estoque:</label>
            <input type="number" min="0" id="quantidade_estoque" name="quantidade_estoque" required>

            <input type="submit" value="Cadastrar Produto">
        </form>
    </main>
</body>
</html>
