<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$element_id = [];

foreach($arResult["ITEMS"] as $key => $arItem) {
    $element_id = $arItem['PROPERTIES']['RELATED_ITEMS']['VALUE'];
    $element_id[] = $arItem['PROPERTIES']['RELATED_ITEMS_CAKES']['VALUE'];
    $element_id[] = $arItem['PROPERTIES']['RELATED_ITEMS_GINGER']['VALUE'];
    $element_id[] = $arItem['PROPERTIES']['RELATED_ITEMS_ECLAIR']['VALUE'];

    foreach($element_id as $ids) {
        $arFilter = Array("ID"=>$ids);
        $res = CIBlockElement::GetList(Array(), $arFilter);
        while ($ob = $res->GetNextElement()) {
            $arResult["ITEMS"][$key]['RELATED_ITEMS_INFO'][] = $ob->GetFields();
        }
    }
}

$arResult['TEMPLATE_NAME'] = 'cupcake_star_stories';

