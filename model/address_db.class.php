<?php

class AddressDB {

    /* 
     * Return a object, containg the Address related to $addressID
     * or FALSE/NULL in failure
     */
    public static function getAddress($clientID) {
        if (!is_null($clientID))
            $query = "SELECT * FROM address
                      WHERE addressClientID = '$clientID' LIMIT 1";
        else
            return null;

        try {
            $db = Database::getDB();
            $statement = $db->prepare($query);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            foreach ($rows as $row) {
                $arrayAddress = self::prepareArrayAddress($row);
                $address = new Address($arrayAddress);
                $address->setID($row['addressID']);
            }

            return $address;

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
    public static function deleteAddress($clientID) {
        $query = "DELETE FROM address
                  WHERE addressClientID = '$clientID'";

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
    public static function addAddress($address) {
        $district = $address->getDistrict();
        $street = $address->getStreet();
        $number = $address->getNumber();
        $cep = $address->getCEP();
        $cityID = $address->getCityID();
        $clientID = $address->getClientID();

        $query = "INSERT INTO address (addressDistrict, addressStreet, addressNumber,
                                        addressCEP, addressCityID, addressClientID)

                  VALUES ('$district', '$street', '$number', '$cep', '$cityID', '$clientID')";

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
    public static function updateAddress($address) {
        $addressClientID = $address->getClientID();
        $district = $address->getDistrict();
        $street = $address->getStreet();
        $number = $address->getNumber();
        $cep = $address->getCEP();
        $cityID = $address->getCityID();
        $clientID = $address->getClientID();

        $query = "UPDATE address
                  SET addressDistrict = '$district',
                      addressStreet   = '$street',
                      addressNumber   = '$number',
                      addressCEP      = '$cep',
                      addressCityID   = '$cityID'
                  WHERE addressClientID ='$addressClientID'";

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
     * Get database row of the address, and return a array with address data
     */
    private static function prepareArrayAddress($row) {
        $arrayAddress = array();

        if (!empty($row)) {
          $arrayAddress['district'] = $row['addressDistrict'];
          $arrayAddress['street'] = $row['addressStreet'];
          $arrayAddress['number'] = $row['addressNumber'];
          $arrayAddress['cep'] = $row['addressCEP'];
          $arrayAddress['cityID'] = $row['addressCityID'];
          $arrayAddress['clientID'] = $row['addressClientID'];
        }

        return $arrayAddress;
    }

}

?>
