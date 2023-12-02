<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $password = $_POST['senha'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO funcionario (nome_adm, email_adm, senha_adm) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $nome, $email, $hashed_password);
        if (mysqli_stmt_execute($stmt)) {
            // Cadastro bem-sucedido, define a mensagem de alerta
            echo "<script>alert('Usuário Cadastrado com Sucesso.'); window.location.href = 'index.php';</script>";
        } else {
            // Erro no cadastro, define a mensagem de alerta
            echo "<script>alert('Erro ao cadastrar usuário.');</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        // Erro na preparação da consulta, define a mensagem de alerta
        echo "<script>alert('Erro na preparação da consulta.');</script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Chikito Pizzaria</title>
    <link rel="shortcut icon" type="imagex/png" href="assets/img/LogoChickito.png">
    <link rel="stylesheet" href="assets/css/cadastro.css">
    <link rel="stylesheet" href="assets/css/responsivo_cadastro.css">
    <script src="../Projeto chickito/assets/js/main.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100&display=swap" rel="stylesheet">
</head>

<body>
    <div id="content">
        <div id="content-items">
            <div class="Background-Square"></div>
            <img class="logo" src="assets/img/LogoChickito.png" alt="Avatar">

            <!-- LOGIN -->
            <form action="" method="POST">
                <div id="LOGINitr">
                    <h2 class="LOGIN">CADASTRO</h2><br>
                </div>

                <!-- NOME -->

                <div id="nomeitr">
                    <h3 class="nome">Nome</h3>
                    <input type="nome" class="Hr1" id="nome" name="nome">
                </div>


                <!-- E-MAIL -->
                <div id="E-mailitr">
                    <h3 class="E-mail">E-mail</h3>
                    <input type="email" class="Hr2" id="email" name="email">
                </div>

                <!-- PASSWORD -->
                <div id="Passworditr">
                    <h3 class="Password">Senha</h3>
                    <input type="password" class="Hr3" id="senha" name="senha">
                </div>

                <!-- ALTS -->
                <div id="alts">
                    <a href="index.php" class="esquecer">Entrar com e-mail</a>
                </div>

                <!-- BUTTON -->
                <div id="Buttonitr">
                    <input type="submit" class="Button-Login" value="Cadastrar-se">
                </div>
            </form>
        </div>
    </div>
</body>

</html>