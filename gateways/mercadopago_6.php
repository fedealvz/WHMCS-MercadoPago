<?php
if (!defined("WHMCS")) {
    exit("This file cannot be accessed directly");
}
require_once(ROOTDIR . "/modules/gateways/MercadoPago_Lib/mercadopago_config.php");
function MercadoPago_6_config()
{
    $modulo = "mercadopago_6";
    $nombre = "MercadoPago 6";
    $obj = new MercadopagoConfig($nombre,$modulo);
    $salida = $obj->getConfigModulo();
    return $salida;
}
function MercadoPago_6_link($params)
{
    $obj = new MercadopagoConfig();
    $salida = $obj->getLinkPago($params);
    return $salida;
}
?>