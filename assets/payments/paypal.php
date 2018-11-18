<?php

require_once 'payments/PayPal-PHP-SDK/autoload.php';
require_once 'config.php';
require_once 'database.php';

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class PayPalGateway {

  public function createPayment($userId, $price) {
    global $config;
    global $database;

    $payer = new Payer();
    $payer -> setPaymentMethod("paypal");

    $item = new Item();
    $item -> setName('DeinPlugin.net Guthaben')
          -> setCurrency('EUR')
          -> setPrice($price)
          -> setQuantity(1);
    $itemList = new ItemList();
    $itemList -> setItems(array($item));

    $details = new Details();
    $details -> setShipping(0)
             -> setTax(0)
             -> setSubtotal($price);
    $amount = new Amount();
    $amount -> setCurrency("EUR")
            -> setTotal($price)
            -> setDetails($details);

    $transaction = new Transaction();
    $transaction -> setAmount($amount)
                 -> setItemList($itemList)
                 -> setDescription("Aufladung von DeinPlugin.net Guthaben")
                 -> setInvoiceNumber(uniqid());

     $redirectUrls = new RedirectUrls();
     $redirectUrls -> setReturnUrl($config['base_url'] . "assets/payments.php?method=paypal&price=$price&success=true")
                   -> setCancelUrl($config['base_url'] . "assets/payments.php?method=paypal&price=$price&success=false");

     $payment = new Payment();

     $payment -> setIntent("sale")
              -> setPayer($payer)
              -> setRedirectUrls($redirectUrls)
              -> setTransactions(array($transaction));

     $request = clone $payment;

     try {
       $payment->create($this -> getApiContext());
     } catch (Exception $ex) {
       die("Die Zahlung mit PayPal konnte nicht vorbereitet werden, bitte versuche es später erneut");
     }

    $database -> addTransaction('PayPal', $price, $payment -> id, $userId);

     return $payment -> getApprovalLink();
  }

  function acceptPayment($price) {
    global $database;

    $paymentId = $_GET['paymentId'];
    $payment = Payment::get($paymentId, $this -> getApiContext());
    $execution = new PaymentExecution();
    $execution -> setPayerId($_GET['PayerID']);

    $details = new Details();
    $details -> setShipping(0)
             -> setTax(0)
             -> setSubtotal($price);
     $amount = new Amount();
     $amount -> setCurrency('EUR');
     $amount -> setTotal($price);
     $amount -> setDetails($details);

     $transaction = new Transaction();
     $transaction -> setAmount($amount);
     $execution -> addTransaction($transaction);

     try {
       $result = $payment->execute($execution, $this -> getApiContext());

       if ($payment -> getState() == 'approved') {
          echo "Zahlung erfolgreich";
          $database -> editTransactionStatus('PayPal', $payment -> getId(), 1);
          $database -> addBalance('PayPal', $payment -> getId()) ;
       } else if ($payment -> getState() == 'failed') {
         echo "Zahlung fehlgeschlagen";
         $database -> editTransactionStatus('PayPal', $payment -> getId(), -1);
       }

       try {
         $payment = Payment::get($paymentId, $this -> getApiContext());
       } catch (Exception $ex) {
         die("Error: 2");
       }
    } catch (Exception $ex) {
        die("Error: 1");
    }

    return "https://google.de/?q=Danke!";
  }

  function getApiContext() {
    global $config;

    $apiContext = new ApiContext(
      new OAuthTokenCredential(
        $config['paypal_client_id'],
        $config['paypal_client_secret']));

    $apiContext -> setConfig(
        array(
            'mode' => $config['paypal_sandox'] ? 'sandbox' : 'live',
            'log.LogEnabled' => true,
            'log.FileName' => 'logs/PayPal.log',
            'log.LogLevel' => $config['paypal_sandbox'] ? 'DEBUG' : 'INFO',
            'cache.enabled' => true
          ));

    return $apiContext;
  }
}
