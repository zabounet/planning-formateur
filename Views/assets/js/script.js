addEventListener('DOMContentLoaded', function(){

    let modif = document.getElementById('modifier_nom_formateur');
    let nom = document.getElementsByClassName('nomProfil');
    console.log('yes');

    Array.from(nom).forEach(function(noms){
        modif.addEventListener('click', function(){
            sessionNom = noms.childNodes.getAttribute("value");
            console.log(sessionNom);
            noms.innerHTML = `<input type="text" name="nom" value="<?= ${sessionNom} ;?>" />`;   
        })
    })
})