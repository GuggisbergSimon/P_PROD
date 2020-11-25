<?php

/**
 * Authors : Adrian Barreira & Simon Guggisberg
 * Date : 25.11.2020
 * Description : Database class interacting with data on MySQL server
 */

/**
 * Class Database
 */
class Database
{
    private $connector;
    private $serverName = 'localhost';
    private $username = 'root';
    private $password = 'root';

    /**
     * Database constructor.
     */
    public function __construct()
    {
        try {
            $this->connector = new PDO('mysql:host=' . $this->serverName . ';dbname=book;charset=utf8', $this->username, $this->password);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * @param $query
     * @return false|PDOStatement
     */
    private function querySimpleExecute($query)
    {
        return $this->connector->query($query);
    }

    /**
     * @param $req
     * @return mixed
     */
    private function formatData($req)
    {
        return $req->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * @param $req
     */
    private function unsetData($req)
    {
        $req->closeCursor();
    }

    /**
     * Merges an array as string as the following : (..., ..., ...) with a char (or a string) being added before and after each element
     * @param string[] $strings
     * @param string $char
     * @return string merged
     */
    function mergeStrings($strings, $char): string
    {
        $stringsAsString = "";
        foreach ($strings as $string) {
            $stringsAsString = $stringsAsString . $char . ', ' . $char . addslashes($string);
        }
        $stringsAsString = substr_replace($stringsAsString, '(', 0, 2);
        return $stringsAsString . $char . ')';
    }

    /**
     * Read a table and return an array with the table's informations
     * @param string $tableName
     * @return array
     */
    function readTable(string $tableName): array
    {
        $results = $this->querySimpleExecute('select * from ' . $tableName);
        $results = $this->formatData($results);
        return $results;
    }

#region ExistsAt functions

    /**
     * Checks wether the specified data exists, returns a negative value if the data does not exist, the id otherwise
     * @param mixed $value
     * @param string $table
     * @param string $column
     * @return int
     */
    function dataExistsAt($value, $table, $column): int
    {
        $results = $this->readTable($table);

        foreach ($results as $result) {
            if ($result[$column] == $value) {
                return (int)$result["id" . ucfirst(substr($table, 2, strlen($table)))];
            }
        }
        return -1;
    }

    /**
     * @param string $username
     * @return int
     */
    function userExistsAt($username): int
    {
        return $this->dataExistsAt($username, 't_user', 'useUsername');
    }

    /**
     * TODO choose date format
     * @param $date
     * @param string $table
     * @param int $hour
     * @return int
     */
    function reservationExistsAt($date, $table, $hour): int
    {
        $results = $this->readTable($table);

        foreach ($results as $result) {
            if (($result['resDate'] == $date) && ($result['resTable'] == $table) && ($result['resHour'] == $hour)) {
                return (int)$result['idReservation'];
            }
        }
        return -1;
    }

#endregion

#region Add functions

    /**
     * Adds some data to the database, returns the id of the data
     * @param string $table
     * @param string[] $columns
     * @param string[] $values
     * @return int id
     */
    function addData($table, $columns, $values): int
    {
        echo "added new entry to $table " . var_dump($columns) . " " . var_dump($values);

        $id = 'id' . ucfirst(substr($table, 2, strlen($table)));
        $this->querySimpleExecute('insert into ' . $table . ' ' . $this->mergeStrings($columns, '') . ' values ' . $this->mergeStrings($values, '\''));
        $results = $this->querySimpleExecute("select max($id) from " . $table);
        $results = $this->formatData($results);
        return (int)($results[0]["max($id)"]);
    }

    /**
     * TODO hash password
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password hashed
     * @param int $role
     * @return int
     */
    function addUser($username, $firstName, $lastName, $email, $password, $role): int
    {
        return $this->addData('t_user', ['useUsername', 'useFirstName', 'useLastName', 'useEmail', 'usePassword', 'useRole'], [$username, $firstName, $lastName, $email, $password, $role]);
    }

    /**
     * TODO choose date format
     * @param $date
     * @param int $table
     * @param int $hour
     * @param int $meal
     * @param int $userId
     * @return int
     */
    function addReservation($date, $table, $hour, $meal, $userId): int
    {
        return $this->addData('t_reservation', ['resDate', 'resTable', 'resHeure', 'resPlat', 'fkUserId'], [$date, $table, $hour, $meal, $userId]);
    }

#endregion

}