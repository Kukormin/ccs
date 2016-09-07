<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Пирожные на заказ");
?><style>
.new_descr ul {
	list-style: initial;
	margin: 10px;
	margin-left: 30px;
}

h2 {
	font-family: 'PTSansRegular', sans-serif;
	font-size: 21px !important;
	font-weight: bold;
	text-align: left;
	margin: 10px 0 !important;
}

h3 {
	font-family: 'PTSansRegular', sans-serif;
	font-size: 19px;
}

h4 {
	font-family: 'PTSansRegular', sans-serif;
	font-size: 17px;
}

h1 {
	font-size: 18px;
	line-height: 30px;
	font-family: 'Lasco Bold', sans-serif;
	text-transform: uppercase;
	color: #a3a67b;
}

.new_descr p {
	text-align: justify;
	color: #22303d;
	font-size: 14px;
	line-height: 25px;
	font-family: 'PTSansRegular', sans-serif;
}

.new_descr {
	margin-top: 50px;
text-align: justify;
	color: #22303d;
	font-size: 14px;
	line-height: 25px;
	font-family: 'PTSansRegular', sans-serif;
}
</style>
<section class="b-topblock b-topblock--pay-ship"></section>
<div class="b-content-center b-content-center--cupcake" style="padding-top: 45px;">
	<div class="b-grey-wrap-top b-grey-wrap-top--asaide">
		<div class="b-grey-wrap-top-right">
			<div class="b-grey-wrap-bottom">
				<div class="b-grey-wrap-bottom-right">
					 <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"left-menu-zakazat",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "zakazat",
		"COMPONENT_TEMPLATE" => ".default",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => "",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_THEME" => "site",
		"ROOT_MENU_TYPE" => "zakazat",
		"USE_EXT" => "N"
	)
);?>
					<div style="clear: both;">
					</div>
				</div>
			</div>
		</div>
	</div>
	 <div class="new_descr b-catalog-wrap--cupcake">
<h1>Пирожные на заказ</h1>
<p>Ни один праздник не обходится без завершающего чаепития с вкусными десертами и сладостями. К вечеру, обычно, закуски и винные бутылки на столе сменяются красивым, аппетитным тортом или набором роскошных пирожных.</p>

<p>Если вы хотите придать своему мероприятию индивидуальный колорит, обязательно закажите пирожные. Таки способом можно воплотить в кондитерском изделии все свои пожелания. Совсем необязательно главным украшением стола должен быть торт. Не менее интересно выглядят композиции из пирожных на заказ. Во-первых, можно подобрать эти лакомства различной формы и сложить из них композицию. Во-вторых, выбрав пирожные с разнообразными начинками, можно не беспокоиться, что кому-то не придется по вкусу десерт.</p>

<p>Пирожные на заказ отлично подойдут для празднования именин на работе. Коллеги с удовольствием поздравят виновника торжества, который угостит их такой вкуснятиной. Это гораздо практичнее, чем нести с собой огромный торт. Каждое пирожное — это отдельная порция, поэтому вам не придется трать время на разрезание угощения. </p>

<p>Кроме того, пирожные на заказ незаменимы, когда нужно собрать на воскресный пикник с классом ребенка. Расположившись на лоне природы и нагуляв аппетит во время прогулки, дети с удовольствием полакомятся замечательным десертом. Пирожные окажутся очень кстати и на других классных мероприятиях, утренниках и сладких столах.</p>

<p>Заказ пирожных с доставкой имеет массу преимуществ. Покупатель может выбрать из каталога кондитерские изделия, наиболее подходящие по вкусу и оформлению к случаю, для которого они приобретаются.</p>

<p>Если необходимо сделать вкусный подарок девушке, стоит обратить внимание на красочно оформленное лакомство изящной формы. Дамы особо ценят утонченность вкуса. Если в гости ожидаются дети, лучше подобрать пирожные, своей формой напоминающие фигурки животных или мультяшных героев — с такими пирожными пить чай не только вкусно, но и весело!</p>

<p>Заказ пирожных на дом очень удобен, особенно когда почти весь день занят работой, а на хождение по магазинам просто нет времени. При этом неважно, в каком районе Москвы вы находитесь, ведь доставка вкусняшек от Cupcake Story осуществляется в любую точку столицы.</p>

<p>А еще заказ пирожных с доставкой очень удобен, когда гости приходят неожиданно, особенно вечером. В этом случае можно связаться с менеджером компании, и уже в ближайшее время изысканные лакомства окажутся на вашем столе. Вечеринка будет красиво завершена или, напротив, веселье продолжится с новыми силами!</p>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"cupcake_section_slider_final", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
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
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "cupcake_section_slider_final",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "",
		"ELEMENT_SORT_FIELD2" => "",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_ORDER2" => "",
		"FILTER_NAME" => "",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "40",
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
			0 => "ARTICLE",
			1 => "NUMBER",
			2 => "TAGS",
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
			5 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "15",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
			0 => "ACTION",
			1 => "NEW",
			2 => "STAR_GIFT",
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "items_num",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(
			0 => "ACTION",
			1 => "NEW",
			2 => "STAR_GIFT",
			3 => "",
		),
		"SECTION_CODE" => "",
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
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
		"DISABLE_INIT_JS_IN_COMPONENT" => "N"
	),
	false
);?>
</div>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>