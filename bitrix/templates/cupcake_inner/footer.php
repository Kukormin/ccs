<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @global CMain $APPLICATION */
/** @global CUser $USER */

$isAuthorized = $USER->IsAuthorized();

//<div class=".b-content-wrap">


?>
</div><?

if (defined('INDEX_PAGE') && INDEX_PAGE)
{
	?>
	<section class="b-footer-wrap">
		<img src="/bitrix/templates/.default/images/bg-footer.jpg" alt=""/>

		<div class="b-footer">
			<div class="b-footer-text">
				<div class="b-footer-text__list">
					<div class="b-footer__img">
						<img src="/bitrix/templates/.default/images/footer-pic1.png" alt=""/>
					</div>
					<h1>
						<div class="b-content-center--title i-padding__top-100" style="color:white">
							Капкейки на заказ
						</div>
					</h1>
					<div class="b-footer-text__item">
						CupCake Story — это семейная кондитерская, специализирующаяся на выпечке капкейков вкуснейших
						мини-тортиков с волшебной начинкой и шапкой нежного крема
					</div>
					<div class="b-footer-text__sub">
						В нашей линейке более 50 различных вкусов! И поверьте, каждый вкус — это маленькая сладкая
						история, которая без сомнений не оставит вас и ваших близких равнодушными !
					</div>
					<a class="b-footer-link" href="/about/">О компании </a>
				</div>
			</div>
			<div class="b-footer-info gl-block-footer-info">
				<div class="b-footer-copy">
					<span>Проект развивает </span><a style="color:#a3a67b;"
					                                 href="http://komanda-a.pro/">Команда-А</a><br>
					<span>Продвижение сайта - </span><a style="color:#a3a67b;" href="http://neyiron.ru/">Neyiron</a>
				</div>
				<ul class="b-footer-nav__list">
					<?$APPLICATION->IncludeComponent("bitrix:menu", "cupcakes_menu_bottom", array(
						"MENU_CACHE_TIME" => "3600000",
						"MENU_CACHE_TYPE" => "A",
						"ROOT_MENU_TYPE" => "bottom2",
					), false);?>
				</ul>
				<span class="b-footer-phones">7 (499) 322-00-20</span>

				<div class="b-cards-wrapper">
					<a class="b-sitemap-footer" href="/sitemap.php" title="Карта сайта"> </a>
					<a href="https://www.instagram.com/cupcake.story/" target="_blank"
					   class="b-footer-instagram-main"> </a>
					<a href="#" class="b-footer-mail"> </a>
					<a class="b-footer-mastercard-main"> </a>
					<a class="b-footer-visa-main"> </a>
				</div>

			</div>
		</div>
	</section>
<?
}
else
{
	?>
	<section class="b-footer-wrap b-footer-wrap-about">
	<div class="b-footer b-footer-about">
		<div class="b-footer-info b-footer-info-about">
			<div class="b-footer-copy b-footer-copy-about">
				<span>Проект развивает </span><a style="color:#a3a67b" href="http://komanda-a.pro/">Команда-А</a><br>
				<span>Продвижение сайта - </span><a style="color:#a3a67b;" href="http://neyiron.ru/">Neyiron</a>
			</div>
			<ul class="b-footer-nav__list b-footer-nav__list-about">
				<?$APPLICATION->IncludeComponent("bitrix:menu", "cupcakes_menu_bottom", array(
						"MENU_CACHE_TIME" => "3600000",
						"MENU_CACHE_TYPE" => "A",
						"ROOT_MENU_TYPE" => "bottom2",
					), false);?>
			</ul>
			<span class="b-footer-phones b-footer-phones-about">7 (499) 322-00-20</span>

			<div class="b-cards-wrapper">
				<a class="b-sitemap-footer" href="/sitemap.php" title="Карта сайта"> </a>
				<a href="https://www.instagram.com/cupcake.story/" target="_blank"
				   class="b-footer-instagram-inner"> </a>
				<a href="#" class="b-footer-mail b-footer-mail-about"> </a>
				<a class="b-footer-mastercard-main"> </a>
				<a class="b-footer-visa-inner"> </a>
			</div>
		</div>
	</div>
	</section><?
}

?>
<!--modal-->
<div class="b-modal">
	<div id="overlay" class="overlay" style="display: none"></div><?

	//
	// Регистрация
	//
	if (!$isAuthorized)
	{
		?>
		<div class="b-modal-personal_account js_modal_registration" style="display: none">
			<span class="b-close-modal">close</span><?

			$APPLICATION->IncludeComponent("bitrix:main.register", "cupcake_registration", array(
				"AUTH" => "Y",
				"COMPONENT_TEMPLATE" => "cupcake_registration",
				"REQUIRED_FIELDS" => array(
					0 => "EMAIL",
					1 => "NAME",
					2 => "PERSONAL_PHONE",
				),
				"SET_TITLE" => "N",
				"SHOW_FIELDS" => array(
					0 => "EMAIL",
					1 => "NAME",
					2 => "PERSONAL_PHONE",
				),
				"SUCCESS_PAGE" => "/",
				"USER_PROPERTY" => array(),
				"USER_PROPERTY_NAME" => "",
				"USE_BACKURL" => "Y"
			), false);

			?>
		</div><?
	}

	//
	// Авторизация
	//
	if (!$isAuthorized)
	{
		?>
		<div class="b-modal-personal_account js_login_modal" style="display: none">
			<span class="b-close-modal">close</span><?

			$APPLICATION->IncludeComponent(
				"bitrix:system.auth.form",
				"cupcake_auth",
				array(
					"COMPONENT_TEMPLATE" => "cupcake_auth",
					"FORGOT_PASSWORD_URL" => "",
					"PROFILE_URL" => "",
					"REGISTER_URL" => "",
					"SHOW_ERRORS" => "Y"
				),
				false
			);

			?>
		</div><?
	}

	//
	// Восстановление пароля
	//
	if (!$isAuthorized)
	{
		?>
		<div class="b-modal-personal_account js_forgot_pass" style="display: none">
			<span class="b-close-modal">close</span><?

			$APPLICATION->IncludeComponent(
				"bitrix:system.auth.forgotpasswd",
				"cupcake_forgot_pass",
				array(
					"COMPONENT_TEMPLATE" => "cupcake_forgot_pass"
				),
				false
			);

			?>
		</div><?
	}

	//
	// Быстрый заказ
	//
	?>
    <div class="b-modal-fastorder js_modal_fastorder" style="display: none">
        <span class="b-close-modal">close</span>
        <!--form-->
        <div class="js-ajax-fastorder">
			<div class="preloader"></div>
		</div>
    </div><?

	//
	// Письмо в компанию
	//
	?>
    <div class="b-modal-personal_account js_feedback_modal" style="display: none">
        <span class="b-close-modal">close</span>
        <!--form-->
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.feedback",
            "cupcake_feedback",
            array(
                "COMPONENT_TEMPLATE" => "cupcake_feedback",
                "EMAIL_TO" => "zakaz@cupcakestory.ru",
                "EVENT_MESSAGE_ID" => array(
	                0 => "7",
                ),
                "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                "REQUIRED_FIELDS" => array(
                    0 => "MESSAGE",
                ),
                "USE_CAPTCHA" => "Y"
            ),
            false
        );?>
    </div><?

	//
	// Сообщение отправлено
	//
	?>
	<div class="b-modal-personal_account js_thankyou_modal" style="display: none">
		<span class="b-close-modal">close</span>
		<div class="b-personal_account--form">
			<div class="b-grey-wrap-top thank_you_modal">
				<div class="b-grey-wrap-top-right">
					<div class="b-grey-wrap-bottom">
						<div class="b-grey-wrap-bottom-right">
							<div class="b-application-event--title">
								<span> Спасибо!</span>
							</div>
							<div class="b-personal_account__form-wrap">
								<div class="thank_you_mess">Ваше сообщение отправлено.</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><?

	//
	// Подписка на рассылку
	//
	?>
	<div class="b-modal-personal_account js_subscribe_modal" style="display: none">
		<span class="b-close-modal">close</span><?

		$APPLICATION->IncludeComponent("bitrix:subscribe.form", "cupcake_subscription_main", Array(
			"CACHE_TIME" => "3600",
			"CACHE_TYPE" => "A",
			"COMPONENT_TEMPLATE" => "cupcake_subscription_main",
			"PAGE" => "#SITE_DIR#personal/subscribe/subscr_edit.php",
			"SHOW_HIDDEN" => "N",
			"USE_PERSONALIZATION" => "N"
		));

		?>
	</div><?

	?>
</div><?

?>
</div><?

$APPLICATION->IncludeFile('/include/body_bottom.php', array());

?>
</body>
</html>
