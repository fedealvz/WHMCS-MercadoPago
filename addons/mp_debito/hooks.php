<?php

include_once "../../../init.php";

add_hook("AfterModuleTerminate", 1, function ($vars) {
    $cliente = $vars["userid"];
    $cuantos = Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("cliente", "=", $cliente)->where("status", "=", "autorizado")->count();
    if ($cuantos != 0) {
        $resultado = Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("cliente", "=", $cliente)->get();
        $debito = $resultado[0]->debito;
        $command = "GetClientsDetails";
        $postData = ["clientid" => "1", "stats" => true];
        $results = localAPI($command, $postData, $adminUsername);
        $servicios = $results["stats"]["productsnumactive"];
        if ($servicios == 0) {
            $data = ["status" => "cancelled"];
            $ch = curl_init("https://api.mercadopago.com/preapproval/" . $debito);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json", "x-integrator-id: dev_ea52525a0a6e11eb98420242ac130004", "Authorization: Bearer " . $token]);
            $result = curl_exec($ch);
            curl_close($ch);
            $resultado = Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("debito", "=", $debito)->delete();
        }
    }
});

add_hook("InvoiceCreated", 1, function ($vars) {
    $cliente = $vars["user"];
    $factura = $vars["invoiceid"];
    $command = "GetInvoice";
    $postData = ["invoiceid" => $factura];
    $results = localAPI($command, $postData, $adminUsername);
    $importe = $results["balance"];
    $resultado = Illuminate\Database\Capsule\Manager::table("tbladdonmodules")->where("module", "=", "mp_debito")->where("setting", "=", "token")->get();
    $token = $resultado[0]->value;
    $resultado = Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("cliente", "=", $cliente)->get();
    $status = $resultado[0]->status;
    $debito = $resultado[0]->debito;
    if ($status == "autorizado") {
        $data = ["auto_recurring" => ["currency_id" => "ARS", "transaction_amount" => $importe]];
        $ch = curl_init("https://api.mercadopago.com/preapproval/" . $debito);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json", "x-integrator-id: dev_ea52525a0a6e11eb98420242ac130004", "Authorization: Bearer " . $token]);
        $result = curl_exec($ch);
        curl_close($ch);
        $datosdelpago = json_decode($result, true);
        Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("debito", $debito)->update(["importe" => $importe]);
        $command = "UpdateInvoice";
        $postData = ["invoiceid" => $factura, "status" => "Payment Pending"];
        $results = localAPI($command, $postData, $adminUsername);
    }
});

add_hook("AfterCronJob", 2, function ($vars) {
    $gatewayModule = "mp_debito";
    $gateway = new WHMCS\Module\Gateway();
    $GATEWAY = $gateway->getParams();
    $resultado = Illuminate\Database\Capsule\Manager::table("tbladdonmodules")->where("module", "=", "mp_debito")->where("setting", "=", "token")->get();
    $token = $resultado[0]->value;
    $userid = substr(strrchr($token, "-"), 1);
    $ch = curl_init("https://api.mercadopago.com/v1/payments/search?operation_type=recurring_payment&status=approved&begin_date=NOW-3DAYS&end_date=NOW&range=date_last_updated&sort=date_last_updated&criteria=desc");
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json", "x-integrator-id: dev_ea52525a0a6e11eb98420242ac130004", "Authorization: Bearer " . $token]);
    $result = curl_exec($ch);
    curl_close($ch);
    $datosdelpago = json_decode($result, true);
    $resultados = $datosdelpago["results"];
    foreach ($resultados as $pago) {
        $debito = $pago["metadata"]["preapproval_id"];
        $mp_transaccion = $pago["id"];
        $comision = $pago["fee_details"][0]["amount"];
        $cobrado = $pago["transaction_details"]["total_paid_amount"];
        $fee = $comision / $cobrado;
        $command = "GetTransactions";
        $postData = ["transid" => $mp_transaccion . "_0"];
        $arr_transacciones = localAPI($command, $postData, $adminUsername);
        if ($arr_transacciones["totalresults"] == 0) {
            $resultado = Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("debito", "=", $debito)->get();
            if (!empty($resultado)) {
                $cliente = $resultado[0]->cliente;
                $command = "GetInvoices";
                $postData = ["userid" => $cliente, "order" => "asc", "status" => "Unpaid"];
                $results = localAPI($command, $postData, $adminUsername);
                if ($results["numreturned"] != 0) {
                    $listadefacturas = $results["invoices"]["invoice"];
                    $saldo = $cobrado;
                    $contador = 0;
                    foreach ($listadefacturas as $valor) {
                        if ($saldo <= 0) {
                        } else {
                            $factura = $valor["id"];
                            $importe = $valor["total"];
                            $transa = $mp_transaccion . "_" . $contador;
                            if ($importe <= $saldo) {
                                $command = "AddTransaction";
                                $postData = ["userid" => $cliente, "paymentmethod" => "mp_debito", "invoiceid" => $factura, "amountin" => $importe, "transid" => $transa, "fees" => $fee * $importe];
                                $results = localAPI($command, $postData, $adminUsername);
                                $saldo = $saldo - $importe;
                                $contador++;
                                $estado = "Pagada";
                            } else {
                                $command = "AddTransaction";
                                $postData = ["userid" => $cliente, "paymentmethod" => "mp_debito", "invoiceid" => $factura, "amountin" => $saldo, "transid" => $transa, "fees" => $fee * $saldo];
                                $results = localAPI($command, $postData, $adminUsername);
                                $saldo = 0;
                                $contador++;
                                $estado = "Pago a cuenta";
                            }
                            $texto_log = "\nFactura: " . $nro_de_factura . "\nMercadopago Suscripción\nTransaccion: " . $transa . "\n                        ";
                            logTransaction("MercadoPago Suscripcion", $texto_log, $estado . " [" . $factura . "]");
                            Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("debito", $debito)->update(["fecha" => date("Y-m-d"), "status" => "autorizado"]);
                        }
                    }
                } else {
                    $command = "AddCredit";
                    $postData = ["clientid" => $cliente, "description" => "[" . $cliente . "] MercadoPago Suscripcion - " . $mp_transaccion, "amount" => $cobrado];
                    $results = localAPI($command, $postData, $adminUsername);
                    $command = "AddTransaction";
                    $postData = ["userid" => $cliente, "paymentmethod" => "mp_debito", "amountin" => $cobrado, "transid" => $mp_transaccion, "fees" => $comision];
                    $results = localAPI($command, $postData, $adminUsername);
                    $texto_log = "\nPago sin Factura\nMercadopago Suscripción\nTransaccion: : " . $mp_transaccion . "\n                        ";
                    logTransaction("MercadoPago Suscripcion", $texto_log, "Pago sin factura");
                    Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("debito", $debito)->update(["fecha" => date("Y-m-d"), "status" => "autorizado"]);
                }
            }
        }
    }
});

add_hook("DailyCronJob", 3, function ($vars) {
    $gatewayModule = "mp_debito";
    $gateway = new WHMCS\Module\Gateway();
    $GATEWAY = $gateway->getParams();
    $resultado = Illuminate\Database\Capsule\Manager::table("tbladdonmodules")->where("module", "=", "mp_debito")->where("setting", "=", "token")->get();
    $token = $resultado[0]->value;
    $userid = substr(strrchr($token, "-"), 1);
    $resultado = Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("status", "=", "procesando")->count();
    if ($resultado != 0) {
        $procesando = Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("status", "=", "procesando")->get();
        foreach ($procesando as $variable) {
            $debito = $variable->debito;
            $fecha = $variable->fecha;
            $fecha_calculo = strtotime("+2 day", strtotime($fecha));
            $vencimiento = date("Ymd", $fecha_calculo);
            $datetime1 = date_create($vencimiento);
            $datetime2 = new DateTime("now");
            if ($datetime1 < $datetime2) {
                $data = ["status" => "cancelled"];
                $ch = curl_init("https://api.mercadopago.com/preapproval/" . $debito);
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json", "x-integrator-id: dev_ea52525a0a6e11eb98420242ac130004", "Authorization: Bearer " . $token]);
                $result = curl_exec($ch);
                curl_close($ch);
                $datosdelpago = json_decode($result, true);
                $status = $datosdelpago["status"];
                if (!empty($debito) && $status == "cancelled") {
                    $resultado = Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("debito", "=", $debito)->delete();
                }
            } else {
                $ch = curl_init("https://api.mercadopago.com/preapproval/search?id=" . $debito);
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json", "x-integrator-id: dev_ea52525a0a6e11eb98420242ac130004", "Authorization: Bearer " . $token]);
                $result = curl_exec($ch);
                curl_close($ch);
                $datosdelpago = json_decode($result, true);
                $estado = $datosdelpago["results"][0]["status"];
                if ($estado == "authorized") {
                    Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("debito", $debito)->update(["fecha" => date("Y-m-d"), "status" => "pendiente"]);
                }
            }
        }
    }
});

?>

