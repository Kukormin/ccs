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
);?>
<div class="b-content-center b-contact-info" itemscope="" itemtype="http://schema.org/Organization">
	<div class="b-contact-info__link-wrap b-contact-info__item">
		<p class="clearfix">
 <a href="tel:+74993220020" class="b-contact-info__link-phone" itemprop="telephone">+7 (499) 322 00 20</a> <a href="mailto:zakaz@cupcakestory.ru" class="b-contact-info__link-email" itemprop="email"><b>zakaz@cupcakestory.ru</b></a>
		</p>
		<p>
 <b>Оптовые поставки,&nbsp;ритейл</b><br>
			 тел.: +7 (499) 322-00-20 (доб. 103), email: <a href="mailto:taisiyal@cupcakestory.ru">taisiyal(собака)cupcakestory.ru</a>
		</p>
		<p>
			 Реклама email:<a href="mailto:dorofeeva@cupcakestory.ru">dorofeeva@cupcakestory.ru</a>
		</p>
		<p>
			 Отдел закупок:&nbsp;<a href="mailto:sklad@cupcakestory.ru">sklad@cupcakestory.ru</a><br>
		</p>
 <img src="/images/scheme.jpg" alt="схема">
	</div>
	<div class="b-contact-info__item">
		<p itemprop="name">
 <b>Семейная кондитерская "Cupcake Story"</b>
		</p>
		<p itemprop="contactPoint" itemscope="" itemtype="http://schema.org/ContactPoint">
			 Заказы в интернет-магазине принимаются по телефону <span itemprop="hoursAvailable" datetime="Mo-Fr 10:00−20:00">с понедельника по пятницу с 10 до 20.</span> <span itemprop="hoursAvailable" datetime="Sa,Su 10:00−17:00">По&nbsp;субботам и воскресеньям с&nbsp;10&nbsp;до&nbsp;17.</span>
		</p>
		<p itemprop="contactPoint" itemscope="" itemtype="http://schema.org/ContactPoint">
 <b>Мини-кафе в Москве в Фуд Маркете улица Новый Арбат, 21.&nbsp;</b>
		</p>
		<p itemprop="contactPoint" itemscope="" itemtype="http://schema.org/ContactPoint">
 <b>Режим работы:&nbsp;&nbsp;ежедневно&nbsp;с 12 до 24.&nbsp;<br>
 </b>
		</p>
		<p itemprop="contactPoint" itemscope="" itemtype="http://schema.org/ContactPoint">
 <b>Мини-кафе в Москве на Даниловском рынке. </b>Справа от главного входа.<b><br>
 </b>
		</p>
		<p itemprop="contactPoint" itemscope="" itemtype="http://schema.org/ContactPoint">
 <b>Режим работы:&nbsp;&nbsp;ежедневно&nbsp;с 10 до 21.&nbsp;</b><br>
		</p>
		<p itemprop="contactPoint" itemscope="" itemtype="http://schema.org/ContactPoint">
			 Узнать о наличии продукции на Даниловском рынке, забронировать продукцию можно по номеру +7 (967) 022-99-03 (WhatsApp,Telegram).<b>&nbsp;</b><br>
		</p>
		<p itemprop="contactPoint" itemscope="" itemtype="http://schema.org/ContactPoint">
 <b><i>Внимание! В кафе нельзя сделать заказ на индивидуальный дизайн.</i></b>
		</p>
		<p>
 <br>
		</p>
		<p>
 <strong>Точки самовывоза.</strong><br>
		</p>
		<p>
 <strong style="font-weight:bold">1) Фабрика «Кристалл»</strong><br>
			 Вводите в навигатор «Самокатная, 4с9». Вход на фабрику будет возле больших железных красных ворот.<br>
			 Режим работы: понедельник-пятница с 10 до 20, суббота-воскресенье с&nbsp;10&nbsp;до&nbsp;17.&nbsp;
		</p>
		<p>
 <b>1,8,9 мая мы работаем с 10 до 17.</b>
		</p>
		<p>
 <b>Как добраться:</b>
		</p>
		<p>
 <b>Пешком на "Кристалл"</b><b>:&nbsp;</b>
		</p>
		<p>
			 Проходим через центральную проходную завода.<br>
			 Поворачиваем направо в арку. Видим фонтан, и еще одну арку. Проходим ее. Идем прямо до конца слева будет зеленая лестница. Вам сюда.&nbsp; Поднимаемся на второй этаж. Слева дверь вам сюда!
		</p>
		<p>
 <b>На машине&nbsp;на "Кристалл:</b><br>
		</p>
		<p>
			 Напротив церкви вы увидите красные ворота завода Кристалл и шлагбаум. Вам туда. Если закрыты - не стесняйтесь посигналить.&nbsp; Берите у охраника пропуск (не забудьте поставить потом у нас печать, чтобы отдать на выезде). Дальше езжайте прямо, пока не переедете железнодорожные пути (примерно метров 200).&nbsp; За ними - направо, и где-то через 100 метров снова направо через рельсы.&nbsp; Огибаете угол дома вправо и увидите площадку с зеленой лестницей наверх.&nbsp; Паркуйтесь рядом и поднимайтесь по лестнице на 2 этаж. Следите за указателями.
		</p>
	</div>
</div>
 <!--map-->
<div class="b-maps">
	<div id="gmap" class="b-gmap">
	</div>
	 <?

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
		"EMAIL_TO" => "taisiyal@cupcakestory.ru",
		"EVENT_MESSAGE_ID" => array(),
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => array(0=>"MESSAGE",),
		"USE_CAPTCHA" => "Y"
	)
);?>
</div>
 </section> <br>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>