<?php

echo '
<body>
<a href="displayDay.php?day=09-12-2020">Test Display Day</a>
<a onclick="return confirm(\'Êtes vous sûr de vouloir supprimer cet utilisateur ? \');" href="deleteTeacher.php">Supprimer utilisateur</a>
    <form action="validatingReservation.php" method="post">
        <p>
            <label>Date de la réservation : </label>
            <input type="date" name="resDate">
        </p>
        <p>
            <label>Numéro de table</label>
            <input type="number" name="resTable" min="1" max="18" value="1">
        </p>
        <p>
            <label>Heure de la réservation</label>
            <select name="resHour">
                <option value="Choose">Choisir</option>
                <option value="11">11h20-12h</option>
                <option value="12">12h10-13h50</option>
            </select>
        </p>
        <p>
            <label>Plat choisi : </label>
            <select name="resMeal">
                <option value="0">Choisir</option>
                <option value="1">Menu du jour 1</option>
                <option value="2">Menu du jour 2</option>
                <option value="3">Menu pâtes</option>
                <option value="4">Menu burger</option>
                <option value="5">Menu végétarien</option>
            </select>
        </p>
        <input type="Submit">
    </form>
</body>
';