<?php

class City {
    private $id;
    private $name;
    private $stateID;

    public function __construct($arrayCity = array()) {
        if (!empty($arrayCity)) {
            $this->name = $arrayCity['name'];
            $this->stateID = $arrayCity['stateID'];
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

    public function setStateID($stateID) {
        $this->stateID = $stateID;
    }

    public function getStateID() {
        return $this->stateID;
    }
}

?>