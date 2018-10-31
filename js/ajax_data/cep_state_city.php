<?php

if (!isset($appPath))
    require_once '../../util/main.php';

require_once 'model/database.class.php';
require_once 'model/city.class.php';
require_once 'model/city_db.class.php';
require_once 'model/state.class.php';
require_once 'model/state_db.class.php';

if (isset($_POST['cityName']) && isset($_POST['stateInitials'])) {
    $cityName = $_POST['cityName'];
    $stateInitials = $_POST['stateInitials'];
} else {
    echo '<option>No cityName</option>';
    exit();
}

$city = CityDB::getCityByName($cityName);
$state = StateDB::getStateByInitials($stateInitials);
$option = '';

if (isset($city) && isset($state))
    $option = $state->getID() . ';' . $city->getID();
else {
    if (!isset($city))
        $option = 'Erro: Cidade não econtrada no banco de dados';
    else
        $option = 'Erro: Estado não econtrado no banco de dados';
}

echo $option;

?>