<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/cardapio.css">
    <link rel="stylesheet" href="assets/css/responsivo_cardapio.css">
    <link rel="stylesheet" href="assets/css/pedidos.css">
    <script src="assets/js/main.js"></script>
    <title>Pedidos Chikito Pizzaria</title>

    <style>
        .editar-produto-select {
            display: none;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="logohome">
            <a href="pedidos.php">
                <img src="assets/img/LogoChickito.png" alt="Logochickito" class="logo">
            </a>
        </div>

        <ul class=" btnnav">
            <li><a href="home.php">Home</a></li>
            <li><a href="cardapio.php">Cardápio</a></li>
            <li><a href="pedidos.php">Pedidos</a></li>
            <li><a href="cozinha.php">Cozinha</a></li>
        </ul>

        <div id="logout">
            <form action="logout.php" method="POST">
                <a href="logout.php"><img src="assets/img/logout.png" class="logout"></a>
            </form>
        </div>
    </nav>
    <main>
        <?php
        session_start();
        include 'conexao.php';

        if (!isset($_SESSION["id_funcionario"])) {
            header("Location: index.php");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["id_pedido"]) && isset($_POST["novo_produto_pedido"])) {
                $id_pedido = $_POST["id_pedido"];
                $novoProduto = $_POST["novo_produto_pedido"];

                $precos = [
                    "Pizza de Pepperoni" => 40,
                    "Pizza de Ninho com Nutella" => 50,
                    "Fanta Laranja" => 5,
                    "Schweppes" => 6
                ];

                if (array_key_exists($novoProduto, $precos)) {
                    $novoPreco = $precos[$novoProduto];

                    $sql = "UPDATE pedido SET produto_pedido = ?, preco_pedido = ? WHERE id_pedido = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sdi", $novoProduto, $novoPreco, $id_pedido);

                    if ($stmt->execute()) {
                        echo "";
                    } else {
                        echo "" . $stmt->error;
                    }
                } else {
                    echo "";
                }
            } else {
                echo "";
            }
        }

        if (isset($_POST['excluir'])) {
            $id_pedido = $_POST['id_pedido'];

            // Query SQL para excluir o pedido com base no ID
            $sql_delete = "DELETE FROM pedido WHERE id_pedido = $id_pedido";

            if ($conn->query($sql_delete) === TRUE) {
                echo "";
            } else {
                echo "" . $conn->error;
            }
        }


        $sql = "SELECT p.id_pedido, p.produto_pedido, p.preco_pedido, p.mesa_pedido, f.nome_adm
        FROM pedido p
        JOIN funcionario f ON p.fk_funcionario = f.id_funcionario";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h1>Lista de Pedidos</h1>";
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>ID do Pedido</th>";
            echo "<th>Produto</th>";
            echo "<th>Preço Total</th>";
            echo "<th>Mesa</th>";
            echo "<th>Funcionário</th>";
            echo "<th>Excluir Pedido</th>";
            echo "<th>Editar Pedido</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_pedido"] . "</td>";
                echo "<td>";
                echo "<span class='editar-container'>";
                echo "<span class='editar-campo' id='produto-" . $row["id_pedido"] . "' data-index='" . $row["id_pedido"] . "'>" . $row["produto_pedido"] . "</span>";
                echo "<select class='editar-produto-select' data-index='" . $row["id_pedido"] . "'>";
                echo "<option value='Pizza de Pepperoni'>Pizza de Pepperoni</option>";
                echo "<option value='Pizza de Ninho com Nutella'>Pizza de Ninho com Nutella</option>";
                echo "<option value='Fanta Laranja'>Fanta Laranja</option>";
                echo "<option value='Schweppes'>Schweppes</option>";
                // Adicione outras opções de produtos aqui
                echo "</select>";
                echo "</span>";
                echo "</td>";
                echo "<td><span id='preco-" . $row["id_pedido"] . "'>R$ " . number_format($row["preco_pedido"], 2, ',', '.') . "</span></td>";
                echo "<td>" . $row["mesa_pedido"] . "</td>";
                echo "<td>" . $row["nome_adm"] . "</td>";
                echo "<td>";
                echo "<form method='POST'>";
                echo "<input type='hidden' class='excluir-pedido' name='id_pedido' value='" . $row["id_pedido"] . "'>";
                echo "<input type='submit' class='excluir-pedido' name='excluir' value='Excluir'>";
                echo "</form>";
                echo "</td>";
                echo "<td>";
                echo "<form method='POST'>";
                echo "<input type='hidden' class='editar-pedido' name='id_pedido' value='" . $row["id_pedido"] . "'>";
                echo "<button class='editar-pedido botao-azul editar-button' data-index='" . $row["id_pedido"] . "'>Editar</button>";
                echo "<button class='salvar-button botao-azul' style='display: none;' data-index='" . $row["id_pedido"] . "'>Salvar</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Nenhum pedido encontrado.";
        }

        ?>
    </main>

    <script>
        // JavaScript para controlar a edição
        const editarButtons = document.querySelectorAll('.editar-button');
        const salvarButtons = document.querySelectorAll('.salvar-button');
        const editarCampos = document.querySelectorAll('.editar-campo');
        const editarProdutoSelects = document.querySelectorAll('.editar-produto-select');

        editarButtons.forEach((button, index) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();

                const idPedido = button.getAttribute('data-index');

                // Mostrar o select e ocultar o campo de edição
                editarCampos.forEach((campo) => {
                    if (campo.getAttribute('data-index') === idPedido) {
                        campo.style.display = 'none';
                    }
                });

                editarProdutoSelects.forEach((select) => {
                    if (select.getAttribute('data-index') === idPedido) {
                        select.style.display = 'block';
                    }
                });

                // Ocultar o botão "Editar" e mostrar o botão "Salvar" associado
                button.style.display = 'none';
                salvarButtons.forEach((salvarButton) => {
                    if (salvarButton.getAttribute('data-index') === idPedido) {
                        salvarButton.style.display = 'block';
                    }
                });
            });
        });

        salvarButtons.forEach((salvarButton, index) => {
            salvarButton.addEventListener('click', (event) => {
                event.preventDefault();

                const idPedido = salvarButton.getAttribute('data-index');
                const select = document.querySelector('.editar-produto-select[data-index="' + idPedido + '"]');
                const novoProduto = select.value;

                // Ocultar o select e mostrar o campo de edição
                editarCampos.forEach((campo) => {
                    if (campo.getAttribute('data-index') === idPedido) {
                        campo.style.display = 'block';
                        campo.textContent = novoProduto;
                    }
                });

                editarProdutoSelects.forEach((select) => {
                    if (select.getAttribute('data-index') === idPedido) {
                        select.style.display = 'none';
                    }
                });

                // Ocultar o botão "Salvar" e mostrar o botão "Editar" associado
                salvarButton.style.display = 'none';
                editarButtons.forEach((button) => {
                    if (button.getAttribute('data-index') === idPedido) {
                        button.style.display = 'block';
                    }
                });

                // Atualizar o preço na interface do usuário
                const precoSpan = document.getElementById('preco-' + idPedido);
                const precos = {
                    'Pizza de Pepperoni': 40,
                    'Pizza de Ninho com Nutella': 50,
                    'Fanta Laranja': 5,
                    'Schweppes': 6
                    // Adicione outros produtos e preços aqui
                };

                if (precos.hasOwnProperty(novoProduto)) {
                    const novoPreco = precos[novoProduto];
                    precoSpan.textContent = 'R$ ' + novoPreco.toFixed(2).replace('.', ',');
                } else {
                    precoSpan.textContent = 'Produto não encontrado';
                }
            });
        });

        // Adicione um ouvinte de eventos 'change' para atualizar o preço ao selecionar um novo produto
        editarProdutoSelects.forEach((select) => {
            select.addEventListener('change', (event) => {
                const idPedido = select.getAttribute('data-index');
                const novoProduto = select.value;
                const precoSpan = document.getElementById('preco-' + idPedido);
                const precos = {
                    'Pizza de Pepperoni': 40,
                    'Pizza de Ninho com Nutella': 50,
                    'Fanta Laranja': 5,
                    'Schweppes': 6
                    // Adicione outros produtos e preços aqui
                };

                if (precos.hasOwnProperty(novoProduto)) {
                    const novoPreco = precos[novoProduto];
                    precoSpan.textContent = 'R$ ' + novoPreco.toFixed(2).replace('.', ',');
                } else {
                    precoSpan.textContent = 'Produto não encontrado';
                }
            });
        });
    </script>

</body>

</html>