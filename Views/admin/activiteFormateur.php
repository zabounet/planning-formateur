<?php $link = "Activité des formateurs" ;?>

<form  method="post">
  <input type="date" name="date_debut" id="date_debut">
  <input type="date" name="date_fin" id="date_fin">
  <label for="referent-formateur"> Formateur : 
          <?php foreach($infosFormateur['Formateurs'] as $formateurs):?>
            <label for="formateur"><?= $formateurs->nom_formateur . ' ' . $formateurs->prenom_formateur;?></label>
            <input type="checkbox" name="formateur[]" value="<?= $formateurs->id_formateur;?>" />
          <?php endforeach;?>
  </label>
  <input type="submit" value="envoyer" name="valider">
</form>

<?= $html;?>