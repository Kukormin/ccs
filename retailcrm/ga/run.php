<?php
if (
    function_exists('date_default_timezone_set')
    &&
    function_exists('date_default_timezone_get')
) {
    date_default_timezone_set(@date_default_timezone_get());
}

require_once 'vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/vendor/google/apiclient/client_secret_629195762039-hbi274i34gdu3j32fbdh2jc75r6ni9ri.apps.googleusercontent.com.json');
require_once 'StatusUpdate.php';

$client = new \RetailCrm\ApiClient(
    'https://mebelvia.retailcrm.ru',
    'oYijxFlncids3VyRwUU3JVTa3X6FieZm'
);
$result = array();
$full = array();
$first = array();
$offset = 0;
do {
    if (!empty(file_get_contents('history.log'))) {
        $date = file_get_contents('history.log');
    } else{
        $timemark = new DateTime(date('Y-m-d H:i:s'));
        date_sub($timemark, date_interval_create_from_date_string('1 day'));
        date_add($timemark, date_interval_create_from_date_string('3 hour'));
        $date = $timemark->format('Y-m-d H:i:s');
    }
    
    $history = $client->ordersHistory(new DateTime($date), null, 100, $offset);
    $offset += 100;
    foreach($history['orders'] as $n=>$order){
        if (isset($order['status']) && count($order['items']) > 0) {
            $full[$order['number']] = $order;
        }
    }
} while (count($history['orders']) > 0);
$timemark = new DateTime(date('Y-m-d H:i:s'));
date_add($timemark, date_interval_create_from_date_string('3 hour'));
$date = $timemark->format('Y-m-d H:i:s');
file_put_contents('history.log', $date);

if (!empty($full)) {
    $sender = new StatusUpdate($result, $client, $full);
    $sender->execute();
}