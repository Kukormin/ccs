<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"].'/include/functions.php');

CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");

CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());

$data = $_POST['data'];

foreach ($data as $item) {
	$hasPackage = false;
	$item['props'] = json_decode($item['props']);
	
	foreach ($item['props'] as &$prop){
		$prop = (array)$prop;
		if ($prop['CODE'] == 'PACKAGE') {
			if ($prop['NAME'] == '') $prop['NAME'] = 'Коробка';
			$prop['SORT'] = MOD_Add2BasketByProductID($prop['PACK'], 1);
			unset($prop['PACK']);	
		}
	}
	$opts = array();
	if ($item['quantity']>1) $opts = array('ALLOW_DUBLICATE' => 'Y');
	MOD_Add2BasketByProductID($item['id'], $item['quantity'], $opts, $item['props']);
}

echo 1;