<?php

class Client {
    // personal data
    private $id;
    private $name;
    private $cpf;
    private $rg;
    private $civilStatus;
    private $gender;
    private $email;
    private $birthDate;

    // phones
    private $cellPhone;
    private $homePhone;
    private $workPhone;
    private $emergencyPhone;

    // professionals data
    private $schoolingID;
    private $profession;

    // complementary data
    private $beginDate;
    private $noInstructor;

    public function __construct($arrayClient = array()) {
        if (!empty($arrayClient)) {
            // personal data
            $this->name = $arrayClient['name'];
            $this->cpf = $arrayClient['cpf'];
            $this->rg = $arrayClient['rg'];
            $this->civilStatus = $arrayClient['civilStatus'];
            $this->gender = $arrayClient['gender'];
            $this->email = $arrayClient['email'];
            $this->birthDate = $arrayClient['birthDate'];

            // phones
            $this->cellPhone = $arrayClient['cellPhone'];
            $this->homePhone = $arrayClient['homePhone'];
            $this->workPhone = $arrayClient['workPhone'];
            $this->emergencyPhone = $arrayClient['emergencyPhone'];

            // personal data
            $this->schoolingID = $arrayClient['schoolingID'];
            $this->profession = $arrayClient['profession'];

            // complementary data
            $this->beginDate = $arrayClient['beginDate'];
            $this->noInstructor = $arrayClient['noInstructor'];
        }
    }

    public function getAll() {
        $client = array();

        $client['id'] = $this->id;
        $client['name'] = $this->name;
        $client['cpf'] = $this->cpf;
        $client['rg'] = $this->rg;
        $client['birthDate'] = $this->birthDate;
        $client['civilStatus'] = $this->civilStatus;
        $client['gender'] = $this->gender;
        $client['email'] = $this->email;
        $client['cellPhone'] = $this->cellPhone;
        $client['homePhone'] = $this->homePhone;
        $client['workPhone'] = $this->workPhone;
        $client['emergencyPhone'] = $this->emergencyPhone;
        $client['schoolingID'] = $this->schoolingID;
        $client['profession'] = $this->profession;
        $client['beginDate'] = $this->beginDate;
        $client['noInstructor'] = $this->noInstructor;

        return $client;
    }

    public function setID($id) {
        $this->id = $id;
    }

    public function getID() {
        return $this->id;
    }

    /*
     * Personal geters and seters
     */
    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setCPF($cpf) {
        $this->cpf = $cpf;
    }

    public function getCPF() {
        return $this->cpf;
    }

    public function setRG($rg) {
        $this->rg = $rg;
    }

    public function getRG() {
        return $this->rg;
    }

    public function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;
    }

    public function getBirthDate() {
        return $this->birthDate;
    }

    public function setCivilStatus($civilStatus) {
        $this->civilStatus = $civilStatus;
    }

    public function getCivilStatus() {
        return $this->civilStatus;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    /*
     * Phones geters and seters
     */
    public function setCellPhone($cellPhone) {
        $this->cellPhone = $cellPhone;
    }

    public function getCellPhone() {
        return $this->cellPhone;
    }

    public function setHomePhone($homePhone) {
        $this->homePhone = $homePhone;
    }

    public function getHomePhone() {
        return $this->homePhone;
    }

    public function setWorkPhone($workPhone) {
        $this->workPhone = $workPhone;
    }

    public function getWorkPhone() {
        return $this->workPhone;
    }

    public function setEmergencyPhone($emergencyPhone) {
        $this->emergencyPhone = $emergencyPhone;
    }

    public function getEmergencyPhone() {
        return $this->emergencyPhone;
    }

    /*
     * Professional geters and seters
     */
    public function setSchoolingID($schoolingID) {
        $this->schoolingID = $schoolingID;
    }

    public function getSchoolingID() {
        return $this->schoolingID;
    }

    public function setProfession($profession) {
        $this->profession = $profession;
    }

    public function getProfession() {
        return $this->profession;
    }

    /*
     * Complementary geters and seters
     */
    public function setBeginDate($beginDate) {
        $this->beginDate = $beginDate;
    }

    public function getBeginDate() {
        return $this->beginDate;
    }

    public function setNoInstructor($noInstructor) {
        $this->noInstructor = $noInstructor;
    }

    public function getNoInstructor() {
        return $this->noInstructor;
    }

}

?>