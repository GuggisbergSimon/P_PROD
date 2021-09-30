<?php

include_once "model/Database.php";
include_once "controller/HomeController.php";

$database = new Database();
$controller = new HomeController();

//todo choix de tables mis en commentaires pour le moment, à rétablir si besoin est
if (!array_key_exists('username', $_SESSION)) {
    header("Location: index.php?controller=home&action=Connexion");
    exit();
} else {

    echo '
    

    <form action="#" method="post">
        <div class="container">

            <h3>Commander un plat</h3>
            <div class="ligne"></div>';

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
            ?>
            <div class="form-group mt-4">
                <label>Date de la réservation : </label>
                <input onchange="dateChange(this.value)" class="form-control" type="date" name="resDate" id="dateOrder" min="<?php echo(date("Y-m-d", strtotime("+1 days"))); ?>">
            </div>
            <div class="form-group">
                <label for="selectMeal">Plat choisit : </label>
                <select class="form-control selectedMeal" id="selectMeal" name="resMeal">
                    <option disabled selected>----- Sélection du plat -----</option>
                </select>
            </div>
            <div class="form-group">
                <label for="selectHour">Heure choisit : </label>
                <select class="form-control selectedMea2" id="selectHour" name="resHour">
                    <option disabled selected>----- Sélection de l'heure -----</option>
                    <option value="11">11h20 - 12h00</option>
                    <option value="12">12h10 - 12h50</option>
                </select>
            </div>
            <input class="btn btn-primary mt-4 mb-4" name="submitBtn" type="submit" value="Commander">
        </div>
    </form>
    <?php
        //Recherche des reservation de l'utilisateur.
        $result=$database->readReservationUser($_SESSION['username']);
    ?>

    <!-- tableau de plats commandé -->
    <div class="container">
        <h3>Plat commandé</h3>
        <div class="ligne"></div>
        <?php
            if(count($result) != 0){
        ?>
        <table class="table">
        <thead>
            <tr>
            <th scope="col">Date</th>
            <th scope="col">Heure de la réservation</th>
            <th scope="col">Plat choisi</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php

    
        for($y=0; $y < count($result); $y++){
            $newDate = date("d.m.Y", strtotime($result[$y]['resDate']));
            $meaname=$result[$y]["meaName"];
            echo("<tr>");
                
            //date
            echo"<td>$newDate</td>";

            //Heur réservée
            if($result[$y]["resHour"] == 11){
                echo("<td>11h20 - 12h</td>");
            }
            elseif($result[$y]["resHour"] == 12){
                echo("<td>12h10 - 12h50</td>");
            }
            else{
                echo("<td>... - ...</td>");
            }
            
            //Nom du plat
            echo("<td>$meaname</td>");

            //Action
            echo("<td>");



            echo("<form method='post' action='#'>");
            //<!-- <a onclick="modifieorder($result[$y]['idReservation']);"><i class="fas fa-edit"></i></a>' -->
            if($newDate != date("d.m.Y")){
                echo('<a href="?controller=home&action=Commander&Delete=' .$result[$y]["idReservation"]. '"><i class="fas fa-trash-alt"></i></a>');
            }
            
            ?>
            <?php
            echo("</form>");
            ?>
            <div id='hello'></div>
            <?php
            echo("</td>");
            echo("</tr>");
        }
    }
    else{
        echo("<h3 style='height: 100px;'>Aucun plat commandé</h3>");
    }
    
    ?>
    </tbody>
    </table>

</div>
    <?php
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
            echo 'Date : ' . date('d.m.Y', strtotime($_SESSION['CommandTemp']['resDate'])) . '<br>Heure : ';
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
            echo $database->getMeal($_SESSION['CommandTemp']['resMeal'])['meaName'];
            ?></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>
    
    <?php
    unset($_SESSION['CommandDone']);
    unset($_SESSION['CommandTemp']);

}

// Transformation d'un tableau SQL en tableau JSON pour qu'il soit facilement mit en tableau par le javascript
function getData(){
    
    //Mise en variable de tout les plats
    $data = $_SESSION['currentMeals'];

    //Debut du tableau
    $strarray = "{";

    //Creation du contenu du tableau
    for($d=0; $d < count($data); $d++){

        //Si la date entre se trouve entre les dates de commande du plat
        if($data[$d]['meaStartDate'] <= date("Y-m-d") && $data[$d]['meaDeadline'] >= date("Y-m-d")){

            //Permet de séparer chaque tableau entre eux sauf le premier
            if($d != 0){
                $strarray .= ',';
            }
            $strarray .= '"'. $d . '":{';
            $strarray .= '"idMeal":"'. $data[$d]['idMeal'] .'",';
            $strarray .= '"meaName":"'. $data[$d]['meaName'] .'",';
            $strarray .= '"meaPicturePath":"'. $data[$d]['meaPicturePath'] .'",';
            $strarray .= '"meaIsCurrentMeal":"'. $data[$d]['meaIsCurrentMeal'] .'",';
            $strarray .= '"meaStartDate":"'. $data[$d]['meaStartDate'] .'",';
            $strarray .= '"meaDeadline":"'. $data[$d]['meaDeadline'] .'",';
            $strarray .= '"meaDisplay":"'. $data[$d]['meaDisplay'] .'"}';
        }
    }
    //Fin du tableau
    $strarray .= "}";

    //Retour du tableau en format JSON
    return $strarray;
}
?>

<script type="text/javascript">
    //Affiche dynamiquement les plats disponible selon la date sélectionner
    function dateChange(val) {
        var dateSelected = val;

        //Récupère le string JSON et le transforme en tableau
        tempMeal = '<?php echo getData(); ?>';
        allmeals = JSON.parse(tempMeal);

        //Supprimer toutes les plats ajouter
        suppAllOption();

        //Ajout le(s) plat(s) disponible à la date sélectionné
        for(var meal in allmeals){
            if(dateSelected >= allmeals[meal]['meaStartDate'] && dateSelected <= allmeals[meal]['meaDeadline']){
                addOption(allmeals[meal]);
            }
        }
    }

    //Permet d'ajouter un plat au dropdown
    function addOption(meal){

        //selectionne l'element suivant sont id
        option = document.querySelector('.selectedMeal');

        //Ajout le code HTML a l'element selectionner
        option.innerHTML += "<option value='" + meal['idMeal'] + "'>" + meal['meaName'] + "</option>";
    }

    //Supprime tout les choix et remet celui de base
    function suppAllOption() {
        div = document.querySelector('.selectedMeal');
        while (div.firstChild) {
            div.removeChild(div.firstChild);
        }

        div.innerHTML += "<option disabled selected>----- Sélection du plat -----</option>";
    }
</script>