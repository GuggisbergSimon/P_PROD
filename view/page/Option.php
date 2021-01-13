<?php
include_once "model/Database.php";

$day = date('w');

$meals = [
    1=> "Menu du jour 1",
    2=>"Menu du jour 2",
    3=>"Menu pâtes",
    4 =>"Menu hamburger",
    5=> "Menu végétarien"
];

echo '
<div class="container mt-5 mb-5">
<table class="table table-bordered" style="width:100%">
    <tr>
        <th>Lundi</th>
        <th>Mardi</th>
        <th>Mercredi</th>
        <th>Jeudi</th>
        <th>Vendredi</th>
    </tr>
    <tr>';
$database = new Database();
for ($i = 0; $i < 5; $i++) {
    $week_day = date('Y-m-d', strtotime('+1 days', strtotime('+' . ($i - $day) . ' days')));
    echo "<td>$week_day</td>";
}
echo '</tr><tr>';

for ($i = 0; $i < 5; $i++) {
    $database = new Database();
    $week_day = date('Y-m-d', strtotime('+1 days', strtotime('+' . ($i - $day) . ' days')));
    echo '<td>';
    if (key_exists('role', $_SESSION) && $_SESSION['role'] > 50) {
        $reservations = $database->readReservationPerDay($week_day);
        foreach ($reservations as $reservation) {
            echo '
                <p>
                    ' . $reservation['resHour'] . 'h <br>
                    ' . $meals[$reservation['resMeal']] . ' <br>
                    Utilisateur : ' . $database->getUser($reservation['fkUser']) . '
                </p>';
        }
    }
    echo '</td>';
}
echo '</tr></table></div>';
$week_end = date('d-m-Y', strtotime('+' . (6 - $day) . ' days'));
?>