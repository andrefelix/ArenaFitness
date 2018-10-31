<?php

class MonthlyDB {

    /* 
     * Return a object, containg the Monthly related to $monthlyID
     * or FALSE/NULL in failure
     */
    public static function getMonthly($monthlyID) {
        if (!is_null($monthlyID))
            $query = "SELECT * FROM monthly
                      WHERE monthlyID = '$monthlyID' LIMIT 1";
        else
            return null;

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            foreach ($rows as $row) {
                $arrayMonthly = self::prepareArrayMonthly($row);
                $monthly = new Monthly($arrayMonthly);
                $monthly->setID($row['monthlyID']);
            }

            return $monthly;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /* 
     * Return a array of the objects, containing all Monthlies
     * or a empty array in failure
     */
    public static function getMonthlies($clientID) {
        $query = "SELECT * FROM monthly WHERE monthlyClientID = '$clientID'";

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();

            $monthlies = array();

            foreach ($result as $row) {
                $arrayMonthly = self::prepareArrayMonthly($row);
                $monthly = new Monthly($arrayMonthly);
                $monthly->setID($row['monthlyID']);
                $monthlies[] = $monthly;
            }

            return $monthlies;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /*
     * Return 1 if the row related to monthlyID is deleted, or 0 in failure
     */
    public static function deleteMonthly($monthlyID) {
        $query = "DELETE FROM monthly
                  WHERE monthlyID = '$monthlyID'";

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
    public static function addMonthly($monthly) {
        $datePay = $monthly->getDatePay();
        $datePaid = $monthly->getDatePaid();
        $value = preg_replace('/[^0-9]/', '', $monthly->getValue());
        $clientID = $monthly->getClientID();

        $datePay = implode('-', array_reverse(explode('/', $datePay)));
        $datePaid = implode('-', array_reverse(explode('/', $datePaid)));

        $query = "INSERT INTO monthly (monthlyDatePay, monthlyDatePaid, monthlyValue,
                                       monthlyClientID)

                  VALUES ('$datePay', '$datePaid', '$value', '$clientID')";

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
            /*
             * roll back transaction if something failed
             */
            $db->rollback();
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /*
     * Return 1 if the new row is insert in DB, or 0 in failure
     */
    public static function updateMonthly($monthly) {
        $monthlyID = $monthly->getID();
        $datePay = $monthly->getDatePay();
        $datePaid = $monthly->getDatePaid();
        $value = preg_replace('/[^0-9]/', '', $monthly->getValue());

        $datePay = implode('-', array_reverse(explode('/', $datePay)));
        $datePaid = implode('-', array_reverse(explode('/', $datePaid)));

        $query = "UPDATE monthly
                  SET monthlyDatePay = '$datePay',
                      monthlyDatePaid   = '$datePaid',
                      monthlyValue   = '$value'
                  WHERE monthlyID = '$monthlyID'";

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
     * Get database row of the monthly, and return a array with monthly data
     */
    private static function prepareArrayMonthly($row) {
        $arrayMonthly = array();

        if (!empty($row)) {
            $arrayMonthly['datePay'] = implode('/', array_reverse(explode('-', $row['monthlyDatePay'])));
            $arrayMonthly['datePaid'] = implode('/', array_reverse(explode('-', $row['monthlyDatePaid'])));
            $arrayMonthly['value'] = $row['monthlyValue'];
            $arrayMonthly['clientID'] = $row['monthlyClientID'];
        }

        return $arrayMonthly;
    }

}

?>
