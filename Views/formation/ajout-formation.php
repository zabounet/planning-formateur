<form method="post">
    <fieldset id="part1">Informations sur la formation

        <select name="grn">
            <option disabled selected>Choisir un GRN</option>
            <?php foreach($infosFormation['GRNS'] as $grn):?>
                <option value="<?= $grn->numero_grn;?>"><?= $grn->numero_grn . ' - ' . $grn->nom_grn;?></option>
            <?php endforeach;?>
        </select>

        <label for="offre"> Nom de l'offre :
            <input name="offre" type="text" placeholder="Exemple : AIS offre 1234">
        </label>

        <label for="date-debut-formation"> Date de début :
            <input name="date-debut-formation" type="date">
        </label>
        <label for="date-fin-formation"> Date de fin :
            <input name="date-fin-formation" type="date">
        </label>

        <select name="ville">
            <option disabled selected>Choisir une ville</option>
            <?php foreach($infosFormation['Villes'] as $villes):?>
                <option value="<?= $villes->nom_ville;?>"><?= $villes->nom_ville ;?></option>
            <?php endforeach;?>
        </select>

    </fieldset>

    <fieldset id="part2">Répartition des périodes
    <div id="date-fields-container">
        <div class="date-fields">
            <label for="date-debut-ran"> Date de début ran :
                <input name="date-debut-ran" type="date">
            </label>
            <label for="date-fin-ran"> Date de fin ran :
                <input name="date-fin-ran" type="date">
            </label>
        </div>
        <button type="button" class="add-date-fields" data="ran">Add new</button>
        
    </div>
        <div class="date-fields">
            <label for="date-debut-pae"> Date de début pae :
                <input name="date-debut-pae" type="date">
            </label>
            <label for="date-fin-pae"> Date de fin pae :
                <input name="date-fin-pae" type="date">
            </label>
        </div>
        <button type="button" class="add-date-fields" data="pae">Add new</button>

        <div class="date-fields">
            <label for="date-debut-centre"> Date de début centre :
                <input name="date-debut-centre" type="date">
            </label>
            <label for="date-fin-centre"> Date de fin centre :
                <input name="date-fin-centre" type="date">
            </label>
        </div>
        <button type="button" class="add-date-fields" data="centre">Add new</button>

        <div class="date-fields">
            <label for="date-debut-certif"> Date de début certification :
                <input name="date-debut-certification" type="date">
            </label>
            <label for="date-fin-certif"> Date de fin certification :
                <input name="date-fin-certification" type="date">
            </label>
        </div>
        <button type="button" class="add-date-fields" data="certification">Add new</button>

    </fieldset>

    <select name="type">
        <option disabled selected>Choisir un type de formation</option>
        <?php foreach($infosFormation['Types'] as $types):?>
            <option value="<?= $types->designation_type_formation?>"><?= $types->designation_type_formation ;?></option>
        <?php endforeach;?>
    </select>

    <label for="description"> Description
        <textarea name="description"></textarea>
    

    <select name="formateur">
        <option disabled selected>Choisir un formateur</option>
        <?php foreach($infosFormation['Formateurs'] as $formateurs):?>
            <option value="<?= $formateurs->nom_formateur . $formateurs->prenom_formateur;?>"><?= $formateurs->nom_formateur . ' ' . $formateurs->prenom_formateur;?></option>
        <?php endforeach;?>
    </select>

    <input type="submit" name="submit">
</form>

<?php // if(isset($_POST["grn"], ($_POST['formateur']), ($_POST['date']), ($_POST['ville']), $_POST['type']) && !empty($_POST['date'])) {var_dump($_POST);}
//var_dump($_POST);
$id = $_POST["offre"] . " : " . $_POST["date-debut-formation"] . " - " . $_POST["date-fin-formation"] . $_POST["ville"];
echo "<h1>" . $id . "</h1>";
;?>