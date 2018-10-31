<?php
if (!isset($appPath))
    require_once '../../util/main.php';

require_once 'model/database.class.php';
require_once 'model/city.class.php';
require_once 'model/city_db.class.php';
require_once 'model/state.class.php';
require_once 'model/state_db.class.php';
require_once 'model/client.class.php';
require_once 'model/client_db.class.php';
require_once 'model/address.class.php';
require_once 'model/address_db.class.php';
require_once 'model/observation.class.php';
require_once 'model/observation_db.class.php';
require_once 'model/monthly.class.php';
require_once 'model/monthly_db.class.php';
require_once 'util/masks.php';


if (isset($_POST['clientID'])) {
    $clientID = $_POST['clientID']; 

    $client = ClientDB::getClient($clientID);
    $address = AddressDB::getAddress($clientID);
    $observation = ObservationDB::getObservation($clientID);
    $city = CityDB::getCity($address->getCityID());
    $state = StateDB::getState($city->getStateID());
    $monthlies = MonthlyDB::getMonthlies($clientID);
    $monthly = $monthlies[0];

    /*
     * Inputs for update
     */
    $html = '<form action="controller.php" id="form'.$clientID.'" method="post">';

    $html .= '<input type="hidden" name="action" value="registerClientsView">';

    $html .= '<input type="hidden" name="clientID" value="'.$client->getID().'">';
    $html .= '<input type="hidden" name="name" value="'.$client->getName().'">';
    $html .= '<input type="hidden" name="cpf" value="'.$client->getCPF().'">';
    $html .= '<input type="hidden" name="rg" value="'.$client->getRG().'">';
    $html .= '<input type="hidden" name="gender" value="'.$client->getGender().'">';
    $html .= '<input type="hidden" name="civilStatus" value="'.$client->getCivilStatus().'">';
    $html .= '<input type="hidden" name="email" value="'.$client->getEmail().'">';
    $html .= '<input type="hidden" name="schoolingID" value="'.$client->getSchoolingID().'">';
    $html .= '<input type="hidden" name="profession" value="'.$client->getProfession().'">';

    $html .= '<input type="hidden" name="birthDate" value="'.$client->getBirthDate().'">';
    $html .= '<input type="hidden" name="beginDate" value="'.$client->getBeginDate().'">';
    $html .= '<input type="hidden" name="cellPhone" value="'.$client->getCellPhone().'">';
    $html .= '<input type="hidden" name="homePhone" value="'.$client->getHomePhone().'">';
    $html .= '<input type="hidden" name="workPhone" value="'.$client->getWorkPhone().'">';
    $html .= '<input type="hidden" name="emergencyPhone" value="'.$client->getEmergencyPhone().'">';
    //$html .= '<input type="hidden" name="schooling" value="'.$client->getSchooling().'">';
    //$html .= '<input type="hidden" name="profession" value="'.$client->getProfession().'">';
    $html .= '<input type="hidden" name="noInstructor" value="'.$client->getNoInstructor().'">';

    $html .= '<input type="hidden" name="observation" value="'.$observation->getText().'">';

    $html .= '<input type="hidden" name="addressID" value="'.$address->getID().'">';
    $html .= '<input type="hidden" name="district" value="'.$address->getDistrict().'">';
    $html .= '<input type="hidden" name="street" value="'.$address->getStreet().'">';
    $html .= '<input type="hidden" name="number" value="'.$address->getNumber().'">';
    $html .= '<input type="hidden" name="cep" value="'.$address->getCEP().'">';
    $html .= '<input type="hidden" name="cityID" value="'.$city->getID().'">';
    $html .= '<input type="hidden" name="stateID" value="'.$state->getID().'">';

    $html .= '<input type="hidden" name="value" value="'.$monthly->getValue().'">';

    $html .= '</form>';

    $html .= '<strong>'.$client->getName().'</strong><br>';
    $html .= 'CPF: '.mask($client->getCPF(), '###.###.###-##').'<br>';
    $html .= 'RG: '.$client->getRG().'<br>';
    $html .= 'Data de nascimento: '.$client->getBirthDate().'<br>';
    $html .= 'Email: '.$client->getEmail().'<br>';
    $html .= 'Estado: '.$state->getInitials().'<br>';
    $html .= 'Cidade: '.$city->getName().'<br>';
    $html .= 'Bairro: '.$address->getDistrict().'<br>';
    $html .= 'Rua: '.$address->getStreet().'<br>';
    $html .= 'Número: '.$address->getNumber().'<br>';
    $html .= 'CEP: '.mask($address->getCEP(), '#####-###').'<br>';
    $html .= 'Celular: '.mask($client->getCellPhone(), '(##)#####-####').'<br>';
    $html .= 'Fone residencial: '.mask($client->getHomePhone(), '(##)####-####').'<br>';
    $html .= 'Fone comencial: '.mask($client->getWorkPhone(), '(##)####-####').'<br>';
    $html .= 'Fone emergencial: '.mask($client->getEmergencyPhone(), '(##)####-####').'<br>';

    if ($client->getNoInstructor())
        $html .= '<strong>Cliente não possui instrutor<br></strong>';

    $html .= 'Observação: '.$observation->getText().'<br>';

    

    foreach ($monthlies as $monthly) {
        if ($monthly->getDatePaid() == 0) {
            $datePay = implode('-', array_reverse(explode('/', $monthly->getDatePay())));
            $dateNow = date("y-m-d");

            if (strtotime($datePay) == strtotime($dateNow))
                $html .= '<strong>Dia de pagamento</strong><br>';
            else if (strtotime($datePay) > strtotime($dateNow))
                $html .= '<strong>Pagamento em dia</strong><br>';
            else
                $html .= '<strong>Pagamento em atraso</strong><br>';
        }
    }


    $html .= '<button class="monthlyButton" value="'.$clientID.'" onclick="monthlyButton(this.value);">Mensalidade</button>';
    $html .= '<button class="updateButton" value="'.$clientID.'" onclick="updateButton(this.value);">Atualizar</button>';
    $html .= '<button class="deleteButton" value="'.$clientID.'" onclick="deleteButton(this.value);">Deletar</button>';
    $html .= '<button class="closeButton" value="'.$clientID.'" onclick="closeButton(this.value)">Fechar</button>';
    $html .= '<br>';
    
    //$html .= '<script type="text/javascript" src="../js/events_list_clients.js"></script>';

    echo $html;
}

?>