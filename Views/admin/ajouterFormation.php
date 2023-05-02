<form method="post">
    <fieldset id="part1">Informations sur la formation
        <label for="type">Catégorie de formation :
            <select name="type">
                <option disabled selected>Choisir un type de formation</option>
                <?php foreach($infosFormation['Types'] as $types):?>
                    <option value="<?= $types->id_type_formation?>"><?= $types->designation_type_formation ;?></option>
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

        <label for="acronyme"> Acronyme de formation :
            <input name="acronyme" type="text" placeholder="Exemple : CDA">
        </label>

        <label for="description"> Description
            <textarea name="description" style="resize : none;"></textarea>
        </label>

        <label for="offre"> Numéro d'offre :
            <input name="offre" type="text" placeholder="Exemple : offre 1234">
        </label>

        <label for="date-debut-formation"> Date de début :
            <input name="date-debut-formation" type="date">
        </label>
        <label for="date-fin-formation"> Date de fin :
            <input name="date-fin-formation" type="date">
        </label>

        <label for="ville"> Ville :
            <select name="ville">
                <option disabled selected>Choisir une ville</option>
                <?php foreach($infosFormation['Villes'] as $villes):?>
                    <option value="<?= $villes->id_ville;?>"><?= $villes->nom_ville ;?></option>
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
                    <option value="<?= $formateurs['id_formateur'];?>"><?= $formateurs['nom_formateur'] . ' ' . $formateurs['prenom_formateur'];?></option>
                <?php endforeach;?>
            </select>
        </label>

        <div>
            <button type="button" class="add-date-fields" data="intervention">Add new</button>
        </div>
    </fieldset>

    <input type="submit">
</form>

<?php 

;?>