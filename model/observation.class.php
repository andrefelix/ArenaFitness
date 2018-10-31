<?php

class Observation {
    private $id;
    private $text;
    private $clientID;

    public function __construct($arrayObservation = array()) {
        if (!empty($arrayObservation)) {
            $this->text = $arrayObservation['text'];
            $this->clientID = $arrayObservation['clientID'];
        }
    }

    public function setID($id) {
        $this->id = $id;
    }

    public function getID() {
        return $this->id;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getText() {
        return $this->text;
    }

    public function setClientID($clientID) {
        $this->clientID = $clientID;
    }

    public function getClientID() {
        return $this->clientID;
    }
}

?>