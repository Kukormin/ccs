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


<div class="b-slider b-slider--stories">
    <div class="b-slider-wrap--stories">

        <?foreach($arResult["ITEMS"] as $arItem):?>
        <div class="b-slider__item b-slider__item--mobile b-slider-stories__item" data-url="<?=CFile::GetPath($arItem['PROPERTIES']['BACKGROUND_PHOTO']['VALUE'])?>">
            <div class="b-slider-stories__right-block">
                <div class="b-slider-stories__content-top">
                    <div class="b-slider-stories__title " >
                        <?=$arItem['NAME']?><br/><?=$arItem['PROPERTIES']['SURNAME']['VALUE']?>
                    </div>
                    <div class="b-slider-stories__desc"> <?=$arItem['PROPERTIES']['STATUS']['VALUE']?></div>
                </div>
                <div class="b-slider-stories__img-photo">
					<noindex><a target="_blank "href="<?=$arItem['PROPERTIES']['INSTAGRAM_URL']['VALUE']?>" rel="nofollow"><div class="b-slider-stories__icon-photo"></div></a></noindex>
                    <img src="<?=CFile::GetPath($arItem['PROPERTIES']['INSTAGRAM_IMG']['VALUE'])?>" alt=""/>
                </div>

                <div class="b-slider__img b-slider-stories__img "  >
                    <img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt=""/>
                </div>
            </div>

            <div class="b-slider-favorite b-slider-stories-wrap">
                <div class="b-slider-stories__text "  >
<?
$replace = [
    '</a>' => '',
    ];

$content = str_replace(array_keys($replace), $replace, $arItem['DETAIL_TEXT']);
$content = $content = preg_replace('/(<a [^\>]*>)/', '',  $content);
?>
                    <?=$content?>
                </div>
                <div class="b-slider-favorite-label">я люблю</div>
                <div class="b-slider-favorite__list">
                    <?foreach($arItem['RELATED_PRODUCTS'] as $like_items) { ?>
                    <div class="b-slider-favorite__item">
                        <div class="b-slider-favorite-img">
                            <a href="<?=$like_items['DETAIL_PAGE_URL']?>">
                                <img src="<?=$like_items['PREVIEW_PICTURE']?>" width="120" height="90"/>
                            </a>
                        </div>
									<span class="b-slider-favorite-desc b-slider--stories-desc">
                                        <a href="<?=$like_items['DETAIL_PAGE_URL']?>">
										    <?=$like_items['NAME']?>
                                        </a>
									</span>
                    </div>
                    <? } ?>
                </div>
            </div>
        </div>
<?endforeach;?>

    </div>
</div>

