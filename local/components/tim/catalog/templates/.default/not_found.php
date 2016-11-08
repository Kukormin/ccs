<?
use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);

// TODO: все строки в языковой файл

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 */

?>
<div class="catalog">
	<h1>По вашему запросу ничего не найдено</h1><?

	$APPLICATION->IncludeFile(
		SITE_TEMPLATE_PATH . '/include_areas/' . LANGUAGE_ID . '/mustlike.php',
		array(),
		array(
			"MODE"      => "html",
			"TEMPLATE"  => "include.php",
			"NAME"      => "Могут понравиться"
		)
	);

	?>
</div>
