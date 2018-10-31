<?php
if (!isset($appPath))
    require_once '../../util/main.php';

require_once 'model/database.class.php';
require_once 'model/client.class.php';
require_once 'model/client_db.class.php';
require_once 'model/address.class.php';
require_once 'model/address_db.class.php';
require_once 'model/observation.class.php';
require_once 'model/observation_db.class.php';
require_once 'model/monthly.class.php';
require_once 'model/monthly_db.class.php';

if (isset($_POST['clientID'])) {
    $clientID = $_POST['clientID'];

    $client = ClientDB::getClient($clientID);
    $address = AddressDB::getAddress($clientID);
    $observation = ObservationDB::getObservation($clientID);
    $monthlies = MonthlyDB::getMonthlies($clientID);

    $deleteClean = true;
    $html = '';

    if (isset($observation) && !empty($observation) && 
        !ObservationDB::deleteObservation($clientID)) {
        $html .= 'Falha ao deletar observação do cliente. ';
        $deleteClean = false;
    }

    if (isset($address) && !empty($address) && 
        !AddressDB::deleteAddress($clientID)) {
        $html .= 'Falha ao deletar endereço do cliente. ';
        $deleteClean = false;
    }

    foreach ($monthlies as $monthly) {
        if (!MonthlyDB::deleteMonthly($monthly->getID())) {
            $html .= 'Falha ao a deletar mensalidade do cliente. ';
            $deleteClean = false;
        }
    }
    
    if ($deleteClean == true) {
        if (isset($client) && !empty($client) && 
            !ClientDB::deleteClient($clientID)) {
            $html = 'Falha ao deletar o cliente. Por favor entre em contato com
                     o desenvolvedor.';
        }
    } else {
        $html .= 'Por favor entre em contato com o desenvolvedor';
    }

    echo $html;
} else
    echo "No post";

?>