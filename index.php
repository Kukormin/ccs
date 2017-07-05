<?
/** @global CMain $APPLICATION */

define('INDEX_PAGE', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Кондитерская CupCake  Story предлагает сладости на заказ ручной работы. Десерты на заказ по  лучшим ценам. Для более подробной информации тел. +7 (499) 322-00-20");
$APPLICATION->SetPageProperty("title", "Капкейки на заказ в Москве с доставкой | Пирожные на заказ в Москве от  семейной кондитерской Cupcake Story");

$APPLICATION->SetTitle("Cupcake Story — семейная кондитерская. Капкейки, торты, эклеры, пряники, пирожные с доставкой на домКапкейки на заказ в Москве с доставкой | Пирожные на заказ в Москве от  семейной кондитерской Cupcake Story");

?>
<section class="b-topblock main-screen"><?

	// Большие баннеры
	$APPLICATION->IncludeComponent('tim:empty', 'main_banners');

	?>
</section>
<section class="b-bg-grey"><?

	//
	// Новинки
	//
	$APPLICATION->IncludeComponent('tim:empty', 'novelties');

	//
	// Капкейки
	//
	$APPLICATION->IncludeComponent('tim:empty', 'index_cupcackes');

	//
	// Подписка на рассылку
	//
	?>
	<div class="b-mailing">
		<a href="#" class="b-mailing__item-img">
			<img src="/bitrix/templates/.default/images/mail.png" alt="подписка" />
		</a>
		<div class="b-mailing-text">
			подпишитесь на нашу рассылку, чтоб быть в курсе последних новинок и акций
		</div>
		<div class="b-title b-title--border-middle">
			<div class="b-title__item b-title__item--grey">
				<a href="#" class="bnt-mailing"> подписаться</a>
			</div>
		</div>
	</div><?

	//
	// Звездные истории
	//
	?>
	<div class="b-slider">
		<a href="/celebrity-stories/" class="b-mod__link--text-hover">звездные истории</a><?

		$APPLICATION->IncludeComponent(
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
		);

		?>
	</div>

</section><?

\Local\Utils\Remarketing::setPageType('home');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");