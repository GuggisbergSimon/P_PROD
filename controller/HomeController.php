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

        if (!array_key_exists('role', $_SESSION)) $_SESSION['role'] = 0;

        if ($_GET['action'] == 'Option' && $_SESSION['role'] < 50) {
            $action = 'AccueilAction'; // listAction
            $_GET['action'] = 'Accueil';
        }

        if (method_exists(get_class($this), $action)) {
            return call_user_func(array($this, $action));
        } else {
            return call_user_func(array($this, "AccueilAction"));
        }

        //return call_user_func(array($this, $action));
    }

    /**
     * Display Index Action
     *
     * @return string
     */
    private function ConnexionAction()
    {
        //var_dump($_POST);
        $view = file_get_contents('view/page/Connexion.php');
        $compte;

        if (array_key_exists('login', $_POST)) {
            if ($_POST['login'] == true) {
                include_once 'model/Database.php';

                $registerRepository = new Database();

                if (array_key_exists('username', $_POST) && $_POST['username'] != "") {

                    $compte = $registerRepository->login($_POST['username']);

                    if (array_key_exists('password', $_POST) && $_POST['password'] != "") {
                        if ($compte != -1) {
                            if ($compte['usePassword'] != array() && password_verify($_POST['password'], $compte['usePassword'])) {
                                if ($_POST['password'] && $_POST['username']) {
                                    echo '<h1 class="mt-3 text-center text-success" >VOUS VOUS ETES CONNECTES</h1>';
                                    $_SESSION['username'] = $compte['useUsername'];
                                    $_SESSION['role'] = $compte['useRole'];
                                    $_SESSION['connected'] = true;
                                    $_SESSION['loginError'] = null;
                                    header("Location: index.php?controller=home&action=Accueil");
                                } else {

                                    $_SESSION['loginError'] = true;

                                    //header("Location: index.php?controller=login&action=index");
                                    echo "erreur 1";
                                }
                            } else {

                                //TODO: A CHECK
                                $_SESSION['loginError'] = true;

                                //header("Location: index.php?controller=login&action=index");
                                echo "erreur 2";
                            }
                        } else {
                            $_SESSION['loginError'] = true;

                            echo "erreur 3";
                        }
                    } else {
                        $_SESSION['loginError'] = true;

                        echo "erreur 4";
                    }
                } else {
                    $_SESSION['loginError'] = true;

                    echo "erreur 5";
                }

            }
        }

        /*
        if(array_key_exists('password', $_POST)){
            if($_POST['password'] == $compte[0]['usePassword']){
                if($_POST['password'] && $_POST['username']){
                    echo '<h1 class="mt-3 text-center text-success" >VOUS VOUS ETES CONNECTES</h1>';
                    $_SESSION['username'] = $compte[0]['useUsername'];
                    $_SESSION['connected'] = true;
                }
                else{

                    $_SESSION['loginError'] = true;

                    //header("Location: index.php?controller=login&action=index");
                    echo "erreur 1";
                }
            }
            else{
                $_SESSION['loginError'] = true;

                //header("Location: index.php?controller=login&action=index");
                echo "erreur 2";
            }
        }
        else{
            if(array_key_exists('username', $_POST)){
                //header("Location: index.php?controller=login&action=index");
                echo "erreur 3";
            }
            else{
                //header("Location: index.php?controller=home&action=index");
                echo "erreur 4";
            }
        }
    }*/

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

        //var_dump($_POST);
        $view = file_get_contents('view/page/Inscription.php');

        if (array_key_exists('register', $_POST)) {

            if ($_POST['register'] == true) {
                include_once 'model/Database.php';

                $registerRepository = new Database();

                if (array_key_exists('username', $_POST) && $_POST['username'] != "") {
                    if (array_key_exists('password', $_POST) && $_POST['password'] != "" && array_key_exists('confPassword', $_POST) && $_POST['confPassword'] == $_POST['password']) {
                        if (array_key_exists('email', $_POST) && $_POST['email'] != "") {
                            if (array_key_exists('firstName', $_POST) && $_POST['firstName'] != "") {
                                if (array_key_exists('lastName', $_POST) && $_POST['lastName'] != "") {
                                    if ($_POST['password'] && $_POST['username'] && ($registerRepository->userExistsAt($_POST['username']) < 0)) {
                                        $compte = $registerRepository->register($_POST['username'], $_POST['password'], $_POST['email'], $_POST['firstName'], $_POST['lastName']);
                                        echo '<h1 class="mt-3 text-center text-success" >VOUS VOUS ETES INSCRIS </h1>';
                                        $_SESSION['username'] = $compte[0]['useUsername'];
                                        //$_SESSION['connected'] = true;
                                    } else {

                                        $_SESSION['registerError'] = true;

                                        //header("Location: index.php?controller=login&action=index");
                                        echo "Nom d'utilisateur déjà présent, veuillez en sélectionner un autre.";
                                    }
                                } else {
                                    $_SESSION['registerError'] = true;

                                    echo "Veuillez remplir le champ Nom.";
                                }
                            } else {
                                $_SESSION['registerError'] = true;

                                echo "Veuillez remplir le champ Prénom.";
                            }
                        } else {
                            $_SESSION['registerError'] = true;

                            echo "Veuillez remplir le champ Email.";
                        }
                    } else {
                        $_SESSION['registerError'] = true;

                        echo "Mots de passe incorrects, veuillez l'entrer à nouveau.";
                    }
                } else {
                    $_SESSION['registerError'] = true;

                    echo "Veuillez entrez un nom d'utilisateur.";
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
    private
    function DisconnectAction()
    {

        //unset($_SESSION['username']);
        $_SESSION = array();

        header('Location: index.php?controller=home&action=Accueil');
    }

    /**
     * Display Contact Action
     *
     * @return string
     */
    private
    function AccueilAction()
    {

        $view = file_get_contents('view/page/Accueil.php');
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * @return false|string$
     */
    private
    function ValidateReservationAction()
    {
        $view = file_get_contents('controller/validatingReservation.php');
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * @return false|string$
     */
    private
    function DisplayDayAction()
    {
        $view = file_get_contents('controller/displayDay.php');
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
    private
    function AproposAction()
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
    private
    function ContactAction()
    {

        $view = file_get_contents('view/page/Contact.php');
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
    private
    function OptionAction()
    {

        $view = file_get_contents('view/page/Option.php');


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
    private
    function ParametreAction()
    {

        $view = file_get_contents('view/page/Parametre.php');


        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private
    function CommanderAction()
    {

        $view = file_get_contents('view/page/Commander.php');


        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
}