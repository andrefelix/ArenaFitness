<?php

include 'templates/admin_header.php';

?>

<link rel="stylesheet" href="../css/monthly_client.css">
<!-- Only for subscribe conflited clas in CSS -->
<script src="../js/plugin/jquery_mask_plugin/jquery.mask.js"></script>
<script src="../js/events_list_clients.js"></script>


<?php



echo '<div class="mainContent">';
echo '<div class="content">';
echo '<article class="topContent">';
echo '<header class="mainHeader"><h2><a href="#" title="Lista de clientes">Lista de clientes</a></h2></header>';
echo '<form action="controller.php" method="post" id="findClient">';
echo '<label><b>Pesquisar cliente por nome:</b></label><br>';
echo '<input type="hidden" name="action" value="listClients">';
echo '<input type="text" name="nameClient">';
echo '<button class="searchButton" onclick="searchClient();">Pesquisar cliente</button>';
echo '</form>';
echo '<content>';

if (isset($_POST['nameClient']) && !empty($_POST['nameClient']))
    $clients = ClientDB::getClientByName($_POST['nameClient']);
else
    $clients = ClientDB::getClients();

foreach ($clients as $client) {

    $monthlies = MonthlyDB::getMonthlies($client->getID());

    $imageButton = '<button class="viewButton" onclick="viewButton(this.value);"';
    $imageButton .= 'value="'.$client->getId().'">Visualizar cliente</button>';

    //echo '<form>';
    echo '<input type="hidden" id="clientName'.$client->getID().'" value="'.$client->getName().'">';

    $html = '';

    foreach ($monthlies as $monthly) {

        if ($monthly->getDatePaid() == 0) {
            $datePay = implode('-', array_reverse(explode('/', $monthly->getDatePay())));
            $dateNow = date("y-m-d");

            if (strtotime($datePay) == strtotime($dateNow)) {
                $html .= '<p id="'.$client->getID().'" class="datePay"><strong>'.$client->getName().'</strong>';
                $html .= $imageButton.'</p>';
            }
            else if (strtotime($datePay) > strtotime($dateNow)) {
                $html .= '<p id="'.$client->getID().'" class="datePaid"><strong>'.$client->getName().'</strong>';
                $html .= $imageButton.'</p>';
            }
            else {
                $html .= '<p id="'.$client->getID().'" class="dateNotPaid"><strong>'.$client->getName().'</strong>';
                $html .= $imageButton.'</p>';
            }

            break;
        }
    }

    echo $html;

    //echo '</form>';
}

echo '</content>';
echo '</article>';
echo '</div>';
echo '</div>';

include_once 'templates/admin_footer.php';

?>