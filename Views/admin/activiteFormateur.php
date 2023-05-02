<?php $link = 'Activité des formateurs' ;?>

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


<table>
<tbody>
  <?php 
    $annees = array('2023','2024');
    // Obtenir les jours de la semaine
    $jours_semaine = array('Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim');
    // Obtenir les mois de l'année
    $mois_annee = array('jan', 'fév', 'mar', 'avr', 'mai', 'jun', 'jul', 'aoû', 'sep', 'oct', 'nov', 'déc');
    // Obtenir le nombre de jours dans l'année
    $nb_jours_annee = date('z', strtotime('December 31'));
  ?>
    <tr>
      <th rowspan="4">afpa</th>
      <?php 
        // Boucler à travers les années
        for($annee = date('Y'); $annee <= date('Y')+1; $annee++) { ?>
          <th colspan="<?= $nb_jours_annee+1 ?>"> <?= $annee ?></th>
      <?php } ?>
    </tr>
    <tr>
    <?php foreach ($mois_annee as $mois ) {
      $nb_jours = cal_days_in_month(CAL_GREGORIAN, array_search($mois, $mois_annee) + 1, $annees[0]);
      echo "<th colspan='$nb_jours'>$mois</th>";
    } ?>
    </tr>
    <tr>
      <?php 
        // Répéter les jours de la semaine jusqu'à la fin de l'année
        for($i = 0; $i <= $nb_jours_annee; $i++) {
          echo "<th>" . $jours_semaine[$i % 7] . "</th>";
        }
      ?>
    </tr>

  
 
  <?php foreach ($mois_annee as $mois ) {
    $nb_jours = cal_days_in_month(CAL_GREGORIAN, array_search($mois, $mois_annee) + 1, $annees[0]);
    
    for($i = 1; $i <= $nb_jours; $i++) {
      echo "<th>$i</th>";
    }
  } ?>
    <tr>
      <th>sandy</th>
    </tr>
  </tbody>
</table>
