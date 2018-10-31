<?php

class UserDB {

    /* 
     * Return a object, containg the User related to $userID
     * or FALSE/NULL in failure
     */
    public static function getUser($userName) {
        $query = "SELECT * FROM user
                  WHERE userName = '$userName' LIMIT 1";

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            foreach ($rows as $row) {
                $arrayUser = self::prepareArrayUser($row);
                $user = new User($arrayUser);
                $user->setID($row['userID']);
            }

            if (isset($user))
                return $user;
            else
                return null;

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
    public static function deleteUser($userID) {
        $query = "DELETE FROM user
                  WHERE userID = '$userID'";

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
    public static function addUser($user) {
        $name = $user->getName();
        $password = $user->getPassword();
        $salt = $user->getSalt();

        $query = "INSERT INTO user (userName, userPassword, userSalt)
                  VALUES ('$name', '$password', '$salt')";

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
    public static function updateUser($user) {
        $userID = $user->getID();
        $name = $user->getName();
        $password = $user->getPassword();
        $salt = $user->getSalt();

        $query = "UPDATE user
                  SET userName     = '$name',
                      userPassword = '$password',
                      userSalt     = '$salt'
                  WHERE userID ='$userID'";

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
     * Get database row of the user, and return a array with user data
     */
    private static function prepareArrayUser($row) {
        $arrayUser = array();

        if (!empty($row)) {
          $arrayUser['name'] = $row['userName'];
          $arrayUser['password'] = $row['userPassword'];
          $arrayUser['salt'] = $row['userSalt'];
        }

        return $arrayUser;
    }

}

?>
