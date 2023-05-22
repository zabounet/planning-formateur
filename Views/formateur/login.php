<?php $link = "Connexion"; ?>
<div class="form-login">
    <h1>Planning Formateur de L'AFPA Blois-Tours</h1>
    <p>
        Veuillez vous authentifier👤
    </p>
    <div class="form-container">
        <form action="#" method="post">
            <div class="mail-box box">
                <label class="mail-label label" for="email">E-mail :</label>
                <div class="mail-container">
                    <img class="icon" src="/planning/Views/assets/image/user_icon.svg" alt="">
                    <div class="form-input">
                        <input type="email" name="email" id="email">
                    </div>
                </div>
            </div>
            <div class="pass-box box">
                <label class="pass-label label" for="password">Mot de passe :</label>
                <div class="pass-container">
                    <img class="icon" src="/planning/Views/assets/image/cle.svg" alt="">
                    <div class="form-input">
                        <input type="password" name="password" id="pass">
                        <img class="icon-eye" src="/planning/Views/assets/image/eye-open.svg" alt="" id="eye" >
                    </div>
                </div>
            </div>
            <input type="submit" name="login" class="form-btn">
        </form>
        <span class="error">
            <?php if (isset($_SESSION['erreur'])) {
                echo $_SESSION['erreur'];
                unset($_SESSION['erreur']);
            }; ?>
        </span>
    </div>

    <div class="logo">
        <img src="/planning/Views/assets/image/logo_afpa.png" alt="">
        <img src="/planning/Views/assets/image/logo_ministere.png" alt="">
    </div>

</div>