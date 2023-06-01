<?php $link = "Inscription formateur"; ?>

<h1>Inscription formateur</h1>
<section>
    <form style="text-transform: capitalize;" method="post" name="validation">
        <label for="nom">nom
            <input type="text" name="nom" id="nom-input">
        </label>
        <label for="prenom">prenom
            <input type="text" name="prenom" id="prenom-input">
        </label>
        <label for="email">e-mail
            <input type="email" name="email" id="mail-input">
        </label>
        <label for="type_contrat"> type contrat :
            <select name="type_contrat" id="type_contrat">
                <option disabled selected>Choisir type contat</option>
                <option value="CDI">CDI</option>
                <option value="CDD">CDD</option>
                <option value="interim">intrime</option>
                <option value="autre">autre</option>
            </select>
        </label>

        <label for="date_debut_contrat">date debut contrat
            <input type="date" name="date_debut_contrat" id="">
        </label>
        <label for="date_fin_contrat">date fin contrat
            <input type="date" name="date_fin_contrat" id="fin">
        </label>
        <label for="grn"> GRN :
            <select name="grn">
                <option disabled selected>Choisir un GRN</option>
                <?php foreach ($infosFormateur['GRNS'] as $grn) : ?>
                    <option value="<?= $grn->numero_grn; ?>"><?= $grn->numero_grn . ' - ' . $grn->nom_grn; ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label for="ville"> Ville :
            <select name="ville">
                <option disabled selected>Choisir une ville</option>
                <?php foreach ($infosFormateur['Villes'] as $villes) : ?>
                    <option value="<?= $villes->id_ville; ?>"><?= $villes->nom_ville; ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <input type="submit" value="Inscrire" name="inscription">

    </form>
</section>
<div id="error"></div>
<div>
    <span style="color:red;">
        <?php if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
        ?>
    </span>
</div>
<div>
    <span style="color:green;">
        <?php if (isset($_SESSION['success'])) {
            echo $_SESSION['success'];
            unset($_SESSION['success']);
        }
        ?>
    </span>
</div>