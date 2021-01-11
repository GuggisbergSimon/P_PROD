<h4>Page réservée à l'admin du site permettant d'y apporter des modifications ainsi que de nouvelles fonctionnalités</h4>
<?php
include_once "model/Database.php";

$day = date('w');
echo '
<table style="width:100%">
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
                    Heure : ' . $reservation['resHour'] . 'h <br>
                    Plat : ' . $reservation['resMeal'] . ' <br>
                    Utilisateur : ' . $database->getUser($reservation['fkUser']) . '
                </p>';
        }
    }
    echo '</td>';
}
echo '</tr></table>';
$week_end = date('d-m-Y', strtotime('+' . (6 - $day) . ' days'));
?>