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

$ajax = false;
$result = [];
if ($arResult["ERROR_MESSAGE"])
{
    $ajax = true;
	$result['MESSAGE'] = implode('<br>', $arResult["ERROR_MESSAGE"]);
}
elseif($arResult["OK_MESSAGE"])
{
	$ajax = true;
	$result['MESSAGE'] = $arResult["OK_MESSAGE"];
}

if ($ajax)
{
	$APPLICATION->RestartBuffer();

	header('Content-Type: application/json');
	echo json_encode($result);

	die();
}

?>
<section class="b-bg-grey">

    <div class="b-content-center b-sweet-table--form">

        <div class="b-grey-wrap-top">
            <div class="b-grey-wrap-top-right">
                <div class="b-grey-wrap-bottom">
                    <div class="b-grey-wrap-bottom-right">
                        <div class="b-application-event--title">
                            <span>  заявка на мероприятие</span>
                        </div>
                        <div class="b-application-event__form-wrap">
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
                            <form action="<?=POST_FORM_ACTION_URI?>" method="POST" class="js-validation-sweet-table">
                                <?=bitrix_sessid_post()?>
                                <div class="b-application-event__form--line">
                                    <div class="b-application-event__form-item b-sweet-table__item-name">
                                        <label for=""> <?=GetMessage("MFT_NAME")?></label>
                                        <div class="b-form-item__input">
                                            <input type="text" name="user_name" value="">
                                        </div>
                                    </div>
                                    <div class="b-application-event__form-item b-application-event__form-item-phone  b-sweet-table__item-phone">
                                        <label for=""> <?=GetMessage("MFT_PHONE")?></label>
                                        <div class="b-form-item__input">
                                            <input type="text" name="phone" value="" class="js-phone-mask" placeholder="+7(926)123-45-67">
                                        </div>
                                    </div>
                                    <div class="b-application-event__form-item b-application-event__form-item--date b-sweet-table__item-date">
                                        <label for=""> <?=GetMessage("MFT_TIME")?></label>
                                        <div class="b-form-item__input b-item--date-input">
                                            <input type="text" name="time" value="" onclick='showcalendar(this)' readonly='readonly'>
                                            <span class="b-calendar"> i</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="b-application-event__form--line">
                                    <div class="b-application-event__form-item b-form-item__textarea">
                                        <label class="b-sweet-table-label" for=""> <?=GetMessage("MFT_MESSAGE")?></label>
                                        <div class="b-form-item__input">
                                            <textarea name="MESSAGE"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="b-application-event__form--line">
                                    <?if($arParams["USE_CAPTCHA"] == "Y"):?>
                                    <div class="b-application-event__form-item b-form--captcha">
                                        <label for=""> <?=GetMessage("MFT_CAPTCHA")?></label>
                                        <div class="b-form-item__input b-item__input--capcha">
                                            <input type="text" name="captcha_word" value="">
                                        </div>
                                        <div class="b-captcha-line">
                                            <div class="b-item--captcha--img">
                                                <input id="captchaSid" type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
                                                <img id="captchaImg" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
                                            </div>
                                            <button id="reloadCaptcha" class="b-bnt-form-capcha">отправить</button>
                                        </div>
                                    </div>
                                    <?endif;?>
                                    <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
                                    <div class="b-form-item--right">
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


</section>

<script type="text/javascript">
	var sunday_holidays = 0;
	var holidays = [];
	var dhour = 15;
	var dminutes = 0;
	var free_delivery = [];
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

