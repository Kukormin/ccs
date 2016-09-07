<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Капкейки");

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
?>
<?$APPLICATION->IncludeComponent("bitrix:catalog.element", "happybox_detail", Array(
	"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"ADD_DETAIL_TO_SLIDER" => "N",	// Добавлять детальную картинку в слайдер
		"ADD_ELEMENT_CHAIN" => "N",	// Включать название элемента в цепочку навигации
		"ADD_PICT_PROP" => "-",	// Дополнительная картинка основного товара
		"ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
		"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
		"ADD_TO_BASKET_ACTION" => array(	// Показывать кнопки добавления в корзину и покупки
			0 => "BUY",
		),
		"BACKGROUND_IMAGE" => "-",	// Установить фоновую картинку для шаблона из свойства
		"BASKET_URL" => "/personal/cart",	// URL, ведущий на страницу с корзиной покупателя
		"BRAND_USE" => "N",	// Использовать компонент "Бренды"
		"BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CHECK_SECTION_ID_VARIABLE" => "N",	// Использовать код группы из переменной, если не задан раздел элемента
		"COMPONENT_TEMPLATE" => "cupcake_detail",
		"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
		"DETAIL_PICTURE_MODE" => "IMG",	// Режим показа детальной картинки
		"DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
		"DISPLAY_COMPARE" => "N",	// Разрешить сравнение товаров
		"DISPLAY_NAME" => "Y",	// Выводить название элемента
		"DISPLAY_PREVIEW_TEXT_MODE" => "E",	// Показ описания для анонса
		"ELEMENT_CODE" => "",	// Код элемента
		"ELEMENT_ID" => "576",	// ID элемента
		"HIDE_NOT_AVAILABLE" => "N",	// Не отображать товары, которых нет на складах
		"IBLOCK_ID" => "5",	// Инфоблок
		"IBLOCK_TYPE" => "catalog",	// Тип инфоблока
		"LABEL_PROP" => "-",	// Свойство меток товара
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",	// URL на страницу, где будет показан список связанных элементов
		"LINK_IBLOCK_ID" => "",	// ID инфоблока, элементы которого связаны с текущим элементом
		"LINK_IBLOCK_TYPE" => "",	// Тип инфоблока, элементы которого связаны с текущим элементом
		"LINK_PROPERTY_SID" => "",	// Свойство, в котором хранится связь
		"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
		"MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
		"MESS_BTN_COMPARE" => "Сравнить",	// Текст кнопки "Сравнить"
		"MESS_BTN_SUBSCRIBE" => "Подписаться",	// Текст кнопки "Уведомить о поступлении"
		"MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
		"META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
		"META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
		"OFFERS_CART_PROPERTIES" => array(	// Свойства предложений, добавляемые в корзину
			0 => "NUMBER",
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
			10 => "DATE_ACTIVE_FROM",
			11 => "ACTIVE_FROM",
			12 => "DATE_ACTIVE_TO",
			13 => "ACTIVE_TO",
			14 => "SHOW_COUNTER",
			15 => "SHOW_COUNTER_START",
			16 => "IBLOCK_TYPE_ID",
			17 => "IBLOCK_ID",
			18 => "IBLOCK_CODE",
			19 => "IBLOCK_NAME",
			20 => "IBLOCK_EXTERNAL_ID",
			21 => "",
		),
		"OFFERS_LIMIT" => "0",	// Максимальное количество предложений для показа (0 - все)
		"OFFERS_PROPERTY_CODE" => array(	// Свойства предложений
			0 => "NUMBER",
			1 => "",
			2 => "",
			3 => "",
			4 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",	// По какому полю сортируем предложения товара
		"OFFERS_SORT_FIELD2" => "id",	// Порядок второй сортировки предложений товара
		"OFFERS_SORT_ORDER" => "asc",	// Порядок сортировки предложений товара
		"OFFERS_SORT_ORDER2" => "desc",	// Поле для второй сортировки предложений товара
		"OFFER_ADD_PICT_PROP" => "-",	// Дополнительные картинки предложения
		"OFFER_TREE_PROPS" => array(	// Свойства для отбора предложений
			0 => "NUMBER",
		),
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
		"PRICE_CODE" => array(	// Тип цены
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"PRICE_VAT_SHOW_VALUE" => "N",	// Отображать значение НДС
		"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
		"PRODUCT_PROPERTIES" => array(	// Характеристики товара
			0 => "FILLING",
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
		"PRODUCT_QUANTITY_VARIABLE" => "",	// Название переменной, в которой передается количество товара
		"PRODUCT_SUBSCRIPTION" => "N",	// Разрешить оповещения для отсутствующих товаров
		"PROPERTY_CODE" => array(	// Свойства
			0 => "FILLING",
			1 => "ACTION",
			2 => "NEW",
			3 => "STAR_GIFT",
			4 => "",
		),
		"SECTION_CODE" => "",	// Код раздела
		"SECTION_ID" => "",	// ID раздела
		"SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
		"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
		"SET_BROWSER_TITLE" => "Y",	// Устанавливать заголовок окна браузера
		"SET_CANONICAL_URL" => "N",	// Устанавливать канонический URL
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"SET_META_DESCRIPTION" => "Y",	// Устанавливать описание страницы
		"SET_META_KEYWORDS" => "Y",	// Устанавливать ключевые слова страницы
		"SET_STATUS_404" => "N",	// Устанавливать статус 404
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"SHOW_404" => "N",	// Показ специальной страницы
		"SHOW_CLOSE_POPUP" => "N",	// Показывать кнопку продолжения покупок во всплывающих окнах
		"SHOW_DEACTIVATED" => "N",	// Показывать деактивированные товары
		"SHOW_DISCOUNT_PERCENT" => "N",	// Показывать процент скидки
		"SHOW_MAX_QUANTITY" => "N",	// Показывать общее количество товара
		"SHOW_OLD_PRICE" => "N",	// Показывать старую цену
		"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
		"TEMPLATE_THEME" => "blue",	// Цветовая тема
		"USE_COMMENTS" => "N",	// Включить отзывы о товаре
		"USE_ELEMENT_COUNTER" => "Y",	// Использовать счетчик просмотров
		"USE_MAIN_ELEMENT_SECTION" => "N",	// Использовать основной раздел для показа элемента
		"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
		"USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
		"USE_VOTE_RATING" => "N",	// Включить рейтинг товара
		"SEF_RULE" => "/catalog/#IBLOCK_CODE#/#SECTION_CODE#/#ELEMENT_ID#",	// Правило для обработки
		"SECTION_CODE_PATH" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",	// Не подключать js-библиотеки в компоненте
		"SET_VIEWED_IN_COMPONENT" => "N",	// Включить сохранение информации о просмотре товара для старых шаблонов
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>