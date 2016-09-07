<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

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
    //print_r($ar_dtype);
    $arResult['DELIVERY'][$ar_dtype['ID']] = $ar_dtype;
    foreach($arResult['DELIVERY'] as $k => $delivery) {
        $arResult['DELIVERY_PRICE_ARR'][$delivery['NAME']] = [$delivery['NAME'] => $delivery['PRICE']];
        $arResult['DELIVERY_TYPES_ARR'][$delivery['NAME']] = [$delivery['NAME'] => $k];
    }
}


// Выведем все активные платежные системы для текущего сайта, для типа плательщика с кодом 2, работающие с валютой RUR
$db_ptype = CSalePaySystem::GetList($arOrder = Array("SORT"=>"ASC", "PSA_NAME"=>"ASC"), Array("LID"=>SITE_ID, "CURRENCY"=>"RUB", "ACTIVE"=>"Y"));
while ($ptype = $db_ptype->Fetch())
{
    $arResult['PAYSYSTEM_UNAUTHED'][] = $ptype;
}


?>