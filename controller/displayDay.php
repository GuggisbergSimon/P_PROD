<?php

include_once 'model/Database.php';

$database = new Database();
//TODO change by role condition once roles are stocked if admin in sessions variables
if (key_exists('day', $_GET)) {
//if (key_exists('day', $_GET) && key_exists('role', $_SESSION) && $_SESSION['role'] > 50) {
    $reservations = $database->readReservationPerDay($_GET['day']);
    foreach ($reservations as $reservation) {
        var_dump($reservation);
    }
}
