<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
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

$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
?>



<div class="b-catalog-wrap--cupcake js-ajax-content-block">
<h1><?= $APPLICATION->ShowTitle(false) ?></h1>
<div style="margin-top:15px;text-align: left;">
<ul style="display:inline-block;padding-top: 4px;vertical-align:top;" class="b-catalog-cupcake__list">
	<li class="b-catalog-cupcake--all <?= !isset($_REQUEST['new']) && !isset($_REQUEST['action']) ? 'active' : ''; ?> js-catalog-filter"
	    data-param="">Все
	</li>
	<li class="b-catalog-cupcake--new-items <?= isset($_REQUEST['new']) ? 'active' : ''; ?> js-catalog-filter"
	    data-param="new">Новинки
	</li>
	<li class="b-catalog-cupcake--discounts <?= isset($_REQUEST['action']) ? 'active' : ''; ?> js-catalog-filter"
	    data-param="action">Акции
	</li>
	
</ul>

<?//if($APPLICATION->GetCurPage()=='/catalog/cupcakes/children/'):?>
<div style="display:inline-block;vertical-align:top;" >
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.smart.filter",
			".default",
			Array(
				"CACHE_GROUPS" => "Y",
				"SHOW_ALL_WO_SECTION"=> "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"CONVERT_CURRENCY" => "N",
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"FILTER_NAME" => "arrFilter",
				"FILTER_VIEW_MODE" => "vertical",
				"HIDE_NOT_AVAILABLE" => "N",
				"IBLOCK_ID" => $arResult['IBLOCK_ID'],
				"IBLOCK_TYPE" => "catalog",
				"PAGER_PARAMS_NAME" => "arrPager",
				"PRICE_CODE" => "",
				"SAVE_IN_SESSION" => "N",
				"SECTION_CODE" => $_REQUEST['SECTION_CODE'],
				"SECTION_DESCRIPTION" => "-",
				"SECTION_ID" => "",
				"SECTION_TITLE" => "-",
				"SEF_MODE" => "N",
				"TEMPLATE_THEME" => "blue",
				"XML_EXPORT" => "N",
			),
			$component
		);?>
</div>
<?//endif?>
</div>

<div class="b-mod-catalog--cupcake">


	<?php if (count($arResult['ITEMS']) <= 0)
	{
		?>
		<p class="b-mod-catalog--cupcake--empty">Товары для этого раздела пока готовятся, пожалуйста, зайдите немного
			позже :)</p>
	<?php } ?>
	<?
	foreach ($arResult['ITEMS'] as $key => $arItem) {

	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
	$strMainID = $this->GetEditAreaId($arItem['ID']);

	$arItemIDs = array(
		'ID' => $strMainID,
		'PICT' => $strMainID . '_pict',
		'SECOND_PICT' => $strMainID . '_secondpict',
		'STICKER_ID' => $strMainID . '_sticker',
		'SECOND_STICKER_ID' => $strMainID . '_secondsticker',
		'QUANTITY' => $strMainID . '_quantity',
		'QUANTITY_DOWN' => $strMainID . '_quant_down',
		'QUANTITY_UP' => $strMainID . '_quant_up',
		'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
		'BUY_LINK' => $strMainID . '_buy_link',
		'BASKET_ACTIONS' => $strMainID . '_basket_actions',
		'NOT_AVAILABLE_MESS' => $strMainID . '_not_avail',
		'SUBSCRIBE_LINK' => $strMainID . '_subscribe',
		'COMPARE_LINK' => $strMainID . '_compare_link',

		'PRICE' => $strMainID . '_price',
		'DSC_PERC' => $strMainID . '_dsc_perc',
		'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',
		'PROP_DIV' => $strMainID . '_sku_tree',
		'PROP' => $strMainID . '_prop_',
		'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
		'BASKET_PROP_DIV' => $strMainID . '_basket_prop',
	);

	$strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

	$productTitle = (isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != '' ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']);
	$imgTitle = (isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != '' ? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] : $arItem['NAME']);

	$minPrice = false;
	if (isset($arItem['MIN_PRICE']) || isset($arItem['RATIO_PRICE']))
		$minPrice = (isset($arItem['RATIO_PRICE']) ? $arItem['RATIO_PRICE'] : $arItem['MIN_PRICE']);?>
<?php //print_r($arItem); ?>
	<div class="b-mod__item" id="<? echo $strMainID; ?>" data-id="" data-iid="">
		<div class="b-mod__item-img">
			<div class="b-mod__item-img--effect-transform">
				<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
				                                                      alt=""></a>
			</div>
			<?
			if ($arItem['PROPERTIES']['ACTION']['VALUE_ENUM'] == 'Да' ||
				$arItem['PROPERTIES']['NEW']['VALUE_ENUM'] == 'Да' ||
				$arItem['PROPERTIES']['HIT']['VALUE'])
			{
				if ($arItem['PROPERTIES']['ACTION']['VALUE_ENUM'] == 'Да')
					$name = 'акция';
				elseif ($arItem['PROPERTIES']['NEW']['VALUE_ENUM'] == 'Да')
					$name = 'новинка';
				else
					$name = 'хит';
				?>
				<div
					class="b-mod__item-label <?= $arItem['PROPERTIES']['ACTION']['VALUE_ENUM'] == 'Да' ?
						'b-mod__item-label--discont' : '' ?>"> <?= $name ?></div>
			<? } ?>

			<?php if (!$arItem['PROPERTIES']['NOT_AVAILABLE']['VALUE']): ?>
				<div class="basket-button" data-btn_id="<?= $arItem['ID'] ?>"
				     data-block_id="<?= $arItem['IBLOCK_ID']; ?>"></div>
			<?php endif; ?>
		</div>
		<div class="b-mod__item-title">
			<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?= $productTitle; ?></a>
			<span><? echo $arItem['NAME']; ?></span>
		</div>

		<?php if ($arItem['MIN_PRICE']['DISCOUNT_VALUE'] !== $arItem['MIN_PRICE']['VALUE']): ?>

		<div class="b-mod__item-price">
			<span
				style="text-decoration: line-through; color:#aaa;"><?= number_format($arItem['MIN_PRICE']['VALUE'], 0, '', ' ') ?></span>
			<?= number_format($arItem['MIN_PRICE']['DISCOUNT_VALUE'], 0, '', ' ') ?> P

			<?php else: ?>
			<div class="b-mod__item-price"><?= number_format($arItem['MIN_PRICE']['DISCOUNT_VALUE'], 0, '', ' ') ?> P
				<?php endif ?>


				<? if (isset($arItem['OFFERS'][0]['PROPERTIES']['NUMBER']))
				{
					?>
					<span>/
						<? foreach ($arItem['OFFERS'] as $of)
						{
							if ($of['MIN_PRICE']['DISCOUNT_VALUE'] == $arItem['MIN_PRICE']['DISCOUNT_VALUE'])
							{
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
				var <? echo $strObName; ?> =
				new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
			</script>

		</div>
		<? } ?>
	</div>

	<?if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}?>
	<div class="new_descr"><?
		// Описание выводим только на первой странице. Почему?
		if (is_object($arResult['NAV_RESULT']) && $arResult['NAV_RESULT']->PAGEN == 1)
		{
			$desc = CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "DESCRIPTION");
			if ($desc != '' && $_REQUEST['SECTION_CODE'] == '')
				echo $desc;
			else
			{
				$rsSections = CIBlockSection::GetList(array(), array(
					'IBLOCK_ID' => $arResult['IBLOCK_ID'],
					'CODE' => $_REQUEST['SECTION_CODE']
				));
				if ($arSection = $rsSections->Fetch())
				{
					echo $arSection['DESCRIPTION'];
				}
			}
		}
		?>
	</div>


</div>
<!--end b-catalog-wrap--cupcake-->
<div class="b-content-center b-content-center--bottom i-padding-vert-30">

	<a href="#" class="b-scroll-to-top b-scroll-to-top--catalog">
		наверх
	</a>
</div>

</div>

