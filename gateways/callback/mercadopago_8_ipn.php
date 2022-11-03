<?php
include "../../../init.php";
include ROOTDIR . DIRECTORY_SEPARATOR . "includes/functions.php";
include ROOTDIR . DIRECTORY_SEPARATOR . "includes/gatewayfunctions.php";
include ROOTDIR . DIRECTORY_SEPARATOR . "includes/invoicefunctions.php";
require_once "../MercadoPago_Lib/mercadopago_config.php";
$gatewayModule = "mercadopago_8";
$gateway = new WHMCS\Module\Gateway();
if (!$gateway->isActiveGateway($gatewayModule) || !$gateway->load($gatewayModule)) {
    WHMCS\Terminus::getInstance()->doDie("Module not Active");
}
$GATEWAY = $gateway->getParams();
$obj = new MercadopagoConfig("Mercadopago 8", $gatewayModule);
$obj->crearTablaCustomTransacciones();
$respuesta = $obj->mercadopagoIPN($GATEWAY);

header("HTTP/1.1 " . $respuesta);
exit("Callback completo: " . var_export($respuesta, 1));
?>