<?php
include_once '../database.php';

session_start();

$database = new Database();
$sResDate = 'resDate';
$sResTable = 'resTable';
$sResHour = 'resHour';
$sResMeal = 'resMeal';
$aMeals = array(
    1 => 'Daily1',
    2 => 'Daily2',
    3 => 'Pasta',
    4 => 'Burger',
    5 => 'Vegetarian'
);

$dDateRegex = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';

var_dump($_POST);

if (array_key_exists($sResDate, $_POST) && preg_match($dDateRegex, $_POST[$sResDate])
    && array_key_exists($sResTable, $_POST) && $_POST[$sResTable] > 0 && $_POST[$sResTable] < 19
    && array_key_exists($sResHour, $_POST) && ($_POST[$sResHour] == 11 || $_POST[$sResHour] == 12)
    && array_key_exists($sResMeal, $_POST) && $_POST[$sResMeal] > 0 && $_POST[$sResMeal] < 6
    && array_key_exists('username', $_SESSION)) {
    $date = $_POST[$sResDate];
    $table = $_POST[$sResTable];
    $hour = $_POST[$sResHour];
    if ($database->reservationExistsAt($date, $table, $hour) < 0) {
        $database->addReservation($date, $table, $hour, $_POST[$sResMeal], $database->getIdUser($_SESSION['username']));
        echo 'reservation added';
    }
    //todo display landing page
} else {
    echo 'a problem happened, please complete the reservation correctly again';
    //todo add a link to go back to form
}
