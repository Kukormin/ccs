<?
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
$arDefaultParams = array(
	'TEMPLATE_THEME' => 'blue',
	'PRODUCT_DISPLAY_MODE' => 'N',
	'ADD_PICT_PROP' => '-',
	'LABEL_PROP' => '-',
	'OFFER_ADD_PICT_PROP' => '-',
	'OFFER_TREE_PROPS' => array('-'),
	'PRODUCT_SUBSCRIPTION' => 'N',
	'SHOW_DISCOUNT_PERCENT' => 'N',
	'SHOW_OLD_PRICE' => 'N',
	'ADD_TO_BASKET_ACTION' => 'ADD',
	'SHOW_CLOSE_POPUP' => 'N',
	'MESS_BTN_BUY' => '',
	'MESS_BTN_ADD_TO_BASKET' => '',
	'MESS_BTN_SUBSCRIBE' => '',
	'MESS_BTN_DETAIL' => '',
	'MESS_NOT_AVAILABLE' => '',
	'MESS_BTN_COMPARE' => ''
);
$arParams = array_merge($arDefaultParams, $arParams);

$main_section = [6, 7, 33];
$product_ids = [];
foreach($main_section as $ids) {


    $arIB = CCatalogSKU::GetInfoByProductIBlock($ids);
    $iblock_id = $arIB['IBLOCK_ID'];
    $prices = [];
    $el_id = [];
    if($arIB) {
        $result = CIBlockElement::GetList(Array(), Array('ACTIVE' => 'Y',"IBLOCK_ID" => $iblock_id), false, false, Array());
        while($arr = $result->GetNext())
        {
            $el_id[] = $arr['ID'];
        }
        $db_res = CPrice::GetList(
            array(),
            array(
                "PRODUCT_ID" => $el_id,
            )
        );

        while ($ar_res = $db_res->Fetch())
        {
            $prices[$ar_res['PRODUCT_ID']][] = $ar_res['PRICE'];
        }

    }
    $res = CIBlockElement::GetList(Array(), Array('ACTIVE' => 'Y',"IBLOCK_ID" => $ids), false, false, Array("ID", "NAME", "IBLOCK_ID","PREVIEW_PICTURE", "IBLOCK_NAME", "DETAIL_PICTURE", "DATE_CREATE", "CATALOG_GROUP_1", "OF_IBLOCK_ID", "DETAIL_PAGE_URL"));
    while($ar = $res->GetNext())
    {
        $prices_ib = array();
        $sku = CCatalogSKU::getOffersList([$ar['ID']]);
        foreach ($sku as $sku_items) {
            foreach ($sku_items as $id=>$n) {
                $prices_ib[] = $prices[$id][0];
            }
        }
        unset($sku);
        unset($sku_items);
        $ar['PRICE'] = isset($prices_ib[0]) ? $prices_ib[0] : $prices_ib[1];
        $arResult['ITEMS'][] = $ar;
        $product_ids[] = $ar['ID'];
    }
}


$sliced_arr = array_slice($arResult['ITEMS'], 0, 15);
$arResult['ITEMS'] = $sliced_arr;


?>