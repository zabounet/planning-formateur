<?php $link = "Profil"; ?>

<?php if (isset($_SESSION['formateur']) && !empty($_SESSION['formateur']['id'])) : ?>
    <div class="profile">
        <span>profil</span>

        <div class="info-personel">
            <span class="titre titre-profil">Vos informations personnelles :</span>
            <div class="container-info">

                <form class="profil nom-profil" method="post">
                    <span>Nom :</span>
                    <?php if (str_replace('/planning/public/formateur/profil', '', $_SERVER['REQUEST_URI']) === "?id=1") : ?>
                        <input type='text' name="nom" class="nomProfil" value="<?= $_SESSION['formateur']['nom'] ?>" />
                        <input class="valider" type="submit" id="modifier_nom_formateur" value="Valider" name="modifNom" />
                    <?php else : ?>
                        <span id="prenomProfil"><?= $_SESSION['formateur']['nom'] ?></span>
                        <a href="?id=1">Modifier</a>
                    <?php endif; ?>
                </form>
                <hr>
                <form class="profil prenom-profil" method="post">
                    <span>Prenom :</span>
                    <?php if (str_replace('/planning/public/formateur/profil', '', $_SERVER['REQUEST_URI']) === "?id=2") : ?>
                        <input type='text' name="prenom" class="prenomProfil" value="<?= $_SESSION['formateur']['prenom'] ?>" />
                        <input class="valider" type="submit" id="modifier_prenom_formateur" value="Valider" name="modifPrenom" />
                    <?php else : ?>
                        <span id="prenomProfil"><?= $_SESSION['formateur']['prenom'] ?></span>
                        <a href="?id=2">Modifier</a>
                    <?php endif; ?>
                </form>
                <hr>
                <form class="profil mail-profil" method="post">
                    <span>Mail :</span>
                    <?php if (str_replace('/planning/public/formateur/profil', '', $_SERVER['REQUEST_URI']) === "?id=3") : ?>
                        <input type="email" name="mail" class="mailProfil" value="<?= $_SESSION['formateur']['mail'] ?>" />
                        <input type="submit" id="modifier_mail_formateur" value="Valider" name="modifMail" class="valider" />
                    <?php else : ?>
                        <span id="mailProfil"><?= $_SESSION['formateur']['mail'] ?></span>
                        <a href="?id=3">Modifier</a>
                    <?php endif; ?>
                </form>
                <hr>
                <form class="profil mdp-profil" method="post">

                    <?php if (str_replace('/planning/public/formateur/profil', '', $_SERVER['REQUEST_URI']) === "?id=4") : ?>
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
                        <span>Mot de passe :</span>
                        <span id="mdpProfil">****</span>
                        <a href="?id=4">Modifier</a>
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

    <hr>

    <div class="vacances">
        <span class="vacances-text">Demande de vacances</span>
        <span class="titre titre-demande-vacances">Sélectionnez une période</span>
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
    <hr>
    <div class="teletravail">
        <span class="teletravail-text">Demande de teletravail</span>
        <div class="demande-teletravail">
            <span class="titre titre-demande-teletravai">Selectionnez les jours de la semaine pour teletravail</span>
            <span class="notif notif-demande-teletravail"><i class='fas fa-exclamation-circle' style='font-size:30px;color:red'></i> Vous ne pouvez pas choisir plus de 2 jour par semaine pour le teletravail !!</span>
            <span style="margin-left: 30Px;">Les jours pour teletravail :</span>
            <form method="post" class="container-teletravail">
                <div>
                    <section class="app">
                        <?php
                        $jourSemaine = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi');
                        $jourTeletravail = explode(",", $_SESSION['teletravail']['jour_teletravail']);

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
                </div>
                <div>
                    <input type="submit" value="envoyer la demande" name="jourTeletravail" class="valider">
                </div>
            </form>
            </span>
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
    <div class="profil-text">
        <span>Profil</span>
    </div>
    <div class="info-personel">
        <span class="titre titre-profil">Vos informations personnelles :</span>
        <div class="container-info">

            <form class="profil nom-profil" method="post">
                <span>Nom :</span>
                <?php if (str_replace('/planning/public/formateur/profil', '', $_SERVER['REQUEST_URI']) === "?id=1") : ?>
                    <input type='text' name="nom" class="nomProfil" value="<?= $_SESSION['admin']['nom'] ?>" />
                    <input class="valider" type="submit" id="modifier_nom_formateur" value="Valider" name="modifNom" />
                <?php else : ?>
                    <span id="prenomProfil"><?= $_SESSION['admin']['nom'] ?></span>
                    <a href="?id=1">Modifier</a>
                <?php endif; ?>
            </form>
            <hr>
            <form class="profil prenom-profil" method="post">
                <span>Prenom :</span>
                <?php if (str_replace('/planning/public/formateur/profil', '', $_SERVER['REQUEST_URI']) === "?id=2") : ?>
                    <input type='text' name="prenom" class="prenomProfil" value="<?= $_SESSION['admin']['prenom'] ?>" />
                    <input class="valider" type="submit" id="modifier_prenom_formateur" value="Valider" name="modifPrenom" />
                <?php else : ?>
                    <span id="prenomProfil"><?= $_SESSION['admin']['prenom'] ?></span>
                    <a href="?id=2">Modifier</a>
                <?php endif; ?>
            </form>
            <a href=""></a>
            <hr>
            <form class="profil mail-profil" method="post">
                <span>Mail :</span>
                <?php if (str_replace('/planning/public/formateur/profil', '', $_SERVER['REQUEST_URI']) === "?id=3") : ?>
                    <input type='email' name="mail" class="mailProfil" value="<?= $_SESSION['admin']['mail'] ?>" />
                    <input class="valider" type="submit" id="modifier_mail_formateur" value="Valider" name="modifMail" />
                <?php else : ?>
                    <span id="mailProfil"><?= $_SESSION['admin']['mail'] ?></span>
                    <a href="?id=3">Modifier</a>
                <?php endif; ?>
            </form>
            <hr>
                <form class="profil mdp-profil" method="post">

                    <?php if (str_replace('/planning/public/formateur/profil', '', $_SERVER['REQUEST_URI']) === "?id=4") : ?>
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
                        <span>Mot de passe :</span>
                        <span id="mdpProfil">****</span>
                        <a href="?id=4">Modifier</a>
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
<hr>
    <div class="list-color">
        
        <span class="list-color-text">List color :</span>
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
                        <input type="color" name="couleur_tt" value="<?= $_SESSION['color']['couleur_tt']; ?>" id="">
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