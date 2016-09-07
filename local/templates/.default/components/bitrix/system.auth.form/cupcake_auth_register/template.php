<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<!--modal login-->
<?if($arResult["FORM_TYPE"] == "login"):?>
	<!--form-->
	<!--<div class="b-personal_account--form">
		<div class="b-grey-wrap-top">
			<div class="b-grey-wrap-top-right">
				<div class="b-grey-wrap-bottom">
					<div class="b-grey-wrap-bottom-right">
						<div class="b-application-event--title">
							<span> вход</span>
						</div>
						<div class="b-personal_account__form-wrap">
							<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
								<?if($arResult["BACKURL"] <> ''):?>
									<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
								<?endif?>
								<?foreach ($arResult["POST"] as $key => $value):?>
									<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
								<?endforeach?>
								<input type="hidden" name="AUTH_FORM" value="Y" />
								<input type="hidden" name="TYPE" value="AUTH" />
								<div class="b-personal_account__form--line">-->
									<!--form item-->
									<!--<div class="b-personal_account__form-item">
										<label for=""> адрес эл. почты</label>
										<div class="b-form-item__input">
											<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" />
										</div>
									</div>
									<div class="b-personal_account__form-item">
										<label for="">пароль</label>
										<div class="b-form-item__input">
											<input class="b-account-form--input-pass" type="password" name="USER_PASSWORD" autocomplete="off" />
										</div>
									</div>
								</div>

								<div class="b-personal_account__form--line b-personal_account__form--line-login">
									<div class="b-personal_account__form-item">
										<button class="b-bnt-form" type="submit" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>">войти</button>
										<a href="#" class="b-forget_password"> Забыли пароль?</a>
									</div>
									<div class="b-personal_account__form-item b-personal_account__form-item--right">
										<a class="b-registration__form__link" href="<?=$arResult['AUTH_REGISTER_URL']?>">регистрация</a>
									</div>
								</div>
								
								<div class="b-personal_account__form--line b-personal_account__form--line-last">
									<div class="b-personal_account__form-item">
										<div class="b-block-social">
											<div class="b-block-social-title">
												Войти через акаунты в социальных сетях
											</div>-->
                                            <?
                                            $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "cupcake_flat",
                                                array(
                                                    "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
                                                    "CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
                                                    "AUTH_URL" => $arResult["AUTH_URL"],
                                                    "POST" => $arResult["POST"],
                                                    "SHOW_TITLES" => $arResult["FOR_INTRANET"]?'N':'Y',
                                                    "FOR_SPLIT" => $arResult["FOR_INTRANET"]?'Y':'N',
                                                    "AUTH_LINE" => $arResult["FOR_INTRANET"]?'N':'Y',
                                                ),
                                                $component,
                                                array("HIDE_ICONS"=>"Y")
                                            );
                                            ?>
										<!--</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>-->
<?endif?>
<?

/*if($arResult["AUTH_SERVICES"]):?>
		<tr>
			<td colspan="2">
				<div class="bx-auth-lbl"><?=GetMessage("socserv_as_user_form")?></div>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons",
	array(
		"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
		"SUFFIX"=>"form",
	),
	$component,
	array("HIDE_ICONS"=>"Y")
);
?>
			</td>
		</tr>
<?endif?>*/?>
	<!--</table>
</form>-->
?>