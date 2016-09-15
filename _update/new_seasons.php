<?
if (!$_SERVER["DOCUMENT_ROOT"]) {
	error_reporting(0);
	setlocale(LC_ALL, 'ru.UTF-8');
	$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__) . "/..");
	$bConsole = true;
}
else {
	$bConsole = false;
}

// 1. ДОбавить ИБ сезонов

$oldCode = 'SEASON';
$newCode = 'SEASON_IB';


require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$iblock = new \CIBlock();
$iblockElement = new \CIBlockElement();
$iblockProperty = new \CIBlockProperty();

CModule::IncludeModule('highloadblock');
$hldata = Bitrix\Highloadblock\HighloadBlockTable::getById(8)->fetch();
$hlentity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
$hlDataClass = $hldata['NAME'].'Table';
$result = $hlDataClass::getList(array(
	'select' => array('ID', 'UF_NAME', 'UF_XML_ID'),
	'order' => array('UF_NAME' =>'ASC'),
));
$hlSeasons = array();
while($res = $result->fetch())
	$hlSeasons[$res['ID']] = $res;

$seasonsId = 0;
$dbIb = $iblock->GetList(
	Array(),
	Array(
		'CODE' => 'seasons',
	),
	false
);
while ($arIb = $dbIb->Fetch()) {
	$seasonsId = $arIb['ID'];
}

$items = array();
$rsItems = $iblockElement->GetList(array(), array(
	'IBLOCK_ID' => $seasonsId,
), false, false, array('ID', 'NAME', 'CODE'));
while ($arItem = $rsItems->Fetch())
{
	$items[$arItem['CODE']] = $arItem;
}

foreach ($hlSeasons as $season)
{
	$code = $season['UF_XML_ID'];
	if (!$items[$code])
	{
		$iblockElement->Add(array(
			'NAME' => $season['UF_NAME'],
			'CODE' => $code,
		    'IBLOCK_ID' => $seasonsId,
		));
	}
}

$newSeasonsByCode = array();
$rsItems = $iblockElement->GetList(array(), array(
	'IBLOCK_ID' => $seasonsId,
), false, false, array('ID', 'NAME', 'CODE'));
while ($arItem = $rsItems->Fetch())
{
	$newSeasonsByCode[$arItem['CODE']] = $arItem['ID'];
}

$dbIb = $iblock->GetList(
	Array(),
	Array(
		'TYPE' => 'catalog',
	),
	false
);
$catalogIds = array();
while ($arIb = $dbIb->Fetch())
{
	$ex = false;
	$dbProps = $iblockProperty->GetList(Array(), Array(
		'IBLOCK_ID' => $arIb['ID'],
		'CODE' => $oldCode,
	));
	if ($prop = $dbProps->Fetch()) {
		$catalogIds[] = $arIb['ID'];
		$ex = true;
	}

	if ($ex)
	{
		$dbProps = $iblockProperty->GetList(Array(), Array(
			'IBLOCK_ID' => $arIb['ID'],
			'CODE' => $newCode,
		));
		if ($prop = $dbProps->Fetch())
		{

		}
		else
		{
			$arFields = array(
				'IS_REQUIRED' => 'N',
				'MULTIPLE' => 'Y',
				'ACTIVE' => 'Y',
				'FILTRABLE' => 'Y',
				'NAME' => 'Сезон',
				'CODE' => $newCode,
				'IBLOCK_ID' => $arIb['ID'],
				'PROPERTY_TYPE' => 'E',
				'USER_TYPE' => 'EList',
				'LINK_IBLOCK_ID' => $seasonsId,
				'SORT' => 600,
			);
			$iPropId = $iblockProperty->Add($arFields);
		}
	}
}

$elements = array();
$cnt = 0;
$cnt1 = 0;

$rsItems = $iblockElement->GetList(array(), array(
	'IBLOCK_ID' => $catalogIds,
    //'ID' => 1047,
), false, false, array('ID', 'NAME', 'CODE', 'IBLOCK_ID'));
while ($ob = $rsItems->GetNextElement())
{
	$fields = $ob->GetFields();

	$id = $fields['ID'];
	if ($elements[$id])
		continue;

	$elements[$id] = true;

	$props = $ob->GetProperties();
	$oldValues = $props[$oldCode]['VALUE'];
	$newValues = $props[$newCode]['VALUE'];
	if ($oldValues && !$newValues)
	{
		$cnt++;
		$upd = array();
		foreach ($oldValues as $code)
		{
			$newId = $newSeasonsByCode[$code];
			if ($newId)
				$upd[] = $newId;
		}

		if ($upd)
		{
			$iblockElement->SetPropertyValues($id, $fields['IBLOCK_ID'], $upd, $newCode);
			$cnt1++;
		}

	}

}

echo ($cnt);
echo ($cnt1);


require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");

