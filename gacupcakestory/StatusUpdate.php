<?php
use TheIconic\Tracking\GoogleAnalytics\Analytics;
class StatusUpdate
{
    private $history = array();
    private $fullHistory = array();
    private $api;
    private $client;

    public function __construct($history = array(), $api, $fullHistory = array())
    {
        $this->fullHistory = $fullHistory;
        $this->api = $api;
        $this->client = new Google_Client();
        $this->client->setAuthConfig(__DIR__ . '/vendor/google/apiclient/client_secret_629195762039-hbi274i34gdu3j32fbdh2jc75r6ni9ri.apps.googleusercontent.com.json');
        $this->client->useApplicationDefaultCredentials();
        $this->client->setApplicationName('My cool application');
        $this->client->setAccessType('offline_access');
        $this->client->setScopes(['https://www.googleapis.com/auth/analytics']);
    }
    private function getData() 
    {
        if (empty($this->fullHistory)) {
            return array();
        }
        $orders = $this->api->ordersList(array('numbers' => array_keys($this->fullHistory)), null, 100);
        $statuses = array();
        $statuses = $this->api->statusGroupsList();
        $gadata = $this->getGAOrders(array_keys($this->fullHistory));
        $fullh = $this->fullHistory;
        $orders_indexes = array();
        
        foreach ($orders['orders'] as $order) {
            $orders_indexes[$order['number']] = $order;
            if(count($order['items']) <= 0){
                continue;
            }
            if(!in_array($order['number'], array_keys($gadata["orders"])) && ($order['orderMethod'] == 'callback' || $order['fromApi'] == false)) {
                    $analytics = new Analytics();
                    $analytics->setProtocolVersion('1')
                    ->setTrackingId('UA-44854874-1')
                    ->setDocumentPath('/');
                    if(isset($order['customFields']['clientid'])){
                        $analytics->setClientId($order['customFields']['clientid']);
                    } else {
                        $analytics->setClientId($order['customer']['id']);
                    }
                    foreach ($order['items'] as $item) {
                            $productData = array(
                                'sku' => $item['offer']['externalId'],
                                'name' => $item['offer']['name'],
                                'quantity' => $item['quantity']
                            );
                            $analytics->addProduct($productData);
                    }
                    $analytics->setProductActionToPurchase();
                    $analytics->setTransactionId($order['number']);
                    $analytics->setEventCategory('Checkout')
                    ->setEventAction('Purchase');
                    $analytics->sendEvent();
                    unset($analytics);
            } else if (in_array($order['status'], $statuses['statusGroups']['cancel']['statuses'])) {
                   $analytics = new Analytics();
                   $analytics->setProtocolVersion('1')
                   ->setTrackingId('UA-44854874-1')
                   ->setDocumentPath('/');
                   if(isset($order['customFields']['clientid'])){
                        $analytics->setClientId($order['customFields']['clientid']);
                    } else {
                        $analytics->setClientId($order['customer']['id']);
                    }
                    $analytics->setEventCategory('Ecommerce')
                    ->setEventAction('Refund');
                    $analytics->setTransactionId($order['number']);
                    $analytics->setProductActionToRefund();
                    $analytics->sendEvent();
                    unset($analytics);
            }
            else {
                foreach ($orders_indexes as $index=>$order) {
                  foreach ($fullh[$index]['items'] as $item) {
                    if(in_array($item['id'], array_keys($gadata["items"]))){
                        if($item['deleted'] == true || $item['isCanceled'] == true){
                            $analytics = new Analytics();
                            $analytics->setProtocolVersion('1')
                            ->setTrackingId('UA-44854874-1');
                            if(isset($order['customFields']['clientid'])){
                                $analytics->setClientId($order['customFields']['clientid']);
                            } else {
                                $analytics->setClientId($order['customer']['id']);
                            }
                            $productData = array(
                                'sku' => $item['id'],
                                'name' => $gadata["items"][$item['id']]['productName'],
                                'quantity' => $gadata["items"][$item['id']]['quantity']
                            );
                            $analytics->addProduct($productData);
                            $analytics->setEventCategory('Ecommerce')
                            ->setEventAction('Refund');
                            $analytics->setTransactionId($order['number']);
                            $analytics->setProductActionToRefund();
                            $analytics->sendEvent();
                            unset($analytics);
                        } elseif($item['quantity']!=$gadata["items"][$item['id']]['count']){
                            $count = $item['quantity'] - $gadata["items"][$item['id']]['count'];
                            $analytics = new Analytics();
                            $analytics->setProtocolVersion('1')
                            ->setTrackingId('UA-44854874-1')
                            ->setDocumentPath('/');
                            if(isset($order['customFields']['clientid'])){
                                $analytics->setClientId($order['customFields']['clientid']);
                            } else {
                                $analytics->setClientId($order['customer']['id']);
                            }
                            $analytics->setItemName($item['offer']['name'])
                            ->setItemQuantity($count)
                            ->setItemPrice($item['initialPrice'])
                            ->setItemCode($item['offer']['externalId']);
                            $analytics->sendItem();
                            unset($analytics);
                        }
                    }
                  }  
                }
            }
        }
    }
    public function execute()
    {
        $this->getData();
    }

    public function getGAOrders($ids = array())
    {
        $items = $this->getGAItems($ids);

        $analyticsService = new Google_Service_Analytics($this->client);

        $data = $analyticsService->data_ga->get(
            'ga:77804606',
            '100daysAgo',
            'today',
            'ga:transactions',
            array(
                'dimensions' => 'ga:transactionId',
                'filters' => implode(',', array_map(array($this, 'getFilters'), $ids))
            ));
        $orders = array();
        foreach ($data->getRows() as $order) {
            $tmp = array(
                'externalId' => $order[0]
                /*'tax'        => $order[1],
                'shipping'   => $order[2]*/
            );
            
            foreach ($items as $item) {
                if ($item['transactionId'] == $order[0]) {
                    unset($item['transactionId']);
                    $tmp['items'][] = $item;
                }
            }
            $orders[$order[0]] = $tmp;
        }

        return array("orders"=>$orders, "items"=>$items);
    }

    private function getGAItems($ids = array())
    {
        $analyticsService = new Google_Service_Analytics($this->client);

        $data = $analyticsService->data_ga->get(
            'ga:77804606',
            '100daysAgo',
            'today',
            'ga:itemRevenue,ga:itemQuantity',
            array(
                'dimensions' => 'ga:transactionId,ga:productSku,ga:productName',
                'filters' => implode(',', array_map(array($this, 'getFilters'), $ids))
            ));

        $items = array();
        foreach ($data->getRows() as $item) {
            $items[$item[1]] = array(
                'transactionId' => $item[0],
                'productId'     => $item[1],
                'initialPrice'  => $item[3],
                'quantity'      => $item[4],
                'productName'   => $item[2],
            );
        }
        return $items;
    }

    private function getFilters($id)
    {
        return sprintf('ga:transactionId=@%s', $id);
    }
}