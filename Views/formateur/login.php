<?php $link = "Connexion";?>

<h1>Planning Formateur de L'AFPA Blois-Tours</h1>
<span>
    Veuillez vous authentifier
</span>
<?= $loginForm ?>
<img src="/planning/Views/" alt="">
<img src="" alt="">
<?php if(isset($_SESSION['erreur'])) {
    echo $_SESSION['erreur'];
    unset($_SESSION['erreur']);
};?>