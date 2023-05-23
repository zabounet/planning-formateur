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
                            <li><a href="/planning/public/formateur/profil">Profil</a></li>
                            <li><a href="/planning/public/admin/formateurHome">Gérer les formateurs</a></li>
                            <li><a href="/planning/public/admin/formationHome">Gérer les formations</a></li>
                        <?php else : ?>
                            <li><a href="/planning/public/admin/formateursHome">Retour à la liste des formateurs</a></li>
                        <?php endif; ?>
                            <li><a href="/planning/public/formateur/logout">Deconnexion</a></li>
                    </ul>
                </nav>
            </div>
            <form class="activite-form" method="post">
                <input required type="date" name="date_debut" id="date_debut" <?php if (isset($data['date_debut'])) {
                                                                                    echo 'value="' . $data['date_debut'] . '"';
                                                                                }  ?>>
                <input required type="date" name="date_fin" id="date_fin" <?php if (isset($data['date_fin'])) {
                                                                                echo 'value="' . $data['date_fin'] . '"';
                                                                            } ?>>
                <label for="referent-formateur"> Formateur :
                    <?php
                    $iterations = 0;
                    foreach ($infosFormateur['Formateurs'] as $formateurs) :
                        if ($formateurs->id_formateur == 1 || $formateurs->id_formateur == 2) {
                            continue;
                        };
                    ?>
                        <?php if (empty($_POST)) : ?>
                            <input class="formateurCheckbox" checked type="checkbox" value="<?= $formateurs->id_formateur ?>" name="formateurs[]"> <?= strtoupper($formateurs->nom_formateur) . ' ' . $formateurs->prenom_formateur ?>
                        <?php elseif (!empty($_POST) && !empty($_POST['formateurs']) && in_array($formateurs->id_formateur, $data['formateurs'])) : ?>
                            <input class="formateurCheckbox" checked type="checkbox" value="<?= $formateurs->id_formateur ?>" name="formateurs[]"> <?= strtoupper($formateurs->nom_formateur) . ' ' . $formateurs->prenom_formateur ?>
                        <?php else : ?>
                            <input class="formateurCheckbox" type="checkbox" value="<?= $formateurs->id_formateur ?>" name="formateurs[]"> <?= strtoupper($formateurs->nom_formateur) . ' ' . $formateurs->prenom_formateur ?>
                        <?php endif; ?>
                    <?php
                        $iterations++;
                    endforeach;
                    ?>
                    <input type="hidden" name="nbFormateur" value="<?= $iterations; ?>">
                </label>
                <input id="submit-btn" type="submit" value="envoyer" name="valider">
            </form>
            <img src="/planning/Views/assets/image/flower.svg">
        </div>
    </header>
    <main>
        <div>
            <?= $contenu; ?>
        </div>
    </main>
</body>

</html>