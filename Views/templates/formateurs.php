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
    if(!isset($infosCurrent))$infosCurrent = [];
    
    if ($link === "Activité des formateurs") {
        echo '<link rel="stylesheet" href="/planning/Views/assets/css/activiter.css">';
    }

    if ($link === "Formateur home") {
        echo '<link rel="stylesheet" href="/planning/Views/assets/css/searchbar.css">';
    }

    if ($link !== "Modifier " . $infosCurrent[0]->prenom_formateur . " " . $infosCurrent[0]->nom_formateur || $link === "Inscripton formateur") {
        echo '<script src="/planning/Views/assets/js/formateur.js"></script>';
    }; ?>
</head>

<body>

    <header>
        <nav>
            <ul>
                <?php if ($link === "Formateur home") : ?>
                    <li><a href="/planning/public">Home</a></li>
                    <li><a href="/planning/public/admin/activiteFormateurs">Consulter l'activité des formateurs</a></li>
                    <li><a href="/planning/public/admin/inscriptionFormateur">Ajouter un formateur</a></li>
                <?php else : ?>
                    <li><a href="/planning/public/admin/formateursHome">Retour à la liste des formateurs</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <div>
            <?= $contenu; ?>
        </div>
    </main>
</body>

</html>