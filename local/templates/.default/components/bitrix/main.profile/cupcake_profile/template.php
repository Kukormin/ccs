<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>

<?ShowError($arResult["strProfileError"]);?>
<?
if ($arResult['DATA_SAVED'] == 'Y')
	ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>
<script type="text/javascript">
	<!--
	var opened_sections = [<?
$arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
$arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
if (strlen($arResult["opened"]) > 0)
{
	echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
}
else
{
	$arResult["opened"] = "reg";
	echo "'reg'";
}
?>];
	//-->

	var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
</script>

<div class="b-block-account--wrap b-title--border-top i-padding-bott-55">
	<div class="b-block-account--content-wrap">


		<div class="b-block-account__navigation">
			<div class="b-block-account__link-nav">
				<a class="b-account-link-nav__item active" href="#">
					<span> Персональные данные</span> </a>
				<a class="b-account-link-nav__item" href="/personal/shipping_address/">
					<span> Адреса доставки</span> </a>
				<a class="b-account-link-nav__item" href="/personal/order/">
					<span> История заказов</span> </a>
			</div>

			<div class="account__navigation--mobile"> </div>

			<div class="b-account-navigation__mobile-wrap b-block-mobile-only">
				<ul class="b-account-navigation__mobile-list">
					<li class="b-account-navigation__mobile-item">
						<a class="b-account-navigation__mobile-link" href="#">
							<span> Персональные данные</span> </a>
					</li>
					<li class="b-account-navigation__mobile-item">
						<a class="b-account-navigation__mobile-link" href="/personal/shipping_address/">
							<span> Адреса доставки</span> </a>
					</li>
					<li class="b-account-navigation__mobile-item">
						<a class="b-account-navigation__mobile-link" href="/personal/order/">
							<span> История заказов</span> </a>
					</li>
				</ul>
			</div>
		</div>


		<div class="b-account-form">
			<div class="b-account-form--wrap">
				<form class="profile_form" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
					<?=$arResult["BX_SESSION_CHECK"]?>
					<input type="hidden" name="lang" value="<?=LANG?>" />
					<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
					<div class="b-account-form--line">
						<label for="">ваше имя</label>
						<div class="b-account-form--input">
							<input id="input_name" type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" readonly="true"/>
						</div>
									<span class="b-account-form--change js-personal-editable" data-for="input_name">
										Изменить
									</span>
						</span>
					</div>
					<div class="b-account-form--line">
						<label for="">Адрес эл. почты</label>
						<div class="b-account-form--input">
							<input type="text" name="EMAIL" id="input_mail" value="<? echo $arResult["arUser"]["EMAIL"]?>" readonly="true" />
							<input type="hidden" name="LOGIN" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
						</div>
									<span class="b-account-form--change js-personal-editable" data-for="input_mail">
										Изменить
									</span>
					</div>
					<div class="b-account-form--line">
						<label for="">телефон</label>
						<div class="b-account-form--input">
							<input type="text" name="PERSONAL_PHONE" id="input_phone" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" readonly="true"/>
						</div>
									<span class="b-account-form--change js-personal-editable" data-for="input_phone">
										Изменить
									</span>
					</div>
					<div class="b-account-form--line">
						<label for="">пароль</label>
						<div class="b-account-form--input">
							<input class="b-account-form--input-pass bx-auth-input" id="input_pass" type="password" name="NEW_PASSWORD" value="" placeholder="× × × × × × × × ×"  readonly="true"/>
							<input class="new_password_confirm" type="hidden" name="NEW_PASSWORD_CONFIRM" value="" autocomplete="off" />
						</div>
									<span class="b-account-form--change js-personal-editable" data-for="input_pass">
										Изменить
									</span>
					</div>

					<div class="b-account-form--line">
						<input class="b-bnt-form b-bnt-form--account" type="submit" name="save" value="<?=GetMessage("MAIN_SAVE")?>">
					</div>
				</form>
			</div>
			<div class="b-account-form--subscribe">
			<?$APPLICATION->IncludeComponent(
	"bitrix:subscribe.simple", 
	"cupcake_subscribe", 
	array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "cupcake_subscribe",
		"SET_TITLE" => "N",
		"SHOW_HIDDEN" => "N"
	),
	false
);?>
				</div>
		</div>
	</div>
</div>


</div>
</section>
