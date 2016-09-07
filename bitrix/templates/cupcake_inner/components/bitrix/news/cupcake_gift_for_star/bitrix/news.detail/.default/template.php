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


<section class="b-topblock b-topblock--pay-ship">
</section>


<section class="b-bg-grey">
	<div class="b-content-center">
		<div class="b-block-page-gift">
			<div class="b-block-page-gift--img">
				<img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt=""/>
			</div>
			<a class="b-block-new__link" href="/gift_for_star">все звезды </a>
			<div class="b-content-center--title"> <?echo $arResult["NAME"]?> <?=$arResult['PROPERTIES']['SURNAME']['VALUE']?></div>
				<span class="b-category-item-profession-st">
					<?=$arResult['PROPERTIES']['STATUS']['VALUE']?>
				</span>
			<div class="b-content-center--description i-margin-0 i-padding-0"><?echo $arResult["PREVIEW_TEXT"];?>  </div>
				<span class="b-category-item-content-st">
					<?echo $arResult["DETAIL_TEXT"];?>
				</span>
		</div>




