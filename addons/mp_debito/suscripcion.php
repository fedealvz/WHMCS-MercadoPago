<?php

include_once "../../../init.php";

$suscripcion = $_GET["id"];
$accion = $_GET["hana"];
$inv = $_GET["inv"];

if (!empty($suscripcion) && !empty($accion)) {
    if ($accion == "haften") {
        Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("debito", $suscripcion)->update(["fecha" => date("Y-m-d"), "status" => "procesando"]);
        header("Location: https://www.mercadopago.com/mla/debits/new?preapproval_id=" . $suscripcion);
        exit;
    }
    $resultado = Illuminate\Database\Capsule\Manager::table("tbladdonmodules")->where("module", "=", "mp_debito")->where("setting", "=", "token")->get();
    $token = $resultado[0]->value;
    $data = ["status" => "cancelled"];
    $ch = curl_init("https://api.mercadopago.com/preapproval/" . $suscripcion);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json", "x-integrator-id: dev_ea52525a0a6e11eb98420242ac130004", "Authorization: Bearer " . $token]);
    $result = curl_exec($ch);
    curl_close($ch);
    $datosdelpago = json_decode($result, true);
    $debito = $datosdelpago["id"];
    $status = $datosdelpago["status"];
    if (!empty($debito) && $status == "cancelled") {
        $resultado = Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("debito", "=", $debito)->delete();
        header("Location: /viewinvoice.php?id=" . $inv);
        exit;
    }
    echo "Error MercadoPago:<br>";
    echo "<pre>" . print_r($datosdelpago, true) . "</pre>";
} else {
    exit("Error.");
}

?>

