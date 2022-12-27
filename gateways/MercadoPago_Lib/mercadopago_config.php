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
        return "\r\n    <img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoxNjJFNjgwQUJEMUYxMUVBOTgyRUY0MEYyNUVBREZGQiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoxNjJFNjgwQkJEMUYxMUVBOTgyRUY0MEYyNUVBREZGQiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjE2MkU2ODA4QkQxRjExRUE5ODJFRjQwRjI1RUFERkZCIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjE2MkU2ODA5QkQxRjExRUE5ODJFRjQwRjI1RUFERkZCIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+B2bg/QAAHupJREFUeNrtXQdYFFfX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'>\r\n    ";
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
        $configHeader = array("bh_xxx" => array("FriendlyName" => traduccion($idioma, "mpconfig_2"), "Description" => "<br><br><b><a href='https://github.com/fedealvz/WHMCS-MercadoPago' target='_blank'>https://github.com/fedealvz/WHMCS-MercadoPago</a></b><br><br><br>"), "FriendlyName" => array("Type" => "System", "Value" => $nombre), "bh_Access_Token" => array("FriendlyName" => "<b>Access Token</b>:", "Type" => "text", "Size" => "150", "Description" => "&nbsp;<a href='#' onclick='\$(\"#Client_id\").modal(\"show\");' class='btn btn-warning btn-xs'>" . traduccion($idioma, "mpconfig_4") . "</a><br>\r\n            " . traduccion($idioma, "mpconfig_5") . ":\r\n            <br><a href='https://www.mercadopago.com/mla/account/credentials' target='_blank' class='btn btn-info btn-xs'>Argentina</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mlb/account/credentials' target='_blank' class='btn btn-info btn-xs'>Brasil</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mlc/account/credentials' target='_blank' class='btn btn-info btn-xs'>Chile</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mco/account/credentials' target='_blank' class='btn btn-info btn-xs'>Colombia</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mlm/account/credentials' target='_blank' class='btn btn-info btn-xs'>México</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mpe/account/credentials' target='_blank' class='btn btn-info btn-xs'>Perú</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mlu/account/credentials' target='_blank' class='btn btn-info btn-xs'>Uruguay</a>\r\n            &nbsp;<a href='https://www.mercadopago.com/mlv/account/credentials' target='_blank' class='btn btn-info btn-xs'>Venezuela</a>\r\n\r\n\r\n\r\n            <div class='modal fade' id='Client_id' tabindex='-1' role='dialog' aria-labelledby='DeactivateGatewayLabel' aria-hidden='true'>\r\n                <div class='modal-dialog'>\r\n                    <div class='modal-content panel panel-primary'>\r\n                        <div id='modalDeactivateGatewayHeading' class='modal-header panel-heading'>\r\n                            <button type='button' class='close' data-dismiss='modal'> <span aria-hidden='true'>&times;</span> <span class='sr-only'>" . traduccion($idioma, "mpconfig_6") . "</span> </button>\r\n                            <h4 class='modal-title' id='DeactivateGatewayLabel'>" . traduccion($idioma, "mpconfig_4") . ": Access Token</h4>\r\n                        </div>\r\n                        <div id='modalDeactivateGatewayBody' class='modal-body panel-body'>\r\n                            <p>" . traduccion($idioma, "mpconfig_7") . "\r\n                            <br><span style='color:red'>" . traduccion($idioma, "mpconfig_8") . "</span></p>\r\n                        </div>\r\n                        <div id='modalDeactivateGatewayFooter' class='modal-footer panel-footer'>\r\n                            <button type='button' id='DeactivateGateway-Cancelar' class='btn btn-default' data-dismiss='modal'> " . traduccion($idioma, "mpconfig_6") . " </button>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\t\r\n            "), "merchant_account_id" => array("FriendlyName" => "Merchant Account ID:", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_67")), "processing" => array("FriendlyName" => "Processing Mode:", "Type" => "dropdown", "Options" => array("aggregator" => "Aggregator (Default)", "gateway" => "Gateway"), "Description" => traduccion($idioma, "mpconfig_68")), "useradmin" => array("FriendlyName" => "UserName:", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_72")), "bh_success" => array("FriendlyName" => traduccion($idioma, "mpconfig_9") . ":", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_12")), "bh_pending" => array("FriendlyName" => traduccion($idioma, "mpconfig_10") . ":", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_12")), "bh_failure" => array("FriendlyName" => traduccion($idioma, "mpconfig_11") . ":", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_12")), "bh_titulo" => array("FriendlyName" => "<span style='color:red'>" . traduccion($idioma, "mpconfig_13") . "</span>:", "Type" => "text", "Size" => "50", "Value" => "Factura", "Description" => " " . traduccion($idioma, "mpconfig_14")), "bh_texto" => array("FriendlyName" => "<span style='color:red'>" . traduccion($idioma, "mpconfig_15") . "</span>:", "Type" => "text", "Value" => traduccion($idioma, "mpconfig_16")), "color" => array("FriendlyName" => traduccion($idioma, "mpconfig_17") . ":", "Type" => "dropdown", "Options" => array("primary" => traduccion($idioma, "mpconfig_18"), "secondary" => traduccion($idioma, "mpconfig_19"), "success" => traduccion($idioma, "mpconfig_20"), "danger" => traduccion($idioma, "mpconfig_21"), "warning" => traduccion($idioma, "mpconfig_22"), "info" => traduccion($idioma, "mpconfig_23"), "light" => traduccion($idioma, "mpconfig_24"), "dark" => traduccion($idioma, "mpconfig_25"), "link" => traduccion($idioma, "mpconfig_26")), "Description" => traduccion($idioma, "mpconfig_27")), "bh_nota" => array("FriendlyName" => traduccion($idioma, "mpconfig_28") . ":", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_29")), "bh_credit_card" => array("FriendlyName" => traduccion($idioma, "mpconfig_30") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_31")), "bh_ticket" => array("FriendlyName" => traduccion($idioma, "mpconfig_32") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_33")), "bh_atm" => array("FriendlyName" => traduccion($idioma, "mpconfig_34") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_35")), "bh_debito" => array("FriendlyName" => traduccion($idioma, "mpconfig_36") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_37")), "bh_prepaga" => array("FriendlyName" => traduccion($idioma, "mpconfig_38") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_39")), "bh_banco" => array("FriendlyName" => traduccion($idioma, "mpconfig_40") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_41")), "bh_comportamiento" => array("FriendlyName" => traduccion($idioma, "mpconfig_42") . ":", "Type" => "dropdown", "Options" => array("normal" => traduccion($idioma, "mpconfig_43"), "noverifica" => traduccion($idioma, "mpconfig_44"), "truncado" => traduccion($idioma, "mpconfig_45"), "redondeado" => traduccion($idioma, "mpconfig_46")), "Description" => traduccion($idioma, "mpconfig_47") . "<br>\r\n            <b>" . traduccion($idioma, "mpconfig_43") . "</b>: " . traduccion($idioma, "mpconfig_48") . "\r\n            <br><b>" . traduccion($idioma, "mpconfig_44") . "</b>: " . traduccion($idioma, "mpconfig_49") . "\r\n            <br><b>" . traduccion($idioma, "mpconfig_45") . "</b>: " . traduccion($idioma, "mpconfig_50") . "\r\n            <br><b>" . traduccion($idioma, "mpconfig_46") . "</b>: " . traduccion($idioma, "mpconfig_51")), "bh_error_mp" => array("FriendlyName" => traduccion($idioma, "mpconfig_52") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_53")), "prueba" => array("FriendlyName" => traduccion($idioma, "mpconfig_54") . ":", "Type" => "yesno", "Description" => traduccion($idioma, "mpconfig_55")), "email" => array("FriendlyName" => traduccion($idioma, "mpconfig_70") . ":", "Type" => "text", "Size" => "100", "Description" => "<br>" . traduccion($idioma, "mpconfig_71")));
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
        $this->callbackMercadopago($informe_cobro);
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
                        $moneda_de_cobro = $datosdelpago["currency_id"];
                        $comision = $datosdelpago["transaction_details"]["total_paid_amount"] - $datosdelpago["transaction_details"]["net_received_amount"];
                        $command = "GetInvoice";
                        $postData = array("invoiceid" => $nrofactura);
                        $arr_datos_factura = localAPI($command, $postData, $adminUsername);
                        $datos_factura = print_r($arr_datos_factura, true);
                        $usuario_id = $arr_datos_factura["userid"];
                        $balance = $arr_datos_factura["balance"];
                        if ($GATEWAY["bh_comportamiento"] != "normal") {
                            $importe_pagado = $balance;
                        } else {
                            $importe_pagado = $datosdelpago["transaction_details"]["total_paid_amount"];
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
                        $command = "AddTransaction";
                        $postData = array("paymentmethod" => $GATEWAY["paymentmethod"], "invoiceid" => $nrofactura, "transid" => $mp_transaccion, "amountin" => $importe_pagado, "fees" => $comision);
                        $results = localAPI($command, $postData, $adminUsername);
                        $texto_log = "\r\n                    " . traduccion($idioma, "mpconfig_56") . ": " . $nrofactura . "\r\n                    " . traduccion($idioma, "mpconfig_57") . ": " . $GATEWAY["name"] . "\r\n                    " . traduccion($idioma, "mpconfig_58") . ": " . $mp_transaccion . "\r\n                    " . traduccion($idioma, "mpconfig_60") . ": " . $datosdelpago["authorization_code"] . "\r\n                    " . traduccion($idioma, "mpconfig_61") . ": " . $datosdelpago["date_approved"] . "\r\n                    " . traduccion($idioma, "mpconfig_62") . ": " . $datosdelpago["payment_type_id"] . " - " . $datosdelpago["payment_method_id"] . "\r\n                    " . traduccion($idioma, "mpconfig_63") . ": " . $datosdelpago["currency_id"] . "\r\n                    " . traduccion($idioma, "mpconfig_64") . ": " . $datosdelpago["transaction_details"]["total_paid_amount"] . "\r\n                    " . traduccion($idioma, "mpconfig_65") . ": " . $datosdelpago["transaction_details"]["net_received_amount"] . "\r\n                    " . $conversionlog;
                        logTransaction($GATEWAY["name"], $texto_log, traduccion($idioma, "mpconfig_66") . " [" . $nrofactura . "]");
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
                        Capsule::table("tbltransaction_history")->insert(array("invoice_id" => $datosdelpago["external_reference"], "gateway" => $GATEWAY["name"], "updated_at" => date("Y-m-d H:i:s"), "transaction_id" => $mp_transaccion, "remote_status" => traduccion($idioma, "mpconfig_76"), "description" => $datosdelpago["payment_type_id"] . " - " . $datosdelpago["payment_method_id"]));
                    }
                    $resultado = Capsule::table("bapp_mercadopago")->where("id", "=", $mp_id)->delete();
                }
            }
        }
        return true;
    }
}
?>