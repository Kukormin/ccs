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
foreach ($arResult['ITEMS'] as $key => $arItem) {
    if($arItem['IBLOCK_ID'] == 4) continue;
    $db_props = CIBlockElement::GetProperty($arItem['IBLOCK_ID'], $arItem['ID'], Array(), Array());
    while ($ob = $db_props->Fetch()) {
        $arResult['ITEMS'][$key]['PROPERTIES'][$ob['CODE']] = $ob;
    }
}
?>


    <?

	$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
	$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
	$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
	?>
				<div class="b-catalog-wrap--cupcake js-ajax-content-block">
                    <? $APPLICATION->IncludeFile( '/include/pryanik_banner.php', array(),
                        array(
                            'MODE'  => 'html',
                            'TEMPLATE'  => 'page_inc.php',
                        )
                    ); ?>
                    <ul class="b-catalog-cupcake__list">
						<li class="b-catalog-cupcake--all <?=!isset($_REQUEST['new'])&&!isset($_REQUEST['action'])?'active':'';?> js-catalog-filter" data-param="">Все</li>
						<li class="b-catalog-cupcake--new-items <?=isset($_REQUEST['new'])?'active':'';?> js-catalog-filter" data-param="new">Новинки</li>
						<li class="b-catalog-cupcake--discounts <?=isset($_REQUEST['action'])?'active':'';?> js-catalog-filter" data-param="action">Акции</li>
					</ul>
							<div class="b-mod-catalog--cupcake">
							<?php if (count($arResult['ITEMS']) <= 0) {?>
								<p class="b-mod-catalog--cupcake--empty">Товары для этого раздела пока готовятся, пожалуйста, зайдите немного позже :)</p>
							<?php } ?>
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
<?php //print_r($arItem); ?>
								<div class="b-mod__item" id="<? echo $strMainID; ?>" data-id="" data-iid="">
									<div class="b-mod__item-img">
										<div class="b-mod__item-img--effect-transform">
											<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt=""></a>
										</div>
                                        <? if($arItem['PROPERTIES']['ACTION']['VALUE_ENUM']=='Да' || $arItem['PROPERTIES']['NEW']['VALUE_ENUM']=='Да') {?>
                                            <div class="b-mod__item-label <?=$arItem['PROPERTIES']['ACTION']['VALUE_ENUM']=='Да' && !isset($_REQUEST['new']) ? 'b-mod__item-label--discont':''?>"> <?=$arItem['PROPERTIES']['ACTION']['VALUE_ENUM']=='Да'  && !isset($_REQUEST['new']) ? 'акция':'новинка'?></div>
                                        <? } ?>
                                        <?php if(!$arItem['PROPERTIES']['NOT_AVAILABLE']['VALUE']):?>
											<div class="basket-button" data-btn_id="<?=$arItem['ID']?>" data-block_id="<?=$arItem['IBLOCK_ID'];?>"></div>
										<?php endif;?>
									</div>
									<div class="b-mod__item-title">
                                        <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?=$productTitle;?></a>
                                        <span><?echo $ar_res['NAME']; ?></span>
									</div>
									<div class="b-mod__item-price"><?=isset($arItem['MIN_PRICE']['DISCOUNT_VALUE']) ? number_format($arItem['MIN_PRICE']['DISCOUNT_VALUE'], 0, '', '') : number_format($arItem['MIN_PRICE']['VALUE'], 0, '', '');?> P
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
                            <? } ?>
							</div>
				 </div>		<!--end b-catalog-wrap--cupcake-->


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


