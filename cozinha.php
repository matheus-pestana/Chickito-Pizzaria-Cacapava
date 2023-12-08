<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION["id_funcionario"])) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM pedido";
$result = $conn->query($sql);

$id_funcionario = $_SESSION['id_funcionario'];

$query = "SELECT nome_adm FROM funcionario WHERE id_funcionario = ?";
$statement = $conn->prepare($query);

if ($statement) {
    $statement->bind_param('i', $id_funcionario);
    $statement->execute();
    $statement->bind_result($nome_funcionario);
    if ($statement->fetch()) {
    } else {
        $nome_funcionario = "Nome não encontrado";
    }

    $statement->close();
} else {
    echo "Erro na preparação da consulta.";
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/cardapio.css">
    <link rel="stylesheet" href="assets/css/pedidos.css">
    <link rel="stylesheet" href="assets/css/responsividade_cozinha.css">
    <link rel="shortcut icon" type="imagex/png" href="assets/img/LogoChickito.png">
    <script src="assets/js/cozinha.js"></script>
    <script src="assets/js/hamburguinho.js"></script>
    <title>Pedidos Chikito Pizzaria</title>

</head>

<body>
    <nav class="navbar">
        <div class="logohome">
            <a href="cardapio.php">
                <img src="assets/img/LogoChickito.png" alt="Logochickito" class="logo">
            </a>
        </div>
        <div class="menu-container">
            <div class="hamburger-menu" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <ul class="menu-list">
            <li><a href="home.php">Início</a></li>
            <li><a href="cardapio.php">Cardápio</a></li>
            <li><a href="pedidos.php">Pedidos</a></li>
            <li><a href="cozinha.php">Cozinha</a></li>
            </ul>
        </div>
        </div>

        <div id="logout">
            <form class="logout" action="logout.php" method="POST">
                <p class="user_name">Logado como: <?php echo $nome_funcionario; ?></p>
                <a href="logout.php"><img src="assets/img/logout.png" class="logout-img"></a>
            </form>
        </div>
    </nav>
    <main>

        <?php

        include 'conexao.php';

        if (!isset($_SESSION["id_funcionario"])) {
            header("Location: index.php");
            exit();
        }

        $sql = "SELECT * FROM pedido";
        $result = $conn->query($sql);

        $id_funcionario = $_SESSION['id_funcionario'];

        $query = "SELECT nome_adm FROM funcionario WHERE id_funcionario = ?";
        $statement = $conn->prepare($query);

        if ($statement) {
            $statement->bind_param('i', $id_funcionario);
            $statement->execute();
            $statement->bind_result($nome_funcionario);
            if ($statement->fetch()) {
            } else {
                $nome_funcionario = "Nome não encontrado";
            }

            $statement->close();
        } else {
            echo "Erro na preparação da consulta.";
        }

        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Nome</th><th>Mesa</th><th>Hora</th><th>OBS</th><th>Itens</th><th>Valor</th><th>Funcionário</th><th>Status</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr id='pedido_" . $row["id_pedido"] . "'>";
                echo "<td>" . $row["id_pedido"] . "</td>";
                echo "<td class='nome_pedido'>" . $row["nome_pedido"] . "</td>";
                echo "<td class='mesa_pedido'>" . $row["mesa_pedido"] . "</td>";
                echo "<td class='hora_pedido'>" . $row["hora_pedido"] . "</td>";
                echo "<td class='obs_pedido'>" . $row["obs_pedido"] . "</td>";
                echo "<td class='itens_pedido'>" . $row["itens_pedido"] . "</td>";
                echo "<td class='valor_pedido'>" . $row["valor_total"] . "</td>";
                echo "<td class='fk_id_funcionario'>" . $nome_funcionario . "</td>";
                echo "<td><select class='status' data-id=" . $row["id_pedido"] . "><option>Pendente</option><option>Concluído</option></select></td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Nenhum resultado encontrado.";
        }

        $conn->close();
        ?>

    </main>

    <footer>
        <p class="footer-text">© 2023 Code Flow. Todos os direitos reservados.</p>
        <p class="footer-text">Versão do Produto: 2.8.1</p>
    </footer>

</body>

</html>