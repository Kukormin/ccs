<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (CModule::IncludeModule('sale')) {
    $count = 0;
    $dbBasketItems = CSaleBasket::GetList(
        array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL"
        ),
        false,
        false,
        array("ID", "QUANTITY", "PRICE")
    );
    
    while ($arItems = $dbBasketItems->Fetch())
    {
        
        if (strlen($arItems["CALLBACK_FUNC"]) > 0)
        {
             CSaleBasket::UpdatePrice($arItems["ID"], 
                                      $arItems["QUANTITY"]);
             $arItems = CSaleBasket::GetByID($arItems["ID"]);
        }

        $arBasketItems[] = $arItems;
    }

    $summ = 0;

    foreach ($arBasketItems as $item) {
        $count += $item["QUANTITY"];
        $summ = $summ + $item["PRICE"]*$item["QUANTITY"];

    }
    
    header('Content-type: application/json;');
    echo json_encode(array('SUM'=>$summ, 'COUNT'=>$count));
}