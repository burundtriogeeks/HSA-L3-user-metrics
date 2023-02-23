<?php

    echo "\nStart as : ".date("d-m-Y H:i")."\n";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"https://bank.gov.ua/NBU_Exchange/exchange?json");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close($ch);

    $uah_usd = 0;

    $currency_list = json_decode($server_output,true);
    foreach ($currency_list as $currency) {
        if ($currency["CurrencyCodeL"] == "USD") {
            $uah_usd =  $currency["Amount"];
        }
    }

    echo "Currency : ".$uah_usd."\n";

    //Send data to GA4
    $uniqid = uniqid();
    $data_json = '{ "client_id": "'.$uniqid.'", "events": [ { "name": "currency", "params": { "value": "'.$uah_usd.'" } } ] }';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,"https://www.google-analytics.com/mp/collect?api_secret=DBkCOTuXSQ6eYXtSvrKZOQ&measurement_id=G-75NM9KYLHP");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($curl, CURLOPT_TIMEOUT, 5);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_json))
    );
    $server_output = curl_exec($curl);

    curl_close($curl);

    echo "End\n";