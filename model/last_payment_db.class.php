<?php

class LastPaymentDB {

    /* 
     * Return a object, containg the LastPayment related to $lastPaymentID
     * or FALSE/NULL in failure
     */
    public static function getLastPayment($lastPaymentClientID) {
        if (!is_null($lastPaymentID))
            $query = "SELECT * FROM lastPayment
                      WHERE lastPaymentClientID = '$lastPaymenClientID' LIMIT 1";
        else
            return null;

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            foreach ($rows as $row) {
                $arrayLastPayment = prepareArrayLastPayment($row);
                $lastPayment = new LastPayment($arrayLastPayment);
                $lastPayment->setID($row['lastPaymentID']);
            }

            return $lastPayment;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /* 
     * Return a array of the objects, containing all lastPayments
     * or a empty array in failure
     */
    public static function getPayments($clientID) {
        $query = "SELECT * FROM lastPayment WHERE lastPaymentClientID = '$clientID'";

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();

            $lastPayments = array();

            foreach ($result as $row) {
                $arrayLastPayment = prepareArrayLastPayment($row);
                $lastPayment = new LastPayment($arrayLastPayment);
                $lastPayment->setID($row['lastPaymentID']);
                $lastPayments[] = $lastPayment;
            }

            return $lastPayments;

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
    public static function deleteLastPayment($lastPaymentID) {
        $query = "DELETE FROM lastPayment
                  WHERE lastPaymentID = '$lastPaymentID'";

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
     * Return TRUE if the new row is insert in DB, or FALSE in failure
     */
    public static function addLastPayment($lastPayment) {
        $query = "INSERT INTO lastPayment (lastPaymentDate, lastPaymentValue, lastPaymentClientID)
                  VALUES ('$lastPayment->getDate()', '$lastPayment->getValue()',
                          '$lastPayment->getClientID()')";

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
    public static function updateLastPayment($lastPayment) {
        $query = "UPDATE lastPayment
                  SET lastPaymentDate = '$lastPayment->getDate()',
                      lastPaymentValue = '$lastPayment->getValue()',
                      lastPaymenClientID   = '$lastPayment->getClientID()'
                  WHERE lastPaymentID ='$lastPayment->getID()'";

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
     * Get database row of the lastPayment, and return a array with lastPayment data
     */
    private static function prepareArrayLastPayment($row) {
        $arrayLastPayment = array();

        if (!empty($row)) {
          $arrayLastPayment['date'] = $row['lastPaymentDate'];
          $arrayLastPayment['value'] = $row['lastPaymentValue'];
          $arrayLastPayment['clientID'] = $row['lastPaymentClientID'];
        }

        return $arrayLastPayment;
    }

}

?>
