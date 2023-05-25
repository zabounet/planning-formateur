<?php $link = "Modifier " . $infosCurrent[0]->prenom_formateur . " " . $infosCurrent[0]->nom_formateur; ?>

<h1>Inscription formateur</h1>
<section>
    <form style="text-transform: capitalize;" method="post" name="validation">
        <span>nom</span>
        <input value="<?= $infosCurrent[0]->nom_formateur; ?>" type="text" name="nom" id="nom-input">

        <span>prenom</span>
        <input value="<?= $infosCurrent[0]->prenom_formateur; ?>" type="text" name="prenom" id="prenom-input">

        <span>mail</span>
        <input value="<?= $infosCurrent[0]->mail_formateur; ?>" type="mail" name="mail" id="mail-input">

        <label for="type_contrat"> type contrat :
            <select name="type_contrat" id="type_contrat">
                <option disabled selected>Choisir type contrat</option>
                <option <?php if ($infosCurrent[0]->type_contrat_formateur === "CDI") : ?> selected <?php endif; ?> value="CDI">CDI</option>
                <option <?php if ($infosCurrent[0]->type_contrat_formateur === "CDD") : ?> selected <?php endif; ?> value="CDD">CDD</option>
                <option <?php if ($infosCurrent[0]->type_contrat_formateur === "Interim") : ?> selected <?php endif; ?> value="Interim">intrime</option>
                <option <?php if ($infosCurrent[0]->type_contrat_formateur === "Autre") : ?> selected <?php endif; ?> value="Autre">autre</option>
            </select>
        </label>

        <span>date debut contrat</span>
        <input value="<?= $infosCurrent[0]->date_debut_contrat; ?>" type="date" name="date_debut_contrat" id="">

        <span>date fin contrat</span>
        <input <?php if ($infosCurrent[0]->type_contrat_formateur !== "CDI") : ?> value="<?= $infosCurrent[0]->date_fin_contrat; ?>" <?php endif; ?> type="date" name="date_fin_contrat" id="fin">

        <label for="grn"> GRN :
            <select name="grn">
                <option disabled>Choisir un GRN</option>


                <?php foreach ($infosFormateur['GRNS'] as $grn) : ?>

                    <?php if ($grn->numero_grn === $infosCurrent[0]->numero_grn) : ?>
                        <option selected value="<?= $grn->numero_grn ?>"><?= $grn->numero_grn . " - " . $grn->nom_grn; ?></option>
                    <?php else : ?>
                        <option value="<?= $grn->numero_grn ?>"><?= $grn->numero_grn . " - " . $grn->nom_grn; ?></option>
                    <?php endif; ?>

                <?php endforeach; ?>

            </select>
        </label>

        <label for="ville"> Ville :
            <select name="ville">
                <option disabled selected>Choisir une ville</option>

                <?php foreach ($infosFormateur['Villes'] as $villes) : ?>

                    <?php if ($villes->nom_ville === $infosCurrent[0]->nom_ville) : ?>
                        <option selected value="<?= $villes->id_ville; ?>"><?= $villes->nom_ville; ?></option>
                    <?php else : ?>
                        <option value="<?= $villes->id_ville; ?>"><?= $villes->nom_ville; ?></option>
                    <?php endif; ?>

                <?php endforeach; ?>

            </select>
        </label>

        <input type="submit" value="Inscrire" name="inscription">

    </form>

    <hr>

    <h2>Liste des périodes d'intervention du formateur</h2>

    <?php foreach ($infosInterventions as $intervention) : ?>
        <form method="post">
            <p>Date de début : <?php $debut = new DateTime($intervention->date_debut_intervention);
                                echo $debut->format('d-m-Y'); ?></p>
            <p>Date de fin : <?php $fin = new DateTime($intervention->date_debut_intervention);
                                echo $fin->format('d-m-Y'); ?></p>
            <p>Formation :
                <?php foreach ($infosFormation as $formation) {
                    if ($formation->id_formation === $intervention->id_formation) {
                        echo $formation->nom_formation;
                    } else {
                        continue;
                    }
                } ?>
            </p>
            <input type="hidden" name="intervention" value="<?= $intervention->id_intervention; ?>">
            <input type="submit" name="delete" value="Supprimer la période">
        </form>
    <?php endforeach; ?>

    <hr>

    <h2>Liste des périodes de MNSP du formateur</h2>

    <?php foreach ($infosMNSP as $mnsp) : ?>
        <form method="post">
            <p>Date de début : <?php $debut = new DateTime($mnsp->date_debut_MNSP);
                                echo $debut->format('d-m-Y'); ?></p>
            <p>Date de fin : <?php $fin = new DateTime($mnsp->date_debut_MNSP);
                                echo $fin->format('d-m-Y'); ?></p>
            <input type="hidden" name="MNSP" value="<?= $mnsp->id_MNSP; ?>">
            <input type="submit" name="delete" value="Supprimer la période">
        </form>
    <?php endforeach; ?>

    <hr>

    <h2>Liste des périodes de perfectionnement du formateur</h2>

    <?php foreach ($infosPerfectionnement as $perfectionnement) : ?>
        <form method="post">
            <p>Date de début : <?php $debut = new DateTime($perfectionnement->date_debut_perfectionnement);
                                echo $debut->format('d-m-Y'); ?></p>
            <p>Date de fin : <?php $fin = new DateTime($perfectionnement->date_debut_perfectionnement);
                                echo $fin->format('d-m-Y'); ?></p>
            <input type="hidden" name="perfectionnement" value="<?= $perfectionnement->id_perfectionnement; ?>">
            <input type="submit" name="delete" value="Supprimer la période">
        </form>
    <?php endforeach; ?>

    <hr>

    <form method="post">
        <h2>Ajouter une période d'intervention pour ce formateur</h2>
        <div>
            <button type="button" class="add-date-fields" data="intervention">Ajouter intervention</button>
        </div>
        <input type="submit" value="Valider">
    </form>

    <form method="post">
        <h2>Ajouter une période de MNSP pour ce formateur</h2>
        <div>
            <button type="button" class="add-date-fields" data="MNSP">Ajouter MSNP</button>
        </div>
        <input type="submit" value="Valider">
    </form>

    <form method="post">
        <h2>Ajouter une période de perfectionnement pour ce formateur</h2>
        <div>
            <button type="button" class="add-date-fields" data="perfectionnement">Ajouter perfectionnement</button>
        </div>
        <input type="submit" value="Valider">
    </form>
</section>