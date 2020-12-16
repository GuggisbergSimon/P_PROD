<?php

include_once '../model/Database.php';

if (key_exists('username', $_SESSION)) {
    $database = new Database();
    $database->deleteUser($_SESSION['username']);
    header("Location: index.php");
    //todo logoff
}