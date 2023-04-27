<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/planning/Views/assets/css/style.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/styleprofil.css">
    <script src="/planning/Views/assets/js/formation.js"></script>
</head>
<body>

    <header style="width: 100%; height: 150px; background-color: crimson;">
        <nav>
            <ul>
                <li><a href="/planning/public">Home</a></li>
                <li><a href="/planning/public/admin/activiteFormateurs">Consulter l'activité des formateurs</a></li>
                <li><a href="/planning/public/admin/ajouterFormateurs">Ajouter un formateur</a></li>
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