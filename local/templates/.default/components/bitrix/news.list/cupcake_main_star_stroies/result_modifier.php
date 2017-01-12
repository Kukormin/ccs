<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */

foreach($arResult["ITEMS"] as $key => $arItem) {
	foreach ($arItem['PROPERTIES']['RELATED_PRODUCTS']['VALUE'] as $productId)
		$arResult["ITEMS"][$key]['RELATED_PRODUCTS'][] = \Local\Catalog\Products::getById($productId);
}

