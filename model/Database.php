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
        $results = $this->querySimpleExecute('SELECT * from ' . $tableName);
        $results = $this->formatData($results);
        return $results;
    }

    function readReservationPerDay(string $day)
    {
        $results = $this->querySimpleExecute("SELECT * from t_reservation where resDate between '$day 00:00:00' and '$day 23:59:59' order by resHour ASC, resTable ASC, fkMeal ASC");
        $results = $this->formatData($results);
        return $results;
    }

    /**
     * Read a table and return the day the user reserve
     * @param string $tableName
     * @return array
     */
    function readReservationUserDate(string $user, string $day){
        $results = $this->querySimpleExecute("SELECT * FROM t_reservation INNER JOIN t_user ON t_reservation.fkUser = t_user.idUser INNER JOIN t_meal ON t_reservation.fkMeal = t_meal.idMeal WHERE useUsername='$user' AND resDate='$day'");
        
        $results = $this->formatData($results);
        return $results;
    }

    /**
     * Lit la table et envoie tout les plats commande pour aujourd'hui et les jours qui suivent, les jours préscédent ne sont pas afficher.
     * @param string $tableName
     * @return array
     */
    function readReservationUser(string $user){
        $results = $this->querySimpleExecute("SELECT * FROM t_reservation INNER JOIN t_user ON t_reservation.fkUser = t_user.idUser INNER JOIN t_meal ON t_reservation.fkMeal = t_meal.idMeal WHERE useUsername='$user' AND resDate >= CURDATE() ORDER BY resDate ASC");
        
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
        $results = $this->querySimpleExecute("SELECT * from t_user where useUsername='". $username . "'");
        return $results = $this->formatData($results)[0]['idUser'];
    }

    function getCurrentMeals() {
        $results = $this->querySimpleExecute("SELECT * from t_meal where meaIsCurrentMeal = '1'");
        return $results = $this->formatData($results);
    }

    function getAllMeals() {
        $results = $this->querySimpleExecute("SELECT * from t_meal");
        return $results = $this->formatData($results);
    }

    function getAllMealsDisplayed() {
        $results = $this->querySimpleExecute("SELECT * from t_meal WHERE meaDisplay = '1'");
        return $results = $this->formatData($results);
    }

    // 

    function getMeal($mealId) {
        $results = $this->querySimpleExecute("SELECT * from t_meal where idMeal=$mealId");
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
    // $_POST['mealName-'. $z], $_POST['mealCurrentMeal-'. $z], $_POST['mealStartDate-'. $z], $_POST['mealDeadline-'. $z]
    public function addNewMeal() {
        $this->queryPrepareExecute(
            "INSERT INTO t_meal (meaName, meaStartDate, meaDeadline) VALUES (:varNull, :stringDateStart, :stringDateDeadline)",
            array(
                1=> array(
                    "marker" => "varNull",
                    "var" => null,
                    "type" => PDO::PARAM_INT
                ),
                2=> array(
                    "marker" => "stringDateStart",
                    "var" => date("Y-m-d"),
                    "type" => PDO::PARAM_STR
                ),
                3=> array(
                    "marker" => "stringDateDeadline",
                    "var" => date("Y-m-d"),
                    "type" => PDO::PARAM_STR
                )
            )
        );
    }

    // Met à jour le plat suivant l'id renseigner
    public function updateMeal($mealId, $mealName, $mealCurrentMeal, $mealStartDate, $mealDeadline) {
        $this->queryPrepareExecute(
            "UPDATE t_meal SET meaName = :varMeaName, meaIsCurrentMeal = :varMealCurrentMeal, meaStartDate = :varMealStartDate, meaDeadline = :varMealDeadline WHERE t_meal.idMeal = :intMealId",
            array(
                1=> array(
                    "marker" => "varMeaName",
                    "var" => $mealName,
                    "type" => PDO::PARAM_STR
                ),
                2=> array(
                    "marker" => "varMealCurrentMeal",
                    "var" => $mealCurrentMeal,
                    "type" => PDO::PARAM_INT
                ),
                3=> array(
                    "marker" => "varMealStartDate",
                    "var" => $mealStartDate,
                    "type" => PDO::PARAM_STR
                ),
                4=> array(
                    "marker" => "varMealDeadline",
                    "var" => $mealDeadline,
                    "type" => PDO::PARAM_STR
                ),
                5=> array(
                    "marker" => "intMealId",
                    "var" => $mealId,
                    "type" => PDO::PARAM_INT
                ),
            )
        );
    }

    public function reactivateMeal($idMeal){
        $this->queryPrepareExecute(
            "UPDATE t_meal SET meaDisplay = 1 WHERE t_meal.idMeal = :intMealId",
            array(
                array(
                    "marker" => "intMealId",
                    "var" => $idMeal,
                    "type" => PDO::PARAM_INT
                )
            )
        );
    }

    /**
     * Returns the user with the corresponding id as an array
     * @param $userId int
     * @return mixed
     */
    function getUser($userId) {
        $results = $this->querySimpleExecute("SELECT * from t_user where idUser=$userId");
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

    /**
     * Deletes the order with the id order
     * @param $idorder int
     */
    function deleteOrder($idorder)
    {
        $this->querySimpleExecute('delete from t_reservation where idReservation = ' . $idorder);
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
        $results = $this->querySimpleExecute("SELECT max($id) from " . $table);
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
    function addReservation($date, $table, $hour, $idmeal, $userId)
    {
        $this->queryPrepareExecute(
            "INSERT INTO t_reservation (resDate, resHour, fkMeal, resTable, fkUser) VALUES (:resDate, :resHour, :idmeal, :resTable, :userId)",
            array(
                1=> array(
                    "marker" => "resDate",
                    "var" => $date,
                    "type" => PDO::PARAM_STR
                ),
                2=> array(
                    "marker" => "resTable",
                    "var" => 0,
                    "type" => PDO::PARAM_INT
                ),
                3=> array(
                    "marker" => "resHour",
                    "var" => $hour,
                    "type" => PDO::PARAM_STR
                ),
                4=> array(
                    "marker" => "idmeal",
                    "var" => $idmeal,
                    "type" => PDO::PARAM_INT
                ),
                5=> array(
                    "marker" => "userId",
                    "var" => $userId,
                    "type" => PDO::PARAM_INT
                )
            )
        );
    }

    function deleteMealById($id){
        $this->queryPrepareExecute(
            "UPDATE t_meal SET meaDisplay = '0', meaIsCurrentMeal = '0'  WHERE t_meal.idMeal = :intId",
            array(
                array(
                    "marker" => "intId",
                    "var" => $id,
                    "type" => PDO::PARAM_INT
                )
            )
        );
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
    public function register($username, $password, $email, $firstName, $lastName, $role1)
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
                'marker' => ':passwordHash',
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
                'marker' => ':role1',
                'var' => $role1,
                'type' => PDO::PARAM_STR
            )
        );

            $req = $this->queryPrepareExecute("INSERT INTO t_user (useUsername, usePassword, useEmail, useFirstName, UseLastName, useRole) VALUES (:username, :passwordHash, :email, :firstName, :lastName, :role1)", $values);
            

        //$results = $this->unsetData($results);
        return $req;
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
            error_log("\n[" . date("H:i:s Y-m-d") . "]" . "Message could not be sent. Mailer Error: {$mail->ErrorInfo}", 3, "logs/ErrorLogs.log");
            //error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}", 3, "/logs/new");
        }
    }

    //Permet d'envoyer un email pour vérification
    public function sendVerifMail($hashLink, $toAdresse){
        include_once "configConfidential.ini.php";
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        $subject = "Confirmer votre adresse mail";
        $body = "Vous y êtes presque !! <br/>
                Cliqué sur le lien ci-dessous pour vérifier votre compte <br/>
                <a href='$hashLink'>" . $hashLink . "</a>";

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            //$mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->CharSet    = 'UTF-8';
            $mail->Host       = 'smtp.office365.com';                   // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = MAIL_USERNAME;                          // SMTP username
            $mail->Password   = MAIL_PASSWORD;                          // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Header
            //addCustomHeader("");

            //Recipients
            $mail->setFrom(MAIL_FROMADDRESS,'Cafétéria ETML');

            $mail->addAddress($toAdresse, $toAdresse);                              // Add a recipient

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = $body;

            $mail->send();
            $mail->ClearAllRecipients();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            error_log("\n[" . date("H:i:s Y-m-d") . "]" . "Message could not be sent. Mailer Error: {$mail->ErrorInfo}", 3, "logs/ErrorLogs.log");
            //error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}", 3, "/logs/new");
        }
    }

    /**
     * Ajoute le hash avec comme liaison l'email et un délais de 24h pour activer 
     */
    public function addNewHash($hash, $date, $idUser){
        $this->queryPrepareExecute(
            "INSERT INTO t_verification (verhash, verDeadline, fkUser) VALUES (:hash, :date, :idUser)",
            array(
                1=> array(
                    "marker" => "hash",
                    "var" => $hash,
                    "type" => PDO::PARAM_STR
                ),
                2=> array(
                    "marker" => "date",
                    "var" => $date,
                    "type" => PDO::PARAM_STR
                ),
                3=> array(
                    "marker" => "idUser",
                    "var" => $idUser,
                    "type" => PDO::PARAM_INT
                )
            )
        );
    }

    /**
     * Verification du hash avec le mail.
     */
    public function verifLink($vHash, $Adresse){
        $result1 = $this->queryPrepareExecute(
            "SELECT * FROM t_verification LEFT JOIN t_user ON t_verification.fkUser = t_user.idUser WHERE verhash = :vHash AND useEmail = :Adresse",
            array(
                1=> array(
                    "marker" => "vHash",
                    "var" => $vHash,
                    "type" => PDO::PARAM_STR
                ),
                2=> array(
                    "marker" => "Adresse",
                    "var" => $Adresse,
                    "type" => PDO::PARAM_STR
                )
            )
        );

        $result2 = $this->formatData($result1);

        return $result2;
    }

    /**
     * Supprime le lien car il a été utilisé.
     */
    public function deleteLink($idVerif){
        $this->queryPrepareExecute(
            "DELETE FROM t_verification WHERE t_verification.idVerification = :idVerif;",
            array(
                1=> array(
                    "marker" => "idVerif",
                    "var" => $idVerif,
                    "type" => PDO::PARAM_STR
                )
            )
        );
    }

    /**
     * Validation de l'utilisateur
     */
    public function userOk($adresse){
        $this->queryPrepareExecute(
            "UPDATE t_user SET useVerif = 1 WHERE t_user.useEmail = :Adresse",
            array(
                1=> array(
                    "marker" => "Adresse",
                    "var" => $adresse,
                    "type" => PDO::PARAM_STR
                )
            )
        );
    }

    /**
     * Selectionne tous les lien de validation expirer
     */
    public function allExpiredLink($dateNow){
        $return = $this->queryPrepareExecute(
            "SELECT idUser FROM t_verification WHERE verDeadline > :dateNow",
            array(
                1=> array(
                    "marker" => "dateNow",
                    "var" => $dateNow,
                    "type" => PDO::PARAM_STR
                )
            )
        );

        return $return;
    }

    /**
     * Permet l'update du role et si l'adresse mail est vérifier ou non
     */
    public function GetUserInfo($username){
        $result1 = $this->queryPrepareExecute(
            "SELECT useUsername, useEmail, useFirstName, useLastName, useRole, useVerif FROM t_user WHERE useUsername = :username",
            array(
                1=> array(
                    "marker" => "username",
                    "var" => $username,
                    "type" => PDO::PARAM_STR
                )
            )
        );

        $result2 = $this->formatData($result1);

        return $result2;
    }

    /**
     * Obtient tous les plats commander
     */
    public function allMealsReserved($dateNow){
        $result1 = $this->queryPrepareExecute(
            "SELECT  t_reservation.resHour, t_meal.meaName, t_user.useUsername, t_user.useEmail, t_user.useFirstName, t_user.useLastName FROM t_reservation
            LEFT JOIN t_user ON t_reservation.fkUser = t_user.idUser
            LEFT JOIN t_meal ON t_reservation.fkMeal = t_meal.idMeal
            WHERE resDate = :dateNow",
            array(
                1=> array(
                    "marker" => "dateNow",
                    "var" => $dateNow,
                    "type" => PDO::PARAM_STR
                )
            )
        );

        $result2 = $this->formatData($result1);

        return $result2;
    }

    /**
     * Récupère le nom du plats ainsi que la quantité commandé pour les 2 périodes
     */
    public function getNumberofAllMeal($dateNow){
        //Exécution simple car rien n'est entré par l'utilisateur.
        $resultat1 = $this->querySimpleExecute("SELECT meaName, COUNT(CASE WHEN resHour = '11' THEN 1 END) as reserved11, COUNT(CASE WHEN resHour = '12' THEN 1 END) as reserved12 
        FROM t_reservation 
        LEFT JOIN t_meal ON t_reservation.fkMeal = t_meal.idMeal 
        WHERE resDate = '$dateNow' GROUP BY meaName");

        $resultat2 = $this->formatData($resultat1);

        return $resultat2;
    }
}