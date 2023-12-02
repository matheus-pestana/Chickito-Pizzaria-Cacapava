<?php
include 'conexao.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Verifique se o email existe no banco de dados (você deve implementar isso)
    // Se o email existir, gere um token de redefinição de senha
    $token = bin2hex(random_bytes(32));

    // Salve o token no banco de dados junto com a data de expiração (por exemplo, 1 hora no futuro)

    // Agora, envie um email com um link para redefinir a senha
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pedrogabrielxx268@gmail.com'; // Seu endereço de email do Gmail
        $mail->Password = 'ghxo gkma rjgp kewq'; // Senha de aplicativo gerada anteriormente
        $mail->SMTPSecure = 'PHPMailer::ENCRYPTION_SMTPS';
        $mail->Port = 587;
        

        $mail->setFrom('pedrogabrielxx268@gmail.com', 'ghxo gkma rjgp kewq');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Redefinir Senha - Chikito Pizzaria';
        $mail->Body = 'Clique no link a seguir para redefinir sua senha: ' . 
            '<a href="https://seusite.com/redefinir_senha.php?token=' . $token . '">Redefinir Senha</a>';

        $mail->send();
        echo "<script>alert('Um email com as instruções para redefinir a senha foi enviado para o seu email.'); window.location.href = 'index.php';</script>";
    } catch (Exception $e) {
        echo "Erro no envio do email: {$mail->ErrorInfo}";
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Chikito Pizzaria</title>
    <link rel="shortcut icon" type="imagex/png" href="assets/img/LogoChickito.png">
    <link rel="stylesheet" href="assets/css/senha.css">
    <link rel="stylesheet" href="assets/css/responsivo_senha.css">
    <script src="assets/js/main.js"></script>
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
            <form action="redefinir_senha.php" method="POST">
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
