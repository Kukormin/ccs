<?php
set_time_limit(0);
require_once('bootstrap.php');

$apiKey = "xCQ6xmYWuC5FaiQ4E7ZkLvtRylQycv50";
$apiUrl = "https://cupcakestory.retailcrm.ru";

$filter['createdAtFrom'] = date('Y') . '-01-01';
$filter['extendedStatus'] = ['obrabotan', 'complete'];

$api = new \RetailCrm\ApiClient($apiUrl, $apiKey);

try {
    $response = $api->ordersList($filter, 1, 100);
} catch (\RetailCrm\Exception\CurlException $e) {
    echo "Connection error: " . $e->getMessage();
    die();
}

$data = array();

if ($response->isSuccessful()) {
    $pages = $response->pagination;

    if (isset($pages['totalPageCount']) && $pages['totalPageCount'] > 0) {
        for($page = 1; $page <= $pages['totalPageCount']; $page++) {
            try {
                $response = $api->ordersList($filter, $page, 100);
            } catch (\RetailCrm\Exception\CurlException $e) {
                echo "Connection error: " . $e->getMessage();
            }

            foreach ($response->orders as $order) {
                $data[] = $order;
            }

            time_nanosleep(0, 50000000);
        }
    } else {
        $data[] = $response->orders;
    }
} else {
    echo sprintf(
        "Error: [HTTP-code %s] %s",
        $response->getStatusCode(),
        $response->getErrorMsg()
    );
}

$clientSumm = array();

foreach ($data as $order) {
    if (isset($clientSumm[$order['customer']['id']])) {
        if ($order['totalSumm'] > 0) {
            $clientSumm[$order['customer']['id']] += $order['totalSumm'];
        }
    } else {
        if ($order['totalSumm'] > 0) {
            $clientSumm[$order['customer']['id']] = $order['totalSumm'];
        }
    }
}

if (!empty($clientSumm) && count($clientSumm) > 0) {
    foreach ($clientSumm as $id => $summ) {
        $customer = array('id' => $id);

        //кастомное поле для суммы за год
        $customer['customFields']['periodsumm'] = $summ;

        if ($summ >= 500000) {
            $customer['customFields']['customer_segment'] = 20;
        } elseif ($summ >= 200000) {
            $customer['customFields']['customer_segment'] = 15;
        } elseif ($summ >= 30000) {
            $customer['customFields']['customer_segment'] = 10;
        } else {
            $customer['customFields']['customer_segment'] = 0;
        }

        try {
            $api->customersEdit($customer, $by = 'id', '7718300028');
        } catch (\RetailCrm\Exception\CurlException $e) {
            echo "Connection error: " . $e->getMessage();
            continue;
        }

        time_nanosleep(0, 50000000);
    }
}