<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$redirect = array(

	'/catalog/gingerbread/1-sentyabrya/' => '/cat/gingerbread/knowledge/',
	'/catalog/gingerbread/bolshie/' => '/cat/gingerbread/big/',
	'/catalog/gingerbread/detskie/' => '/cat/gingerbread/kids/',
	'/catalog/gingerbread/malye/' => '/cat/gingerbread/small/',
	'/catalog/gingerbread/pryanichnye-bukety/' => '/cat/gingerbread/happy/',
	'/catalog/gingerbread/imbirnye-pryaniki/' => '/cat/gingerbread/',
	'/catalog/gingerbread/pryaniki-s-logotipom/' => '/cat/gingerbread/logo/',
	'/catalog/gingerbread/' => '/cat/gingerbread/',

	'/catalog/cakes/14-fevralya/' => '/cat/cakes/14feb/',
	'/catalog/cakes/8-marta/' => '/cat/cakes/8march/',
	'/catalog/cakes/klassicheskie/' => '/cat/cakes/classic/',
	'/catalog/cakes/novogodnie/' => '/cat/cakes/newyear/',
	'/catalog/cakes/prazdnichnye/' => '/cat/cakes/holiday/',
	'/catalog/cakes/torty-na-den-rozhdeniya/' => '/cat/cakes/birthday/',
	'/catalog/cakes/torty-na-yubilej/' => '/cat/cakes/jubilee/',
	'/catalog/cakes/svadebnye-torty/' => '/cat/cakes/wedding/',
	'/catalog/cakes/detskie/' => '/cat/cakes/kids/',
	'/catalog/cakes/' => '/cat/cakes/',

	'/catalog/happybox/' => '/cat/happy/',
	'/catalog/minicakes/' => '/cat/minicakes/',

	'/catalog/eclairs/assorti/' => '/cat/eclairs/happy/',
	'/catalog/eclairs/detskie/' => '/cat/eclairs/kids/',
	'/catalog/eclairs/klassicheskie/' => '/cat/eclairs/classic/',
	'/catalog/eclairs/prazdnichnye/' => '/cat/eclairs/holiday/',
	'/catalog/eclairs/' => '/cat/eclairs/',

	'/catalog/cupcakes/bestseller/' => '/cat/cupcakes/choice/',
	'/catalog/cupcakes/assorti/' => '/cat/cupcakes/happy/',
	'/catalog/cupcakes/children/' => '/cat/cupcakes/kids/',
	'/catalog/cupcakes/dlya-devochek/' => '/cat/cupcakes/girl/',
	'/catalog/cupcakes/dlya-malchikov/' => '/cat/cupcakes/boy/',
	'/catalog/cupcakes/holyday/' => '/cat/cupcakes/holiday/',
	'/catalog/cupcakes/calendar/' => '/cat/cupcakes/holiday/',
	'/catalog/cupcakes/14-fevralya/' => '/cat/cupcakes/14feb/',
	'/catalog/cupcakes/8-marta/' => '/cat/cupcakes/8march/',
	'/catalog/cupcakes/9-maya/' => '/cat/cupcakes/9may/',
	'/catalog/cupcakes/vypusknoj/' => '/cat/cupcakes/graduation/',
	'/catalog/cupcakes/den-zashhity-detej/' => '/cat/cupcakes/children/',
	'/catalog/cupcakes/den-znaniy/' => '/cat/cupcakes/knowledge/',
	'/catalog/cupcakes/den-materi/' => '/cat/cupcakes/mothers/',
	'/catalog/cupcakes/den-semi-vernosti-i-lyubvi/' => '/cat/cupcakes/family/',
	'/catalog/cupcakes/novogodnie/' => '/cat/cupcakes/newyear/',
	'/catalog/cupcakes/pasha/' => '/cat/cupcakes/easter/',
	'/catalog/cupcakes/rozhdestvo/' => '/cat/cupcakes/christmas/',
	'/catalog/cupcakes/halloween/' => '/cat/cupcakes/halloween/',
	'/catalog/cupcakes/family/' => '/cat/cupcakes/holiday/',
	'/catalog/cupcakes/devichnik/' => '/cat/cupcakes/henparty/',
	'/catalog/cupcakes/birthday/' => '/cat/cupcakes/birthday/',
	'/catalog/cupcakes/kreshchenie/' => '/cat/cupcakes/epiphany/',
	'/catalog/cupcakes/malchishnik/' => '/cat/cupcakes/stagparty/',
	'/catalog/cupcakes/rozhdenie-rebenka/' => '/cat/cupcakes/child/',
	'/catalog/cupcakes/anniversary/' => '/cat/cupcakes/jubilee/',
	'/catalog/cupcakes/raznoe/' => '/cat/cupcakes/',
	'/catalog/cupcakes/wedding/' => '/cat/cupcakes/wedding/',
	'/catalog/cupcakes/kapkeyki-dlya-lyubimogo/' => '/cat/cupcakes/man/',
	'/catalog/cupcakes/kapkeyki-dlya-vlyublennyh/' => '/cat/cupcakes/love/',
	'/catalog/cupcakes/kapkeyki-na-godovshchinu/' => '/cat/cupcakes/anniversary/',
	'/catalog/cupcakes/fitness/' => '/cat/cupcakes/fitness/',
	'/catalog/cupcakes/' => '/cat/cupcakes/',

);

$dir = $APPLICATION->GetCurDir();
$url = '';
foreach ($redirect as $old => $new)
{
	if (strpos($dir, $old) === 0)
	{
		$url = $new;
		break;
	}
}

if (!$url)
	$url = '/cat/';

LocalRedirect($url, false, '301 Moved Permanently');
die();

if (isset($_REQUEST['IBLOCK_CODE'])) {
    CModule::IncludeModule("iblock");
    $res = CIBlock::GetList(
        array(),
        array('CODE' => $_REQUEST['IBLOCK_CODE']),
        false
    );
    $iBlockID = $res->Fetch();
    $_REQUEST['IBLOCK_ID'] = $iBlockID["ID"];
}else{
    $_REQUEST['IBLOCK_ID'] = 0;
    $iBlockID = 0;
}
//echo '----index';
?>




<section class="b-topblock b-topblock--pay-ship">
	</section>


    <section class="b-bg-grey">
		<!--block slider-->
        <div class="b-content-center b-slider-stock b-slider-cupcake">
            <div class="b-slider-stock-wrap">
                    <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"cupcake_banners_inner", 
	array(
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
		"COMPONENT_TEMPLATE" => "cupcake_banners_inner",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "DETAIL_TEXT",
			5 => "DETAIL_PICTURE",
			6 => "DATE_ACTIVE_FROM",
			7 => "ACTIVE_FROM",
			8 => "DATE_ACTIVE_TO",
			9 => "ACTIVE_TO",
			10 => "IBLOCK_TYPE_ID",
			11 => "IBLOCK_ID",
			12 => "IBLOCK_CODE",
			13 => "IBLOCK_NAME",
			14 => "IBLOCK_EXTERNAL_ID",
			15 => "",
		),
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
		"PROPERTY_CODE" => array(
			0 => "LINK_NAME",
			1 => "DISPLAY_MAIN",
			2 => "LINK",
			3 => "",
		),
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
	),
	false
);?>
            </div>
        </div>

			<div class="b-content-center b-content-center--cupcake">


                <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"cupcake_section_list", 
	array(
		"ADD_SECTIONS_CHAIN" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "cupcake_section_list",
		"COUNT_ELEMENTS" => "Y",
		"IBLOCK_ID" => $iBlockID["ID"],
		"IBLOCK_TYPE" => "catalog",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => array(
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "SORT",
			5 => "DESCRIPTION",
			6 => "PICTURE",
			7 => "DETAIL_PICTURE",
			8 => "IBLOCK_TYPE_ID",
			9 => "IBLOCK_ID",
			10 => "IBLOCK_CODE",
			11 => "IBLOCK_EXTERNAL_ID",
			12 => "DATE_CREATE",
			13 => "CREATED_BY",
			14 => "TIMESTAMP_X",
			15 => "MODIFIED_BY",
			16 => "",
		),
		"SECTION_ID" => "",
		"SECTION_URL" => "/catalog/#IBLOCK_CODE#/#SECTION_CODE#/",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "UF_ACSESS_BOUND",
			2 => "UF_DISPLAY_MAIN",
			3 => "UF_DATE",
			4 => "UF_PASSWORD",
			5 => "",
		),
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => "3",
		"VIEW_MODE" => "LIST"
	),
	false
); ?>

<?
$arrFilter = array(
    
);
if (isset($_REQUEST['new'])) {
    $arrFilter['!PROPERTY_NEW'] = false;
}
if (isset($_REQUEST['action'])) {
    $arrFilter['!PROPERTY_ACTION'] = false;
}

?>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter", 
	"pyst", 
	array(
		"CACHE_GROUPS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CONVERT_CURRENCY" => "N",
		"DISPLAY_ELEMENT_COUNT" => "Y",
		"FILTER_NAME" => "arrFilter",
		"FILTER_VIEW_MODE" => "vertical",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => $iBlockID["ID"],
		"IBLOCK_TYPE" => "catalog",
		"PAGER_PARAMS_NAME" => "arrPager",
		"PRICE_CODE" => "",
		"SAVE_IN_SESSION" => "N",
		"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
		"SECTION_DESCRIPTION" => "-",
		"SECTION_ID" => "",
		"SECTION_TITLE" => "-",
		"SEF_MODE" => "N",
		"TEMPLATE_THEME" => "blue",
		"XML_EXPORT" => "N",
		"COMPONENT_TEMPLATE" => "pyst",
		"POPUP_POSITION" => "left"
	),
	false
);?>
<?
$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"cupcake_catalog_section", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"BY_LINK" => "Y",
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
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"COMPONENT_TEMPLATE" => "cupcake_catalog_section",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => $iBlockID["ID"],
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
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
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
			0 => "",
			1 => "ACTION",
			2 => "FILLING",
			3 => "NEW",
			4 => "STAR_GIFT",
			5 => "PACKAGE",
			6 => "MINIMUM_PRICE",
		),
		"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "UF_ACSESS_BOUND",
			2 => "UF_DISPLAY_MAIN",
			3 => "UF_DATE",
			4 => "UF_PASSWORD",
			5 => "DESCRIPTION",
			6 => "",
		),
		"SEF_MODE" => "N",
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
		"USE_MAIN_ELEMENT_SECTION" => "Y",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y",
		"SEF_RULE" => "",
		"SECTION_CODE_PATH" => "",
		"PAGER_BASE_LINK" => "",
		"PAGER_PARAMS_NAME" => "arrPager",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N"
	),
	false
);?>

</section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>