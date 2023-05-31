<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $link; ?></title>
    <link rel="stylesheet" href="/planning/Views/assets/css/fonts.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/style.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/side-burger.css">
    <script src="/planning/Views/assets/js/header.js"></script>

    <?php

    if ($link === "Activité des formateurs") {
        echo '<link rel="stylesheet" href="/planning/Views/assets/css/activiter.css">';
    }
    if ($link === "Profil") {
        echo '<link rel="stylesheet" href="/planning/Views/assets/css/styleprofil.css">';
    }
    if ($link === "Formateur home") {
        echo '<link rel="stylesheet" href="/planning/Views/assets/css/searchbar.css">';
        echo '<link rel="stylesheet" href="/planning/Views/assets/css/homeS.css">';
        echo '<script src="/planning/Views/assets/js/deleteHomeS.js"></script>';
    }
    if($link === "Inscription formateur"){
        echo '<script src="/planning/Views/assets/js/formateur.js"></script>'; 
        echo '<link rel="stylesheet" href="/planning/Views/assets/css/formateurs.css">';
    }
    if (isset($infosCurrent)) {
        if ($link === "Modifier " . $infosCurrent[0]->prenom_formateur . " " . $infosCurrent[0]->nom_formateur) {
            echo '<script src="/planning/Views/assets/js/formateur.js"></script>';
            echo '<link rel="stylesheet" href="/planning/Views/assets/css/formateurs.css">';
        };
    };

    ?>
</head>

<body>
    <header>
        <div class="menu nav-content">
            <button class="nav-button burger-button">
                <span class="burger-box">
                    <span class="burger">

                    </span>
                </span>
            </button>
            <nav id="dropnav" class="dropmenu">
                <ul>
                    <li><a href="/planning/public/">Home</a></li>
                    <li><a href="/planning/public/index.php?p=formateur/profil">Profil </a></li>
                    <?php if($link === "Formateur home"):?>
                        <li><a href="/planning/public/index.php?p=admin/inscriptionFormateur">Inscrire un nouveau formateur</a></li>
                        <li><a href="/planning/public/index.php?p=admin/activiteFormateurs">Consulter l'activité des formateurs</a></li>
                    <?php elseif (isset($infosCurrent) && $link === "Modifier " . $infosCurrent[0]->prenom_formateur . " " . $infosCurrent[0]->nom_formateur) : ?>
                        <li><a href="/planning/public/index.php?p=admin/formateursHome">Retourner à la liste des formateurs</a></li>
                    <?php endif; ?>
                    <li><a href="/planning/public/index.php?p=admin/formationsHome">Gérer les formations</a></li>
                    <li><a href="/planning/public/index.php?p=formateur/logout">Deconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div>
            <?= $contenu; ?>
        </div>
    </main>
</body>

</html>