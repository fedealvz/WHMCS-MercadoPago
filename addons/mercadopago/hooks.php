<?php
include ROOTDIR . DIRECTORY_SEPARATOR . "modules/gateways/MercadoPago_Lib/mercadopago_config.php";
add_hook("AfterCronJob", 1, function ($vars) {
    $obj = new MercadopagoConfig();
    $obj->callbackMercadopago();
});
?>