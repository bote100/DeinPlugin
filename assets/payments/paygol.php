<?php

class PayGolGateway {

    public function createPayment($userId, $price) {
        global $config;
        global $database;

        //PAYGOL PAYMENT ERSTELLEN + TRANSAKTIONS_ID in DIE DB EINTRAGEN (MIT PREISSSSSSS)
        $pg_serviceid   = '367379';
        $pg_currency    = 'EUR';
        $pg_custom      = 'Guthaben aufladen';
        $pg_price       = '10.00';
        $pg_return_url  = 'https://deinplugin.deppelopers.space/assets/payments.php';
        $pg_cancel_url  = 'https://deinplugin.deppelopers.space/profile';
        $pg_mode        = 'api';
        $pg_country     = 'DE';
        $pg_language    = 'de';
        $pg_method      = 'paysafecard';
        $pg_format      = 'txt';
        $pg_ip          = '88.130.50.160';
        $pg_email       = 'julienobarowski1@gmail.com';
        $pg_first_name  = 'Julien';
        $pg_last_name   = 'Obarowski';


        file_get_contents("https://www.paygol.com/pay?pg_serviceid=$pg_serviceid
                &pg_price=$pg_price&pg_currency=$pg_currency
                &pg_custom=$pg_custom&pg_return_url=$pg_return_url
                &pg_cancel_url=$pg_cancel_url&pg_mode=$pg_mode&pg_country=$pg_country&pg_language=$pg_language
                &pg_method=$pg_method&pg_format=$pg_format&pg_ip=$pg_ip&pg_email=$pg_email
                &pg_first_name=$pg_first_name&pg_last_name=$pg_last_name");

        $id             = $_GET['id'];
        $service        = $_GET['service'];

        return "https://www.paygol.com/api/check-payment?service=$service&id=$id&format=txt";
    }

    function acceptPayment($price) {
        //DU BRAUCHST DIETRANSACTION-ID
        // => transcation-id in die success url mit als get PARAmeter, den du hier auslesen kannst
        $id             = $_GET['id'];
        $service        = $_GET['service'];

        return "https://www.paygol.com/api/check-payment?service=$service&id=$id&format=txt";

        //PAYMENT überprüfen und dANNACH GELD hinzufügen

        //WENN ERFOLGREICH => success seite, sonst FEHLER-Seii
        //return "https://google.de/?q=Bitte";
    }
}
