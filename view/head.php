<?php 
    //session_start(); // Démarrer le système de session  
    
/*
if($_SESSION == array()){
    session_start(); // Démarrer le système de session  
}*/
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<!-- police que le site de l'ETML utilise pour la barre de nav.-->
	<link href='https://fonts.googleapis.com/css?family=Exo:500,600' rel='stylesheet' type='text/css'>
	<!-- Logo Etml onglet page internet -->
	<link rel="icon" type="image/png" sizes="16x16" src="../../userContent/logoOnlet.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ETML - Restaurant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="resources/css/style.css" rel="stylesheet" type="text/css" />
    <?php
	if(array_key_exists('role', $_SESSION) && $_SESSION['role'] >= 50){
		echo '<style>';
		echo '.topnav a:hover { background-color: indigo; }';
		echo '.topnav { background-color: darkblue; }';
		echo '.topnav a.active { background-color: blue; }';
		echo '</style>';
	}
	?>
</head>
<body>