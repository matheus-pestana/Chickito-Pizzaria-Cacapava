document.addEventListener('DOMContentLoaded', function () {
    var linksTipos = document.querySelectorAll('#tipos a');

    var cards = document.querySelectorAll('#cardapio .card');

    linksTipos.forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            var isAtivo = link.classList.contains('ativo');

            linksTipos.forEach(function (el) {
                el.classList.remove('ativo');
            });

            if (isAtivo) {
                cards.forEach(function (card) {
                    card.style.display = 'flex';
                });
                return;
            }

            link.classList.add('ativo');

            var tipoSelecionado = link.getAttribute('data-tipo');

            if (tipoSelecionado === 'todos') {
                cards.forEach(function (card) {
                    card.style.display = 'flex';
                });
            } else {
                cards.forEach(function (card) {
                    card.style.display = 'none';
                });

                cards.forEach(function (card) {
                    if (card.classList.contains(tipoSelecionado)) {
                        card.style.display = 'flex';
                    }
                });
            }
        });
    });
});


function Relogio() {

    var data = new Date();

    var hr = data.getHours();
    var min = data.getMinutes();
    var s = data.getSeconds();

    let strHora = new String(hr)
    let strMinuto = new String(min)
    let strSegundo = new String(s)

    if (strSegundo.length == 1) s = "0" + s
    if (strMinuto.length == 1) min = "0" + min
    if (strHora.length == 1) hr = "0" + hr


    var tempo_total = hr + ":" + min + ":" + s;

    var tempo = window.document.getElementById('hora');
    var tempoModal = window.document.getElementById('horaModal');
    tempo.innerHTML = tempo_total;
    tempoModal.innerHTML = tempo_total;
}
setInterval(Relogio, 500);


function abrirModal() {
    let modal = document.querySelector(".modal")
    let bg = document.querySelector(".bg")

    modal.style.display = 'block';
    bg.style.display = 'block';
}

function fechar() {
    let modal = document.querySelector(".modal")
    let bg = document.querySelector(".bg")

    modal.style.display = 'none';
    bg.style.display = 'none';
}

function enviarCozinha() {
    fechar()

    let modal2 = document.querySelector(".modal2")
    let bg2 = document.querySelector(".bg2")

    modal2.style.display = 'block';
    bg2.style.display = 'block';



}

function fechar2() {
    let modal2 = document.querySelector(".modal2")
    let bg2 = document.querySelector(".bg2")

    modal2.style.display = 'none';
    bg2.style.display = 'none';

}



function abrirModalErro() {
    let modal = document.querySelector(".modalErro")
    let bg = document.querySelector(".bgErro")

    modal.style.display = 'block';
    bg.style.display = 'block';
}

function fecharErro() {
    let modal = document.querySelector(".modalErro")
    let bg = document.querySelector(".bgErro")

    modal.style.display = 'none';
    bg.style.display = 'none';
}

function atualizarModal() {
    var total = document.getElementById("total").innerHTML
    var mesa = document.getElementById("mesa").value
    var nome = document.getElementById("nome").value

    if (mesa == "" || mesa == " ") {
        tituloErro = document.querySelector(".modalTitleErro")
        document.querySelector(".modalTitleErro").innerHTML = "Insira uma mesa"
        abrirModalErro()
    }
    else if (nome == "" || nome == " ") {
        tituloErro = document.querySelector(".modalTitleErro")
        document.querySelector(".modalTitleErro").innerHTML = "Preencha seu nome"
        abrirModalErro()
    }
    else if (total == "Total" || total == "R$0.00") {
        tituloErro = document.querySelector(".modalTitleErro")
        document.querySelector(".modalTitleErro").innerHTML = "Escolha um item"
        abrirModalErro()
    }
    else {
        var itensComanda = document.getElementById("itensComanda");

        var itensTexto = "";

        for (let i = 0; i < comandaItens.length; i++) {
            var item = comandaItens[i];
            itensTexto += `${item.nome} (x${item.quantidade})<br>`;
        }
        console.log(itensTexto)

        itensComanda.innerHTML = itensTexto;

        document.getElementById("totalModal").innerHTML = total
        document.getElementById("mesaModal").innerHTML = mesa
        document.getElementById("clienteModal").innerHTML = nome
        console.log("Valor do nome:", nome);
        abrirModal()
    }
}

function limparCampos() {

    document.getElementById("mesa").value = ""
    document.getElementById("nome").value = ""

    comandaItens.length = 0

    var elemento = document.getElementById("novosProdutos");
    while (elemento.firstChild) {
        elemento.removeChild(elemento.firstChild);

        atualizarPrecoTotal()
    }

}

let comandaItens = []

function adicionarProduto(id, nome, preco, img) {


    var itemExistente = comandaItens.find(item => item.id === id);

    if (itemExistente) {
        if (itemExistente.quantidade < 99) {
            itemExistente.quantidade++;
            var quantId = "quant_" + id;
            var inputQuantidade = document.getElementById(quantId);
            inputQuantidade.value = itemExistente.quantidade;
        }
    } else {
        comandaItens.push({
            id: id,
            nome: nome,
            preco: preco,
            quantidade: 1,
        });

        console.log(comandaItens)


        var quantId = "quant_" + id;

        var novoProduto = document.createElement("div");
        novoProduto.className = "produto";

        novoProduto.innerHTML = `
        <div class="imgQuant">
            <img class="img_card comanda_img" src=${img}>
            <div class="quantidade">
                <input onchange="certeza_de_zero('${quantId}'); atualizarQuantidade(${id}, '${quantId}');" type="number" min="1" max="99" class="input_login quant" placeholder="Quantidade" id="${quantId}" value=1>
            </div>
        </div>
        <div class="textoRemove">
            <h2 class="nomeComanda" name="produto">${nome}</h2>
            <h3 class="precoComanda">R$${preco.toFixed(2)}</h3>
            <button class="btnRemove" onclick="removerProduto(this, ${id})">Remover</button>
        </div>
    `;

        var novosProdutosDiv = document.getElementById("novosProdutos");
        novosProdutosDiv.appendChild(novoProduto);
    }

    atualizarPrecoTotal();
}



function certeza_de_zero(input) {

    var quantidade = document.getElementById(input).value

    if (quantidade < 1) {
        document.getElementById(input).value = 1
    }

    else if (quantidade > 99) {
        document.getElementById(input).value = 99
    }


}

function certeza_de_zeroMesa() {


    var mesa = document.getElementById("mesa").value


    if (mesa < 1) {
        document.getElementById("mesa").value = 1
    }

    else if (mesa > 20) {
        document.getElementById("mesa").value = 20
    }

}



function atualizarQuantidade(id, quantId) {
    var quantidade = parseInt(document.getElementById(quantId).value);

    var item = comandaItens.find(item => item.id === id);

    if (item) {
        item.quantidade = quantidade;

        atualizarPrecoTotal();
    }
}


function atualizarPrecoTotal() {
    var total = 0;

    for (var i = 0; i < comandaItens.length; i++) {
        var item = comandaItens[i];
        total += item.preco * item.quantidade;
    }

    var inputTotal = document.getElementById("total");
    inputTotal.innerHTML = "R$" + total.toFixed(2);

    console.log(comandaItens)
    console.log(total);
    return total.toFixed(2);
}




function removerProduto(button, id) {
    var itemIndex = comandaItens.findIndex(item => item.id === id);


    if (itemIndex !== -1) {
        comandaItens[itemIndex].quantidade = 0;

        var produto = button.parentElement.parentElement;

        produto.remove();

        comandaItens.splice(itemIndex, 1);

        atualizarPrecoTotal();



    }
}

function enviaPedidoCozinha(event) {
    event.preventDefault();

    let mesaModal = document.getElementById("mesaModal").innerText;
    let clienteModal = document.getElementById("clienteModal").innerText;
    let prodModal = document.getElementById("itensComanda").innerText;
    let horaModal = document.getElementById("horaModal").innerText;
    let obsModal = document.getElementById("obs").value;
    let totalModal = document.getElementById("totalModal").innerText;

    let form = new FormData();
    form.append("nome", clienteModal);
    form.append("mesa", mesaModal);
    form.append("hora", horaModal);
    form.append("observacao", obsModal);
    form.append("total", totalModal);
    form.append("produtos", prodModal);

    fetch("inserir.php", {
        method: "POST",
        body: form
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        fechar();
        limparCampos();
    })
    .catch(error => {
        console.error("Erro ao enviar pedido:", error);
    });
}

var pedidoForm = document.getElementById("pedidoForm");

if (pedidoForm) {
    pedidoForm.addEventListener('submit', enviaPedidoCozinha);
} else {
    console.error("Formulário não encontrado na página.");
}


// document.querySelector('.enviar').addEventListener('click', enviarCozinha);

