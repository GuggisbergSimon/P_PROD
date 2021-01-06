<h2 class="mt-3 text-center">Inscription</h2>
<form action="index.php?controller=home&action=Register" class="my-5" method="post">
    <div class="container">
        <?php

        if (array_key_exists('registerError', $_SESSION) && $_SESSION['registerError']) {
            echo '<div class="text-danger mb-5"><h4>' . "nom d'utilisateur ou mot de passe erroné" . '</h4></div>';
            $_SESSION['registerError'] = false;
        }

        ?>
        <div class="form-group">
            <label for="NomUser">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="NomUser" aria-describedby="AideNomUser" name="username">
            <label for="MotDePasse">Mot de passe</label>
            <input type="password" class="form-control" id="MotDePasse" aria-describedby="AideNomUser" name="password">
            <label for="ConfMotDePasse">Confirmation mot de passe</label>
            <input type="password" class="form-control" id="ConfMotDePasse" aria-describedby="AideNomUser" name="confPassword">
            <label for="Email">Email</label>
            <input type="text" class="form-control" id="Email" aria-describedby="AideNomUser" name="email">
            <small id="AideNomUser" class="form-text text-muted">Votre nom d'utilisateur, mot de passe et votre email ne seront pas partagés.</small>
        </div>
        <div class="form-group">
            <label for="Nom">Nom</label>
            <input type="text" class="form-control" id="Nom" aria-describedby="AideNom" name="lastName">
            <label for="Prenom">Prénom</label>
            <input type="text" class="form-control" id="Prenom" aria-describedby="AideNom" name="firstName">
            <small id="AideNom" class="form-text text-muted">Votre nom et prénom ne seront visibles que par le personnel du restaurant autorisé.</small>
        </div>
        <button type="submit" class="btn btn-primary">Inscription</button>
    </div>
    <input type="hidden" id="loginCheck" name="register" value="1">
</form>


<?php
if (array_key_exists('username', $_SESSION)) {
    //echo $_SESSION['username'];
}
?>