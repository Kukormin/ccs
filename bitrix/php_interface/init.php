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

// Модуль ИБ в основном всегда нужен
\Bitrix\Main\Loader::includeModule('iblock');

CModule::AddAutoloadClasses(
	'',
	array(
		'Local\\StaticCache' => '/bitrix/php_interface/lib/StaticCache.php',
		'Local\\ExtCache' => '/bitrix/php_interface/lib/ExtCache.php',
		'Local\\Package' => '/bitrix/php_interface/lib/Package.php',
	)
);

function intarocrm_before_order_send($resOrder){
	if(!CModule::IncludeModule("sale") || !CModule::IncludeModule("intaro.intarocrm") || empty($resOrder))
	  return false;
/*$f = fopen($_SERVER["DOCUMENT_ROOT"]."/OrderUpl.txt", "a+");
fwrite($f, print_r(array(date('Y-m-d H:i:s'),$resOrder,$_SESSION['retailcrm']),true));
fclose($f); 
  	if (isset($_SESSION['retailcrm']['utm_source'])) {
	    $resOrder['source']['source'] = $_SESSION['retailcrm']['utm_source'];
	    $resOrder['customFields']['usource'] = $_SESSION['retailcrm']['utm_source'];
	}
	if (isset($_SESSION['retailcrm']['utm_medium'])){
	    $resOrder['source']['medium'] = $_SESSION['retailcrm']['utm_medium'];
	    $resOrder['customFields']['umedium'] = $_SESSION['retailcrm']['utm_medium'];
	}
	if (isset($_SESSION['retailcrm']['utm_campaign'])) {
	    $resOrder['source']['campaign'] = $_SESSION['retailcrm']['utm_campaign'];
	    $resOrder['customFields']['ucampaign'] = $_SESSION['retailcrm']['utm_campaign'];
	}
	if (isset($_SESSION['retailcrm']['utm_term'])){
	    $resOrder['customFields']['uterm'] = $_SESSION['retailcrm']['utm_term'];
	}
	if (isset($_SESSION['retailcrm']['utm_content'])) {
	    $resOrder['customFields']['ucontent'] = $_SESSION['retailcrm']['utm_content'];
	}
	unset($_SESSION['retailcrm']);
$f = fopen($_SERVER["DOCUMENT_ROOT"]."/OrderUpl.txt", "a+");
fwrite($f, print_r(array(date('Y-m-d H:i:s'),$resOrder),true));
fclose($f); */
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
// UA
/*global $APPLICATION;
$ua = "
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-66662174-1', 'auto');
  function getRetailCrmCookie(name) {
        var matches = document.cookie.match(new RegExp(
            '(?:^|; )' + name + '=([^;]*)'
        ));
        return matches ? decodeURIComponent(matches[1]) : '';
  }
  ga('set', 'dimension1', getRetailCrmCookie('_ga'));
  ga('send', 'pageview');
";
if (isset($_GET['id'])) {
    $ua .= "
  ga('require', 'ecommerce', 'ecommerce.js');
  ga('ecommerce:addTransaction', {
      'id': {$_GET['id']}
  });
  ga('ecommerce:send');
";
}
$ua .= "</script>";
$APPLICATION->AddHeadString($ua);*/