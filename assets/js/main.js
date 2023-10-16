const contadores = [0, 0, 0, 0];

function ContarCliques(element) {
    const index = Array.from(element.parentElement.parentElement.parentElement.children).indexOf(element.parentElement.parentElement);
    contadores[index]++;
    document.getElementById(`cliques${index}`).innerHTML = contadores[index];
    atualizarDiv();
}

function DescontarCliques(element) {
    const index = Array.from(element.parentElement.parentElement.parentElement.children).indexOf(element.parentElement.parentElement);
    if (contadores[index] > 0) {
        contadores[index]--;
        document.getElementById(`cliques${index}`).innerHTML = contadores[index];
        atualizarDiv();
    } else {
        alert("Não é possível pedir quantidades negativas.");
    }
}

function atualizarDiv() {
    const selectedProductsDiv = document.querySelector('.selected-products');
    let produtosSelecionados = '';

    for (let i = 0; i < contadores.length; i++) {
        if (contadores[i] > 0) {
            const itemName = getItemName(i);
            produtosSelecionados += `<p>Item ${i + 1}: ${itemName}, Quantidade: ${contadores[i]}</p>`;

            // Adicione campos ocultos para cada produto que armazenam o índice
            produtosSelecionados += `<input type="hidden" name="produto_indice[${i}]" value="${i}">`;
        }
    }

    const precoTotal = calcularPrecoTotal();

    selectedProductsDiv.innerHTML = `
        <h2 class="select-pdt_h2">Produtos selecionados:</h2>
        ${produtosSelecionados}
        <h2 class="all-price_h2">Preço total: R$ <span id="precoTotal">${precoTotal}</span></h2>
        <form action="cardapio.php" method="POST">
            <input type="hidden" name="precoTotal" value="${precoTotal}">
            ${getHiddenInputs()}
            
            <div id="mesa">
                <label for="mesaSelect">Escolha a Mesa:</label>
                <select id="mesaSelect" name="mesaSelect">
                    <option value="1">Mesa 1</option>
                    <option value="2">Mesa 2</option>
                    <option value="3">Mesa 3</option>
                    <option value="4">Mesa 4</option>
                    <option value="5">Mesa 5</option>
                    <option value="6">Mesa 6</option>
                    <option value="7">Mesa 7</option>
                </select>
            </div>
            
            <div class="div-btn-odr">
                <button name="btn-order" class="btn-odr" type="submit">Efetuar Pedido</button>
            </div>
        </form>
    `;
}



function getItemName(index) {
    const itemNames = ["Pizza de Pepperoni", "Pizza de Ninho com Nutella", "Fanta Laranja", "Schweppes"];
    return itemNames[index];
}

function calcularPrecoTotal() {
    const precos = [40.00, 50.00, 5.00, 6.00];
    let precoTotal = 0;

    for (let i = 0; i < contadores.length; i++) {
        precoTotal += contadores[i] * precos[i];
    }

    return precoTotal.toFixed(2);
}

function getHiddenInputs() {
    let hiddenInputs = '';
    for (let i = 0; i < contadores.length; i++) {
        if (contadores[i] > 0) {
            hiddenInputs += `<input type="hidden" name="produtos[${i}]" value="${contadores[i]}">`;
            hiddenInputs += `<input type="hidden" name="produto_nome[${i}]" value="${getItemName(i)}">`;
            hiddenInputs += `<input type="hidden" name="produto_preco[${i}]" value="${getProdutoPreco(i)}">`;
        }
    }
    return hiddenInputs;
}

function getProdutoPreco(index) {
    const precos = [40.00, 50.00, 5.00, 6.00];
    return precos[index].toFixed(2);
}

function criarSelectMesa() {
    const selectMesa = document.createElement('select');
    selectMesa.id = 'mesaSelect';
    selectMesa.name = 'mesaSelect';

    const opcoesMesa = ["Mesa 1", "Mesa 2", "Mesa 3", "Mesa 4", "Mesa 5", "Mesa 6", "Mesa 7"];

    for (let i = 0; i < opcoesMesa.length; i++) {
        const option = document.createElement('option');
        option.value = i + 1;
        option.text = opcoesMesa[i];
        selectMesa.appendChild(option);
    }
}

function filtrarCategorias(categoria) {
    document.querySelectorAll(`[data-categoria]`).forEach((item) => {
    item.style.display='none';
    })

    document.querySelectorAll(`[data-categoria='${categoria}']`).forEach((item) => {
        item.style.display='flex';
        })
 }