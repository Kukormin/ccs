<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
?>
<?//print_r($arResult);?>
<div class="b-reviews-content b-title--border-top">
	<div class="b-reviews__list">
		<?foreach($arResult["ITEMS"] as $arItem):?>
		<div class="stat">
			<div class="b-reviews-title">
				<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
			</div>
			<p>
				<?echo $arItem["PREVIEW_TEXT"]?>
			</p>
			<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="moar">Подробнее..</a>
		</div>
		<?endforeach;?>
	</div>
</div>
