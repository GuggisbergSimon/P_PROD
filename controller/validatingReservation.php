<?php

include_once 'model/Database.php';

$database = new Database();
$sResDate = 'resDate';
//$sResTable = 'resTable';
$sResHour = 'resHour';
$sResMeal = 'resMeal';
$aMeals = array(
    //1 => 'Daily1',
    //2 => 'Daily2',
    //3 => 'Pasta',
    //4 => 'Burger',
    5 => 'Vegetarian'
);

$dDateRegex = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';

//if (array_key_exists($sResTable, $_POST) && $_POST[$sResTable] > 0 && $_POST[$sResTable] < 19)
if (array_key_exists($sResDate, $_POST) && preg_match($dDateRegex, $_POST[$sResDate]) && date('Y-m-d') < date('Y-m-d', strtotime($_POST[$sResDate]))) {
    if (array_key_exists($sResHour, $_POST) && ($_POST[$sResHour] == 11 || $_POST[$sResHour] == 12)) {
        if (array_key_exists($sResMeal, $_POST) && $_POST[$sResMeal] > 0 && $_POST[$sResMeal] < 6) {
            if (array_key_exists('username', $_SESSION)) {
                $date = $_POST[$sResDate];
                //$table = $_POST[$sResTable];
                $hour = $_POST[$sResHour];

                //that condition is for checking wether the reservation exists already, only one reservation per date/table and hour
                //TODO rework it to handle limit of 4 people per table
                //if ($database->reservationExistsAt($date, $table, $hour) < 0) {
                $database->addReservation($date, 0 /*$table*/, $hour, $_POST[$sResMeal], $database->getIdUser($_SESSION['username']));
                echo 'Réservation ajoutée !<br>';
                //}
            } else {
                echo 'Veuillez vous connectez pour ajouter une réservation.<br>';
            }
        } else {
            echo 'Veuillez entrer un type de plat correct.<br>';
        }
    } else {
        echo 'Veuillez entrer une heure correcte.<br>';
    }
} else {
    echo 'Veuillez entrer une date à partir de demain, dans un format correct.<br>';
}
echo '<a href="index.php?controller=home&action=Commander">Retour en arrière</a>';