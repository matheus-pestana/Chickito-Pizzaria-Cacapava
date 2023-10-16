<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION['id_funcionario']) && !empty($_SESSION['id_funcionario'])) {
        $id_funcionario = $_SESSION['id_funcionario'];

        $precoTotal = $_POST["precoTotal"];
        $mesaSelect = $_POST["mesaSelect"];

        $produtos = $_POST["produtos"];
        $produtoNomes = $_POST["produto_nome"];
        $produtoPrecos = $_POST["produto_preco"];

        $nomesProdutos = implode(", ", $produtoNomes);

        $sql = "INSERT INTO pedido (preco_pedido, produto_pedido, mesa_pedido, fk_funcionario) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dssi", $precoTotal, $nomesProdutos, $mesaSelect, $id_funcionario);

        if ($stmt->execute()) {
            $conn->close();
            echo "";
        } else {
            $conn->close();
            echo "" . $stmt->error;
        }
    } else {
        echo "";
    }
} else {
    echo "";
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/cardapio.css">
    <link rel="stylesheet" href="assets/css/responsivo_cardapio.css">
    <script src="assets/js/main.js"></script>
    <title>Home Chikito Pizzaria</title>

</head>

<body>
    <nav class="navbar">
        <div class="logohome">
            <a href="cardapio.php">
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
        <div id="tipos">

           <a onClick="filtrarCategorias('salgada')" href="#pizzasalgada">
            <figure class="tipos-content">
                <img src="assets/img/pizza.png" class="tipo-img">
                <figcaption>Pizza Salgada</figcaption>
            </figure>
            </a>

            <a onClick="filtrarCategorias('doce')" href="#pizzadoce">
            <figure class="tipos-content">
                <img src="assets/img/doce.png" class="tipo-img">
                <figcaption>Pizza Doce</figcaption>
            </figure>
            </a>
       
            <a onClick="filtrarCategorias('bebidas')" href="#bebidas">
            <figure class="tipos-content">
                <img src="assets/img/bebidas.png" class="tipo-img">
                <figcaption>Bebidas</figcaption>
            </figure>
            </a>
        
        </div>
        <div id="items">

            <figure class="items-content" data-categoria="salgada">
                <img src="assets/img/pepperoni.png" class="items-img">
                <div class="text">
                    <figcaption class="caption">Pizza de Pepperoni</figcaption>
                    <blockquote>
                        Média | Calabresa , Queijo, Cebola e Borda Recheada com Catupiry
                    </blockquote>
                    <figcaption class="preco">R$ 40,00</figcaption>
                </div>
                <div class="button"><button class="btn" onclick="ContarCliques(this)">+</button></div>
                <span id="cliques0">0</span>
                <div class="button"><button class="btn" onclick="DescontarCliques(this)">-</button></div>
            </figure>

            <figure class="items-content" data-categoria="doce">
                <img src="assets/img/nutellao.png" class="items-img">
                <div class="text">
                    <figcaption class="caption">Pizza de Ninho com Nutella</figcaption>
                    <blockquote>
                        Grande | Nutella, Borda recheada com doce de leite
                    </blockquote>
                    <figcaption class="preco">R$ 50,00</figcaption>
                </div>
                <div class="button"><button class="btn" onclick="ContarCliques(this)">+</button></div>
                <span id="cliques1">0</span>
                <div class="button"><button class="btn" onclick="DescontarCliques(this)">-</button></div>
            </figure>

            <figure class="items-content" data-categoria="bebidas">
                <img src="assets/img/laranjao.png" class="items-img">
                <div class="text">
                    <figcaption class="caption">Fanta Laranja</figcaption>
                    <blockquote>
                        600ml | Com açúcar
                    </blockquote>
                    <figcaption class="preco">R$ 5,00</figcaption>
                </div>
                <div class="button"><button class="btn" onclick="ContarCliques(this)">+</button></div>
                <span id="cliques2">0</span>
                <div class="button"><button class="btn" onclick="DescontarCliques(this)">-</button></div>
            </figure>

            <figure class="items-content" data-categoria="bebidas">
                <img src="assets/img/schweppes.png" class="items-img">
                <div class="text">
                    <figcaption class="caption">Schweppes</figcaption>
                    <blockquote>
                        350ml | Sem açúcar
                    </blockquote>
                    <figcaption class="preco">R$ 6,00</figcaption>
                </div>
                <div class="button"><button class="btn" onclick="ContarCliques(this)">+</button></div>
                <span id="cliques3">0</span>
                <div class="button"><button class="btn" onclick="DescontarCliques(this)">-</button></div>
            </figure>
        </div>
        <div class="selected-products">
            <h2 class=select-pdt_h2>Produtos selecionados:</h2>
            <h2 class=all-price_h2>Preço total:</h2>
            <div class="mesa-selection">
            </div>
            <div class=div-btn-odr>
                <button name="btn-order" class="btn-odr">Efetuar Pedido</button>
            </div>
        </div>
</body>
</main>
</body>

</html>