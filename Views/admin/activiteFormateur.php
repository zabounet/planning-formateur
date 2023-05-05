<?php $link = "Activité des formateurs"; ?>

<form method="post">
  <input type="date" name="date_debut" id="date_debut">
  <input type="date" name="date_fin" id="date_fin">
  <label for="referent-formateur"> Formateur :
    <?php
      $iterations = 0;
      foreach ($infosFormateur['Formateurs'] as $formateurs){
        if($iterations == 0 || $iterations == 1){
          $iterations++;
          continue;
        };
      ?>
        <label for="formateur"><?= $formateurs->nom_formateur . ' ' . $formateurs->prenom_formateur; ?></label>
        <input type="checkbox" name="formateur[]" value="<?= $formateurs->id_formateur; ?>" />
    <?php 
      $iterations++;
      }; 
    ?>
  </label>
  <input type="submit" value="envoyer" name="valider">
</form>

<h3>Légende : </h3>
<div style="width: 300px; height : 100px; display: flex;">      
  <div style="display: flex; align-items: center; justify-content: center; width: 50%; height : 100px; background-color: var(--greenCell)">Actif</div>
  <div style="display: flex; align-items: center; justify-content: center; width: 50%; height : 100px; background-color: var(--emptyCell)">Libre</div>
  <div style="display: flex; align-items: center; justify-content: center; width: 50%; height : 100px; background-color: var(--weekendCell)">Week-ends</div>
</div>
<?= $html; ?>