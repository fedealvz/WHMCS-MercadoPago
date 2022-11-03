<?php
require_once(__DIR__ . "/MercadoPago_Lib/mercadopago_config.php");
if (!defined("WHMCS")) {
    exit("This file cannot be accessed directly");
}

function MercadoPago_3_config()
{
    $modulo = "mercadopago_3";
    $nombre = "MercadoPago 3";
    $obj = new MercadopagoConfig($nombre, $modulo);
    $salida = $obj->getConfigModulo();
    return $salida;
}
function MercadoPago_3_link($params)
{
    $obj = new MercadopagoConfig();
    $salida = $obj->getLinkPago($params);
    return $salida;
}
?>