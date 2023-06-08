<?php $link = "Ajouter une formation"; ?>

<form method="post">
    <div class="title-container">
        <h1 class="head-title"><?= $link; ?></h1>
    </div>

    <fieldset id="part1">
        <div class="second-title-container">
            <legend>Informations sur la formation</legend>
        </div>
        <hr>

        <div class="part1-sect">
            <label for="type">Catégorie :
                <select name="type" id="type">
                    <option disabled selected>Choisir un type de formation</option>
                    <?php foreach ($infosFormation['Types'] as $types) : ?>
                        <option value="<?= $types->id_type_formation ?>"><?= $types->designation_type_formation; ?></option>
                    <?php endforeach; ?>
                </select></label>

            <label for="grn"> GRN : 
                <select name="grn" id="grn">
                    <option disabled selected>Choisir un GRN</option>
                    <?php foreach ($infosFormation['GRNS'] as $grn) : ?>
                        <option value="<?= $grn->numero_grn; ?>"><?= $grn->numero_grn . ' - ' . $grn->nom_grn; ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label for="ville"> Ville : 
                <select name="ville" id="ville">
                    <option disabled selected>Choisir une ville</option>
                    <?php foreach ($infosFormation['Villes'] as $villes) : ?>
                        <option value="<?= $villes->id_ville; ?>"><?= $villes->nom_ville; ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="part1-sect">
            <label for="acronyme"> Acronyme : 
                <input id="acronyme" name="acronyme" type="text" placeholder="Exemple : CDA">
            </label>

            <label for="description"> Description : 
                <textarea autocomplete="on" id="description" name="description" placeholder="Exemple: Concepteur Developpeur d'Applications" style="resize : none;"></textarea>
            </label>

            <label for="offre"> Offre : 
                <input id="offre" name="offre" type="text" placeholder="Exemple : offre 1234">
            </label>
        </div>
        <div class="part1-sect">
            <label for="candidats"> Places / Candidats :
                <input type="text" name="candidats" placeholder="Nb places / Nb candidats">
            </label>
            <label for="date-debut-formation"> Date de début : 
                <input id="date-debut" name="date-debut-formation" type="date">
            </label>
            <label for="date-fin-formation"> Date de fin : 
                <input id="date-fin" name="date-fin-formation" type="date">
            </label>
        </div>
    </fieldset>

    <fieldset id="part2">
        <div class="second-title-container">
            <legend>Répartition des périodes</legend>
        </div>
        <hr>

        <div class="part2-container">
            <div class="col1">
                <h3>Périodes de RAN</h3>
                <div class="date-container">
                    <button type="button" class="add-date-fields" data="ran">+</button>
                </div>

                <h3>Périodes d'activité en entreprise <span class="legend">/!\ Ne pas remplir si alternance /!\</span></h3>
                <div class="date-container">
                    <button type="button" class="add-date-fields" data="entreprise"><span>+</span></button>
                </div>
            </div>

            <div class="col2">
                <h3>Périodes d'activité en centre  <span class="legend">/!\ Ne pas remplir sauf si alternance /!\</span></h3>
                <div class="date-container">
                    
                    <button type="button" class="add-date-fields" data="centre"><span>+</span></button>
                </div>

                <h3>Périodes de certification</h3>
                <div class="date-container">
                    <button type="button" class="add-date-fields" data="certification"><span>+</span></button>
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset id="part3">
        <div class="second-title-container">
            <legend>Répartition des périodes</legend>
        </div>
        <hr>

        <div class="part3-container">
            <div class="checkbox-choice">
                <div class="separate">
                    <label for="interruption">Aucune interruption</label>
                    <input type="radio" name="interruption" value="noInterruptions">
                </div>
                <div class="separate">
                    <label for="interruption">Ajouter une interruption</label>
                    <input type="radio" name="interruption" value="addInterruptions">
                </div>
            </div>
            <div class="interruption-dates">
                <h3>Période d'interruption <span class="legend">*</span></h3>
                <button type="button" class="add-date-fields" data="interruption">+</button>
            </div>
        </div>
    </fieldset>

    <fieldset id="part4">
        <div class="second-title-container">
            <legend>Répartition des formateurs</legend>
        </div>
        <hr>

        <label for="referent-formateur"> Formateur référent :
            <select name="referent-formateur">
                <option disabled selected>Choisir un formateur</option>
                <?php foreach ($infosFormation['Formateurs'] as $formateurs) : ?>
                    <?php if ($formateurs->id_formateur == 1 || $formateurs->id_formateur == 2) {
                        continue;
                    }; ?>
                    <option value="<?= $formateurs->id_formateur; ?>"><?= $formateurs->nom_formateur . ' ' . $formateurs->prenom_formateur; ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <div class="intervention-container">
            <h3 class="addbtn-title">Ajouter une intervention</h3>
            <button type="button" class="addbtn add-date-fields" data="intervention">+</button>
        </div>
    </fieldset>
    <div class="indicator">
        <div id="step1"></div>
        <div id="step2"></div>
        <div id="step3"></div>
        <div id="step4"></div>
    </div>
    <input id="nextButton" class="no-need" type="button" value="Page suivante">
    <input id="submitButton" class="no-show" type="submit" value="Valider">
    <span class="legend">* champs obligatoires</span>
</form>