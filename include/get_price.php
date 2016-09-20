<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (CModule::IncludeModule('sale')) {
    $count = 0;
    $dbBasketItems = CSaleBasket::GetList(
        array(),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL"
        ),
        false,
        false
    );
    
    while ($arItems = $dbBasketItems->Fetch())
    {
        if (strlen($arItems["CALLBACK_FUNC"]) > 0)
        {
             CSaleBasket::UpdatePrice($arItems["ID"], 
                                      $arItems["QUANTITY"]);
             $arItems = CSaleBasket::GetByID($arItems["ID"]);
        }

	    $rsProps = CSaleBasket::GetPropsList(array(), array("BASKET_ID" => $arItems['ID'], 'CODE' => 'PACKAGE'));
	    $props = array();
	    if ($prop = $rsProps->Fetch())
	    {
		    $pack = \Local\Package::getById($prop['SORT']);
		    if (!$pack)
		    {
			    $iblockId = 0;
			    $res = CCatalogSku::GetProductInfo($arItems['PRODUCT_ID']);
			    if ($res) {
				    $parent =  CIBlockElement::GetByID($res['ID']);
				    while($ar_res = $parent->GetNext())
					    $iblockId = $ar_res['IBLOCK_ID'];
			    }
			    if (!$iblockId)
			    {
				    $product = CIBlockElement::GetByID($arItems['PRODUCT_ID']);
				    while($ar_res = $product->GetNext())
					    $iblockId = $ar_res['IBLOCK_ID'];
			    }
			    if ($iblockId)
				    $pack = \Local\Package::getByName($prop['VALUE'], $iblockId);
		    }

		    if ($pack)
			    $arItems['PRICE'] += $pack['PRICE'];
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