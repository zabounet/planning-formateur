<table>
  <thead style="width: 100%; border-collapse: collapse;">
  <?php $annes = ['2023','2024'] ?>
  <?php $moiss = ['jan','feb','mars','avril','mais','juin','jul','aoute','sept','oct','nov','dec'] ?>
        
        <tr>
            <?php foreach ($annes as $anne ) {
                echo "<td colspan='356'>$anne</td>";
            } ?>
        </tr>
    <tr>
      <!-- reapet les mois -->
      <?php foreach ($moiss as $mois ) {
                echo "<td colspan='31'>$mois</td>";
            } ?>
    </tr>
    <tr>
      <th>Lun</th>
      <th>Mar</th>
      <th>Mer</th>
      <th>Jeu</th>
      <th>Ven</th>
      <th>Sam</th>
      <th>Dim</th>
      <th>Lun</th>
      <th>Mar</th>
      <th>Mer</th>
      <th>Jeu</th>
      <th>Ven</th>
      <th>Sam</th>
      <th>Dim</th>
      <th>Lun</th>
      <th>Mar</th>
      <th>Mer</th>
      <th>Jeu</th>
      <th>Ven</th>
      <th>Sam</th>
      <th>Dim</th>
      <th>Lun</th>
      <th>Mar</th>
      <th>Mer</th>
      <th>Jeu</th>
      <th>Ven</th>
      <th>Sam</th>
      <th>Dim</th>
      <th>Lun</th>
      <th>Mar</th>
      <th>Mer</th>
      <th>Jeu</th>
      <th>Ven</th>
      <th>Sam</th>
      <th>Dim</th>
      <th>Lun</th>
      <th>Mar</th>
      <th>Mer</th>
      <th>Jeu</th>
      <th>Ven</th>
      <th>Sam</th>
      <th>Dim</th>
      <th>Lun</th>
      <th>Mar</th>
      <th>Mer</th>
      <th>Jeu</th>
      <th>Ven</th>
      <th>Sam</th>
      <th>Dim</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <!-- reapet les jours -->
      <?php for($i = 1; $i <= 365; $i++) {
         ?>
        <td><?= $i ?></td>
      <?php } ?>

    </tr>
   
  </tbody>
</table>
