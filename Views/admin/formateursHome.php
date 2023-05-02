<h1>Liste des formateurs</h1>
<?php 
$iterations = 1;
foreach($infosFormateur as $formateur):
    if($iterations == 1){
        $iterations++;
        continue;
    }
?>

<?php var_dump($formateur) ;?>
<h3>Formateur : <?= $formateur->nom_formateur . " " . $formateur->prenom_formateur ;?></h3>
<p>GRN de rattachement : <?= $formateur->numero_grn ;?></p>
<p>Ville de rattachement : <?= $formateur->nom_ville ;?></p>
<p>Contrat : <?= $formateur->type_contrat_formateur ;?></p>
<p>Date de début du contrat : <?= $formateur->date_debut_contrat ;?></p>
<?php if($formateur->type_contrat_formateur != "CDI") :?>
    <p>Date de fin du contrat : <?= $formateur->date_fin_contrat ;?></p>
<?php endif;?>

<a href="/planning/public/admin/modifierFormateur?id=<?= $iterations ;?>">Modifier les informations du formateur</a>
<a href="#">Supprimer le formateur</a>

<?php 
$iterations++;
endforeach;
?>