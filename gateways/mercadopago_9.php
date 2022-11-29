<?php
if (!defined("WHMCS")) {
    exit("This file cannot be accessed directly");
}
require_once(__DIR__ . "/MercadoPago_Lib/mercadopago_config.php");
function MercadoPago_9_config()
{
    $modulo = "mercadopago_9";
    $nombre = "MercadoPago 9";
    $obj = new MercadopagoConfig($nombre,$modulo);
    $salida = $obj->getConfigModulo();
    return $salida;
}
function MercadoPago_9_link($params)
{
    $obj = new MercadopagoConfig();
    $salida = $obj->getLinkPago($params);
    return $salida;
}
?>