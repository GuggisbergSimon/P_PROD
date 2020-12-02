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
            $this->bdd = new PDO('mysql:host=localhost;dbname=bdwebprojet;charset=utf8', 'root', 'root');
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
}