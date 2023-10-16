<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    $sql = "SELECT * FROM sua_tabela WHERE campo_email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $novaSenha = substr(md5(mt_rand()), 0, 8);

        $hashNovaSenha = password_hash($novaSenha, PASSWORD_DEFAULT);

        $sql = "UPDATE funcionario SET senha_adm = ? WHERE email_adm = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $hashNovaSenha, $email);
        $stmt->execute();

        $assunto = "Nova Senha";
        $mensagem = "Sua nova senha é: " . $novaSenha;
        $headers = "De: suacontato@seusite.com";

        mail($email, $assunto, $mensagem, $headers);

        $conexao->close();

        header("Location: login.php");
        exit();
    } else {
        echo "O email fornecido não está cadastrado.";
    }

    $conexao->close();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Chikito Pizzaria</title>
    <link rel="stylesheet" href="assets/css/senha.css">
    <link rel="stylesheet" href="assets/css/responsivo_senha.css">
    <script src="js/main.js"></script>
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
            <form action="">
                <div id="LOGINitr">
                    <h2 class="login">Redefinir Senha</h2><br>
                </div>

                <div id="E-mailitr">
                    <h3 class="E-mail">E-mail</h3>
                    <input type="email" class="Hr2" id="email" name="email">
                </div>

                <!-- NEW PASSWORD -->
                <div id="Passworditr">
                    <h3 class="Password">Nova senha</h3>
                    <div class="Hr3" contenteditable></div>
                </div>

                <!-- CONFIRM PASSWORD -->
                <div id="Passworditr">
                    <h3 class="Password">Senha</h3>
                    <div class="Hr3" contenteditable></div>
                </div>

                <!-- ALTS -->
                <div id="alts">
                    <a href="index.php" class="retornar">Retornar ao Login</a>
                    <a href="cadastro.php" class="cadastro">Novo por aqui? Cadastre-se.</a>
                </div>

                <!-- BUTTON -->
                <div id="Buttonitr">
                    <button class="Button-Login" type="button" onclick="ButtonLogin()">LOGIN</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>