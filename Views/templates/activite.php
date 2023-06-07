<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $link; ?></title>
    <link rel="stylesheet" href="/planning/Views/assets/css/fonts.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/style.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/header.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/burger.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/activiter.css">
    <script src="/planning/Views/assets/js/header.js"></script>
    <script src="/planning/Views/assets/js/table.js"></script>
</head>

<body>

    <header class="big">
        <div class="header-content">
            <div class="nav-content menu">
                <button class="nav-button burger-button">
                    <span class="burger-box">
                        <span class="burger">

                        </span>
                    </span>
                </button>
                <nav id="dropnav" class="dropmenu">
                    <ul>
                        <?php if ($link !== "Formateur home") : ?>
                            <li><a href="/planning/public">Home</a></li>
                            <li><a href="/planning/public/index.php?p=formateur/profil">Profil</a></li>
                            <li><a href="/planning/public/index.php?p=admin/formateursHome">Gérer les formateurs</a></li>
                            <li><a href="/planning/public/index.php?p=admin/formationsHome">Gérer les formations</a></li>
                        <?php else : ?>
                            <li><a href="/planning/public/index.php?p=admin/formateursHome">Retour à la liste des formateurs</a></li>
                        <?php endif; ?>
                        <li><a href="/planning/public/index.php?p=formateur/logout">Deconnexion</a></li>
                    </ul>
                </nav>
            </div>
            <form class="activite-form" method="post">
                <div id="part1">
                    <label for="date_debut" id="debut">Début :
                        <input required type="date" name="date_debut" id="date_debut" <?php if (isset($data['date_debut'])) {
                                                                                            echo 'value="' . $data['date_debut'] . '"';
                                                                                        }  ?>></label>
                    <label for="date_fin" id="fin">Fin :
                        <input required type="date" name="date_fin" id="date_fin" <?php if (isset($data['date_fin'])) {
                                                                                        echo 'value="' . $data['date_fin'] . '"';
                                                                                    } ?>></label>

                    <input id="submit-btn" type="submit" value="envoyer" name="valider">
                    <span id="advanced">Recherche avancée</span>
                </div>
                <div id="part2" class="dropmenu">
                    <div class="sect">
                        <h2>Selectionnez un ou plusieurs formateurs</h2>
                        <div class="formateurs" id="liste">
                            <?php $nombre = 0;
                            foreach ($infosFormateur['Formateurs'] as $formateur) : ?>
                                <?php if ($formateur->id_formateur == 2) {
                                    continue;
                                }; ?>
                                <?php if (empty($_POST)) : ?>
                                    <label for="formateurs">
                                        <input checked type="checkbox" value="<?= $formateur->id_formateur ?>" name="formateurs[]"><span> <?= strtoupper($formateur->nom_formateur) . ' ' . $formateur->prenom_formateur ?></span>
                                        <span class="checkmark"></span>
                                    </label>
                                <?php elseif (!empty($_POST) && in_array($formateur->id_formateur, $data['formateurs'])) : ?>
                                    <label for="formateurs">
                                        <input checked type="checkbox" value="<?= $formateur->id_formateur ?>" name="formateurs[]"><span> <?= strtoupper($formateur->nom_formateur) . ' ' . $formateur->prenom_formateur ?></span>
                                        <span class="checkmark"></span>
                                    </label>
                                <?php else : ?>
                                    <label for="formateurs">
                                        <input type="checkbox" value="<?= $formateur->id_formateur ?>" name="formateurs[]"><span> <?= strtoupper($formateur->nom_formateur) . ' ' . $formateur->prenom_formateur ?></span>
                                        <span class="checkmark"></span>
                                    </label>
                                <?php endif; ?>
                            <?php $nombre++;
                            endforeach ?>
                            <button type="button" id="checkFormateurs">Cocher/décocher tout</button>
                            <input type="hidden" name="nbFormateurs" value="<?= $nombre; ?>">
                        </div>
                    </div>
                </div>
            </form>
            <img class="flower-img" src="/planning/Views/assets/image/flower.svg">
        </div>
        <div class="legend">
            <ul class="list-color">
                <li class="color"><span>Présentiel</span>
                    <div style="background-color:<?= $_SESSION['color']['couleur_centre']; ?>;"></div>
                </li>
                <li class="color"><span>Autre</span>
                    <div style="background-color:<?= $_SESSION['color']['couleur_autre']; ?>;"></div>
                </li>
                <li class="color"><span>Vacs attente</span>
                    <div style="background-color:<?= $_SESSION['color']['couleur_vacance_demandees']; ?>;"></div>
                </li>
                <li class="color"><span>Vacs ok</span>
                    <div style="background-color:<?= $_SESSION['color']['couleur_vacance_validee']; ?>;"></div>
                </li>
                <li class="color"><span>Férié</span>
                    <div style="background-color:<?= $_SESSION['color']['couleur_ferie']; ?>;"></div>
                </li>
                <li class="color"><span>Week-end</span>
                    <div style="background-color:<?= $_SESSION['color']['couleur_weekend']; ?>;"></div>
                </li>
                <li class="color"><span>MNSP</span>
                    <div style="background-color:<?= $_SESSION['color']['couleur_MNSP']; ?>;"></div>
                </li>
                <li class="color"><span>Perf</span>
                    <div style="background-color:<?= $_SESSION['color']['couleur_perfectionment']; ?>;"></div>
                </li>
            </ul>
        </div>
    </header>
    <main>
        <div>
            <?= $contenu; ?>
        </div>
    </main>
</body>

</html>