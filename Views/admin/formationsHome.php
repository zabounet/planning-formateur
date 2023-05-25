<?php $link = "Formation home"; ?>
<form action="" method="post">
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
$iterations = 1;
foreach ($infosFormation as $formation) {
    $disassemble = explode(' ', $formation->nom_formation);
    $reassemble = $disassemble[1] . ' ' . $disassemble[2] . ' ' . $disassemble[3];

    if (!empty($formation->candidats_formation)) {
        $placesCandidats = explode('/', $formation->candidats_formation);
        $places = $placesCandidats[0];
        $candidats = $placesCandidats[1];
    } else {
        $places = $candidats = "Indéfini";
    }

?>
    <h2>Nom de la formation : <?= $reassemble; ?></h2>
    <h3>GRN : <?= $formation->numero_grn; ?></h3>

    <p>Type de formation : <?= $formation->designation_type_formation; ?></p>
    <p>Description de la formation : <?= $formation->description_formation; ?></p>
    <p>Rattachée au centre de <?= $formation->nom_ville; ?></p>
    <p>Nombre de places totales : <?= $places; ?></p>
    <p>Nombre de candidats placés : <?= $candidats; ?></p>
    <p>Début le : <span style="font-weight: 800;"><?php $debut = new DateTime($formation->date_debut_formation);
                                                    echo $debut->format('d-m-Y'); ?></span></p>
    <p>Fin le : <span style="font-weight: 800;"><?php $fin = new DateTime($formation->date_fin_formation);
                                                echo $fin->format('d-m-Y'); ?></span></p>
    <p>Formateur référent : <?= $formation->nom_formateur . " " . $formation->prenom_formateur; ?></p>

    <a href="/planning/public/index.php?p=admin/modifierFormation&?id=<?= $formation->id_formation; ?>">Modifier les informations de la formation</a>
    <form action="" method="post">
        <input class="delete" type="button" value="Supprimer">
        <div class="confirm"> 
            <h4>Êtes-vous sûr ?</h4>
            <input type="submit" name="Delete" value="Confirmer">
        </div>
        <input type="hidden" name="ID" value="<?= $formation->id_formation; ?>">
    </form>
    <hr>
<?php
    $iterations++;
}
if (isset($search) && empty($infosFormateur)) {
    echo "<h2 style='text-align: center;'>Aucun résultat pour '$search'.</h2>";
}; ?>