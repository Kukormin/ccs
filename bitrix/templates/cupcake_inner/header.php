<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

/** @global CMain $APPLICATION */

$APPLICATION->IncludeFile('/include/retailcrm_utm.php', array());

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta name='yandex-verification' content='4821d23a92acdadc'/>
	<? $APPLICATION->ShowHead(); ?>
	<title><? $APPLICATION->ShowTitle() ?></title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<link href="/bitrix/templates/.default/css/slick.css?v=7" rel="stylesheet" type="text/css"/>
	<link href="/bitrix/templates/.default/css/about.css?v=13" rel="stylesheet" type="text/css"/>
	<link href="/bitrix/templates/.default/template_styles.css?v=34" rel="stylesheet" type="text/css"/>
	<link href="/bitrix/templates/.default/css/cupcake-media.css?v=16" rel="stylesheet" type="text/css"/>
	<link href="/bitrix/templates/.default/css/featherlight.css?v=7" rel="stylesheet" type="text/css"/>
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>

	<script type="text/javascript" src="/bitrix/templates/.default/js/jquery.min.js"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/jquery.stellar.min.js?v=6"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/nouislider.min.js"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/featherlight.js?v=6"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/slick.js?v=6"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/jquery.suggestions.min.js"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/cupcake.js?v=16"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/share.js?v=6"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/additional.js?v=6"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/jquery.validate.min.js?v=6"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/messages_ru.js?v=6"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/jquery.maskedinput.min.js?v=6"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/jquery.form.min.js?v=6"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/calendar.js?v=10"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/catalog.js?v=3"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/iphone-style-checkboxes.js?v=2"></script>

	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]--><?

	$APPLICATION->IncludeFile('/include/head_bottom.php', array());

	?>
</head>
<body>
<?

$APPLICATION->IncludeFile('/include/body_top.php', array());

$headerLine = \Local\Media\Banners::getBySectionCode('header', 1);
if ($headerLine)
	$headerLine = $headerLine[0]['NAME'];
$class = $headerLine ? ' with_header_alert' : '';

?>
<div id="panel"><?$APPLICATION->ShowPanel(); ?></div>

<div class="b-content-wrap<?= $class ?>"><?

$hideHeader = defined('HIDE_HEADER') && HIDE_HEADER;
if (!$hideHeader)
{
	?>
	<section class="b-header"><?

	if ($headerLine)
	{
		?>
		<div class="header-alert"><?= $headerLine ?></div><?
	}

	// Самое верхнее меню
	?>
	<nav class="b-top-nav">
		<ul class="b-top-nav__list">
			<?$APPLICATION->IncludeComponent("bitrix:menu", "cupcakes_menu_black", Array(
				"MENU_CACHE_TIME" => "3600000",
				"MENU_CACHE_TYPE" => "A",
				"ROOT_MENU_TYPE" => "top",
				"USE_EXT" => "N"
			));?>
		</ul>
	</nav><?

	?>
	<div class="b-panel">
		<div class="b-header__center"><?

			// Поиск
			$APPLICATION->IncludeComponent("bitrix:search.form", "header-search2", Array(
				"USE_SUGGEST" => "Y",
				"PAGE" => "/cat/",
				"COMPONENT_TEMPLATE" => ".default"
			), false);

			// Пользователь
			global $USER;
			if ($USER->IsAuthorized())
			{
				?>
				<a href="/personal/">
					<div class="b-header__user b-header__user--registration active"><?= $USER->GetFirstName() ?></div>
				</a><?
			}
			else
			{
				?>
				<div class="b-header__user"><span class="js_login">Вход</span> / <span
						class="js_register">Регистрация</span></div><?
			}

			// Телефоны
			?>
			<div class="b-header-phones-wrapper">
				<div class="b-header__phone">+7 (499) 322-00-20</div>
				<div class="b-header-watsup">Пишите нам в WhatsApp</div>
				<div class="b-header-watsup-phone">+7 (968) 622-73-42</div>
			</div><?

			// Логотип
			?>
			<div class="b-header__logo">
				<div class="b-header__logo-link"><?

					if (defined('INDEX_PAGE') && INDEX_PAGE)
					{
						?>
						<img src="/bitrix/templates/.default/images/icn-logo.png" alt=""/><?
					}
					else
					{
						?>
						<a href="/">
							<img src="/bitrix/templates/.default/images/icn-logo.png" alt=""/>
						</a><?
					}

					?>
				</div>
			</div>
		</div><?

		// Меню - розовая лента
		?>
		<div class="b-header__bottom">
			<div class="b-header__bottom-nav"><?

				// Пункты справа
				?>
				<div class="b-links"><?

					$curPage = $APPLICATION->GetCurPage();
					$sweetTable = $curPage != '/' && strpos('/sweet-table/', $curPage) === 0;
					$active = $sweetTable ? ' active' : '';
					?>
					<a href="/sweet-table/" class="sweet-table<?= $active ?>">сладкие столы</a><?

					$cartCount = Local\Sale\Cart::getQuantity();
					$style = $cartCount ? '' : 'style="display:none;"';
					// Ссылка на корзину
					?><a href="/personal/cart/" class="basket">
						<img src="/bitrix/templates/.default/images/icn-bascet.png" alt="" />
						<span class="item_shopping_cart js-basket-total-count"<?= $style ?>><?= $cartCount ?></span>
					</a>
				</div><?

				?>
				<div class="mobile-button-nav"></div>
				<nav class="b-bottom-nav">
					<ul class="b-bottom-nav__list">
						<li class="b-bottom-nav__item b-bottom-nav__item--mob"><?

							// Пунты меню для мобилок
							if (!$USER->IsAuthorized())
							{
								?>
								<div class="b-header__user"><span class="js_login">Вход</span> / <span
										class="js_register">Регистрация</span></div><?
							}
							else
							{
								?>
								<div class="b-personal-area">
									<a href="/personal/" class="b-personal-area__link">Персональные данные</a>
									<a href="/personal/shipping_address/"
									   class="b-personal-area__link">Адреса доставки</a>
									<a href="/personal/order/?filter_history=Y"
									   class="b-personal-area__link">История заказов</a>
									<a href="/?logout=yes" class="b-personal-area__link">Выход</a>
								</div><?
							}

							?>
						</li><?

						// Пункты меню - категории каталога
						$APPLICATION->IncludeComponent("bitrix:menu", "cupcakes_menu_pink_inner", array(
							"MENU_CACHE_TIME" => "3600000",
							"MENU_CACHE_TYPE" => "A",
							"ROOT_MENU_TYPE" => "bottom",
						));

						?>
					</ul><?

					// Дополнительное меню для мобилок (которое на десктопе снизу)
					?>
					<ul class="b-top-nav__list--mobile">
						<?$APPLICATION->IncludeComponent("bitrix:menu", "cupcakes_menu_black", Array(
							"MENU_CACHE_TIME" => "3600000",
							"MENU_CACHE_TYPE" => "A",
							"ROOT_MENU_TYPE" => "top",
						));?>
						<li class="b-top-nav__item  b-top-nav__item--mob">
							<div class="b-header__phone b-header__phone--mob">+7 499 322-00-20</div>
							<div class="b-header-watsup b-header-watsup--mob">Пишите нам в WhatsApp</div>
							<div class="b-header-watsup-phone b-header-watsup-phone--mob">+7 968 622 73 42</div>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	</section><?
}
