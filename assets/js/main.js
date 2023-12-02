function mostra() {
    var div = document.getElementById("adicionar-item");
    if(div.style.display == "none") {
        div.style.display = "block";
    } else {
        div.style.display = "none";
    }
}

function toggleQuantidadeInput(checkbox) {
    var quantidadeInput = checkbox.parentElement.querySelector('.quantidade-input');
    quantidadeInput.style.display = checkbox.checked ? 'inline-block' : 'none';
}