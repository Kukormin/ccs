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
	<div class="b-content-center b-questions-answers">
		<div class="b-questions-answers-block-top i-padding__top-100">
			<a class="b-questions-answers__link" href="/">назад </a>
			<div class="b-questions-answers--title"> вопросы и ответы</div>
		</div>
		<div class="b-questions-answers-content b-title--border-top">
			<div id="questions-answers" class="questions-answers_wrap">
<?foreach($arResult["ITEMS"] as $arItem):?>
<div class="questions-answers_title"> <?echo $arItem["PROPERTIES"]["Q_TEXT"]["VALUE"]?></div>
<div class="questions-answers-sub_nav">
	<p><?echo $arItem["PROPERTIES"]["A_TEXT"]["VALUE"]["TEXT"]?></p>
</div>
<?endforeach;?>
</div>
</div>

</div>
</section>




