<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @var string $strElementEdit */
/** @var string $strElementDelete */
/** @var array $arElementDeleteParams */
/** @var array $arSkuTemplate */
/** @var array $templateData */
global $APPLICATION;
?>


<? foreach ($arResult['ITEMS'] as $key => $arItem) {
    $res = CIBlockSection::GetByID($arItem["IBLOCK_SECTION_ID"]);
    if($ar_res = $res->GetNext())
if($arItem['PROPERTIES']['NEW']['VALUE'] == 'Да') {
?>
<div class="b-mod__item">
    <div class="b-mod__item-img">
        <div class="b-mod__item-img--effect-transform">
            <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="">
        </div>
        <div class="b-mod__item-label">новинка</div>
        <div class="basket-button"></div>
    </div>
    <div class="b-mod__item-title">
        <?=$arItem['NAME']?>
        <span><?=$ar_res['NAME']; ?></span>
    </div>
    <div class="b-mod__item-price"><?=$arItem['MIN_PRICE']['DISCOUNT_VALUE']?> <span class="rub">i</span> <span>/ 6 шт</span></div>
</div>
<?} }?>

