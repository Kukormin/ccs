<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('sale');
$item = CSaleBasket::GetByID($_GET['ID']);

echo $item['PRICE']*$item['QUANTITY'];