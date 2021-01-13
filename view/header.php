<!--header-->
<div class="toptop">
    <a style= "font-family: 'ETML'; text-decoration: none;" href="https://www.etml.ch" target="_blank">ETML</a>
    <p>Ecole technique - Ecole des métiers - Lausanne</p>
</div>

<?php
	if(array_key_exists('role', $_SESSION) && $_SESSION['role'] >= 50){
        $admin = true;
	} else {
        $admin = false;
    }
?>

<nav class="navbar navbar-expand-lg navbar-dark py-3 <?php if ($admin) { echo "navbar-admin"; } ?>" style="background-color: #556B2F;">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">

                <a class="nav-item nav-link link <?php if ($_GET['action'] == 'Accueil') { echo 'active'; } ?>" href="index.php?controller=home&action=Accueil"><i class="fas fa-home"></i> Accueil <span class="sr-only">(current)</span></a>
                
                <?php
                // Connecté
                if(array_key_exists('role', $_SESSION)) {
                    // Utilisateur
                    if ($_SESSION['role'] == 0) {
                ?>
                        <a class="nav-item nav-link link <?php if ($_GET['action'] == 'Commander') { echo 'active'; } ?>" href="index.php?controller=home&action=Commander"><i class="fas fa-shopping-cart"></i> Commander</a>
                <?php
                    // Administrateur
                    } else if ($_SESSION['role'] >= 50) {
                ?>
                        <a class="nav-item nav-link link <?php if ($_GET['action'] == 'Option') { echo 'active'; } ?>" href="index.php?controller=home&action=Option"><i class="fas fa-cog"></i> Administration</a>
                <?php
                    }
                } else {
                ?>
                    <span data-toggle="tooltip" data-placement="bottom" title="Vous devez être connecté">
                        <a class="nav-item nav-link disabled"><i class="fas fa-shopping-cart"></i> Commander</a>
                    </span>
                <?php
                }
                ?>

                <a class="nav-item nav-link link <?php if ($_GET['action'] == 'Contact') { echo 'active'; } ?>" href="index.php?controller=home&action=Contact"><i class="far fa-address-card"></i> Contact</a>

                <a class="nav-item nav-link link <?php if ($_GET['action'] == 'Apropos') { echo 'active'; } ?>" href="index.php?controller=home&action=Apropos"><i class="fas fa-comment-dots"></i> À propos</a>
            </div>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <?php 
            if(array_key_exists('username', $_SESSION)){
            ?>
                <a href="index.php?controller=home&action=Disconnect" class="btn btn-danger">Déconnexion</a>
            <?php
            }
            else {
            ?>
            <div class="d-flex flex-row">
                <a class="nav-item nav-link link <?php if ($_GET['action'] == 'Register') { echo 'active'; } ?>" href="index.php?controller=home&action=Register">Inscription</a>
                <div class="btn-nav btn-primary rounded">
                    <a class="nav-item nav-link pl-sm-2 pr-sm-2" style="color: white;" href="index.php?controller=home&action=Connexion">Connexion</a>
                </div>
            </div>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>