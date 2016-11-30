<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "На данной странице предоставлены контакты нашей компании");
$APPLICATION->SetPageProperty("title", "Контакты");
$APPLICATION->SetTitle("Контакты");

?><section class="b-topblock b-topblock--pay-ship"></section> <section class="b-bg-grey b-bg-grey--contact">
<h1 style="text-align:center">
<div class="b-content-center--title i-padding__top-100">
	 Контакты
</div>
 </h1>
<div class="b-bg-grey-contact--title">
	 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"cupcake_adr_contacts",
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
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "cupcake_adr_contacts",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array("",""),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "27",
		"IBLOCK_TYPE" => "pickupadr",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
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
		"PROPERTY_CODE" => array("PICKUP_ADR","SCHEDULE","COORDS",""),
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
);?>контакты
</div>
 <!--info-->
<div class="b-content-center b-contact-info">
	<div class="b-contact-info__link-wrap">
 <a href="tel:+74993220020" class="b-contact-info__link-phone">+7 499 322 00 20</a> <a href="mailto:zakaz@cupcakestory.ru" class="b-contact-info__link-email">zakaz@cupcakestory.ru</a>
	</div>
	<div class="b-contact-info__item">
		<p>
			 Заказы в интернет-магазине принимаются по телефону с понедельника по пятницу с 10 до 20. По&nbsp;субботам и воскресеньям с&nbsp;10&nbsp;до&nbsp;17.
		</p>
		<p>
 <strong style="font-weight:bold">Точка самовывоза. Фабрика «Кристалл»</strong><br>
			 Вводите в навигатор «Самокатная, 4с9». Вход на фабрику будет возле больших железных красных ворот.<br>
			 Режим работы: понедельник-пятница с 10 до 20, суббота-воскресенье с&nbsp;10&nbsp;до&nbsp;17.
		</p>
	</div>
</div>
 <!--map-->
<div class="b-maps">
	<div id="gmap" class="b-gmap"></div><?

	/*?>
	<div class="b-contact-label">пункты самовывоза</div><?*/

	?>
</div>
 <!--form-->
<div class="b-content-center b-contact-table--form">
	 <?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback",
	"cupcake_feedback",
	Array(
		"COMPONENT_TEMPLATE" => "cupcake_feedback",
		"EMAIL_TO" => "zakaz@cupcakestory.ru",
		"EVENT_MESSAGE_ID" => array(),
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => array(0=>"MESSAGE",),
		"USE_CAPTCHA" => "Y"
	)
);?>
</div>
 </section> <br>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>