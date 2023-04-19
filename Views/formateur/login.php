<h1>Login</h1>

<?= $loginForm ?><br>
<?php if(isset($_SESSION['erreur'])) {
    echo $_SESSION['erreur'];
    unset($_SESSION['erreur']);
};?>