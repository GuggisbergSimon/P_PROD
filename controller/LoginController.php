<?php
/**
 * ETML
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Controler pour gérer les pages classiques
 */

include_once 'model/RegisterRepository.php';

class LoginController extends Controller {

    /**
     * Dispatch current action
     *
     * @return mixed
     */
    public function display() {

        $action = $_GET['action'] . "Action"; // listAction

        return call_user_func(array($this, $action));
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

    private function registerAction() {
        //$registerRepository = new RegisterRepository();
        //$compte = $registerRepository->login('test')->fetchAll();*/
        //$registerRepository = new RegisterRepository();
        //$compte = $registerRepository->register($_POST['username'], $_POST['password']);

        $registerRepository = new RegisterRepository();
        $compte = $registerRepository->accountCreation();

        $view = file_get_contents('view/page/login/register.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function loginAction() {

        $registerRepository = new RegisterRepository();
        $compte = $registerRepository->login($_POST['username'])->fetchAll();

        $view = file_get_contents('view/page/login/logintest.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Check Form action
     *
     * @return string
     */
    private function checkAction() {

        $lastName = htmlspecialchars($_POST['lastName']);
        $firstName = htmlspecialchars($_POST['firstName']);
        $answer = htmlspecialchars($_POST['answer']);

        $view = file_get_contents('view/page/home/resume.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
}