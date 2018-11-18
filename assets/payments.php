<?php

session_start();
error_reporting(E_ALL);

require_once 'config.php';
require_once 'database.php';

$database = new Database();

if (isset($_GET['method']) && isset($_GET['price'])) {
  $_GET['method'] = strtolower($_GET['method']);
  $_GET['price'] = floatval(str_replace(',', '.', $_GET['price']));

  if ($_GET['method'] == 'paypal') {
    require_once 'payments/paypal.php';
    $gateway = new PayPalGateway();
  } else if ($_GET['method'] == 'paygol') {
    require_once 'payments/paygol.php';
    $gateway = new PayGolGateway();
  }

  if (!isset($gateway))
    die("Bitte wähle einen gültigen Zahlungsprovider");

  if (isset($_GET['success'])) {
    if ($_GET['success'] == true)
        die ('<meta http-equiv="refresh" content="0; URL='
            . ($gateway -> acceptPayment(floatval($_GET['price']))) . '">');
  } else {
    if (!isset($_SESSION['USER_ID']))
      die("Invalid session");

		die ('<meta http-equiv="refresh" content="0; URL='
            . ($gateway -> createPayment($_SESSION['USER_ID'], floatval($_GET['price']))) . '">');
  }
}

$database -> close();
