<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itensSelecionados = $_POST['itens'];
    $quantidades = $_POST['quantidades'];

    $sql = "INSERT INTO pedido (produto_pedido, preco_pedido) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    for ($i = 0; $i < count($itensSelecionados); $i++) {
        $item = $itensSelecionados[$i];
        $quantidade = $quantidades[$i];
        $stmt->bind_param("si", $item, $quantidade);
        $stmt->execute();
    }

    $stmt->close();
    mysqli_close($conn);
}
?>
