<?php
if (!isset($appPath))
    require_once '../../util/main.php';

require_once 'model/database.class.php';
require_once 'model/client.class.php';
require_once 'model/client_db.class.php';
require_once 'model/monthly.class.php';
require_once 'model/monthly_db.class.php';

// Last monthly. Used for upadate pay day
$lastMonthly;
$clientID;

if (isset($_POST['clientID'])) {
    $clientID = $_POST['clientID'];

    $client = ClientDB::getClient($clientID);
    $monthlies = MonthlyDB::getMonthlies($clientID);

    $html = '<strong>' . $client->getName() . '</strong>';

    foreach ($monthlies as $monthly) {
        $html .= '<p class="monthly" id="'.$monthly->getID().'">';

        if ($monthly->getDatePaid() == null || $monthly->getDatePaid() == 0)
            $html .= 'Data do pagamento: Ainda não realizado<br>';
        else
            $html .= 'Data do pagamento: '.$monthly->getDatePaid().'<br>';

        $html .= 'Data do vencimento: '.$monthly->getDatePay().'<br>';
        $html .= 'Valor: '.$monthly->getValue().'<br>';

        if ($monthly->getDatePaid() == 0) {
            $lastMonthly = $monthly;
            $name = $client->getName();

            $buttonPay = '<button class="payButton" value="'.$monthly->getID().'" ';
            $buttonPay .= 'onclick="payButton(this.value, '.$clientID.', \''.$name.'\');">';
            $buttonPay .= 'Realizar Pagamento</button>';

            $monthlyUpdate = '<button class="payButton" value="'.$monthly->getID().'" ';
            $monthlyUpdate .= 'onclick="updateMonthlyView();">Modificar Mensalidade</button><br>';

            $datePay = implode('-', array_reverse(explode('/', $monthly->getDatePay())));
            $dateNow = date("y-m-d");

            if (strtotime($datePay) == strtotime($dateNow))
                $html .= '<strong>Dia de pagamento</strong><br>'.$buttonPay.' '.$monthlyUpdate.'</p>';
            else if (strtotime($datePay) > strtotime($dateNow))
                $html .= '<strong>Pagamento em dia</strong><br>'.$buttonPay.' '.$monthlyUpdate.'</p>';
            else
                $html .= '<strong>Pagamento em atraso</strong><br>'.$buttonPay.' '.$monthlyUpdate.'</p>';
        } else
            $html .= '<strong>Mensalidade paga</strong><br></p>';
    }

    $html .= '<button class="closeButton" value="'.$clientID.'" onclick="closeButton(this.value);">Fechar</button>';
    $html .= '<br>';
    //$html .= '<script type="text/javascript" src="../js/events_list_clients.js"></script>';

    echo $html;
}

?>



<div id="formMonthly" class="modal_">
    <form class="modal-content_ animate_" action="" method="post">
        
        <div class="container">
            <input type="hidden" id="monthlyID" name="monthlyID"
                <?php echo 'value="'.$lastMonthly->getID().'"'; ?> />
            <label><b>Data de vencimento</b></label><br>
            <input type="text" id="monthlyDatePay" name="monthlyDatePay"
                <?php echo 'value="'.$lastMonthly->getDatePay().'"'; ?> />
            <p id="updateDatePay"></p>
            <label><b>Valor da mensalidade</b></label><br>
            <input type="text" id="monthlyValue" name="monthlyValue"
                <?php echo 'value="'.$lastMonthly->getValue().'"'; ?> />
            <p id="updateValue"></p>
            <button type="button" class="buttonMonthlyUpdate" <?php echo 'value="'.$clientID.'"';?>
                    onclick="updateMonthly(this.value);">Atualizar Mensalidade</button><br>

        </div>

        <div class="container_" style="background-color:#f1f1f1">
            <button type="button" onclick="closeMonthlyButton();"
                    class="cancelbtn">Cancelar</button><br>
        </div>

    </form>
</div>
