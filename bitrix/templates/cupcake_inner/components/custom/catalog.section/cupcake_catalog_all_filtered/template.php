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
<div class="b-content-center b-slider-about-novelty">
    <div class="b-title b-title--border-middle">
        <div class="b-title__item b-title__item--grey">
						<span href="#" class="b-mod--about-novelty__item-img">
							У нас есть много вкусных коллекций
						</span>
        </div>
    </div>
<div class="b-slider-wrap-about-novelty">
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
                    <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="">
                </div>

                <div class="basket-button" data-btn_id="<?=$arItem['ID']?>"></div>
            </div>
            <div class="b-mod__item-title">
                <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?=$productTitle;?></a>
                <span><?echo $ar_res['NAME']; ?></span>
            </div>
            <div class="b-mod__item-price"><?=$arItem['MIN_PRICE']['DISCOUNT_VALUE']?> <span class="rub">i</span>
                <span>/
                    <? foreach ($arItem['OFFERS'] as $of) {
                        if ($of['MIN_PRICE']['DISCOUNT_VALUE'] == $arItem['MIN_PRICE']['DISCOUNT_VALUE']) {
                            print $of['PROPERTIES']['NUMBER']['VALUE'];
                            break;
                        }
                    } ?> шт</span></div>
            <!--MODAL DISCOUNT-->
            <div class="b-modal--cupcake b-modal--cupcake-discont" id="modal_<?=$arItem['ID']?>" style="display: none">
                <a href="#" class="b-modal-add-products"> Продолжить покупки</a>
                <span class="b-close-modal">close</span>
                <div class="b-modal--cupcake__wrap">
                    <div class="b-modal-cupcake__img-product">
                        <img id="<? echo $arItemIDs['PICT']; ?>" src="<? echo $arItem['PREVIEW_PICTURE']['SRC']?>" alt="">
                    </div>
                    <div class="b-modal-cupcake__date-discont">
                        <div class="b-mod__item-label b-mod__item-label--discont"> акция</div>
                        До конца августа вторая коллекция в подарок
                    </div>
                    <div class="b-mod__item-title b-modal-cupcake__item-title--white b-modal-border-top">
                        <?=$arItem['NAME'] ?>
                    </div>
                    <!--select-->
                    <div class="b-block-assortment--select b-modal-cupcake--select">
                        <div class="b-application-event__form-item b-modal-cupcake-select__item">
                            <label class="is-color-white" for=""> Начинка</label>
                            <div class="b-form-item__input b-form-item__input--select">
                                <p class="select_title">Ваниль</p>
                                <select>
                                    <option>Ваниль</option>
                                    <option>Ваниль2</option>
                                </select>
                            </div>
                        </div>
                        <div class="b-modal-cupcake-select__list">
                            <div class="b-application-event__form-item b-modal-cupcake-select__item-total">
                                <label class="is-color-white" for=""> количество</label>
                                <div class="b-form-item__input b-form-item__input--select">
                                    <p class="select_title">6</p>
                                    <select>
                                        <? foreach ($arItem['OFFERS'] as $of) { ?>
                                            <option value="<?=$of['ID'];?>"><?=$of['PROPERTIES']['NUMBER']['VALUE'];?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                            <span class="b-block-assortment--package  b-modal-cupcake-assortment--package"> <input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>"> упаковки</span>
                            <a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow"><span class="b-modal-cupcake-assortment--package-delete"> </span></a>
                        </div>
                        <a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" rel="nofollow"><span class="b-block-assortment--package-add b-modal-cupcake-assortment--package-add b-modal-border-bottom b-modal-border-top"> Хочу еще</span></a>

                    </div>
                    <!--end select-->

                    <div class="b-block-modal-cupcake--total">
                        <div class="b-history-total--price b-modal-cupcake-total--price" id="<? echo $arItemIDs['PRICE']; ?>">
                            <? if (!empty($minPrice))
                            {
                                echo $minPrice['DISCOUNT_VALUE'];
                            }
                            unset($minPrice); ?> <span class="rub">i</span>
                        </div>
                        <div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>">
                            <a id="<?=$arItemIDs['BUY_LINK']; ?>" href="javascript:void(0)" rel="nofollow"><button class="b-bnt-form b-bnt-modal-cupcake--white">в корзину</button></a>
                        </div>
                        <button class="b-bnt-form b-bnt-buy-one-click i-margin-left-30">купить в один клик</button>
                        <button class="b-bnt-present b-bnt-form i-margin-left-30">сделать подарок</button>
                    </div>
                </div>
            </div>
            <!--END MODAL DISCOUNT -->
            <?
            $arJSParams = array(
                'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
                'SHOW_QUANTITY' => false,
                'SHOW_ADD_BASKET_BTN' => false,
                'SHOW_BUY_BTN' => false,
                'SHOW_ABSENT' => false,
                'SHOW_SKU_PROPS' => false,
                'SECOND_PICT' => $arItem['SECOND_PICT'],
                'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
                'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
                'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
                'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
                'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
                'DEFAULT_PICTURE' => array(
                    'PICTURE' => $arItem['PRODUCT_PREVIEW'],
                    'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
                ),
                'VISUAL' => array(
                    'ID' => $arItemIDs['ID'],
                    'PICT_ID' => $arItemIDs['PICT'],
                    'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
                    'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                    'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                    'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                    'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
                    'PRICE_ID' => $arItemIDs['PRICE'],
                    'TREE_ID' => $arItemIDs['PROP_DIV'],
                    'TREE_ITEM_ID' => $arItemIDs['PROP'],
                    'BUY_ID' => $arItemIDs['BUY_LINK'],
                    'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
                    'DSC_PERC' => $arItemIDs['DSC_PERC'],
                    'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
                    'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
                    'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
                    'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
                    'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK']
                ),
                'BASKET' => array(
                    'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                    'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                    'SKU_PROPS' => $arItem['OFFERS_PROP_CODES'],
                    'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
                    'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
                ),
                'PRODUCT' => array(
                    'ID' => $arItem['ID'],
                    'NAME' => $productTitle
                ),
                'OFFERS' => array(),
                'OFFER_SELECTED' => 0,
                'TREE_PROPS' => array(),
                'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
            );
            if ($arParams['DISPLAY_COMPARE'])
            {
                $arJSParams['COMPARE'] = array(
                    'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
                    'COMPARE_PATH' => $arParams['COMPARE_PATH']
                );
            }
            ?>
            <script type="text/javascript">
                var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
            </script>
        </div>
        </div>
<? } ?>
    </div>
    </div>
