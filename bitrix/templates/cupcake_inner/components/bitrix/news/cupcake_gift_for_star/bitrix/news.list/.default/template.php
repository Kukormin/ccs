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
//print_r($arResult);

?>

<section class="b-topblock b-topblock--pay-ship">
</section>




<section class="b-bg-grey">
	<div class="b-content-center">
		<div class="b-content-center--title i-padding__top-100"> подарок для звезды</div>
		<div class="b-content-center--description">Мы всегда рады получать от вас послания с отзывами, комментариями, предложениями и пожеланиями! Смелей, напишите, что вы думаете о Cupcake Story и ваша весточка обязательно долетит до нас!  </div>

		<div class="b-category b-title--border-top">
			<ul class="b-category-list">
				<?foreach($arResult["ITEMS"] as $arItem):?>
					<?
					$birthday = $arItem['PROPERTIES']['BIRTHDAY']['VALUE'];
					$date = substr($birthday, 0, strrpos($birthday,'.'));
					$date = DateTime::createFromFormat('d.m', $date);
					$today = new DateTime();
					$interval = $date->diff($today);
					?>
					<li class="b-news__category-item b-content__category-item">
					<div class="b-news__category-img">
						<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt=""/>
						<? if($interval->format('%R%a') <= 7 && $interval->format('%R%a') >= 0) {?>
						<div class="b-category-img--str">скоро день рождения </div>
						<? } ?>
					</div>
					<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="b-category-item-name-st">
						<?echo $arItem["NAME"]?> <?=$arItem['PROPERTIES']['SURNAME']['VALUE']?>
					</a>
						<span class="b-category-item-profession-st">
							<?=$arItem['PROPERTIES']['STATUS']['VALUE']?>
						</span>
						<span class="b-category-item-content-st">
							<?=$arItem["PREVIEW_TEXT"];?>
						</span>
				</li>
				<?endforeach;?>
			</ul>
		</div>
	</div>
	<div class="b-content-center b-content-center--bottom i-padding-vert-30">
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<br /><?=$arResult["NAV_STRING"]?>
		<?endif;?>

		<a href="#" class="b-scroll-to-top">
		наверх
		</a>

	</div>

</section>

