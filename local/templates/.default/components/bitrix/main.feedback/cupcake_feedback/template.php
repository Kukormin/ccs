<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<div class="b-personal_account--form">
						<div class="b-grey-wrap-top">
							<div class="b-grey-wrap-top-right">
								<div class="b-grey-wrap-bottom">
									<div class="b-grey-wrap-bottom-right">
										<div class="b-application-event--title">
											<span> письмо в компанию</span>
										</div>
										<div class="b-personal_account__form-wrap">
											<?if(!empty($arResult["ERROR_MESSAGE"]))
											{
												foreach($arResult["ERROR_MESSAGE"] as $v)
													ShowError($v);
											}
											if(strlen($arResult["OK_MESSAGE"]) > 0)
											{
												?><div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
											}
											?>
											<form action="<?=POST_FORM_ACTION_URI?>" method="POST" class="js-validation-feedback">
												<?=bitrix_sessid_post()?>
                                                <? if(strpos($APPLICATION->GetCurPage(),'/contacts/')===0): ?>
                                                <div class="b-personal_account__form--line contacts_comment">
                                                        Мы всегда рады знакомству с новыми партнерами. Если вы заинтересованы в оптовых закупках, совместных промо-акциях или других партнерских проектах, смело пишите нам.
                                                </div>
                                                <?endif;?>
												<div class="b-personal_account__form--line">
													<div class="b-personal_account__form-item">
														<label for=""> <?=GetMessage("MFT_NAME")?></label>
														<div class="b-form-item__input">
															<input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
														</div>
													</div>
													<div class="b-personal_account__form-item">
														<label for=""> <?=GetMessage("MFT_EMAIL")?></label>
														<div class="b-form-item__input">
															<input type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>" class="email">
														</div>
													</div>
												</div>

												<div class="b-personal_account__form--line">
													<div class="b-personal_account__form-item b-form-item__textarea">
														<label for=""> <?=GetMessage("MFT_MESSAGE")?></label>
														<div class="b-form-item__input">
															<textarea name="MESSAGE"><?=$arResult["MESSAGE"]?></textarea>
														</div>
													</div>
												</div>
												<div class="b-personal_account__form--line">
													<?if($arParams["USE_CAPTCHA"] == "Y"):?>
													<div class="b-personal_account__form-item b-form--captcha">
														<label for=""><?=GetMessage("MFT_CAPTCHA")?></label>
														<div class="b-form-item__input b-item__input--capcha">
															<input type="text" name="captcha_word" value="">
														</div>
														<div class="b-item--captcha--img">
															<input id="captchaSid" type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
															<img id="captchaImg" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
														</div>
														<button id="reloadCaptcha" class="b-bnt-form-capcha">отправить</button>
													</div>
													<?endif;?>
													<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
													<div class="b-personal_account__form-item b-personal_account__form-item-right-btn">
														<input class="b-bnt-form" type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#reloadCaptcha').click(function(){
			$('#whiteBlock').show();
			$.getJSON('<?=$this->__folder?>/reload_captcha.php', function(data) {
				$('#captchaImg').attr('src','/bitrix/tools/captcha.php?captcha_sid='+data);
				$('#captchaSid').val(data);
				$('#whiteBlock').hide();
			});
			return false;
		});
	});
</script>
