<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


CModule::IncludeModule('sale');
$arFields = array(
    "LID" => "s1",
    "PERSON_TYPE_ID" => 1,
    "PAYED" => "N",
    "CANCELED" => "N",
    "STATUS_ID" => "N",
    "PRICE" => $_POST['total_price'],
    "CURRENCY" => "RUB",
    "USER_ID" => IntVal($USER->GetID()),
    "PAY_SYSTEM_ID" => $_POST['PAY_SYSTEM_ID'],
    "PRICE_DELIVERY" => $_POST['delivery_price'],
    "TAX_VALUE" => 0.0,
    "USER_DESCRIPTION" => ""
);

$ORDER_ID = CSaleOrder::Add($arFields);
$ORDER_ID = IntVal($ORDER_ID);
CSaleBasket::OrderBasket($ORDER_ID, $_SESSION["SALE_USER_ID"], SITE_ID);


?>