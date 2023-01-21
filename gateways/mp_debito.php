<?php

include_once "../../../init.php";

if (!defined("WHMCS")) {
	exit("This file cannot be accessed directly");
}

function mp_debito_MetaData()
{
	return array(
		'DisplayName' => 'MercadoPago Suscripciones Argentina',
		'APIVersion' => '1.1', // Use API Version 1.1
		'DisableLocalCreditCardInput' => true,
		'TokenisedStorage' => false,
	);
}

function mp_debito_config()
{
	return [
		"FriendlyName" => ["Type" => "System", "Value" => "MercadoPago Suscripciones Argentina"],
		"boton_adhesion" => ["FriendlyName" => "Botón Adhesión", "Type" => "text", "Size" => "25", "Value" => "Adherir Suscripción", "Description" => "<br>Texto del botón de adhesión."],
		"boton_cancelacion" => ["FriendlyName" => "Botón Cancelación", "Type" => "text", "Size" => "25", "Value" => "Cancelar Suscripción", "Description" => "<br>Texto del botón de cancelación."],
		"nota_inactivo" => ["FriendlyName" => "Nota para clientes inactivos", "Type" => "text", "Size" => "25", "Value" => "Haga clic en el botón para suscribirse al débito automático.", "Description" => "<br>Texto de la nota que aparece encima del botón para los clientes que aún no están suscriptos al débito automático."],
		"nota_procesando" => ["FriendlyName" => "Nota para suscripciones en proceso", "Type" => "text", "Size" => "25", "Value" => "Su solicitud de adhesión al débito automático se está procesando.", "Description" => "<br>Texto de la nota que aparece encima del botón para los clientes que aún no completaron los datos de su tarjeta."],
		"nota_pendiente" => ["FriendlyName" => "Nota para suscripciones pendientes", "Type" => "text", "Size" => "25", "Value" => "Su adhesión ha sido recibida y se encuentra pendiente de cobro.", "Description" => "<br>Texto de la nota que aparece encima del botón para los clientes que ya completaron la suscripción pero aún no fue debitado el primer pago."],
		"nota_autorizado" => ["FriendlyName" => "Nota para suscripciones activas", "Type" => "text", "Size" => "25", "Value" => "Su cuenta se encuentra adherida al débito automático.", "Description" => "<br>Texto de la nota que aparece encima del botón para los clientes cuya suscripción está activa."],
		"nota_tiempofuera" => ["FriendlyName" => "Nota para facturas vencidas", "Type" => "text", "Size" => "25", "Value" => "Su cuenta no puede aherirse al débito automático.", "Description" => "<br>Texto de la nota que aparece en caso de que la factura está vencida"]
	];
}

function mp_debito_link($params)
{
	$boton_adhesion = $params["boton_adhesion"];
	$boton_cancelacion = $params["boton_cancelacion"];
	$nota_inactivo = $params["nota_inactivo"];
	$nota_procesando = $params["nota_procesando"];
	$nota_pendiente = $params["nota_pendiente"];
	$nota_autorizado = $params["nota_autorizado"];
	$nota_tiempofuera = $params["nota_tiempofuera"];
	$invoiceId = $params["invoiceid"];
	$description = $params["description"];
	$amount = $params["amount"];
	$currencyCode = $params["currency"];
	$vencimiento = $params["dueDate"];
	$cliente = $params["clientdetails"]["id"];
	$firstname = $params["clientdetails"]["firstname"];
	$lastname = $params["clientdetails"]["lastname"];
	$email = $params["clientdetails"]["email"];
	$address1 = $params["clientdetails"]["address1"];
	$address2 = $params["clientdetails"]["address2"];
	$city = $params["clientdetails"]["city"];
	$state = $params["clientdetails"]["state"];
	$postcode = $params["clientdetails"]["postcode"];
	$country = $params["clientdetails"]["country"];
	$phone = $params["clientdetails"]["phonenumber"];
	$companyName = $params["companyname"];
	$systemUrl = $params["systemurl"];
	$returnUrl = $params["returnurl"];
	$langPayNow = $params["langpaynow"];
	$moduleDisplayName = $params["name"];
	$moduleName = $params["paymentmethod"];
	$whmcsVersion = $params["whmcsVersion"];
	$fecha_de_vencimiento = substr($vencimiento, 0, 10);
	$datetime1 = date_create($fecha_de_vencimiento);
	$datetime2 = new DateTime("midnight");
	$htmlOutput = '';

	if ($datetime1 < $datetime2) {
		$htmlOutput = "<div class='alert alert-info'>" . $nota_tiempofuera . "</div>";
	} else {
		$cart = $params["cart"]->items;
		$ciclo = $cart[0]->billingPeriod;
		$resultado = Illuminate\Database\Capsule\Manager::table("tbladdonmodules")->where("module", "=", "mp_debito")->where("setting", "=", "token")->get();
		$token = $resultado[0]->value;
		//$userid = substr(strrchr($token, "-"), 1);
		$cuantos = Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("cliente", "=", $cliente)->count();
		if ($cuantos == 0) {
			$data = [
				"auto_recurring" =>
					[
						"currency_id" => "ARS",
						"transaction_amount" => $amount,
						"frequency" => $ciclo,
						"frequency_type" => "months"
					],
				"back_url" => $systemUrl . "viewinvoice.php?id=" . $invoiceId,
				//"collector_id" => $userid, Este campo no lo vi como requerido en la doc de mp
				"external_reference" => $cliente,
				"payer_email" => $email,
				"reason" => "Adhesión al débito automático.",
				"status" => "pending"
			];

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://api.mercadopago.com/preapproval',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>json_encode($data),
				CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer '.$token,
					'Content-Type: application/json',
					'x-integrator-id: dev_ea52525a0a6e11eb98420242ac130004'
				),
			));

			$result = curl_exec($curl);
			curl_close($curl);

			// logModuleCall('Mercado Pago debito', 'preapproval', json_encode($data), $result, '', '');

			$datosdelpago = json_decode($result, true);
			$debito = $datosdelpago["id"];
			Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->insert(["cliente" => $cliente, "importe" => $amount, "debito" => $debito, "fecha" => date("Y-m-d"), "status" => "inactivo"]);
		}
		$resultado = Illuminate\Database\Capsule\Manager::table("mercadopago_debito")->where("cliente", "=", $cliente)->get();
		$status = $resultado[0]->status;
		$debito = $resultado[0]->debito;
		switch ($status) {
			case "autorizado":
				$texto = $nota_autorizado;
				$boton = $boton_cancelacion;
				$url = "kanselleer";
				$color = "danger";
				$icono = "times-circle";
				break;
			case "pendiente":
				$texto = $nota_pendiente;
				$boton = $boton_cancelacion;
				$url = "kanselleer";
				$color = "warning";
				$icono = "clock";
				break;
			case "procesando":
				$texto = $nota_procesando;
				$boton = $boton_cancelacion;
				$url = "kanselleer";
				$color = "info";
				$icono = "hourglass-half";
				break;
			case "inactivo":
				$texto = $nota_inactivo;
				$boton = $boton_adhesion;
				$url = "haften";
				$color = "primary";
				$icono = "check-square";
				break;
		}

		$htmlOutput = "<div class='alert alert-info'>" . $texto . "</div><a href='modules/addons/mp_debito/suscripcion.php?id=" . $debito . "&hana=" . $url . "&inv=" . $invoiceId . "' class='btn btn-" . $color . " btn-lg'>" . $boton . " &nbsp;<i class='fa fa-" . $icono . "'></i></a>";
	}
	return $htmlOutput;
}

function reconstruye_clave_debito($frase_de_seguridad)
{
	$desglose_frase_seguridad = str_split($frase_de_seguridad);
	$fraseoriginal = $desglose_frase_seguridad[0] . $desglose_frase_seguridad[10] . $desglose_frase_seguridad[20] . $desglose_frase_seguridad[30] . $desglose_frase_seguridad[40] . $desglose_frase_seguridad[50] . $desglose_frase_seguridad[60] . $desglose_frase_seguridad[70];
	$fraseoriginal_cortada = str_split($fraseoriginal);
	foreach ($fraseoriginal_cortada as $letra) {
		switch ($letra) {
			case "M":
				$sopadeletras[] = "0";
				break;
			case "U":
				$sopadeletras[] = "1";
				break;
			case "R":
				$sopadeletras[] = "2";
				break;
			case "C":
				$sopadeletras[] = "3";
				break;
			case "I":
				$sopadeletras[] = "4";
				break;
			case "E":
				$sopadeletras[] = "5";
				break;
			case "L":
				$sopadeletras[] = "6";
				break;
			case "A":
				$sopadeletras[] = "7";
				break;
			case "G":
				$sopadeletras[] = "8";
				break;
			case "O":
				$sopadeletras[] = "9";
				break;
		}
	}
	$fecha_de_vencimiento = $sopadeletras[0] . $sopadeletras[1] . $sopadeletras[2] . $sopadeletras[3] . "-" . $sopadeletras[4] . $sopadeletras[5] . "-" . $sopadeletras[6] . $sopadeletras[7];
	return $fecha_de_vencimiento;
}

?>
