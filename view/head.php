<?php 
    //session_start(); // Démarrer le système de session  
    
/*
if($_SESSION == array()){
    session_start(); // Démarrer le système de session  
}*/
?>
<!DOCTYPE html>
<html>
<head>
	<!-- police que le site de l'ETML utilise pour la barre de nav.-->
	<link href='https://fonts.googleapis.com/css?family=Exo:500,600' rel='stylesheet' type='text/css'>
	<!-- Logo Etml onglet page internet -->
	<link rel="icon" type="image/png" sizes="16x16" src="../../userContent/logoOnlet.png">
	<meta charset="UTF-8">
	<title>ETML - Restaurant</title>
	<link href="resources/css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<?php 
	if(array_key_exists('role', $_SESSION) && $_SESSION['role'] >= 50){
		echo '<style>';
		echo '.topnav a:hover { background-color: indigo; }';
		echo '.topnav { background-color: darkblue; }';
		echo '#active { background-color: blue; }';
		echo '</style>';
	}
	?>
</head>
<body>