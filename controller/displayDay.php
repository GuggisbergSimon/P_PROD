<?php
include '../database.php';

session_start();

$database = new Database();
if (key_exists('day', $_GET) && key_exists('role', $_SESSION) && $_SESSION['role'] > 50) {
    $days = $database->readReservationPerDay($_GET['day']);

    foreach ($days as $day) {
        var_dump($day);
    }
}