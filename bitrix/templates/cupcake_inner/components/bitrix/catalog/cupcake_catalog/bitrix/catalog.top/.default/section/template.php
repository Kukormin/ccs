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
//print_r($arResult);
?>

<div class="b-catalog-wrap--cupcake">
	<ul class="b-catalog-cupcake__list">
		<li class="b-catalog-cupcake--all active">Все</li>
		<li class="b-catalog-cupcake--new-items">Новинки</li>
		<li class="b-catalog-cupcake--discounts">акции</li>
	</ul>
	<div class="b-mod-catalog--cupcake">
<?
foreach ($arResult['ITEMS'] as $key => $arItem) {

$res = CIBlockSection::GetByID($arItem["IBLOCK_SECTION_ID"]);
if($ar_res = $res->GetNext())

$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
$strMainID = $this->GetEditAreaId($arItem['ID']);

    $arItemIDs = array(
        'ID' => $strMainID,
        'PICT' => $strMainID.'_pict',
        'SECOND_PICT' => $strMainID.'_secondpict',
        'MAIN_PROPS' => $strMainID.'_main_props',

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
        'BASKET_PROP_DIV' => $strMainID.'_basket_prop'
    );

    $strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

    $minPrice = false;
    if (isset($arItem['MIN_PRICE']) || isset($arItem['RATIO_PRICE']))
        $minPrice = (isset($arItem['RATIO_PRICE']) ? $arItem['RATIO_PRICE'] : $arItem['MIN_PRICE']);

?>

<div class="b-mod__item" id="<? echo $strMainID; ?>">
	<div class="b-mod__item-img">
		<div class="b-mod__item-img--effect-transform">
			<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="">
		</div>
		<? if($arItem['PROPERTIES']['ACTION']['VALUE_ENUM']=='Да' || $arItem['PROPERTIES']['NEW']['VALUE_ENUM']=='Да') {?>
		<div class="b-mod__item-label <?=$arItem['PROPERTIES']['ACTION']['VALUE_ENUM']=='Да' ? 'b-mod__item-label--discont':''?>"> <?=$arItem['PROPERTIES']['ACTION']['VALUE_ENUM']=='Да' ? 'акция':'новинка'?></div>
		<? } ?>
		<div class="basket-button" data-btn_id="<?=$arItem['ID']?>"></div>
	</div>
	<div class="b-mod__item-title">
		<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><? echo $arItem['NAME'] ?></a>
		<span><?echo $ar_res['NAME']; ?></span>
	</div>
	<div class="b-mod__item-price"><?=$arItem['MIN_PRICE']['DISCOUNT_VALUE']?> P <span>/
            <? foreach ($arItem['OFFERS'] as $of) {
				if ($of['MIN_PRICE']['DISCOUNT_VALUE'] == $arItem['MIN_PRICE']['DISCOUNT_VALUE']) {
					print $of['PROPERTIES']['NUMBER']['VALUE'];
					break;
				}
			} ?> шт</span></div>
    <!--modal-discont-->
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
    $arSkuProps = array();
    ?><div class="bx_catalog_item_scu" id="<? echo $arItemIDs['PROP_DIV']; ?>"><?
        foreach ($arSkuTemplate as $code => $strTemplate)
        {
            if (!isset($arItem['OFFERS_PROP'][$code]))
                continue;
            echo '<div>', str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $strTemplate), '</div>';
        }
        foreach ($arResult['SKU_PROPS'] as $arOneProp)
        {
            if (!isset($arItem['OFFERS_PROP'][$arOneProp['CODE']]))
                continue;
            $arSkuProps[] = array(
                'ID' => $arOneProp['ID'],
                'SHOW_MODE' => $arOneProp['SHOW_MODE'],
                'VALUES_COUNT' => $arOneProp['VALUES_COUNT']
            );
        }
        foreach ($arItem['JS_OFFERS'] as &$arOneJs)
        {
            if (0 < $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'])
            {
                $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
                $arOneJs['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
            }
        }
        unset($arOneJs);
        ?></div><?
    if ($arItem['OFFERS_PROPS_DISPLAY'])
    {
        foreach ($arItem['JS_OFFERS'] as $keyOffer => $arJSOffer)
        {
            $strProps = '';
            if (!empty($arJSOffer['DISPLAY_PROPERTIES']))
            {
                foreach ($arJSOffer['DISPLAY_PROPERTIES'] as $arOneProp)
                {
                    $strProps .= '<br>'.$arOneProp['NAME'].' <strong>'.(
                        is_array($arOneProp['VALUE'])
                            ? implode(' / ', $arOneProp['VALUE'])
                            : $arOneProp['VALUE']
                        ).'</strong>';
                }
            }
            $arItem['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
        }
    }
    $arJSParams = array(
        'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
        'SHOW_QUANTITY' => ($arParams['USE_PRODUCT_QUANTITY'] == 'Y'),
        'SHOW_ADD_BASKET_BTN' => false,
        'SHOW_BUY_BTN' => true,
        'SHOW_ABSENT' => true,
        'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
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
        'OFFERS' => $arItem['JS_OFFERS'],
        'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
        'TREE_PROPS' => $arSkuProps,
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
        var <? echo $strObName; ?> = new JCCatalogTopSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
    </script>
</div>

<? }?>
</div>
	</div>
</div>
<div class="b-content-center b-content-center--bottom i-padding-vert-30">
	<?if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}?>
	<a href="#" class="b-scroll-to-top b-scroll-to-top--catalog">
		наверх
	</a>
</div>
</section>

