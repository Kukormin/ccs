<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');

$db_dtype = CSaleDelivery::GetList(
array(
"SORT" => "ASC",
),
array(
"ACTIVE" => "Y",
),
false,
false,
array('ID', 'NAME')
);

while ($ar_dtype = $db_dtype->Fetch()) {
    $arResult['arUser']['DELIVERY'][$ar_dtype['ID']] = $ar_dtype['NAME'];
}
