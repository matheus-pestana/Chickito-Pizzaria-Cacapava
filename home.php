<?php
session_start();

include 'conexao.php';

if (!isset($_SESSION["id_funcionario"])) {
    header("Location: index.php");
    exit();
}

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
    <link rel="shortcut icon" type="imagex/png" href="assets/img/LogoChickito.png">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/responsivo_inicio.css">
    <script src="assets/js/hamburguinho.js"></script>
    <title>Home Chikito Pizzaria</title>

</head>

<body>

<nav class="navbar">
        <div class="logohome">
            <a href="home.php">
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
                <a href="logout.php"><img src="assets/img/logout.png" class="logout-img"></a>
            </form>
        </div>
    </nav>
    <div class="entregador">
        <img src="assets/img/img_home.png" alt="imagem de um entregador de pizza" class="img_home">
    </div>

    <div class="centro">
        <div class="introducao">
            <h1>Olá, <?php echo $nome_funcionario; ?> seja bem-vindo(a)</h1>
            <a href="cardapio.php" class="btn-home">Veja o cardápio</a>
        </div>
        <div>
            <a href="#" class="promo">
                <img src="assets/img/promo1.png" alt="" class="img_promo">
            </a>
        </div>

    </div>

    <footer>
        <p class="footer-text">© 2023 Code Flow. Todos os direitos reservados.</p>
        <p class="footer-text">Versão do Produto: 2.8.1</p>
    </footer>

</body>

</html>