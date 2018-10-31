<?php 

include 'templates/admin_header.php';

?>

<script src="../js/plugin/jquery_mask_plugin/jquery.mask.js"></script>
<script src="../js/validate_register_clients.js"></script>
<link rel="stylesheet" href="../css/form_style.css">

<?php

/*
 * Initialize all fields vars, with empty value or DB values case user is doing
 * update
 */

$clientID = isset($_POST['clientID']) ? $_POST['clientID'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
$rg = isset($_POST['rg']) ? $_POST['rg'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$civilStatus = isset($_POST['civilStatus']) ? $_POST['civilStatus'] : '';
$birthDate = isset($_POST['birthDate']) ? $_POST['birthDate'] : '';
$beginDate = isset($_POST['beginDate']) ? $_POST['beginDate'] : '';
$cellPhone = isset($_POST['cellPhone']) ? $_POST['cellPhone'] : '';
$homePhone = isset($_POST['homePhone']) ? $_POST['homePhone'] : '';
$workPhone = isset($_POST['workPhone']) ? $_POST['workPhone'] : '';
$emergencyPhone = isset($_POST['emergencyPhone']) ? $_POST['emergencyPhone'] : '';
$schoolingID = isset($_POST['schoolingID']) ? $_POST['schoolingID'] : '';
$profession = isset($_POST['profession']) ? $_POST['profession'] : '';
$noInstructor = isset($_POST['noInstructor']) ? $_POST['noInstructor'] : '';

$observation = isset($_POST['observation']) ? $_POST['observation'] : '';

$value = isset($_POST['value']) ? $_POST['value'] : '';

$district = isset($_POST['district']) ? $_POST['district'] : '';
$street = isset($_POST['street']) ? $_POST['street'] : '';
$cep = isset($_POST['cep']) ? $_POST['cep'] : '';
$number = isset($_POST['number']) ? $_POST['number'] : '';

$cityID = isset($_POST['cityID']) ? $_POST['cityID'] : '';
$stateID = isset($_POST['stateID']) ? $_POST['stateID'] : '';

?>

<form action="controller.php" method="post" id="registerClientsForm">
    <input type="hidden" id="action" name="action" value="registerClients">
    <div class="form">

        <input type="hidden" id="clientID" name="clientID" <?php echo 'value="'.$clientID.'"';?> />

        <fieldset>
            <legend>Dados pessoais:</legend>
            <p class="input">
                <label>Nome:</label>
                <input type="text" id="name" name="name" placeHolder="Nome do cliente"
                <?php echo 'value="'.$name.'"';?> />
                <p id="validMessageName" class="validateMessage"></p>
            </p>

            <p class="input">
                <label>CPF:</label>
                <input type="text" id="cpf" name="cpf" placeHolder="CPF"
                <?php echo 'value="'.$cpf.'"';?> />
                <p id="validMessageCPF" class="validateMessage"></p>
            </p>   

            <p class="input">
                <label>RG:</label>
                <input type="text" id="rg" name="rg" placeHolder="RG"
                <?php echo 'value="'.$rg.'"';?> />
                <p id="validMessageRG" class="validateMessage"></p>
            </p>

            <p class="input">
                <label>Nascimento:</label>
                <input type="text" id="birthDate" name="birthDate" placeHolder="Data de nascimento"
                <?php echo 'value="'.$birthDate.'"';?> />
                <p id="validMessageBirthDate" class="validateMessage"></p>
            </p>

            <p class="input">
                <label>Estado civil:</label>
                <select id="civilStatus" name="civilStatus">
                    
                    <?php
                    if (!empty($civilStatus)) {
                        echo '<option value="'.$civilStatus.'" selected>'.$civilStatus;
                        echo '</option>';
                    ?>
                        <option value="casado">Casado(a)</option>
                        <option value="solteiro">Solteiro(a)</option>
                        <option value="divorciado">Divorciado(a)</option>
                        <option value="viuvo">Víuvo(a)</option>
                    <?php
                    } else {
                    ?>
                        <option value="none" selected>Escolha uma opção</option>
                        <option value="casado">Casado(a)</option>
                        <option value="solteiro">Solteiro(a)</option>
                        <option value="divorciado">Divorciado(a)</option>
                        <option value="viuvo">Víuvo(a)</option>
                    <?php
                    }
                    ?>

                </select>
                <p id="validMessageCivilStatus" class="validateMessage"></p>
            </p>

            <p class="input">
                <label>SEXO:</label>

                <?php
                if (empty($gender)) {
                ?>
                    <input type="radio"  name="gender" value="M">M
                    <input type="radio"  name="gender" value="F">F
                <?php
                } else if ($gender == 'M') {
                ?>
                    <input type="radio"  name="gender" value="M" checked>M
                    <input type="radio"  name="gender" value="F">F
                <?php
                } else {
                ?>
                    <input type="radio"  name="gender" value="M">M
                    <input type="radio"  name="gender" value="F" checked>F
                <?php
                }
                ?>

                <p id="validMessageGender" class="validateMessage"></p>
            </p>

            <p class="input">
                <label>Email:</label>
                <input type="email" id="email" name="email" placeHolder="Email"
                <?php echo 'value="'.$email.'"';?> />
                <p id="validMessageEmail" class="validateMessage"></p>
            </p>

            <p>
                <label>Escolaridade:</label>
                <select id="schoolingID" name="schoolingID">
                    <option value="none">Escolha uma escolaridade</option>
                    <?php

                    $schoolings = SchoolingDB::getSchoolings();

                    foreach ($schoolings as $schooling) {
                        if ($schooling->getID() == $schoolingID)
                            $option = '<option selected ';
                        else
                            $option = '<option ';

                        $option .= 'value="' . $schooling->getID() . '">';
                        $option .= $schooling->getDescription() . '</option>';
                        echo $option;
                    }

                    ?>
                </select>
                <p id="validMessageSchoolingID" class="validateMessage"></p>
            </p>

            <p>
                <label>Profissão:</label>
                <input type="text" id="profession" name="profession" placeHolder="Profissão do cliente"
                <?php echo 'value="'.$profession.'"';?> />
                <p id="validMessageProfession" class="validateMessage"></p>
            </p>
        </fieldset>

        <fieldset>
            <legend>Telefones:</legend>
            <p>
                <label>Celular:</label>
                <input type="text" id="cellPhone" name="cellPhone" placeHolder="Telefone celular"
                <?php echo 'value="'.$cellPhone.'"';?> />
                <p id="validMessageCellPhone" class="validateMessage"></p>
            </p>
            <p>
                <label>Residencial:</label>
                <input type="text" id="homePhone" name="homePhone" placeHolder="Telefone residencial"
                <?php echo 'value="'.$homePhone.'"';?> />
                <p id="validMessageHomePhone" class="validateMessage"></p>
            </p>
            <p>
                <label>Comercial:</label>
                <input type="text" id="workPhone" name="workPhone" placeHolder="Telefone comercial"
                <?php echo 'value="'.$workPhone.'"';?> />
                <p id="validMessageWorkPhone" class="validateMessage"></p>
            </p>
            <p>
                <label>Emergência:</label>
                <input type="text" id="emergencyPhone" name="emergencyPhone" placeHolder="Telefone de emergência"
                <?php echo 'value="'.$emergencyPhone.'"';?> />
                <p id="validMessageEmergencyPhone" class="validateMessage"></p>
            </p>
        </fieldset>

        <fieldset>
            <legend>Endereço:</legend>
            <p>
                <label>Estado:</label>
                <select id="stateID" name="stateID">
                    <option value="none">Escolha um estado</option>
                    <?php

                    $states = StateDB::getStates();

                    foreach ($states as $state) {
                        if ($state->getID() == $stateID)
                            $option = '<option selected ';
                        else
                            $option = '<option ';

                        $option .= 'value="' . $state->getID() . '">';
                        $option .= $state->getInitials() . '</option>';
                        echo $option;
                    }

                    ?>
                </select>
                <p id="validMessageStateID" class="validateMessage"></p>
            </p>
            <p>
                <label>Cidade:</label>
                <select id="cityID" name="cityID">
                    <option value="none">Escolha a cidade</option>
                    <?php

                    $cities = CityDB::getCities($stateID);

                    foreach ($cities as $city) {
                        if ($city->getID() == $cityID)
                            $option = '<option selected ';
                        else
                            $option = '<option ';
                        
                        $option .= 'value="' . $city->getID() . '">';
                        $option .= $city->getName() . '</option>';
                        echo $option;
                    }

                    ?>
                </select>
                <p id="validMessageCityID" class="validateMessage"></p>
            </p>
            <p>
                <label>Bairro:</label>
                <input type="text" id="district" name="district" placeHolder="Bairro"
                <?php echo 'value="'.$district.'"';?> />
                <p id="validMessageDistrict" class="validateMessage"></p>
            </p>
            <p>
                <label>Rua:</label>
                <input type="text" id="street" name="street" placeHolder="Rua"
                <?php echo 'value="'.$street.'"';?> />
                <p id="validMessageStreet" class="validateMessage"></p>
            </p>
            <p>
                <label>Número:</label>
                <input type="text" id="number" name="number" placeHolder="Número"
                <?php echo 'value="'.$number.'"';?> />
                <p id="validMessageNumber" class="validateMessage"></p>
            </p>
            <p>
                <label>CEP:</label>
                <input type="text" id="cep" name="cep" placeHolder="CEP"
                <?php echo 'value="'.$cep.'"';?> />
                <p id="validMessageCEP" class="validateMessage"></p>
            </p>
        </fieldset>

        <fieldset>
            <legend>Dados complementares:</legend>
            <p>
                <label>Data de início:</label>
                <input type="text" id="beginDate" name="beginDate" placeHolder="Data de início"
                <?php echo 'value="'.$beginDate.'"';?> />
                <p id="validMessageBeginDate" class="validateMessage"></p>
            </p>
            <p>
                <label>Valor da mensalidade:</label>
                <input type="text" id="value" name="value" placeHolder="valor"
                <?php echo 'value="'.$value.'"';?> />
                <p id="validMessageValue" class="validateMessage"></p>
            </p>
            <p>
                <label>Com Personal:</label>
                
                <?php
                if ($noInstructor === '') {
                ?>
                    <input type="radio" name="noInstructor" value="0">SIM
                    <input type="radio" name="noInstructor" value="1">NÃO
                <?php
                } else if ($noInstructor == 0) {
                ?>
                    <input type="radio" name="noInstructor" value="0" checked>SIM
                    <input type="radio" name="noInstructor" value="1">NÃO
                <?php
                } else {
                ?>
                    <input type="radio" name="noInstructor" value="0">SIM
                    <input type="radio" name="noInstructor" value="1" checked>NÃO
                <?php
                }
                ?>
                <p id="validMessageNoInstructor" class="validateMessage"></p>
            </p>
            <p>
                <label>Observação:</label>
                <textarea class="textArea" id="observation" name="observation" placeHolder="Observação"><?php echo $observation;?></textarea>
                <p id="validMessageObservation" class="validateMessage"></p>
            </p>
        </fieldset>
        
        <?php
        if (!empty($clientID)) {
        ?>
            <input class="registerButton" type="button" id="registerButton" value="Atualizar cliente">
        <?php
        } else {
        ?>
            <input class="registerButton" type="button" id="registerButton" value="Cadastrar cliente">
        <?php
        }
        ?>

        <input class="cancelButton" type="button" id="cancelButton" value="Cancelar">
    </form>
<!-- end div form -->
</div>

<?php

include_once 'templates/admin_footer.php';

?>