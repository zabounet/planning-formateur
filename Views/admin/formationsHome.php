<?php $link = "Formation home"; ?>
<form class="search-form" method="post">
    <div class="search-wrapper">
        <input class="search-input" type="text" placeholder="Search..." name="search_d" value="<?php if (isset($search)) {
                                                                                                    echo $search;
                                                                                                }  ?>">
        <button>
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-search" viewbox="0 0 24 24">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="M23 23l-4.35-4.35"></path>
            </svg>
        </button>
    </div>
</form>
<?php if (!empty($search)) {
    echo "<button style='text-align: center;'><a href='/planning/public/index.php?p=admin/formationsHome'>Afficher tout</a></button>";
} ?>
<h1>Liste des formations</h1>


<?php
// Boucle sur l'ensemble des formations récupérées
foreach ($infosFormation as $formation) {
    // explose le nom de la formation afin d'en retirer un nom plus court.
    $disassemble = explode(' ', $formation->nom_formation);
    $reassemble = $disassemble[1] . ' ' . $disassemble[2] . ' ' . $disassemble[3];

    // Si les informations relatives au candidats ont été rentrées, 
    // explose l'informations pour en retirer les places totales et les candidats déjà inscrits.
    // Sinon, met la valeur sur indéfini.
    if (!empty($formation->candidats_formation)) {
        $placesCandidats = explode('/', $formation->candidats_formation);
        $places = $placesCandidats[0];
        $candidats = $placesCandidats[1];
    } else {
        $places = $candidats = "Indéfini";
    }

?>
    <div class="content-container">
        <!-- Déchargement des données -->
        <h2>Nom de la formation : <?= $reassemble; ?></h2>
        <h3>GRN : <span><?= $formation->numero_grn; ?><span></h3>

        <p>Type de formation : <span><?= $formation->designation_type_formation; ?></span></p>
        <p>Description de la formation : <span><?= $formation->description_formation; ?></span></p>
        <p>Rattachée au centre de <span><?= $formation->nom_ville; ?></span></p>
        <p>Nombre de places totales : <span><?= $places; ?></span></p>
        <p>Nombre de candidats placés : <span><?= $candidats; ?></span></p>
        <!-- Conversion des données relatives au dates en objet DateTime afin de pouvoir les formater à la française -->
        <p>Début le : <span><?php $debut = new DateTime($formation->date_debut_formation);
                            echo $debut->format('d-m-Y'); ?></span></p>
        <p>Fin le : <span><?php $fin = new DateTime($formation->date_fin_formation);
                            echo $fin->format('d-m-Y'); ?></span></p>
        <p>Formateur référent : <span><?= $formation->nom_formateur . " " . $formation->prenom_formateur; ?></span></p>

        <div class="btns-box">
            <a href="/planning/public/index.php?p=admin/modifierFormation&?id=<?= $formation->id_formation; ?>">Modifier les informations de la formation</a>
            <form action="" method="post">
                <input class="delete" type="button" value="Supprimer">
                <div class="confirm">
                    <h4 class="confirm-text">Êtes-vous sûr(e) ?</h4>
                    <input type="submit" name="Delete" value="Confirmer">
                </div>
                <input type="hidden" name="ID" value="<?= $formation->id_formation; ?>">
            </form>
        </div>
    </div>
    <hr>
<?php
}
if (isset($search) && empty($infosFormateur)) {
    echo "<h2 style='text-align: center;'>Aucun résultat pour '$search'.</h2>";
}; ?>