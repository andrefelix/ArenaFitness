<?php

function errorManager($file=NULL, $function=NULL, $numError=NULL, $msgError=NULL) {
    if ($file == NULL)
        $file = "Arquivo não identificado";
    if ($function == NULL)
        $function = "Função não identificada";
    if ($numError == NULL)
        $numError = "Código do erro não identificado";
    if ($msgError == NULL)
        $msgError = "Mensagem de erro não identificada";

    $result = "<strong>Houve um erro no sistema</strong><br />
               <strong>Arquivo:</strong>$file<br />
               <strong>Rotina:</strong>$function<br />
               <strong>Numero do erro:</strong>$numError<br />
               <strong>Mensagem do erro:</strong>$msgError<br />";
               
    return $result;
}

?>