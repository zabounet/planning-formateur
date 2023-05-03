<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $link ;?></title>
    <link rel="stylesheet" href="/planning/Views/assets/css/style.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/styleprofil.css">
    <?php if($link !== "Formation home"): ?>
        <script src="/planning/Views/assets/js/formation.js"></script>
    <?php endif;?>
</head>
<body>

    <header style="width: 100%; height: 150px; background-color: crimson;">
        <nav>
            <ul>
                <?php if($link === "Formation home") : ?>
                    <li><a href="/planning/public">Home</a></li>
                    <li><a href="/planning/public/admin/ajouterFormation">Ajouter une nouvelle formation</a></li>
                <?php else :?>
                    <li><a href="/planning/public/admin/formationsHome">Retour à la liste des formations</a></li>
                <?php endif;?>
            </ul>
        </nav>
    </header>
    <main>
        <div>
            <?= $contenu ;?>
        </div>
    </main>
    <footer style="width: 100%; height: 150px; background-color: crimson;"></footer>
</body>
</html>