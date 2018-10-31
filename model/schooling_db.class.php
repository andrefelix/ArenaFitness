<?php

class SchoolingDB {

    /* 
     * Return a object, containg the Schooling related to $schoolingID
     * or FALSE/NULL in failure
     */
    public static function getSchoolingByDescription($schoolingDescription) {
        if (!is_null($schoolingDescription))
            $query = "SELECT * FROM schooling
                      WHERE schoolingDescription = '$schoolingDescription' LIMIT 1";
        else
            return null;

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            foreach ($rows as $row) {
                $arraySchooling = self::prepareArraySchooling($row);
                $schooling = new Schooling($arraySchooling);
                $schooling->setID($row['schoolingID']);
            }

            return $schooling;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /* 
     * Return a object, containg the Schooling related to $schoolingID
     * or FALSE/NULL in failure
     */
    public static function getSchooling($schoolingID) {
        if (!is_null($schoolingID))
            $query = "SELECT * FROM schooling
                      WHERE schoolingID = '$schoolingID' LIMIT 1";
        else
            return null;

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            foreach ($rows as $row) {
                $arraySchooling = self::prepareArraySchooling($row);
                $schooling = new Schooling($arraySchooling);
                $schooling->setID($row['schoolingID']);
            }

            return $schooling;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /* 
     * Return a array of the objects, containing all schoolings
     * or a empty array in failure
     */
    public static function getSchoolings() {
        $query = "SELECT * FROM schooling";

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();

            $schoolings = array();

            foreach ($result as $row) {
                $arraySchooling = self::prepareArraySchooling($row);
                $schooling = new Schooling($arraySchooling);
                $schooling->setID($row['schoolingID']);
                $schoolings[] = $schooling;
            }

            return $schoolings;

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
    public static function deleteSchooling($schoolingID) {
        $query = "DELETE FROM schooling
                  WHERE schoolingID = '$schoolingID'";

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
     * Return 1 if the new row is insert in DB, or 0 in failure
     */
    public static function addSchooling($schooling) {
        $name = $schooling->getName();
        $initials = $schooling->getInitials();

        $query = "INSERT INTO schooling (schoolingName, schoolingInitials)
                  VALUES ('$name', '$initials')";

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
            require_once 'error/error_message.php';
            exit();
        }
    }

    /*
     * Return 1 if the new row is insert in DB, or 0 in failure
     */
    public static function updateSchooling($schooling) {
        $id = $schooling->getID();
        $description = $schooling->getDescription();

        $query = "UPDATE schooling
                  SET schoolingDescription = '$description'
                  WHERE schoolingID ='$id'";

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
     * Get database row of the schooling, and return a array with schooling data
     */
    private static function prepareArraySchooling($row) {
        $arraySchooling = array();

        if (!empty($row)) {
          $arraySchooling['description'] = $row['schoolingDescription'];
        }

        return $arraySchooling;
    }

}

?>
