var linha = 0;

function adicionarItem(){
  var nivel = document.getElementById("nivel").value;
  var disciplina = document.getElementById("disciplina").value;

  var tabela = document.getElementById("tabela");
  var newRow = document.createElement("tr");
  newRow.classList.add ("removable-rows");
  newRow.id = "row_" + linha;
  tabela.appendChild(newRow);

  var newTd = document.createElement("td");
  newTd.textContent = nivel;
  newTd.classList.add("row-table");
  newRow.appendChild(newTd);
  var newInput = document.createElement("input");
  newInput.type = "hidden";
  newInput.value = nivel;
  newTd.appendChild(newInput);
  newInput.name = "nivel_"+ linha;

  newTd = document.createElement("td");
  newTd.classList.add("row-table");
  newTd.innerHTML = disciplina;
  newRow.appendChild(newTd);
  newInput = document.createElement("input");
  newInput.type = "hidden";
  newInput.value = disciplina;
  newTd.appendChild(newInput);
  newInput.name = "disciplina_" + linha;

  newTd = document.createElement("td");
  var newButton = document.createElement("a");
  newButton.id = "button_" + linha;
  newButton.id = "button_" + linha;

  newButton.classList.add("button");
  newTd.classList.add("row-table");
  newButton.classList.add("button-remove");
  newButton.classList.add("botao--container");
  newButton.classList.add("botao--terciario");
  newTd.appendChild(newButton);
  newRow.appendChild(newTd);
  linha = linha +1;

  newButton.addEventListener ("click", function(event, outro) {
    var l = event.target.id.substring (7);
    var element = document.getElementById ("row_" + l);
    element.parentNode.removeChild(element);
    var rows = document.getElementsByClassName("removable-rows");
    for (var i = 0; i < rows.length; i++) {
        rows [i].getElementsByTagName("a") [0].id = "button_" + i;
        rows [i].id = "row_" + i;
    }
    linha = rows.length;
  });
}

function readURL(input) {
    
    if (input.files && input.files [0]) {
        var reader = new FileReader ();
        reader.onload = function (e) {
        $ ('#img_prev')
            .attr ('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
    else{   
        $ ('#img_prev')
            .attr ('src', "assets/img/visual/default.svg");
    }
}

function voltarPrincipal () {
    window.location.href = "index.php";
}
/** Alterar texto caminho imagem */
var imgInput = document.querySelector('.input--img');
var imgInputText = document.querySelector('.input--img-text');
imgInputTextContent = imgInputText.textContent;

imgInput.addEventListener('change', function (e) {
	var value = e.target.value.length > 0 ? e.target.value : imgInputTextContent;
	imgInputText.textContent = value.replace('C:\\fakepath\\', '');
});

/** Alterar texto caminho arquivo */

var fileInput = document.querySelector('.input--file');
var fileInputText = document.querySelector('.input--file-text');
fileInputTextContent = fileInputText.textContent;

fileInput.addEventListener('change', function (e) {
	var value = e.target.value.length > 0 ? e.target.value : fileInputTextContent;
	fileInputText.textContent = value.replace('C:\\fakepath\\', '');
});

function enviarFormulario () {
    var imgVisual = document.getElementById("imagem_visual");
    var imgTatil = document.getElementById("imagem_tatil");
    var titulo = document.getElementById("titulo");
    var pChave = document.getElementById("p_chave"); 

    if (imgVisual.value == ""){
        alert ("Adicione uma imagem visual");
        return;
    }
    if (imgTatil.value == ""){
        alert ("Adicione o arquivo tatil");
        return;
    }

    if (titulo.value == ""){
        alert ("Adicione um titulo");
        return;
    }
    if (pChave.value == ""){
        alert ("Adicione uma palavra chave");
        return;
    }
    if (linha == 0) {
        alert ("Adicione pelo menos uma disciplina");
        return;
    }
    var form = document.getElementById ("form-adiciona");
    form.submit ();
}