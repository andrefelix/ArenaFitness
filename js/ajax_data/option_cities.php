<?php

if (!isset($appPath))
    require_once '../../util/main.php';

require_once 'model/database.class.php';
require_once 'model/city.class.php';
require_once 'model/city_db.class.php';

if (isset($_POST['id']))
    $stateID = $_POST['id'];
else {
    echo '<option>No stateID</option>';
    exit();
}

$cities = CityDB::getCities($stateID);

$option = '';

foreach ($cities as $city) {
    $option .= '<option value="' . $city->getID() . '">';
    $option .= $city->getName() . '</option>';
}

echo $option;

?>