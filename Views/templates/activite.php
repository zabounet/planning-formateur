<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $link; ?></title>
    <link rel="stylesheet" href="/planning/Views/assets/css/fonts.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/style.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/activiter.css?" <?= time(); ?>>
    <script src="/planning/Views/assets/js/header.js?" <?= time(); ?>></script>
</head>

<body>

    <header>
        <div class="header-content">
            <div class="nav-content">
                <button class="burger-button">
                    <span class="burger-box">
                        <span class="burger">

                        </span>
                    </span>
                </button>
                <nav id="dropnav">
                    <ul>
                        <?php if ($link !== "Formateur home") : ?>
                            <li><a href="/planning/public">Home</a></li>
                            <li><a href="/planning/public/formateur/profil">Profile</a></li>
                            <li><a href="/planning/public/admin/formateurHome">Formateurs</a></li>
                            <li><a href="/planning/public/admin/formationHome">Formations</a></li>
                        <?php else : ?>
                            <li><a href="/planning/public/admin/formateursHome">Retour à la liste des formateurs</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <form method="post">
                <input type="date" name="date_debut" id="date_debut">
                <input type="date" name="date_fin" id="date_fin">
                <label for="referent-formateur"> Formateur :
                    <?php
                    $iterations = 0;
                    foreach ($infosFormateur['Formateurs'] as $formateurs) {
                        if ($iterations == 0 || $iterations == 1) {
                            $iterations++;
                            continue;
                        };
                    ?>
                        <label for="formateur"><?= $formateurs->nom_formateur . ' ' . $formateurs->prenom_formateur; ?></label>
                        <input type="checkbox" name="formateur[]" value="<?= $formateurs->id_formateur; ?>" />
                    <?php
                        $iterations++;
                    };
                    ?>
                </label>
                <input type="submit" value="envoyer" name="valider">
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