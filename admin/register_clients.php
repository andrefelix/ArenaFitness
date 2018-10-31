<?php

if (!isset($appPath))
    require_once '../util/main.php';

$msg = '';
$operationFail = false;
$emptyFields = array();

if (isset($_POST) && !empty($_POST)) {
    foreach ($_POST as $key => $value) {
        // noInstructor can contain 0 value and empty(0) is TRUE
        if (empty($value) && $key != 'noInstructor')
            $emptyFields[$key] = $key;
    }
} else {
    $msg = 'Register client POST is NULL';
    $operationFail = true;
}

if (empty($emptyFields)) {
    $arrayPost = array();
    $arrayPost = $_POST;

    foreach ($_POST as $key => $value) {
        if ($key == 'cep' || $key == 'number')
            $arrayPost[$key]= preg_replace("/[^0-9]/", "", $arrayPost[$key]);
        else if ($key != 'observation' && $key != 'email' && $key != 'beginDate' && $key != 'birthDate')
            $arrayPost[$key] = preg_replace("/[^a-zA-Z0-9\s]/", "", $arrayPost[$key]);
    }

    $client = new Client($arrayPost);
    $address = new Address($arrayPost);

    $obs = array();
    $obs['text'] = $arrayPost['observation'];
    $obs['clientID'] = isset($arrayPost['clientID']) ? $arrayPost['clientID'] : null;
    $observation = new Observation($obs);

    // UPDATE
    if (isset($arrayPost['clientID'])) {
        $client->setID($arrayPost['clientID']);

        if (ClientDB::updateClient($client) == 0)
            $msg .= 'Dados pessoais não foram modificados<br>';

        if (AddressDB::updateAddress($address) == 0)
            $msg .= 'Endereço não foi modificado<br>';

        if (ObservationDB::updateObservation($observation) == 0)
            $msg .= 'Observação não foi modificada<br>';

        $msg .= 'Processo de atualização concluído.';

    } else { // REGISTER
        $month = array();
        $month['datePay'] = $arrayPost['beginDate'];
        $month['datePaid'] = null; // Notthing paid
        $month['value'] = $arrayPost['value'];
        $monthly = new Monthly($month);

        $clientID = ClientDB::addClient($client);

        if ($clientID != 0) {
            $client->setID($clientID);
            $address->setClientID($clientID);
            $observation->setClientID($clientID);
            $monthly->setClientID($clientID);

            if (AddressDB::addAddress($address) == 0)
                $msg .= 'Not insert address values in DB<br>';

            if (ObservationDB::addObservation($observation) == 0)
                $msg .= 'Not insert observation values in DB<br>';

            if (MonthlyDB::addMonthly($monthly) == 0)
                $msg .= 'Not insert monthly values in DB<br>';

            if (empty($msg))
                $msg = 'Cliente cadastrado com sucesso!';
            else
                $operationFail = true;
        }
    }

} else {
    $msg = 'Os campos';

    foreach ($emptyFields as $key => $value) {
        $msg .= ' - ' . $key;
    }

    $msg .= ' estão vazios';
    $operationFail = true;
}


if ($operationFail == true) {
    require_once 'error/error_manager.php';
    $errorMessage = errorManager(__FILE__, null, null, $msg);
    require_once 'error/error_message.php';
} else {
    require_once 'templates/admin_header.php';
    echo '<h2>'.$msg.'</h2>';
    require_once 'templates/admin_footer.php';
}

?>