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


define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule('iblock');

$oCIBlockProperty = new CIBlockProperty();
$oCIBlockPropertyEnum = new CIBlockPropertyEnum;

$sCode = 'HIT';
$sName = 'Хит';
$sXmlId = 'HIT_Y';

$arIblockFilter = array(
	'ID' => array(4,5,6,7,33,38,40),
);
$dbIb = CIBlock::GetList(
	Array(), 
	$arIblockFilter,
	false
);
while ($arIb = $dbIb->Fetch()) {
	
	$rsProps = CIBlockProperty::GetList(array(), array(
		'IBLOCK_ID' => $arIb['ID'],
		'CODE' => $sCode,
	));
	if ($arProp = $rsProps->Fetch()) {
		?>ИБ "<?=$arIb['NAME']?>": Свойство "<?=$sName?>" уже существует
		<?
	}
	else {
		$arFields = array(
			'MULTIPLE' => 'N',
			'ACTIVE' => 'Y',
			'NAME' => $sName,
			'CODE' => $sCode,
			'IBLOCK_ID' => $arIb['ID'],
			'PROPERTY_TYPE' => 'L',
			'LIST_TYPE' => 'C',
			'FILTRABLE' => 'Y',
			'SORT' => 700,
		);
		
		$oCIBlockProperty = new CIBlockProperty();
		$iPropId = $oCIBlockProperty->Add($arFields);

		if ($iPropId) {
			?>ИБ "<?=$arIb['NAME']?>": Добавлено свойство "<?=$sName?>"
			<?
		} else {
			?>ИБ "<?=$arIb['NAME']?>": Ошибка добавления свойства "<?=$sName?>"
			<?
		}
		
		if ($iPropId) {
			$dbEnums = CIBlockPropertyEnum::GetList(Array(), Array(
				'PROPERTY_ID' => $iPropId,
				'XML_ID' => $sXmlId,
			));
			if (!$dbEnums->Fetch()) {
				$arFields = array(
					'PROPERTY_ID' => $iPropId,
					'XML_ID' => $sXmlId,
					'VALUE' => "Да",
				);
				$iEnumId = $oCIBlockPropertyEnum->Add($arFields);
				if ($iEnumId) {
					?>Добавлен вариант значения свойства "<?=$sXmlId?>"
					<?
				}
				else {
					?>Ошибка добавления варианта значения свойства "<?=$sXmlId?>"
					<?
				}
			}
		}
	}
}
