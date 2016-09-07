<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подарок для звезды");
?><?$APPLICATION->IncludeComponent(
	"bitrix:news",
	"cupcake_gift_for_star",
	Array(
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "cupcake_gift_for_star",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(0=>"",1=>"",),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Подарок для звезды",
		"DETAIL_PROPERTY_CODE" => array(0=>"BIRTHDAY",1=>"STATUS",2=>"SURNAME",3=>"",),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "17",
		"IBLOCK_TYPE" => "gift_for_star",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(0=>"",1=>"",),
		"LIST_PROPERTY_CODE" => array(0=>"BIRTHDAY",1=>"STATUS",2=>"SURNAME",3=>"",),
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "16",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "cupcake_pagenav",
		"PAGER_TITLE" => "Подарок для звезды",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_MODE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_REVIEW" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N",
		"VARIABLE_ALIASES" => array("SECTION_ID"=>"SECTION_ID","ELEMENT_ID"=>"ELEMENT_ID",)
	)
);?><br>
 <br>
<? if (isset($_GET['ELEMENT_ID'])) { ?>
	<? $APPLICATION->IncludeComponent("bitrix:catalog.top", "catalog_gift_for_star", Array(
		"ACTION_VARIABLE" => "action",    // Название переменной, в которой передается действие
		"ADD_PROPERTIES_TO_BASKET" => "Y",    // Добавлять в корзину свойства товаров и предложений
		"ADD_TO_BASKET_ACTION" => "ADD",    // Показывать кнопку добавления в корзину или покупки
		"BASKET_URL" => "/personal/basket.php",    // URL, ведущий на страницу с корзиной покупателя
		"CACHE_FILTER" => "N",    // Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",    // Учитывать права доступа
		"CACHE_TIME" => "36000000",    // Время кеширования (сек.)
		"CACHE_TYPE" => "A",    // Тип кеширования
		"COMPONENT_TEMPLATE" => ".default",
		"CONVERT_CURRENCY" => "N",    // Показывать цены в одной валюте
		"DETAIL_URL" => "",    // URL, ведущий на страницу с содержимым элемента раздела
		"DISPLAY_COMPARE" => "N",    // Разрешить сравнение товаров
		"ELEMENT_COUNT" => "12",    // Количество выводимых элементов
		"ELEMENT_SORT_FIELD" => "sort",    // По какому полю сортируем элементы
		"ELEMENT_SORT_FIELD2" => "id",    // Поле для второй сортировки элементов
		"ELEMENT_SORT_ORDER" => "asc",    // Порядок сортировки элементов
		"ELEMENT_SORT_ORDER2" => "desc",    // Порядок второй сортировки элементов
		"FILTER_NAME" => "",    // Имя массива со значениями фильтра для фильтрации элементов
		"HIDE_NOT_AVAILABLE" => "N",    // Не отображать товары, которых нет на складах
		"IBLOCK_ID" => "4",    // Инфоблок
		"IBLOCK_TYPE" => "catalog",    // Тип инфоблока
		"LINE_ELEMENT_COUNT" => "3",    // Количество элементов выводимых в одной строке таблицы
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",    // Текст кнопки "Добавить в корзину"
		"MESS_BTN_BUY" => "Купить",    // Текст кнопки "Купить"
		"MESS_BTN_DETAIL" => "Подробнее",    // Текст кнопки "Подробнее"
		"MESS_NOT_AVAILABLE" => "Нет в наличии",    // Сообщение об отсутствии товара
		"OFFERS_LIMIT" => "5",    // Максимальное количество предложений для показа (0 - все)
		"PARTIAL_PRODUCT_PROPERTIES" => "N",    // Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
		"PRICE_CODE" => "",    // Тип цены
		"PRICE_VAT_INCLUDE" => "Y",    // Включать НДС в цену
		"PRODUCT_ID_VARIABLE" => "id",    // Название переменной, в которой передается код товара для покупки
		"PRODUCT_PROPERTIES" => "",    // Характеристики товара
		"PRODUCT_PROPS_VARIABLE" => "prop",    // Название переменной, в которой передаются характеристики товара
		"PRODUCT_QUANTITY_VARIABLE" => "",    // Название переменной, в которой передается количество товара
		"PROPERTY_CODE" => array(    // Свойства
			0 => "ACTION",
			1 => "FILLING",
			2 => "NEW",
			3 => "STAR_GIFT",
			4 => "",
		),
		"SECTION_ID_VARIABLE" => "SECTION_ID",    // Название переменной, в которой передается код группы
		"SECTION_URL" => "",    // URL, ведущий на страницу с содержимым раздела
		"SEF_MODE" => "N",    // Включить поддержку ЧПУ
		"SHOW_CLOSE_POPUP" => "N",    // Показывать кнопку продолжения покупок во всплывающих окнах
		"SHOW_DISCOUNT_PERCENT" => "N",    // Показывать процент скидки
		"SHOW_OLD_PRICE" => "N",    // Показывать старую цену
		"SHOW_PRICE_COUNT" => "1",    // Выводить цены для количества
		"USE_PRICE_COUNT" => "N",    // Использовать вывод цен с диапазонами
		"USE_PRODUCT_QUANTITY" => "N",    // Разрешить указание количества товара
		"VIEW_MODE" => "SECTION",    // Показ элементов
		"OFFERS_FIELD_CODE" => array(    // Поля предложений
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
			10 => "DATE_ACTIVE_FROM",
			11 => "ACTIVE_FROM",
			12 => "DATE_ACTIVE_TO",
			13 => "ACTIVE_TO",
			14 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(    // Свойства предложений
			0 => "ARTICLE",
			1 => "NUMBER",
			2 => "TAGS",
			3 => "STAR_GIFT_PRICE",
			4 => "DISCOUNT_PRICE",
			5 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",    // По какому полю сортируем предложения товара
		"OFFERS_SORT_ORDER" => "asc",    // Порядок сортировки предложений товара
		"OFFERS_SORT_FIELD2" => "id",    // Поле для второй сортировки предложений товара
		"OFFERS_SORT_ORDER2" => "desc",    // Порядок второй сортировки предложений товара
		"TEMPLATE_THEME" => "blue",    // Цветовая тема
		"PRODUCT_DISPLAY_MODE" => "N",    // Схема отображения
		"ADD_PICT_PROP" => "-",    // Дополнительная картинка основного товара
		"LABEL_PROP" => "-",    // Свойство меток товара
		"MESS_BTN_COMPARE" => "Сравнить",    // Текст кнопки "Сравнить"
		"OFFERS_CART_PROPERTIES" => "",    // Свойства предложений, добавляемые в корзину
	),
		false

	);
}
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>