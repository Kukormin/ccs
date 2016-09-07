<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? $fVerComposite = (defined("SM_VERSION") && version_compare(SM_VERSION, "14.5.0") >= 0 ? true : false); ?>
<? if($fVerComposite) $this->setFrameMode(true); ?>
<?$ALX = "FID".$arParams["FORM_ID"];?>
<?$capCode = $GLOBALS["APPLICATION"]->CaptchaGetCode();?>
<?$actionPage = $APPLICATION->GetCurPage();
	if(strpos($actionPage, "index.php") !== false)
	$actionPage = $APPLICATION->GetCurDir();
?>

	<div class="b-reviews-table--form">
		<div class="b-grey-wrap-top">
			<div class="b-grey-wrap-top-right">
				<div class="b-grey-wrap-bottom">
					<div class="b-grey-wrap-bottom-right">
						<div class="b-application-event--title">
							оставить отзыв
						</div>
						<div class="b-application-event__form-wrap">
							<form id="f_feedback_<?=$ALX?>" name="f_feedback_<?=$ALX?>" action="<?=$actionPage?>" method="post" enctype="multipart/form-data" class="js-form-validation">
								<input type="hidden" name="FEEDBACK_FORM_<?=$ALX?>" value="Y" />
								<?echo bitrix_sessid_post()?>
								<div class="b-application-event__form--line">
									<div class="b-application-event__form-item b-form-item-reviews">
										<label for=""> ваше имя</label>
										<div class="b-form-item__input">
											<input id="REVIEW_TITLE_FID11" type="text" value="" name="FIELDS[REVIEW_TITLE_FID1]">
											<input id="PUBLICATION_DATE_FID11" type="hidden" value="<?=date('d.m.Y');?>" name="FIELDS[PUBLICATION_DATE_FID1]">
										</div>
									</div>
									<div class="b-application-event__form-item b-form-item-reviews">
										<label for=""> EMAIL</label>
										<div class="b-form-item__input">
											<input id="EMAIL_FID11" type="text" value="" name="FIELDS[EMAIL_FID1]" class="email">
										</div>
									</div>
								</div>
								<div class="b-application-event__form--line">
									<div class="b-application-event__form-item b-form-item__textarea">
										<label for=""> отзыв</label>
										<div class="b-form-item__input">
											<textarea id="FB_TEXT_FID11" name="FIELDS[FB_TEXT_FID1]"></textarea>
										</div>
									</div>
								</div>
								<div class="b-application-event__form--line">
									<?if($arParams["USE_CAPTCHA"] == "Y"):?>
									<div class="b-application-event__form-item b-form--captcha">
										<label for=""> символы с картинки</label>
										<div class="b-form-item__input b-item__input--capcha">
											<input type="text" name="captcha_word" value="">
										</div>
										<div class="b-captcha-line">
											<div class="b-item--captcha--img">
												<input id="captchaSid" type="hidden" name="captcha_sid" value="<?=htmlspecialcharsEx($capCode)?>">
												<img id="captchaImg" src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsEx($capCode)?>" width="180" height="40" alt="CAPTCHA">
											</div>
											<button id="reloadCaptcha" class="b-bnt-form-capcha">отправить</button>
										</div>
									</div>
									<?endif;?>
									<div class="b-form-item--right">
										<input class="b-bnt-form" id="fb_close_FID1" type="submit" value="Отправить" name="SEND_FORM_FID1">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>