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
<?$flag = true;
foreach($arResult["ITEMS"] as $k => $arItem):?>
    <div class="b-method-shipping-input js_radio_input">
        <input class="radio" name="address" type="radio" id="pickup<?=$k?>" data-addr="<?=$arItem['PROPERTIES']['PICKUP_ADR']['VALUE']?>" data-price="0" data-id="самовывоз" data-deltype="15" <?//=$flag ? 'checked' : ''?>/>
        <label class="b-label-radio" for="pickup<?=$k?>"><?=$arItem['PROPERTIES']['PICKUP_ADR']['VALUE']?>, Время работы: <?=$arItem['PROPERTIES']['SCHEDULE']['VALUE']?> </label>
    </div>
    <? $flag = false; ?>
<?endforeach;?>
