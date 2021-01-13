<?php
//todo choix de tables/menus mis en commentaires pour le moment, à rétablir
if (!array_key_exists('username', $_SESSION)) {
    header("Location: index.php?controller=home&action=Connexion");
    exit();
} else {
    echo '
<form action="index.php?controller=home&action=ValidateReservation" method="post">
    <div class="container">
    <div class="form-group mt-4">
        <label>Date de la réservation : </label>
        <input class="form-control" type="date" name="resDate">
    </div>' .
        //<p>
        //<label>Numéro de table</label>
        //<input type="number" name="resTable" min="1" max="18" value="1">
        //</p>
        '<div class="form-group">
        <label>Heure de la réservation</label>
        <select class="form-control" name="resHour">
            <option value="Choose">Choisir</option>
            <option value="11">11h20-12h</option>
            <option value="12">12h10-13h50</option>
        </select>
    </div>
    <div class="form-group">
        <label>Plat choisi : </label>
        <select class="form-control" name="resMeal">
            ' . //<option value="0">Choisir</option>
        //<option value="1">Menu du jour 1</option>
        //<option value="2">Menu du jour 2</option>
        //<option value="3">Menu pâtes</option>
        //<option value="4">Menu burger</option>
        '<option value="5">Menu végétarien</option>
        </select>
    </div>
    <input class="btn btn-primary mt-4 mb-4" type="Submit">
    </div>
</form>
    ';
}
?>