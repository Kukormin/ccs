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
	<div class="b-content-center b-news">
		<h1><div class="b-content-center--title i-padding__top-100"> новости</div></h1>
		

		<div class="b-category b-title--border-top">
			<ul class="b-category-list js-ajax-content-block">
				<?foreach($arResult["ITEMS"] as $arItem):?>
					<li class="b-news__category-item">
						<div class="b-news__category-img b-mod__item-img--effect-transform">
							<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>">
								<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="" />
							</a>
						</div>
						<span class="b-news__category-date"><?echo $arItem["PROPERTIES"]["publication_date"]["VALUE"]?></span>
						<a class="b-news__category-link" href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
					</li>
				<?endforeach;?>
			</ul>
		</div>
	</div>



</section>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
