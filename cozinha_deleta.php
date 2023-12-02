<?php
// Inclua o arquivo de conexão com o banco de dados (se necessário)
include 'conexao.php';

// Adicione o cabeçalho Content-Type
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha o ID do Pedido da solicitação JSON
    $data = json_decode(file_get_contents("php://input"), true);
    $idPedido = $data["idPedido"];

    // Verifique se o ID do Pedido foi fornecido
    if (empty($idPedido)) {
        $response = array("status" => "error", "message" => "ID do Pedido não fornecido.");
        echo json_encode($response);
        exit; // Encerrar a execução do script
    }

    // Tente deletar o pedido e verifique se há algum erro
    $sql = "DELETE FROM pedido WHERE id_pedido = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPedido);

    if ($stmt->execute()) {
        // Exclusão bem-sucedida
        $response = array("status" => "success", "message" => "Pedido excluído com sucesso.");
    } else {
        // Erro na exclusão
        $response = array("status" => "error", "message" => "Erro ao excluir o pedido: " . ($stmt->error ? $stmt->error : 'Unknown error'));
    }

    // Encerrar a execução do statement e a conexão com o banco de dados
    $stmt->close();
    $conn->close();

    // Imprimir a resposta antes de enviar
    echo json_encode($response);
} else {
    // Resposta para métodos de requisição inválidos
    $response = array("status" => "error", "message" => "Método de requisição inválido.");
    echo json_encode($response);
}
?>
