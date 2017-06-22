<?php

define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule('iblock');

$blockCode = "goodies";

$dbRes = CIBlock::GetList([],['CODE' => $blockCode]);
$iBlock = $iBlock = $dbRes->Fetch();

if(!$iBlock){
	$iBlock = new CIBlock();
	$arFieldsBlock = [
		'ACTIVE' => 'Y',
		'CODE' => $blockCode,
	    'IBLOCK_TYPE_ID' => 'new_catalog',
	    'NAME' => 'Вкусности',
	    'SITE_ID' => 's1'

	];
	$ID = $iBlock->Add($arFieldsBlock);

}else{
	$ID = $iBlock['ID'];
	echo 'Блок "Вкусности уже существует"<br>';
}

$props = new CIBlockProperty();
$arProps = [];
$dbRes = CIBlockProperty::GetList([],['IBLOCK_ID' => $ID]);
$arPropsCodes = ['PROPERTY' => 'Свойство','WEIGHT' => 'Вес','UNIT' => 'Еденица измерения'];

while ($prop = $dbRes->Fetch()){
	$arProps[$prop['CODE']] = $prop;
}

foreach ($arPropsCodes as $code => $name){
	if(isset($arProps[$code])){
		echo "Свойство '$name' уже существует<br>";
	}else{
		$props->Add([
			'NAME' => $name,
		    'ACTIVE' => 'Y',
		    'CODE' => $code,
		    'PROPERTY_TYPE' => 'S',
		    'IBLOCK_ID' => $ID,

		]);
	}
}

