<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION["id_funcionario"])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    echo "ID de pedido inválido.";
    exit();
}

$idPedido = $_GET["id"];

$query = "DELETE FROM pedido WHERE id_pedido = ?";
$statement = $conn->prepare($query);

if ($statement) {
    $statement->bind_param('i', $idPedido);
    $statement->execute();

    if ($statement->affected_rows > 0) {
        echo "Pedido excluído com sucesso.";
        header('location: pedidos.php');
    } else {
        echo "Erro ao excluir o pedido.";
    }

    $statement->close();
} else {
    echo "Erro na preparação da declaração.";
    exit();
}

?>