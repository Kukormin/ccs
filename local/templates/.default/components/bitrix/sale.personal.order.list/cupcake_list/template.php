<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>




    <section class="b-topblock b-min-height-213 b-topblock-mobhide">
    </section>

<?if(!empty($arResult['ERRORS']['FATAL'])):?>

    <?foreach($arResult['ERRORS']['FATAL'] as $error):?>
        <?=ShowError($error)?>
    <?endforeach?>

    <?$component = $this->__component;?>
    <?if($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])):?>
        <?$APPLICATION->AuthForm('', false, false, 'N', false);?>
    <?endif?>

<?else:?>

    <?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

        <?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
            <?=ShowError($error)?>
        <?endforeach?>

    <?endif?>


    <section class="b-bg-grey">
        <div class="b-content-center b-block-account">

            <div class="b-block-new--title b-block-account--title"> личный кабинет </div>

            <div class="b-block-account--wrap b-title--border-top">
                <div class="b-block-account--content-wrap">

                    <div class="b-block-account__navigation">
                        <div class="b-block-account__link-nav">
                            <a class="b-account-link-nav__item" href="/personal/">
                                <span> Персональные данные</span> </a>
                            <a class="b-account-link-nav__item" href="/personal/shipping_address/">
                                <span> Адреса доставки</span> </a>
                            <a class="b-account-link-nav__item active" href="/personal/order/">
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
                    <?if(empty($arResult['ORDERS']) || !isset($arResult['ORDERS'])):?>
                        <div class="no_orders">Вы пока не делали заказов, самое время <a href="/catalog/cupcakes/">попробовать</a>.</div>
                    <?elseif(!empty($arResult['ORDERS'])):?>
                    <div class="b-order-history-content b-block-account--wrap">
                        <div id="order-history" class="b-order-history_wrap">

			
                <?foreach($arResult["ORDER_BY_STATUS"] as $key => $group):?>

                    <?foreach($group as $k => $order):?>

                        <div class="b-order-history_title"><span class="b-order-number">  № <?=$order["ORDER"]["ACCOUNT_NUMBER"]?></span> <span class="b-order-history--date"> <?=$order["ORDER"]["DATE_INSERT_FORMATED"];?></span> </div>
                            <div class="b-order-history-sub_nav b-title--border-top b-title--border-bottom">
								<?$APPLICATION->IncludeComponent(
									"bitrix:sale.personal.order.detail",
									"cupcake_history",
									Array(
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"CACHE_GROUPS" => "Y",
										"CACHE_TIME" => "3600",
										"CACHE_TYPE" => "A",
										"COMPONENT_TEMPLATE" => ".default",
										"CUSTOM_SELECT_PROPS" => array(""),
										"ID" => $order['ORDER']['ID'],
										"PATH_TO_CANCEL" => "",
										"PATH_TO_LIST" => "",
										"PATH_TO_PAYMENT" => "payment.php",
										"PICTURE_HEIGHT" => "110",
										"PICTURE_RESAMPLE_TYPE" => "1",
										"PICTURE_WIDTH" => "110",
										"PROP_1" => array(""),
										"SET_TITLE" => "Y",
										"URL_TO_COPY" => $order["ORDER"]["URL_TO_COPY"]
									)
								);?>
     
                            </div>
                    <?endforeach;?>
                <?endforeach;?>
            <?endif;?>
                        </div>

                    </div>

                </div>
            </div>


        </div>
    </section>

<?endif?>


