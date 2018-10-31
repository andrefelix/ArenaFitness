<?php

class ObservationDB {

    /* 
     * Return a object, containg the Observation related to $observationID
     * or FALSE/NULL in failure
     */
    public static function getObservation($clientID) {
        if (!is_null($clientID))
            $query = "SELECT * FROM observation
                      WHERE observationClientID = '$clientID' LIMIT 1";
        else
            return null;

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            foreach ($rows as $row) {
                $arrayObservation = self::prepareArrayObservation($row);
                $observation = new Observation($arrayObservation);
                $observation->setID($row['observationID']);
            }

            return $observation;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /*
     * Return 1 if the row related to addressID is deleted, or 0 in failure
     */
    public static function deleteObservation($clientID) {
        $query = "DELETE FROM observation
                  WHERE observationClientID = '$clientID'";

        try {
            $db = Database::getDB();
            $observationment = $db->prepare($query);
            /*
             * execute() return true or false
             */
            $observationment->execute();
            $rowsAffected = $observationment->rowCount();
            $observationment->closeCursor();

            return $rowsAffected;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /*
     * Return TRUE if the new row is insert in DB, or FALSE in failure
     */
    public static function addObservation($observation) {
        $text = $observation->getText();
        $clientID = $observation->getClientID();

        $query = "INSERT INTO observation (observationText, observationClientID)

                  VALUES ('$text', '$clientID')";

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
    public static function updateObservation($observation) {
        $observationClientID = $observation->getClientID();
        $text = $observation->getText();

        $query = "UPDATE observation
                  SET observationText = '$text'
                  WHERE observationClientID = '$observationClientID'";

        try {
            $db = Database::getDB();
            $observationment = $db->prepare($query);
            /*
             * execute() return true or false
             */
            $observationment->execute();
            $rowsAffected = $observationment->rowCount();
            $observationment->closeCursor();

            return $rowsAffected;
            
        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /*
     * Get database row of the observation, and return a array with observation data
     */
    private static function prepareArrayObservation($row) {
        $arrayObservation = array();

        if (!empty($row)) {
            $arrayObservation['text'] = $row['observationText'];
            $arrayObservation['clientID'] = $row['observationClientID'];
        }

        return $arrayObservation;
    }

}

?>