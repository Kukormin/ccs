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
        <div class="what">
            <div class="what__title">Что такое Жуковские Вкусности?</div>
            <div class="what__list">
                <div class="what__item">Знакомые всем снеки с новыми оригинальными вкусами: печенье в шоколаде, сушки с маком, сладкая и соленая соломка, воздушная кукуруза острая и сахарная, традиционные «ушки».</div>
                <div class="what__item">Современная упаковка, которую удобно поставить в подстаканник в машине или положить в школьный рюкзак. Она не сломает снеки, не рассыпется в сумке. </div>
                <div class="what__item">Яркий дизайн хорошо видно в прикассовой зоне и на полке.</div>
                <div class="what__item">Промышленное производство из качественных ингредиентов без добавления заменителей и усилителей вкуса. Мы контролируем качество от закупки сырья до упаковки.</div>
                <div class="what__item">Поддержка звезд, которые показывают, как любят и едят Жуковские Вкусности.</div>
            </div>
            <div class="what__center">
                Попробуйте в корнере CupCake Story на Даниловском рынке (ссылка на адрес в яндексе)<br>
                Закажите партию снеков!
            </div>
        </div>

	    <? $APPLICATION->IncludeComponent(
		    "custom:main.feedback",
		    "cupcake_sweet_table",
		    [
			    "COMPONENT_TEMPLATE" => "cupcake_sweet_table",
			    "EMAIL_TO" => "sergeich06@gmail.com",
			    "EVENT_MESSAGE_ID" => [0 => "39",],
			    "OK_TEXT" => "Спасибо, ваше сообщение принято.",
			    "REQUIRED_FIELDS" => "",
			    "USE_CAPTCHA" => "Y",
			    "FORM_TITLE" => 'заказать снеки',
		    ]
	    ); ?>
    </div>



<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>