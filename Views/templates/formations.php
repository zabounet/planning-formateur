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
    if (!isset($infosCurrent)) $infosCurrent['acronyme_formation'] = "";

    if ($link === "Formation home") {
        echo '<link rel="stylesheet" href="/planning/Views/assets/css/searchbar.css">';
    }
    if ($link === "Ajouter une formation" || $link === "Modifier la formation " . $infosCurrent['acronyme_formation']) {
        echo '<link rel="stylesheet" href="/planning/Views/assets/css/formations.css">';
    }
    if ($link === "Ajouter une formation" || $link === "Modifier la formation " . $infosCurrent['acronyme_formation']) {
        echo '<script src="/planning/Views/assets/js/formation.js"></script>';
    }; ?>
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
                    <li><a href="/planning/public/formateur/profil">Profil </a></li>
                    <li><a href="/planning/public/admin/formateursHome">Gérer les formateurs</a></li>
                    <?php if($link === "Formation home"):?>
                        <li><a href="/planning/public/admin/ajouterFormation">Ajouter une nouvelle formation</a></li>
                    <?php else:?>
                        <li><a href="/planning/public/admin/formationsHome">Retourner au menu des formations</a></li>
                    <?php endif ;?>
                    <li><a href="/planning/public/formateur/logout">Deconnexion</a></li>
            </nav>
        </div>
    </header>
    <main <?php if(in_array($link, ["Ajouter une formation","Modifier la formation " . $infosCurrent['acronyme_formation']])): echo "class='fixed-height'";?><?php endif;?>>
        <?= $contenu; ?>
    </main>
</body>

</html>