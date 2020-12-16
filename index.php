<?php
session_start();
/**
 * ETML
 * Auteur :  Cindy Hardegger
 * Date: 22.01.2019
 * Site web en MVC et orienté objet
 */

$debug = false;

if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

}
date_default_timezone_set('Europe/Zurich');

include_once 'controller/Controller.php';
include_once 'controller/HomeController.php';
include_once 'controller/LoginController.php';


class MainController {

    /**
     * Permet de sélectionner le bon contrôler et l'action
     */
    public function dispatch() {

        if (!isset($_GET['controller'])) {
            $_GET['controller'] = 'home';
            $_GET['action'] = 'index';
        }


        $currentLink = $this->menuSelected($_GET['controller']);
        $this->viewBuild($currentLink);
    }

    /**
     * Selectionner la page et instancier le contrôleur
     *
     * @param string $page : page sélectionner
     * @return $link : instanciation d'un contrôleur
     */
    protected function menuSelected ($page) {

        switch($_GET['controller']){
            case 'home':
                $link = new HomeController();
                break;
            case 'catalog':
                $link = new CatalogController();
                break;
            case 'login':
                $link = new LoginController();
                break;
            default:
                $link = new HomeController();
                break;
        }

        return $link;
    }

    /**
     * Construction de la page
     *
     * @param $currentPage : page qui doit s'afficher
     */
    protected function viewBuild($currentPage) {

            $content = $currentPage->display();

            //var_dump($_POST);  
            if(array_key_exists('disconnect', $_POST) && $_POST['disconnect']){
                    $_SESSION = array();
            }

            if($currentPage instanceof LoginController && $_GET['action'] == 'index'){
                echo $content;
            }
            else{
                include(dirname(__FILE__) . '/view/head.php');
                include(dirname(__FILE__) . '/view/header.php');
                echo $content;
                include(dirname(__FILE__) . '/view/footer.php');
            }

            //RAJOUTER controle de connexion sur newbook
    }
}

/**
 * Affichage du site internet - appel du contrôleur par défaut
 */
$controller = new MainController();
$controller->dispatch();