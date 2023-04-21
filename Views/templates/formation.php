<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="/planning/Views/assets/js/formation.js"></script>
</head>
<body>

        <nav>
            <ul>

                <?php if(isset($_SESSION['formateur']) && !empty($_SESSION['formateur']['id']) || isset($_SESSION['admin']) && !empty($_SESSION['admin']['id'])):?>
                    <li><a href="/planning/public/Participant/profil">Profil </a></li>
                    <li><a href="/planning/public/formateur/logout">logout</a></li>

                <?php else :?>
                    <li><a href="/planning/public/Participant/register">Incription </a></li>
                    <li><a href="/planning/public/formateur/login">Login </a></li>
                <?php endif;?>

            </ul>
        </nav>
    </header>
    <main>
        <div>
            <?= $contenu ;?>
        </div>
    </main>

</body>
</html>