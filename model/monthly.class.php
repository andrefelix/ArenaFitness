<?php

class Monthly {
    private $id;
    private $datePay;
    private $datePaid;
    private $value;
    private $clientID;

    public function __construct($arrayMonthly = array()) {
        if (!empty($arrayMonthly)) {
            $this->datePay = $arrayMonthly['datePay'];
            $this->datePaid = $arrayMonthly['datePaid'];
            $this->value = $arrayMonthly['value'];
            $this->clientID = $arrayMonthly['clientID'];
        }
    }

    public function setID($id) {
        $this->id = $id;
    }

    public function getID() {
        return $this->id;
    }

    public function setDatePay($datePay) {
        $this->datePay = $datePay;
    }

    public function getDatePay() {
        return $this->datePay;
    }

    public function setDatePaid($datePaid) {
        $this->datePaid = $datePaid;
    }

    public function getDatePaid() {
        return $this->datePaid;
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