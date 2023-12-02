<?php

include 'conexao.php';

// Cria um array para armazenar a resposta
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'editar') {
        if (isset($_POST['id_pedido'])) {
            $idPedido = $_POST['id_pedido'];
            $nomePedido = $_POST['nome_pedido'];
            $mesaPedido = $_POST['mesa_pedido'];
            $obsPedido = $_POST['obs_pedido'];

            $sql = "UPDATE pedido SET 
                    nome_pedido = '$nomePedido',
                    mesa_pedido = '$mesaPedido',
                    obs_pedido = '$obsPedido'
                    WHERE id_pedido = $idPedido";

            $result = $conn->query($sql);

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Atualização bem-sucedida';
            } else {
                $response['success'] = false;
                $response['message'] = 'Erro ao executar a atualização: ' . $conn->error;
            }
        }
    }
}

// Define o cabeçalho para indicar que a resposta é do tipo JSON
header('Content-Type: application/json');

// Converte o array para formato JSON e imprime
echo json_encode($response);

?>
