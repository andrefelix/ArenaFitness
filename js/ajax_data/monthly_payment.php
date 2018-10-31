<?php

if (!isset($appPath))
    require_once '../../util/main.php';

require_once 'model/database.class.php';
require_once 'model/monthly.class.php';
require_once 'model/monthly_db.class.php';


if (isset($_POST['monthlyID'])) {
    $monthlyID = $_POST['monthlyID'];
    $clientName = $_POST['clientName'];
    
    /*
     * Get monthly, set your paid date and go to the payment
     */
    $monthly = MonthlyDB::getMonthly($monthlyID);
    $datePaid = date('d/m/y');
    $monthly->setDatePaid($datePaid);

    $html = '<strong>' . $clientName . '</strong><br>';

    if (MonthlyDB::updateMonthly($monthly)) {
        $html .= '<strong>Mensalidade paga com sucesso</strong><br>';
        $html .= '<p class="monthly">Data do pagamento: '.$monthly->getDatePaid().'<br>';
        $html .= 'Data do vencimento: '.$monthly->getDatePay().'<br>';
        $html .= 'Valor: '.$monthly->getValue().'<br>';

        /*
         * After payment, set the next pay date
         */
        $datePay = implode('-', array_reverse(explode('/', $monthly->getDatePay())));
        $monthly->setDatePay(date('d/m/y', strtotime($datePay.' +1 month')));
        $monthly->setDatePaid(null);

        /*
         * Initialiy class receive "datePaid", for keep client background green
         * after this, is checked the dates for to put correct class for client
         */
        $class = "datePaid";
        $datePaid = implode('-', array_reverse(explode('/', $datePaid)));

        if (strtotime($datePaid) == strtotime($datePay.' +1 month'))
            $class = "datePay";
        else if (strtotime($datePaid) > strtotime($datePay.' +1 month'))
            $class = "dateNotPaid";

        if (MonthlyDB::addMonthly($monthly) >= 1) {
            $html .= '<strong>Próxima mensalidade foi gerada</strong><br></p>';
            $html .= '<input type="hidden" id="ajaxDatePay" value="'.$class.'">';
        }
        else {
            $html .= '<strong>Erro ao gerar próxima mensalidade. O desenvolvedor ';
            $html .= 'será avisado</strong><br></p>';
        }
    } else {
        $html .= '<strong>Houve um erro ao tentar realizar pagamento. Por favor tente ';
        $html .= 'novamente ou entre em contato com o desenvolvedor</strong><br></p>';
    }

    $html .= '<button class="closeButton" value="'.$monthly->getClientID().'" onclick="closeButton(this.value);">Fechar</button>';
    $html .= '<br>';
    echo $html;
} else
    echo 'Post not set';

?>