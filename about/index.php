<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О компании");
?><section class="b-topblock b-topblock--about">
<div class="b-about-text">
	<h1><div class="b-about-top-text__title">
		 Добро пожаловать в&nbsp;сладкий, волшебный мир Cupcake Story!
	</div></h1>
	<div class="b-about-top-text__sub">
 <span class="b-about-top-text__sub-item">
		Cupcake Story &mdash; это сладкий, звездный проект Сергея Жукова и Регины Бурд . Cupcake Story &mdash; это не просто кондитерская, создающая дизайнерские капкейки и десерты для особенных событий вашей жизни. Это семья, вкладывающая в каждый заказ частичку души и создающая маленькую, вкусную историю для вас и ваших близких. </span>
<span class="b-about-top-text__sub-item">Cupcake Story &mdash; это более 50 потрясающих вкусов, неповторимый дизайн каждого капкейка и торта, натуральные ингредиенты и индивидуальный подход к каждому вашему заказу!</span><span class="b-about-top-text__sub-item"> 
Выбрав кондитерскую Cupcake Story один раз, вы непременно захотите стать частичкой сладкой семьи и останетесь с нами надолго.</span>
	</div>
</div>
 </section> <section class="b-bg-grey">
<div class="b-content-center b-ingredients">
	<div class="b-ingredients__title">
		 Попробовать стоит
	</div>
	<ul class="b-ingredients__list">
		<li class="b-ingredients__item">
		<div class="b-ingredients__img">
 <img src="/bitrix/templates/.default/images/pic/about-pic1.png" alt="">
		</div>
		<div class="b-ingredients__text">
			 Мы используем только натуральные ингредиенты высокого качества (никаких порошков, маргаринов, заменителей и т.п.). Только настоящее масло, молоко и&nbsp;йогурт, сливки, фрукты и фруктовые пюре, орехи и ягоды, всегда просеянная мука, настоящий шоколад и какао.
		</div>
 </li>
		<li class="b-ingredients__item">
		<div class="b-ingredients__img">
 <img src="/bitrix/templates/.default/images/pic/about-pic2.png" alt="">
		</div>
		<div class="b-ingredients__text">
			 Мы предлагаем самое большое разнообразие вкусов капкейков и макаронс! Собирая рецепты, ароматы и вкусовые сочетания со всего света, мы создаем свои уникальные капкейки, которые могут порадовать самого искушенного сладкоежку.
		</div>
 </li>
		<li class="b-ingredients__item">
		<div class="b-ingredients__img">
 <img src="/bitrix/templates/.default/images/pic/about-pic3.png" alt="">
		</div>
		<div class="b-ingredients__text">
			 Мы любим полезные сладости, поэтому используем всевозможные виды муки, благодаря чему получаются не только уникальные аутентичные вкусы капкейков но и достигается максимальная польза (при использовании ореховой, фруктовой, ржаной, муки грубого помола, отрубей и т.п.).
		</div>
 </li>
		<li class="b-ingredients__item">
		<div class="b-ingredients__img">
 <img src="/bitrix/templates/.default/images/pic/about-pic4.png" alt="">
		</div>
		<div class="b-ingredients__text">
			 Мы рады всем друзьям и друзьям друзей, вегетарианцам, веганам и постящимся! Поэтому мы всегда можем изготовить неизменно вкусные капкейки без добавления яиц, молочных продуктов и возможных аллергенов (орехи, мед, и т.п.).
		</div>
 </li>
		<li class="b-ingredients__item">
		<div class="b-ingredients__img">
 <img src="/bitrix/templates/.default/images/pic/about-pic5.png" alt="">
		</div>
		<div class="b-ingredients__text">
			 Мы занимаемся любимым делом! Каждый капкейк/пирожное/любая сладость изготовлены вручную и хранят в себе тепло заботливых рук, аутентичный вкус натуральных продуктов, лучик солнца и отличное настроение!
		</div>
 </li>
		<li class="b-ingredients__item">
		<div class="b-ingredients__img">
 <img src="/bitrix/templates/.default/images/pic/about-pic6.png" alt="">
		</div>
		<div class="b-ingredients__text">
			 Мы делаем наши капкейки не только вкусными, но и красивыми! Помимо классического, авторского дизайна, Вы всегда можете заказать индивидуальный дизайн капкейков и макаронс для вашего торжества!
		</div>
 </li>
	</ul>
</div>
 <?$APPLICATION->IncludeComponent(
	"bitrix:photogallery", 
	"cupcake_gallery", 
	array(
		"ADDITIONAL_SIGHTS" => array(
		),
		"ALBUM_PHOTO_SIZE" => "120",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "cupcake_gallery",
		"DATE_TIME_FORMAT_DETAIL" => "d.m.Y",
		"DATE_TIME_FORMAT_SECTION" => "d.m.Y",
		"DRAG_SORT" => "N",
		"ELEMENTS_PAGE_ELEMENTS" => "50",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "desc",
		"IBLOCK_ID" => "20",
		"IBLOCK_TYPE" => "gallery",
		"JPEG_QUALITY" => "100",
		"JPEG_QUALITY1" => "100",
		"ORIGINAL_SIZE" => "1280",
		"PAGE_NAVIGATION_TEMPLATE" => "",
		"PATH_TO_FONT" => "default.ttf",
		"PATH_TO_USER" => "",
		"PHOTO_LIST_MODE" => "Y",
		"SECTION_PAGE_ELEMENTS" => "15",
		"SECTION_SORT_BY" => "UF_DATE",
		"SECTION_SORT_ORD" => "DESC",
		"SEF_MODE" => "N",
		"SET_TITLE" => "N",
		"SHOWN_ITEMS_COUNT" => "50",
		"SHOW_LINK_ON_MAIN_PAGE" => array(
			0 => "comments",
		),
		"SHOW_NAVIGATION" => "N",
		"SHOW_TAGS" => "N",
		"THUMBNAIL_SIZE" => "100",
		"UPLOAD_MAX_FILE_SIZE" => "2",
		"USE_COMMENTS" => "N",
		"USE_LIGHT_VIEW" => "Y",
		"USE_RATING" => "N",
		"USE_WATERMARK" => "Y",
		"WATERMARK_MIN_PICTURE_SIZE" => "800",
		"WATERMARK_RULES" => "USER",
		"VARIABLE_ALIASES" => array(
			"SECTION_ID" => "SECTION_ID",
			"ELEMENT_ID" => "ELEMENT_ID",
			"PAGE_NAME" => "PAGE_NAME",
			"ACTION" => "ACTION",
		)
	),
	false
);?>
<div class="b-content-center b-slider-about-novelty">
	<div class="b-title b-title--border-middle">
		<div class="b-title__item b-title__item--grey">
 <span href="#" class="b-mod--about-novelty__item-img">
			У нас есть много вкусных сладостей </span>
		</div>
	</div>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"cupcake_section_slider",
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
		"COMPONENT_TEMPLATE" => "cupcake_section_slider",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "created",
		"ELEMENT_SORT_FIELD2" => "",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_ORDER2" => "",
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
		"OFFERS_FIELD_CODE" => array(0=>"ID",1=>"CODE",2=>"XML_ID",3=>"NAME",4=>"TAGS",5=>"SORT",6=>"PREVIEW_TEXT",7=>"PREVIEW_PICTURE",8=>"DETAIL_TEXT",9=>"DETAIL_PICTURE",10=>"IBLOCK_TYPE_ID",11=>"IBLOCK_ID",12=>"IBLOCK_CODE",13=>"IBLOCK_NAME",14=>"IBLOCK_EXTERNAL_ID",15=>"DATE_CREATE",16=>"",),
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array(0=>"ARTICLE",1=>"NUMBER",2=>"TAGS",3=>"STAR_GIFT_PRICE",4=>"FILLING",5=>"",),
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
		"PRICE_CODE" => array(0=>"BASE",),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(0=>"ACTION",1=>"NEW",2=>"STAR_GIFT",),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "items_num",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(0=>"ACTION",1=>"NEW",2=>"STAR_GIFT",3=>"",),
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
		"USE_PRODUCT_QUANTITY" => "Y"
	)
);?>
</div>
 </section><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>