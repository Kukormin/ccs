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

$offer_prices = [];
$offer_codes = [];
/*foreach($arResult['OFFERS'] as $offers) {
	if($offers['PROPERTIES']['DISCOUNT_PRICE']['VALUE'] < $offers['PRICES']['BASE']['VALUE']) {
		$offer_prices[$offers['ID']][] = $offers['PRICES']['BASE']['VALUE'];
		$offer_prices[$offers['ID']][] = $offers['PROPERTIES']['DISCOUNT_PRICE']['VALUE'];
	} else {
		$offer_prices[$offers['ID']][] = $offers['PRICES']['BASE']['VALUE'];
	}
}*/
foreach ($arResult['JS_OFFERS'] as $offers) {
    if($offers['PRICE']['DISCOUNT_VALUE'] < $offers['PRICE']['VALUE']) {
		$offer_prices[$offers['ID']][] = $offers['PRICE']['VALUE'];
		$offer_prices[$offers['ID']][] = $offers['PRICE']['DISCOUNT_VALUE'];
	} else {
		$offer_prices[$offers['ID']][] = $offers['PRICE']['VALUE'];
	}
    foreach ($offers['TREE'] as $key=>$val) {
        $offer_codes[explode('_',$key)[1].'_'.$val] = $offers['ID'];
    }
}

?>
<?php $boolHasAction = $arResult['PROPERTIES']['ACTION']['VALUE']=='Да'; ?>
<div class="b-modal--cupcake <?=$boolHasAction?'b-modal--cupcake-discont':'';?> <?=empty($arResult['SKU_PROPS'])?'without_select':''?> js-modal-window" id="modal_<?=$arResult['ID']?>" style="display: block" data-id="<?=$arResult['ID']?>">
<script>
    if (!window.modal_offer_prices) window.modal_offer_prices = {};
    modal_offer_prices[<?=$arResult['ID']?>] = JSON.parse('<?=json_encode($offer_prices);?>');
</script>
    <a href="#" class="b-modal-add-products"> Продолжить покупки</a>
    <span class="b-close-modal">close</span>
    <div class="b-modal--cupcake__wrap">
        <div class="b-modal-cupcake__img-product">
            <img src="<? echo $arResult['PREVIEW_PICTURE']['SRC']?>" alt="">
        </div>
        <?php if ($boolHasAction) { ?>
            <div class="b-modal-cupcake__date-discont">
                <div class="b-mod__item-label b-mod__item-label--discont"> акция</div>
                <?=$arResult['PROPERTIES']['ACTION_TEXT']['VALUE']?>
            </div>
        <?php } ?>
        <div class="b-mod__item-title b-modal-cupcake__item-title--white <?=$boolHasAction?'b-modal-border-top':'';?>">
            <?=$arResult['NAME'] ?>
        </div>
        <!--select-->
        <div class="b-block-assortment--select b-modal-cupcake--select">
        <?php if (count($arResult['PRODUCT_PROPERTIES'])) { ?>
            <?php foreach ($arResult['PRODUCT_PROPERTIES'] as $sKey => $arProp) { 
                if (!count($arProp['VALUES'])) continue;?>
                <div class="b-application-event__form-item b-modal-cupcake-select__item">
                    <label class="is-color-white" for=""> <?=$arResult['PROPERTIES'][$sKey]['NAME'];?></label>
                    <div class="b-form-item__input b-form-item__input--select">
                        <p class="select_title"><?=$arProp['VALUES'][$arProp['SELECTED']];?></p>
                        <select class="js-basket-property" data-code="<?=$sKey;?>" data-name="<?=$arResult['PROPERTIES'][$sKey]['NAME'];?>">
                            <?php foreach ($arProp['VALUES'] as $key=>$val) { 
                                echo '<option '.($arProp['SELECTED']==$val?'selected':'').' value="'.$key.'">'.$val.'</option>';
                             } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
            <div class="b-modal-cupcake-select__list">
                <?php if (isset($arResult['SKU_PROPS']) && count($arResult['SKU_PROPS']) > 0) { ?>
                    <?php foreach ($arResult['SKU_PROPS'] as $sKey => $arOffer) { ?>
                        <?php if (count($arOffer['VALUES']) < 1) continue; ?>
                        <div class="b-application-event__form-item b-modal-cupcake-select__item-total">
                            <label class="is-color-white" for=""> <?=$arOffer['NAME'];?></label>
                            <div class="b-form-item__input b-form-item__input--select">
                                <?php uasort($arOffer['VALUES'], function ($a, $b) {return strnatcmp($a['NAME'], $b['NAME']);}); 
                                if ($arOffer['VALUES'][0]['ID'] == 0) unset($arOffer['VALUES'][0]);
                                ?>
                                <p class="select_title"><?=reset($arOffer['VALUES'])['NAME'];?></p>
                                <select class="js-option-selector" data-code="<?=$sKey;?>" data-name="<?=$arOffer['NAME'];?>">
                                    <? foreach ($arOffer['VALUES'] as $of) { 
                                        if ($of['ID'] === 0) continue; ?>
                                        <option value="<?=$offer_codes[$arOffer['ID'].'_'.$of['ID']];?>"><?=$of['NAME'];?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
                <span class="b-block-assortment--package  b-modal-cupcake-assortment--package js-modal-counter" data-count="1">1 упаковка</span>
                <span class="b-modal-cupcake-assortment--package-delete js-modal-downcount" style="display: none"> </span>
            </div>
            <span class="b-block-assortment--package-add b-modal-cupcake-assortment--package-add b-modal-border-bottom b-modal-border-top js-modal-upcount"> Хочу еще</span>

        </div>
        <!--end select-->

        <div class="b-block-modal-cupcake--total">
            <?
            $boolHasDiscout = false;
            if ($arResult['MIN_PRICE']['DISCOUNT_VALUE'] != $arResult['MIN_PRICE']['VALUE'])
            {
                $boolHasDiscout = true;
                $arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
                $arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
            }
            ?>
            <?php if ($boolHasDiscout) { ?>
                <div class="b-old--total-price b-history-total--price b-modal-cupcake-total--price js-modal-priceblock js-priceblock" data-price="<?=$arResult['MIN_PRICE']['DISCOUNT_VALUE'];?>" data-oldprice="<?=$arResult['MIN_PRICE']['VALUE'];?>">
                    <div class="b-old-price"> <?=number_format($arResult['MIN_PRICE']['VALUE'], 0, '', ' ');?> <span class="rub">i</span></div>
                    <div class="b-new-price"> <?=number_format($arResult['MIN_PRICE']['DISCOUNT_VALUE'], 0, '', ' ');?> <span class="rub">i</span></div>
                </div>
            <?php } else { ?>
                <div class="b-history-total--price b-modal-cupcake-total--price js-modal-priceblock js-priceblock" data-price="<?=$arResult['MIN_PRICE']['VALUE'];?>" data-oldprice="0">
                    <?=number_format($arResult['MIN_PRICE']['VALUE'], 0, '', ' ');?> <span class="rub">i</span>
                </div>
            <?php } ?>
            
            <button class="b-bnt-form b-bnt-modal-cupcake--white js-modal-tobasket" data-href="/personal/cart">в корзину</button>
            
            <button class="b-bnt-form b-bnt-buy-one-click i-margin-left-30 js-buy-fastorder">купить в один клик</button>
            <!--<button class="b-bnt-present b-bnt-form i-margin-left-30">сделать подарок</button>-->
        </div>
    </div>
</div>
<?
$category = '';
$cat = CIBlock::GetByID($arResult['IBLOCK_ID']);
if($ar_res = $cat->GetNext())
    $category = $ar_res['NAME'];
?>
<script>
    $(document).ready(function() {
        $('.js-modal-tobasket').click(function() {
            if($('.js-modal-tobasket').html() == 'в корзину') {
                dataLayer.push({
                    'event': 'addToCart',
                    'ecommerce': {
                        'currencyCode': 'RUR',
                        'add': {
                            'products': [{
                                'name': '<?=$arResult['NAME']?>',
                                'id': '<?=$arResult['ID']?>',
                                'price': '<?=$arResult['MIN_PRICE']['VALUE']?>',
                                'category': '<?=$category?>',
                                'quantity': parseInt($('.js-modal-counter').html())
                            }]
                        }
                    }
                });
            }
        });
    });
</script>