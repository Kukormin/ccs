<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


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
        $userLogin = "fastorder".time();
        $userPassw = GetRandomCode();
        $userEmail = GetRandomCode()."@mail.com";

        $arFields = Array(
            "EMAIL"          => $userEmail,
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
    "PAY_SYSTEM_ID" => 1,
    "PRICE_DELIVERY" => $DELIVERY_PRICE,
    "DELIVERY_ID" => $_POST['delivery_type'],
    "TAX_VALUE" => 0.0,
    //"USER_DESCRIPTION" => ""
);

$ORDER_ID = CSaleOrder::Add($arFields);
$ORDER_ID = IntVal($ORDER_ID);
CSaleBasket::OrderBasket($ORDER_ID, $_SESSION["SALE_USER_ID"], SITE_ID);
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
    "NAME" => "Телефон",
    "ORDER_PROPS_ID" => 3,
    "VALUE" => $_POST["PERSONAL_PHONE"],
    'CODE' => 'PHONE'
);
CSaleOrderPropsValue::Add($arFields);

$arEventFields = array(
    "ORDER_ID"                    => $ORDER_ID,
    "ORDER_DATE"                  => date("m.d.y"),
    "ORDER_USER"                  => $_POST["NAME"],
    "PRICE"                       => $PRICE." рублей",
    "EMAIL"                       => $_POST["EMAIL"],
    "ORDER_LIST"                  => $strOrderList,
    "SALE_EMAIL"                  => "sale@cupcake.ru"
);
$GLOBALS['INTARO_CRM_ORDER_ADD_NEW'] = true;
CSaleOrder::Update($ORDER_ID, array("USER_DESCRIPTION" => ""));
$GLOBALS['INTARO_CRM_ORDER_ADD_NEW'] = false;
CEvent::Send("SALE_NEW_ORDER", "s1", $arEventFields);
LocalRedirect("/personal/final.php?id=".$ORDER_ID."&price=".$PRICE);

?>