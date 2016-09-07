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
<div class="b-mod b-mod--novelty">
        <?foreach ($arResult['ITEMS'] as $key => $arItem) {
            $res = CIBlockSection::GetByID($arItem["IBLOCK_SECTION_ID"]);
            if($ar_res = $res->GetNext())

            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
            $strMainID = $this->GetEditAreaId($arItem['ID']);
            $arItemIDs = array(
                'ID' => $strMainID,
                'PICT' => $strMainID.'_pict',
                'SECOND_PICT' => $strMainID.'_secondpict',
                'STICKER_ID' => $strMainID.'_sticker',
                'SECOND_STICKER_ID' => $strMainID.'_secondsticker',
                'QUANTITY' => $strMainID.'_quantity',
                'QUANTITY_DOWN' => $strMainID.'_quant_down',
                'QUANTITY_UP' => $strMainID.'_quant_up',
                'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
                'BUY_LINK' => $strMainID.'_buy_link',
                'BASKET_ACTIONS' => $strMainID.'_basket_actions',
                'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
                'SUBSCRIBE_LINK' => $strMainID.'_subscribe',
                'COMPARE_LINK' => $strMainID.'_compare_link',

                'PRICE' => $strMainID.'_price',
                'DSC_PERC' => $strMainID.'_dsc_perc',
                'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',
                'PROP_DIV' => $strMainID.'_sku_tree',
                'PROP' => $strMainID.'_prop_',
                'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
                'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
            );

            $strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

            $productTitle = (
            isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
                ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
                : $arItem['NAME']
            );
            $imgTitle = (
            isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
                ? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
                : $arItem['NAME']
            );

            $minPrice = false;
            if (isset($arItem['MIN_PRICE']) || isset($arItem['RATIO_PRICE']))
                $minPrice = (isset($arItem['RATIO_PRICE']) ? $arItem['RATIO_PRICE'] : $arItem['MIN_PRICE']);?>

            <div class="b-slider__item" id="<? echo $strMainID; ?>">
                <div class="b-mod__item b-mod__item-about-novelty">
                    <div class="b-mod__item-img">
                        <div class="b-mod__item-img--effect-transform">
                            <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>">
                            <?if(!is_array($arItem['PREVIEW_PICTURE']) && $arItem['PREVIEW_PICTURE'] != 0) {?>
                                <img src="<?=CFile::GetPath($arItem['PREVIEW_PICTURE'])?>" alt="">
                            <? } else {?>
                                <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="">
                            <?}?>
                            </a>
                        </div>
                        <div class="b-mod__item-label">новинка</div>
                        <?php if(!$arItem['PROPERTIES']['NOT_AVAILABLE']['VALUE']):?>
                            <div class="basket-button" data-btn_id="<?=$arItem['ID']?>" data-block_id="<?=$arItem['IBLOCK_ID'];?>"></div>
                        <?php endif;?>
                    </div>
                    <div class="b-mod__item-title">
                        <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?=$productTitle;?></a>
                        <span><?=$ar_res['NAME'] != '' ? $ar_res['NAME'] : $arItem['IBLOCK_NAME']; ?></span>
                </div>
                    <div class="b-mod__item-price"><? if($arItem['MIN_PRICE']['DISCOUNT_VALUE'] !== NULL) {echo number_format($arItem['MIN_PRICE']['DISCOUNT_VALUE'], 0, '', ' '); } elseif(is_string($arItem['CATALOG_PRICE_1'])) {echo number_format($arItem['CATALOG_PRICE_1'], 0, '', ' ');}elseif($arItem['PRICE']){echo number_format($arItem['PRICE'], 0, '', ' ');} ?> <span class="rub">i</span>
                    <? if (isset($arItem['OFFERS'][0]['PROPERTIES']['NUMBER'])) { ?>
                    <span>/
                            <? foreach ($arItem['OFFERS'] as $of) {
                                if ($of['MIN_PRICE']['DISCOUNT_VALUE'] == $arItem['MIN_PRICE']['DISCOUNT_VALUE']) {
                                    print $of['PROPERTIES']['NUMBER']['VALUE'];
                                    break;
                                }
                            } ?> шт</span>
                    <? } ?>
                    </div>
                   
                </div>
            </div>
        <? } ?>
    </div>

