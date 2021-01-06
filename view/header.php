		<!--header-->
		<div class="toptop">
			<a href="https://www.etml.ch" target="_blank">ETML</a>
			<p>Ecole technique - Ecole des métiers - Lausanne</p>
		</div>
		
		
		<!-- header du site avec le bouteau Accueil, connexion, à propos, commande, option-->
		<div class="topnav">
			<a href="index.php?controller=home&action=Accueil" <?php if($_GET['action'] == 'Accueil') echo 'id="active"'; ?>>Accueil</a>
			<?php 
			if(array_key_exists('role', $_SESSION) && $_SESSION['role'] == 0){
				echo '<a href="index.php?controller=home&action=Commander"';
				if($_GET['action'] == 'Commander'){
					echo ' id="active"';
				}
				echo '>Commander</a>';
			}
			?>
			<?php 
			if(array_key_exists('username', $_SESSION)){
				echo '<a href="index.php?controller=home&action=Disconnect">Déconnexion</a>';
			}
			else{
				echo '<a href="index.php?controller=home&action=Connexion"';
				if($_GET['action'] == 'Connexion' || $_GET['action'] == 'Register'){
					echo 'id="active"';
				} 
				echo '>Connexion</a>';
			}
			?>
			<a href="index.php?controller=home&action=Contact" <?php if($_GET['action'] == 'Contact') echo 'id="active"'; ?>>Contact</a>
			<a href="index.php?controller=home&action=Apropos" <?php if($_GET['action'] == 'Apropos') echo 'id="active"'; ?>>À propos</a>
			<?php 
			if(array_key_exists('role', $_SESSION) && $_SESSION['role'] >= 50){
				echo '<a href="index.php?controller=home&action=Option"';
				if($_GET['action'] == 'Option'){
					echo 'id="active"';
				} 
				echo '>Administation</a>';
			}
			?>
		</div>	

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