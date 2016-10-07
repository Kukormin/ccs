<?
AddEventHandler('main','OnEpilog','onEpilog',1);
function onEpilog(){
	global $APPLICATION;
	$arPageProp=$APPLICATION->GetPagePropertyList();
	$arMetaPropName=array('og:title','og:description','og:url','og:image', 'fb:app_id');
	foreach ($arMetaPropName as $name){
		//$key=mb_strtoupper($name,'UTF-8');
		$key=mb_strtoupper($name);
		if (isset($arPageProp[$key])){
			//$APPLICATION->AddHeadString('<meta property="'.$name.'" content="'.htmlspecialchars($arPageProp[$key]).'">',$bUnique=true);
			$APPLICATION->AddHeadString('<meta property="'.$name.'" content="'.$arPageProp[$key].'">',$bUnique=true);
		}
	}
}

//
// Меняем Фамилию на Имя, если Имя не заполнено
// (по-умолчанию если в ФИО одно слово - считается, что это Фамилия)
//
AddEventHandler('main', 'OnAfterUserAdd', 'afterUserAdd');
function afterUserAdd(&$arFields)
{
	$ID = intval($arFields['ID']);
	if ($ID > 0)
	{
		if (!$arFields['NAME'] && $arFields['LAST_NAME'])
		{
			$user = new \CUser();
			$user->Update($ID, array(
				'NAME' => $arFields['LAST_NAME'],
				'LAST_NAME' => '',
			));
		}
	}
}

// Модуль ИБ в основном всегда нужен
\Bitrix\Main\Loader::includeModule('iblock');

CModule::AddAutoloadClasses(
	'',
	array(
		'Local\\StaticCache' => '/bitrix/php_interface/lib/StaticCache.php',
		'Local\\ExtCache' => '/bitrix/php_interface/lib/ExtCache.php',
		'Local\\Package' => '/bitrix/php_interface/lib/Package.php',
		'Local\\Remarketing' => '/bitrix/php_interface/lib/Remarketing.php',
		'Local\\Savings' => '/bitrix/php_interface/lib/Savings.php',
	)
);

function intarocrm_before_order_send($resOrder){
	if(!CModule::IncludeModule("sale") || !CModule::IncludeModule("intaro.intarocrm") || empty($resOrder))
	  return false;
	if($resOrder['delivery']['cost']){
		$arOrder = CSaleOrder::GetByID($resOrder['externalId']);
		if($arOrder["DELIVERY_ID"] && $arOrder["DELIVERY_ID"]!=''){
			$arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
			$resOrder['delivery']['cost'] = $arDeliv["PRICE"];
		}
	}

	if(preg_match("/(\d{2}\.\d{2}\.\d{4}) с (\d{2}:\d{2}) по (\d{2}:\d{2})/", $resOrder['customerComment'], $match)) {
		$resOrder['delivery']['date'] = $match[1];
		$resOrder['delivery']['address']['deliveryTime'] = 'с ' . $match[2] . ' до ' . $match[3];
	}

	return $resOrder;
}
