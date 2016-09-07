<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

$res = CIBlockSection::GetList(Array(), Array('ACTIVE' => 'Y', "IBLOCK_ID" => 5, 'ID'=> 63), true, Array("NAME", "DESCRIPTION", "SECTION_PAGE_URL", "UF_DISPLAY_MAIN_BOX", "PICTURE"));
while($ar = $res->GetNext())
{
    $ar['SECTION_PAGE_URL'] = '/happybox/';
    $ar['UF_DISPLAY_MAIN'] = $ar['UF_DISPLAY_MAIN_BOX'];
    $ar['PICTURE'] = CFile::GetFileArray($ar['PICTURE']);
    $arResult['SECTIONS'][] = $ar;
}
