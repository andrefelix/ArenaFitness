<?php

function mask($str, $mask) {
    $str = str_replace(' ', '', $str);

    for ($i = 0; $i < strlen($str); $i++)
        $mask[strpos($mask, '#')] = $str[$i];

    return $mask;
}

?>