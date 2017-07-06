<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Жуковские вкусности");
$APPLICATION->SetTitle("Жуковские вкусности");

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
					'VIDEO_URL' => 'https://www.youtube.com/embed/aZHsQ2noPMM',
				]); ?>
            </div>
            <div class="clr"></div>
        </div>
    </section>
    <div class="b-content"><?

        $APPLICATION->IncludeComponent("tim:empty", "goodies");

        ?>
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

    </div><?

$APPLICATION->IncludeComponent(
	"custom:main.feedback",
	"cupcake_sweet_table",
	[
		"COMPONENT_TEMPLATE" => "cupcake_sweet_table",
		"EMAIL_TO" => "zakaz@cupcakestory.ru",
		"EVENT_MESSAGE_ID" => [0 => "39",],
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => "",
		"USE_CAPTCHA" => "Y",
        'FORM_TITLE' => 'Заказать снеки',
	]
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>