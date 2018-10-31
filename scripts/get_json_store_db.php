<html>
<body>
<?php

require_once '../model/database.class.php';

require_once '../model/city.class.php' ;
require_once '../model/city_db.class.php';

require_once '../model/state.class.php';
require_once '../model/state_db.class.php';

getCitiesSatesJSON();

function getCitiesSatesJSON() {    
    $str = file_get_contents('../js/json/estados_cidades.json');
    $json = json_decode($str, true);

    foreach ($json as $arrays) {
        foreach ($arrays as $states) {
            //echo '<p>' . $states['sigla'] . ' ' . $states['nome'] . '</p>';
            $arrayState = array();
            $arrayState['name'] = $states['nome'];
            $arrayState['initials'] = $states['sigla'];
            $state = new State($arrayState);

            $state->setID(StateDB::addState($state));
            $cityStateID = $state->getID();
            
            if ($cityStateID == 0) {
                require_once '../error/error_manager.php';
                $msg = 'PDO::lastInsertId() returned 0 in state table';
                $errorMessage = errorManager(__FILE__, __FUNCTION__, NULL, $msg);
                include '../error/error_message.php';
                exit();
            }

            foreach ($states['cidades'] as $cities) {
                //echo '<p>' . $cities . '</p>';
                $arrayCity = array();
                $arrayCity['name'] = $cities;
                $arrayCity['stateID'] = $state->getID();
                $city = new City($arrayCity);
                $city->setStateID($cityStateID);

                $city->setID(CityDB::addCity($city));
            }
            //echo '<hr>';
        }
    }
    
}

?>
</body>
</html>