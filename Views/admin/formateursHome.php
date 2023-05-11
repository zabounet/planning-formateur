<?php $link = "Formateur home" ;?>

<form action="" method="post">
    <div class="search-wrapper">
        <input class="search-input" type="text" placeholder="Search..." name="search_d" value="<?php if(isset($search)){echo $search;}  ?>">
        <button>
            <svg width="20" height="20" fill="none" 
                stroke="currentColor" stroke-linecap="round" 
                stroke-linejoin="round" stroke-width="2" class="feather feather-search"
                viewbox="0 0 24 24">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="M23 23l-4.35-4.35"></path>
            </svg>
        </button>
    </div>
</form> 
<?php if(!empty($search)){echo "<button style='text-align: center;'><a href='/planning/public/admin/formateursHome'>Afficher tout</a></button>";} ?>


<h1>Liste des formateurs</h1>
<?php 
foreach($infosFormateur as $formateur):
    if($formateur->id_formateur == 1 || $formateur->id_formateur == 2){
        continue;
    }
?>
<h3>Formateur : <?= $formateur->nom_formateur . " " . $formateur->prenom_formateur ;?></h3>
<p>GRN de rattachement : <?= $formateur->numero_grn ;?></p>
<p>Ville de rattachement : <?= $formateur->nom_ville ;?></p>
<p>Contrat : <?= $formateur->type_contrat_formateur ;?></p>
<p>Date de début du contrat : <?= $formateur->date_debut_contrat ;?></p>
<?php if($formateur->type_contrat_formateur != "CDI") :?>
    <p>Date de fin du contrat : <?= $formateur->date_fin_contrat ;?></p>
<?php endif;?>

<a href="/planning/public/admin/modifierFormateur?id=<?= $formateur->id_formateur ;?>">Modifier les informations du formateur</a>
<a href="#">Supprimer le formateur</a>

<hr>

<?php 
endforeach;

if(isset($search) && empty($infosFormateur)){
    echo "<h2 style='text-align: center;'>Aucun résultat pour '$search'.</h2>";
}
?>