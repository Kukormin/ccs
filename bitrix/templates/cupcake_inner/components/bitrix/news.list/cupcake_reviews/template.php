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

<div class="b-reviews-content b-title--border-top">
	<ul class="b-reviews__list">
		<?foreach($arResult["ITEMS"] as $arItem):?>
		<li class="b-reviews__item">
			<div class="b-reviews-date-post">
				<?echo $arItem["NAME"]?> / <?echo $arItem["PROPERTIES"]["PUBLICATION_DATE"]["VALUE"]?>
			</div>
			<div class="b-reviews-title">
				<?echo $arItem["PROPERTIES"]["REVIEW_TITLE"]["VALUE"]?>
			</div>
			<p>
				<?echo $arItem["PROPERTIES"]["FB_TEXT"]["VALUE"]["TEXT"]?>
			</p>
		</li>
		<?endforeach;?>
	</ul>
</div>
