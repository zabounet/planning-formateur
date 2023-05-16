<?php $link = "Profil"; ?>

<?php if (isset($_SESSION['formateur']) && !empty($_SESSION['formateur']['id'])) : ?>
    <div class="profil">
        <span>profil</span>

        <div class="info-personel">
            <span class="titre titre-profil">Vos informations personnelles :</span>
            <div class="container-info">

                <form class="profil nom-profil" method="post">
                    <span>Nom :</span>
                    <?php if (str_replace('/planning/public/formateur/profil', '', $_SERVER['REQUEST_URI']) === "?id=1") : ?>
                        <input type='text' name="nom" class="nomProfil" value="<?= $_SESSION['formateur']['nom'] ?>" />
                        <input type="submit" id="modifier_nom_formateur" value="Valider" name="modifNom" />
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
                        <input type="submit" id="modifier_prenom_formateur" value="Valider" name="modifPrenom" />
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
                        <input type="submit" id="modifier_mail_formateur" value="Valider" name="modifMail" />
                    <?php else : ?>
                        <span id="mailProfil"><?= $_SESSION['formateur']['mail'] ?></span>
                        <a href="?id=3">Modifier</a>
                    <?php endif; ?>
                </form>
                <hr>
                <form class="profil mdp-profil" method="post">

                    <?php if (str_replace('/planning/public/formateur/profil', '', $_SERVER['REQUEST_URI']) === "?id=4") : ?>
                        <span>Saisir votre mot de passe actuel :</span>
                        <input type="password" name="current_mdp" class="mdpProfil" value="" />
                        <span>Saisir nouveau mot de passe :</span>
                        <input type="password" name="new_mdp" class="mdpProfil" value="" />
                        <span>Saisir confirmation du nouveau mot de passe :</span>
                        <input type="password" name="conf_new_mdp" class="mdpProfil" value="" />
                        <input type="submit" id="modifier_mdp_formateur" value="valider" name="verifierMdp" />
                    <?php else : ?>
                        <span>Mot de passe :</span>
                        <span id="mdpProfil">****</span>
                        <a href="?id=4">Modifier</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>



    <div>
        <span class="vacances">Demande de vacances</span>
        <div class="demande-vacances">
            <span class="titre titre-demande-vacances">Sélectionnez une période</span>
            <form method="POST" class="container-vacances">
                <div class="date-demande-vacances">
                    <div class="date date-debut date-debut-vacance">
                        <p>Date de début</p>
                        <input type="date" name="date_debut" id="" min="<?= date('Y-m-d'); ?>">
                        <div>Calendrier</div>
                    </div>
                    <hr>
                    <div class="date date-fin date-fin-vacance">
                        <p>Date de fin</p>
                        <input type="date" name="date_fin" id="">
                        <div>Calendrier</div>
                    </div>
                </div>
                <div class="btn btn-validation-vacance">
                    <input type="submit" value="envoyer la demande" name="vacances">
                </div>
            </form>
        </div>
    </div>

    <div>
        <span class="teletravail">Demande de teletravail</span>
        <div class="demande-teletravail">
            <span class="titre titre-demande-teletravai">Selectionnez les jours de la semaine pour teletravail</span>
            <span class="notif notif-demande-teletravail">Vous ne pouvez pas choisir plus de 2 jour par semaine pour le teletravail !!</span>
            <p>Les jours pour teletravail :</p>
            <form method="post" class="container-teletravail">
                <div>
                    <section class="app">
                        <article class="feature1">
                            <input type="checkbox" id="lundi" name="lundi" />
                            <div>
                                <span>
                                    Lundi
                                </span>
                            </div>
                        </article>
                        <article class="feature2">
                            <input type="checkbox" id="mardi" name="mardi" />
                            <div>
                                <span>
                                    Mardi
                                </span>
                            </div>
                        </article>
                        <article class="feature3">
                            <input type="checkbox" id="mercredi" name="mercredi" />
                            <div>
                                <span>
                                    Mercredi
                                </span>
                            </div>
                        </article>
                        <article class="feature4">
                            <input type="checkbox" id="jeudi" name="jeudi" />
                            <div>
                                <span>
                                    Jeudi
                                </span>
                            </div>
                        </article>
                        <article class="feature5">
                            <input type="checkbox" id="vendredi" name="vendredi" />
                            <div>
                                <span>
                                    Vendredi
                                </span>
                            </div>
                        </article>
                    </section>
                </div>
                <div>
                    <input type="submit" value="envoyer la demande" name="jourTeletravail">
                </div>
            </form>

        </div>
    </div>

    <!-- profil admin -->
<?php elseif (isset($_SESSION['admin']) && !empty($_SESSION['admin']['id'])) : ?>

    <span class="profil-text">Profil</span>
    <hr>
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
                    <input type='text' name="mail" class="mailProfil" value="<?= $_SESSION['admin']['mail'] ?>" />
                    <input class="valider" type="submit" id="modifier_mail_formateur" value="Valider" name="modifMail" />
                <?php else : ?>
                    <span id="mailProfil"><?= $_SESSION['admin']['mail'] ?></span>
                    <a href="?id=3">Modifier</a>
                <?php endif; ?>
            </form>
        </div>
    </div>


    <form method="POST" name="list-color">
        <hr>
        <span class="titre">Changer la couleur des informations apparaissant sur le calendrier</span>
        <div class="list-color">
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
                    <span>Itinerant</span>
                    <input type="color" name="itinerant" value="<?= $_SESSION['color']['couleur_itinerant']; ?>" id="">
                </div>
            </div>
        </div>
        <input class="valider" type="submit" value="valider" name="send-color">
    </form>


<?php endif; ?>
<div>
    <span style="color:red;">
        <?php if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
        ?>
    </span>
</div>
<div>
    <span style="color:green;">
        <?php if (isset($_SESSION['success'])) {
            echo $_SESSION['success'];
            unset($_SESSION['success']);
        }
        ?>
    </span>
</div>