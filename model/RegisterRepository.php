<?php
/**
 * ETML
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Recueil des méthodes permettant de charger les données pour les clients
 */

include_once 'Entity.php';

class RegisterRepository implements Entity {

    private $bdd;

    public function __construct()
    {
        // SQL stuff
        try
        {
            $this->bdd = new PDO('mysql:host=localhost;dbname=bd_p_prod;charset=utf8', 'root', 'root');
        }
        catch (Exception $e)
        {
                die('Erreur : ' . $e->getMessage());
        }
    }
    
    /**
     * Récupérer tous les clients
     *
     * @return array
     */
    public function findAll() {

        try
        {
            $this->bdd = new PDO('mysql:host=localhost;dbname=bdwebprojet;charset=utf8', 'root', 'root');
        }
        catch (Exception $e)
        {
                die('Erreur : ' . $e->getMessage());
        }
        $lstCat = $this->bdd->query("SELECT * FROM t_book natural join t_user natural join t_category");

        return $lstCat;

    }

    public function register($username, $password) {

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $insertUser = "INSERT INTO t_user (usePseudo, usePassword, useDate) VALUES ('" . $username . "' , '" . $passwordHash . "', CURDATE())";

        if ($this->bdd->query($insertUser) == TRUE) {
            echo "New record created successfully";
        } 
        else {  
            echo "Error: " . $insertUser . "<br>";
        }
    }

    public function login($username) {

        $userList = $this->bdd->query("SELECT * FROM t_user WHERE useUsername = '$username'");

        return $userList;
    }

    public function accountLoginVerification() {

        if(array_key_exists('password', $_POST)){
            if(password_verify($_POST['password'], $compte[0]['usePassword'])){
                if($_POST['password'] && $_POST['username']){
                    echo '<h1 class="mt-3 text-center text-success" >VOUS VOUS ETES CONNECTES</h1>';
                    $_SESSION['username'] = $compte[0]['usePseudo'];
                    $_SESSION['connected'] = true;
                }
                else{
        
                    $_SESSION['loginError'] = true;
        
                    header("Location: index.php?controller=login&action=index");
                }
            
                /*
                echo $compte[0]['usePseudo'];
            
                $_SESSION['username'] = $compte[0]['usePseudo'];
                var_dump($_SESSION);
                echo $_SESSION['username'];
            
                */
            }
            else{
                $_SESSION['loginError'] = true;
        
                header("Location: index.php?controller=login&action=index");
            }
        }
        else{
            if(array_key_exists('username', $_POST)){
                header("Location: index.php?controller=login&action=index");
            }
            else{
                header("Location: index.php?controller=home&action=index");
            }
        }
        
    }

    public function accountCreation() {

        if($this->accountVerification()){
            $this->register($_POST['username'], $_POST['password']);
        }


    }

    public function accountVerification() {

        $valid = false;
//&& strlen($_POST['username']) > 0
        if(array_key_exists('username', $_POST)) {
            if(preg_match ('/.{1,50}/', $_POST['username']) == 1){  
    
                if(array_key_exists('password', $_POST) && array_key_exists('confirm-password', $_POST)) {
    
                    if(preg_match ('/.{8,50}/', $_POST['password']) == 1){
                        if($_POST['password'] == $_POST['confirm-password']){
                            //$_SESSION['varcheck'] = $this->bdd->query("SELECT * FROM t_user WHERE usePseudo = '" . $_POST['username'] . "'")->fetchAll();
                            if($this->bdd->query("SELECT * FROM t_user WHERE usePseudo = '" . $_POST['username'] . "'")->fetchAll() == array() ){
                                $_SESSION['username'] = $_POST['username'];
                                $valid = true;
                            }
                            else{
                                $_SESSION['registerErrorUserExists'] = true;
                            }
                        }
                        elseif(array_key_exists('password', $_POST)) {
                            echo ' Les deux mots de passes ne sont pas identiques ';
                        }
                    }
                    else{
                        echo 'mdp pas assez long';
                    }
                }
    
                echo ' username enregistré ';
    
            }
        }

        return $valid;
    }

}