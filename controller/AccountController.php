<?php
/**
 * ETML
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Controler pour gérer les pages classiques
 */

include_once 'model/AccountRepository.php';

class AccountController extends Controller {

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
            $action = 'indexAction'; // listAction
        }

        
        if(method_exists(HomeController::class, $action)){      
            return call_user_func(array($this, $action));
        }
        else{
            return call_user_func(array($this, "indexAction"));
        }

        /*
        $action = $_GET['action'] . "Action"; // listAction

        return call_user_func(array($this, $action));
        */
    }

    /**
     * Display Index Action
     *
     * @return string
     */
    private function indexAction() {

        $view = file_get_contents('view/page/login/index.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
}