//por enquanto o editar não esta ativado, ou seja está h i d d e n
var perfil_edit = document.querySelector("#perfil-edit"); 
var perfil_noedit = document.querySelector("#perfil-noedit"); 

var edit = document.querySelector("#btn-edit"); 
var cancel = document.querySelector("#btn-cancel");  

edit.addEventListener('click',() =>{
    perfil_noedit.classList.add("hidden");
    perfil_edit.classList.remove("hidden");

})
cancel.addEventListener('click',() =>{
    perfil_edit.classList.add("hidden");
    perfil_noedit.classList.remove("hidden");
    
})


/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */


  
function userPicture(input) {
    if (input.files && input.files [0]) {
        var reader = new FileReader ();
        reader.onload = function (e) {
        $ ('#js-file-uploader')
            .attr ('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}