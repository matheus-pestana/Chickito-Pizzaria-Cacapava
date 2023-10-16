<?php
session_start();

if (!isset($_SESSION["id_funcionario"]) || !isset($_SESSION["id_funcionario"])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/responsivo_home.css">
    <link rel="stylesheet" href="assets/css/home.css">
    <title>Home Chikito Pizzaria</title>

</head>

<body>

    <nav class="navbar">
        <div class="logohome">
            <a href="home.php">
                <img src="assets/img/LogoChickito.png" alt="Logochickito" class="logo">
            </a>
        </div>

        <ul class="btnnav">
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
    <div class="entregador">
        <img src="assets/img/img_home.png" alt="imagem de um entregador de pizza" class="img_home">
    </div>

    <div class="centro">
      <div class= "introducao" > 
        <h1>Faça seu pedido agora mesmo!!</h1>
        <a href="cardapio.php" class="btn-home">Veja o cardápio</a>
        </div>
        <div >
        <a href="#" class="promo">
            <img  src="assets/img/promo1.png" alt="" class="img_promo" >
        </a>
        </div>

    </div> 



</body>

</html>