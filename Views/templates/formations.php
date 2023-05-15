<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $link; ?></title>
    <link rel="stylesheet" href="/planning/Views/assets/css/fonts.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/style.css">
    <?php
    if(!isset($infosCurrent))$infosCurrent['acronyme_formation'] = "";

    if ($link === "Formateur home") {
        echo '<link rel="stylesheet" href="/planning/Views/assets/css/searchbar.css">';
    }
    if ($link === "Profil") {
        echo '<link rel="stylesheet" href="/planning/Views/assets/css/styleprofil.css">';
    }
    if ($link === "Ajouter une formation" || $link === "Modifier la formation " . $infosCurrent['acronyme_formation']) {
        echo '<link rel="stylesheet" href="/planning/Views/assets/css/formations.css?' . time() . '">' ;
    }
    if ($link === "Ajouter une formation" || $link === "Modifier la formation " . $infosCurrent['acronyme_formation']) {
        echo '<script src="/planning/Views/assets/js/formation.js?' . time() . '"></script>';
    }; ?>
</head>

<body>

    <header>
        <nav>
            <ul>
                <?php if ($link === "Formation home") : ?>
                    <li><a href="/planning/public">Home</a></li>
                    <li><a href="/planning/public/admin/ajouterFormation">Ajouter une nouvelle formation</a></li>
                <?php else : ?>
                    <li><a href="/planning/public/admin/formationsHome">Retour à la liste des formations</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <?= $contenu; ?>
    </main>
</body>

</html>