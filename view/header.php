		<!--header-->
		<div class="toptop">
            <a style= "font-family: 'ETML';" href="https://www.etml.ch" target="_blank">ETML</a>
			<p>Ecole technique - Ecole des métiers - Lausanne</p>
		</div>
		
		
		<!-- header du site avec le bouteau Accueil, connexion, à propos, commande, option-->
            <nav class="navbar-expand-md navbar-light bg-light">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item
            <?php if($_GET['action'] == 'Accueil') {
                        echo ' active';
            }?>">
			    <a href="index.php?controller=home&action=Accueil" class="nav-link">Accueil</a>
            </li>
			<?php
			if(array_key_exists('role', $_SESSION) && $_SESSION['role'] == 0){
				echo '<li class="nav-item';
                if($_GET['action'] == 'Commander'){
                    echo ' active';
                }
                echo '">
				<a href="index.php?controller=home&action=Commander" class="nav-link">Commander</a></li>';
			}
			?>
			<?php 
			if(array_key_exists('username', $_SESSION)){
				echo '<li class="nav-item">
                <a href="index.php?controller=home&action=Disconnect" class="nav-link">Déconnexion</a>
                </li>';
			}
			else {
				echo '<li class="nav-item';
                if($_GET['action'] == 'Connexion' || $_GET['action'] == 'Register'){
                    echo ' active';
                }
                echo '">
                <a href="index.php?controller=home&action=Connexion" class="nav-link">Connexion</a></li>';
			}
			?>
			<?php
			if(array_key_exists('role', $_SESSION) && $_SESSION['role'] >= 50){
				echo '<li class="nav-item';
                if($_GET['action'] == 'Option'){
                    echo ' active"';
                }
                echo '">
                <a href="index.php?controller=home&action=Option"  class="nav-link">Administration</a></li>';
			}
			else {
			    ?>
                <li class="nav-item
                <?php
                if($_GET['action'] == 'Contact') {
                    echo ' active"';
                }
                ?>">
                    <a href="index.php?controller=home&action=Contact"  class="nav-link">Contact</a>
                </li>
                <li class="nav-item
                <?php
                if($_GET['action'] == 'Apropos') {
                    echo ' active"';
                }
                ?>">
                    <a href="index.php?controller=home&action=Apropos"  class="nav-link">À propos</a>
                </li>
            </ul>
            </nav>
                <?php
            }
			?>

		<?php
		/*
			if(isset($_SESSION['username'])){
				echo 
				'<div class="btn-group float-right">
				<button type="button" class="btn btn-success dropdown-toggle mr-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Bonjour ' 
				.  $_SESSION['username'] . 
				'</button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="index.php?controller=home&action=profil&user=IronG">Mon Profil</a>
					<a class="dropdown-item" href="#">Paramètres</a>
					<a class="dropdown-item" href="#">Autre</a>
					<div class="dropdown-divider"></div>
					<form action="#" method="post">
					<input class="dropdown-item" type="submit" name="disconnect" value="Déconnexion">
					</form> 
				</div>
				</div>';
			}   
			else{
				echo '<a class="btn btn-outline-success my-2 mr-5 my-sm-0 px-4 float-right" href="index.php?controller=home&action=Connexion"> Connexion </a>';
			}*/
		?>

<!--
		<div class="topnav">
		  <a href="index.php?controller=home&action=Connexion">Connexion</a>
		  <a href="index.php?controller=home&action=Parametre">Paramètre compte</a>
		  <a href="index.php?controller=home&action=Apropos">A propos</a>
		  <a id="active" href="index.php?controller=home&action=Commande">Commande(RESERVER CUISINE)</a>
		</div>

		-->