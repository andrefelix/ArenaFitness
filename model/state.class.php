<?php

class State {
    private $id;
    private $name;
    private $initials;

    public function __construct($arrayState = array()) {
        if (!empty($arrayState)) {
            $this->name = $arrayState['name'];
            $this->initials = $arrayState['initials'];
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

    public function setInitials($initials) {
        $this->initials = $initials;
    }

    public function getInitials() {
        return $this->initials;
    }
}

?>