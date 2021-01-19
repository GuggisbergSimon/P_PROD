<?php

//todo choix de tables/menus mis en commentaires pour le moment, à rétablir
if (!array_key_exists('username', $_SESSION)) {
    header("Location: index.php?controller=home&action=Connexion");
    exit();
} else {

    echo '
<form action="#" method="post">
    <div class="container">';

    if (isset($commandErrors)) {
        if (count($commandErrors) > 0) {
    ?>
            <div class="alert alert-danger mt-5">
                Oups ... Nous avons rencontré quelques erreurs :<br>
                <ul class="mb-0">
    <?php
                foreach ($commandErrors as $error) {
                    echo "<li>$error</li>";
                }
    ?>
                </ul>
            </div>
    <?php
        }
    }

    echo '
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
    <input class="btn btn-primary mt-4 mb-4" name="submitBtn" type="submit">
    </div>
</form>
    ';
}

if (array_key_exists('CommandDone', $_SESSION) && $_SESSION['CommandDone']) {
?>
    <!-- Modal -->
    <div class="modal" tabindex="-1" role="dialog" id="myModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Commande réalisée</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="mb-2"> Commande suivante bien effectuée :<br>
            <?php
            echo 'Date (yyyy-mm-dd) : ' . $_SESSION['CommandTemp']['resDate'] . '<br>Heure : ';
            switch ($_SESSION['CommandTemp']['resHour']) {
                case 11:
                    echo "11h20 à 12h00";
                    break;
                case 12:
                    echo '12h10 à 12h50';
                    break;
                default:
                    echo 'Heure non reconnue';
                    break;
            }
            echo '<br>Plat : ';
            switch ($_SESSION['CommandTemp']['resMeal']) {
                case 5:
                    echo "Plat végétarien";
                    break;
                default:
                    echo 'Plat non reconnu';
                    break;
            }
            ?></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>

    
    <script>
        $('#myModal').modal('show');
    </script>

    <?php
    unset($_SESSION['CommandDone']);
    unset($_SESSION['CommandTemp']);

}
?>