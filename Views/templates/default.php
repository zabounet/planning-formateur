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
    <?php if ($link === 'Profil') : ?>
        <link rel="stylesheet" href="/planning/Views/assets/css/profil.css">
    <?php endif; ?>
    <script src="/planning/Views/assets/js/header.js"></script>
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
    </header>
    <main>
        <div class="container-contenu">
            <?= $contenu; ?>
        </div>
    </main>
</body>

</html>