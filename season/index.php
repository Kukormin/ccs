<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Новый Год");
$APPLICATION->SetTitle("");

$iblock = new \CIBlock();
$iblockElement = new \CIBlockElement();

$seasonsId = 0;
$dbIb = $iblock->GetList(
	Array(),
	Array(
		'CODE' => 'seasons',
	),
	false
);
while ($arIb = $dbIb->Fetch()) {
	$seasonsId = $arIb['ID'];
}

$newSeasonsByCode = array();
$rsItems = $iblockElement->GetList(array(), array(
	'IBLOCK_ID' => $seasonsId,
), false, false, array('ID', 'NAME', 'CODE', 'DETAIL_TEXT'));
while ($arItem = $rsItems->Fetch())
{
	$newSeasonsByCode[$arItem['CODE']] = $arItem;
}

if ($newSeasonsByCode[$_REQUEST['FILTER']])
    $code = $_REQUEST['FILTER'];
else
    $code = 'newyear';

$fSeason = $newSeasonsByCode[$code];
$filterValue = $fSeason['ID'];

$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($seasonsId, $filterValue);
$propValues = $ipropValues->getValues();

//echo '----index';
?><section class="b-topblock b-topblock--pay-ship"> </section> <section class="b-bg-grey">
<!--block slider-->
<div class="b-content-center b-slider-stock b-slider-cupcake">
	<div class="b-slider-stock-wrap">
		 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"cupcake_banners_inner",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "0",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "cupcake_banners",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"ID",1=>"CODE",2=>"XML_ID",3=>"NAME",4=>"DETAIL_TEXT",5=>"DETAIL_PICTURE",6=>"DATE_ACTIVE_FROM",7=>"ACTIVE_FROM",8=>"DATE_ACTIVE_TO",9=>"ACTIVE_TO",10=>"IBLOCK_TYPE_ID",11=>"IBLOCK_ID",12=>"IBLOCK_CODE",13=>"IBLOCK_NAME",14=>"IBLOCK_EXTERNAL_ID",15=>"",),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "21",
		"IBLOCK_TYPE" => "banner",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "0",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"LINK_NAME",1=>"DISPLAY_MAIN",2=>"LINK",3=>"",),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC"
	)
);?>
	</div>
</div>
<div class="b-content-center b-content-center--cupcake">

<div class="b-grey-wrap-top b-grey-wrap-top--asaide">
	<div class="b-grey-wrap-top-right">
		<div class="b-grey-wrap-bottom">
			<div class="b-grey-wrap-bottom-right">
				<ul id="nav_list_asaide" class="b-cupcake-fiirst-line__list"><?

					foreach ($newSeasonsByCode as $season)
					{
						$active = $season['ID'] == $filterValue ? ' active' : '';
						?>
						<li class="b-cupcake-fiirst-line__item<?= $active?>">
							<a class="b-cupcake-fiirst-line__link" href="/season/<?= $season['CODE'] ?>/"><?=
								$season['NAME'] ?></a>
						</li><?
					}
					?>
				</ul>
				<div style="clear: both;"></div>
			</div>
		</div>
	</div>
</div>

<div class="b-mobile-breadcrumbs b-block-mobile-only">
	<div class="mobile_catalog_open">Развернуть каталог</div>
	<div class="cupcake__navigation--mobile"> </div>
	<div class="cupcake__navigation--mobile-wrap">
		<div class="b-grey-wrap-top">
			<div class="b-grey-wrap-top-right">
				<div class="b-grey-wrap-bottom">
					<div class="b-grey-wrap-bottom-right">
						<ul class="b-cupcake__navigation--mobile-first-line__list"><?

							foreach ($newSeasonsByCode as $season)
							{
								$active = $season['ID'] == $filterValue ? ' active' : '';
								?>
								<li class="b-cupcake__navigation--mobile-first-line__item<?= $active?>">
									<a class="b-cupcake__navigation--mobile-first-line__link" href="/season/<?= $season['CODE'] ?>/"><?=
										$season['NAME'] ?></a>
								</li><?
							}

							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

	 <?
     $arrFilter = array(
    'PROPERTY_SEASON_IB' => $filterValue
    //'PROPERTY_SEASON' => 'newyear'
);
if (isset($_REQUEST['new'])) {
    $arrFilter['!PROPERTY_NEW'] = false;
}
if (isset($_REQUEST['action'])) {
    $arrFilter['!PROPERTY_ACTION'] = false;
}
     $APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"cupcake_catalog_allsection1", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/cart",
		"BROWSER_TITLE" => "NAME",
		"BY_LINK" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"COMPONENT_TEMPLATE" => "cupcake_catalog_allsection1",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "NUMBER",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "TAGS",
			5 => "SORT",
			6 => "PREVIEW_TEXT",
			7 => "PREVIEW_PICTURE",
			8 => "DETAIL_TEXT",
			9 => "DETAIL_PICTURE",
			10 => "IBLOCK_TYPE_ID",
			11 => "IBLOCK_ID",
			12 => "IBLOCK_CODE",
			13 => "IBLOCK_NAME",
			14 => "IBLOCK_EXTERNAL_ID",
			15 => "DATE_CREATE",
			16 => "",
		),
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "ARTICLE",
			1 => "NUMBER",
			2 => "TAGS",
			3 => "STAR_GIFT_PRICE",
			4 => "FILLING",
			5 => "DISCOUNT_PRICE",
			6 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGER_BASE_LINK" => "",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_PARAMS_NAME" => "arrPager",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "cupcake_pagenav",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "12",
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "items_num",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(
			0 => "ACTION",
			1 => "PACKAGE",
			2 => "NEW",
			3 => "STAR_GIFT",
			4 => "FILLING",
			5 => "",
		),
		"SECTION_CODE" => "",
		"SECTION_CODE_PATH" => "",
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "UF_ACSESS_BOUND",
			1 => "UF_DISPLAY_MAIN",
			2 => "UF_DATE",
			3 => "UF_PASSWORD",
			4 => "",
		),
		"SEF_MODE" => "N",
		"SEF_RULE" => "",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "blue",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y",
	    "CUSTOM_DESCRIPTION" => $fSeason['DETAIL_TEXT'],
	),
	false
);

	 if ($propValues)
	 {
		 $arTitleOptions = null;

		 if ($propValues["ELEMENT_PAGE_TITLE"] != "")
			 $APPLICATION->SetTitle($propValues["ELEMENT_PAGE_TITLE"], $arTitleOptions);

		 if ($propValues["ELEMENT_META_TITLE"] != "")
			 $APPLICATION->SetPageProperty("title", $propValues["ELEMENT_META_TITLE"], $arTitleOptions);

		 if ($propValues["ELEMENT_META_KEYWORDS"] != "")
			 $APPLICATION->SetPageProperty("keywords", $propValues["ELEMENT_META_KEYWORDS"], $arTitleOptions);

		 if ($propValues["ELEMENT_META_DESCRIPTION"] != "")
			 $APPLICATION->SetPageProperty("description", $propValues["ELEMENT_META_DESCRIPTION"], $arTitleOptions);

	 }

	 ?>
</div>
 </section><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>