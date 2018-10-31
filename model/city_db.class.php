<?php

class CityDB {

    /* 
     * Return a object, containg the City related to $cityID
     * or FALSE/NULL in failure
     */
    public static function getCityByName($cityName) {
        if (!is_null($cityName))
            $query = "SELECT * FROM city
                      WHERE cityName = '$cityName' LIMIT 1";
        else
            return null;

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            foreach ($rows as $row) {
                $arrayCity = self::prepareArrayCity($row);
                $city = new City($arrayCity);
                $city->setID($row['cityID']);
            }

            return $city;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /* 
     * Return a object, containg the City related to $cityID
     * or FALSE/NULL in failure
     */
    public static function getCity($addressCityID) {
        if (!is_null($addressCityID))
            $query = "SELECT * FROM city
                      WHERE cityID = '$addressCityID' LIMIT 1";
        else
            return null;

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            foreach ($rows as $row) {
                $arrayCity = self::prepareArrayCity($row);
                $city = new City($arrayCity);
                $city->setID($row['cityID']);
            }

            return $city;

        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }
    }

    /* 
     * Return a array of the objects, containing all citys
     * or a empty array in failure
     */
    public static function getCities($stateID) {
        $query = "SELECT * FROM city WHERE cityStateID = '$stateID'";

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();

            $cities = array();

            foreach ($result as $row) {
                $arrayCity = self::prepareArrayCity($row);
                $city = new City($arrayCity);
                $city->setID($row['cityID']);
                $cities[] = $city;
            }

            return $cities;

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
    public static function deleteCity($cityID) {
        $query = "DELETE FROM city
                  WHERE cityID = '$cityID'";

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
    public static function addCity($city) {
        $name = addslashes($city->getName());
        $stateID = $city->getStateID();

        $query = "INSERT INTO city (cityName, cityStateID)
                  VALUES ('$name', '$stateID')";

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
    public static function updateCity($city) {
        $query = "UPDATE city
                  SET cityName = '$city->getCity()',
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
     * Get database row of the city, and return a array with city data
     */
    private static function prepareArrayCity($row) {
        $arrayCity = array();

        if (!empty($row)) {
          $arrayCity['name'] = $row['cityName'];
          $arrayCity['stateID'] = $row['cityStateID'];
        }

        return $arrayCity;
    }

}

?>
