		<!--header-->
		<div class="toptop">
            <a style= "font-family: 'ETML'; text-decoration: none;" href="https://www.etml.ch" target="_blank">ETML</a>
			<p>Ecole technique - Ecole des métiers - Lausanne</p>
		</div>

        <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        
        <div class="topnav d-flex justify-content-md-center" id="myTopnav">

            <a href="index.php?controller=home&action=Accueil"
            <?php
            if($_GET['action'] == 'Accueil') {
                echo ' class="active"';
            }
            ?>>Accueil</a>

            <?php
            if(array_key_exists('role', $_SESSION) && $_SESSION['role'] == 0) {
                echo '<a href="index.php?controller=home&action=Commander"';
                if($_GET['action'] == 'Commander') {
                    echo ' class="active"';
                }
                echo '>Commander</a>';
            }

            if(array_key_exists('username', $_SESSION)){
                echo '<a href="index.php?controller=home&action=Disconnect">Déconnexion</a>';
            }
            else {
                echo '<a href="index.php?controller=home&action=Connexion"';
                if($_GET['action'] == 'Connexion' || $_GET['action'] == 'Register'){
                    echo ' class="active"';
                }
                echo '">Connexion</a>';
            }
            if(array_key_exists('role', $_SESSION) && $_SESSION['role'] >= 50){
                echo '<a href="index.php?controller=home&action=Option"';
                if($_GET['action'] == 'Option'){
                    echo ' class="active"';
                }
                echo '>Administration</a>';
            }
            else {
                ?>
                <a href="index.php?controller=home&action=Contact"
                <?php
                if($_GET['action'] == 'Contact') {
                    echo ' class="active"';
                }
                ?>>Contact</a>
                <a href="index.php?controller=home&action=Apropos"
                <?php
                if($_GET['action'] == 'Apropos') {
                    echo ' class="active"';
                }
                ?>>À propos</a>
            <?php
            }
            ?>
            <a href="javascript:void(0);" class="icon" onclick="toggleBurger()">
                <i class="fa fa-bars"></i>
            </a>
        </div>