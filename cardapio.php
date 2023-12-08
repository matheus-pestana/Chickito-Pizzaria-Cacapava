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
    <link rel="stylesheet" href="assets/css/cardapio.css">
    <link rel="stylesheet" href="assets/css/responsivo_cardapio.css">
    <script src="assets/js/hamburguinho.js"></script>
    <title>Home - Chikito Pizzaria</title>

</head>

<body>
    <nav class="navbar">
        <div class="logohome">
            <a href="cozinha.php">
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
        <div class="bg">
        </div>
        <div class="modal">
            <form id="pedidoForm" onsubmit="enviarCozinha()">
                <div class="contentModal">
                    <h2 class="modalTitle">Finalizar pedido</h2>
                    <h3>Hora:</h3>
                    <p id="horaModal"></p>
                    <h3>Pedidos:</h3>
                    <div id="itensModal">
                        <p id="itensComanda" class="produtoModal"></p>
                    </div>

                    <textarea name="observacao" id="obs" class="text_obs" cols="30" rows="10" placeholder="Insira aqui as observações sobre o pedido"></textarea>
                    <h3>Total:</h3>
                    <p id="totalModal"></p>
                    <h3>Mesa:</h3>
                    <p id="mesaModal"></p>
                    <h3>Cliente:</h3>
                    <p id="clienteModal"></p>
                    <div class=" btn_modal">
                        <button type="submit" id="enviar" class="enviar" onclick="enviarCozinha(); limparCampos();">Finalizar pedido</button>
                        <button class="fechar" type="button" onclick="fechar()">Fechar</button>
                    </div>
            </form>
        </div>

        <div class="bg2">
        </div>
        <div class="modal2">
            <div class="contentModal2">
                <h2 class="modalTitle2">Seu pedido foi finalizado</h2>
                <img src="assets/img/correto.png" alt="Certo" class="certo">
                <button class="fechar" onclick="fechar2()">Fechar</button>
            </div>
        </div>
        </div>

        <div class="bgErro">
        </div>
        <div class="modalErro">
            <div class="contentModalErro">
                <h2 class="modalTitleErro"></h2>
                <img class="certo erro" src="assets/img/erro.png" alt="Erro">
                <button class="fechar" onclick="fecharErro()">Fechar</button>
            </div>
        </div>
        </div>
    <div class="title-tipos">
       <h2>Filtros</h2>
       <h6 class="descricao">arraste caso queira ver o resto das categorias</h6>
    </div>
        

        <div id="tipos">

            <a href="#pizzasalgada" data-tipo="salgada">
                <figure class="tipos-content">
                    <img src="assets/img/pizza.png" class="tipo-img">
                    <figcaption>Pizza Salgada</figcaption>
                </figure>
            </a>

            <a href="#pizzadoce" data-tipo="doce">
                <figure class="tipos-content">
                    <img src="assets/img/doce.png" class="tipo-img">
                    <figcaption>Pizza Doce</figcaption>
                </figure>
            </a>

            <a href="#bebidas" data-tipo="bebida">
                <figure class="tipos-content">
                    <img src="assets/img/bebidas.png" class="tipo-img">
                    <figcaption>Bebidas</figcaption>
                </figure>
            </a>

            <a href="#promocoes" data-tipo="promo">
                <figure class="tipos-content">
                    <img src="assets/img/promopizza.png" class="tipo-img">
                    <figcaption>Promoções</figcaption>
                </figure>
            </a>

        </div>

        <h2 class="title_cardapio">Cardápio</h2>

        <div id="cardapio">

            <div class="card salgada">
                <img src="assets/img/calabresa.png" alt="calabresa" class="img_card">
                <div class="content">
                    <h3 class="nome">Pizza de calabresa</h3>
                    <p class="preco">R$35,99</p>
                </div>
                <button class="btn_card" onclick="adicionarProduto(1,'Pizza de calabresa', 35.99, 'assets/img/calabresa.png' )">Escolher</button>
            </div>

            <div class="card salgada">
                <img src="assets/img/brocatu.png" alt="Brócolis" class="img_card">
                <div class="content">
                    <h3 class="nome">Pizza de brócolis</h3>
                    <p class="preco">R$35,99</p>
                </div>
                <button class="btn_card" onclick="adicionarProduto(2,'Pizza de brócolis', 35.99, 'assets/img/brocatu.png' )">Escolher</button>
            </div>

            <div class="card salgada">
                <img src="assets/img/francatu.png" alt="Frango CaTupiry" class="img_francatu">
                <div class="content">
                    <h3 class="nome">Pizza de frango com catupiry</h3>
                    <p class="preco">R$39,99</p>
                </div>
                <button class="btn_card" onclick="adicionarProduto(3,'Pizza de frango com catupiry', 39.99, 'assets/img/francatu.png' )">Escolher</button>
            </div>

            <div class="card salgada">
                <img src="assets/img/marguerita.png" alt="marguerita" class="img_marg">
                <div class="content">
                    <h3 class="nome">Pizza marguerita</h3>
                    <p class="preco">R$37,99</p>
                </div>
                <button class="btn_card" onclick="adicionarProduto(4,'Marguerita', 37.99, 'assets/img/marguerita.png' )">Escolher</button>
            </div>

            <div class="card salgada">
                <img src="assets/img/mussarela.jpg" alt="hot-mussarela" class="img_card">
                <div class="content">
                    <h3 class="nome">Pizza de mussarela</h3>
                    <p class="preco">R$30,99</p>
                </div>
                <button class="btn_card" onclick="adicionarProduto(5,'Pizza de mussarela', 30.99, 'assets/img/mussarela.jpg' )">Escolher</button>
            </div>

            <div class="card salgada">
                <img src="assets/img/saecacatu.png" alt="carne seca catupiry" class="img_carnsecatu">
                <div class="content">
                    <h3 class="nome">Pizza de carne seca com catupiry</h3>
                    <p class="preco">R$45,99</p>
                </div>
                <button class="btn_card" onclick="adicionarProduto(6,'Carne seca com catupiry', 45.99, 'assets/img/saecacatu.png' )">Escolher</button>
            </div>


            <div class="card salgada">
                <img src="assets/img/tomate-seco.png" alt="tomate seco rúcula" class="img_tomasecoru">
                <div class="content">
                    <h3 class="nome">Pizza de tomate seco com rúcula</h3>
                    <p class="preco">R$38,99</p>
                </div>
                <button class="btn_card" onclick="adicionarProduto(7,'Tomate seco com rúcula', 38.99, 'assets/img/tomate-seco.png' )">Escolher</button>
            </div>

            <div class="card doce">
                <img src="assets/img/chocorango.png" alt="Chocolate com morango" class="img_moranchoco">
                <div class="content">
                    <h3 class="nome">Pizza de chocolate com morango</h3>
                    <p class="preco">R$48,99</p>
                </div>
                <button class="btn_card" onclick="adicionarProduto(8,'Chocolate com morango', 48.99, 'assets/img/chocorango.png' )">Escolher</button>
            </div>

            <div class="card bebida">
                <img src="assets/img/schweppes.png" alt="schweppes" class="img_card">
                <div class="content">
                    <h3 class="nome">Schweppes</h3>
                    <p class="preco">R$4,99</p>
                </div>
                <button class="btn_card" onclick="adicionarProduto(9,'Schweppes', 4.99, 'assets/img/schweppes.png' )">Escolher</button>
            </div>

            <div class="card bebida">
                <img src="assets/img/coca.png" alt="coca" class="img_card">
                <div class="content">
                    <h3 class="nome">Coca-cola 350ml</h3>
                    <p class="preco">R$5,50</p>
                </div>
                <button class="btn_card" onclick="adicionarProduto(10,'Coca-cola', 5.50, 'assets/img/coca.png' )">Escolher</button>
            </div>

            <div class="card bebida">
                <img src="assets/img/awa.png" alt="água" class="img_card">
                <div class="content">
                    <h3 class="nome">Água</h3>
                    <p class="preco">R$3,99</p>
                </div>
                <button class="btn_card" onclick="adicionarProduto(11,'Água', 3.99, 'assets/img/awa.png' )">Escolher</button>
            </div>

            <div class="card bebida">
                <img src="assets/img/sucos.png" alt="sucos" class="img_card">
                <div class="content">
                    <h3 class="nome">Sucos (diversos)</h3>
                    <p class="preco">R$7,99</p>
                </div>
                <button class="btn_card" onclick="adicionarProduto(12,'Sucos', 7.99, 'assets/img/sucos.png' )">Escolher</button>
            </div>

        </div>
        </div>

        <h2 class="title_comanda">Pedido</h2>

        <div id="comanda">
            <form method="POST">
                <div class="hora" id="hora" name="hora">

                </div>
                <div class="mesa_div">
                    <input type="number" class="input_login mesa" name="mesa" id="mesa" placeholder="Mesa" min="1" max="20" onchange="certeza_de_zeroMesa()">
                </div>

                <div id="nome_div">
                    <input type="text" id="nome" name="nome" class="input_login cliente" placeholder="Nome do cliente">
                </div>

            </form>

            <div class="novosProdutos" id="novosProdutos">

            </div>

            <div class="envio">
                <div class="inputs preco">
                    <p type="text" class="input_login valor" id="total">Total</p>

                    <button class="btn_enviar" onclick="atualizarModal()">Enviar pedido</button>
                </div>
            </div>
        </div>


    </main>

    <footer>
        <p class="footer-text">© 2023 Code Flow. Todos os direitos reservados.</p>
        <p class="footer-text">Versão do Produto: 2.8.1</p>
    </footer>

    <script src="assets/js/cardapio.js"></script>
</body>

</html>