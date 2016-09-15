<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
global $APPLICATION;
if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
}
if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency)
	{
	?>
	<script type="text/javascript">
		BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
	</script>
<?
	}
}

if (!$arResult["ID"])
{
	$arTitleOptions = null;
	$ipropValues = new \Bitrix\Iblock\InheritedProperty\IblockValues($arParams["IBLOCK_ID"]);
	$val = $ipropValues->getValues();

	if ($val["SECTION_PAGE_TITLE"] != "")
		$APPLICATION->SetTitle($val["SECTION_PAGE_TITLE"], $arTitleOptions);

	if ($val["SECTION_META_TITLE"] != "")
		$APPLICATION->SetPageProperty("title", $val["SECTION_META_TITLE"], $arTitleOptions);

	if ($val["SECTION_META_KEYWORDS"] != "")
		$APPLICATION->SetPageProperty("keywords", $val["SECTION_META_KEYWORDS"], $arTitleOptions);

	if ($val["SECTION_META_DESCRIPTION"] != "")
		$APPLICATION->SetPageProperty("description", $val["SECTION_META_DESCRIPTION"], $arTitleOptions);

}
