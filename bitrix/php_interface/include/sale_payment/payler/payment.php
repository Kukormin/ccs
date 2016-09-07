<?if ( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true ) die();

CModule::IncludeModule('currency');
CModule::IncludeModule('sale');
include dirname(__FILE__) . "/payler.classes.php";
include( GetLangFileName(dirname(__FILE__) . "/", "/payment.php") );
include( GetLangFileName(dirname(__FILE__) . "/", "/codes.php") );

function _getExplodeMoney($s,$m){
	@list($r,$k) = explode(".",$s);
	if($m) return (int) $k; else return (int) $r;
}

function _covert2utf($s){
	if(SITE_CHARSET!='UTF-8') return iconv(SITE_CHARSET, "UTF-8", $s); else return $s;
}

function genOrderId($oid,$sum){
	$result = $oid."-".md5(randString(18));
	$arOrder = CSaleOrder::GetByID($oid);
	if ($arOrder)
	{
	   $arFields = array(
	      "PAY_VOUCHER_NUM"=>$result,
	      "PS_STATUS_MESSAGE"=>$result,
	     // "PAY_VOUCHER_DATE"=>date("Y:m:d H:i:s"),
	      "PS_STATUS"=>"N",
	      "PS_STATUS_CODE"=>"NEW",
	      "PS_STATUS_DESCRIPTION"=>GetMessage("PS_STATUS_CREATED"),
	      "PS_CURRENCY"=>GetMessage("PS_CURRENCY_PAYLER"),
	      "PS_RESPONSE_DATE"=>date("d.m.Y H:i:s"),
	      //"SUM_PAID"=>$sum,
	   );
	   CSaleOrder::Update($oid, $arFields);
	}
	return $result;
}


/*if(isset($arResult['ORDER_ID'])){
	$ORDER_ID = $arResult['ORDER_ID'];
}elseif(isset($arResult['ID'])){
    $ORDER_ID = $arResult['ID'];
}else{
    $ORDER_ID = IntVal($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["ID"]);
};*/
//print_r($ORDER_ID);
$arOrder = CSaleOrder::GetByID($ORDER_ID);





$current_price = _getExplodeMoney($arOrder["PRICE"],false) * CCurrencyRates::GetConvertFactor($arOrder["CURRENCY"], 'RUB') * 100 + _getExplodeMoney($arOrder["PRICE"],true);


$arBasketItems = array();
$arItemNames = "";
$arItemCounts = 0;
$dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC","ID" => "ASC"), array("LID" => SITE_ID, "ORDER_ID" => $ORDER_ID), false, false, array("NAME","QUANTITY"));
while ($arItems = $dbBasketItems->Fetch()) $arBasketItems[] = $arItems;

foreach ( $arBasketItems as $arItem )
{
	$arItemCounts = $arItemCounts + $arItem['QUANTITY'];
	$arItemNames[] = $arItem["NAME"];
}
$arItemNames = implode(", ",$arItemNames);


$db_ptype = CSalePaySystem::GetList($arOrder = Array("SORT"=>"ASC", "PSA_NAME"=>"ASC"), Array("PERSON_TYPE_ID"=>"1","ACTIVE"=>"Y"));
while ($ptype = $db_ptype->Fetch())
{
    if($ptype["PSA_ACTION_FILE"]=="/bitrix/php_interface/include/sale_payment/payler") $arPaySys = unserialize($ptype["PSA_PARAMS"]);
}

$option = array(
    "DEBUG"=>$arPaySys["PAYLER_DEBUG"]["VALUE"],
    "KEY"=>$arPaySys["PAYLER_KEY"]["VALUE"],
    "PASSWORD"=>$arPaySys["PAYLER_PASSWORD"]["VALUE"],
    "TYPE"=>$arPaySys["PAYLER_TYPE"]["VALUE"],
    "ORDER_LIST"=>$arPaySys["PAYLER_ORDER_LIST"]["VALUE"],
    "ORDER_DETAIL"=>$arPaySys["PAYLER_ORDER_DETAIL"]["VALUE"],
    "ORDER_SUCCESS"=>$arPaySys["PAYLER_ORDER_SUCCESS"]["VALUE"],
    "ORDER_ERROR"=>$arPaySys["PAYLER_ORDER_ERROR"]["VALUE"],
);
if($option["DEBUG"]=="Y") $option["DEBUG"] = true; else $option["DEBUG"] = false;
if($arOrder["PAYED"] == "Y") header("Location: ".str_replace("#ID#",$ORDER_ID,$option["ORDER_DETAIL"]));

/* Payler API */
$payler = new CPayler($option["DEBUG"]);
$data = array(
	"key"=> $option['KEY'],
	"type"=> $option['TYPE'],
	"order_id"=>genOrderId($ORDER_ID,$current_price),
	"amount"=>$current_price,
	"product"=>_covert2utf(TruncateText($arItemNames,240)),
	"total"=>$arItemCounts,
);

$session_data = $payler->POSTtoGateAPI($data, "StartSession");
$session_id = $session_data['session_id'];
var_dump($session_id);

if ($session_id == null) {
	$error_message = '';
	if($session_data['error']) {
		$error_message = ' (ошибка: '.$session_data['error']['code'].')';
	}
	die ('Ошибка инициализации сессии'.$error_message.'.<br>Если ошибка повторяется - обратитесь, пожалуйста, в службу поддержки магазина или на 24@payler.com');
}

$pay = $payler->Pay($session_id);

?>
<html>
<head>
<title>Loading...</title>
<script src="http://yandex.st/jquery/2.1.1/jquery.min.js"></script>
<style>
</style>
</head>
<body>
<?=$pay;?>

<script>$(document).ready(function(){$("#submit").click()})</script>
</body>
</html>

