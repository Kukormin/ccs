<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */

?>
<div class="b-slider-wrap">
<?foreach($arResult["ITEMS"] as $arItem):?>
    <?if($arItem['PROPERTIES']['MAIN_OUTPUT']['VALUE'] == 'Да'):?>
<div class="b-slider__item b-slider__item--mobile">
    <div class="b-slider__content">
        <div class="b-slider__title">
            <?=$arItem['NAME']?> <?=$arItem['PROPERTIES']['SURNAME']['VALUE']?>
        </div>
        <div class="b-slider__desc"> <?=$arItem['PROPERTIES']['STATUS']['VALUE']?></div>
        <div class="b-slider__text">
            <?=$arItem['DETAIL_TEXT']?>
        </div>
    </div>
    <div class="b-slider__img">
        <img src="<?=CFile::GetPath($arItem['PROPERTIES']['MAIN_ANNOUNCE']['VALUE'])?>" alt=""/>
    </div>
    <div class="b-slider-favorite">
        <div class="b-slider-favorite-label">я люблю</div>
        <div class="b-slider-favorite__list">
            <?foreach($arItem['RELATED_PRODUCTS'] as $like_items) { ?>
                <div class="b-slider-favorite__item">
                    <div class="b-slider-favorite-img">
                        <a href="<?=$like_items['DETAIL_PAGE_URL']?>">
                            <img src="<?=$like_items['PREVIEW_PICTURE']?>" width="120" height="90"/>
                        </a>
                    </div>
                        <span class="b-slider-favorite-desc">
                            <a href="<?=$like_items['DETAIL_PAGE_URL']?>">
                                <?=$like_items['NAME']?>
                            </a>
                        </span>
                </div>
            <? } ?>
        </div>
    </div>
</div>
        <?endif;?>
<?endforeach;?>
</div>