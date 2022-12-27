<?php
if (!defined("WHMCS")) {
    exit("This file cannot be accessed directly");
}
require_once(ROOTDIR . "/modules/gateways/MercadoPago_Lib/mercadopago_config.php");
function mercadopago_config()
{
    $obj = new MercadopagoConfig();
    $idioma = $obj->checkIdioma();
    return array("name" => "MercadoPago", "description" => traduccion($idioma, "mercadopago_config_1"), "author" => "MercadoPago", "language" => "spanish", "version" => "17-remake", "fields" => array("licencia" => array("FriendlyName" => traduccion($idioma, "mercadopago_config_2"), "Type" => "text", "Size" => "25", "Description" => ""), "verificador" => array("FriendlyName" => traduccion($idioma, "mercadopago_config_3"), "Type" => "textarea", "Rows" => "6", "Cols" => "60", "Description" => traduccion($idioma, "mercadopago_config_4")), "idioma" => array("FriendlyName" => traduccion($idioma, "mercadopago_config_5"), "Type" => "dropdown", "Options" => array("ar" => "Español", "br" => "Português", "us" => "English"), "Default" => "ar", "Description" => traduccion($idioma, "mercadopago_config_6"))));
}
function mercadopago_activate()
{
    $obj = new MercadopagoConfig();
    $idioma = $obj->checkIdioma();
    try {
        $obj->crearTablaCustomTransacciones();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return array("status" => "success", "description" => traduccion($idioma, "mercadopago_activate_1"));
}
function mercadopago_deactivate()
{    
    $obj = new MercadopagoConfig();
    $idioma = $obj->checkIdioma();
    $obj->eliminarTablaCustomTransacciones();
    return array("status" => "success", "description" => traduccion($idioma, "mercadopago_deactivate_1"));
}
function mercadopago_output($vars)
{
    echo "<div><a href='https://github.com/fedealvz/WHMCS-MercadoPago'>https://github.com/fedealvz/WHMCS-MercadoPago</a></div><br><br>";
    echo "<pre>" . print_r($vars, true) . "</pre>";
}
?>