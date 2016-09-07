<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "ЭКЛЕРЫ НА ЗАКАЗ В СЕМЕЙНОЙ КОНДИТЕРСКОЙ CUPCAKE STORY");
$APPLICATION->SetPageProperty("title", "ЭКЛЕРЫ НА ЗАКАЗ В СЕМЕЙНОЙ КОНДИТЕРСКОЙ CUPCAKE STORY");
$APPLICATION->SetTitle("Эклеры на заказ");
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
</style> <section class="b-topblock b-topblock--pay-ship"></section>
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
		<h1>Эклеры на заказ в семейной кондитерской Cupcake Story</h1>
		<p>
			 Кондитерская семьи Жуковых Cupcake Story готовит лучшие традиционные и праздничные эклеры на заказ. Мечтаете о произведениях кулинарного искусства? Вы на правильном пути. Одни названия рецептов обещают вкусное удовольствие. Здесь и «Цветочная акварель», и «Сладкая награда», и «Влюбленный Шекспир».
		</p>
		<p>
			 Желаете чего-то уникального? Выберите нужные рецепт эклеров и внесите в него свои изменения, будь то оригинальные украшения на глазури или россыпь ягодного ассорти — на заказ мы вы выполним любую просьбу.
		</p>
		<h2>Почему Cupcake Story?</h2>
		<p>
			 Корзинка эклеров на заказ — это прекрасный повод узнать новую сладкую историю, которая никогда не будет повторять прошлую.
		</p>
		<ul>
			<li>Традиционные рецепты + эксперименты. Традиции бабушек, мам и знакомых лежат в основе нашей оригинальной рецептуры, но потому она и не необычна, что каждое пирожное — отдельный маленький шедевр.</li>
			<li>Как дома. Мы не используем порошки, красители и консерванты. Только натуральные продукты: масло, сливки, фрукты, орехи, муку, какао и шоколад.</li>
			<li>Вегетарианские и постные блюда. Мы с радостью испечем эклеры на заказ без добавления яиц и молочных продуктов — для постящихся и вегетарианцев.</li>
		</ul>
		<p>
			 «Закажу еще — 100 %». Реальный отзыв одного из наших подписчиков. И мы счастливы знать, что наши сладкие истории находят отклик в чужих сердцах.
		</p>
		<p>
			 Заказывайте у нас сладости с доставкой в Москве к дню рождения, приему, семейному чаепитию. Ваша коробочка с пирожными прибудет в нужное время. Для этого просто заполните заявку на сайте и определитесь со способом оплаты.
		</p>
		<p>
			 К примеру, доставка с курьером удобна возможностью оплаты наличными. Если же получатель — именинник, предоплата с банковской карты позволит не раскрывать имя дарителя и стоимость поздравления.
		</p>
		<h2>Приходите к нам еще и оставайтесь с Cupcake Story!</h2>
<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "cupcake_section_slider_final1", Array(
	"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"ADD_PICT_PROP" => "-",	// Дополнительная картинка основного товара
		"ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"ADD_TO_BASKET_ACTION" => "ADD",	// Показывать кнопку добавления в корзину или покупки
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"BACKGROUND_IMAGE" => "-",	// Установить фоновую картинку для шаблона из свойства
		"BASKET_URL" => "/personal/cart",	// URL, ведущий на страницу с корзиной покупателя
		"BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"COMPONENT_TEMPLATE" => "cupcake_section_slider_final",
		"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
		"DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
		"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"ELEMENT_SORT_FIELD" => "",	// По какому полю сортируем элементы
		"ELEMENT_SORT_FIELD2" => "",	// Поле для второй сортировки элементов
		"ELEMENT_SORT_ORDER" => "desc",	// Порядок сортировки элементов
		"ELEMENT_SORT_ORDER2" => "",	// Порядок второй сортировки элементов
		"FILTER_NAME" => "",	// Имя массива со значениями фильтра для фильтрации элементов
		"HIDE_NOT_AVAILABLE" => "N",	// Не отображать товары, которых нет на складах
		"IBLOCK_ID" => "7",	// Инфоблок
		"IBLOCK_TYPE" => "catalog",	// Тип инфоблока
		"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
		"LABEL_PROP" => "-",	// Свойство меток товара
		"LINE_ELEMENT_COUNT" => "3",	// Количество элементов выводимых в одной строке таблицы
		"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
		"MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
		"MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
		"MESS_BTN_SUBSCRIBE" => "Подписаться",	// Текст кнопки "Уведомить о поступлении"
		"MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
		"META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
		"META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
		"OFFERS_CART_PROPERTIES" => array(	// Свойства предложений, добавляемые в корзину
			0 => "ARTICLE",
			1 => "NUMBER",
			2 => "TAGS",
		),
		"OFFERS_FIELD_CODE" => array(	// Поля предложений
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
		"OFFERS_LIMIT" => "5",	// Максимальное количество предложений для показа (0 - все)
		"OFFERS_PROPERTY_CODE" => array(	// Свойства предложений
			0 => "ARTICLE",
			1 => "NUMBER",
			2 => "TAGS",
			3 => "STAR_GIFT_PRICE",
			4 => "FILLING",
			5 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",	// По какому полю сортируем предложения товара
		"OFFERS_SORT_FIELD2" => "id",	// Поле для второй сортировки предложений товара
		"OFFERS_SORT_ORDER" => "asc",	// Порядок сортировки предложений товара
		"OFFERS_SORT_ORDER2" => "desc",	// Порядок второй сортировки предложений товара
		"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
		"PAGER_TITLE" => "Товары",	// Название категорий
		"PAGE_ELEMENT_COUNT" => "15",	// Количество элементов на странице
		"PARTIAL_PRODUCT_PROPERTIES" => "N",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
		"PRICE_CODE" => array(	// Тип цены
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"PRODUCT_DISPLAY_MODE" => "N",	// Схема отображения
		"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
		"PRODUCT_PROPERTIES" => array(	// Характеристики товара
			0 => "ACTION",
			1 => "NEW",
			2 => "STAR_GIFT",
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
		"PRODUCT_QUANTITY_VARIABLE" => "items_num",	// Название переменной, в которой передается количество товара
		"PRODUCT_SUBSCRIPTION" => "N",	// Разрешить оповещения для отсутствующих товаров
		"PROPERTY_CODE" => array(	// Свойства
			0 => "ACTION",
			1 => "NEW",
			2 => "STAR_GIFT",
			3 => "",
		),
		"SECTION_CODE" => "",	// Код раздела
		"SECTION_ID" => "",	// ID раздела
		"SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
		"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
		"SECTION_USER_FIELDS" => array(	// Свойства раздела
			0 => "",
			1 => "",
		),
		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
		"SET_BROWSER_TITLE" => "Y",	// Устанавливать заголовок окна браузера
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"SET_META_DESCRIPTION" => "Y",	// Устанавливать описание страницы
		"SET_META_KEYWORDS" => "Y",	// Устанавливать ключевые слова страницы
		"SET_STATUS_404" => "N",	// Устанавливать статус 404
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"SHOW_404" => "N",	// Показ специальной страницы
		"SHOW_ALL_WO_SECTION" => "Y",	// Показывать все элементы, если не указан раздел
		"SHOW_CLOSE_POPUP" => "N",	// Показывать кнопку продолжения покупок во всплывающих окнах
		"SHOW_DISCOUNT_PERCENT" => "N",	// Показывать процент скидки
		"SHOW_OLD_PRICE" => "N",	// Показывать старую цену
		"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
		"TEMPLATE_THEME" => "blue",	// Цветовая тема
		"USE_MAIN_ELEMENT_SECTION" => "N",	// Использовать основной раздел для показа элемента
		"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
		"USE_PRODUCT_QUANTITY" => "Y",	// Разрешить указание количества товара
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",	// Не подключать js-библиотеки в компоненте
	),
	false
);?><br>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>