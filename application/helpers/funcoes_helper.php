<?php
defined('BASEPATH') OR exit('No direct script access allowed');

####################################  CONVERTE DATA PARA FORMATO DO BANCO DE DADOS ###########################################
function data_br($data_bd) {
    return implode('/', array_reverse(explode('-', $data_bd)));
}

####################################  CONVERTE DATA PARA FORMATO BRASILEIRO ###########################################
function data_bd($data_br) {
    return implode('-', array_reverse(explode('/', $data_br)));
}

####################################  PRINTA O ARRAY ORGANIZADO ########### ###########################################
function mydump($valor, $exit = null) {
    echo "<pre>";
    print_r($valor);
    echo "</pre>";
    if(!$exit)
     exit();
}

########################################## SOMA DATA  #####################################################
function somadata($dias, $datahoje) {
    $datahoje = strtr($datahoje, "/", "-");
    $nova_data = date('d/m/Y', strtotime("+$dias days", strtotime($datahoje)));
    return $nova_data;
}

/**
 * Retorna o dia da semana para a data informada
 * @param $data (DEVE estar no padrão Y-m-d)
 * @param $return_type {
 *      Se 0 retorna dia como número, ex: 0 = Sunday, 1 = Monday...
 *      Se 1 retorna dia como string, ex: Sunday, Monday...
 *      Se 2 retorna dia como string abreviado, ex: Sun, Mon...
 * }
 * @return jddayofweek
 */
function day_of_w($data, $return_type) {
    list ($ano, $mes, $dia) = preg_split('[-]', $data);
    $jd_dia = cal_to_jd(CAL_GREGORIAN, $mes, $dia, $ano);
    switch (jddayofweek($jd_dia, $return_type)) {
        case 'Sunday': return 'Domingo';
            break;
        case 'Monday': return 'Segunda';
            break;
        case 'Tuesday': return 'Terça';
            break;
        case 'Wednesday': return 'Quarta';
            break;
        case 'Thursday': return 'Quinta';
            break;
        case 'Friday': return 'Sexta';
            break;
        case 'Saturday': return 'Sábado';
            break;
        default: return 'Dia Inválido';
            break;
    }
}

// Tira do array todos os as key que estão nulas ou sem valor
function fix_data_array($data){
    foreach (array_keys($data) as $k) {
        if($data[$k] == "" || $data[$k] == null)
            unset($data[$k]);
    }
    return $data;
}




