function alternaEdicao(idPedido) {
    var linha = document.getElementById("pedido_" + idPedido);

    var isEditando = linha.classList.contains('editando');

    if (!isEditando) {
        linha.classList.add('editando');
        editarPedido(idPedido);
    } else {
        linha.classList.remove('editando');
        salvarEdicao(idPedido);
    }
}



function editarPedido(idPedido) {
    var linha = document.getElementById("pedido_" + idPedido);

    linha.querySelectorAll('.edit, .delete').forEach(function (btn) {
        btn.disabled = true;
    });

    var salvarBtn = document.createElement('button');
    salvarBtn.textContent = 'Salvar';
    salvarBtn.onclick = function () {
        salvarEdicao(idPedido);
    };

    linha.querySelector('.edit').replaceWith(salvarBtn);

    ['nome_pedido', 'mesa_pedido', 'obs_pedido'].forEach(function (coluna) {
        var valorOriginal = linha.querySelector('.' + coluna).textContent;

        var input = document.createElement('input');
        input.type = 'text';
        input.value = valorOriginal;
        input.className = coluna + '-input';

        linha.querySelector('.' + coluna).innerHTML = '';
        linha.querySelector('.' + coluna).appendChild(input);
    });

    var idInput = document.createElement('input');
    idInput.type = 'hidden';
    idInput.name = 'id_pedido';
    idInput.value = idPedido;
    linha.appendChild(idInput);
}

function salvarEdicao(idPedido) {
    var linha = document.getElementById("pedido_" + idPedido);

    linha.querySelectorAll('.edit, .delete').forEach(function (btn) {
        btn.disabled = false;
    });

    // Obtenha os dados do pedido que você deseja atualizar
    var nomePedidoInput = linha.querySelector('.nome_pedido-input');
    var mesaPedidoInput = linha.querySelector('.mesa_pedido-input');
    var obsPedidoInput = linha.querySelector('.obs_pedido-input');

    var eventoEdicaoConcluida = new Event('edicaoConcluida');
    document.dispatchEvent(eventoEdicaoConcluida);

    var nomePedido = nomePedidoInput.value;
    var mesaPedido = mesaPedidoInput.value;
    var obsPedido = obsPedidoInput.value;

    // Substitua os inputs pelos textos originais usando elementos <span>
    replaceInputWithText(nomePedidoInput, nomePedido);
    replaceInputWithText(mesaPedidoInput, mesaPedido);
    replaceInputWithText(obsPedidoInput, obsPedido);

    // Envie os dados ao servidor usando fetch
    // ...

    fetch('editar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=editar&id_pedido=' + idPedido +
            '&nome_pedido=' + encodeURIComponent(nomePedido) +
            '&mesa_pedido=' + encodeURIComponent(mesaPedido) +
            '&obs_pedido=' + encodeURIComponent(obsPedido)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na requisição: ' + response.statusText);
            }
            // Retorna o corpo da resposta como texto
            return response.text();
        })
        .then(data => {
            // Aqui você pode processar o corpo como necessário, se for o caso
            console.log('Corpo da resposta:', data);

            // Agora, você pode criar um novo objeto Response para poder chamar response.json()
            return new Response(data, { headers: { 'Content-Type': 'application/json' } });
        })
        .then(response => response.json())
        .then(data => {
            // Lógica adicional, se necessário

            // Substituição do botão "Salvar" pelo botão "Editar"
            var editarBtn = document.createElement('button');
            editarBtn.textContent = 'Editar';
            editarBtn.className = 'edit'; // Adicione as classes necessárias aqui
            editarBtn.onclick = function () {
                editarPedido(idPedido);
            };

            // Substitui o botão "Salvar" pelo botão "Editar"
            var salvarBtn = linha.querySelector('button');
            if (salvarBtn) {
                salvarBtn.replaceWith(editarBtn);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });

    // ...


}

function replaceInputWithText(inputElement, text) {
    // Crie um elemento <span> com o texto original
    var textSpan = document.createElement('span');
    textSpan.textContent = text;

    // Substitua o input pelo <span>
    inputElement.parentNode.replaceChild(textSpan, inputElement);
}

function replaceInputWithText(inputElement, text) {
    // Crie um elemento <span> com o texto original
    var textSpan = document.createElement('span');
    textSpan.textContent = text;

    // Substitua o input pelo <span>
    inputElement.parentNode.replaceChild(textSpan, inputElement);
}

function replaceInputWithText(inputElement, text) {
    // Crie um elemento <span> com o texto original
    var textSpan = document.createElement('span');
    textSpan.textContent = text;

    // Substitua o input pelo <span>
    inputElement.parentNode.replaceChild(textSpan, inputElement);
}

function excluirPedido(idPedido) {
    var confirmacao = confirm("Tem certeza que deseja excluir este pedido?");

    if (confirmacao) {
        window.location.href = "excluir.php?id=" + idPedido;
    }
}
