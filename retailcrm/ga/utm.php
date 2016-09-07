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
class utm
{
	public $retail;
	public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(__DIR__ . '/vendor/google/apiclient/client_secret_629195762039-hbi274i34gdu3j32fbdh2jc75r6ni9ri.apps.googleusercontent.com.json');
        $this->client->useApplicationDefaultCredentials();
        $this->client->setApplicationName('My cool application');
        $this->client->setAccessType('offline_access');
        $this->client->setScopes(['https://www.googleapis.com/auth/analytics']);

	    $this->retail = new \RetailCrm\ApiClient(
	    'https://mebelvia.retailcrm.ru',
	    'oYijxFlncids3VyRwUU3JVTa3X6FieZm'
		);
    }
	public function getGAOrders()
	    {
	        $analyticsService = new Google_Service_Analytics($this->client);
	        $data = $analyticsService->data_ga->get(
	            'ga:77804606',
	            '2016-01-25',
	            '2016-01-25',
	            'ga:transactions',
	            array(
	                'dimensions' => 'ga:transactionId,ga:campaign,ga:medium,ga:source',
	                /*'filters' => implode(',', array_map(array($this, 'getFilters'), $ids))*/
	            ));
	        $orders = array();
	        foreach ($data->getRows() as $order) {
	            $tmp = array(
	                'externalId'  => $order[0],
	                'customFields'=> array(
	                	'ucampaign'=> $order[1],
		                'umedium'    => $order[2],
		                'usource'    => $order[3]
	                )
	            );            
	            $orders[$order[0]] = $tmp;
	        }

	        return $orders;

	    /*private function getFilters($id)
	    {
	        return sprintf('ga:transactionId=@%s', $id);
	    }*/
	}
	
}
$utm = new utm();
$gadata = $utm->getGAOrders();
foreach ($gadata as $order) {
	$utm->retail->ordersEdit($order);
}