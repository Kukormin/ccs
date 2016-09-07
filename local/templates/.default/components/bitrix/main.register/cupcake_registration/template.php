<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>

<? CModule::IncludeModule('subscribe'); ?>
<? $arResult["USE_CAPTCHA"] = "N" ?>
<!--form-->
	<div class="b-personal_account--form">
		<div class="b-grey-wrap-top">
			<div class="b-grey-wrap-top-right">
				<div class="b-grey-wrap-bottom">
					<div class="b-grey-wrap-bottom-right">
						<div class="b-application-event--title">
							<span> <?=GetMessage("AUTH_REGISTER")?></span>
						</div>
						<div class="b-personal_account__form-wrap">
							<?
							if (count($arResult["ERRORS"]) > 0):
                                echo '<p>';
								foreach ($arResult["ERRORS"] as $key => $error) {
                                    if (intval($key) == 0 && $key !== 0)
                                        $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;" . GetMessage("REGISTER_FIELD_" . $key) . "&quot;", $error);
                                    if (strpos($error, 'Пользователь с таким e-mail') !== false) {
                                        echo '<span class="errortext">Такой email уже есть в базе, если он ваш — нажмите <a class="b-forget_password">Восстановить пароль</a></span>';
                                    }
                                }
                                echo '</p>';
                                ?>
                                    <script>
                                        $(function () {
                                            $('.js_modal_registration, .overlay').show();
                                            $('.errortext').css('font-family', '"PTSansCaption",sans-serif');
                                            $('.errortext').css('color', 'red');
                                            $('.b-forget_password').css('color', 'red');
                                            $('.b-forget_password').css('font-family', '"PTSansCaption",sans-serif');
                                            $('.b-forget_password').css('cursor', 'pointer');
                                            $('.b-forget_password').css('font-size', '16px');
                                        })
                                    </script>
                                <?
							elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>

								<p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>

							<?endif?>

							<form class="registration_form" method="post" action="" name="regform" enctype="multipart/form-data">
								<?
								if($arResult["BACKURL"] <> ''):
									?>
									<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
									<?
								endif;
								?>
								<div class="b-personal_account__form--line">
									<!--form item-->
									<div class="b-personal_account__form-item">
										<label for=""> имя</label>
										<div class="b-form-item__input">
											<input type="text" name="REGISTER[<?=$arResult["SHOW_FIELDS"][5]?>]" value=""/>
										</div>
									</div>
									<div class="b-personal_account__form-item">
										<label for=""> адрес эл. почты</label>
										<div class="b-form-item__input">
											<input class="registration_phone email" type="text" name="REGISTER[<?=$arResult["SHOW_FIELDS"][3]?>]" value=""/>
											<input class="registration_login" type="hidden" name="REGISTER[<?=$arResult["SHOW_FIELDS"][0]?>]" value=""/>
										</div>

									</div>

								</div>
								<div class="b-personal_account__form--line">
									<div class="b-personal_account__form-item">
										<label for="">телефон</label>
										<div class="b-form-item__input">
											<input type="text" name="REGISTER[<?=$arResult["SHOW_FIELDS"][6]?>]" value="" class="js-phone-mask" placeholder="+7(926)123-45-67"/>
										</div>
									</div>
								</div>
								<div class="b-personal_account__form--line">
									<div class="b-personal_account__form-item">
										<label for=""><?echo GetMessage("REGISTER_FIELD_PASSWORD")?></label>
										<div class="b-form-item__input">
											<input class="b-account-form--input-pass" type="password" name="REGISTER[<?=$arResult["SHOW_FIELDS"][1]?>]" value="" autocomplete="off" />
										</div>
									</div>
									<div class="b-personal_account__form-item">
										<label for=""><?echo GetMessage("REGISTER_FIELD_CONFIRM_PASSWORD")?></label>
										<div class="b-form-item__input">
											<input class="b-account-form--input-pass" type="password" name="REGISTER[<?=$arResult["SHOW_FIELDS"][2]?>]" value="" autocomplete="off" />
										</div>
									</div>

								</div>
								<div class="b-personal_account__form--line">
									<div class="b-personal_account__form-item">
										<div class="b-mod__item-checkbox">
                                            <?
                                            $rub = CRubric::GetList(array("SORT"=>"ASC", "NAME"=>"ASC"), array("ACTIVE"=>"Y", "LID"=>LANG));
                                            while($rub->ExtractFields("r_")):
                                                ?>
                                                <input id="checkbox" tabindex="0" class="checkbox" type="checkbox" name="sf_RUB_ID[]" value="1" checked>
                                                <?
                                            endwhile;
                                            ?>
											<label for="checkbox">Оформить подписку на новости и акции</label>
										</div>
									</div>
								</div>
								<div class="b-personal_account__form--line">
									<div class="b-personal_account__form-item">
										<button type="submit" name="register_submit_button" class="b-bnt-form" value="<?=GetMessage("AUTH_REGISTER")?>"><?=GetMessage("AUTH_REGISTER")?></button>
									</div>
                                    <div class="b-personal_account__form-item b-personal_account__form-item--right">
										<a class="b-registration__form__link js-already-register" href="#">я уже зарегистрирован  </a>
									</div>
								</div>
								<div class="b-personal_account__form--line b-personal_account__form--line-last">
									<div class="b-personal_account__form-item">
										<div class="b-block-social">
											<div class="b-block-social-title">
												Войти через акаунты в социальных сетях
											</div>
                                            <?$APPLICATION->IncludeComponent(
                                                "bitrix:system.auth.form",
                                                "cupcake_auth_register",
                                                Array(
                                                    "COMPONENT_TEMPLATE" => "cupcake_auth_register",
                                                    "FORGOT_PASSWORD_URL" => "",
                                                    "PROFILE_URL" => "",
                                                    "REGISTER_URL" => "",
                                                    "SHOW_ERRORS" => "N"
                                                )
                                            );?>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?
$EMAIL = $_POST['REGISTER[EMAIL]'];
$RUBRICKS = [];
$rsRubric = CRubric::GetList($arOrder, $arFilter);
while($arRubric = $rsRubric->GetNext())
{
    $RUBRICKS[] = $arRubric['ID'];
}
$arFields = Array(
    "EMAIL" => $EMAIL,
    "ACTIVE" => "Y",
    "SEND_CONFIRM" => "N",
    "RUB_ID" => $RUBRICKS,
    "CONFIRMED" => "Y"
);
$subscr = new CSubscription;
$subscr->Add($arFields);
?>
