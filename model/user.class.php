<?php

class User {
    private $id;
    private $name;
    private $password;
    private $salt;

    public function __construct($arrayUser = array()) {
        if (!empty($arrayUser)) {
            $this->name = $arrayUser['name'];
            $this->password = $arrayUser['password'];
            $this->salt = $arrayUser['salt'];
        }
    }

    public function setID($id) {
        $this->id = $id;
    }

    public function getID() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }

    public function getSalt() {
        return $this->salt;
    }

}

?>