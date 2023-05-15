<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $link; ?></title>
    <link rel="stylesheet" href="/planning/Views/assets/css/fonts.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/style.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/activiter.css">
</head>

<body>

    <header>
        <nav>
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
        <div>
            <div>
                <img src="/planning/Views/assets/image/bell.svg" alt="">
            </div>
            <div>
                <form method="post">
                    <div>
                        <div>
                            <label for="">periode du</label>
                            <input type="date" name="date_debut" <?php if (isset($data['date_debut'])) {echo 'value="' . $data['date_debut'] . '"'; }  ?>>
                            <label for="">au</label>
                            <input type="date" name="date_fin" <?php if (isset($data['date_fin'])) {echo 'value="' . $data['date_fin'] . '"'; } ?>>
                            <select name="lieu" id="">
                                <?php if (empty($_POST)):?>
                                    <option selected value="default">Blois - Tours</option>
                                <?php else :?>   
                                    <option value="default">Blois - Tours</option>
                                <?php endif;?>
                                <?php foreach ($villes as $ville) : ?>
                                    <?php if (empty($_POST)): ?>
                                        <option value="<?= $ville->id_ville ?>"> <?= $ville->nom_ville ;?> </option>
                                    <?php elseif(!empty($_POST) && isset($data['lieu'])) : ?>
                                        <option <?php if (($data['lieu']) == $ville->id_ville) { echo "selected"; } ?> value="<?= $ville->id_ville ?>"><?= $ville->nom_ville ?></option>
                                    <?php endif;?>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div>


                            <div>
                                <label for="">GRN : </label>
                                <?php $nb = 0;
                                foreach ($GRNs as $GRN) : ?>
                                    <?php if (empty($_POST)) : ?>
                                        <input checked type="checkbox" value="<?= $GRN->numero_grn ?>" name="grns[]"> <?= $GRN->numero_grn . ' - ' . $GRN->nom_grn ?>
                                    <?php elseif(!empty($_POST) && in_array($GRN->numero_grn, $data['grns'])) : ?>
                                        <input checked type="checkbox" value="<?= $GRN->numero_grn ?>" name="grns[]"> <?= $GRN->numero_grn . ' - ' . $GRN->nom_grn ?>
                                    <?php else : ?>
                                        <input type="checkbox" value="<?= $GRN->numero_grn ?>" name="grns[]"> <?= $GRN->numero_grn . ' - ' . $GRN->nom_grn ?>
                                    <?php endif; ?>
                                <?php $nb++;
                                endforeach ?>
                                <input type="hidden" name="nbGRNs" value="<?= $nb; ?>">
                            </div>

                            <div>
                                <label for="">Formateur : </label>
                                <?php $nombre = 0;
                                foreach ($formateurs['Formateurs'] as $formateur) : ?>
                                    <?php if ($formateur->id_formateur == 2) {
                                        continue;
                                    }; ?>
                                    <?php if (empty($_POST)) :?>
                                        <input checked type="checkbox" value="<?= $formateur->id_formateur ?>" name="formateurs[]"> <?= strtoupper($formateur->nom_formateur) . ' ' . $formateur->prenom_formateur ?>
                                    <?php elseif(!empty($_POST) && in_array($formateur->id_formateur, $data['formateurs'])) : ?>
                                        <input checked type="checkbox" value="<?= $formateur->id_formateur ?>" name="formateurs[]"> <?= strtoupper($formateur->nom_formateur) . ' ' . $formateur->prenom_formateur ?>
                                    <?php else : ?>
                                        <input type="checkbox" value="<?= $formateur->id_formateur ?>" name="formateurs[]"> <?= strtoupper($formateur->nom_formateur) . ' ' . $formateur->prenom_formateur ?>
                                    <?php endif; ?>
                                <?php $nombre++;
                                endforeach ?>
                                <input type="hidden" name="nbFormateurs" value="<?= $nombre; ?>">
                            </div>
                        </div>
                    </div>
                    <input type="submit" name="rechercher" value="rechercher">
                </form>
            </div>
            <div></div>
        </div>
    </header>
    <main>
        <div>
            <?= $contenu; ?>
        </div>
    </main>
</body>

</html>