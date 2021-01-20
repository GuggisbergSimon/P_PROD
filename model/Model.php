<?php

/**
 * Auteur      : HUGO DUCOMMUN, SIMON GUGGISBERG
 * Date        : 20.01.2020
 * Lieu        : (c) ETML, Lausanne
 * Description : Classe abstraite regroupant les méthodes à avoir dans chaque Database
 */

abstract class Model {

    // Connector to the DB
    protected $connector;

    /**
     * @param $query
     * @return false|PDOStatement
     */
    protected function querySimpleExecute($query)
    {
        return $this->connector->query($query);
    }

    /**
     * prepare the execution of a query by binding values to prevent injection
     * @param $query
     * @param $binds
     * @return bool|PDOStatement
     */
    protected function queryPrepareExecute($query, $binds)
    {
        $req = $this->connector->prepare($query);
        foreach($binds as $bind)
        {
            $req->bindValue($bind['marker'], $bind['var'], $bind['type']);
        }
        $req->execute();

        return $req;
    }

    /**
     * @param $req
     * @return mixed
     */
    protected function formatData($req)
    {
        return $req->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * @param $req
     */
    protected function unsetData($req)
    {
        $req->closeCursor();
    }
}

?>