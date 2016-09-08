<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (empty($_POST['NAME']) || empty($_POST['EMAIL']) || empty($_POST['PERSONAL_PHONE'])) die;

CModule::IncludeModule('sale');
$DELIVERY_ID = '';
$DELIVERY_PRICE = '';
$DELIVERY_PRICE_ARR = [];
$db_dtype = CSaleDelivery::GetList(
	array(
		"SORT" => "ASC",
	),
	array(
		"ACTIVE" => "Y",
	),
	false,
	false,
	array('*')
);

while ($ar_dtype = $db_dtype->Fetch()) {
	$DELIVERY_PRICE_ARR[$ar_dtype['ID']] = $ar_dtype['PRICE'];
}

$DELIVERY_PRICE = $DELIVERY_PRICE_ARR[$_POST['delivery_type']];


$USER_ID = IntVal($USER->GetID());
if($USER_ID == 0) {
	/*Create user ------------------------*/

	$obUser = new CUser;

	$arNames = $_POST["NAME"];

	//TrimArr($arNames);
	$userLogin = "client".time();
	$userPassw = GetRandomCode();
	$email = time()."@yahoo.com";
	$arFields = Array(
		"EMAIL"          => $email,
		"LOGIN"          => $userLogin,
		"LID"          => SITE_ID,
		"ACTIVE"       => "Y",
		"GROUP_ID"       => explode(",", COption::GetOptionString("main", "new_user_registration_def_group")),
		"PASSWORD"       => $userPassw,
		"CONFIRM_PASSWORD"  => $userPassw
	);

	$arFields["NAME"] = $arNames;

	$USER_ID = $obUser->Add($arFields);
	CUser::SendUserInfo($USER_ID, SITE_ID, "Приветствуем Вас как нового пользователя нашего сайта!");
	/*------------------------------------*/
} else {
	$USER_ID = IntVal($USER->GetID());
}

if($_POST['form_type'] == 'popup') {
	MOD_Add2BasketByProductID($_POST['product_id'], $_POST['quantity'], array(), false);
	$DELIVERY_PRICE = 0;
	$DELIVERY_TYPE = 15;
}

$dbBasketItems = CSaleBasket::GetList(
	array("NAME" => "ASC"),
	array(
		"FUSER_ID" => CSaleBasket::GetBasketUserID(),
		"LID" => s1,
		"ORDER_ID" => "NULL"
	),
	false,
	false,
	array("ID", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT", "NAME")
);

//считаем сумму заказа
while ($arBasketItems = $dbBasketItems->GetNext())
{
	if ($arBasketItems["DELAY"] == "N" && $arBasketItems["CAN_BUY"] == "Y")
	{
		$arBasketItems["PRICE"] = roundEx($arBasketItems["PRICE"], SALE_VALUE_PRECISION);
		$arBasketItems["QUANTITY"] = DoubleVal($arBasketItems["QUANTITY"]);
		$sumOrder += $arBasketItems["PRICE"] * $arBasketItems["QUANTITY"];
		$strOrderList .= $arBasketItems["NAME"]." - ".$arBasketItems["QUANTITY"]."\n";
	}
}

$DELIVERY_ADDRESS = '';
if($_POST['hidden_delivery_adress'] != '') {
	$DELIVERY_ADDRESS = $_POST['hidden_delivery_adress'];
} elseif($_POST['pickup_adr'] != '') {
	$DELIVERY_ADDRESS = $_POST['pickup_adr'];
}

$PRICE = $sumOrder + $DELIVERY_PRICE;
$arFields = array(
	"LID" => "s1",
	"PERSON_TYPE_ID" => 1,
	"PAYED" => "N",
	"CANCELED" => "N",
	"STATUS_ID" => "N",
	"PRICE" => $PRICE,
	"CURRENCY" => "RUB",
	"USER_ID" => $USER_ID,
	"PAY_SYSTEM_ID" => $_POST['PAY_SYSTEM_ID'],
	"PRICE_DELIVERY" => $DELIVERY_PRICE,
	"DELIVERY_ID" => !empty($DELIVERY_TYPE) ? $DELIVERY_TYPE : $_POST['delivery_type'],
	"TAX_VALUE" => 0.0,
	//"USER_DESCRIPTION" => "Дата и время доставки: ". $_POST['date']. " с " .$_POST['timefrom']." по ".$_POST['timeto'].". Комментарий: ".$_POST['COMMENT']
);

$ORDER_ID = CSaleOrder::Add($arFields);
$ORDER_ID = IntVal($ORDER_ID);
CSaleBasket::OrderBasket($ORDER_ID, CSaleBasket::GetBasketUserID(), SITE_ID);

$arFields = array(
	"ORDER_ID" => $ORDER_ID,
	"NAME" => "Имя",
	"ORDER_PROPS_ID" => 1,
	"VALUE" => $_POST["NAME"],
	'CODE' => 'FIO'
);
CSaleOrderPropsValue::Add($arFields);
$arFields = array(
	"ORDER_ID" => $ORDER_ID,
	"NAME" => "Email",
	"ORDER_PROPS_ID" => 2,
	"VALUE" => $_POST["EMAIL"],
	'CODE' => 'EMAIL'
);
CSaleOrderPropsValue::Add($arFields);
$arFields = array(
	"ORDER_ID" => $ORDER_ID,
	"NAME" => "Телефон",
	"ORDER_PROPS_ID" => 3,
	"VALUE" => $_POST["PERSONAL_PHONE"],
	'CODE' => 'PHONE'
);
CSaleOrderPropsValue::Add($arFields);
$arFields = array(
	"ORDER_ID" => $ORDER_ID,
	"NAME" => "Адрес",
	"ORDER_PROPS_ID" => 7,
	"VALUE" => $DELIVERY_ADDRESS,
	'CODE' => 'ADDRESS'
);
CSaleOrderPropsValue::Add($arFields);
$intervals = array(
	'с 10:00 по 13:00',
	'с 13:00 по 16:00',
	'с 16:00 по 20:00',
);
$GLOBALS['INTARO_CRM_ORDER_ADD_NEW'] = true;
CSaleOrder::Update($ORDER_ID, array("USER_DESCRIPTION" => "Дата и время доставки: ". $_POST['date']. " " .
	$intervals[$_POST['time_interval']] . ". Комментарий: ".$_POST['COMMENT']));
$GLOBALS['INTARO_CRM_ORDER_ADD_NEW'] = false;
/*$arEventFields = array(
    "ORDER_ID"                    => $ORDER_ID,
    "ORDER_DATE"                  => date("m.d.y"),
    "ORDER_USER"                  => $_POST["NAME"],
    "PRICE"                       => $PRICE." рублей",
    "EMAIL"                       => $_POST["EMAIL"],
    "ORDER_LIST"                  => $strOrderList,
    "SALE_EMAIL"                  => "sale@cupcake.ru"
);
CEvent::Send("SALE_NEW_ORDER", "s1", $arEventFields);*/
if($_POST['PAY_SYSTEM_ID'] == 2) {
	include($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sale_payment/payler/payment.php");
} else {
	LocalRedirect("/personal/final.php?id=" . $ORDER_ID . "&price=" . $PRICE);
}
