<?php

function formatDate($inputDate) {
    $timestamp = strtotime($inputDate);
    return date('d-m-Y', $timestamp);
}

function reducirTexto($texto, $longitudMaxima) {
    $texto = strip_tags($texto);
    if (strlen($texto) > $longitudMaxima) {
        $textoReducido = substr($texto, 0, $longitudMaxima) . "[...]";
    } else {
        $textoReducido = $texto;
    }

    return $textoReducido;
}


?>