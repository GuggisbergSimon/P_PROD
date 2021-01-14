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

if(array_key_exists('CommandDone', $_SESSION) && $_SESSION['CommandDone']){
    echo 
    '
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
            <p> Commande bien effectuée pour le ';
            echo $_SESSION['CommandTemp']['resDate'] . ' de ';
            switch ($_SESSION['CommandTemp']['resHour']) {
                case 11:
                    echo "11h20 à 12h00 ";
                    break;
                case 12:
                    echo '12h10 à 12h50 ';
                    break;
                default:
                    echo 'heure non reconnue ';
                    break;
            }
            echo '. Vous avez commandé : ';
            switch ($_SESSION['CommandTemp']['resMeal']) {
                case 5:
                    echo "plat végétarien";
                    break;
                default:
                    echo 'plat non reconnu';
                    break;
            }
            echo '</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>';

    //var_dump($_SESSION);
    //var_dump($_SESSION['CommandTemp']);

    unset($_SESSION['CommandDone']);
    unset($_SESSION['CommandTemp']);
    //var_dump($_SESSION);

    //var_dump($_SESSION);

    echo "<script> $('#myModal').modal('show');</script>";
}
?>