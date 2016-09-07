<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');
/*
$arFields = CSaleBasket::GetByID(298);
print_r($arFields);

$db_res = CSaleBasket::GetPropsList(
    array(
            "SORT" => "ASC",
            "NAME" => "ASC"
        ),
    array("BASKET_ID" => $arFields['ID'])
);
$props = array();
while ($ar_res = $db_res->Fetch())
{
    $props[] = $ar_res;
}

print_r($props);*/
/*
$arFields = CSaleBasket::GetByID(298);
print_r($arFields);

$data = array(
    'CUSTOM_PRICE' => 'Y',
    'PRICE' => 4500,
    'BASE_PRICE' => 4500
);
CSaleBasket::Update(298, $data);

$arFields = CSaleBasket::GetByID(298);
print_r($arFields);
*/