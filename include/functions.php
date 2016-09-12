<?

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Iblock;

/**
 * @param int $PRODUCT_ID
 * @param float|int $QUANTITY
 * @param array $arRewriteFields
 * @param bool|array $arProductParams
 * @return bool|int
 */
function MOD_Add2BasketByProductID($PRODUCT_ID, $QUANTITY = 1, $arRewriteFields = array(), $arProductParams = false)
{
	global $APPLICATION;

	/* for old use */
	if ($arProductParams === false)
	{
		$arProductParams = $arRewriteFields;
		$arRewriteFields = array();
	}

	$boolRewrite = (!empty($arRewriteFields) && is_array($arRewriteFields));

	if ($boolRewrite && isset($arRewriteFields['SUBSCRIBE']) && $arRewriteFields['SUBSCRIBE'] == 'Y')
	{
		return SubscribeProduct($PRODUCT_ID, $arRewriteFields, $arProductParams);
	}

	$PRODUCT_ID = (int)$PRODUCT_ID;
	if ($PRODUCT_ID <= 0)
	{
		$APPLICATION->ThrowException(Loc::getMessage('CATALOG_ERR_EMPTY_PRODUCT_ID'), "EMPTY_PRODUCT_ID");
		return false;
	}

	$QUANTITY = (float)$QUANTITY;
	if ($QUANTITY <= 0)
		$QUANTITY = 1;

	if (!Loader::includeModule("sale"))
	{
		$APPLICATION->ThrowException(Loc::getMessage('CATALOG_ERR_NO_SALE_MODULE'), "NO_SALE_MODULE");
		return false;
	}

	if (Loader::includeModule("statistic") && isset($_SESSION['SESS_SEARCHER_ID']) && (int)$_SESSION["SESS_SEARCHER_ID"] > 0)
	{
		$APPLICATION->ThrowException(Loc::getMessage('CATALOG_ERR_SESS_SEARCHER'), "SESS_SEARCHER");
		return false;
	}

	// Продукт
	$rsProducts = CCatalogProduct::GetList(
		array(),
		array('ID' => $PRODUCT_ID),
		false,
		false,
		array(
			'ID',
			'CAN_BUY_ZERO',
			'QUANTITY_TRACE',
			'QUANTITY',
			'WEIGHT',
			'WIDTH',
			'HEIGHT',
			'LENGTH',
			'TYPE',
			'MEASURE'
		)
	);
	if (!($arCatalogProduct = $rsProducts->Fetch()))
	{
		$APPLICATION->ThrowException(Loc::getMessage('CATALOG_ERR_NO_PRODUCT'), "NO_PRODUCT");
		return false;
	}

	// Единицы измерения
	$arCatalogProduct['MEASURE'] = (int)$arCatalogProduct['MEASURE'];
	$arCatalogProduct['MEASURE_NAME'] = '';
	$arCatalogProduct['MEASURE_CODE'] = 0;
	if ($arCatalogProduct['MEASURE'] <= 0)
	{
		$arMeasure = CCatalogMeasure::getDefaultMeasure(true, true);
		$arCatalogProduct['MEASURE_NAME'] = $arMeasure['~SYMBOL_RUS'];
		$arCatalogProduct['MEASURE_CODE'] = $arMeasure['CODE'];
	}
	else
	{
		$rsMeasures = CCatalogMeasure::getList(
			array(),
			array('ID' => $arCatalogProduct['MEASURE']),
			false,
			false,
			array('ID', 'SYMBOL_RUS', 'CODE')
		);
		if ($arMeasure = $rsMeasures->GetNext())
		{
			$arCatalogProduct['MEASURE_NAME'] = $arMeasure['~SYMBOL_RUS'];
			$arCatalogProduct['MEASURE_CODE'] = $arMeasure['CODE'];
		}
	}

	// Проверка доступного количества (нужна ли?)
	$dblQuantity = (float)$arCatalogProduct["QUANTITY"];
	$boolQuantity = ($arCatalogProduct["CAN_BUY_ZERO"] != 'Y' && $arCatalogProduct["QUANTITY_TRACE"] == 'Y');
	if ($boolQuantity && $dblQuantity <= 0)
	{
		$APPLICATION->ThrowException(Loc::getMessage('CATALOG_ERR_PRODUCT_RUN_OUT'), "PRODUCT_RUN_OUT");
		return false;
	}
	$resQuantity = ($boolQuantity && $dblQuantity < $QUANTITY ? $dblQuantity : $QUANTITY);

	// Товар в инфоблоке
	$rsItems = CIBlockElement::GetList(
		array(),
		array(
			"ID" => $PRODUCT_ID,
			"ACTIVE" => "Y",
			"ACTIVE_DATE" => "Y",
			"CHECK_PERMISSIONS" => "Y",
			"MIN_PERMISSION" => "R",
		),
		false,
		false,
		array(
			"ID",
			"IBLOCK_ID",
			"XML_ID",
			"NAME",
			"DETAIL_PAGE_URL",
		)
	);
	if (!($arProduct = $rsItems->GetNext()))
	{
		$APPLICATION->ThrowException(Loc::getMessage('CATALOG_ERR_NO_IBLOCK_ELEMENT'), "NO_IBLOCK_ELEMENT");
		return false;
	}

	// Цена
	$strCallbackFunc = "";
	$strProductProviderClass = "CCatalogProductProvider";

	if ($boolRewrite)
	{
		if (isset($arRewriteFields['CALLBACK_FUNC']))
			$strCallbackFunc = $arRewriteFields['CALLBACK_FUNC'];
		if (isset($arRewriteFields['PRODUCT_PROVIDER_CLASS']))
			$strProductProviderClass = $arRewriteFields['PRODUCT_PROVIDER_CLASS'];
	}

	$arCallbackPrice = false;
	if (!empty($strProductProviderClass))
	{
		if ($productProvider = CSaleBasket::GetProductProvider(array(
			'MODULE' => 'catalog',
			'PRODUCT_PROVIDER_CLASS' => $strProductProviderClass))
		)
		{
			$providerParams = array(
				'PRODUCT_ID' => $PRODUCT_ID,
				'QUANTITY' => $QUANTITY,
				'RENEWAL' => 'N'
			);
			$arCallbackPrice = $productProvider::GetProductData($providerParams);
			unset($providerParams);
		}
	}
	elseif (!empty($strCallbackFunc))
	{
		$arCallbackPrice = CSaleBasket::ExecuteCallbackFunction(
			$strCallbackFunc,
			'catalog',
			$PRODUCT_ID,
			$QUANTITY,
			'N'
		);
	}
	if (empty($arCallbackPrice) || !is_array($arCallbackPrice))
	{
		$APPLICATION->ThrowException(Loc::getMessage('CATALOG_PRODUCT_PRICE_NOT_FOUND'), "NO_PRODUCT_PRICE");
		return false;
	}
	else
	{
		if (isset($arCallbackPrice['RESULT_PRICE']))
		{
			$arCallbackPrice['BASE_PRICE'] = $arCallbackPrice['RESULT_PRICE']['BASE_PRICE'];
			$arCallbackPrice['PRICE'] = $arCallbackPrice['RESULT_PRICE']['DISCOUNT_PRICE'];
			$arCallbackPrice['DISCOUNT_PRICE'] = $arCallbackPrice['RESULT_PRICE']['DISCOUNT'];
			$arCallbackPrice['CURRENCY'] = $arCallbackPrice['RESULT_PRICE']['CURRENCY'];
		}
		else
		{
			if (!isset($arCallbackPrice['BASE_PRICE']))
				$arCallbackPrice['BASE_PRICE'] = $arCallbackPrice['PRICE'] + $arCallbackPrice['DISCOUNT_PRICE'];
		}
	}

	$arProps = array();

	$strIBlockXmlID = (string)CIBlock::GetArrayByID($arProduct['IBLOCK_ID'], 'XML_ID');
	if ($strIBlockXmlID !== '')
	{
		$arProps[] = array(
			'NAME' => 'Catalog XML_ID',
			'CODE' => 'CATALOG.XML_ID',
			'VALUE' => $strIBlockXmlID
		);
	}

	// add sku props
	$arParentSku = CCatalogSku::GetProductInfo($PRODUCT_ID, $arProduct['IBLOCK_ID']);
	if (!empty($arParentSku))
	{
		if (strpos($arProduct["~XML_ID"], '#') === false)
		{
			$parentIterator = Iblock\ElementTable::getList(array(
				'select' => array('ID', 'XML_ID'),
				'filter' => array('ID' => $arParentSku['ID'])
			));
			if ($parent = $parentIterator->fetch())
			{
				$arProduct["~XML_ID"] = $parent['XML_ID'].'#'.$arProduct["~XML_ID"];
			}
			unset($parent, $parentIterator);
		}
	}

	// Упаковка
    $hasPackage = false;
	// Подготовка свойств
	if (!empty($arProductParams) && is_array($arProductParams))
	{
		foreach ($arProductParams as &$arOneProductParams)
		{
			$arProps[] = array(
				"NAME" => $arOneProductParams["NAME"],
				"CODE" => $arOneProductParams["CODE"],
				"VALUE" => $arOneProductParams["VALUE"],
				"SORT" => $arOneProductParams["SORT"]
			);
            if ($arOneProductParams["CODE"] == 'PACKAGE') $hasPackage = true;
		}
		unset($arOneProductParams);
	}

	if (!$hasPackage) {
		$check = !empty($arParentSku)?$arParentSku['IBLOCK_ID']:$arProduct['IBLOCK_ID'];
		$arFilter = array('CODE' => 'PACKAGE', 'IBLOCK_ID'=>$check);
		$res = CIBlockProperty::GetList(array(), $arFilter);
		if ($ob = $res->GetNext()) {

			$elements = CIBlockElement::GetList(array('catalog_PRICE_1'=>'asc'), array(
				'IBLOCK_ID'=>$ob['LINK_IBLOCK_ID'],
				"ACTIVE"=>"Y"
			));
			if ($el = $elements->GetNextElement()) {
				$pack = $el->GetFields();
				$arProps[] = array(
					"NAME" => 'Коробка',
					"CODE" => 'PACKAGE',
					"VALUE" => $pack['NAME'],
					"SORT" => $pack['ID'],
				);
			}
		}
	}

	$arProps[] = array(
		"NAME" => "Product XML_ID",
		"CODE" => "PRODUCT.XML_ID",
		"VALUE" => $arProduct["~XML_ID"]
	);

	$arFields = array(
		"PRODUCT_ID" => $PRODUCT_ID,
		"PRODUCT_PRICE_ID" => $arCallbackPrice["PRODUCT_PRICE_ID"],
		"BASE_PRICE" => $arCallbackPrice["BASE_PRICE"],
		"PRICE" => $arCallbackPrice["PRICE"],
		"DISCOUNT_PRICE" => $arCallbackPrice["DISCOUNT_PRICE"],
		"CURRENCY" => $arCallbackPrice["CURRENCY"],
		"WEIGHT" => $arCatalogProduct["WEIGHT"],
		"DIMENSIONS" => serialize(array(
			"WIDTH" => $arCatalogProduct["WIDTH"],
			"HEIGHT" => $arCatalogProduct["HEIGHT"],
			"LENGTH" => $arCatalogProduct["LENGTH"]
		)),
		"QUANTITY" => $resQuantity,
		"LID" => SITE_ID,
		"DELAY" => "N",
		"CAN_BUY" => "Y",
		"NAME" => $arProduct["~NAME"],
		"MODULE" => "catalog",
		"PRODUCT_PROVIDER_CLASS" => "CCatalogProductProvider",
		"NOTES" => $arCallbackPrice["NOTES"],
		"DETAIL_PAGE_URL" => $arProduct["~DETAIL_PAGE_URL"],
		"CATALOG_XML_ID" => $strIBlockXmlID,
		"PRODUCT_XML_ID" => $arProduct["~XML_ID"],
		"VAT_INCLUDED" => $arCallbackPrice['VAT_INCLUDED'],
		"VAT_RATE" => $arCallbackPrice['VAT_RATE'],
		"PROPS" => $arProps,
		"TYPE" => ($arCatalogProduct["TYPE"] == CCatalogProduct::TYPE_SET) ? CCatalogProductSet::TYPE_SET : NULL,
		"MEASURE_NAME" => $arCatalogProduct['MEASURE_NAME'],
		"MEASURE_CODE" => $arCatalogProduct['MEASURE_CODE']
	);

	if ($boolRewrite)
	{
		$arFields = array_merge($arFields, $arRewriteFields);
	}

	$result = MOD_BasketAdd($arFields);
	if ($result)
	{
		if (Loader::includeModule("statistic"))
			CStatistic::Set_Event("sale2basket", "catalog", $arFields["DETAIL_PAGE_URL"]);

		// Перенес добавление коробки выше
        /*if (!$hasPackage) {
            $check = !empty($arParentSku)?$arParentSku['IBLOCK_ID']:$arProduct['IBLOCK_ID'];
            $arFilter = array('CODE' => 'PACKAGE', 'IBLOCK_ID'=>$check);
            $res = CIBlockProperty::GetList(array(), $arFilter);
            if ($ob = $res->GetNext()) {

                $arFilter = array('IBLOCK_ID'=>$ob['LINK_IBLOCK_ID'], "ACTIVE"=>"Y");
                $elements = CIBlockElement::GetList(array('catalog_PRICE_1'=>'asc'), $arFilter);
                if ($el = $elements->GetNextElement()) {
                    $elFields = $el->GetFields();
                    $bid = MOD_Add2BasketByProductID($elFields['ID'], 1);
                    $data = array();
                    $arProps[] = array(
                        "NAME" => 'Коробка',
                        "CODE" => 'PACKAGE',
                        "VALUE" => $elFields['NAME'],
                        "SORT" => $bid
                    );
                    $data['PROPS'] = $arProps;
                    CSaleBasket::Update($result, $data);
                }
            }
        }*/
	}
    
    

	return $result;
}


function MOD_BasketAdd($arFields)
{
    global $DB, $APPLICATION;

    if (isset($arFields["ID"]))
        unset($arFields["ID"]);

    $isOrderConverted = 'N';//\Bitrix\Main\Config\Option::get("main", "~sale_converted_15", 'N');

    CSaleBasket::Init();
    if (!CSaleBasket::CheckFields("ADD", $arFields))
        return false;

    if (!array_key_exists('IGNORE_CALLBACK_FUNC', $arFields) || 'Y' != $arFields['IGNORE_CALLBACK_FUNC'])
    {
        if ((array_key_exists("CALLBACK_FUNC", $arFields) && !empty($arFields["CALLBACK_FUNC"]))
            || (array_key_exists("PRODUCT_PROVIDER_CLASS", $arFields) && !empty($arFields["PRODUCT_PROVIDER_CLASS"]))
        )
        {
            /** @var $productProvider IBXSaleProductProvider */
            if ($productProvider = CSaleBasket::GetProductProvider(array("MODULE" => $arFields["MODULE"], "PRODUCT_PROVIDER_CLASS" => $arFields["PRODUCT_PROVIDER_CLASS"])))
            {
                $providerParams = array(
                    "PRODUCT_ID" => $arFields["PRODUCT_ID"],
                    "QUANTITY" => $arFields["QUANTITY"],
                    "RENEWAL" => $arFields["RENEWAL"],
                    "USER_ID" => (isset($arFields["USER_ID"]) ? $arFields["USER_ID"] : 0),
                    "SITE_ID" => (isset($arFields["LID"]) ? $arFields["LID"] : false),
                );
                if (isset($arFields['NOTES']))
                    $providerParams['NOTES'] = $arFields['NOTES'];

                if (!($productProvider::GetProductData($providerParams)))
                {
                    return false;
                }
            }
            else
            {
                if (!(CSaleBasket::ExecuteCallbackFunction(
                    $arFields["CALLBACK_FUNC"],
                    $arFields["MODULE"],
                    $arFields["PRODUCT_ID"],
                    $arFields["QUANTITY"],
                    $arFields["RENEWAL"],
                    $arFields["USER_ID"],
                    $arFields["LID"]
                )))
                {
                    return false;
                }
            }
        }
    }

    if ($isOrderConverted != "Y")
    {
        foreach(GetModuleEvents("sale", "OnBeforeBasketAdd", true) as $arEvent)
            if (ExecuteModuleEventEx($arEvent, Array(&$arFields))===false)
                return false;
    }

    $bFound = false;
    $bEqAr = false;

    //TODO: is order converted?
    if ($isOrderConverted == "Y")
    {
        /** @var \Bitrix\Sale\BasketItem $basketItem */
        if (!($basketItem = \Bitrix\Sale\Compatible\BasketCompatibility::add($arFields)))
        {
            $APPLICATION->ThrowException(Localization\Loc::getMessage('BT_MOD_SALE_BASKET_ERR_ID_ABSENT'), "BASKET_ITEM");
            return false;
        }

        $ID = $basketItem->getId();
        $arFields['QUANTITY'] = $basketItem->getQuantity();
    }
    else
    {
	    $xml = $arFields['PRODUCT_XML_ID'];
	    $tmp = explode('#', $xml);
	    $parentId = $tmp[0];

        $boolProps = (!empty($arFields["PROPS"]) && is_array($arFields["PROPS"]));

        if (!isset($arFields['ALLOW_DUBLICATE']) || $arFields['ALLOW_DUBLICATE'] != 'Y') {
            // check if this item is already in the basket
            $arDuplicateFilter = array(
                "FUSER_ID" => $arFields["FUSER_ID"],
                "LID" => $arFields["LID"],
                "ORDER_ID" => "NULL"
            );

            if (!(isset($arFields["TYPE"]) && $arFields["TYPE"] == CSaleBasket::TYPE_SET))
            {
                if (isset($arFields["SET_PARENT_ID"]))
                    $arDuplicateFilter["SET_PARENT_ID"] = $arFields["SET_PARENT_ID"];
                else
                    $arDuplicateFilter["SET_PARENT_ID"] = "NULL";
            }

            $db_res = CSaleBasket::GetList(
                array(),
                $arDuplicateFilter,
                false,
                false,
                array("ID", "QUANTITY", "PRODUCT_XML_ID", "PRODUCT_ID")
            );
            while($res = $db_res->Fetch())
            {
                if(!$bEqAr)
                {
                    $xml = $res['PRODUCT_XML_ID'];
	                $tmp = explode('#', $xml);
	                $oldParentId = $tmp[0];

	                $bEqAr = $oldParentId == $parentId;

                    if ($bEqAr)
                    {
                        $ID = $res["ID"];
                        $arFields["QUANTITY"] += $res["QUANTITY"];
                        CSaleBasket::Update($ID, $arFields);
                        $bFound = true;
                        continue;
                    }
                }
            }
        }
    }

    if (!$bFound)
    {
        //TODO: is order converted?
        if ($isOrderConverted != "Y")
        {
            $arInsert = $DB->PrepareInsert("b_sale_basket", $arFields);

            $strSql = "INSERT INTO b_sale_basket(".$arInsert[0].", DATE_INSERT, DATE_UPDATE) VALUES(".$arInsert[1].", ".$DB->GetNowFunction().", ".$DB->GetNowFunction().")";
            $DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);

            $ID = intval($DB->LastID());

            $boolOrder = false;
            if (isset($arFields['ORDER_ID']))
            {
                $boolOrder = (0 < (int)$arFields['ORDER_ID']);
            }

            if (!$boolOrder && !CSaleBasketHelper::isSetItem($arFields))
            {
                $siteID = (isset($arFields["LID"])) ? $arFields["LID"] : SITE_ID;
                $_SESSION["SALE_BASKET_NUM_PRODUCTS"][$siteID]++;
            }

            if ($boolProps)
            {
                foreach ($arFields["PROPS"] as &$prop)
                {
                    if ('' != $prop["NAME"])
                    {
                        $arInsert = $DB->PrepareInsert("b_sale_basket_props", $prop);

                        $strSql = "INSERT INTO b_sale_basket_props(BASKET_ID, ".$arInsert[0].") VALUES(".$ID.", ".$arInsert[1].")";
                        $DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);
                    }
                }
                if (isset($prop))
                    unset($prop);
            }

            // if item is set parent
            if (isset($arFields["TYPE"]) && $arFields["TYPE"] == CSaleBasket::TYPE_SET)
            {
                CSaleBasket::Update($ID, array("SET_PARENT_ID" => $ID));

                if (!isset($arFields["MANUAL_SET_ITEMS_INSERTION"])) // set items will be added separately (from admin form data)
                {
                    /** @var $productProvider IBXSaleProductProvider */
                    if ($productProvider = CSaleBasket::GetProductProvider($arFields))
                    {
                        if (method_exists($productProvider, "GetSetItems"))
                        {
                            $arSets = $productProvider::GetSetItems($arFields["PRODUCT_ID"], CSaleBasket::TYPE_SET, array('BASKET_ID' => $ID));

                            if (is_array($arSets))
                            {
                                foreach ($arSets as $arSetData)
                                {
                                    foreach ($arSetData["ITEMS"] as $setItem)
                                    {
                                        $setItem["SET_PARENT_ID"] = $ID;
                                        $setItem["LID"] = $arFields["LID"];
                                        $setItem["QUANTITY"] = $setItem["QUANTITY"] * $arFields["QUANTITY"];
                                        $setItem['FUSER_ID'] = $arFields['FUSER_ID'];
                                        CSaleBasket::Add($setItem);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($boolOrder)
        {
            CSaleOrderChange::AddRecord(
                $arFields["ORDER_ID"],
                "BASKET_ADDED",
                array(
                    "PRODUCT_ID" => $arFields["PRODUCT_ID"],
                    "NAME" => $arFields["NAME"],
                    "QUANTITY" => $arFields["QUANTITY"]
                )
            );
        }
    }

    if ($isOrderConverted != "Y")
    {
        foreach(GetModuleEvents("sale", "OnBasketAdd", true) as $arEvent)
            ExecuteModuleEventEx($arEvent, Array($ID, $arFields));
    }

    return $ID;
}