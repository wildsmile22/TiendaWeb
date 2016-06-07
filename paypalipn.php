<?php

//ES OTRA FORMA DE INFORMAR AL USUARIO SOBRE EL ESTADO DEL PAGO.
//Este codigo IPN es sacado de la URL: http://programacionya.com/paypal-notificacion-de-pago-instantanea-ipn/
$payaltest = true; //si lo cambio  a false será para realizar transacciones reales,asi utiliza sandbox que es version de prueba.

$req = 'cmd=_notify-validate';
$fullipnA = array();

foreach ($_POST as $key => $value) {
    $fullipnA[$key] = $value;

    $encodedvalue = urlencode(stripslashes($value));
    $req .= "&$key=$encodedvalue";
}

$fullipn = Array2Str(" : ", "\n", $fullipnA);

if (!$payaltest) {
    $url = 'https://www.paypal.com/cgi-bin/webscr';
} else {

    $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
}

$curl_result = $curl_err = '';
$fp = curl_init();
curl_setopt($fp, CURLOPT_URL, $url);
curl_setopt($fp, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($fp, CURLOPT_POST, 1);
curl_setopt($fp, CURLOPT_POSTFIELDS, $req);
curl_setopt($fp, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
curl_setopt($fp, CURLOPT_HEADER, 0);
curl_setopt($fp, CURLOPT_VERBOSE, 1);
curl_setopt($fp, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($fp, CURLOPT_TIMEOUT, 30);

$response = curl_exec($fp);
$curl_err = curl_error($fp);
curl_close($fp);


// Variables enviadas por Paypal
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$txn_type = $_POST['txn_type'];
$pending_reason = $_POST['pending_reason'];
$payment_type = $_POST['payment_type'];
$custom_key = $_POST['custom'];


if (strcmp($response, "VERIFIED") == 0) {
    // Verifico el estado del pedido
    if ($payment_status != "Completed") {
        TransLog("El pago no fue aceptado por paypal - Estado del Pago: $payment_status");
        StopProcess();
    }

    //Una vez que la transacción esta confirmada puedo realizar mis tareas
    //actualizar DB, stock, acreditar computos, activar cuentas etc etc



    TransLog("Pago Correcto - $fullipn"); //notifico al webmaster
} else { //la transaccion es invalida NO se puedo cobrarle al cliente.
    TransLog("Pago Invalido - $fullipn");
}

//funcion basica para las notificaciones
function notify_webmaster($message) {
    $subject = "Nuevo Pago";
    $remite = "tu-email";
    $remitente = "Tu remitente";

    $header .="MIME-Version: 1.0\n";
    $header .= "Content-type: text/html; charset=iso-8859-1\n";
    $header .="From: " . $remitente . "<" . $remite . ">\n";
    $header .="Return-path: " . $remite . "\n";
    $header .="X-Mailer: PHP/" . phpversion() . "\n";

    mail("email-aqui-de-quiren-recibe", $subject, $message, $header);
}

//esta función la utilizo para almacenar en una variable global todas las acciones del script y así puedo rastrear errores fácilmente.
function TransLog($message) {
    notify_webmaster($message);
}

//examina todo el IPN y lo convierte en una cadena de texto
function Array2Str($kvsep, $entrysep, $a) {
    $str = "";
    foreach ($a as $k => $v) {
        $str .= "{$k}{$kvsep}{$v}{$entrysep}";
    }
    return $str;
}

//para toda la ejecucion del programa
function StopProcess() {
    exit;
}

?>