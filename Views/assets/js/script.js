addEventListener('DOMContentLoaded', function(){

    let modif = document.getElementById('modifier_nom_formateur');
        
    modif.addEventListener('submit', function(e){
        e.preventDefault;
        // document.getElementById('nomProfil').innerHTML = `<input type="text" name="nom" value="<?= $_SESSION['formateur']['nom'] ;?>" />`;   
    })
})