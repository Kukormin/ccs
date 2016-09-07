<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

ShowMessage($arParams["~AUTH_RESULT"]);

?>


<div class="b-personal_account--form">
    <div class="b-grey-wrap-top">
        <div class="b-grey-wrap-top-right">
            <div class="b-grey-wrap-bottom">
                <div class="b-grey-wrap-bottom-right">
                    <div class="b-application-event--title">
                        <span> Восставновление пароля</span>
                    </div>
                    <div class="b-personal_account__form-wrap">
                        <form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
                            <?
                            if (strlen($arResult["BACKURL"]) > 0)
                            {
                                ?>
                                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                                <?
                            }
                            ?>
                            <input type="hidden" name="AUTH_FORM" value="Y">
                            <input type="hidden" name="TYPE" value="SEND_PWD">

                                <div class="b-personal_account__form-item">
                                    <label for=""> адрес эл. почты</label>
                                    <div class="b-form-item__input">
                                        <input type="text" name="USER_EMAIL" />
                                    </div>
                                </div>
                            </div>

                            <div class="b-personal_account__form--line b-personal_account__form--line-login">
                                <div class="b-personal_account__form-item">
                                    <button class="b-bnt-form" type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>">Восстановить пароль</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



