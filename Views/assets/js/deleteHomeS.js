// Attendre que l'ensemble des éléments soient chargés avant d'éxecuter le code à l'intérieur
// Ceci afin d'éviter les problèmes de "variable indéfinie" car le fichier est chargé dans le header
document.addEventListener('DOMContentLoaded', function () {
    let confirm = document.querySelectorAll('.confirm');
    let del = document.querySelectorAll('.delete');

    // Il y a toujours le même nombre d'élements "del" que "confirm", donc ici n'importe lequel des deux conviendraient.
    for (let i = 0; i < del.length; i++) {

        // Passage de chacun des élément "confirm" en display none par défaut
        confirm[i].style.display = "none";

        // Création d'un eventListener sur les éléments "del". Afin d'afficher l'élément confirm correspondant.
        del[i].addEventListener("click", () => {
            if (confirm[i].style.display === "none")
                confirm[i].style.display = "block";
            else
                confirm[i].style.display = "none";
        });
    };
})