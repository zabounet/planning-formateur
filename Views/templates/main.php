<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $link; ?></title>
    <link rel="stylesheet" href="/planning/Views/assets/css/fonts.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/style.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/header.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/burger.css">
    <link rel="stylesheet" href="/planning/Views/assets/css/activiter.css">
    <script src="/planning/Views/assets/js/header.js"></script>
    <script src="/planning/Views/assets/js/table.js"></script>
</head>

<body>
    <header class="big">
        <div class="header-content">
            <div class="nav-content menu">
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
                            <li><a href="/planning/public/index.php?p=formateur/profil">Profil </a></li>
                            <li><a href="/planning/public/index.php?p=formateur/logout">Deconnexion</a></li>

                        <?php elseif (isset($_SESSION['admin']) && !empty($_SESSION['admin']['id'])) : ?>
                            <li><a href="/planning/public/">Home</a></li>
                            <li><a href="/planning/public/index.php?p=formateur/profil">Profil </a></li>
                            <li><a href="/planning/public/index.php?p=admin/formationsHome">Gérer les formations</a></li>
                            <li><a href="/planning/public/index.php?p=admin/formateursHome">Gérer les formateurs</a></li>
                            <li><a href="/planning/public/index.php?p=formateur/logout">Deconnexion</a></li>

                        <?php else : ?>
                            <li><a href="/planning/public/index.php?p=formateur/login">Login </a></li>

                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <div class="alert-menu menu">
                <button class="nav-button bell-button">
                    <div class="bell-box">
                        <?php if(count($notifs) > 0):?>
                            <img class="bell-img" src="/planning/Views/assets/image/ringing-bell.svg" alt="">
                            <span class="badge"><?php if(count($notifs) > 9) echo "9+"; else{echo count($notifs);}?></span>
                        <?php else:?>
                            <img class="bell-img" src="/planning/Views/assets/image/bell.svg" alt="">
                        <?php endif;?>
                    </div>
                </button>
                <menu id="dropmenu" class="dropmenu drop-notif">
                    <ul>
                        <?php foreach($notifs as $notification) :?>
                            <li>
                                <span><?= strtoupper($notification->nom_formateur). " ". ucfirst($notification->prenom_formateur) . " " . $notification->description_notification;?> 
                                </span>
                                <div class="notif-linge">
                                    <div class="btns">
                                        <?php if(isset($_SESSION['admin'])):?>
                                            <form method="post">
                                                <input type="hidden" name="formateur" value="<?=$notification->id_formateur;?>">    
                                                <input type="hidden" name="notification" value="<?=$notification->id_notification;?>">    
                                                <input type="hidden" name="type" value="<?=$notification->type;?>">   
                                                <input type="hidden" name="date" value="<?=$notification->date;?>"> 
                                                <input class="btn valider" id="submit" type="submit" name="valider" value="Valider">
                                            </form>
                                            <form method="post">
                                                <input type="hidden" name="formateur" value="<?=$notification->id_formateur;?>">    
                                                <input type="hidden" name="notification" value="<?=$notification->id_notification;?>">    
                                                <input type="hidden" name="type" value="<?=$notification->type;?>"> 
                                                <input type="hidden" name="date" value="<?=$notification->date;?>">   
                                                <input class="btn refuser" id="submit" type="submit" name="refuser" value="Refuser">
                                            </form>
                                        </div>
                                        <b>Le : <?= date('d-m-Y', strtotime($notification->date_notification)) ;?></b>
                                    <?php elseif(isset($_SESSION['formateur'])):?>
                                        <form method="post">
                                            <input type="hidden" name="notification" value="<?=$notification->id_notification;?>">    
                                            <input class="btn valider" id="submit" type="submit" name="accept" value="OK">
                                        </form>
                                    <?php endif;?>
                                </div>
                            </li>
                        <?php endforeach;?>
                        <?php if(count($notifs) < 1){echo "<li><span> Rien à signaler ! </span></li>";};?>
                    </ul>
                </menu>
            </div>
            <form class="main-form" method="post">
                <div id="part1" id="debut">
                    <label for="date_debut">Début :
                        <input required type="date" name="date_debut" <?php if (isset($data['date_debut'])) {
                                                                            echo 'value="' . $data['date_debut'] . '"';
                                                                        }  ?>>
                    </label>
                    <label for="date_fin" id="fin">Fin :
                        <input required type="date" name="date_fin" <?php if (isset($data['date_fin'])) {
                                                                        echo 'value="' . $data['date_fin'] . '"';
                                                                    } ?>>
                    </label>
                    <select name="lieu" id="ville">
                        <?php if (empty($_POST)) : ?>
                            <option selected value="default">Blois - Tours</option>
                        <?php else : ?>
                            <option value="default">Blois - Tours</option>
                        <?php endif; ?>
                        <?php foreach ($villes as $ville) : ?>
                            <?php if (empty($_POST)) : ?>
                                <option value="<?= $ville->id_ville ?>"> <?= $ville->nom_ville; ?> </option>
                            <?php elseif (!empty($_POST) && isset($data['lieu'])) : ?>
                                <option <?php if (($data['lieu']) == $ville->id_ville) {
                                            echo "selected";
                                        } ?> value="<?= $ville->id_ville ?>"><?= $ville->nom_ville ?></option>
                            <?php endif; ?>
                        <?php endforeach ?>
                    </select>
                    <input id="submit" type="submit" name="rechercher" value="rechercher">
                    <span id="advanced">Recherche avancée</span>
                </div>

                <div id="part2" class="dropmenu">
                    <div class="shadow"></div>
                    <div class="sect">
                        <h2>Selectionnez un ou plusieurs GRN</h2>
                        <div class="grns">
                            <?php $nb = 0;
                            foreach ($GRNs as $GRN) : ?>
                                <?php if (empty($_POST)) : ?>
                                    <label for="grns">
                                        <input checked type="checkbox" value="<?= $GRN->numero_grn ?>" name="grns[]" class="grnCheck"><span> <?= $GRN->numero_grn . ' - ' . $GRN->nom_grn ?></span>
                                        <span class="checkmark"></span>
                                    </label>
                                <?php elseif (!empty($_POST) && in_array($GRN->numero_grn, $data['grns'])) : ?>
                                    <label for="grns">
                                        <input checked type="checkbox" value="<?= $GRN->numero_grn ?>" name="grns[]" class="grnCheck"><span> <?= $GRN->numero_grn . ' - ' . $GRN->nom_grn ?></span>
                                        <span class="checkmark"></span>
                                    </label>
                                <?php else : ?>
                                    <label for="grns">
                                        <input type="checkbox" value="<?= $GRN->numero_grn ?>" name="grns[]" class="grnCheck"><span> <?= $GRN->numero_grn . ' - ' . $GRN->nom_grn ?></span>
                                        <span class="checkmark"></span>
                                    </label>
                                <?php endif; ?>
                            <?php $nb++;
                            endforeach ?>
                            <button type="button" id="checkGrns">Cocher/décocher tout</button>
                            <input type="hidden" name="nbGRNs" value="<?= $nb; ?>">
                        </div>
                    </div>

                    <div class="sect">
                        <h2>Selectionnez un ou plusieurs formateurs</h2>
                        <div class="formateurs">
                            <?php $nombre = 0;
                            foreach ($formateursList['Formateurs'] as $formateur) : ?>
                                <?php if ($formateur->id_formateur == 2) {
                                    continue;
                                }; ?>
                                <?php if (empty($_POST)) : ?>
                                    <label for="formateurs">
                                        <input checked type="checkbox" value="<?= $formateur->id_formateur ?>" name="formateurs[]" class="formateurCheck"><span> <?= strtoupper($formateur->nom_formateur) . ' ' . $formateur->prenom_formateur ?></span>
                                        <span class="checkmark"></span>
                                    </label>
                                <?php elseif (!empty($_POST) && in_array($formateur->id_formateur, $data['formateurs'])) : ?>
                                    <label for="formateurs">
                                        <input checked type="checkbox" value="<?= $formateur->id_formateur ?>" name="formateurs[]" class="formateurCheck"><span> <?= strtoupper($formateur->nom_formateur) . ' ' . $formateur->prenom_formateur ?></span>
                                        <span class="checkmark"></span>
                                    </label>
                                <?php else : ?>
                                    <label for="formateurs">
                                        <input type="checkbox" value="<?= $formateur->id_formateur ?>" name="formateurs[]" class="formateurCheck"><span> <?= strtoupper($formateur->nom_formateur) . ' ' . $formateur->prenom_formateur ?></span>
                                        <span class="checkmark"></span>
                                    </label>
                                <?php endif; ?>
                            <?php $nombre++;
                            endforeach ?>
                            <button type="button" id="checkFormateurs">Cocher/décocher tout</button>
                            <input type="hidden" name="nbFormateurs" value="<?= $nombre; ?>">
                        </div>
                    </div>
                </div>
            </form>
            <img onload="<?php if (!empty($data)) : ?> spin() <?php endif; ?>" class="flower-img" src="/planning/Views/assets/image/flower.svg">
        </div>
        <div class="legend">
            <ul class="list-color">
                <li class="color"><span>Centre</span><div style="background-color:<?= $_SESSION['color']['couleur_centre']; ?>;"></div></li>
                <li class="color"><span>PAE</span><div style="background-color:<?= $_SESSION['color']['couleur_pae']; ?>;"></div></li>
                <li class="color"><span>Certif</span><div style="background-color:<?= $_SESSION['color']['couleur_certif']; ?>;"></div></li>
                <li class="color"><span>RAN</span><div style="background-color:<?= $_SESSION['color']['couleur_ran']; ?>;"></div></li>
                <li class="color"><span>Interruptions</span><div style="background-color:<?= $_SESSION['color']['couleur_interruption']; ?>;"></div></li>
                <li class="color"><span>Vacs attente</span><div style="background-color:<?= $_SESSION['color']['couleur_vacance_demandees']; ?>;"></div></li>
                <li class="color"><span>Vacs ok</span><div style="background-color:<?= $_SESSION['color']['couleur_vacance_validee']; ?>;"></div></li>
                <li class="color"><span>Autre</span><div style="background-color:<?= $_SESSION['color']['couleur_autre']; ?>;"></div></li>
                <li class="color"><span>Férié</span><div style="background-color:<?= $_SESSION['color']['couleur_ferie']; ?>;"></div></li>
                <li class="color"><span>Week-end</span><div style="background-color:<?= $_SESSION['color']['couleur_weekend']; ?>;"></div></li>
                <li class="color"><span>MNSP</span><div style="background-color:<?= $_SESSION['color']['couleur_MNSP']; ?>;"></div></li>
                <li class="color"><span>Perf</span><div style="background-color:<?= $_SESSION['color']['couleur_perfectionment']; ?>;"></div></li>
            </ul>
        </div>
    </header>
    <main>
        <div>
            <?= $contenu; ?>
        </div>
    </main>
</body>

</html>