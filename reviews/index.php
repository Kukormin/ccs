<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "На данной странице вы можете ознакомиться c отзывами о нас");
$APPLICATION->SetPageProperty("title", "Отзывы");
$APPLICATION->SetTitle("Отзывы");
?><section class="b-topblock b-topblock--pay-ship"> </section> <section class="b-bg-grey">
<div class="b-content-center b-reviews">
	<h1><div class="b-content-center--title i-padding__top-100">
		 Отзывы
	</div></h1>
	<div class="b-content-center--description">
		Мы всегда рады получать от вас послания с&nbsp;отзывами, комментариями, предложениями и&nbsp;пожеланиями. Смелей! Напишите, что вы думаете о Cupcake Story, и ваша весточка обязательно долетит до нас!
    </div>

    <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"cupcake_reviews", 
	array(
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
		"COMPONENT_TEMPLATE" => "cupcake_reviews",
		"DETAIL_URL" => "#SITE_DIR#/reviews/#ID#",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "13",
		"IBLOCK_TYPE" => "reviews",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
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
		"PROPERTY_CODE" => array(
			0 => "PUBLICATION_DATE",
			1 => "REVIEW_TITLE",
			2 => "",
		),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC"
	),
	false
);?>




</div>
	<?$APPLICATION->IncludeComponent(
	"altasib:feedback.form",
	"cupcake_reviews",
	Array(
		"ACTIVE_ELEMENT" => "N",
		"ADD_LEAD" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"ALX_CHECK_NAME_LINK" => "N",
		"BACKCOLOR_ERROR" => "#ffffff",
		"BBC_MAIL" => "",
		"BORDER_RADIUS" => "3px",
		"CAPTCHA_TYPE" => "default",
		"CATEGORY_SELECT_NAME" => "Выберите категорию",
		"CHECK_ERROR" => "Y",
		"COLOR_ERROR" => "#8E8E8E",
		"COLOR_ERROR_TITLE" => "#A90000",
		"COLOR_HINT" => "#000000",
		"COLOR_INPUT" => "#727272",
		"COLOR_MESS_OK" => "#963258",
		"COLOR_NAME" => "#000000",
		"COMPONENT_TEMPLATE" => "cupcake_reviews",
		"EVENT_TYPE" => "ALX_FEEDBACK_FORM",
		"FORM_ID" => "1",
		"HIDE_FORM" => "N",
		"IBLOCK_ID" => "13",
		"IBLOCK_TYPE" => "reviews",
		"IMG_ERROR" => "/upload/altasib.feedback.gif",
		"IMG_OK" => "/upload/altasib.feedback.ok.gif",
		"JQUERY_EN" => "N",
		"LOCAL_REDIRECT_ENABLE" => "N",
		"MESSAGE_OK" => "Сообщение отправлено!",
		"NAME_ELEMENT" => "REVIEW_TITLE",
		"PROPERTY_FIELDS" => array(),
		"PROPERTY_FIELDS_REQUIRED" => array(),
		"PROPS_AUTOCOMPLETE_EMAIL" => array(0=>"EMAIL",),
		"PROPS_AUTOCOMPLETE_NAME" => array(0=>"REVIEW_TITLE",),
		"PROPS_AUTOCOMPLETE_PERSONAL_PHONE" => array(),
		"REWIND_FORM" => "N",
		"SECTION_MAIL_ALL" => "zakaz@cupcakestory.ru",
		"SEND_MAIL" => "N",
		"SHOW_MESSAGE_LINK" => "Y",
		"SIZE_HINT" => "10px",
		"SIZE_INPUT" => "12px",
		"SIZE_NAME" => "12px",
		"USERMAIL_FROM" => "N",
		"USE_CAPTCHA" => "Y",
		"WIDTH_FORM" => "50%"
	)
);?>
 </section><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>