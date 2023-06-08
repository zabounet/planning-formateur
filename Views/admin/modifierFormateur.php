<?php $link = "Modifier " . $infosCurrent[0]->prenom_formateur . " " . $infosCurrent[0]->nom_formateur; ?>

<h1>Modifier les informations de <?= $infosCurrent[0]->prenom_formateur . " " . $infosCurrent[0]->nom_formateur; ?></h1>
<section>
    <form style="text-transform: capitalize;" method="post" name="validation">
        <label for="nom">nom
            <input value="<?= $infosCurrent[0]->nom_formateur; ?>" type="text" name="nom" id="nom-input">
        </label>
        <label for="prenom">prenom
            <input value="<?= $infosCurrent[0]->prenom_formateur; ?>" type="text" name="prenom" id="prenom-input">
        </label>
        <label for="mail">e-mail
            <input value="<?= $infosCurrent[0]->mail_formateur; ?>" type="email" name="mail" id="mail-input">
        </label>
        <label for="type_contrat"> type contrat :
            <select name="type_contrat" id="type_contrat">
                <option disabled selected>Choisir type contrat</option>
                <option <?php if ($infosCurrent[0]->type_contrat_formateur === "CDI") : ?> selected <?php endif; ?> value="CDI">CDI</option>
                <option <?php if ($infosCurrent[0]->type_contrat_formateur === "CDD") : ?> selected <?php endif; ?> value="CDD">CDD</option>
                <option <?php if ($infosCurrent[0]->type_contrat_formateur === "Interim") : ?> selected <?php endif; ?> value="Interim">intrime</option>
                <option <?php if ($infosCurrent[0]->type_contrat_formateur === "Autre") : ?> selected <?php endif; ?> value="Autre">autre</option>
            </select>
        </label>

        <label for="date_debut_contrat">date debut contrat
            <input value="<?= $infosCurrent[0]->date_debut_contrat; ?>" type="date" name="date_debut_contrat" id="">
        </label>
        <label for="date_fin_contrat">date fin contrat
            <input <?php if ($infosCurrent[0]->type_contrat_formateur !== "CDI") : ?> value="<?= $infosCurrent[0]->date_fin_contrat; ?>" <?php endif; ?> type="date" name="date_fin_contrat" id="fin">
        </label>
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

        <input type="submit" value="Modifier" name="inscription">
    </form>

    <hr class="fin-list">

    <div class="teletravail" id="TT">
        <div class="profil-text">
            <h2>Teletravail</h2>
        </div>

        <div class="demande-teletravail">
            <span class="titre titre-demande-teletravai">Selectionnez les jours de la semaine où vous souhaitez être en télétravail</span>
            <span class="notif notif-demande-teletravail"><b>/!\</b> Pas plus de deux jours par semaine de télétravails sont autorisés <b>/!\</b></span>
            <form method="post" class="container-teletravail">
                <div>
                    <section class="app">
                        <?php

                        $jourSemaine = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi');
                        
                        if (isset($_SESSION['teletravail']['jour_teletravail'])) {
                            $jourTeletravail = explode(",", $_SESSION['teletravail']['jour_teletravail']);
                        } else {
                            $jourTeletravail[] = "Aucun";
                        }
                        foreach ($jourSemaine as $jour) :
                        ?>
                            <?php in_array($jour, $jourTeletravail) ? $checked = "checked" : $checked = ""; ?>

                            <article class="features">
                                <input <?= $checked; ?> type="checkbox" id="<?= $jour; ?>" name="<?= $jour; ?>" />
                                <div>
                                    <span>
                                        <?= $jour; ?>
                                    </span>
                                </div>
                            </article>

                        <?php endforeach; ?>
                    </section>
                    <div class="prise-effet">
                        <label for="">Date de prise d'effet : </label>
                        <input class="date-champe" name="date_prise_effet" type="date" required>
                    </div>
                </div>
                <div class="valid-div">
                    <input type="submit" value="Valider" name="jourTeletravail" class="valider">
                </div>
            </form>

            <span class="error" style="color: red;">
                <?php if (isset($_SESSION['error_teletravail'])) {
                    echo $_SESSION['error_teletravail'];
                    unset($_SESSION['error_teletravail']);
                }
                ?>
            </span>
            <span class="success" style="color: green; ">
                <?php if (isset($_SESSION['success_teletravail'])) {
                    echo $_SESSION['success_teletravail'];
                    unset($_SESSION['success_teletravail']);
                }
                ?>

        </div>
    </div>

    <hr class="fin-list">

    <h2>Liste des périodes d'intervention du formateur</h2>
    <?php if(!empty($infosInterventions)):?>
    <?php foreach ($infosInterventions as $intervention) : ?>
        <form method="post">
            <p>Date de début : <?php $debut = new DateTime($intervention->date_debut_intervention);
                                echo $debut->format('d-m-Y'); ?></p>
            <p>Date de fin : <?php $fin = new DateTime($intervention->date_fin_intervention);
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
            <input class="delete" type="button" value="Supprimer la période">
            <div class="confirm">
                <h4 class="confirm-text">Êtes-vous sûr(e) ?</h4>
                <input type="submit" name="Delete" value="Confirmer">
            </div>
        </form>
    <?php endforeach; ?>
    <?php else : ?>
        <p>Il y a aucun date pour intervention</p>
    <?php endif ; ?>
    

    <hr>

    <h2>Liste des périodes de MNSP du formateur</h2>
    <?php if(!empty($infosMNSP)):?>
        <?php foreach ($infosMNSP as $mnsp) : ?>
            <form method="post">
                <p>Date de début : <?php $debut = new DateTime($mnsp->date_debut_MNSP);
                                    echo $debut->format('d-m-Y'); ?></p>
                <p>Date de fin : <?php $fin = new DateTime($mnsp->date_fin_MNSP);
                                    echo $fin->format('d-m-Y'); ?></p>
                <input type="hidden" name="MNSP" value="<?= $mnsp->id_MNSP; ?>">
                <input class="delete" type="button" value="Supprimer la période">
                <div class="confirm">
                    <h4 class="confirm-text">Êtes-vous sûr(e) ?</h4>
                    <input type="submit" name="Delete" value="Confirmer">
                </div>
            </form>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Il y a aucun date pour MNSP</p>
    <?php endif ; ?>
    <hr>

    <h2>Liste des périodes de perfectionnement du formateur</h2>
    <?php if(!empty($infosPerfectionnement)):?>
        <?php foreach ($infosPerfectionnement as $perfectionnement) : ?>
            <form method="post">
                <p>Date de début : <?php $debut = new DateTime($perfectionnement->date_debut_perfectionnement);
                                    echo $debut->format('d-m-Y'); ?></p>
                <p>Date de fin : <?php $fin = new DateTime($perfectionnement->date_fin_perfectionnement);
                                    echo $fin->format('d-m-Y'); ?></p>
                <input type="hidden" name="perfectionnement" value="<?= $perfectionnement->id_perfectionnement; ?>">
                <input class="delete" type="button" value="Supprimer la période">
                <div class="confirm">
                    <h4 class="confirm-text">Êtes-vous sûr(e) ?</h4>
                    <input type="submit" name="Delete" value="Confirmer">
                </div>
            </form>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Il y a aucun date pour perfectionnement</p>
    <?php endif ; ?>
    <hr>

    <h2>Liste des périodes de vacance du formateur</h2>
    <?php if(!empty($infosVacances)):?>
    <?php foreach ($infosVacances as $vacance) : ?>
        <form method="post">
            <p>Date de début : <?php $debut = new DateTime($vacance->date_debut_vacances);
                                echo $debut->format('d-m-Y'); ?></p>
            <p>Date de fin : <?php $fin = new DateTime($vacance->date_fin_vacances);
                                echo $fin->format('d-m-Y'); ?></p>
            <input type="hidden" name="vacance" value="<?= $vacance->id_vacance; ?>">
            <input class="delete" type="button" value="Supprimer la période">
            <div class="confirm">
                <h4 class="confirm-text">Êtes-vous sûr(e) ?</h4>
                <input type="submit" name="Delete" value="Confirmer">
            </div>
        </form>
    <?php endforeach; ?>
    <?php else : ?>
        <p>Il y a aucun date pour vacance</p>
    <?php endif ; ?>

    <hr>

    <h2>Liste des périodes d'autre du formateur</h2>
    <?php if(!empty($infosAutres)):?>
    <?php foreach ($infosAutres as $autre) : ?>
        <form method="post">
            <p> <?=$autre->lettre; ?> </p>
            <p>Date de début : <?php $debut = new DateTime($autre->date_debut_autre);
                                echo $debut->format('d-m-Y'); ?></p>
            <p>Date de fin : <?php $fin = new DateTime($autre->date_fin_autre);
                                echo $fin->format('d-m-Y'); ?></p>
            <input type="hidden" name="autre" value="<?= $autre->id_autre; ?>">
            <input class="delete" type="button" value="Supprimer la période">
            <div class="confirm">
                <h4 class="confirm-text">Êtes-vous sûr(e) ?</h4>
                <input type="submit" name="Delete" value="Confirmer">
            </div>
        </form>
    <?php endforeach; ?>
    <?php else : ?>
        <p>Il y a aucun date pour vacance</p>
    <?php endif ; ?>


    <hr class="fin-list">

    <form method="post">
        <h2>Ajouter une période d'intervention pour ce formateur</h2>
        <div>
            <button type="button" class="add-date-fields" data="intervention">Ajouter intervention</button>
            <input type="submit" value="Valider">
        </div>
    </form>

    <form method="post">
        <h2>Ajouter une période de MNSP pour ce formateur</h2>
        <div>
            <button type="button" class="add-date-fields" data="MNSP">Ajouter MSNP</button>
            <input type="submit" value="Valider">
        </div>
    </form>

    <form method="post">
        <h2>Ajouter une période de perfectionnement pour ce formateur</h2>
        <div>
            <button type="button" class="add-date-fields" data="perfectionnement">Ajouter perfectionnement</button>
            <input type="submit" value="Valider">
        </div>
    </form>
    <form method="post">
        <h2>Ajouter une période de vacance pour ce formateur</h2>
        <div>
            <button type="button" class="add-date-fields" data="vacance">Ajouter vacance</button>
            <input type="submit" value="Valider">
        </div>
    </form>
    <form method="post">
        <h2>Ajouter une période d'autre pour ce formateur</h2>
        <div>
            <button type="button" class="add-date-fields" data="autre">Ajouter autre</button>
            <input type="submit" value="Valider">
        </div>
    </form>
</section>