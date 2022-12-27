<?php
include "../../../init.php";
include ROOTDIR . "/includes/functions.php";
include ROOTDIR . "/includes/gatewayfunctions.php";
include ROOTDIR . "/includes/invoicefunctions.php";
require_once(ROOTDIR . "/modules/gateways/MercadoPago_Lib/mercadopago_config.php");
$gatewayModule = "mercadopago_1";
$gateway = new WHMCS\Module\Gateway();
if (!$gateway->isActiveGateway($gatewayModule) || !$gateway->load($gatewayModule)) {
    WHMCS\Terminus::getInstance()->doDie("Module not Active");
}
$GATEWAY = $gateway->getParams();
$obj = new MercadopagoConfig("Mercadopago 1",$gatewayModule);
$obj->crearTablaCustomTransacciones();
$respuesta = $obj->mercadopagoIPN($GATEWAY);

header("HTTP/1.1 " . $respuesta);
exit("Callback completo: " . var_export($respuesta,1));
?>