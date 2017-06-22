<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "На данной странице предоставлены контакты нашей компании");
$APPLICATION->SetPageProperty("title", "Контакты");
$APPLICATION->SetTitle("Контакты");
?>

    <section class="b-topblock b-topblock--pay-ship"></section>
    <section class="b-goodies-block">
        <div class="b-content">
            <div class="content-left">
                <div class="b-logo">
                    <img src="/local/templates/.default/images/goodies/logo.png" alt="">
                    <div class="this-is">- это</div>
                </div>
                <div class="list">
                    <div class="list__item">Вкусные хрустящие снеки</div>
                    <div class="list__item">Знакомые и проверенные продукты с новыми вкусами в удобной упаковке</div>
                    <div class="list__item">Качественные</div>
                    <div class="list__item">Оригинальные</div>
                    <div class="list__item">Их удобно взять с собой в дорогу</div>
                </div>
            </div>
            <div class="content-right">
				<? $APPLICATION->IncludeComponent('tim:empty', 'video.youtube', [
					'VIDEO_WIDTH' => '560',
					'VIDEO_HEIGHT' => '315',
					'VIDEO_URL' => 'https://www.youtube.com/embed/xR4Qtbnxjq8",',
				]); ?>
            </div>
            <div class="clr"></div>
        </div>
    </section>
    <div class="b-content">
        <?
            $arFilter = [
                    '!PREVIEW_IMAGE' => false,
            ];
        ?>
		<? $APPLICATION->IncludeComponent("bitrix:news.list", "goodies.page", [
				"DISPLAY_DATE" => "N",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "N",
				"AJAX_MODE" => "N",
				"IBLOCK_TYPE" => "new_catalog",
				"IBLOCK_ID" => "goodies",
				"NEWS_COUNT" => 1000,
				"SORT_BY1" => "ID",
				"SORT_ORDER1" => "DESC",
				"SORT_BY2" => "SORT",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "arFilter",
				"FIELD_CODE" => ["ID","NAME","PREVIEW_IMAGE"],
				"PROPERTY_CODE" => ["WEIGHT","PROPERTY","UNIT"],
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"PREVIEW_TRUNCATE_LEN" => "",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_LAST_MODIFIED" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"INCLUDE_SUBSECTIONS" => "N",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => "",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SET_STATUS_404" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => "",
				"PAGER_BASE_LINK" => "",
				"PAGER_PARAMS_NAME" => "arrPager",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
			]
		); ?>
    </div>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>