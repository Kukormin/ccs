<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");
?>

<section class="b-topblock b-min-height-213 b-topblock-mobhide">
</section>

<section class="b-bg-grey">
    <div class="b-content-center b-block-account">

        <div class="b-block-new--title b-block-account--title"> Восстановление пароля</div>

        <div class="b-block-account--wrap b-title--border-top i-padding-bott-55">
            <div class="b-block-account--content-wrap">

                <?
                if (!empty($arParams["~AUTH_RESULT"])):
                    $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
                    ?>
                    <div
                        class="alert <?= ($arParams["~AUTH_RESULT"]["TYPE"] == "OK" ? "alert-success" : "alert-danger") ?>"><?= nl2br(htmlspecialcharsbx($text)) ?></div>
                <? endif ?>

                <form method="post" action="<?= $arResult["AUTH_FORM"] ?>" name="bform">
                    <? if (strlen($arResult["BACKURL"]) > 0): ?>
                        <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                    <? endif ?>
                    <input type="hidden" name="AUTH_FORM" value="Y">
                    <input type="hidden" name="TYPE" value="CHANGE_PWD">

                    <div class="bx-authform-formgroup-container">
                        <div class="bx-authform-label-container"><?= GetMessage("AUTH_LOGIN") ?></div>
                        <div class="bx-authform-input-container">
                            <input type="text" name="USER_LOGIN" maxlength="255"
                                   value="<?= $arResult["LAST_LOGIN"] ?>"/>
                        </div>
                    </div>

                    <div class="bx-authform-formgroup-container">
                        <div class="bx-authform-label-container"><?= GetMessage("AUTH_CHECKWORD") ?></div>
                        <div class="bx-authform-input-container">
                            <input type="text" name="USER_CHECKWORD" maxlength="255"
                                   value="<?= $arResult["USER_CHECKWORD"] ?>"/>
                        </div>
                    </div>

                    <div class="bx-authform-formgroup-container">
                        <div class="bx-authform-label-container"><?= GetMessage("AUTH_NEW_PASSWORD_REQ") ?></div>
                        <div class="bx-authform-input-container">
                            <? if ($arResult["SECURE_AUTH"]): ?>
                                <div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none">
                                    <div class="bx-authform-psw-protected-desc">
                                        <span></span><? echo GetMessage("AUTH_SECURE_NOTE") ?></div>
                                </div>

                                <script type="text/javascript">
                                    document.getElementById('bx_auth_secure').style.display = '';
                                </script>
                            <? endif ?>
                            <input type="password" name="USER_PASSWORD" maxlength="255"
                                   value="<?= $arResult["USER_PASSWORD"] ?>" autocomplete="off"/>
                        </div>
                    </div>

                    <div class="bx-authform-formgroup-container">
                        <div class="bx-authform-label-container"><?= GetMessage("AUTH_NEW_PASSWORD_CONFIRM") ?></div>
                        <div class="bx-authform-input-container">
                            <? if ($arResult["SECURE_AUTH"]): ?>
                                <div class="bx-authform-psw-protected" id="bx_auth_secure_conf" style="display:none">
                                    <div class="bx-authform-psw-protected-desc">
                                        <span></span><? echo GetMessage("AUTH_SECURE_NOTE") ?></div>
                                </div>

                                <script type="text/javascript">
                                    document.getElementById('bx_auth_secure_conf').style.display = '';
                                </script>
                            <? endif ?>
                            <input type="password" name="USER_CONFIRM_PASSWORD" maxlength="255"
                                   value="<?= $arResult["USER_CONFIRM_PASSWORD"] ?>" autocomplete="off"/>
                        </div>
                    </div>

                    <div class="bx-authform-formgroup-container">
                        <input type="submit" class="b-bnt-form b-bnt-form--account" name="change_pwd"
                               value="<?= GetMessage("AUTH_CHANGE") ?>"/>
                    </div>

                    <div class="bx-authform-description-container">
                        <? echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; ?>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    document.bform.USER_LOGIN.focus();
</script>
