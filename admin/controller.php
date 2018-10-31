<?php

if (!isset($appPath))
    require_once '../util/main.php';

if (isset($_GET['action']))
    $action = $_GET['action'];
else if (isset($_POST['action']))
    $action = $_POST['action'];
else
    $action = '';

switch ($action) {
    case 'listClients':
        require_once 'model/database.class.php';
        require_once 'model/client.class.php';
        require_once 'model/client_db.class.php';
        require_once 'model/address.class.php';
        require_once 'model/address_db.class.php';
        require_once 'model/observation.class.php';
        require_once 'model/observation_db.class.php';
        require_once 'model/monthly.class.php';
        require_once 'model/monthly_db.class.php';

        include_once 'admin/list_clients_view.php';
        
        break;

    case 'registerClientsView':
        require_once 'model/database.class.php';
        require_once 'model/state.class.php';
        require_once 'model/state_db.class.php';
        require_once 'model/city.class.php';
        require_once 'model/city_db.class.php';
        require_once 'model/monthly.class.php';
        require_once 'model/monthly_db.class.php';
        require_once 'model/schooling.class.php';
        require_once 'model/schooling_db.class.php';

        include_once 'admin/register_clients_view.php';

        break;

    case 'registerClients':
        require_once 'model/database.class.php';
        require_once 'model/client.class.php';
        require_once 'model/client_db.class.php';
        require_once 'model/address.class.php';
        require_once 'model/address_db.class.php';
        require_once 'model/observation.class.php';
        require_once 'model/observation_db.class.php';
        require_once 'model/monthly.class.php';
        require_once 'model/monthly_db.class.php';
        require_once 'model/schooling.class.php';
        require_once 'model/schooling_db.class.php';

        include_once 'admin/register_clients.php';

        break;

    case 'monthlyView':
        require_once 'model/database.class.php';
        require_once 'model/client.class.php';
        require_once 'model/client_db.class.php';
        require_once 'model/monthly.class.php';
        require_once 'model/monthly_db.class.php';

        require_once 'admin/monthly_view.php';

        break;

    case 'registerPayment':
        require_once 'model/client.class.php';
        require_once 'model/client_db.class.php';
        require_once 'model/monthly.class.php';
        require_once 'model/monthly_db.class.php';

        require_once 'admin/register_payment.php';

        break;
        
    default:
        header('Location: index.php');
        break;
}

?>