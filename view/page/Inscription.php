<h1 class="mt-3 text-center" >Inscription</h1>

<form action="#" class="my-5" method="post">
    <div class="container">
        <?php

        if (array_key_exists('success', $_SESSION))
        {
            if (isset($_SESSION['success'])) {
        ?>
                <div class="alert alert-success mt-5">
                    Vous êtes bien inscrits !
                    <ul class="mb-0">
                        <li><a href="index.php?controller=home&action=Connexion" style="text-decoration: none;">Connectez-vous !</a></li>
                    </ul>
                </div>
        <?php
                $_SESSION['success'] = null;
            }
        }

        if (isset($_SESSION['registerError'])) {
            if (count($_SESSION['registerError']) > 0) {
        ?>
                <div class="alert alert-danger mt-5">
                    Oups ... Nous avons rencontré quelques erreurs :<br>
                    <ul class="mb-0">
        <?php
                    foreach ($_SESSION['registerError'] as $error) {
                        echo "<li>$error</li>";
                    }
        ?>
                    </ul>
                </div>
        <?php
            }
        }

        ?>
        <div class="form-group">
            <label for="NomUser">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="NomUser" aria-describedby="AideNomUser" name="username" value="<?php if (isset($_POST['username'])) { echo htmlspecialchars($_POST['username']); } ?>">
            <label for="MotDePasse">Mot de passe</label>
            <input type="password" class="form-control" id="MotDePasse" aria-describedby="AideNomUser" name="password">
            <label for="ConfMotDePasse">Confirmation mot de passe</label>
            <input type="password" class="form-control" id="ConfMotDePasse" aria-describedby="AideNomUser" name="confPassword">
            <label for="Email">Email</label>
            <input type="text" class="form-control" id="Email" aria-describedby="AideNomUser" name="email" value="<?php if (isset($_POST['email'])) { echo htmlspecialchars($_POST['email']); } ?>">
            <small id="AideNomUser" class="form-text text-muted">Votre nom d'utilisateur, mot de passe et votre email ne seront pas partagés.</small>
        </div>
        <div class="form-group">
            <label for="Prenom">Prénom</label>
            <input type="text" class="form-control" id="Prenom" aria-describedby="AideNom" name="firstName" value="<?php if (isset($_POST['firstName'])) { echo htmlspecialchars($_POST['firstName']); } ?>">
            <label for="Nom">Nom</label>
            <input type="text" class="form-control" id="Nom" aria-describedby="AideNom" name="lastName" value="<?php if (isset($_POST['lastName'])) { echo htmlspecialchars($_POST['lastName']); } ?>">
            <small id="AideNom" class="form-text text-muted">Votre nom et prénom ne seront visibles que par le personnel du restaurant autorisé.</small>
        </div>
        <button type="submit" name="submitBtn" class="btn btn-primary">Inscription</button>
    </div>
</form>