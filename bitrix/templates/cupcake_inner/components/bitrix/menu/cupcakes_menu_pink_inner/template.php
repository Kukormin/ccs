<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
foreach($arResult["ALL_ITEMS"] as $arColumns)
{
	$href = $arColumns["LINK"];
	$cur = $APPLICATION->GetCurPage();
	$active = $cur != '/' && strpos($cur, $href) === 0;
	$class = $active ? ' active' : '';
	$style = !empty($arColumns["PARAMS"]["IMG"]) ? ' style="background: url(' . $arColumns["PARAMS"]["IMG"] .
		') no-repeat center top;"' : '';

	?><li class="b-bottom-nav__item<?= $active ?>">
		<a href="<?= $href ?>"<?= $style ?> class="b-bottom-nav__link"><?= $arColumns["TEXT"] ?></a>
	</li><?
}
