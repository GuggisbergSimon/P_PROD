<?php
include '../database.php';

session_start();

$database = new Database();
var_dump($_GET);
if (key_exists('day', $_GET)) {
    $days = $database->readReservationPerDay($_GET['day']);

    foreach ($days as $day) {
        var_dump($day);
    }
}