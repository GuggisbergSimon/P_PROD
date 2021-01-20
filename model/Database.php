<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

require 'Model.php';


/**
 * Authors : Adrian Barreira, Simon Guggisberg & Hugo Ducommun
 * Date : 25.11.2020
 * Description : Database class interacting with data on MySQL server
 */
include_once 'config.ini.php';

/**
 * Class Database
 */
class Database extends Model
{

    /**
     * Database constructor
     */
    public function __construct()
    {
        $host = $GLOBALS['database']['host'];
        $port = $GLOBALS['database']['port'];
        $dbname = $GLOBALS['database']['dbname'];
        $charset = $GLOBALS['database']['charset'];
        $username = $GLOBALS['database']['username'];
        $password = $GLOBALS['database']['password'];

        try {
            $this->connector = new PDO('mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname . ';charset=' . $charset, $username, $password);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
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

    function readReservationPerDay(string $day)
    {
        $results = $this->querySimpleExecute("select * from t_reservation where resDate between '$day 00:00:00' and '$day 23:59:59' order by resHour ASC, resTable ASC, fkMeal ASC");
        $results = $this->formatData($results);
        return $results;
    }

    /**
     * Returns the id of the user with the corresponding username
     * @param $username string
     * @return mixed
     */
    function getIdUser($username)
    {
        $results = $this->querySimpleExecute("select * from t_user where useUsername='". $username . "'");
        return $results = $this->formatData($results)[0]['idUser'];
    }

    function getCurrentMeals() {
        $results = $this->querySimpleExecute("select * from t_meal where meaIsCurrentMeal limit 2");
        return $results = $this->formatData($results);
    }

    function getAllMeals() {
        $results = $this->querySimpleExecute("select * from t_meal");
        return $results = $this->formatData($results);
    }

    function getMeal($mealId) {
        $results = $this->querySimpleExecute("select * from t_meal where idMeal=$mealId");
        $results = $this->formatData($results);
        return count($results) == 1 ? $results[0] : -1;
    }

    /**
     * Get the number of reservations for the recap
     * @param string $date Date of the recap
     * 
     * @return array
     */
    public function getReservationsPerDayPerHourPerMeal($date) {
        $req = $this->queryPrepareExecute(
            "SELECT resHour, fkMeal, count(idReservation) AS numberReservations FROM t_reservation WHERE date(resDate) = :varDate GROUP BY resHour, fkMeal ORDER BY resHour, fkMeal",
            array(
                array(
                    "marker" => "varDate",
                    "var" => $date,
                    "type" => PDO::PARAM_STR
                )
            )
        );
        $result = $this->formatData($req);
        $this->unsetData($req);
        return $result;
    }

    /**
     * Add a meal to the database
     * @param string $mealName Name of the meal
     * 
     * @return void
     */
    public function addMeal($mealName) {
        $this->queryPrepareExecute(
            "INSERT INTO t_meal (meaName) VALUES (:varMeaName)",
            array(
                array(
                    "marker" => "varMeaName",
                    "var" => $mealName,
                    "type" => PDO::PARAM_STR
                )
            )
        );
    }

    public function setNewCurrentMeals($mealName1, $mealName2) {
        // Set false to the old current meals
        $this->querySimpleExecute(
            "UPDATE t_meal SET meaIsCurrentMeal = 0 WHERE meaIsCurrentMeal = 1"
        );
        // Set true to the new current meals
        $this->queryPrepareExecute(
            "UPDATE t_meal SET meaIsCurrentMeal = 1 WHERE meaName = :varMeaName",
            array(
                array(
                    "marker" => "varMeaName",
                    "var" => $mealName1,
                    "type" => PDO::PARAM_STR
                )
            )
        );
        $this->queryPrepareExecute(
            "UPDATE t_meal SET meaIsCurrentMeal = 1 WHERE meaName = :varMeaName",
            array(
                array(
                    "marker" => "varMeaName",
                    "var" => $mealName2,
                    "type" => PDO::PARAM_STR)
            )
        );
    }

    /**
     * Returns the user with the corresponding id as an array
     * @param $userId int
     * @return mixed
     */
    function getUser($userId) {
        $results = $this->querySimpleExecute("select * from t_user where idUser=$userId");
        return $results = $this->formatData($results)[0];
    }

    /**
     * Deletes the user with the given username
     * @param $username string
     */
    function deleteUser($username)
    {
        $this->querySimpleExecute('delete from t_user where useUsername = ' . $username);
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
     * Checks wether a user exists with the given username
     * @param string $username
     * @return int -1 if the user does not exist, its id otherwise
     */
    function userExistsAt($username): int
    {
        return $this->dataExistsAt($username, 't_user', 'useUsername');
    }

    /**
     * Checks wether a reservation exists at the given arguments
     * @param $date yyyy-mm-dd
     * @param string $table
     * @param int $hour
     * @return int returns -1 if it doesn't exist, the id of the reservation otherwise
     */
    function reservationExistsAt($date, $table, $hour): int
    {
        $results = $this->readTable('t_reservation');
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
     * @return int id of the new data
     */
    function addData($table, $columns, $values): int
    {
        $id = 'id' . ucfirst(substr($table, 2, strlen($table)));
        $this->querySimpleExecute('insert into ' . $table . ' ' . $this->mergeStrings($columns, '') . ' values ' . $this->mergeStrings($values, '\''));
        $results = $this->querySimpleExecute("select max($id) from " . $table);
        $results = $this->formatData($results);
        return (int)($results[0]["max($id)"]);
    }

    /**
     * Adds a new user to the DB
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password not hashed
     * @param int $role
     * @return int id of the new user
     */
    function addUser($username, $firstName, $lastName, $email, $password, $role): int
    {
        $password = password_hash($password, PASSWORD_BCRYPT);
        return $this->addData('t_user', ['useUsername', 'useFirstName', 'useLastName', 'useEmail', 'usePassword', 'useRole'], [$username, $firstName, $lastName, $email, $password, $role]);
    }

    /**
     * Adds a reservation to the DB
     * @param $date yyyy-mm-dd
     * @param int $table
     * @param int $hour
     * @param int $mealId
     * @param int $userId
     * @return int id of the new reservation
     */
    function addReservation($date, $table, $hour, $mealId, $userId): int
    {
        $user = $this->getUser($userId);
        $user = $user['useFirstName'] . ' ' . $user['useLastName'];
        $subject = 'Réservation de ' . $user;
        $body = $user . ' a réservé un menu végétarien pour le ' . $date . /*$table . ' ' . $meal*/ ' à ' . $hour . 'h.';

        $this->sendMail($subject, $body);

        return $this->addData('t_reservation', ['resDate', 'resTable', 'resHour', 'fkMeal', 'fkUser'], [$date, $table, $hour, $mealId, $userId]);
    }

    /**
     * Sends an email through the contact form
     * @return void
     */
    function contactSendMail()
    {
        $subject = 'Contact : ' . $_POST['contactNom'];
        $body = $_POST['contactMsg'];


        $this->sendMail($subject, $body);
    }

#endregion

    /**
     * Registers a new account
     * @param $username
     * @param $password
     * @param $email
     * @param $firstName
     * @param $lastName
     * @param $role
     */
    public function register($username, $password, $email, $firstName, $lastName, $role)
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        //$query = $this->addUser($username, $firstName, $lastName, $email, $password, $role);
        $values = array(
            1=> array(
                'marker' => ':username',
                'var' => $username,
                'type' => PDO::PARAM_STR
            ),
            2=> array(
                'marker' => ':password',
                'var' => $passwordHash,
                'type' => PDO::PARAM_STR
            ),
            3=> array(
                'marker' => ':email',
                'var' => $email,
                'type' => PDO::PARAM_STR
            ),
            4=> array(
                'marker' => ':firstName',
                'var' => $firstName,
                'type' => PDO::PARAM_STR
            ),
            5=> array(
                'marker' => ':lastName',
                'var' => $lastName,
                'type' => PDO::PARAM_STR
            ),
            6=> array(
                'marker' => ':role',
                'var' => $role,
                'type' => PDO::PARAM_STR
            )
        );

        $results = $this->queryPrepareExecute("INSERT INTO t_user (useUsername, usePassword, useEmail, useFirstName, UseLastName, useRole) VALUES (:username, :password, :email, :firstName, :lastName, :role)", $values);

        $results = $this->unsetData($results);
        //$insertUser = "INSERT INTO t_user (useUsername, usePassword, useEmail, useFirstName, UseLastName, useRole) VALUES ('" . $username . "' , '" . $passwordHash . "' , '" . $email . "' , '" . $firstName . "' , '" . $lastName . "' , '" . $role . "')";
    }

    /**
     * Logins as a user
     * @param $username string
     * @return int|mixed -1 if fail, user as an array if success
     */
    public function login($username)
    {
        $values = array(
            1=> array(
                'marker' => ':username',
                'var' => $username,
                'type' => PDO::PARAM_STR
            )
        );

        $req = $this->queryPrepareExecute("SELECT * FROM t_user WHERE useUsername = :username", $values);

        $results = $this->formatData($req);

        if (count($results) > 0) {
            return $results[0];
        }

        $this->unsetData($req);

        return -1;
    }

    /**
     * Sends an email to the email address in the config.ini.php in the parent folder
     * @param $subject string subject of the email
     * @param $body string body text of the email
     */
    public function sendMail($subject, $body){
        include_once "../configConfidential.ini.php";
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->CharSet = 'UTF-8';
            $mail->Host       = 'smtp.office365.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = MAIL_USERNAME;                     // SMTP username
            $mail->Password   = MAIL_PASSWORD;                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above


            //Recipients
            $mail->setFrom(MAIL_FROMADDRESS);

            foreach(MAIL_ADDRESSES as $mailAdress){
                $mail->addAddress($mailAdress);     // Add a recipient
            }

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = $body;

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            //fopen("logs/testfile.txt", "w");
            error_log("\n[" . date("H:i:s Y-m-d") . "]" . "Message could not be sent. Mailer Error: {$mail->ErrorInfo}", 3, "logs/ErrorLogs.log");
            //error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}", 3, "/logs/new");
        }
    }
}