<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Cupcake Story — семейная кондитерская. Капкейки, торты, эклеры, пряники, пирожные с доставкой на дом");
//$APPLICATION->ShowTitle();?><section class="b-topblock main-screen">
<div class="b-content-center">
	<div class="carousel-block">
		<div class="carousel-main">
		<div class="carousel-main-row">
				<a href="/news/aktsiya_30_skidki_na_kapkeyki_pri_pokupke_torta_brauni_s_vishney/">
					<img src="/images/broun.jpg" alt="">
					<div class="details">
						<h3>Капкейки за 1200р станут 900р</h3>
						<p>при заказе торта брауни, только в эту среду, четверг и пятницу.</p>
					</div>
				</a>
			</div>
			<div class="carousel-main-row">
 <a href="http://cupcakestory.ru/catalog/cakes/detskie/1811 "> <img src="/bitrix/templates/.default/images/2.jpg" alt="">
				<div class="details">
					<h3>ТОРТ "МОЯ МАЛЕНЬКАЯ ПРИНЦЕССА"</h3>
					<p>
						 Восхитительный торт из воздушного сливочного бисквита, со сливочно-ванильным кремом : высота 12 см, диаметр 16 см.
					</p>
				</div>
 </a>
			</div>
			<div class="carousel-main-row">
 <a href="http://cupcakestory.ru/sweet-table/"> <img src="http://cupcakestory.ru/bitrix/templates/.default/images/stol.jpg" alt="">
				<div class="details">
					<h3>Сладкий стол под ключ</h3>
					<p>
						 Сладкие столы под ключ на 10-15, 15-20, 25-30 человек. В стоимость сладкого стола входят: сладости ручной работы, декор (оформление в любой цветовой гамме, фон, топперы, аренда стола, посуды скатерти, задний фон), монтаж/демонтаж с выездом дизайнера и декоратора, доставка по Москве<br>
					</p>
				</div>
 </a>
			</div>
			
			 <!--
<div class="carousel-main-row">
						<a href="http://cupcakestory.ru/sweet-table/">
							<img src="http://cupcakestory.ru/bitrix/templates/.default/images/stol.jpg" alt="">
							<div class="details">
								<h3>Сладкий стол под ключ</h3>
								<p> Сладкие столы под ключ на 10-15, 15-20, 25-30 человек. В стоимость сладкого стола входят: сладости ручной работы, декор (оформление в любой цветовой гамме, фон, топперы, аренда стола, посуды скатерти, задний фон), монтаж/демонтаж с выездом дизайнера и декоратора, доставка по Москве</p>
							</div>
						</a>
					</div>
-->
		</div>
		<div class="carousel-thumbs">
			<div class="carousel-thumbs-row">
 <a href="http://cupcakestory.ru/catalog/cakes/detskie/1781"> <img src="http://cupcakestory.ru/bitrix/templates/.default/images/%D1%82%D1%80%D0%B0%D0%BA%D1%82%D0%BE%D1%80%201.jpg">
				<div class="details">
					<h3>Торт "Едет трактор по полям"</h3>
					<p>
						 Торт из воздушного шоколадного бисквита и нежного шоколадного крем чиза: высота 12 см, диаметр 16 см, вес 1670 г (8-12 чел.)
					</p>
				</div>
 </a>
			</div>
			<div class="carousel-thumbs-row">
 <a href="http://cupcakestory.ru/catalog/cakes/detskie/1782"> <img src="http://cupcakestory.ru/bitrix/templates/.default/images/%D0%B4%D0%B8%D0%BD%D0%BE%D0%B7%D0%B0%D0%B2%D1%80.jpg" alt="">
				<div class="details">
					<h3>Потрясающий торт "Сладкий дино"</h3>
					<p>
						 Торт из воздушного белого бисквита, нежного крем-чиза, клубничного желе, тонкий хрустящий слой-нугатин. Торт высотой 10 см, диаметр 16 см, вес 1850 г (8-12 чел.).
					</p>
				</div>
 </a>
			</div>
		</div>
	</div>
</div>
 </section> <section class="b-bg-grey">
<!--block slider-->
<div class="b-mod b-mod--novelty">
	 <? $arrFilter = array("!PROPERTY_NEW" => false) ?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"cupcake_section_slider_main",
	Array(
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
		"COMPONENT_TEMPLATE" => "cupcake_section_slider_main",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "asc",
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
		"OFFERS_CART_PROPERTIES" => array(0=>"ARTICLE",1=>"NUMBER",2=>"TAGS",3=>"STAR_GIFT_PRICE",),
		"OFFERS_FIELD_CODE" => array(0=>"ID",1=>"CODE",2=>"XML_ID",3=>"NAME",4=>"TAGS",5=>"SORT",6=>"PREVIEW_TEXT",7=>"PREVIEW_PICTURE",8=>"DETAIL_TEXT",9=>"DETAIL_PICTURE",10=>"IBLOCK_TYPE_ID",11=>"IBLOCK_ID",12=>"IBLOCK_CODE",13=>"IBLOCK_NAME",14=>"IBLOCK_EXTERNAL_ID",15=>"",),
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array(0=>"ARTICLE",1=>"NUMBER",2=>"TAGS",3=>"STAR_GIFT_PRICE",4=>"",),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "desc",
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
		"PRICE_CODE" => array(0=>"BASE",),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(0=>"ACTION",1=>"PACKAGE",2=>"NOT_AVAILABLE",3=>"NEW",4=>"STAR_GIFT",5=>"FILLING",),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "items_num",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(0=>"ACTION",1=>"PACKAGE",2=>"NOT_AVAILABLE",3=>"NEW",4=>"ACTION_TEXT",5=>"STAR_GIFT",6=>"FILLING",7=>"",),
		"SECTION_CODE" => "",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(0=>"UF_ACSESS_BOUND",1=>"UF_DISPLAY_MAIN",2=>"UF_DATE",3=>"UF_PASSWORD",4=>"",),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "blue",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y"
	)
);?>
</div>
<div class="b-mod b-mod--cupcake">
	<div class="b-title b-title--border-middle">
		<div class="b-title__item b-title__item--grey">
			 КАПКЕЙКИ
		</div>
	</div>
	<div class="home_cupcake-wrap">
		 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"cupcake_section_main_new",
	Array(
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "tree",
		"COUNT_ELEMENTS" => "Y",
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "catalog",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => array(0=>"ID",1=>"CODE",2=>"XML_ID",3=>"NAME",4=>"SORT",5=>"DESCRIPTION",6=>"PICTURE",7=>"DETAIL_PICTURE",8=>"IBLOCK_TYPE_ID",9=>"IBLOCK_ID",10=>"IBLOCK_CODE",11=>"IBLOCK_EXTERNAL_ID",12=>"DATE_CREATE",13=>"CREATED_BY",14=>"TIMESTAMP_X",15=>"MODIFIED_BY",16=>"NOT_AVAILABLE",),
		"SECTION_ID" => "",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(0=>"UF_ACSESS_BOUND",1=>"UF_DISPLAY_MAIN",2=>"",),
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => "10",
		"VIEW_MODE" => "LINE"
	)
);?>
	</div>
</div>
<div class="b-mailing">
 <a href="#" class="b-mailing__item-img"> <img src="/bitrix/templates/.default/images/mail.png" alt=""> </a>
	<div class="b-mailing-text">
		 подпишитесь на нашу рассылку, чтоб быть в курсе последних новинок и акций
	</div>
	<div class="b-title b-title--border-middle">
		<div class="b-title__item b-title__item--grey">
 <a href="#" class="bnt-mailing"> подписаться</a>
		</div>
	</div>
</div>
<div class="b-slider">
 <a href="/celebrity-stories/" class="b-mod__link--text-hover">звездные истории </a>
	<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"cupcake_main_star_stroies",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "cupcake_main_star_stroies",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"ID",1=>"CODE",2=>"XML_ID",3=>"NAME",4=>"TAGS",5=>"SORT",6=>"PREVIEW_TEXT",7=>"PREVIEW_PICTURE",8=>"DETAIL_TEXT",9=>"DETAIL_PICTURE",10=>"IBLOCK_TYPE_ID",11=>"IBLOCK_ID",12=>"IBLOCK_CODE",13=>"IBLOCK_NAME",14=>"IBLOCK_EXTERNAL_ID",15=>"NOT_AVAILABLE",),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "19",
		"IBLOCK_TYPE" => "star_stories",
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
		"PROPERTY_CODE" => array(0=>"MAIN_OUTPUT",1=>"STATUS",2=>"SURNAME",3=>"NOT_AVAILABLE",),
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
 </section><?
?>


<?
\Local\Remarketing::setPageType('home');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");