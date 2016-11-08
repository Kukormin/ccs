<?

// Константы
require('const.php');

// Функции
require('functions.php');

// Классы
require('classes.php');

// Модули битрикса
\Bitrix\Main\Loader::IncludeModule('iblock');

// Обработчики событий
\Local\System\Handlers::addEventHandlers();

// TODO: мета теги og
/*
AddEventHandler('main','OnEpilog','onEpilog',1);
function onEpilog(){
	global $APPLICATION;
	$arPageProp=$APPLICATION->GetPagePropertyList();
	debugmessage($arPageProp);
	$arMetaPropName=array('og:title','og:description','og:url','og:image', 'fb:app_id');
	foreach ($arMetaPropName as $name){
		//$key=mb_strtoupper($name,'UTF-8');
		$key=mb_strtoupper($name);
		if (isset($arPageProp[$key])){
			//$APPLICATION->AddHeadString('<meta property="'.$name.'" content="'.htmlspecialchars($arPageProp[$key]).'">',$bUnique=true);
			$APPLICATION->AddHeadString('<meta property="'.$name.'" content="'.$arPageProp[$key].'">',$bUnique=true);
		}
	}
}
*/

