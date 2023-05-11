<?php $link = "Formation home" ;?>
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
<?php if(!empty($search)){echo "<button style='text-align: center;'><a href='/planning/public/admin/formationsHome'>Afficher tout</a></button>";} ?>
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
if(isset($search) && empty($infosFormateur)){
    echo "<h2 style='text-align: center;'>Aucun résultat pour '$search'.</h2>";
}
;?>