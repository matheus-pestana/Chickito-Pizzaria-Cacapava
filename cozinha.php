<?php
session_start();
include 'conexao.php';

// Verifique se o funcionário está autenticado e autorizado a acessar a cozinha
if (!isset($_SESSION["id_funcionario"])) {
    header("Location: index.php");
    exit();
}

// Atualize o status do pedido (se o formulário for enviado)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["atualizar_status"])) {
    $pedido_id = $_POST["pedido_id"];
    $novo_status = $_POST["novo_status"];

    // Execute uma consulta SQL para atualizar o status do pedido
    $sql_update = "UPDATE pedido SET status_pedido = ? WHERE id_pedido = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("si", $novo_status, $pedido_id);

    if ($stmt->execute()) {
        // Status do pedido atualizado com sucesso
        header("Location: cozinha.php");
        exit();
    } else {
        // Erro ao atualizar o status
        echo "Erro ao atualizar o status do pedido: " . $stmt->error;
    }

    $stmt->close();
}

$sql = "SELECT id_pedido, status_pedido, observacoes, produto_pedido FROM pedido WHERE status_pedido = 'pendente'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/cozinha.css">
    <link rel="stylesheet" href="assets/css/cardapio.css">
    <link rel="stylesheet" href="assets/css/responsivo_cozinha.css">
    <script src="assets/js/main.js"></script>
    <title>Cozinha Chikito Pizzaria</title>
</head>
<body>
    <nav class="navbar">
        <div class="logohome">
            <a href="pedidos.php">
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
        <div id="content">
            <h1>Cozinha - Pedidos</h1>
            <table>
                <?php
                echo "<tr>";
                echo "<th>ID do Pedido</th>";
                echo "<th>Produto</th>";
                echo "<th>Observações</th>";
                echo "<th>Ação</th>";
                echo "<th>Status</th>";
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id_pedido"] . "</td>";
                    echo "<td>" . $row["produto_pedido"] . "</td>";
                    echo "<td>" . $row["observacoes"] . "</td>";
                    echo "<td>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='pedido_id' value=''" . $row["id_pedido"] . "'>";
                    echo "<select name='novo_status'>";
                    echo "<option value='pendente'>Pendente</option>";
                    echo "<option value='concluído'>Concluído</option>";
                    echo "</select>";
                    echo "<input type='submit' name='atualizar_status' value='Atualizar Status' class='btn-att'>";
                    if ($row["status_pedido"] == 'concluído') {
                        echo "<input type='submit' name='excluir_pedido' value='Excluir' class='btn-excluir'>";
                    }
                    echo "</form>";
                    echo "</td>";
                    echo "<td>" . $row["status_pedido"] . "</td>";
                    echo "</tr>";
                }

                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["excluir_pedido"])) {
                    $pedido_id = $_POST["pedido_id_excluir"];
                
                    // Execute uma consulta SQL para excluir o pedido
                    $sql_delete = "DELETE FROM pedido WHERE id_pedido = ?";
                    $stmt_delete = $conn->prepare($sql_delete);
                    $stmt_delete->bind_param("i", $pedido_id);
                
                    if ($stmt_delete->execute()) {
                        // Pedido excluído com sucesso
                        header("Location: cozinha.php");
                        exit();
                    } else {
                        // Erro ao excluir o pedido
                        echo "Erro ao excluir o pedido: " . $stmt_delete->error;
                    }
                
                    $stmt_delete->close();
                }
                
                                
                ?>
            </table>
        </div>
    </main>
</body>
</html>
