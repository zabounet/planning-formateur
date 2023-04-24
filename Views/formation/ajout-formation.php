<form method="post">
    <fieldset id="part1">Informations sur la formation
        <label for="type">Catégorie de formation :
            <select name="type">
                <option disabled selected>Choisir un type de formation</option>
                <?php foreach($infosFormation['Types'] as $types):?>
                    <option value="<?= $types->designation_type_formation?>"><?= $types->designation_type_formation ;?></option>
                <?php endforeach;?>
            </select>
        </label>

        <label for="grn"> GRN :
            <select name="grn">
                <option disabled selected>Choisir un GRN</option>
                <?php foreach($infosFormation['GRNS'] as $grn):?>
                    <option value="<?= $grn->numero_grn;?>"><?= $grn->numero_grn . ' - ' . $grn->nom_grn;?></option>
                <?php endforeach;?>
            </select>
        </label>

        <label for="offre"> Nom de l'offre :
            <input name="offre" type="text" placeholder="Exemple : AIS offre 1234">
        </label>

        <label for="description"> Description
            <textarea name="description" style="resize : none;"></textarea>

        <label for="date-debut-formation"> Date de début :
            <input name="date-debut-formation" type="date" min="<?= date('Y-m-d') ;?>">
        </label>
        <label for="date-fin-formation"> Date de fin :
            <input name="date-fin-formation" type="date" min="<?= date('Y-m-d') ;?>">
        </label>

        <label for="ville"> Ville :
            <select name="ville">
                <option disabled selected>Choisir une ville</option>
                <?php foreach($infosFormation['Villes'] as $villes):?>
                    <option value="<?= $villes->nom_ville;?>"><?= $villes->nom_ville ;?></option>
                <?php endforeach;?>
            </select>
        </label>
    </fieldset>

    <fieldset id="part2">Répartition des périodes
        <div>
            <button type="button" class="add-date-fields" data="ran">Add new</button>
        </div>

        <div>
            <button type="button" class="add-date-fields" data="entreprise">Add new</button>
        </div>

        <div>
            <button type="button" class="add-date-fields" data="centre">Add new</button>
        </div>

        <div>
            <button type="button" class="add-date-fields" data="certification">Add new</button>
        </div>
    </fieldset>

    <fieldset id="part3"> Ajouter des interruptions
        <button type="button" class="add-date-fields" data="interruption">Ajouter une nouvelle interruption</button>
    </fieldset>

    <fieldset id="part4"> Répartition des formateurs
        
        <label for="referent-formateur"> Formateur référent : 
            <select name="referent-formateur">
                <option disabled selected>Choisir un formateur</option>
                <?php foreach($infosFormation['Formateurs'] as $formateurs):?>
                    <option value="<?= $formateurs['nom_formateur'] . $formateurs['prenom_formateur'];?>"><?= $formateurs['nom_formateur'] . ' ' . $formateurs['prenom_formateur'];?></option>
                <?php endforeach;?>
            </select>
        </label>

        <div>
            <button type="button" class="add-date-fields" data="intervention">Add new</button>
        </div>
    </fieldset>

    <input type="submit" name="submit">
</form>

<?php 
// $id = $_POST["grn"] . " " . $_POST["offre"] . " : " . $_POST["date-debut-formation"] . " - " . $_POST["date-fin-formation"] . ' ' . $_POST["ville"];
// echo "<h1>" . $id . "</h1>";
// var_dump($_POST);
// $total = count($_POST['date-debut-pae']);
// for($i = 0; $i < $total; $i++){
//     $dateDebutPae = $_POST['date-debut-pae'][$i];
//     $dateFinPae = $_POST['date-fin-pae'][$i];

//     echo $dateDebutPae;
//     echo "<br>";
//     echo $dateFinPae;
//     echo "<br><br>";

// }
;?>