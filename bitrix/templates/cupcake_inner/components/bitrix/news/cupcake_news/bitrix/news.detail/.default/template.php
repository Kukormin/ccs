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

$APPLICATION->SetPageProperty("fb:app_id", '574393899375304');
$APPLICATION->SetPageProperty("og:title",$arResult['NAME']);
$APPLICATION->SetPageProperty("og:description",strip_tags($arResult["PREVIEW_TEXT"]));
$APPLICATION->SetPageProperty("og:url", 'http://'.SITE_SERVER_NAME.'/news/'.$arResult['CODE'].'/');

?>

<section class="b-topblock b-topblock--pay-ship">
</section>




<section class="b-bg-grey">
	<div class="b-content-center b-block-new">
		<div class="b-block-new--wrap i-padding__top-100">
			<a class="b-block-new__link" href="/news/">все новости </a>
			<h1><div class="b-block-new--title"> <?=$arResult["NAME"]?> </div></h1>
			<div class="b-block-new--date"> <?echo $arResult["PROPERTIES"]["publication_date"]["VALUE"]?></div>
			<div class="b-block-new-description"> <?echo $arResult["PREVIEW_TEXT"];?></div>
			<div class="b-block-new-content">
				<p><?echo $arResult["DETAIL_TEXT"];?></p>
			</div>
			<div class="b-block-social">
				<div class="b-block-social-title">
					поделиться ссылкой:
				</div>
				<ul class="b-social__list js-social-share">
					<li class="b-social__item"> <a data-share="vk" class="b-vk b-vk--dark" href="#"></a></li>
					<li class="b-social__item"> <a data-share="fb" class="b-f b-f--dark" href="#"></a></li>
					<li class="b-social__item"> <a data-share="tw" class="b-tw b-tw--dark" href="#"></a></li>
					<li class="b-social__item"> <a data-share="lj" class="b-live b-live--dark" href="#"></a></li>
					<li class="b-social__item"> <a data-share="gp" class="b-g b-g--dark" href="#"></a></li>
					<!--<li class="b-social__item"> <a class="b-pl" href="#"></a></li>-->
				</ul>
			</div>
		</div>
	</div>
</section>
