<?php
/**
 * ETML
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Controller pour gérer les pages classiques
 */

class HomeController extends Controller
{

    /**
     * Dispatch current action
     *
     * @return mixed
     */
    public function display()
    {

        if (array_key_exists('action', $_GET)) {
            $action = $_GET['action'] . "Action"; // listAction
        } else {
            $action = 'AccueilAction'; // listAction
        }

        if (!array_key_exists('role', $_SESSION) || $_SESSION['role'] < 50) {
            if ($_GET['action'] == "Option") {
                $action = 'AccueilAction'; // listAction
                $_GET['action'] = 'Accueil';
            }
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

                $registerRepository = new Database();

                if (array_key_exists('username', $_POST) && $_POST['username'] != "") {

                    $compte = $registerRepository->login($_POST['username']);

                    if (array_key_exists('password', $_POST) && $_POST['password'] != "") {
                        if ($compte != -1) {
                                if (password_verify($_POST['password'], $compte['usePassword'])) {
                                    $_SESSION['username'] = $compte['useUsername'];
                                    $_SESSION['role'] = $compte['useRole'];
                                    $_SESSION['connected'] = true;
                                    $_SESSION['loginError'] = null;
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
        
        $registerErrors = array();

        if (array_key_exists('submitBtn', $_POST)) {
            if (isset($_POST['submitBtn'])) {

                include_once 'model/Database.php';

                $registerRepository = new Database();

                if (!array_key_exists('username', $_POST) || $_POST['username'] == "") {
                    $registerErrors[] = "Veuillez entrez un nom d'utilisateur.";
                }

                if (!array_key_exists('password', $_POST) || $_POST['password'] == "" || !array_key_exists('confPassword', $_POST) || $_POST['confPassword'] != $_POST['password']) {
                    $registerErrors[] = "Mots de passe incorrects, veuillez les entrer à nouveau.";
                }

                if (!array_key_exists('email', $_POST) || $_POST['email'] == "") {
                    $registerErrors[] = "Veuillez remplir le champ Email.";
                } else {                    
                    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                        $registerErrors[] = "Veuillez renseigner un mail valide.";
                    }
                }


                if (!array_key_exists('firstName', $_POST) || $_POST['firstName'] == "") {
                    $registerErrors[] = "Veuillez remplir le champ Prénom.";   
                }

                if (!array_key_exists('lastName', $_POST) || $_POST['lastName'] == "") {
                    $registerErrors[] = "Veuillez remplir le champ Nom.";   
                }

                if (!array_key_exists('username', $_POST) || ($registerRepository->userExistsAt(strtolower($_POST['username'])) >= 0)) {
                    $registerErrors[] = "Nom d'utilisateur déjà présent, veuillez en sélectionner un autre.";
                }

                if (empty($registerErrors)) {
                    $compte = $registerRepository->register($_POST['username'], $_POST['password'], $_POST['email'], $_POST['firstName'], $_POST['lastName'], 0);
                    unset($_POST);
                    $success = true;
                }
            }
        }

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

        $view = file_get_contents('view/page/Accueil.php');
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

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

        $view = file_get_contents('view/page/Option.php');


        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

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
        $view = file_get_contents('view/page/Recap.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Display Command Action
     * 
     * @return string
     */
    private function CommanderAction()
    {
        // VALIDATION
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['submitBtn'])) {
                include_once 'model/Database.php';

                $database = new Database();
                $sResDate = 'resDate';
                //$sResTable = 'resTable';
                $sResHour = 'resHour';
                $meals = $database->readTable('t_meal');
                $sResMeal = 'resMeal';
                $dDateRegex = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';

                $commandErrors = array();
        
                //if (array_key_exists($sResTable, $_POST) && $_POST[$sResTable] > 0 && $_POST[$sResTable] < 19)
                if (!array_key_exists($sResDate, $_POST) || !preg_match($dDateRegex, $_POST[$sResDate]) || date('Y-m-d') > date('Y-m-d', strtotime($_POST[$sResDate]))) {
                    $commandErrors[] = "Veuillez entrer une date à partir de demain, dans un format correct.";
                }
        
                if (!array_key_exists($sResHour, $_POST) || ($_POST[$sResHour] != 11 && $_POST[$sResHour] != 12)) {
                    $commandErrors[] = "Veuillez entrer une heure correcte.";
                }
        
                if (!array_key_exists($sResMeal, $_POST) || !array_key_exists($_POST[$sResMeal], $meals) ) {
                    //TODO check that the meal selected is selected in db
                    $commandErrors[] = "Veuillez entrer un type de plat correct.";
                }
        
                if (!array_key_exists('username', $_SESSION)) {
                    $commandErrors[] = "Veuillez vous connectez pour ajouter une réservation.";
                }
        
                if (count($commandErrors) == 0) {
                    $date = $_POST[$sResDate];
                    //$table = $_POST[$sResTable];
                    $hour = $_POST[$sResHour];
        
                    //that condition is for checking wether the reservation exists already, only one reservation per date/table and hour
                    //TODO rework it to handle limit of 4 people per table
                    //if ($database->reservationExistsAt($date, $table, $hour) < 0) {
                    $database->addReservation($date, 0 /*$table*/, $hour, $_POST[$sResMeal], $database->getIdUser($_SESSION['username']));
                    //echo 'Réservation ajoutée !<br>';
                    $_SESSION['CommandDone'] = true;
                    $_SESSION['CommandTemp'] = $_POST;
                    //}
                }
            }
        }
        // END VALIDATION

        $view = file_get_contents('view/page/Commander.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }


}