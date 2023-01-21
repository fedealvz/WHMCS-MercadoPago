<?php

if (!defined("WHMCS")) {
    exit("This file cannot be accessed directly");
}
function mp_debito_config()
{
    return ["name" => "MercadoPago Débito", "description" => "Módulo de Débito Automático por MercadoPago Argentina", "author" => "BayresApp", "language" => "spanish", "version" => "3", "fields" => ["licencia" => ["FriendlyName" => "Licencia:", "Type" => "text", "Size" => "25", "Description" => "&nbsp;&nbsp;Licencia BayresApp"], "verificador" => ["FriendlyName" => "Texto Verificador:", "Type" => "textarea", "Rows" => "6", "Cols" => "60", "Description" => "<br>Este campo se rellenará en forma automática. NO ESCRIBIR."], "token" => ["FriendlyName" => "Access Token", "Type" => "text", "Size" => "100", "Description" => "&nbsp;&nbsp;Access Token de MercadoPago"]]];
}

function mp_debito_activate()
{
    try {
        WHMCS\Database\Capsule::schema()->create("mercadopago_debito", function ($table) {
            $table->increments("id");
            $table->string("cliente");
            $table->string("importe");
            $table->string("debito");
            $table->dateTime("fecha");
            $table->string("status");
        });
    } catch (Exception $e) {
        echo "Imposible crear la tabla: " . $e->getMessage();
    }
    return ["status" => "success", "description" => "MercadoPago Argentina - Débito Automático Activado"];
}

function mp_debito_deactivate()
{
    WHMCS\Database\Capsule::schema()->dropIfExists("mercadopago_debito");
    return ["status" => "success", "description" => "MercadoPago Argentina - Débito Automático Desactivado"];
}

function mp_debito_output($vars)
{
    echo "\r\n    <div id=\"content\">\r\n        <div id=\"content_padded\">\r\n            <ul class=\"nav nav-tabs admin-tabs\" role=\"tablist\">\r\n                <li class=\"active\"><a href=\"#tab1\" role=\"tab\" data-toggle=\"tab\" id=\"tabLink1\" aria-expanded=\"true\">Solo Activos</a></li>\r\n                <li class=\"\"><a href=\"#tab2\" role=\"tab\" data-toggle=\"tab\" id=\"tabLink2\" aria-expanded=\"false\">Todos</a></li>\r\n                <li class=\"\"><a href=\"#tab3\" role=\"tab\" data-toggle=\"tab\" id=\"tabLink3\" aria-expanded=\"false\">Pendientes</a></li>\r\n                <li class=\"\"><a href=\"#tab4\" role=\"tab\" data-toggle=\"tab\" id=\"tabLink4\" aria-expanded=\"false\">En Proceso</a></li>\r\n            </ul>\r\n            <div class=\"tab-content admin-tabs\">\r\n                <div class=\"tab-pane active\" id=\"tab1\">\r\n\r\n                    <div class='tablebg'>\r\n                        <table id='sortabletbl0' class='datatable' width='100%' border='0' cellspacing='1' cellpadding='3'>\r\n                            <tbody>\r\n                                <tr>\r\n                                    <th>Cliente</th>\r\n                                    <th>Importe</th>\r\n                                    <th>Débito</th>\r\n                                    <th>Fecha</th>\r\n                                    <th>Status</th>\r\n                                    <th>Cancelar</th>\r\n                                </tr>";
    $resultado = WHMCS\Database\Capsule::table("mercadopago_debito")->where("status", "=", "autorizado")->get();
    foreach ($resultado as $valor) {
        $id = $valor->id;
        $debito = $valor->debito;
        $cliente = $valor->cliente;
        $importe = $valor->importe;
        $status = $valor->status;
        $fecha = $valor->fecha;
        switch ($status) {
            case "procesando":
                $label = "inactive";
                $estado = "Procesando";
                break;
            case "pendiente":
                $label = "pending";
                $estado = "Pendiente";
                break;
            case "autorizado":
                $label = "active";
                $estado = "Activo";
                break;
            default:
                $command = "GetClientsDetails";
                $postData = ["clientid" => $cliente];
                $datoscliente = localAPI($command, $postData, $adminUsername);
                $nombre = $datoscliente["fullname"];
                $importe = round($importe, 2);
                echo "\r\n                            <tr>\r\n                                <td><a href='clientssummary.php?userid=" . $cliente . "'>" . $nombre . "</a></td>\r\n                                <td>\$ " . $importe . "</td>\r\n                                <td><a href='https://www.mercadopago.com.ar/subscription-plans/subscriptor-details?id=" . $debito . "' target='_blank' >" . $debito . "</a></td>\r\n                                <td>" . $fecha . "</td>\r\n                                <td><span class='label " . $label . "'>" . $estado . "</span></td>\r\n                                <td><a href='/modules/addons/mp_debito/canceladmin.php?suscripcion=" . $debito . "' class='btn btn-danger btn-sm'>Cancelar</a></td>\r\n                            </tr>\r\n                        ";
        }
    }
    echo "\r\n\r\n                            </tbody>\r\n                        </table>\r\n                    </div>                </div>\r\n                <div class=\"tab-pane\" id=\"tab2\">\r\n\r\n                \r\n                    <div class='tablebg'>\r\n                        <table id='sortabletbl0' class='datatable' width='100%' border='0' cellspacing='1' cellpadding='3'>\r\n                            <tbody>\r\n                                <tr>\r\n                                    <th>Cliente</th>\r\n                                    <th>Importe</th>\r\n                                    <th>Débito</th>\r\n                                    <th>Fecha</th>\r\n                                    <th>Status</th>\r\n                                    <th>Cancelar</th>\r\n                                </tr>";
    $resultado = WHMCS\Database\Capsule::table("mercadopago_debito")->where("status", "!=", "inactivo")->get();
    foreach ($resultado as $valor) {
        $id = $valor->id;
        $debito = $valor->debito;
        $cliente = $valor->cliente;
        $importe = $valor->importe;
        $status = $valor->status;
        $fecha = $valor->fecha;
        switch ($status) {
            case "procesando":
                $label = "inactive";
                $estado = "Procesando";
                break;
            case "pendiente":
                $label = "pending";
                $estado = "Pendiente";
                break;
            case "autorizado":
                $label = "active";
                $estado = "Activo";
                break;
            default:
                $command = "GetClientsDetails";
                $postData = ["clientid" => $cliente];
                $datoscliente = localAPI($command, $postData, $adminUsername);
                $nombre = $datoscliente["fullname"];
                $importe = round($importe, 2);
                echo "\r\n                            <tr>\r\n                                <td><a href='clientssummary.php?userid=" . $cliente . "'>" . $nombre . "</a></td>\r\n                                <td>\$ " . $importe . "</td>\r\n                                <td><a href='https://www.mercadopago.com.ar/subscription-plans/subscriptor-details?id=" . $debito . "' target='_blank' >" . $debito . "</a></td>\r\n                                <td>" . $fecha . "</td>\r\n                                <td><span class='label " . $label . "'>" . $estado . "</span></td>\r\n                                <td><a href='/modules/addons/mp_debito/canceladmin.php?suscripcion=" . $debito . "' class='btn btn-danger btn-sm'>Cancelar</a></td>\r\n                            </tr>\r\n                        ";
        }
    }
    echo "\r\n\r\n                            </tbody>\r\n                        </table>\r\n                    </div>                </div>\r\n                <div class=\"tab-pane\" id=\"tab3\">\r\n\r\n                \r\n                    <div class='tablebg'>\r\n                        <table id='sortabletbl0' class='datatable' width='100%' border='0' cellspacing='1' cellpadding='3'>\r\n                            <tbody>\r\n                                <tr>\r\n                                    <th>Cliente</th>\r\n                                    <th>Importe</th>\r\n                                    <th>Débito</th>\r\n                                    <th>Fecha</th>\r\n                                    <th>Status</th>\r\n                                    <th>Cancelar</th>\r\n                                </tr>";
    $resultado = WHMCS\Database\Capsule::table("mercadopago_debito")->where("status", "=", "pendiente")->get();
    foreach ($resultado as $valor) {
        $id = $valor->id;
        $debito = $valor->debito;
        $cliente = $valor->cliente;
        $importe = $valor->importe;
        $status = $valor->status;
        $fecha = $valor->fecha;
        switch ($status) {
            case "procesando":
                $label = "inactive";
                $estado = "Procesando";
                break;
            case "pendiente":
                $label = "pending";
                $estado = "Pendiente";
                break;
            case "autorizado":
                $label = "active";
                $estado = "Activo";
                break;
            default:
                $command = "GetClientsDetails";
                $postData = ["clientid" => $cliente];
                $datoscliente = localAPI($command, $postData, $adminUsername);
                $nombre = $datoscliente["fullname"];
                $importe = round($importe, 2);
                echo "\r\n                            <tr>\r\n                                <td><a href='clientssummary.php?userid=" . $cliente . "'>" . $nombre . "</a></td>\r\n                                <td>\$ " . $importe . "</td>\r\n                                <td><a href='https://www.mercadopago.com.ar/subscription-plans/subscriptor-details?id=" . $debito . "' target='_blank' >" . $debito . "</a></td>\r\n                                <td>" . $fecha . "</td>\r\n                                <td><span class='label " . $label . "'>" . $estado . "</span></td>\r\n                                <td><a href='/modules/addons/mp_debito/canceladmin.php?suscripcion=" . $debito . "' class='btn btn-danger btn-sm'>Cancelar</a></td>\r\n                            </tr>\r\n                        ";
        }
    }
    echo "\r\n\r\n                            </tbody>\r\n                        </table>\r\n                    </div>                </div>\r\n                <div class=\"tab-pane\" id=\"tab4\">\r\n                \r\n                    <div class='tablebg'>\r\n                        <table id='sortabletbl0' class='datatable' width='100%' border='0' cellspacing='1' cellpadding='3'>\r\n                            <tbody>\r\n                                <tr>\r\n                                    <th>Cliente</th>\r\n                                    <th>Importe</th>\r\n                                    <th>Débito</th>\r\n                                    <th>Fecha</th>\r\n                                    <th>Status</th>\r\n                                    <th>Cancelar</th>\r\n                                </tr>";
    $resultado = WHMCS\Database\Capsule::table("mercadopago_debito")->where("status", "=", "procesando")->get();
    foreach ($resultado as $valor) {
        $id = $valor->id;
        $debito = $valor->debito;
        $cliente = $valor->cliente;
        $importe = $valor->importe;
        $status = $valor->status;
        $fecha = $valor->fecha;
        switch ($status) {
            case "procesando":
                $label = "inactive";
                $estado = "Procesando";
                break;
            case "pendiente":
                $label = "pending";
                $estado = "Pendiente";
                break;
            case "autorizado":
                $label = "active";
                $estado = "Activo";
                break;
            default:
                $command = "GetClientsDetails";
                $postData = ["clientid" => $cliente];
                $datoscliente = localAPI($command, $postData, $adminUsername);
                $nombre = $datoscliente["fullname"];
                $importe = round($importe, 2);
                echo "\r\n                            <tr>\r\n                                <td><a href='clientssummary.php?userid=" . $cliente . "'>" . $nombre . "</a></td>\r\n                                <td>\$ " . $importe . "</td>\r\n                                <td><a href='https://www.mercadopago.com.ar/subscription-plans/subscriptor-details?id=" . $debito . "' target='_blank' >" . $debito . "</a></td>\r\n                                <td>" . $fecha . "</td>\r\n                                <td><span class='label " . $label . "'>" . $estado . "</span></td>\r\n                                <td><a href='/modules/addons/mp_debito/canceladmin.php?suscripcion=" . $debito . "' class='btn btn-danger btn-sm'>Cancelar</a></td>\r\n                            </tr>\r\n                        ";
        }
    }
    echo "\r\n\r\n                            </tbody>\r\n                        </table>\r\n                    </div>                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n\r\n";
}

?>

