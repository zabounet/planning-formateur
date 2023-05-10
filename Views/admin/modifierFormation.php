<?php 
    $disassemble = explode(" ",$infosCurrent['nom_formation']);
    $reassemble = $disassemble[2] . " " . $disassemble[3] . " ";

    $link = "Modifier la formation " . $infosCurrent['acronyme_formation']; 
?>

<h1>Modifier la formation : <?= $infosCurrent['nom_formation']; ?></h1>

<form method="post">
    <fieldset id="part1">Informations sur la formation

        <label for="type">Catégorie de formation :
            <select name="type">
                <option disabled>Choisir un type de formation</option>

                <?php foreach ($infosFormation['Types'] as $types) : ?>

                    <?php if($types->id_type_formation === $infosCurrent['id_type_formation']):?>
                        <option selected value="<?= $types->id_type_formation ?>"><?= $types->designation_type_formation; ?></option>
                    <?php else:?>
                        <option value="<?= $types->id_type_formation ?>"><?= $types->designation_type_formation; ?></option>
                    <?php endif;?>

                <?php endforeach; ?>

            </select>
        </label>

        <label for="grn"> GRN :
            <select name="grn">
                <option disabled>Choisir un GRN</option>

                <?php foreach ($infosFormation['GRNS'] as $grn) : ?>
                    <?php if($grn->numero_grn === $infosCurrent['numero_grn']):?>
                        <option selected value="<?= $grn->numero_grn; ?>"><?= $grn->numero_grn . ' - ' . $grn->nom_grn; ?></option>
                    <?php else:?>
                        <option value="<?= $grn->numero_grn; ?>"><?= $grn->numero_grn . ' - ' . $grn->nom_grn; ?></option>
                    <?php endif;?>

                <?php endforeach; ?>

            </select>
        </label>

        <label for="acronyme"> Acronyme de formation :
            <input value="<?=$infosCurrent['acronyme_formation'];?>" name="acronyme" type="text" placeholder="Exemple : CDA">
        </label>

        <label for="description"> Description
            <textarea name="description" style="resize : none;"> <?=$infosCurrent['description_formation'];?></textarea>
        </label>

        <label for="offre"> Numéro d'offre :
            <input value="<?=$reassemble;?>" name="offre" type="text" placeholder="Exemple : offre 1234">
        </label>

        <label for="date-debut-formation"> Date de début :
            <input value="<?=$infosCurrent['date_debut_formation'];?>" name="date-debut-formation" type="date">
        </label>
        <label for="date-fin-formation"> Date de fin :
            <input value="<?=$infosCurrent['date_fin_formation'];?>" name="date-fin-formation" type="date">
        </label>

        <label for="ville"> Ville :
            <select name="ville">
                <option disabled>Choisir une ville</option>

                <?php foreach ($infosFormation['Villes'] as $villes) : ?>

                    <?php if($villes->id_ville === $infosCurrent['id_ville']): ?>
                        <option selected value="<?= $villes->id_ville; ?>"><?= $villes->nom_ville; ?></option>
                    <?php else :?>
                        <option value="<?= $villes->id_ville; ?>"><?= $villes->nom_ville; ?></option>
                    <?php endif;?>

                <?php endforeach; ?>
                
            </select>
        </label>
    </fieldset>

    <fieldset id="part2">Répartition des périodes
        <div>
            <?php foreach ($infosRan as $ran) : ?>

                <div class="date-fields" data="ran">
                    <label for="date-debut-ran">Date de début période ran :
                        <input value="<?= $ran->date_debut_ran; ?>" name="date-debut-ran[]" type="date">
                    </label>
                    <label for="date-fin-ran">Date de fin période ran :
                        <input value="<?= $ran->date_fin_ran; ?>" name="date-fin-ran[]" type="date">
                    </label>
                    <button class="delete-date-fields" type="button" data="ran">Supprimer période ran</button>
                </div>

            <?php endforeach; ?>
            <button type="button" class="add-date-fields" data="ran">Ajouter période RAN</button>
        </div>

        <div>
            <?php foreach ($infosPae as $pae) : ?>

                <div class="date-fields" data="entreprise">
                    <label for="date-debut-entreprise">Date de début période entreprise :
                        <input value="<?= $pae->date_debut_pae; ?>" name="date-debut-entreprise[]" type="date">
                    </label>
                    <label for="date-fin-entreprise">Date de fin période entreprise :
                        <input value="<?= $pae->date_fin_pae; ?>" name="date-fin-entreprise[]" type="date">
                    </label>
                    <button class="delete-date-fields" type="button" data="entreprise">Supprimer période pae</button>
                </div>

            <?php endforeach; ?>
            <button type="button" class="add-date-fields" data="entreprise">Ajouter période PAE</button>
        </div>

        <div>
            <?php foreach ($infosCentre as $centre) : ?>

                <div class="date-fields" data="ran">
                    <label for="date-debut-ran">Date de début période centre :
                        <input value="<?= $centre->date_debut_centre; ?>" name="date-debut-centre[]" type="date">
                    </label>
                    <label for="date-fin-ran">Date de fin période centre :
                        <input value="<?= $centre->date_fin_centre; ?>" name="date-fin-centre[]" type="date">
                    </label>
                    <button class="delete-date-fields" type="button" data="centre">Supprimer période centre</button>
                </div>

            <?php endforeach; ?>
            <button type="button" class="add-date-fields" data="centre">Ajouter période centre</button>
        </div>

        <div>
            <?php foreach ($infosCertif as $certification) : ?>

                <div class="date-fields" data="ran">
                    <label for="date-debut-ran">Date de début période certification :
                        <input value="<?= $certification->date_debut_certif; ?>" name="date-debut-certification[]" type="date">
                    </label>
                    <label for="date-fin-ran">Date de fin période certification :
                        <input value="<?= $certification->date_fin_certif; ?>" name="date-fin-certification[]" type="date">
                    </label>
                    <button class="delete-date-fields" type="button" data="certification">Supprimer période certification</button>
                </div>

            <?php endforeach; ?>
            <button type="button" class="add-date-fields" data="certification">Ajouter période certification</button>
        </div>
    </fieldset>

    <fieldset id="part3"> Ajouter des interruptions
        <div>
            <?php foreach ($infosInterruption as $interruption) : ?>

                <div class="date-fields" data="ran">
                    <label for="date-debut-ran">Date de début période interruption :
                        <input value="<?= $interruption->date_debut_interruption; ?>" name="date-debut-interruption[]" type="date" min="<?= date('Y-m-d'); ?>">
                    </label>
                    <label for="date-fin-ran">Date de fin période interruption :
                        <input value="<?= $interruption->date_fin_interruption; ?>" name="date-fin-interruption[]" type="date" min="<?= date('Y-m-d'); ?>">
                    </label>
                    <button class="delete-date-fields" type="button" data="interruption">Supprimer période interruption</button>
                </div>

            <?php endforeach; ?>
        </div>
        <button type="button" class="add-date-fields" data="interruption">Ajouter une nouvelle interruption</button>
    </fieldset>

    <fieldset id="part4"> Répartition des formateurs

        <label for="referent-formateur"> Formateur référent :
            <select name="referent-formateur">
                <option disabled>Choisir un formateur</option>

                <?php foreach ($infosFormation['Formateurs'] as $formateurs) : ?>
                
                    <?php if($formateurs->id_formateur == 1 || $formateurs->id_formateur == 2){
                        continue;
                    };?>

                    <?php if($formateurs->id_formateur === $infosCurrent->id_formateur): ?>
                        <option selected value="<?= $formateurs->id_formateur ?>"><?= $formateurs->nom_formateur . ' ' . $formateurs->prenom_formateur; ?></option>
                    <?php else :?>
                        <option selected value="<?= $formateurs->id_formateur; ?>"><?= $formateurs->nom_formateur . ' ' . $formateurs->prenom_formateur; ?></option>
                    <?php endif;?>

                <?php endforeach; ?>

            </select>
        </label>

        <div>
            <button type="button" class="add-date-fields" data="intervention">Add new</button>
        </div>
    </fieldset>

    <input type="submit" value="Modifier">
</form>