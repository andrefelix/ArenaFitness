<?php

class Schooling {
    private $id;
    private $description;

    public function __construct($arraySchooling = array()) {
        if (!empty($arraySchooling)) {
            $this->description = $arraySchooling['description'];
        }
    }

    public function setID($id) {
        $this->id = $id;
    }

    public function getID() {
        return $this->id;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }

}

?>