<?php

class Address {
    private $id;
    private $district;
    private $street;
    private $number;
    private $cep;
    private $cityID;
    private $clientID;

    public function __construct($arrayAddress = array()) {
        if (!empty($arrayAddress)) {
            $this->district = $arrayAddress['district'];
            $this->street = $arrayAddress['street'];
            $this->number = $arrayAddress['number'];
            $this->cep = $arrayAddress['cep'];
            $this->cityID = $arrayAddress['cityID'];
            $this->clientID = $arrayAddress['clientID'];
        }
    }

    public function setID($id) {
        $this->id = $id;
    }

    public function getID() {
        return $this->id;
    }

    public function setDistrict($district) {
        $this->district = $district;
    }

    public function getDistrict() {
        return $this->district;
    }

    public function setStreet($street) {
        $this->street = $street;
    }

    public function getStreet() {
        return $this->street;
    }

    public function setNumber($number) {
        $this->number= $number;
    }

    public function getNumber() {
        return $this->number;
    }

    public function setCEP($cep) {
        $this->name = $name;
    }

    public function getCEP() {
        return $this->cep;
    }

    public function setCityID($cityID) {
        $this->cityID = $cityID;
    }

    public function getCityID() {
        return $this->cityID;
    }

     public function setClientID($clientID) {
        $this->clientID = $clientID;
    }

    public function getClientID() {
        return $this->clientID;
    }

}

?>