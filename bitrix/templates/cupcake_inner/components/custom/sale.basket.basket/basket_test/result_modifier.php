<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */

//инфоблоки, товары из которых не надо выводить стандартным методом
$hideItemsFrom = array(
	12, //коробки
	30, //коробки тортов
	37, //коробки для эклеров
);

$props_list = array();
$arResult['GROUPED_GOODS'] = [];

foreach ($arResult["GRID"]["ROWS"] as $k => $arItem) {

    $res = CCatalogSku::GetProductInfo($arItem['PRODUCT_ID']);
    if ($res) {
        $name =  CIBlockElement::GetByID($res['ID']);
		$arResult["GRID"]["ROWS"][$k]['PARENT_ITEM_ID'] = $res['ID'];
        while($ar_res = $name->GetNext()) {
			$arResult["GRID"]["ROWS"][$k]['PARENT_NAME'] = $ar_res['NAME'];
            $arResult["GRID"]["ROWS"][$k]['PARENT_IBLOCK_ID'] = $ar_res['IBLOCK_ID'];
        }
    }

    $result = CIBlockElement::GetByID($arItem['PRODUCT_ID']);
    while($acc_name = $result->GetNext()) {
        $acc_section_name = CIBlockSection::GetByID($acc_name["IBLOCK_SECTION_ID"]);
        if($ar_section = $acc_section_name->GetNext()) {
            $arResult["GRID"]["ROWS"][$k]['SECTION_NAME'] = $ar_section['NAME'];
            $arResult["GRID"]["ROWS"][$k]['SECTION_ID'] = $ar_section['ID'];
            $arResult["GRID"]["ROWS"][$k]['IBLOCK_ID'] = $ar_section['IBLOCK_ID'];
        }else{
            $arResult["GRID"]["ROWS"][$k]['IBLOCK_ID'] = $acc_name['IBLOCK_ID'];
        }
    }
	
	$groups_res = CIBlockElement::GetElementGroups($arItem['PRODUCT_ID']);
	$arResult["GRID"]["ROWS"][$k]['GROUPS'] = [];
	while ($gr = $groups_res->GetNext()){
		$arResult["GRID"]["ROWS"][$k]['GROUPS'][] = $gr['ID'];
	}
	if (isset($arResult["GRID"]["ROWS"][$k]['PARENT_ITEM_ID'])) {
		$groups_res = CIBlockElement::GetElementGroups($arResult["GRID"]["ROWS"][$k]['PARENT_ITEM_ID']);
		while ($gr = $groups_res->GetNext()){
			$arResult["GRID"]["ROWS"][$k]['GROUPS'][] = $gr['ID'];
		}
	}
    
    if (in_array($arResult["GRID"]["ROWS"][$k]['IBLOCK_ID'],$hideItemsFrom)) continue;
    
    $arFilter = array('CODE' => 'PACKAGE', 'IBLOCK_ID'=>isset($arResult["GRID"]["ROWS"][$k]['PARENT_IBLOCK_ID'])?$arResult["GRID"]["ROWS"][$k]['PARENT_IBLOCK_ID']:$arResult["GRID"]["ROWS"][$k]['IBLOCK_ID']);
    $res = CIBlockProperty::GetList(array(), $arFilter);
    if ($ob = $res->GetNext()) {
        $arResult["GRID"]["ROWS"][$k]['PACKAGES'] = $ob['LINK_IBLOCK_ID']; //id ��������� �������
    }
    
    foreach ($arItem['PROPS'] as $data) {
		$xblock = $arResult["GRID"]["ROWS"][$k]['PARENT_IBLOCK_ID']?$arResult["GRID"]["ROWS"][$k]['PARENT_IBLOCK_ID']:$arResult["GRID"]["ROWS"][$k]['IBLOCK_ID'];
        $props_list[$data['CODE'].$xblock] = array('CODE' => $data['CODE'], 'IBLOCK' => $xblock);
    }
    
    
    $parent = isset($arResult["GRID"]["ROWS"][$k]['PARENT_NAME'])?$arResult["GRID"]["ROWS"][$k]['PARENT_NAME']:$k;
    if (!$parent) $parent = 'single';
    $arResult['GROUPED_GOODS'][$parent][] = $k;
}

$arFilter = Array("IBLOCK_ID"=>16, "ACTIVE"=>"Y");
$res = CIBlockSection::GetList(Array(), $arFilter, false, Array());
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arResult['CATEGORY_LIST'][$arFields['ID']] = $arFields;
}

$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), array());
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $price = CPrice::GetList(array(), array("PRODUCT_ID" => $arFields['ID']));
    if ($ar_price = $price->Fetch())
    {
        $arFields['PRICE'] = $ar_price['PRICE'];
    }
    $arResult['CATEGORY_LIST'][$arFields['IBLOCK_SECTION_ID']]['ITEMS'][] = $arFields;
}

$arResult['PROPS'] = array();
foreach ($props_list as $prop) {
    $arFilter = array('CODE' => $prop['CODE'], 'IBLOCK_ID'=>$prop['IBLOCK']);
    
    $res = CIBlockProperty::GetList(array(), $arFilter);
    while($ob = $res->GetNext())
    {    

        $res2 = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>$ob['LINK_IBLOCK_ID']));
        while ($ob2 = $res2->GetNext()) {
            $el = CIBlockElement::GetProperty($ob['LINK_IBLOCK_ID'],$ob2['ID'], array('sort'=>'asc'), array('CODE'=>'CATEGORIES'));
			$sections = array();
			while ($item = $el->Fetch()){
				$sections[$item['VALUE']] = $item['VALUE'];
			}
			$ob2['SECTIONS'] = $sections;
            $arResult['PROPS'][$prop['IBLOCK']][$prop['CODE']][] = $ob2;
        }
    }
}
