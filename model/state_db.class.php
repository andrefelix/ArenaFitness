<?php

class StateDB {

    /* 
     * Return a object, containg the State related to $stateID
     * or FALSE/NULL in failure
     */
    public static function getStateByInitials($stateInitials) {
        if (!is_null($stateInitials))
            $query = "SELECT * FROM state
                      WHERE stateInitials = '$stateInitials' LIMIT 1";
        else
            return null;

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            foreach ($rows as $row) {
                $arrayState = self::prepareArrayState($row);
                $state = new State($arrayState);
                $state->setID($row['stateID']);
            }

            return $state;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /* 
     * Return a object, containg the State related to $stateID
     * or FALSE/NULL in failure
     */
    public static function getState($cityStateID) {
        if (!is_null($cityStateID))
            $query = "SELECT * FROM state
                      WHERE stateID = '$cityStateID' LIMIT 1";
        else
            return null;

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            foreach ($rows as $row) {
                $arrayState = self::prepareArrayState($row);
                $state = new State($arrayState);
                $state->setID($row['stateID']);
            }

            return $state;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /* 
     * Return a array of the objects, containing all states
     * or a empty array in failure
     */
    public static function getStates() {
        $query = "SELECT * FROM state";

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();

            $states = array();

            foreach ($result as $row) {
                $arrayState = self::prepareArrayState($row);
                $state = new State($arrayState);
                $state->setID($row['stateID']);
                $states[] = $state;
            }

            return $states;

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
    public static function deleteState($stateID) {
        $query = "DELETE FROM state
                  WHERE stateID = '$stateID'";

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
    public static function addState($state) {
        $name = $state->getName();
        $initials = $state->getInitials();

        $query = "INSERT INTO state (stateName, stateInitials)
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
    public static function updateState($city) {
        $query = "UPDATE state
                  SET stateName = '$state->getName()',
                      cityStateID   = '$city->getStateID()'
                  WHERE cityID ='$city->getID()'";

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
     * Get database row of the state, and return a array with state data
     */
    private static function prepareArrayState($row) {
        $arrayState = array();

        if (!empty($row)) {
          $arrayState['name'] = $row['stateName'];
          $arrayState['initials'] = $row['stateInitials'];
        }

        return $arrayState;
    }

}

?>
