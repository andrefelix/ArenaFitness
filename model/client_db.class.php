<?php

class ClientDB {

    /* 
     * Return a object, containg the Client related to $name
     * or FALSE/NULL in failure
     */
    public static function getClientByName($name) {
        if (!empty($name))
            $query = "SELECT * FROM client
                      WHERE clientName LIKE '%$name%'";
        else
            return null;

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            //$statement->bindValue(':clientID', $clientID);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            $clients = array();

            foreach ($rows as $row) {
                $arrayClient = self::prepareArrayClient($row);
                $client = new Client($arrayClient);
                $client->setID($row['clientID']);
                $clients[] = $client;
            }

            return $clients;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /* 
     * Return a object, containg the Client related to $clientID
     * or FALSE/NULL in failure
     */
    public static function getClient($clientID) {
        if (!is_null($clientID))
            $query = "SELECT * FROM client
                      WHERE clientID = '$clientID' LIMIT 1";
        else
            return null;

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            //$statement->bindValue(':clientID', $clientID);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            foreach ($rows as $row) {
                $arrayClient = self::prepareArrayClient($row);
                $client = new Client($arrayClient);
                $client->setID($row['clientID']);
            }

            return $client;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /* 
     * Return a array of the objects, containing all clients
     * or a empty array in failure
     */
    public static function getClients() {
        $query = "SELECT * FROM client ORDER BY clientName";

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();

            $clients = array();

            foreach ($result as $row) {
                $arrayClient = self::prepareArrayClient($row);
                $client = new Client($arrayClient);
                $client->setID($row['clientID']);
                $clients[] = $client;
            }

            return $clients;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /*
     * Return 1 if the row related to clientID is deleted, or 0 in failure
     */
    public static function deleteClient($clientID) {
        $query = "DELETE FROM client
                  WHERE clientID = '$clientID'";

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            //$statement->bindValue(':clientID', $clientID);
            /*
             * execute() return true or false
             */
            $statement->execute();
            $rowsAffected = $statement->rowCount();
            $statement->closeCursor();

            return $rowsAffected;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /*
     * Return ClientID if the new row is insert in DB, or 0 in failure
     */
    public static function addClient($client) {
        $name = $client->getName();
        $cpf = $client->getCPF();
        $rg = $client->getRG();
        $civilStatus = $client->getCivilStatus();
        $gender = $client->getGender();
        $email = $client->getEmail();
        $birthDate = $client->getBirthDate();
        $cellPhone = $client->getCellPhone();
        $homePhone = $client->getHomePhone();
        $workPhone = $client->getWorkPhone();
        $emergencyPhone = $client->getEmergencyPhone();
        $schoolingID = $client->getSchoolingID();
        $profession = $client->getProfession();
        $beginDate = $client->getBeginDate();
        $noInstructor = $client->getNoInstructor();

        /*
         * Format date for db insert
         */
        $beginDate = implode('-', array_reverse(explode('/', $beginDate)));
        $birthDate = implode('-', array_reverse(explode('/', $birthDate)));


        $query = "INSERT INTO client (clientName, clientCPF, clientRG, clientCivilStatus,
                                      clientGender, clientEmail, clientBirthDate,
                                      clientCellPhone, clientHomePhone, clientWorkPhone,
                                      clientEmergencyPhone, clientSchoolingID, clientProfession,
                                      clientBeginDate, clientNoInstructor)

                  VALUES ('$name', '$cpf', '$rg', '$civilStatus', '$gender', '$email',
                          '$birthDate', '$cellPhone', '$homePhone', '$workPhone',
                          '$emergencyPhone', '$schoolingID', '$profession', '$beginDate',
                          '$noInstructor')";

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            /*
             * execute() return true or false
             */
            $statement->execute();
            $rowsAffected = $statement->rowCount();
            $statement->closeCursor();

            if ($rowsAffected == 1)
              return $db->lastInsertId();

            return $rowsAffected;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /*
     * Return 1 if the new row is insert in DB, or 0 in failure
     */
    public static function updateClient($client) {
        $clientID = $client->getID();
        $name = $client->getName();
        $cpf = $client->getCPF();
        $rg = $client->getRG();
        $civilStatus = $client->getCivilStatus();
        $gender = $client->getGender();
        $email = $client->getEmail();
        $birthDate = $client->getBirthDate();
        $cellPhone = $client->getCellPhone();
        $homePhone = $client->getHomePhone();
        $workPhone = $client->getWorkPhone();
        $emergencyPhone = $client->getEmergencyPhone();
        $schoolingID = $client->getSchoolingID();
        $profession = $client->getProfession();
        $beginDate = $client->getBeginDate();
        $noInstructor = $client->getNoInstructor();
        /*
         * Format date for db insert
         */
        $beginDate = implode('-', array_reverse(explode('/', $beginDate)));
        $birthDate = implode('-', array_reverse(explode('/', $birthDate)));

        $query = "UPDATE client
                  SET clientName           = '$name',
                      clientCPF            = '$cpf',
                      clientRG             = '$rg',
                      clientCivilStatus    = '$civilStatus',
                      clientGender         = '$gender',
                      clientEmail          = '$email',
                      clientBirthDate      = '$birthDate',
                      clientCellPhone      = '$cellPhone',
                      clientHomePhone      = '$homePhone',
                      clientWorkPhone      = '$workPhone',
                      clientEmergencyPhone = '$emergencyPhone',
                      clientSchoolingID    = '$schoolingID',
                      clientProfession     = '$profession',
                      clientBeginDate      = '$beginDate',
                      clientNoInstructor   = '$noInstructor'
                  WHERE clientID ='$clientID'";

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            /*
             * execute() return true or false
             */
            $statement->execute();
            $rowsAffected = $statement->rowCount();
            $statement->closeCursor();

            return $rowsAffected;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /*
     * Get database row of the client, and return a array with client data
     */
    private static function prepareArrayClient($row) {
        $arrayClient = array();

        if (!empty($row)) {
            // personal data
            $arrayClient['name'] = $row['clientName'];
            $arrayClient['cpf'] = $row['clientCPF'];
            $arrayClient['rg'] = $row['clientRG'];
            $arrayClient['civilStatus'] = $row['clientCivilStatus'];
            $arrayClient['gender'] = $row['clientGender'];
            $arrayClient['email'] = $row['clientEmail'];
            /*
             * Format date for BR visualization
             */
            $arrayClient['birthDate'] = implode('/', array_reverse(explode('-', $row['clientBirthDate'])));
            $arrayClient['beginDate'] = implode('/', array_reverse(explode('-', $row['clientBeginDate'])));

            // phones
            $arrayClient['cellPhone'] = $row['clientCellPhone'];
            $arrayClient['homePhone'] = $row['clientHomePhone'];
            $arrayClient['workPhone'] = $row['clientWorkPhone'];
            $arrayClient['emergencyPhone'] = $row['clientEmergencyPhone'];

            // professionals data
            $arrayClient['schoolingID'] = $row['clientSchoolingID'];
            $arrayClient['profession'] = $row['clientProfession'];

            // complementary data
            $arrayClient['noInstructor'] = $row['clientNoInstructor'];

        }

        return $arrayClient;
    }

}

?>
