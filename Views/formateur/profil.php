<?php $link = "Profil"; ?>

<div class="profile" id="profil">
    <div class="profil-text section-titre">
        <span>Profil</span>
    </div>

    <div class="info-personel">
        <span class="titre titre-profil">Vos informations personnelles :</span>
        <div class="container-info">

            <form class="profil nom-profil" method="post">
                <span class="title">Nom :</span>
                <?php if (str_replace('/planning/public/index.php?p=Formateur/profil', '', $_SERVER['REQUEST_URI']) === "&?id=1") : ?>
                    <input class="value" type='text' name="nom" class="value nomProfil" value="<?php if (isset($_SESSION['formateur'])){ echo $_SESSION['formateur']['nom'];} else {echo $_SESSION['admin']['nom'];} ?>" />
                    <input class="valider" type="submit" id="modifier_nom_formateur" value="Valider" name="modifNom" />
                <?php else : ?>
                    <span class="value" id="prenomProfil"><?php if (isset($_SESSION['formateur'])){ echo $_SESSION['formateur']['nom'];} else {echo $_SESSION['admin']['nom'];} ?></span>
                    <a href="/planning/public/index.php?p=Formateur/profil&?id=1">Modifier</a>
                <?php endif; ?>
            </form>
            <hr>
            <form class="profil prenom-profil" method="post">
                <span class="title">Prenom :</span>
                <?php if (str_replace('/planning/public/index.php?p=Formateur/profil', '', $_SERVER['REQUEST_URI']) === "&?id=2") : ?>
                    <input class="value" type='text' name="prenom" class="value prenomProfil" value="<?php if (isset($_SESSION['formateur'])) echo $_SESSION['formateur']['prenom']; else {echo $_SESSION['admin']['prenom'];} ?>" />
                    <input class="valider" type="submit" id="modifier_prenom_formateur" value="Valider" name="modifPrenom" />
                <?php else : ?>
                    <span class="value" id="prenomProfil"><?php if (isset($_SESSION['formateur'])) echo $_SESSION['formateur']['prenom']; else {echo $_SESSION['admin']['prenom'];} ?></span>
                    <a href="/planning/public/index.php?p=Formateur/profil&?id=2">Modifier</a>
                <?php endif; ?>
            </form>
            <hr>
            <form class="profil mail-profil" method="post">
                <span class="title">Mail :</span>
                <?php if (str_replace('/planning/public/index.php?p=Formateur/profil', '', $_SERVER['REQUEST_URI']) === "&?id=3") : ?>
                    <input class="value" type="email" name="mail" class="value mailProfil" value="<?php if (isset($_SESSION['formateur'])) echo $_SESSION['formateur']['mail']; else {echo $_SESSION['admin']['mail'];} ?>" />
                    <input type="submit" id="modifier_mail_formateur" value="Valider" name="modifMail" class="valider" />
                <?php else : ?>
                    <span class="value" id="mailProfil"><?php if (isset($_SESSION['formateur'])) echo $_SESSION['formateur']['mail']; else {echo $_SESSION['admin']['mail'];} ?></span>
                    <a href="/planning/public/index.php?p=Formateur/profil&?id=3">Modifier</a>
                <?php endif; ?>
            </form>
            <hr>
            <form class="profil <?php if(str_replace('/planning/public/index.php?p=Formateur/profil', '', $_SERVER['REQUEST_URI']) === "&?id=4") echo "mdpChange";?> mdp-profil" method="post">

                <?php if (str_replace('/planning/public/index.php?p=Formateur/profil', '', $_SERVER['REQUEST_URI']) === "&?id=4") : ?>
                    <div class="mdp-container">
                        <div>
                            <span>Saisir votre mot de passe actuel :</span>
                            <input type="password" name="current_mdp" class="mdpProfil" value="" />
                        </div>
                        <div>
                            <span>Saisir nouveau mot de passe :</span>
                            <input type="password" name="new_mdp" class="mdpProfil" value="" />
                        </div>
                        <div>
                            <span>Saisir confirmation du nouveau mot de passe :</span>
                            <input type="password" name="conf_new_mdp" class="mdpProfil" value="" />
                        </div>
                    </div>
                    <input type="submit" id="modifier_mdp_formateur" value="valider" name="verifierMdp" class="valider" />
                <?php else : ?>
                    <span class="title">Mot de passe :</span>
                    <span class="value" id="mdpProfil">****</span>
                    <a href="/planning/public/index.php?p=Formateur/profil&?id=4">Modifier</a>
                <?php endif; ?>
            </form>
        </div>
        <span class="error" style="color: red;">
            <?php if (isset($_SESSION['error_profil'])) {
                echo $_SESSION['error_profil'];
                unset($_SESSION['error_profil']);
            }
            ?>
        </span>
        <span class="success" style="color: green; ">
            <?php if (isset($_SESSION['success_profil'])) {
                echo $_SESSION['success_profil'];
                unset($_SESSION['success_profil']);
            }
            ?>
        </span>
    </div>
</div>
<?php if (isset($_SESSION['formateur']) && !empty($_SESSION['formateur']['id'])) : ?>

    <div class="vacances" id="vacance">
        <div class="profil-text">
            <span class="vacances-text">Demande de vacances</span>
        </div>

        <span class="titre titre-demande-vacances">Sélectionnez une période :</span>
        <div class="demande-vacances">
            <form method="POST" class="container-vacances">
                <div class="date-demande-vacances">
                    <div class="date date-debut date-debut-vacance">
                        <p>Date de début</p>
                        <input type="date" name="date_debut" id="" required min="<?= date('Y-m-d'); ?> ">
                    </div>
                    <div class="date date-fin date-fin-vacance">
                        <p>Date de fin</p>
                        <input type="date" name="date_fin" id="" min="" required>
                    </div>
                </div>
                <div class="btn btn-validation-vacance">
                    <input type="submit" value="envoyer la demande" name="vacances" class="valider">
                </div>
            </form>
            <span class="error" style="color: red;">
                <?php if (isset($_SESSION['error_vacance'])) {
                    echo $_SESSION['error_vacance'];
                    unset($_SESSION['error_vacance']);
                }
                ?>
            </span>
            <span class="success" style="color: green; ">
                <?php if (isset($_SESSION['success_vacance'])) {
                    echo $_SESSION['success_vacance'];
                    unset($_SESSION['success_vacance']);
                }
                ?>
            </span>
        </div>
    </div>
    <div class="teletravail" id="TT">
        <div class="profil-text">
            <span class="teletravail-text">Demande de teletravail</span>
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
                        <input name="date_prise_effet" type="date" required>
                    </div>
                </div>
                <div>
                    <input type="submit" value="envoyer la demande" name="jourTeletravail" class="valider">
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

    <!-- profil admin -->
<?php elseif (isset($_SESSION['admin']) && !empty($_SESSION['admin']['id'])) : ?>
    <div class="list-color" id="couleur">

        <div class="profil-text">
            <span>Code couleur</span>
        </div>
        <form method="POST" name="list-color">

            <span class="titre">Changer la couleur des informations apparaissant sur le calendrier</span>
            <div class="list-color-container">
                <div class="cloumn cloumn-color1">

                    <div>
                        <span>Activité en centre</span>
                        <input type="color" name="centre" value="<?= $_SESSION['color']['couleur_centre']; ?>" id="">
                    </div>

                    <div>
                        <span>Activité en entreprise</span>
                        <input type="color" name="pae" value="<?= $_SESSION['color']['couleur_pae']; ?>" id="">
                    </div>

                    <div>
                        <span>Période de certification</span>
                        <input type="color" name="certif" value="<?= $_SESSION['color']['couleur_certif']; ?>" id="">
                    </div>

                    <div>
                        <span>Période de remise à niveau</span>
                        <input type="color" name="ran" value="<?= $_SESSION['color']['couleur_ran']; ?>" id="">
                    </div>
                </div>
                <div class="cloumn cloumn-color2">
                    <div>
                        <span>Vacances demandées</span>
                        <input type="color" name="vacance_demandees" value="<?= $_SESSION['color']['couleur_vacance_demandees']; ?>" id="">
                    </div>

                    <div>
                        <span>Vacances approuvées</span>
                        <input type="color" name="vacance_validee" value="<?= $_SESSION['color']['couleur_vacance_validee']; ?>" id="">
                    </div>

                    <div>
                        <span>Télétravail</span>
                        <input type="color" name="couleur_autre" value="<?= $_SESSION['color']['couleur_autre']; ?>" id="">
                    </div>

                    <div>
                        <span>Jour férié</span>
                        <input type="color" name="ferie" value="<?= $_SESSION['color']['couleur_ferie']; ?>" id="">
                    </div>
                </div>
                <div class="cloumn cloumn-color3">
                    <div>
                        <span>Week-end</span>
                        <input type="color" name="weekend" value="<?= $_SESSION['color']['couleur_weekend']; ?>" id="">
                    </div>

                    <div>
                        <span>Période d'interruption</span>
                        <input type="color" name="interruption" value="<?= $_SESSION['color']['couleur_interruption']; ?>" id="">
                    </div>

                    <div>
                        <span>MNSP</span>
                        <input type="color" name="MNSP" value="<?= $_SESSION['color']['couleur_MNSP']; ?>" id="">
                    </div>

                    <div>
                        <span>Perfectionment</span>
                        <input type="color" name="perfectionment" value="<?= $_SESSION['color']['couleur_perfectionment']; ?>" id="">
                    </div>
                </div>
            </div>
            <input class="valider" type="submit" value="valider" name="send-color">
        </form>
        <span class="error" style="color: red;">
            <?php if (isset($_SESSION['error_color'])) {
                echo $_SESSION['error_color'];
                unset($_SESSION['error_color']);
            }
            ?>
        </span>
        <span class="success" style="color: green; ">
            <?php if (isset($_SESSION['success_color'])) {
                echo $_SESSION['success_color'];
                unset($_SESSION['success_color']);
            }
            ?>
        </span>
    </div>


<?php endif; ?>