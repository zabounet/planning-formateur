<h1>Liste des formations</h1>
<?php 
$iterations = 1;
foreach($infosFormation as $formation) {
    $disassemble = explode(' ' , $formation->nom_formation); 
    $reassemble = $disassemble[1] . ' ' . $disassemble[2] . ' ' . $disassemble[3];
?>
    <h2>Nom de la formation : <?= $reassemble;?></h2>
    <h3>GRN raffilié : <?= $formation->numero_grn ;?></h3>

    <p>Type de formation : <?= $formation->designation_type_formation ;?></p>
    <p>Description de la formation : <?= $formation->description_formation ;?></p>
    <p>Se déroule dans la ville de <?= $formation->nom_ville;?></p>
    <p>Début le : <span style="font-weight: 800;"><?= $formation->date_debut_formation ;?></span></p>
    <p>Fin le : <span style="font-weight: 800;"><?= $formation->date_fin_formation ;?></span></p>
    <p>Formateur référent : <?= $formation->nom_formateur . " " . $formation->prenom_formateur;?></p>
    
    <a href="/planning/public/admin/modifierFormation?id=<?=$formation->id_formation;?>">Modifier les informations de la formation</a>
    <a href="#">Supprimer la formation</a>
    <hr>
<?php 
    $iterations++;
}
;?>