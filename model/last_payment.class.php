<?php

class LastPayment {
    private $id;
    private $date;
    private $value;
    private $clientID;

    public function __construct($arrayLastPayment = array()) {
        if (!empty($arrayState)) {
            $this->date = $arrayLastPayment['date'];
            $this->value = $arrayLastPayment['value']
            $this->clientID = $arrayLastPayment['clientID'];
        }
    }

    public function setID($id) {
        $this->id = $id;
    }

    public function getID() {
        return $this->id;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getDate() {
        return $this->date;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getValue() {
        return $this->value;
    }

    public function setClientID($clientID) {
        $this->clientID = $clientID;
    }

    public function getClientID() {
        return $this->clientID;
    }
}

?>