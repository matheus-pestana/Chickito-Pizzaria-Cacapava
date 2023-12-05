<?php
include 'conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $email = $_POST['email'];
    $novaSenha = $_POST['novaSenha'];
    $confirmaSenha = $_POST['confirmaSenha'];

    // Validações adicionais, se necessário...

    // Verifica se o email existe no banco de dados
    $verificaEmail = "SELECT * FROM funcionario WHERE email_adm = '$email'";
    $resultado = $conn->query($verificaEmail);

    if ($resultado->num_rows == 0) {
        echo "<script>alert('Email não encontrado.');window.location.href = 'senha.php';</script>";
        exit();
    }

    // Verifica se a senha digitada é a mesma da senha confirmada
    if ($novaSenha !== $confirmaSenha) {
        echo "<script>alert('As senhas não coincidem.');window.location.href = 'senha.php';</script>";
        exit();
    }

    // Atualiza a senha no banco de dados
    $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
    $sql = "UPDATE funcionario SET senha_adm = '$novaSenhaHash' WHERE email_adm = '$email'";

    if ($conn->query($sql) === TRUE) {
        // Exibe um aviso
        echo "<script>alert('Senha alterada com Sucesso.'); window.location.href = 'index.php';</script>";
        exit();
    } else {
        echo "Erro ao atualizar a senha: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senha - Chikito Pizzaria</title>
    <link rel="shortcut icon" type="imagex/png" href="assets/img/LogoChickito.png">
    <link rel="stylesheet" href="assets/css/senha.css">
    <link rel="stylesheet" href="assets/css/responsivo_senha.css">
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
                    <h2 class="login">Redefinir Senha</h2><br>
                </div>

                <div id="E-mailitr">
                    <h3 class="E-mail">E-mail</h3>
                    <input type="email" class="Hr2" id="email" name="email" required>
                </div>

                <!-- NOVA SENHA -->
                <div id="NovaSenhaitr">
                    <h3 class="Password">Nova senha</h3>
                    <input type="password" class="Hr3" id="novaSenha" name="novaSenha" required>
                </div>

                <!-- CONFIRMAR NOVA SENHA -->
                <div id="ConfirmaSenhaitr">
                    <h3 class="Password">Confirme a nova senha</h3>
                    <input type="password" class="Hr3" id="confirmaSenha" name="confirmaSenha" required>
                </div>

                <!-- ALTS -->
                <div id="alts">
                    <a href="index.php" class="retornar">Retornar ao Login</a>
                    <a href="cadastro.php" class="cadastro">Novo por aqui? Cadastre-se.</a>
                </div>

                <!-- BUTTON -->
                <div id="Buttonitr">
                    <input class="Button-Login" type="submit" value="Redefinir Senha">
                </div>

            </form>
        </div>
    </div>
</body>

</html>