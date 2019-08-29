<?php

class Database {

    private static $dbName = 'arena_fitness';
    private static $host = 'localhost';
    private static $dsn = 'mysql:host=localhost;dbname=arena_fitness';
    private static $username = 'root';
    private static $password = '';
    private static $db;

    /*
     * __contruct is never called because the class is static
     */
    private function __construct() {
        self::createTables();
    }

    public static function getDB() {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn, self::$username, self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                /*
                $sql = 'CREATE DATABASE IF NOT EXISTS ' . self::$dbName . ';';
                self::$db->exec($sql);
                */
            } catch(PDOException $e) {
                require_once 'error/error_manager.php';
                $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
                include 'error/error_message.php';
                exit();
            }
        }
        
        // Is not necessary call createTables every time, just one time is needed
        //self::createTables();

        return self::$db;
    }

    private static function createTables() {
        /*
         * Automated create tables, if not exists
         */
        $sql = "";
        $sql .= "CREATE TABLE IF NOT EXISTS `arena_fitness`.`user` ( `userID` INT(7) NOT NULL AUTO_INCREMENT , `userName` VARCHAR(60) NOT NULL , `userPassword` VARCHAR(30) NOT NULL , `userSalt` VARCHAR(13) NOT NULL , PRIMARY KEY (`userID`)) ENGINE = InnoDB;";
        $sql .= "CREATE TABLE IF NOT EXISTS `arena_fitness`.`client` ( `clientID` INT(7) NOT NULL AUTO_INCREMENT , `clientName` VARCHAR(60) NOT NULL , `clientCPF` INT(11) NOT NULL , `clientRG` VARCHAR(13) NOT NULL , `clientCivilStatus` VARCHAR(10) NOT NULL , `clientGender` VARCHAR(1) NOT NULL , `clientEmail` VARCHAR(63) NOT NULL , `clientBirthDate` DATE NOT NULL , `clientCellPhone` INT(11) NOT NULL , `clientHomePhone` INT(10) NOT NULL , `clientWorkPhone` INT(10) NOT NULL , `clientEmergencyPhone` INT(10) NOT NULL , `clientSchooling` VARCHAR(50) NOT NULL , `clientProfession` VARCHAR(50) NOT NULL , `clientBeginDate` DATE NOT NULL , `clientNoInstructor` VARCHAR(1) NOT NULL , PRIMARY KEY (`clientID`)) ENGINE = InnoDB;";
        $sql .= "CREATE TABLE IF NOT EXISTS `arena_fitness`.`address` ( `addressID` INT(7) NOT NULL AUTO_INCREMENT , `addressDistrict` VARCHAR(50) NOT NULL , `addressStreet` VARCHAR(60) NOT NULL , `addressNumber` INT(4) NOT NULL , `adressCEP` INT(8) NOT NULL , `addressCityID` INT(4) NOT NULL , `addressClientID` INT(7) NOT NULL , PRIMARY KEY (`addressID`)) ENGINE = InnoDB;";
        $sql .= "CREATE TABLE IF NOT EXISTS `arena_fitness`.`city` ( `cityID` INT(4) NOT NULL AUTO_INCREMENT , `cityName` VARCHAR(40) NOT NULL , `cityStateID` INT(2) NOT NULL , PRIMARY KEY (`cityID`)) ENGINE = InnoDB;";
        $sql .= "CREATE TABLE IF NOT EXISTS `arena_fitness`.`state` ( `stateID` INT(2) NOT NULL AUTO_INCREMENT , `stateName` VARCHAR(40) NOT NULL , `stateInitials` VARCHAR(2) NOT NULL , PRIMARY KEY (`stateID`)) ENGINE = InnoDB;";
        $sql .= "CREATE TABLE IF NOT EXISTS `arena_fitness`.`observation` ( `observationID` INT(7) NOT NULL AUTO_INCREMENT , `observationText` VARCHAR(250) NOT NULL , `observationClientID` INT(7) NOT NULL , PRIMARY KEY (`observationID`)) ENGINE = InnoDB;";
        $sql .= "CREATE TABLE IF NOT EXISTS `arena_fitness`.`schooling` ( `schoolingID` INT NOT NULL AUTO_INCREMENT , `schooling` VARCHAR(60) NOT NULL , PRIMARY KEY (`schoolingID`)) ENGINE = InnoDB;";
        
        try {
            self::$db->exec($sql);
        } catch(PDOException $e) {
            require_once 'error/error_manager.php';
            $errorMessage = errorManager(__FILE__, __FUNCTION__, $e->getCode(), $e->getMessage());
            include 'error/error_message.php';
            exit();
        }

        /*
         * CREATE TABLE `arena_fitness`.`client` ( `clientID` INT(7) NOT NULL AUTO_INCREMENT , `clientName` VARCHAR(60) NOT NULL , `clientCPF` INT(11) NOT NULL , `clientRG` VARCHAR(13) NOT NULL , `clientCivilStatus` VARCHAR(10) NOT NULL , `clientGender` VARCHAR(1) NOT NULL , `clientEmail` VARCHAR(63) NOT NULL , `clientBirthDate` DATE NOT NULL , `clientCellPhone` INT(11) NOT NULL , `clientHomePhone` INT(10) NOT NULL , `clientWorkPhone` INT(10) NOT NULL , `clientEmergencyPhone` INT(10) NOT NULL , `clientSchooling` VARCHAR(50) NOT NULL , `clientProfession` VARCHAR(50) NOT NULL , `clientBeginDate` DATE NOT NULL , `clientNoInstructor` VARCHAR(1) NOT NULL , PRIMARY KEY (`clientID`)) ENGINE = InnoDB;
         * CREATE TABLE `arena_fitness`.`address` ( `addressID` INT(7) NOT NULL AUTO_INCREMENT , `addressDistrict` VARCHAR(50) NOT NULL , `addressStreet` VARCHAR(60) NOT NULL , `addressNumber` INT(4) NOT NULL , `adressCEP` INT(8) NOT NULL , `addressCityID` INT(4) NOT NULL , `addressClientID` INT(7) NOT NULL , PRIMARY KEY (`addressID`)) ENGINE = InnoDB;
         * CREATE TABLE `arena_fitness`.`city` ( `cityID` INT(4) NOT NULL AUTO_INCREMENT , `cityName` VARCHAR(40) NOT NULL , `cityStateID` INT(2) NOT NULL , PRIMARY KEY (`cityID`)) ENGINE = InnoDB;
         * CREATE TABLE `arena_fitness`.`state` ( `stateID` INT(2) NOT NULL AUTO_INCREMENT , `stateName` VARCHAR(40) NOT NULL , `stateInitials` VARCHAR(2) NOT NULL , PRIMARY KEY (`stateID`)) ENGINE = InnoDB;
         * CREATE TABLE `arena_fitness`.`observation` ( `observationID` INT(7) NOT NULL AUTO_INCREMENT , `observationText` VARCHAR(250) NOT NULL , `observationClientID` INT(7) NOT NULL , PRIMARY KEY (`observationID`)) ENGINE = InnoDB;
         * CREATE TABLE `arena_fitness`.`schooling` ( `schoolingID` INT NOT NULL AUTO_INCREMENT , `schooling` VARCHAR(60) NOT NULL , PRIMARY KEY (`schoolingID`)) ENGINE = InnoDB;
         */
    }

}

?>
