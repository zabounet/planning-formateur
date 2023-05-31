<?php $link = "Formateur home"; ?>

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
    echo "<button style='text-align: center;'><a href='/planning/public/index.php?p=admin/formateursHome'>Afficher tout</a></button>";
} ?>


<h1>Liste des formateurs</h1>
<?php
foreach ($infosFormateur as $formateur) :
    if ($formateur->id_formateur == 1 || $formateur->id_formateur == 2) {
        continue;
    }
?>
    <div class="content-container">

        <h2>Formateur : <?= $formateur->nom_formateur . " " . $formateur->prenom_formateur; ?></h2>
        <p>GRN : <span><?= $formateur->numero_grn; ?><span></p>
        <p>Rattaché au centre de : <span><?= $formateur->nom_ville; ?><span></p>
        <p>Contrat : <span><?= $formateur->type_contrat_formateur; ?><span></p>
        <p>Date de début du contrat : <span><?php $debut = new DateTime($formateur->date_debut_contrat);
                                            echo $debut->format('d-m-Y'); ?><span></p>
        <?php if ($formateur->type_contrat_formateur != "CDI") : ?>
            <p>Date de fin du contrat : <span><?php $fin = new DateTime($formateur->date_fin_contrat);
                                                echo $fin->format('d-m-Y'); ?><span></p>
        <?php endif; ?>

        <div class="btns-box">
            <a href="/planning/public/index.php?p=admin/modifierFormateur&?id=<?= $formateur->id_formateur; ?>">Modifier les informations du formateur</a>
            <form action="" method="post">
                <input class="delete" type="button" value="Supprimer">
                <div class="confirm">
                    <h4 class="confirm-text">Êtes-vous sûr(e) ?</h4>
                    <input type="submit" name="Delete" value="Confirmer">
                </div>
                <input type="hidden" name="ID" value="<?= $formateur->id_formateur; ?>">
            </form>
        </div>
    </div>
    <hr>

<?php
endforeach;

if (isset($search) && empty($infosFormateur)) {
    echo "<h2 style='text-align: center;'>Aucun résultat pour '$search'.</h2>";
}
?>