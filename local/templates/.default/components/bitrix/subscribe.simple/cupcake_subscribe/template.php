<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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
?>


	<a href="#" class="b-mailing__item-img b-mailing__item-img--subscribe">
		<img src="/bitrix/templates/.default/images/mail.png" alt="">
	</a>
	<form method="POST" action="<?echo $arResult["FORM_ACTION"]?>">
		<?foreach($arResult["RUBRICS"] as $arRubric):?>
			<div style="display: none;"><input name="RUB_ID[]" value="<?echo $arRubric["ID"]?>" id="RUB_<?echo $arRubric["ID"]?>" type="checkbox" <?=$arResult["RUBRICS"][0]["CHECKED"] == 1 ? '' : 'checked="checked"'?>><label for="RUB_<?echo $arRubric["ID"]?>"><?echo $arRubric["NAME"]?></label></div>
		<?endforeach?>
		<?echo bitrix_sessid_post();?>
		<span> Подписка на новости и акции<?=$arResult["RUBRICS"][0]["CHECKED"] == 1 ? ' ' : ' не '?>оформлена</span>
		<button class="b-bnt-form b-bnt-unsubscribe" type="submit" name="Update" value="<?=$arResult["RUBRICS"][0]["CHECKED"] == 1 ? 'Отписаться' : 'Подписаться'?>"><?=$arResult["RUBRICS"][0]["CHECKED"] == 1 ? 'Отписаться' : 'Подписаться'?></button>




