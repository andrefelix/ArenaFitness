<?php

if (!isset($appPath))
    require_once '../../util/main.php';

require_once 'model/database.class.php';
require_once 'model/monthly.class.php';
require_once 'model/monthly_db.class.php';

if (isset($_POST['monthlyID'])) {
    $arrayPost = $_POST;

    /*
     * Complete array with desnecessary info, only for avoid PHP warnings
     */
    $arrayPost['datePaid'] = 0;
    $arrayPost['clientID'] = 0;

    $monthly = new Monthly($arrayPost);
    $monthly->setID($arrayPost['monthlyID']);

    if (MonthlyDB::updateMonthly($monthly))
        echo 'Mensalidade alterado com sucesso.';
    else
        echo '';
}

?>