<?php
$key = isset($_GET['IBLOCK_CODE'])?strtoupper($_GET['IBLOCK_CODE']):'MAIN';

if (isset($_GET['SECTION_CODE'])) {
    $rsSections = CIBlockSection::GetList(array(),array('IBLOCK_ID' => инфоблок, '=CODE' => 'код секции'));
    if ($arSection = $rsSections->Fetch())
    {
        $section = $arSection['ID'];
    }
} else {
    $section = 0;
}

foreach ($arResult["ITEMS"] as $id=>$arItem) {
    if (
        ($section && in_array($section, $arItem['PROPERTIES']['DISPLAY_'.$key]['VALUE'])) 
        || 
        (($key=='MAIN' && !$section) || $arItem['PROPERTIES']['DISPLAY_'.$key.'_MAIN']['VALUE'] == 'Да')
       )
         { /* */
    } else {
        unset($arResult["ITEMS"][$id]);
    }
}