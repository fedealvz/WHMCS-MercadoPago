<?php
if (!defined("WHMCS")) {
    exit("This file cannot be accessed directly");
}
require_once(ROOTDIR . "/modules/gateways/MercadoPago_Lib/mercadopago_config.php");
function MercadoPago_8_config()
{
    $modulo = "mercadopago_8";
    $nombre = "MercadoPago 8";
    $obj = new MercadopagoConfig($nombre,$modulo);
    $salida = $obj->getConfigModulo();
    return $salida;
}
function MercadoPago_8_link($params)
{
    $obj = new MercadopagoConfig();
    $salida = $obj->getLinkPago($params);
    return $salida;
}
?>