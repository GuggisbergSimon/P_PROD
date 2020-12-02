<?php
/**
 * ETML
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Controler pour gérer les pages classiques
 */

class HomeController extends Controller {

    /**
     * Dispatch current action
     *
     * @return mixed
     */
    public function display() {

        
        if(array_key_exists('action', $_GET)){
            $action = $_GET['action'] . "Action"; // listAction
        }
        else{
            $action = 'ConnexionAction'; // listAction
        }

        
        if(method_exists(get_class($this), $action)){      
            return call_user_func(array($this, $action));
        }
        else{
            return call_user_func(array($this, "ConnexionAction"));
        }

        //return call_user_func(array($this, $action));
    }

    /**
     * Display Index Action
     *
     * @return string
     */
    private function ConnexionAction() {
        var_dump($_POST);
        $view = file_get_contents('view/page/Connexion.php');
        $compte;
if(array_key_exists('login', $_POST)){
    if($_POST['login'] == true){
        include_once 'model/RegisterRepository.php';

        $registerRepository = new RegisterRepository();
        
        $compte = $registerRepository->login($_POST['username'])->fetchAll();
    }
    
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
    private function AproposAction() {

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
    private function ParametreAction() {

        $view = file_get_contents('view/page/Parametre.php');


        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function CommandeAction() {

        $view = file_get_contents('view/page/Commande.php');


        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
}