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
}

function enviarFormulario () {
    if (linha == 0) {
        alert ("Adicione pelo menos uma disciplina");
        return;
    }
    var form = document.getElementById ("form-adiciona");
    form.submit ();
}

function voltarPrincipal () {
    window.location.href = "index.php";
}

var fileInput = document.querySelector('.input--file');
var fileInputText = document.querySelector('.input--file-text');
fileInputTextContent = fileInputText.textContent;

fileInput.addEventListener('change', function (e) {
	var value = e.target.value.length > 0 ? e.target.value : fileInputTextContent;
	fileInputText.textContent = value.replace('C:\\fakepath\\', '');
});
