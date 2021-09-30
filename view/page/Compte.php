<h1 class="mt-3 text-center" >Mon Compte</h1>

<div  class="container mb-5">
    <?php
        if (isset($_SESSION['success'])) {
            if ($_SESSION['success']) {
        ?>
                <div class="alert alert-success mt-5">
                    Email envoyé !
                    <ul class="mb-0">
                        <li>Un mail de confirmation vous a été envoyé. Vous avez 24h pour cliquer sur le lien et confirmer votre adresse mail. ATTENTION: l'email peut se trouver dans les spams</li>
                        <li>Si l'email n'est pas le bon veuillez recréer un compte avec la bonne adresse mail.</li>
                    </ul>
                </div>
        <?php
                $success = null;
            }
        }

        if (array_key_exists('Errors', $_SESSION)) {
            if (count($_SESSION['Errors']) > 0) {
                ?>
                <div class="alert alert-danger mt-5">
                    Oups ... Nous avons rencontré quelques erreurs :<br>
                    <ul class="mb-0">
                        <?php
                            foreach($_SESSION['Errors'] as $error) {
                                echo "<li>$error</li>";
                            }
                        ?>
                    </ul>
                </div>
                <?php
            }
        }
    ?>
    <form action="#" class="my-5" method="post">
        <div class="form-group row">
            <label for="NomUser" class="col-sm-2 col-form-label">Nom d'utilisateur</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="NomUser" aria-describedby="AideNomUser" name="username" value="<?php if (isset($_SESSION['allUserInfo']['useUsername'])) { echo htmlspecialchars($_SESSION['allUserInfo']['useUsername']); } ?>" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="Email" class="col-sm-2 col-form-label mt-sm-2">Email</label>
            <?php
            if($_SESSION['allUserInfo']['useVerif'] == 0){

            
            ?>
            <div class="col-sm-7 mt-2">
                <input type="text" class="form-control" id="Email" aria-describedby="AideNomUser" name="email" value="<?php if (isset($_SESSION['allUserInfo']['useEmail'])) { echo htmlspecialchars($_SESSION['allUserInfo']['useEmail']); } ?>" disabled>
            </div>
            <div class="col-sm-3 mt-2">
                <button type="submit" name="verifier" class="btn btn-primary col-sm-12">Vérifier</button>
            </div>
            <small id="AideNomUser" class="form-text text-muted col-sm-12">Vous n'avez pas vérifié votre adresse mail. Cliquez sur le bouton ci-dessus afin de recevoir l'email de confirmation. Si vous l'avez déjà fait, recharger la page afin de faire disparaitre ce message.</small>

            <?php
            }
            else{
            ?>

            <div class="col-sm-10">
                <input type="text" class="form-control" id="Email" aria-describedby="AideNomUser" name="email" value="<?php if (isset($_SESSION['allUserInfo']['useEmail'])) { echo htmlspecialchars($_SESSION['allUserInfo']['useEmail']); } ?>" disabled>
            </div>

            <?php
            }
            ?>
        </div>
        <div class="form-group row">
            <label for="Prenom" class="col-sm-2 col-form-label">Prénom</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="Prenom" aria-describedby="AideNom" name="firstName" value="<?php if (isset($_SESSION['allUserInfo']['useFirstName'])) { echo htmlspecialchars($_SESSION['allUserInfo']['useFirstName']); } ?>" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="Nom" class="col-sm-2 col-form-label">Nom</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="Nom" aria-describedby="AideNom" name="lastName" value="<?php if (isset($_SESSION['allUserInfo']['useLastName'])) { echo htmlspecialchars($_SESSION['allUserInfo']['useLastName']); } ?>" disabled>
            </div>
        </div>
    </form>
</div>