<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
//print_r($arResult);
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



<section class="b-topblock b-min-height-213 b-topblock-mobhide">
</section>




<section class="b-bg-grey">
    <div class="b-content-center b-block-account">

        <div class="b-block-new--title b-block-account--title"> личный кабинет </div>

        <div class="b-block-account--wrap b-title--border-top i-padding-bott-75">
            <div class="b-block-account--content-wrap">

                <div class="b-block-account__navigation">
                    <div class="b-block-account__link-nav">
                        <a class="b-account-link-nav__item" href="/personal/">
                            <span> Персональные данные</span> </a>
                        <a class="b-account-link-nav__item active" href="#">
                            <span> Адреса доставки</span> </a>
                        <a class="b-account-link-nav__item" href="/personal/order/">
                            <span> История заказов</span> </a>
                    </div>

                    <div class="account__navigation--mobile"> </div>

                    <div class="b-account-navigation__mobile-wrap b-block-mobile-only">
                        <ul class="b-account-navigation__mobile-list">
                            <li class="b-account-navigation__mobile-item">
                                <a class="b-account-navigation__mobile-link" href="/personal/">
                                    <span> Персональные данные</span> </a>
                            </li>
                            <li class="b-account-navigation__mobile-item">
                                <a class="b-account-navigation__mobile-link" href="#">
                                    <span> Адреса доставки</span> </a>
                            </li>
                            <li class="b-account-navigation__mobile-item">
                                <a class="b-account-navigation__mobile-link" href="/personal/order/">
                                    <span> История заказов</span> </a>
                            </li>
                        </ul>
                    </div>
                </div>


                <form class="profile_form" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
                <ol class="b-block-account-address__list">
                    <?foreach($arResult['arUser']['UF_ADRESSES'] as $key => $adress):?>
                        <?php
                        $text = explode('|', $adress);
                        ?>
                    <li class="b-block-account-address__item js-address-block">
                        <span class="b-block-account-address__item-area js-address-value"><?=$text[0]?></span>

                        <div class="b-application-event__form--line js-address-edit" style="display: none;">
                            <div class="b-application-event__form-item b-form-item-shipping-address">
                                <div class="b-form-item__input">
                                    <input type="text" name="UF_ADRESSES[<?=$key?>]" value="<?=$text[0]?>">
                                </div>
                            </div>
                            <div class="b-application-event__form-item b-form-item--select">
                                <div class="b-form-item__input b-form-item__input--select">
                                    <p class="select_title">По Москве</p>
                                    <select class="shipping_region">
                                        <?foreach($arResult['arUser']['DELIVERY'] as $region):?>
                                            <?if($region != 'Самовывоз'):?>
                                                <option value="<?=$region?>"><?=$region?></option>
                                            <?endif;?>
                                        <?endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="b-block-account-address__group">
                            <span class="b-account--change js-address-change"> Изменить  </span>
                            <span class="b-account_address--delete js-address-delete">Удалить</span>
                        </div>
                    </li>
                    <?endforeach;?>
                </ol>

                <!--form-account-->
                <div class="b-account-form">
                    <div class="b-account-form--wrap b-account-form--wrap-shipping-address">
                       <div>
                            <?=$arResult["BX_SESSION_CHECK"]?>
                            <input type="hidden" name="lang" value="<?=LANG?>" />
                            <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
                            <input type="hidden" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" />
                            <input type="hidden" name="EMAIL" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
                            <input type="hidden" name="LOGIN" value="<? echo $arResult["arUser"]["EMAIL"]?>" />


                            <div class="b-application-event__form--line">
                                <div class="b-application-event__form-item b-form-item-shipping-address">
                                    <label for=""> новый адрес</label>
                                    <div class="b-form-item__input">
                                        <input type="text" name="UF_ADRESSES[<?=count($arResult['arUser']['UF_ADRESSES'])?>]" value="">
                                    </div>
                                </div>
                                <div class="b-application-event__form-item b-form-item--select">
                                    <label for=""> зона доставки</label>
                                    <div class="b-form-item__input b-form-item__input--select">
                                        <p class="select_title">По Москве</p>
                                        <select class="shipping_region">
                                            <?foreach($arResult['arUser']['DELIVERY'] as $region):?>
                                                <?if($region != 'Самовывоз'):?>
                                                    <option value="<?=$region?>"><?=$region?></option>
                                                <?endif;?>
                                            <?endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="b-account-form--line">
                                <input class="b-bnt-form b-bnt-form--account" type="submit" name="save" value="<?=GetMessage("MAIN_SAVE")?>">
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>


    </div>
</section>
