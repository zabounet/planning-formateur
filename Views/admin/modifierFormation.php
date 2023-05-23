<?php
// Explose chaque mots du nom dans un array afin de ne récupèrer que les informations nécessaires
$disassemble = explode(" ", $infosCurrent['nom_formation']);
$reassemble = $disassemble[2] . " " . $disassemble[3] . " ";

$link = "Modifier la formation " . $infosCurrent['acronyme_formation'];
?>

<form method="post">
    <div class="title-container">
        <h1 class="head-title">Modifier la formation <?= $infosCurrent['acronyme_formation'] . " " . $reassemble ?></h1>
    </div>

    <fieldset id="part1">
        <div class="second-title-container">
            <legend>Informations sur la formation</legend>
        </div>
        <hr>

        <div class="part1-sect">
            <label for="type">Catégorie :
                <select name="type" id="type">
                    <option disabled>Choisir un type de formation</option>

                    <?php foreach ($infosFormation['Types'] as $types) : ?>

                        <?php if ($types->id_type_formation === $infosCurrent['id_type_formation']) : ?>
                            <option selected value="<?= $types->id_type_formation ?>"><?= $types->designation_type_formation; ?></option>
                        <?php else : ?>
                            <option value="<?= $types->id_type_formation ?>"><?= $types->designation_type_formation; ?></option>
                        <?php endif; ?>

                    <?php endforeach; ?>

                </select>
            </label>

            <label for="grn"> GRN :
                <select name="grn" id="grn">
                    <option disabled>Choisir un GRN</option>

                    <?php foreach ($infosFormation['GRNS'] as $grn) : ?>
                        <?php if ($grn->numero_grn === $infosCurrent['numero_grn']) : ?>
                            <option selected value="<?= $grn->numero_grn; ?>"><?= $grn->numero_grn . ' - ' . $grn->nom_grn; ?></option>
                        <?php else : ?>
                            <option value="<?= $grn->numero_grn; ?>"><?= $grn->numero_grn . ' - ' . $grn->nom_grn; ?></option>
                        <?php endif; ?>

                    <?php endforeach; ?>

                </select>
            </label>

            <label for="ville"> Ville :
                <select name="ville" id="ville">
                    <option disabled>Choisir une ville</option>

                    <?php foreach ($infosFormation['Villes'] as $villes) : ?>

                        <?php if ($villes->id_ville === $infosCurrent['id_ville']) : ?>
                            <option selected value="<?= $villes->id_ville; ?>"><?= $villes->nom_ville; ?></option>
                        <?php else : ?>
                            <option value="<?= $villes->id_ville; ?>"><?= $villes->nom_ville; ?></option>
                        <?php endif; ?>

                    <?php endforeach; ?>

                </select>
            </label>
        </div>
        <div class="part1-sect">
            <label for="acronyme"> Acronyme :
                <input id="acronyme" value="<?= $infosCurrent['acronyme_formation']; ?>" name="acronyme" type="text" placeholder="Exemple : CDA">
            </label>

            <label for="description"> Description :
                <textarea id="description" name="description" style="resize : none;"> <?= $infosCurrent['description_formation']; ?></textarea>
            </label>

            <label for="offre"> Offre :
                <input id="offre" value="<?= $reassemble; ?>" name="offre" type="text" placeholder="Exemple : offre 1234">
            </label>
        </div>
        <div class="part1-sect">
            <label for="date-debut-formation"> Date de début :
                <input id="date-debut" value="<?= $infosCurrent['date_debut_formation']; ?>" name="date-debut-formation" type="date">
            </label>
            <label for="date-fin-formation"> Date de fin :
                <input id="date-fin" value="<?= $infosCurrent['date_fin_formation']; ?>" name="date-fin-formation" type="date">
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

                    <?php foreach ($infosRan as $ran) : ?>

                        <div class="date-fields" data="ran">
                            <div class="separate">
                                <label for="date-debut-ran"> Date de début :</label>
                                <input id="date-debut-ran" value="<?= $ran->date_debut_ran; ?>" name="date-debut-ran[]" type="date" class="date-periode">
                            </div>
                            <div class="separate">
                                <label for="date-fin-ran">Date de fin :</label>
                                <input id="date-fin-ran" value="<?= $ran->date_fin_ran; ?>" name="date-fin-ran[]" type="date" class="date-periode">

                            </div>
                            <button class="delete-date-fields" type="button" data="ran">X</button>
                            <hr>
                        </div>

                    <?php endforeach; ?>
                    <button class="add-date-fields" type="button" data="ran">+</button>
                </div>

                <h3>Périodes d'activité en entreprise</h3>
                <div class="date-container">

                    <?php foreach ($infosPae as $pae) : ?>

                        <div class="date-fields" data="entreprise">
                            <div class="separate">
                                <label for="date-debut-entreprise">Date de début : </label>
                                <input id="date-debut-entreprise" value="<?= $pae->date_debut_pae; ?>" name="date-debut-entreprise[]" type="date" class="date-periode">
                            </div>
                            <div class="separate">
                                <label for="date-fin-entreprise">Date de fin : </label>
                                <input id="date-fin-entreprise" value="<?= $pae->date_fin_pae; ?>" name="date-fin-entreprise[]" type="date" class="date-periode">
                            </div>
                            <button class="delete-date-fields" type="button" data="entreprise">X</button>
                            <hr>
                        </div>

                    <?php endforeach; ?>
                    <button class="add-date-fields" type="button" data="entreprise">+</button>
                </div>
            </div>
            <div class="col2">
                <h3>Périodes d'activité en centre <span class="legend">*</span></h3>
                <div class="date-container">

                    <?php foreach ($infosCentre as $centre) : ?>

                        <div class="date-fields" data="centre">
                            <div class="separate">

                                <label for="date-debut-centre">Date de début : </label>
                                <input id="date-debut-centre" value="<?= $centre->date_debut_centre; ?>" name="date-debut-centre[]" type="date" class="date-periode">
                            </div>
                            <div class="separate">

                                <label for="date-fin-centre">Date de fin : </label>
                                <input id="date-fin-centre" value="<?= $centre->date_fin_centre; ?>" name="date-fin-centre[]" type="date" class="date-periode">

                            </div>
                            <button class="delete-date-fields" type="button" data="centre">X</button>
                            <hr>
                        </div>

                    <?php endforeach; ?>
                    <button type="button" class="add-date-fields" data="centre">+</button>
                </div>

                <h3>Périodes de certification</h3>
                <div class="date-container">
                    <div>
                        <?php foreach ($infosCertif as $certification) : ?>

                            <div class="date-fields" data="certification">
                                <div class="separate">

                                    <label for="date-debut-certification">Date de début : </label>
                                    <input id="date-debut-certification" value="<?= $certification->date_debut_certif; ?>" name="date-debut-certification[]" type="date" class="date-periode">
                                </div>
                                <div class="separate">

                                    <label for="date-fin-certification">Date de fin : </label>
                                    <input id="date-fin-certifciation" value="<?= $certification->date_fin_certif; ?>" name="date-fin-certification[]" type="date" class="date-periode">
                                </div>
                                <button class="delete-date-fields" type="button" data="certification">X</button>
                                <hr>
                            </div>

                        <?php endforeach; ?>
                        <button type="button" class="add-date-fields" data="certification">+</button>
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
                <?php foreach ($infosInterruption as $interruption) : ?>

                    <div class="date-fields" data="ran">
                        <div class="separate">
                            <label for="date-debut-ran">Date de début période interruption : </label>
                            <input value="<?= $interruption->date_debut_interruption; ?>" name="date-debut-interruption[]" type="date">
                        </div>
                        <div class="separate">
                            <label for="date-fin-ran">Date de fin période interruption : </label>
                            <input value="<?= $interruption->date_fin_interruption; ?>" name="date-fin-interruption[]" type="date">
                        </div>
                        <button class="delete-date-fields" type="button" data="interruption">X</button>
                        <hr>
                    </div>
                <?php endforeach; ?>
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
                <option disabled>Choisir un formateur</option>

                <?php foreach ($infosFormation['Formateurs'] as $formateurs) : ?>

                    <?php if ($formateurs->id_formateur == 1 || $formateurs->id_formateur == 2) {
                        continue;
                    }; ?>

                    <?php if ($formateurs->id_formateur === $infosCurrent->id_formateur) : ?>
                        <option selected value="<?= $formateurs->id_formateur ?>"><?= $formateurs->nom_formateur . ' ' . $formateurs->prenom_formateur; ?></option>
                    <?php else : ?>
                        <option selected value="<?= $formateurs->id_formateur; ?>"><?= $formateurs->nom_formateur . ' ' . $formateurs->prenom_formateur; ?></option>
                    <?php endif; ?>

                <?php endforeach; ?>

            </select>
        </label>

        <div class="intervention-container">
            <?php foreach ($infosInterventions as $intervention) : ?>
                <div class="date-fields">
                    <label for="formateur">
                        <select name="formateur[]">
                            <option disabled>Choisir un formateur</option>
                            <?php foreach ($infosFormation['Formateurs'] as $formateurs) : ?>
                                <?php if ($formateurs->id_formateur == 1 || $formateurs->id_formateur == 2) {
                                    continue;
                                }; ?>
                                <?php if ($formateurs->id_formateur === $intervention['id']) : ?>
                                    <option selected value="<?= $formateurs->id_formateur; ?>"><?= $formateurs->nom_formateur . ' ' . $formateurs->prenom_formateur; ?></option>
                                <?php else : ?>
                                    <option value="<?= $formateurs->id_formateur; ?>"><?= $formateurs->nom_formateur . ' ' . $formateurs->prenom_formateur; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <div class="separate">
                        <label for="date-debut-intervention"> Date de début :</label>
                        <input id="date-debut-intervention" name="date-debut-intervention[]" value="<?= $intervention['debut']; ?>" type="date" class="date-periode">
                    </div>
                    <div class="separate">
                        <label for="date-fin-intervention"> Date de fin :</label>
                        <input id="date-fin-intervention" name="date-fin-intervention[]" value="<?= $intervention['fin']; ?>" type="date" class="date-periode">
                    </div>
                    <button class="delete-date-fields" type="button" data="intervention">X</button>
                    <hr>
                </div>
            <?php endforeach; ?>
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
    <input id="nextButton" type="button" value="Suivant">
    <input id="submitButton" type="submit" value="Valider">
    <span class="legend">* champs obligatoires</span>
    <input type="submit" value="Modifier">
</form>