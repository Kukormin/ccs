<?php
set_time_limit(0);
require_once('bootstrap.php');

$apiKey = "xCQ6xmYWuC5FaiQ4E7ZkLvtRylQycv50";
$apiUrl = "https://cupcakestory.retailcrm.ru";

$api = new \RetailCrm\ApiClient($apiUrl, $apiKey);

try {
    $customersPage = 1;
    $customersList = array();

    do {
        $response = $api->customersList(array(), $customersPage);
        $customersPage++;

        if (!is_null($response) && count($response['customers'])) {
            foreach ($response['customers'] as $customer) {
                $api->customersEdit(array(
                    'id' => $customer['id'],
                    'customFields' => array(
                        'periodsumm' => 0,
                        'customer_segment' => 0,
                    )
                ), $by = 'id', '7718300028');
            }
        } else {
            break;
        }
    } while ($response['pagination']['currentPage'] != $response['pagination']['totalPageCount']);
} catch (\RetailCrm\Exception\CurlException $e) {
    echo "Connection error: " . $e->getMessage();
    die();
}