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

<div class="b-category b-title--border-top">
				<div class="b-title-page-gift">
подарок для звезды
</div>

				<div class="b-mod b-mod--page-gift-st">
                    <? foreach ($arResult['ITEMS'] as $key => $arItem) {
                        if($arItem['PROPERTIES']['STAR_GIFT']['VALUE'] == 'Да') {
                        ?>
                    <div class="b-mod__item b-mod__item-page-gift">
                        <div class="b-mod__item-img">
                            <div class="b-mod__item-img--effect-transform">
                                <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="">
                            </div>
                            <div class="basket-button details-button"></div>
                        </div>
                        <div class="b-mod__item-title">
                            <?=$arItem['NAME']?>
                        </div>
                        <div class="b-mod__item-price">1 200 P <span>/ 6 шт</span></div>
                    </div>
                   <? } }?>

                </div>
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
