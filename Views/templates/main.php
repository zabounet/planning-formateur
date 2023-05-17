<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $link; ?></title>
    <link rel="stylesheet" href="/planning/Views/assets/css/fonts.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/style.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/activiter.css">
    <script src="/planning/Views/assets/js/header.js"></script>
</head>

<body>
    <header>
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
                        <?php if (isset($_SESSION['formateur']) && !empty($_SESSION['formateur']['id'])) : ?>
                            <li><a href="/planning/public/">Home</a></li>
                            <li><a href="/planning/public/formateur/profil">Profil </a></li>
                            <li><a href="/planning/public/formateur/logout">Deconnexion</a></li>

                        <?php elseif (isset($_SESSION['admin']) && !empty($_SESSION['admin']['id'])) : ?>
                            <li><a href="/planning/public/">Home</a></li>
                            <li><a href="/planning/public/formateur/profil">Profil </a></li>
                            <li><a href="/planning/public/formateur/logout">Deconnexion</a></li>
                            <li><a href="/planning/public/admin/formationsHome">Gérer les formations</a></li>
                            <li><a href="/planning/public/admin/formateursHome">Gérer les formateurs</a></li>

                        <?php else : ?>
                            <li><a href="/planning/public/formateur/login">Login </a></li>

                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <div class="alert-menu menu">
                <button class="nav-button bell-button">
                    <div class="bell-box">
                        <img class="bell-img" src="/planning/Views/assets/image/bell.svg" alt="">
                        <?php // if($notifications) : 
                        ?>
                        <span class="badge">1</span>
                        <?php // endif; 
                        ?>
                    </div>
                </button>
                <menu id="dropmenu" class="dropmenu">
                    <ul>
                        <?php // foreach($a as $b) :
                        ?>
                        <!--  -->
                        <?php // endforeach;
                        ?>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                    </ul>
                </menu>
            </div>
            <form class="main-form" method="post">
                <div id="part1" id="debut">
                    <label for="date_debut">Début : 
                        <input type="date" name="date_debut" <?php if (isset($data['date_debut'])) {
                                                                            echo 'value="' . $data['date_debut'] . '"';
                                                                        }  ?>>
                    </label>
                    <label for="date_fin" id="fin">Fin : 
                        <input type="date" name="date_fin" <?php if (isset($data['date_fin'])) {
                                                                        echo 'value="' . $data['date_fin'] . '"';
                                                                    } ?>>
                    </label>
                    <select name="lieu" id="ville">
                        <?php if (empty($_POST)) : ?>
                            <option selected value="default">Blois - Tours</option>
                        <?php else : ?>
                            <option value="default">Blois - Tours</option>
                        <?php endif; ?>
                        <?php foreach ($villes as $ville) : ?>
                            <?php if (empty($_POST)) : ?>
                                <option value="<?= $ville->id_ville ?>"> <?= $ville->nom_ville; ?> </option>
                            <?php elseif (!empty($_POST) && isset($data['lieu'])) : ?>
                                <option <?php if (($data['lieu']) == $ville->id_ville) {
                                            echo "selected";
                                        } ?> value="<?= $ville->id_ville ?>"><?= $ville->nom_ville ?></option>
                            <?php endif; ?>
                        <?php endforeach ?>
                    </select>
                    <div class="grid-filling1"></div>
                    <div class="grid-filling2"></div>
                    <input id="submit" type="submit" name="rechercher" value="rechercher">
                    <span id="advanced">Recherche avancée</span>
                    <div class="grid-filling3"></div>
                    <div class="grid-filling4"></div>
                </div>

                <div id="part2" class="dropmenu">
                    <div class="shadow"></div>
                    <div class="sect">
                        <h2>Selectionnez un ou plusieurs GRN</h2>
                        <div class="grns">
                            <?php $nb = 0;
                            foreach ($GRNs as $GRN) : ?>
                                <?php if (empty($_POST)) : ?>
                                    <label for="grns">
                                        <input checked type="checkbox" value="<?= $GRN->numero_grn ?>" name="grns[]"><span> <?= $GRN->numero_grn . ' - ' . $GRN->nom_grn ?></span>
                                        <span class="checkmark"></span>
                                    </label>
                                <?php elseif (!empty($_POST) && in_array($GRN->numero_grn, $data['grns'])) : ?>
                                    <label for="grns">
                                        <input checked type="checkbox" value="<?= $GRN->numero_grn ?>" name="grns[]"><span> <?= $GRN->numero_grn . ' - ' . $GRN->nom_grn ?></span>
                                        <span class="checkmark"></span>
                                    </label>
                                <?php else : ?>
                                    <label for="grns">
                                        <input type="checkbox" value="<?= $GRN->numero_grn ?>" name="grns[]"><span> <?= $GRN->numero_grn . ' - ' . $GRN->nom_grn ?></span>
                                        <span class="checkmark"></span>
                                    </label>
                                <?php endif; ?>
                            <?php $nb++;
                            endforeach ?>
                            <input type="hidden" name="nbGRNs" value="<?= $nb; ?>">
                        </div>
                    </div>

                    <div class="sect">
                        <h2>Selectionnez un ou plusieurs formateurs</h2>
                        <div class="formateurs">
                            <?php $nombre = 0;
                            foreach ($formateurs['Formateurs'] as $formateur) : ?>
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
                            <input type="hidden" name="nbFormateurs" value="<?= $nombre; ?>">
                        </div>
                    </div>
                </div>
            </form>
            <img onload="<?php if (!empty($data)) : ?> spin() <?php endif; ?>" class="flower-img" src="/planning/Views/assets/image/flower.svg">
        </div>
    </header>
    <main>
        <div>
            <?= $contenu; ?>
        </div>
    </main>
</body>

</html>