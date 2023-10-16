<?php
session_start();
include 'conexao.php';

if (isset($_SESSION['id_funcionario'])) {
    header('Location: home.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['senha'];

    $sql = "SELECT id_funcionario, senha_adm FROM funcionario WHERE email_adm = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id_funcionario, $stored_password);
                mysqli_stmt_fetch($stmt);

                if (password_verify($password, $stored_password)) {
                    $_SESSION['id_funcionario'] = $id_funcionario;
                    header('Location: home.php');
                    exit();
                } else {
                    echo "Senha incorreta. <a href='index.php'>Tente novamente</a>.";
                }
            } else {
                echo "E-mail não encontrado. <a href='index.php'>Tente novamente</a>.";
            }
        } else {
            echo "Erro na execução da consulta: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Erro na preparação da consulta: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Chikito Pizzaria</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsivo_login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100&display=swap" rel="stylesheet">
</head>

<body>
    <div id="content">
        <div id="content-items">
            <img class="logo" src="assets/img/LogoChickito.png" alt="Avatar">

            <!-- LOGIN -->
            <form action="" method="POST">
                <div id="LOGINitr">
                    <h2 class="login">LOGIN</h2><br>
                </div>

                <!-- E-MAIL -->
                <div id="E-mailitr">
                    <h3 class="E-mail">E-mail</h3>
                    <input type="email" class="Hr2" id="email" name="email" required>
                </div>

                <!-- PASSWORD -->
                <div id="Passworditr">
                    <h3 class="Password">Senha</h3>
                    <input type="password" class="Hr3" id="senha" name="senha" required>
                </div>

                <!-- ALTS -->
                <div id="alts">
                    <a href="senha.php" class="esquecer">Esqueceu sua senha?</a>
                    <a href="cadastro.php" class="cadastro">Novo por aqui? Cadastre-se.</a>
                </div>

                <!-- BUTTON -->
                <div id="Buttonitr">
                    <input class="Button-Login" type="submit" value="Login"></input>
                </div>
            </form>
        </div>
    </div>
</body>

</html>