<?php

session_start();

include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $mesa = $_POST["mesa"];
    $hora = $_POST["hora"];
    $observacao = $_POST["observacao"];
    $valortotal = $_POST["total"];
    $produtos = $_POST["produtos"];
    $id_funcionario = $_SESSION['id_funcionario'];

    $sql = "INSERT INTO pedido (nome_pedido, mesa_pedido, hora_pedido, obs_pedido, itens_pedido, valor_total, fk_id_funcionario)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $nome, $mesa, $hora, $observacao, $produtos, $valortotal, $id_funcionario);

    if ($stmt->execute()) {
        echo "Registro inserido com sucesso";
    } else {
        echo "Erro ao inserir o registro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
