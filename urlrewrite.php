<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/catalog/([^/]+?)/([^/]+?)/(\\d+)\\??(.*)#",
		"RULE" => "IBLOCK_CODE=\$1&SECTION_CODE=\$2&ELEMENT_ID=\$3&\$4",
		"ID" => "",
		"PATH" => "/catalog/detail.php",
	),
	array(
		"CONDITION" => "#^/catalog/([^/]+?)/([^/]+?)/\\??(.*)#",
		"RULE" => "IBLOCK_CODE=\$1&SECTION_CODE=\$2&\$3",
		"ID" => "",
		"PATH" => "/catalog/list.php",
	),
	array(
		"CONDITION" => "#^/catalog/([^/]+?)/\\??(.*)#",
		"RULE" => "IBLOCK_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/catalog/index.php",
	),
	array(
		"CONDITION" => "#^/bitrix/services/ymarket/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/bitrix/services/ymarket/index.php",
	),
	array(
		"CONDITION" => "#^/season/(.+?)/\\??(.*)#",
		"RULE" => "FILTER=\$1&\$2",
		"ID" => "",
		"PATH" => "/season/index.php",
	),
	array(
		"CONDITION" => "#^/personal/order/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.order",
		"PATH" => "/personal/order/index.php",
	),
	array(
		"CONDITION" => "#^/stati/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/stati/index.php",
	),
	array(
		"CONDITION" => "#^/store/#",
		"RULE" => "",
		"ID" => "bitrix:catalog.store",
		"PATH" => "/store/index.php",
	),
	array(
		"CONDITION" => "#^/news/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/news/index.php",
	),
);

?>