<?php
/**
 * ETML
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Controller pour gérer les pages classiques
 */

class HomeController extends Controller
{
    //// Definition des variables ////

    //define("MAXPEPOLEPERTABLE")



    /**
     * Dispatch current action
     *
     * @return mixed
     */
    public function display()
    {
        if(array_key_exists('username', $_SESSION) && isset($_SESSION['username'])){
            include_once 'model/Database.php';
            $database = new Database();
    
            $return = $database->GetUserInfo($_SESSION['username']);
    
            $_SESSION['role'] = $return[0]['useRole'];
            $_SESSION['emailVerif'] = $return[0]['useVerif'];
        }

        $_SESSION['adminRight'] = false;
        if(array_key_exists('role', $_SESSION) && $_SESSION['role'] >= 50){
            $_SESSION['adminRight'] = true;
        }

        if (array_key_exists('action', $_GET)) {
            $action = $_GET['action'] . "Action"; // listAction
        } else {
            //Si $_GET['action'] n'existe pas on le (re)définit
            $_GET['action'] = "Accueil";
            $action = 'AccueilAction'; // listAction
        }

        if ((!array_key_exists('role', $_SESSION) || $_SESSION['role'] < 50) && array_key_exists('action', $_GET)) {
            if ($_GET['action'] == "Option") {
                $action = 'AccueilAction'; // listAction
                $_GET['action'] = 'Accueil';
            }
        }

        // Redirige vers la page "Verif" pour le lien de vérification reçu par email.
        if(array_key_exists('Verif', $_GET) && array_key_exists('Mail', $_GET)){
            $action = 'VerifAction';
        }


        if (method_exists(get_class($this), $action)) {
            return call_user_func(array($this, $action));
        } else {
            return call_user_func(array($this, "AccueilAction"));
        }
    }

    /**
     * Display Index Action
     *
     * @return string
     */
    private function ConnexionAction()
    {
        $view = file_get_contents('view/page/Connexion.php');
        $compte = [];

        if (array_key_exists('submitBtn', $_POST)) {
            if (isset($_POST['submitBtn'])) {
                include_once 'model/Database.php';

                $database = new Database();

                if (array_key_exists('username', $_POST) && $_POST['username'] != "") {

                    $compte = $database->login($_POST['username']);

                    if (array_key_exists('password', $_POST) && $_POST['password'] != "") {
                        if ($compte != -1) {
                            if (password_verify($_POST['password'], $compte['usePassword'])) {
                                $_SESSION['username'] = $compte['useUsername'];
                                $_SESSION['connected'] = true;
                                $_SESSION['loginError'] = null;
                                //Ces variables sont actualiser à chaque changement de page
                                $_SESSION['role'] = $compte['useRole'];
                                $_SESSION['emailVerif'] = $compte['useVerif'];
                                header("Location: index.php?controller=home&action=Accueil");
                            } else {

                                $_SESSION['loginError'] = true;

                                //header("Location: index.php?controller=login&action=index");
                                //echo "mdp erroné - erreur 1";
                            }
                        } else {

                            $_SESSION['loginError'] = true;

                            //header("Location: index.php?controller=login&action=index");
                            // echo "compte n'existe pas - erreur 2";
                        }
                    } else {
                        $_SESSION['loginError'] = true;

                        // echo "pas de mdp inséré - erreur 3";
                    }
                } else {
                    $_SESSION['loginError'] = true;

                    // echo "rien n'est rempli - erreur 4";
                }
            }
        }

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Display Contact Action
     *
     * @return string
     */
    private function RegisterAction()
    {
        $view = file_get_contents('view/page/Inscription.php');

        $_SESSION['registerErrors'] = array();

        if (array_key_exists('submitBtn', $_POST)) {
            if (isset($_POST['submitBtn'])) {

                include_once 'model/Database.php';

                $database = new Database();

                if (!array_key_exists('username', $_POST) || $_POST['username'] == "") {
                    $_SESSION['registerErrors'][] = "Veuillez entrer un nom d'utilisateur.";
                }
                else{
                    //Vérification pour ne pas injecter de code, car il l'exécute lors de l'affichage
                    if($this->verifCodeInput($_POST['username'])){
                        $_SESSION['registerErrors'][] = "Votre nom d'utilisateur ne doit pas contenir ces caractères : ". $GLOBALS['showPattern'];
                    }
                }

                if (!array_key_exists('password', $_POST) || $_POST['password'] == "" || !array_key_exists('confPassword', $_POST) || $_POST['confPassword'] != $_POST['password']) {
                    $_SESSION['registerErrors'][] = "Mots de passe incorrects, veuillez les entrer à nouveau.";
                }

                if (!array_key_exists('email', $_POST) || $_POST['email'] == "") {
                    $_SESSION['registerErrors'][] = "Veuillez remplir le champ Email.";
                } else {
                    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                        $_SESSION['registerErrors'][] = "Veuillez renseigner un mail valide.";
                    }
                    else{
                        //Restriction pour l'inscription au email @eduvaud.ch et @vd.ch
                        if(!(strpos(strtolower($_POST['email']), "@eduvaud.ch") !== false || strpos(strtolower($_POST['email']), "@vd.ch") !== false)) {
                            $_SESSION['registerErrors'][] = "Veuillez inscrire une adresse @eduvaud.ch ou @vd.ch.";
                        }
                    }
                }


                if (!array_key_exists('firstName', $_POST) || $_POST['firstName'] == "") {
                    $_SESSION['registerErrors'][] = "Veuillez remplir le champ Prénom.";
                }
                else{
                    //Vérification pour ne pas injecter de code, car il l'exécute lors de l'affichage
                    if($this->verifCodeInput($_POST['firstName'])){
                        $_SESSION['registerErrors'][] = "Votre prénom ne doit pas contenir ces caractères : ". $GLOBALS['showPattern'];
                    }
                }

                if (!array_key_exists('lastName', $_POST) || $_POST['lastName'] == "") {
                    $_SESSION['registerErrors'][] = "Veuillez remplir le champ Nom.";
                }
                else{
                    //Vérification pour ne pas injecter de code, car il l'exécute lors de l'affichage
                    if($this->verifCodeInput($_POST['lastName'])){
                        $_SESSION['registerErrors'][] = "Votre nom ne doit pas contenir ces caractères : ". $GLOBALS['showPattern'];
                    }
                }

                if (!array_key_exists('username', $_POST) || ($database->userExistsAt(strtolower($_POST['username'])) >= 0)) {
                    $_SESSION['registerErrors'][] = "Nom d'utilisateur déjà présent, veuillez en sélectionner un autre.";
                }

                if (empty($_SESSION['registerErrors'])) {
                    $username = htmlspecialchars($_POST['username']);
                    $firstName = htmlspecialchars($_POST['firstName']);
                    $lastName = htmlspecialchars($_POST['lastName']);

                    $compte = $database->register($username, $_POST['password'], $_POST['email'], $firstName, $lastName, 0);

                    //Vérification que l'email ou le pseudo n'est pas duplique.
                    $error = $compte->errorInfo();
                    //print_r($compte->errorInfo());
                    if($error[1] == 1062){
                        if(strpos($error[2], "useEmail") !== false){
                            $_SESSION['registerErrors'][] = "l'email existe déjà, veuillez le revérifier. Si c'est votre adresse mail vous pouvez contacter l'administrateur par mail au groupe \"ETML_RESTAURANT\" ou par téléphone au 021 316 77 89";
                        }
                        else if(strpos($error[2], "useUsername") !== false){
                            $_SESSION['registerErrors'][] = "Le nom d'utilisateur existe déjà veuillez en entrer un autre";
                        }
                    }
                    else{

                        $idUser = $database->getIdUser($_POST['username']);
                        //Envoie de l'email de vérification
                        $this->sendMailVerifTo($idUser, $_POST['email']);

                        $success = true;
                    }
                }
            }
        }

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Vérifie si le lien recu est le bon
     */
    private function VerifAction()
    {
        //Pour l'utilisation de la BD
        include_once 'model/Database.php';
        $database = new Database();

        if (array_key_exists('Verif', $_GET) && array_key_exists('Mail', $_GET)) {
            if (isset($_GET['Verif']) && isset($_GET['Mail'])) {
                $hash = $_GET['Verif'];
                $mail = $_GET['Mail'];

                //Recherche par rapport au lien et l'email recu en $_GET
                $return = $database->verifLink($hash, $mail);

                //Si la requête retourne 1 c'est que l'utilisateur a bien demandé de vérifier son addresse mail et que le lien est bon
                if(count($return) == 1){
                    //Vérification si le lien est expiré.
                    if($return[0]['verDeadline'] > date("Y-m-d H:i:s")){
                        ///Correct URL
                        $_SESSION['statusLink'] = 1;
                        
                        //Account OK
                        $database->userOk($mail);

                        //Delete all link for this account
                        $database->deleteLink($return[0]['idVerification']);
                    }
                    else{
                        //link expired
                        $_SESSION['statusLink'] = 0;
                    }
                }
                else{
                    //Wrong URL entered or link expired
                    $_SESSION['statusLink'] = 0;
                }
            }
        }
        //Delete all link expired
        $dateNow = date("Y-m-d H:i:s");

        //TODO : a corriger car il ne fonctionne pas
        // Suppression de tout les liens expirer
        $allId = $database->allExpiredLink($dateNow);
        foreach($allId as $id){
            $database->deleteLink($id['idUser']);
        }

        $view = file_get_contents('view/page/Verif.php');
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Display Disconnect Action
     *
     * @return string
     */
    private function DisconnectAction()
    {
        session_destroy();

        header('Location: index.php?controller=home&action=Accueil');
        exit();
    }

    /**
     * Display Home Action
     *
     * @return string
     */
    private function AccueilAction()
    {
        include_once 'model/Database.php';
        $db = new Database();
        
        $allMeals = $db->getAllMeals();

        $_SESSION['meals'] = array();

        $nbrMeal = count($allMeals);
        $dateNow = date("Y-m-d");
        $lastDay = new DateTime("Sunday this week $dateNow");
        $lastDay = date_format($lastDay, 'Y-m-d');
        $firstDay = new DateTime("Monday this week $dateNow");
        $firstDay = date_format($firstDay, 'Y-m-d');

        for($x=0; $x < $nbrMeal; $x++){
            //le plat doit être comprit dans la semaine actuel.
            if($allMeals[$x]['meaStartDate'] <= $lastDay && $allMeals[$x]['meaDeadline'] >= $firstDay){
                if($allMeals[$x]['meaIsCurrentMeal'] == 1 && $allMeals[$x]['meaDisplay'] == 1){
                    array_push($_SESSION['meals'], $allMeals[$x]);
                }
            }
        }

        $view = file_get_contents('view/page/Accueil.php');
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        $db = null;

        return $content;
    }

    /**
     * Display About Action
     *
     * @return string
     */
    private function AproposAction()
    {

        $view = file_get_contents('view/page/Apropos.php');
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Display Contact Action
     *
     * @return string
     */
    private function ContactAction()
    {
        $mailSent = false;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['submitBtn'])) {
                if (isset($_POST['contactNom']) && isset($_POST['contactMsg'])) {
                    if (!empty($_POST['contactNom']) && !empty($_POST['contactMsg'])) {
                        include_once 'model/Database.php';
                        $database = new Database();
                        $database->contactSendMail();

                        $mailSent = true;

                        unset($contactError);
                        unset($_POST);
                    } else {
                        $contactError = true;
                    }
                }
            }
        }

        $view = file_get_contents('view/page/Contact.php');
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Display Option Action
     *
     * @return string
     */
    private function OptionAction()
    {
        // Reset variables
        $_SESSION['menuErrors'] = null;
        $_SESSION['menuSuccess'] = null;
        $_SESSION['menuInfo'] = null;
        $Scrollspy = null;

        // Validation
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['submitBtn'])) {

                $menuErrors = array();

                include_once 'model/Database.php';
                $db = new Database();

                //Comptage du nombre total de menu qui on été afficher sur la page
                $a=0;
                $boucle = true;
                while($boucle){
                    if(isset($_POST['mealName-'. $a])){
                        $a++;
                    }
                    else{
                        $boucle = false;
                    }
                }

                $NbrOfMenu = $a;

                // Meals in DB
                $meals = $db->getAllMeals();

                for($z = 0; $z < $NbrOfMenu; $z++){
                    // reset variable
                    $menuExists = false;
                    $restorMeal = false;

                    $menu = htmlspecialchars($_POST['mealName-'. $z]);

                    if(empty($menu)){
                        $menu = "-";
                    }
                    
                    // Check if they are already in the DB otherwise create them in the DB

                    foreach ($meals as $meal) {
                        if (strtolower($meal['meaName']) == strtolower($menu) && $meal['idMeal'] != $_POST['mealID-'. $z] && ($meal['meaName'] != null || $meal['meaName'] == "-")) {
                            if(!($this->verifCodeInput($meal['meaName']))){
                                //Si le champs meaDisplay est a 0, on le réactive
                                if($meal['meaDisplay'] == 0){
                                    // on va réactiver un ancien plat qui a le même nom et supprimer la row dernièrement créer pour ne pas avoir de double
                                    $db->reactivateMeal($meal['idMeal']);
                                    $db->deleteMealById($_POST['mealID-'. $z]);

                                    $restorMeal = true;
                                }
                                else{
                                    //On a trouvé ce que l'on voulait, c'est à dire un doublon.
                                    $menuExists = true;
                                    break;
                                }
                            }
                            else{
                                $_SESSION['menuErrors'][] = "Veillez ne pas entrer ces caractères dans le nom du plat : ". $GLOBALS['showPattern'];
                            }
                        }
                    }

                    //Savoir si le plat est commandable ou non par l'utilisateur
                    if(isset($_POST['mealCurrentMeal-'. $z])){

                        if($_POST['mealCurrentMeal-'. $z] == "on"){
                            $intCurrentMeal = 1;
                        }
                        elseif($_POST['mealCurrentMeal-'. $z] == "off"){
                            $intCurrentMeal = 0;
                        }
                    }
                    else{
                        $intCurrentMeal = 0;
                    }
                    

                    //message d'erreur car le plat existe déjà dans la DB.
                    if ($menuExists) {
                        $_SESSION['menuErrors'][] = "Le plat (". $menu .") existe déjà, veuillez saisir un autre plat pour le Menu N°". ($z+1);
                    }
                    elseif($_POST['mealStartDate-'. $z] > $_POST['mealDeadline-'. $z]){
                        $_SESSION['menuErrors'][] = "La date du Menu N°". ($z+1) ." (". $menu .") n'est pas correcte. La date de début doit être avant la date de fin";
                    }
                    else{


                        $mealId = $_POST['mealID-'. $z];
                        $mealCurrentMeal = $intCurrentMeal;
                        $mealStartDate = htmlspecialchars($_POST['mealStartDate-'. $z]);
                        $mealDeadline = htmlspecialchars($_POST['mealDeadline-'. $z]);

                        // update row
                        $db->updateMeal($mealId, $menu, $mealCurrentMeal, $mealStartDate, $mealDeadline);
                    }

                    //Autre message
                    if($restorMeal){
                        $_SESSION['menuInfo'][] = "Le menu N° ". ($z+1) ." (". $menu .") existait déjà, mais avait été supprimé. Le plat est maintenant réactivé";
                    }
                }
                // User feedback
                if(!isset($_SESSION['menuErrors'])){
                    $_SESSION['menuSuccess'] = true;
                    $Scrollspy = "#changeMenu";
                }

                $db = null;
            }
            elseif(isset($_POST['addMenu'])){
                include_once 'model/Database.php';
                $db = new Database();

                $db->addNewMeal();
            }
        }

        //Permet de supprimer un plat si il est inscrit dans l'URL
        if(isset($_GET['supprMeal'])){
            //Vérifie si la personne connecter est admin
            if($_SESSION['role'] > 50){
                include_once 'model/Database.php';
                $db = new Database();
    
                $db->deleteMealById($_GET['supprMeal']);
    
                header("Location: index.php?controller=home&action=Option$Scrollspy");
            }
        }
        // End validation

        include_once 'model/Database.php';

        $db = new Database();

        //Variable en SESSION afin de pouvoir récupérer l'information dans la prochaine page
        $_SESSION['meals'] = $db->getAllMealsDisplayed();
        // $_SESSION['$currentMeals'] = $db->getCurrentMeals(); - Old

        $view = file_get_contents('view/page/Option.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        $db = null;

        return $content;
    }

    /**
     * Display Parameters Action
     *
     * @return string
     */
    private function ParametreAction()
    {

        $view = file_get_contents('view/page/Parametre.php');


        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Display Recap Action
     *
     * @return string
     */
    private function RecapAction()
    {
        include_once 'model/Database.php';
        $database = new Database();

        $currentDate = date('Y-m-d');

        //DB requet qui récupère tous les plat commandé avec le nom des personnes
        $allReservation = $database->allMealsReserved($currentDate);
        //echo($currentDate ." ");
        $nbrOfMeal = $database->getNumberofAllMeal($currentDate);

        $_SESSION['allReservation'] = $allReservation;
        $_SESSION['nbrOfMeal'] = $nbrOfMeal;

        $view = file_get_contents('view/page/Recap.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        $database = null;

        return $content;
    }

    /**
     * Verifie si la commande a supprimer est bien celle du l'utilisateur
     * 
     * 
     */
    private function VerifieDeleteOrder($id){
        include_once 'model/Database.php';
        $database = new Database();

        //Recherche dans BD de toutes ces commandes
        $result=$database->readReservationUser($_SESSION['username']);

        $okDelete = false;

        //Comparaisons des résultats
        for($x=0 ; $x < count($result) ; $x++){
            if($id == $result[$x]['idReservation']){
                $okDelete = true;
            }
        }

        if($okDelete){
            $database->deleteOrder($id);
        }
    }

    /**
     * Display Command Action
     *
     * @return string
     */
    private function CommanderAction()
    {
        $maxorderperday=1;

        include_once 'model/Database.php';
        $database = new Database();

        // VALIDATION
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['submitBtn'])) {

                $sResDate = 'resDate';
                //$sResTable = 'resTable';
                $sResHour = 'resHour';
                $sResMeal = 'resMeal';
                $dDateRegex = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';

                $commandErrors = array();

                //if (array_key_exists($sResTable, $_POST) && $_POST[$sResTable] > 0 && $_POST[$sResTable] < 19)
                if (!array_key_exists($sResDate, $_POST) || !preg_match($dDateRegex, $_POST[$sResDate]) || date('Y-m-d') >= date('Y-m-d', strtotime($_POST[$sResDate]))) {
                    $commandErrors[] = "Veuillez entrer une date à partir de demain, dans un format correct.";
                }
                else {
                    $weekDay = date("w", strtotime($_POST[$sResDate]));
                    if ($weekDay == 0 || $weekDay == 6) {
                        $commandErrors[] = "Veuillez choisir une date en semaine, et non pas un samedi/dimanche.";
                    }
                }

                // Si une heure est définie
                if (!array_key_exists($sResHour, $_POST) || ($_POST[$sResHour] != 11 && $_POST[$sResHour] != 12)) {
                    $commandErrors[] = "Veuillez entrer une heure correcte.";
                }

                // Si un plat est sélectionner
                if (!array_key_exists($sResMeal, $_POST)) {
                    $commandErrors[] = "Veuillez entrer un type de plat correct.";
                } else {
                    $meal = $database->getMeal($_POST[$sResMeal]);
                    if ($meal < 0 || !$meal['meaIsCurrentMeal']) {
                        $commandErrors[] = "Veuillez entrer un type de plat correct.";
                    }
                }

                //Si l'utilisateur est connecté
                if (!array_key_exists('username', $_SESSION)) {
                    $commandErrors[] = "Veuillez vous connecter pour ajouter une réservation.";
                }

                if (!array_key_exists('resMeal', $_POST) || $_POST['resMeal'] == 0) {
                    $commandErrors[] = "Veuillez entrer un plat valide.";
                }

                //Si l'email est vérifié
                if(array_key_exists('emailVerif', $_SESSION) && isset($_SESSION['emailVerif'])){
                    if($_SESSION['emailVerif'] == 0){
                        $commandErrors[] = "Votre adresse mail n'est pas valide";
                    }
                }
                else{
                    $commandErrors[] = "Votre adresse mail n'est pas valide";
                }

                //Regarde si l'utilisateur n'a pas déjà une réservation à cette date
                $result=$database->readReservationUserDate($_SESSION['username'], $_POST[$sResDate]);

                if(count($result) == $maxorderperday){
                    $commandErrors[] = "Vous avez déjà réservé " . $maxorderperday . " fois pour cette date";
                }

                if (count($commandErrors) == 0) {
                    $date = htmlspecialchars($_POST[$sResDate]);
                    //$table = $_POST[$sResTable];
                    $hour = htmlspecialchars($_POST[$sResHour]);
                    $meal = htmlspecialchars($_POST[$sResMeal]);
                    
                    
                    //that condition is for checking wether the reservation exists already, only one reservation per date/table and hour - only one reservation per personne/day
                    //if ($database->reservationExistsAt($date, $table, $hour) < 0) {
                    $database->addReservation($date, 0 /*, $table*/, $hour, $meal, $database->getIdUser($_SESSION['username']));
                    //echo 'Réservation ajoutée !<br>';
                    $_SESSION['CommandDone'] = true;
                    $_SESSION['CommandTemp'] = $_POST;
                    //}
                }
            }
        }

        //Permet de 
        if(isset($_GET['Delete'])){
            $this->VerifieDeleteOrder($_GET['Delete']);
            header('Location: index.php?controller=home&action=Commander');
        }

        // END VALIDATION
        $_SESSION['currentMeals'] = $database->getCurrentMeals();

        if(array_key_exists('emailVerif', $_SESSION) && isset($_SESSION['emailVerif'])){
            if($_SESSION['emailVerif'] == 1){
                $view = file_get_contents('view/page/Commander.php');
            }
            else{
                $view = file_get_contents('view/page/Commander.php');
            }
        }
        else{
            $view = file_get_contents('view/page/Commander.php');
        }

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Envoie un email de vérification
     */
    private function sendMailVerifTo($idUser, $mail){
        include_once 'model/Database.php';
        $database = new Database();

        //TODO : Raccourcir le lien en enlevant le GET['home'] et GET['action']
        $actual_link = "http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $hashLink = "&Verif=";

        //rand() génère un chiffre entre 0 et 7843976 puis md5() va le transformer en phrase de 32 caracteres
        $hash = md5(rand(0,7843976));

        $mailLink = "&Mail=" . $mail;

        //Creation du lien
        $alllink = $actual_link . $hashLink . $hash . $mailLink;

        $date = date("Y-m-d H:i:s", strtotime("+1 days"));

        $database->addNewHash($hash, $date, $idUser);

        $database->sendVerifMail($alllink, $mail);
    }
    
    private function CompteAction(){
        include_once 'model/Database.php';
        $database = new Database();

        $_SESSION['success'] = null;
        $_SESSION['Errors'] = null;

        //Permet de charger les information de l'utilisateur si il est connecté
        if (array_key_exists('username', $_SESSION) && isset($_SESSION['username'])){ 
            $return = $database->GetUserInfo($_SESSION['username']);

            $_SESSION['allUserInfo'] = $return[0];

            $view = file_get_contents('view/page/Compte.php');
        }
        else{
            $view = file_get_contents('view/page/Accueil.php');
        }
        
        // Permet d'envoyer un email de vérification
        if(array_key_exists('verifier', $_POST) && isset($_POST['verifier'])){
            $idUser = $database->getIdUser($_SESSION['username']);
            $userInfo = $database->GetUserInfo($_SESSION['username']);

            $mail = $userInfo[0]['useEmail'];

            //Vérifie si l'email envoyer contient @eduvaud.ch ou @vd.ch
            if(strpos(strtolower($mail), "@eduvaud.ch") !== false || strpos(strtolower($mail), "@vd.ch") !== false){
                //Envoie de l'email de vérification
                $this->sendMailVerifTo($idUser, $mail);

                $_SESSION['success'] = true;
            }
            else{
                $_SESSION['Errors'][] = "l'email de ce compte n'est pas @eduvaud.ch ou @vd.ch. Veillez recréer un compte afin de pouvoir commandé un plat.";
            }
        }

        unset($_POST['verifier']);

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    //Permet de vérifier si du code se trouve dans la variable
    //C'est pour éviter de l'injection de code dans la base de donnée.
    private function verifCodeInput($inpute){
        //Tous les caractères à exclure pour ne pas a avoir du code exécutable lors de l'affichage.
        $pattern = '(<|>|"|;|/|!|_)';
        //Permet d'afficher les caractères qui ne doivent pas être entré lors de l'affichage de l'erreur.
        $GLOBALS['showPattern'] = "< > \" ; / ! _";

        //Vérification de $inpute
        if(preg_match($pattern, strtolower($inpute)) == true){
            return true;
        }
        else{
            return false;
        }
    }
}