document.addEventListener('DOMContentLoaded', function () {
    var statusSelects = document.querySelectorAll('.status');

    statusSelects.forEach(function (select) {
        select.addEventListener('change', function () {
            var idPedido = this.getAttribute('data-id');
            var novoStatus = this.value;

            if (novoStatus === 'Concluído') {
                console.log('ID do Pedido:', idPedido); // Adicione esta linha
                alert('Tem certeza que deseja excluir este pedido?')
                enviarSolicitacaoExclusao(idPedido);
            }
        });
    });
});

function enviarSolicitacaoExclusao(idPedido) {
    console.log('Enviando solicitação de exclusão para ID:', idPedido);

    fetch('cozinha_deleta.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            idPedido: idPedido,
        }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log(data); // Log the response from the server
        // Assuming the response contains a status field, update the UI accordingly
        if (data.status === 'success') {
            // Update the table or perform any other necessary actions
            document.getElementById('pedido_' + idPedido).remove();
        } else {
            console.error('Error deleting pedido:', data.message);
        }
    })
    .catch(error => {
        console.error('Erro ao enviar solicitação:', error);
    });
}

