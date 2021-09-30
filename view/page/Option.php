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
                    ' . $database->getMeal($reservation['fkMeal'])['meaName'] . ' <br>
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
        <h3 class="my-0" id="changeMenu">Changement des menus de la semaine</h3>
        <div class="ligne ligne-admin"></div>
    </div>

    <?php
    if (isset($_SESSION['menuErrors'])) {
        if (count($_SESSION['menuErrors']) > 0) {
    ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Oups ... Nous avons rencontré quelques erreurs :
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br>
                <ul class="mb-0">
    <?php
                foreach ($_SESSION['menuErrors'] as $error) {
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
    if (isset($_SESSION['menuInfo'])) {
        if (count($_SESSION['menuInfo']) > 0) {
    ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Information</strong> : 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br>
                <ul class="mb-0">
    <?php
                foreach ($_SESSION['menuInfo'] as $info) {
                    echo "<li>$info</li>";
                }
    ?>
                </ul>
            </div>
    <?php
        }
    }
    ?>

    <?php
    if (isset($_SESSION['menuSuccess'])) {
        if ($_SESSION['menuSuccess']) {
    ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Les changements de menu ont bien été effectués !
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="mb-0">
                    <li><a href="index.php?controller=home&action=Accueil" style="text-decoration: none;">Voir la page d'accueil</a></li>
                </ul>
            </div>
    <?php
        }
    }
    ?>

    <form action="#" method="post" class="mb-5" autocomplete="off" id="formMenu">
        <?php
            $meal = $_SESSION['meals'];
            $nbrMeal = count($meal);
            $menuDigit = 1;
            if($nbrMeal != 0){
                for($x=0; $x < $nbrMeal; $x++){
                    if($meal[$x]['meaDisplay'] == '1'){
                        $check="";
                        if($meal[$x]['meaIsCurrentMeal'] == "1"){
                            $check = "checked";
                        }
                        echo("<div class='container-fluid mb-2'>               
                            <h6>Menu N°". $menuDigit ."</h6>
                            <div class='form-row'>
                                <div class='col-lg-4'>
                                    <input type='hidden' name='mealID-". $x ."' value='". $meal[$x]['idMeal'] ."'>
                                    <input type='text' class='form-control' name='mealName-". $x ."' placeholder='Nom du plat' value='" . $meal[$x]['meaName'] ."'>
                                </div>
                                <div class='col-lg-2'>
                                    <input type='date'class='form-control' name='mealStartDate-". $x ."' placeholder='Last name' value ='" . $meal[$x]['meaStartDate'] . "'>
                                </div>
                                <div class='col-lg-2 mb-2'>
                                    <input type='date'class='form-control' name='mealDeadline-". $x ."' placeholder='Last name' value ='" . $meal[$x]['meaDeadline'] . "'>
                                </div>
                                <div class='col-lg-*'>
                                    <!-- Custom switch -->
                                    <p class='custom-control custom-switch custom-switch-lg'>
                                        <input class='checkbox custom-control-input custom-control-input-success' name='mealCurrentMeal-". $x ."' id='customSwitch". $x ."' type='checkbox' ". $check .">
                                        <label class='custom-control-label font-italic' for='customSwitch". $x ."'>Plat disponible</label>
                                    </p>
                                </div>
                                <div class='col-lg-*'>
                                    <span class='d-inline-block' tabindex='0' data-toggle='tooltip' data-placement='top' title='Si la case est cochée, le plat sera commandable entre les dates indiquées'>
                                            <button class='btn btn-primary btn-sm' style='pointer-events: none;' type='button' disabled>?</button>
                                        </span>
                                </div>
                                <div class='col-lg-*'>
                                    <button type='button' OnClick='supprMeal(this.value)' value='". $meal[$x]['idMeal'] ."' class='btn btn-danger'>Supprimer</button>
                                </div>
                            </div>
                        </div>");
                    }
                    $menuDigit++;
                }
            }
            else{
                echo("<h5 class='mb-4'>Aucun menu trouvé</h5>");
            }
        ?>
        
        <button type="reset" id="resetBtn" class="btn btn-dark mb-2">Réinitialiser les champs</button>
        <button type="submit" name="submitBtn" class="btn btn-primary mb-2">Enregistrer</button>
        <button type="add" name="addMenu" class="btn btn-success mb-2">Ajouter un plat</button>
    </form>
</div>

<script type="text/javascript">
    // Permet d'ajouter supprMeal en $_GET et d'y définir sa valeur, pour le supprimer
    function supprMeal(clicked_id) {
        key = encodeURIComponent("supprMeal");
        value = encodeURIComponent(clicked_id);

        // kvp looks like ['key1=value1', 'key2=value2', ...]
        var kvp = document.location.search.substr(1).split('&');
        let i=0;

        for(; i<kvp.length; i++){
            if (kvp[i].startsWith(key + '=')) {
                let pair = kvp[i].split('=');
                pair[1] = value;
                kvp[i] = pair.join('=');
                break;
            }
        }

        if(i >= kvp.length){
            kvp[kvp.length] = [key,value].join('=');
        }

        // can return this or...
        let params = kvp.join('&');

        // reload page with new params
        document.location.search = params;
    }
</script>