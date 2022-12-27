<?php
if (!defined("WHMCS")) {
    exit("This file cannot be accessed directly");
}
require_once(ROOTDIR . "/modules/gateways/MercadoPago_Lib/mercadopago_config.php");
function MercadoPago_1_config()
{    
    $modulo = "mercadopago_1";
    $nombre = "MercadoPago 1";
    $obj = new MercadopagoConfig($nombre,$modulo);
    $salida = $obj->getConfigModulo();
    return $salida;
}
function MercadoPago_1_link($params)
{
    $obj = new MercadopagoConfig();
    $salida = $obj->getLinkPago($params);
    return $salida;
}
?>