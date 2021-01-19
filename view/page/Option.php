<div class="container">
    <div class="my-4">
        <h3 class="my-0">Menus de la semaine</h3>
        <div class="ligne ligne-admin"></div>
    </div>

<?php

include_once "model/Database.php";

$day = date('w');

$meals = [
    1=> "Menu du jour 1",
    2=> "Menu du jour 2",
    3=> "Menu pâtes",
    4 => "Menu hamburger",
    5=> "Menu végétarien"
];

echo '
<table class="table table-bordered w-100">
    <thead class="thead-dark">
        <tr>
            <th>Lundi</th>
            <th>Mardi</th>
            <th>Mercredi</th>
            <th>Jeudi</th>
            <th>Vendredi</th>
        </tr>
    </thead>
    <thead class="thead-light">
    <tr>';
$database = new Database();
for ($i = 0; $i < 5; $i++) {
    $week_day = date('d.m.Y', strtotime('+1 days', strtotime('+' . ($i - $day) . ' days')));
    echo "<th>$week_day</th>";
}
echo '</tr></thead><tr>';

for ($i = 0; $i < 5; $i++) {
    $database = new Database();
    $week_day = date('Y-m-d', strtotime('+1 days', strtotime('+' . ($i - $day) . ' days')));
    echo '<td>';
    if (key_exists('role', $_SESSION) && $_SESSION['role'] > 50) {
        $reservations = $database->readReservationPerDay($week_day);
        foreach ($reservations as $reservation) {
            $user = $database->getUser($reservation['fkUser']);
            echo '
                <p class="mb-0 mt-2">
                    ' . $reservation['resHour'] . 'h <br>
                    ' . $meals[$reservation['resMeal']] . ' <br>
                    Pour ' . $user['useFirstName'] . ' ' . $user['useLastName'] . '
                </p>';
        }
    }
    echo '</td>';
}
echo '</tr></table>';
$week_end = date('d-m-Y', strtotime('+' . (6 - $day) . ' days'));
?>
    <div class="my-4">
        <h3 class="my-0">Changement des menus</h3>
        <div class="ligne ligne-admin"></div>
    </div>

    <form action="#" method="post" class="mb-5">
    <div class="form-group">
        <label for="menuNumberOne">Menu n°1</label>
        <input type="text" class="form-control" id="menuNumberOne" name="menuNumberOne">
    </div>
    <div class="form-group">
        <label for="menuNumberTwo">Menu n°2</label>
        <input type="text" class="form-control" id="menuNumberTwo" name="menuNumberTwo">
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>

</div>