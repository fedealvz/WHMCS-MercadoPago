<?php
use Illuminate\Database\Capsule\Manager as Capsule;
require_once(__DIR__ . "/idioma.php");
class MercadopagoConfig
{ 
    public $nombreModulo;
    public $modulo;
    public function __construct($nombreModulo = "mercadopago",$modulo = "mercadopago")
    {
        $this->nombreModulo = $nombreModulo;
        $this->modulo = $modulo;
    }
    function crearTablaCustomTransacciones()
    {
        $nombreTabla = "bapp_mercadopago";
        if (!WHMCS\Database\Capsule::schema()->hasTable($nombreTabla)) {
            try {
                WHMCS\Database\Capsule::schema()->create($nombreTabla, function ($table) {
                    $table->increments("id");
                    $table->string("transaccion")->unique();
                    $table->dateTime("momento");
                    $table->string("gateway");
                });
                return true;
            } catch(\Exception $ex) {
                throw new Exception("No se pudo crear la tabla de transacciones: " . $ex->getMessage());
            }
        }
        return false;
    }
    function eliminarTablaCustomTransacciones()
    {
        $nombreTabla = "bapp_mercadopago";
        if (WHMCS\Database\Capsule::schema()->hasTable($nombreTabla)) {
            try {
                WHMCS\Database\Capsule::schema()->dropIfExists($nombreTabla);
                return true;
            } catch(\Exception $ex) {
                throw new Exception("No se pudo eliminar la tabla de transacciones: " . $ex->getMessage());
            }
        }
        return false;
    }
    function checkIdioma()
    {
        $resultado = Capsule::table("tbladdonmodules")->where("module", "=", "mercadopago")->where("setting", "=", "idioma")->get();
        $resultado = $resultado[0]->value;
        if (empty($resultado)) {
            $resultado = "ar";
        }
        return $resultado;
    }    
    function getMPLogo()
    {
        return "\r\n    <img src='data:image/png;base64,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'>\r\n    ";
    }      
    function getPreferenciaPago($accesstoken, $datos_mp, $prueba = false)
    {
        $userid = substr(strrchr($accesstoken, "-"), 1);
        $uri = "https://api.mercadopago.com/checkout/preferences/";
        $data = array("additional_info" => "", "auto_return" => $datos_mp["retorno"], "back_urls" => array("failure" => $datos_mp["url_fallo"], "pending" => $datos_mp["url_pendiente"], "success" => $datos_mp["url_exito"]), "binary_mode" => true, "merchant_account_id" => $datos_mp["merchant_account_id"], "processing_modes" => array($datos_mp["processing"]), "processing_mode" => $datos_mp["processing"], "external_reference" => $datos_mp["referencia"], "items" => array(array("id" => "", "currency_id" => $datos_mp["item_moneda"], "title" => $datos_mp["item_titulo"], "picture_url" => $datos_mp["item_imagen"], "description" => $datos_mp["item_descripcion"], "category_id" => "services", "quantity" => 1, "unit_price" => $datos_mp["item_precio"])), "notification_url" => $datos_mp["notification_url"], "payer" => array("phone" => array("area_code" => $datos_mp["comprador_telefono_codigodearea"], "number" => $datos_mp["comprador_telefono_numero"]), "address" => array("zip_code" => $datos_mp["comprador_domicilio_codigopostal"], "street_name" => $datos_mp["comprador_domicilio_calle"], "street_number" => $datos_mp["comprador_domicilio_numero"]), "identification" => array("number" => $datos_mp["comprador_documento_numero"], "type" => $datos_mp["comprador_documento_tipo"]), "email" => $datos_mp["comprador_email"], "name" => $datos_mp["comprador_nombre"], "surname" => $datos_mp["comprador_apellido"]), "payment_methods" => array("excluded_payment_types" => $datos_mp["exclusiones"]));
        $url = "https://api.mercadopago.com/checkout/preferences/?access_token=" . $accesstoken;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Length: " . strlen(json_encode($data))));
        $result = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result, true);
        return $response;
    }
    function getConfigModulo()
    {
        $modulo = $this->modulo;
        $nombre = $this->nombreModulo;
        $idioma = $this->checkIdioma();
        $configHeader = array("bh_xxx" => array("FriendlyName" => traduccion($idioma, "mpconfig_2"), "Description" => "<br><br><b><a href='https://github.com/fedealvz/WHMCS-MercadoPago' target='_blank'>https://github.com/fedealvz/WHMCS-MercadoPago</a></b><br><br><br>"), "FriendlyName" => array("Type" => "System", "Value" => $nombre), "bh_Access_Token" => array("FriendlyName" => "<b>Access Token</b>:", "Type" => "text", "Size" => "150", "Description" => "&nbsp;<a href='#' onclick='\$(\"#Client_id\").modal(\"show\");' class='btn btn-warning btn-xs'>" . traduccion($idioma, "mpconfig_4") . "</a><br>\r\n            " . traduccion($idioma, "mpconfig_5") . ":\r\n            <br><a href='https://www.mercadopago.com/mla/account/credentials' target='_blank' class='btn btn-info btn-xs'>Argentina</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mlb/account/credentials' target='_blank' class='btn btn-info btn-xs'>Brasil</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mlc/account/credentials' target='_blank' class='btn btn-info btn-xs'>Chile</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mco/account/credentials' target='_blank' class='btn btn-info btn-xs'>Colombia</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mlm/account/credentials' target='_blank' class='btn btn-info btn-xs'>México</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mpe/account/credentials' target='_blank' class='btn btn-info btn-xs'>Perú</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mlu/account/credentials' target='_blank' class='btn btn-info btn-xs'>Uruguay</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mlv/account/credentials' target='_blank' class='btn btn-info btn-xs'>Venezuela</a>\r\n\r\n\r\n\r\n            <div class='modal fade' id='Client_id' tabindex='-1' role='dialog' aria-labelledby='DeactivateGatewayLabel' aria-hidden='true'>\r\n                <div class='modal-dialog'>\r\n                    <div class='modal-content panel panel-primary'>\r\n                        <div id='modalDeactivateGatewayHeading' class='modal-header panel-heading'>\r\n                            <button type='button' class='close' data-dismiss='modal'> <span aria-hidden='true'>&times;</span> <span class='sr-only'>" . traduccion($idioma, "mpconfig_6") . "</span> </button>\r\n                            <h4 class='modal-title' id='DeactivateGatewayLabel'>" . traduccion($idioma, "mpconfig_4") . ": Access Token</h4>\r\n                        </div>\r\n                        <div id='modalDeactivateGatewayBody' class='modal-body panel-body'>\r\n                            <p>" . traduccion($idioma, "mpconfig_7") . "\r\n                            <br><span style='color:red'>" . traduccion($idioma, "mpconfig_8") . "</span></p>\r\n                        </div>\r\n                        <div id='modalDeactivateGatewayFooter' class='modal-footer panel-footer'>\r\n                            <button type='button' id='DeactivateGateway-Cancelar' class='btn btn-default' data-dismiss='modal'> " . traduccion($idioma, "mpconfig_6") . " </button>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\t\r\n            "), "merchant_account_id" => array("FriendlyName" => "Merchant Account ID:", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_67")), "processing" => array("FriendlyName" => "Processing Mode:", "Type" => "dropdown", "Options" => array("aggregator" => "Aggregator (Default)", "gateway" => "Gateway"), "Description" => traduccion($idioma, "mpconfig_68")), "useradmin" => array("FriendlyName" => "UserName:", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_72")), "bh_success" => array("FriendlyName" => traduccion($idioma, "mpconfig_9") . ":", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_12")), "bh_pending" => array("FriendlyName" => traduccion($idioma, "mpconfig_10") . ":", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_12")), "bh_failure" => array("FriendlyName" => traduccion($idioma, "mpconfig_11") . ":", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_12")), "bh_titulo" => array("FriendlyName" => "<span style='color:red'>" . traduccion($idioma, "mpconfig_13") . "</span>:", "Type" => "text", "Size" => "50", "Value" => "Factura", "Description" => " " . traduccion($idioma, "mpconfig_14")), "bh_texto" => array("FriendlyName" => "<span style='color:red'>" . traduccion($idioma, "mpconfig_15") . "</span>:", "Type" => "text", "Value" => traduccion($idioma, "mpconfig_16")), "color" => array("FriendlyName" => traduccion($idioma, "mpconfig_17") . ":", "Type" => "dropdown", "Options" => array("primary" => traduccion($idioma, "mpconfig_18"), "secondary" => traduccion($idioma, "mpconfig_19"), "success" => traduccion($idioma, "mpconfig_20"), "danger" => traduccion($idioma, "mpconfig_21"), "warning" => traduccion($idioma, "mpconfig_22"), "info" => traduccion($idioma, "mpconfig_23"), "light" => traduccion($idioma, "mpconfig_24"), "dark" => traduccion($idioma, "mpconfig_25"), "link" => traduccion($idioma, "mpconfig_26")), "Description" => traduccion($idioma, "mpconfig_27")), "bh_nota" => array("FriendlyName" => traduccion($idioma, "mpconfig_28") . ":", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_29")), "bh_credit_card" => array("FriendlyName" => traduccion($idioma, "mpconfig_30") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_31")), "bh_ticket" => array("FriendlyName" => traduccion($idioma, "mpconfig_32") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_33")), "bh_atm" => array("FriendlyName" => traduccion($idioma, "mpconfig_34") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_35")), "bh_debito" => array("FriendlyName" => traduccion($idioma, "mpconfig_36") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_37")), "bh_prepaga" => array("FriendlyName" => traduccion($idioma, "mpconfig_38") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_39")), "bh_banco" => array("FriendlyName" => traduccion($idioma, "mpconfig_40") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_41")), "bh_comportamiento" => array("FriendlyName" => traduccion($idioma, "mpconfig_42") . ":", "Type" => "dropdown", "Options" => array("normal" => traduccion($idioma, "mpconfig_43"), "noverifica" => traduccion($idioma, "mpconfig_44"), "truncado" => traduccion($idioma, "mpconfig_45"), "redondeado" => traduccion($idioma, "mpconfig_46")), "Description" => traduccion($idioma, "mpconfig_47") . "<br>\r\n            <b>" . traduccion($idioma, "mpconfig_43") . "</b>: " . traduccion($idioma, "mpconfig_48") . "\r\n            <br><b>" . traduccion($idioma, "mpconfig_44") . "</b>: " . traduccion($idioma, "mpconfig_49") . "\r\n            <br><b>" . traduccion($idioma, "mpconfig_45") . "</b>: " . traduccion($idioma, "mpconfig_50") . "\r\n            <br><b>" . traduccion($idioma, "mpconfig_46") . "</b>: " . traduccion($idioma, "mpconfig_51")), "bh_error_mp" => array("FriendlyName" => traduccion($idioma, "mpconfig_52") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_53")), "prueba" => array("FriendlyName" => traduccion($idioma, "mpconfig_54") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_55")), "email" => array("FriendlyName" => traduccion($idioma, "mpconfig_70") . ":", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_71")), "bh_modocolaprocesamiento" => array("FriendlyName" => traduccion($idioma, "mpconfig_77") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_78")));
        return $configHeader;
    }
    
    function getLinkPago($params)
    {
        $companyname = $params["companyname"];
        $systemurl = $params["systemurl"];
        $bh_texto = $params["bh_texto"];
        $bh_nota = $params["bh_nota"];
        $color = $params["color"];
        $nota = "";
        if (!empty($bh_nota)) {
            $nota = "<p><div class='small-text'>" . $bh_nota . "</div></p>";
        }
        $bh_credit_card = $params["bh_credit_card"];
        $bh_ticket = $params["bh_ticket"];
        $bh_atm = $params["bh_atm"];
        $bh_debito = $params["bh_debito"];
        $bh_prepaga = $params["bh_prepaga"];
        $bh_banco = $params["bh_banco"];
        if ($bh_credit_card == "on") {
            $mediosno[] = array("id" => "credit_card");
        }
        if ($bh_ticket == "on") {
            $mediosno[] = array("id" => "ticket");
        }
        if ($bh_banco == "on") {
            $mediosno[] = array("id" => "bank_transfer");
        }
        if ($bh_atm == "on") {
            $mediosno[] = array("id" => "atm");
        }
        if ($bh_debito == "on") {
            $mediosno[] = array("id" => "debit_card");
        }
        if ($bh_prepaga == "on") {
            $mediosno[] = array("id" => "prepaid_card");
        }
        $datos_mp["exclusiones"] = $mediosno;
        if ($params["prueba"] == "on") {
            $mododeprueba = true;
        } else {
            $mododeprueba = false;
        }
        switch ($params["bh_comportamiento"]) {
            case "truncado":
                $importe = (int) $params["amount"];
                break;
            case "redondeado":
                $entero = (int) $params["amount"];
                $fraccion = 0 + $params["amount"] - (int) $params["amount"];
                if (0.49 <= $fraccion) {
                    $entero = $entero + 1;
                }
                $importe = $entero;
                break;
            default:
                $importe = floatval($params["amount"]);
                break;
        }
        $datos_mp["item_precio"] = $importe;
        $accesstoken = $params["bh_Access_Token"];
        $datos_mp["retorno"] = "all";
        $bh_success = $params["bh_success"];
        $bh_pending = $params["bh_pending"];
        $bh_failure = $params["bh_failure"];
        $bh_error_mp = $params["bh_error_mp"];
        if (empty($bh_success)) {
            $bh_success = $systemurl . "viewinvoice.php?id=" . $params["invoiceid"];
        }
        if (empty($bh_pending)) {
            $bh_pending = $systemurl . "viewinvoice.php?id=" . $params["invoiceid"];
        }
        if (empty($bh_failure)) {
            $bh_failure = $systemurl . "viewinvoice.php?id=" . $params["invoiceid"];
        }
        $datos_mp["merchant_account_id"] = $params["merchant_account_id"];
        $datos_mp["processing"] = $params["processing"];
        $datos_mp["url_exito"] = $bh_success;
        $datos_mp["url_fallo"] = $bh_pending;
        $datos_mp["url_pendiente"] = $bh_failure;
        $datos_mp["notification_url"] = $systemurl . "modules/gateways/callback/" . $params["paymentmethod"] . "_ipn.php?source_news=webhooks";
        $datos_mp["referencia"] = $params["invoiceid"];
        $datos_mp["item_titulo"] = $companyname . " - " . $params["bh_titulo"] . " Nro. " . $params["invoiceid"];
        $datos_mp["item_imagen"] = "";
        $datos_mp["item_descripcion"] = $params["description"];
        $datos_mp["item_moneda"] = $params["currency"];
        $datos_mp["comprador_nombre"] = $params["clientdetails"]["firstname"];
        $datos_mp["comprador_apellido"] = $params["clientdetails"]["lastname"];
        $datos_mp["comprador_email"] = $params["clientdetails"]["email"];
        if (empty($accesstoken)) {
            $code = "Datos inválidos de Mercadopago";
        } else {
            $respuesta = $this->getPreferenciaPago($accesstoken, $datos_mp, $mododeprueba);
            if ($params["bh_error_mp"] == "on") {
                $code = "Respuesta Mercadopago<br><br><pre>" . print_r($respuesta, true) . "</pre>";
            } else {
                if ($mododeprueba) {
                    $enlace = $respuesta["sandbox_init_point"];
                } else {
                    $enlace = $respuesta["init_point"];
                }
                $logo = $this->getMPLogo();
                $code = "<script src='https://www.mercadopago.com/v2/security.js' view='item'></script>" . $logo . "<br><a href='" . $enlace . "' class='btn btn-" . $color . "'>" . $bh_texto . "</a>" . $nota;
            }
        }
        return $code;
    }
    function mercadopagoIPN($gatewayOBJ)
    {
        $gatewayModule = $this->modulo;
        $informe = json_decode(file_get_contents("php://input"), true);
        $informe_cobro = $informe["data"]["id"];
        $informe_action = $informe["action"];
        $informe_id = $informe["id"];
        $informe_type = $informe["type"];
        $email = $gatewayOBJ["email"];
        $modoProcesamientoPorColas = $gatewayOBJ["bh_modocolaprocesamiento"] == "on";
        $admin = $gatewayOBJ["useradmin"];
        if (!empty($admin)) {
            $adminUsername = $gatewayOBJ["useradmin"];
        }
        if (!empty($email)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $verificamail = true;
            } else {
                $verificamail = false;
            }
        }
        if ($verificamail) {
            mail($email, $informe_id . " - Start", print_r($informe, true));
        }
        $command = "GetTransactions";
        $postData = array("transid" => $informe_cobro);
        $arr_transacciones = localAPI($command, $postData, $adminUsername);
        if ($arr_transacciones["totalresults"] == 0) {
            Capsule::table("bapp_mercadopago")->insert(array("transaccion" => $informe_cobro, "momento" => date("Y-m-d H:i:s"), "gateway" => $gatewayModule));
        }
        if (!$modoProcesamientoPorColas)
        {
            $this->callbackMercadopago($informe_cobro);
        }        
        $retorno = "200";
        return $retorno;
    }
    function getPaymentMercadopago($transaccion,$accessToken)
    {        
        $url = "https://api.mercadopago.com/v1/payments/" . $transaccion;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $accessToken));
        $result = curl_exec($ch);
        curl_close($ch);
        $respuestaParseada = json_decode($result, true);
        return $respuestaParseada;
    }
    function callbackMercadopago($idtrans = "")
    {
        if (!empty($idtrans)) {
            $resultado = Capsule::table("bapp_mercadopago")->where("transaccion", "=", $idtrans)->get();
            $mp_id = $resultado[0]->id;
            $mp_transaccion = $resultado[0]->transaccion;
            $mp_momento = $resultado[0]->momento;
            $mp_gateway = $resultado[0]->gateway;
        } else {
            $resultado = Capsule::table("bapp_mercadopago")->first();
            $mp_id = $resultado->id;
            $mp_transaccion = $resultado->transaccion;
            $mp_momento = $resultado->momento;
            $mp_gateway = $resultado->gateway;
        }
        if (!empty($mp_id)) {
            $log = "ID: " . $mp_id . "<br>Tran: " . $mp_transaccion . "<br>Time: " . $mp_momento . "<br>Gat: " . $mp_gateway;
            $GATEWAY = getGatewayVariables($mp_gateway);
            $admin = $GATEWAY["useradmin"];
            if (!empty($admin)) {
                $adminUsername = $GATEWAY["useradmin"];
            }
            $command = "GetTransactions";
            $postData = array("transid" => $mp_transaccion);
            $arr_transacciones = localAPI($command, $postData, $adminUsername);
            if ($arr_transacciones["totalresults"] == 0) {
                $email = $GATEWAY["email"];
                if (!empty($email)) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $verificamail = true;
                    } else {
                        $verificamail = false;
                    }
                }
                if ($verificamail) {
                    mail($email, "IPN Trans: " . $mp_transaccion, $log);
                }
                $datosdelpago = $this->getPaymentMercadopago($mp_transaccion,$GATEWAY["bh_Access_Token"]);
                if ($verificamail) {
                    mail($email, "Search Trans. " . $mp_transaccion, print_r($datosdelpago, true));
                }
                $status = $datosdelpago["status"];
                $idioma = $this->checkIdioma();
                if ($status == "approved") {
                    $nrofactura = $datosdelpago["external_reference"];
                    if (!empty($nrofactura)) {
                        $valorAbonado = $datosdelpago["transaction_amount"];
                        $moneda_de_cobro = $datosdelpago["currency_id"];
                        $comision = $valorAbonado - $datosdelpago["transaction_details"]["net_received_amount"];
                        $command = "GetInvoice";
                        $postData = array("invoiceid" => $nrofactura);
                        $arr_datos_factura = localAPI($command, $postData, $adminUsername);
                        $datos_factura = print_r($arr_datos_factura, true);
                        $usuario_id = $arr_datos_factura["userid"];
                        $balance = $arr_datos_factura["balance"];
                        if ($GATEWAY["bh_comportamiento"] != "normal") {
                            $importe_pagado = $balance;
                        } else {
                            $importe_pagado = $datosdelpago["transaction_amount"];
                            $command = "GetClientsDetails";
                            $postData = array("clientid" => $usuario_id);
                            $arr_datos_cliente = localAPI($command, $postData, $adminUsername);
                            $moneda_code_usuario = $arr_datos_cliente["currency_code"];
                            if ($moneda_de_cobro != $moneda_code_usuario) {
                                $command = "GetCurrencies";
                                $postData = array();
                                $arr_listademonedas = localAPI($command, $postData, $adminUsername);
                                $monedero = $arr_listademonedas["currencies"]["currency"];
                                foreach ($monedero as $datosmoneda) {
                                    $moneda_code = $datosmoneda["code"];
                                    $monedasporcode[$moneda_code] = $datosmoneda["rate"];
                                }
                                $tasadeconversion = $monedasporcode[$moneda_code_usuario];
                                $ximporte_pagado = round($importe_pagado * $tasadeconversion, 2);
                                $xcomision = round($comision * $tasadeconversion, 2);
                                $importe_pagado = $ximporte_pagado;
                                $comision = $xcomision;
                                $conversionlog = traduccion($idioma, "mpconfig_73") . ": " . $moneda_code_usuario . "\r\n                            " . traduccion($idioma, "mpconfig_74") . ": " . $importe_pagado . "\r\n                            " . traduccion($idioma, "mpconfig_75") . ": " . $comision;
                            }
                        }
                        $command = "AddInvoicePayment";
                        $postData = array("gateway" => $GATEWAY["paymentmethod"], "invoiceid" => $nrofactura, "transid" => $mp_transaccion, "amount" => $importe_pagado, "fees" => $comision);
                        $results = localAPI($command, $postData, $adminUsername);
                        $texto_log = "\r\n                    " . traduccion($idioma, "mpconfig_56") . ": " . $nrofactura . "\r\n                    " . traduccion($idioma, "mpconfig_57") . ": " . $GATEWAY["name"] . "\r\n                    " . traduccion($idioma, "mpconfig_58") . ": " . $mp_transaccion . "\r\n                    " . traduccion($idioma, "mpconfig_60") . ": " . $datosdelpago["authorization_code"] . "\r\n                    " . traduccion($idioma, "mpconfig_61") . ": " . $datosdelpago["date_approved"] . "\r\n                    " . traduccion($idioma, "mpconfig_62") . ": " . $datosdelpago["payment_type_id"] . " - " . $datosdelpago["payment_method_id"] . "\r\n                    " . traduccion($idioma, "mpconfig_63") . ": " . $datosdelpago["currency_id"] . "\r\n                    " . traduccion($idioma, "mpconfig_64") . ": " . $datosdelpago["transaction_amount"] . "\r\n                    " . traduccion($idioma, "mpconfig_65") . ": " . $datosdelpago["transaction_details"]["net_received_amount"] . "\r\n                    " . $conversionlog;
                        logTransaction($GATEWAY["name"], $texto_log, traduccion($idioma, "mpconfig_66") . " [" . $nrofactura . "]");
                        //DETALLE DE LA API DE MP
                        logTransaction($GATEWAY["name"], "API Payment MP: " .  var_export($datosdelpago, true), "Detalle del pago aprobado.");
                        $resultado = Capsule::table("tbltransaction_history")->where("transaction_id", "=", $mp_transaccion)->delete();
                    }
                    $resultado = Capsule::table("bapp_mercadopago")->where("id", "=", $mp_id)->delete();
                } else {
                    if ($status == "pending") {
                        $command = "UpdateInvoice";
                        $postData = array("invoiceid" => $datosdelpago["external_reference"], "notes" => date("Y-m-d H:i:s") . ": " . traduccion($idioma, "mpconfig_76") . "\r\n                        [" . ucwords($datosdelpago["payment_type_id"]) . " - " . ucwords($datosdelpago["payment_method_id"]) . "]");
                        $results = localAPI($command, $postData, $adminUsername);
                        $texto_log = "\r\n                    " . traduccion($idioma, "mpconfig_56") . ": " . $datosdelpago["external_reference"] . "\r\n                    " . traduccion($idioma, "mpconfig_57") . ": " . $GATEWAY["name"] . "\r\n                    " . traduccion($idioma, "mpconfig_58") . ": " . $mp_transaccion . "\r\n                    " . traduccion($idioma, "mpconfig_62") . ": " . $datosdelpago["payment_type_id"] . " - " . $datosdelpago["payment_method_id"];
                        logTransaction($GATEWAY["name"], $texto_log, traduccion($idioma, "mpconfig_76") . " [" . $datosdelpago["external_reference"] . "]");
                        //DETALLE DE LA API DE MP
                        logTransaction($GATEWAY["name"], "API Payment MP: " .  var_export($datosdelpago, true), "Detalle del pago aprobado.");
                        Capsule::table("tbltransaction_history")->insert(array("invoice_id" => $datosdelpago["external_reference"], "gateway" => $GATEWAY["name"], "updated_at" => date("Y-m-d H:i:s"), "transaction_id" => $mp_transaccion, "remote_status" => traduccion($idioma, "mpconfig_76"), "description" => $datosdelpago["payment_type_id"] . " - " . $datosdelpago["payment_method_id"]));
                    }
                    $resultado = Capsule::table("bapp_mercadopago")->where("id", "=", $mp_id)->delete();
                }
            }
            else
            {
                //BORRAR PORQUE YA FUE INGRESADA LA TRANSACCION
                $resultado = Capsule::table("bapp_mercadopago")->where("id", "=", $mp_id)->delete();
            }
        }
        return true;
    }
    function procesarTodosRegistrosCallback($limiteRegistros = 10)
    {
        $resultado = Capsule::table("bapp_mercadopago")->limit($limiteRegistros)->get();
        foreach ($resultado as $registro) {
            $this->callbackMercadopago($registro->transaccion);
        }
    }
}
?>