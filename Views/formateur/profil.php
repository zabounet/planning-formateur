<div class="profil">
    <p>profil</p>

    <div class="info-personel">
        <span class="titre titre-profil">vos informations personnelles :</span>
        <div class="container-info">
            
            <form class="nom-profil" method="post">
                <span>Nom :</span>
                <span id="nomProfil"><?= $_SESSION['formateur']['nom']?></span>
                <input type="submit" id="modifier_nom_formateur" value="Modifier" name="modifNom" />
            </form>
            <hr>
            <div class="prenom-profil">
                <span>prenom :</span>
                <span id="prenomProfil"><?= $_SESSION['formateur']['prenom']?></span>
                <button>modifier</button>
            </div>
            <hr>
            <div class="mail-profil">
                <span>E-mail :</span>
                <span id="mailProfil"><?= $_SESSION['formateur']['mail']?></span>
                <button>modifier</button>
            </div>
            <hr>
            <div class="mdp-profil">
                <span>mot de pass :</span>
                <button>modifier</button>
            </div>
        </div>
    </div>
</div>

<div>
    <span class="vacances">Demande vacanses</span>
    <div class="demande-vacances">
        <span class="titre titre-demende-vacances" >Sélectionnez une période</span>
        <form method="POST" class="container-vacances">
            <div class="date-demande-vacances">
                <div class="date date-debut date-debut-vacance">
                    <p>Date de début</p>
                    <input type="date" name="date_debut" id="">
                    <div>clandier</div>
                </div>
                <hr>
                <div class="date date-debut date-debut-vacance">
                    <p>Date de fin</p>
                    <input type="date" name="date_fin" id="">
                    <div>clandier</div>
                </div>
            </div>
            <div class="btn btn-validation-vacance">
            <input type="submit" value="envoyer la demande" name="vacances">
            </div>
        </form>
    </div>
</div>