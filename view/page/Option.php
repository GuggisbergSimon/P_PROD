<div class="container">
    <div class="my-4">
        <h3 class="my-0">Menus de la semaine</h3>
        <div class="ligne ligne-admin"></div>
    </div>

<?php

include_once "model/Database.php";

$day = date('w');

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
                    ' . $meals[$reservation['fkMeal']] . ' <br>
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
        <h3 class="my-0">Changement des menus de la semaine</h3>
        <div class="ligne ligne-admin"></div>
    </div>

    <?php 
    if (isset($menuErrors)) {
        if (count($menuErrors) > 0) {
    ?>
            <div class="alert alert-danger">
                Oups ... Nous avons rencontré quelques erreurs :<br>
                <ul class="mb-0">
    <?php
                foreach ($menuErrors as $error) {
                    echo "<li>$error</li>";
                }
    ?>
                </ul>
            </div>
    <?php
        }
    }
    ?>

    <?php 
    if (isset($menuSuccess)) {
        if ($menuSuccess) {
    ?>
            <div class="alert alert-success">
                Les changements de menu ont bien été effectués !
                <ul class="mb-0">
                        <li><a href="index.php?controller=home&action=Accueil" style="text-decoration: none;">Voir la page d'accueil</a></li>
                </ul>
            </div>
    <?php
        }
    }
    ?>

    <form action="#" method="post" class="mb-5" autocomplete="off">
        <div class="form-group">
            <label for="menuNumberOne">Menu n°1</label>
            <input type="text" class="form-control" id="inputMenu1" name="inputMenu1" list="menuNumberOne" value="<?= $currentMeals[0]['meaName'] ?>">
            <datalist id="menuNumberOne" name="menuNumberOne">
                <?php
                if (isset($meals))  {
                    foreach($meals as $meal) {
                ?>
                        <option value="<?= $meal['meaName'] ?>">
                <?php
                    }
                }
                ?>
            </datalist>
        </div>

        <div class="form-group">
            <label for="menuNumberTwo">Menu n°2</label>
            <input type="text" class="form-control" id="inputMenu2" name="inputMenu2" list="menuNumberOne" value="<?= $currentMeals[1]['meaName'] ?>">
            <datalist id="menuNumberOne" name="menuNumberOne">
                <?php
                if (isset($meals))  {
                    foreach($meals as $meal) {
                ?>
                        <option value="<?= $meal['meaName'] ?>">
                <?php
                    }
                }
                ?>
            </datalist>
        </div>

        <button type="reset" class="btn btn-dark" id="resetBtn">Réinitialiser</button>
        <button type="submit" name="submitBtn" class="btn btn-primary">Enregistrer</button>
    </form>
</div>

<script type="text/javascript">
    $('#resetBtn').click(function () {
        var defaultMenu1 = <?= $currentMeals[0]['meaName'] ?>;
        var defaultMenu2 = <?= $currentMeals[1]['meaName'] ?>;
        $('#inputMenu1').attr("value", defaultMenu1);
        $('#inputMenu2').attr("value", defaultMenu2);
    });
</script>