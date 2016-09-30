<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Сладкие столы");
?>
	<section class="b-topblock b-topblock--pay-ship"> </section> <section class="b-bg-grey">
	<div class="b-content-center b-reviews">
		<div class="b-content-center--title i-padding__top-100">
		<? $APPLICATION->IncludeFile( '/include/sweet_table_title_inc.php', array(),
			array(
				'MODE'  => 'html',
				'TEMPLATE'  => 'page_inc.php',
			)
		); ?>
			</div>
	<div class="b-content-center--description">
		<? $APPLICATION->IncludeFile( '/include/sweet_table_text_inc.php', array(),
			array(
				'MODE'  => 'html',
				'TEMPLATE'  => 'page_inc.php',
			)
		); ?>
	</div>

<?$APPLICATION->IncludeComponent(
	"bitrix:photogallery", 
	"cupcake_gallery_sweet", 
	array(
		"ADDITIONAL_SIGHTS" => array(
		),
		"ALBUM_PHOTO_SIZE" => "120",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "cupcake_gallery_sweet",
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
		"UPLOAD_MAX_FILE_SIZE" => "4",
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

<?$APPLICATION->IncludeComponent(
	"custom:main.feedback", 
	"cupcake_sweet_table", 
	array(
		"COMPONENT_TEMPLATE" => "cupcake_sweet_table",
		"EMAIL_TO" => "zakaz@cupcakestory.ru",
		"EVENT_MESSAGE_ID" => array(
			0 => "39",
		),
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => array(
		),
		"USE_CAPTCHA" => "Y"
	),
	false
);?>
</section><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>