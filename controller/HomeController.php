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

        $view = file_get_contents('view/page/Connexion.php');
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