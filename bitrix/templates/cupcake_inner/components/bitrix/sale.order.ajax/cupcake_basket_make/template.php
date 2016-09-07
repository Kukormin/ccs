<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
//print_r($arResult);
$price = preg_replace('|(\D)|', '', $arResult['ORDER_PRICE_FORMATED']);
?>
<script>
    $(document).ready(function () {
        function deliveryPrice() {
            return parseInt($('.js_radio_input input:checked').data('price'));
        }

        var price = <?=$price?>;
        var total_price = 0;

        $('.js_radio_input input').change(function () {
            if ($('.js_radio_input input:checked').data('price') == 0) {
                total_price = price + deliveryPrice();
                $('.js_total_price').html((total_price > 10000 ? format_number(total_price) : total_price) + ' ' + '<span class="rub">i</span>');
                $('.hidden_total_price').html(total_price + ' ' + '<span class="rub">i</span>');
                $('.js_footer_label').html('Самовывоз');
                $('.js_price_footer').html('Итого');
                $('.hidden_delivery_type').val($('.js_radio_input input:checked').data('deltype'));
                $('.hidden_del_addr').val($('.js_radio_input input:checked').data('addr'));
                var position = $('.b-method-shipping-input.js_radio_input input:checked').position().top;
                if ($('.b-method-shipping-input.js_radio_input input:checked').attr('id') == 'delivery_new') position = $('.b-method-shipping-input.js_radio_input input:checked').parent().position().top - 100;
                $(".b-method-shipping_item.b-method-shipping_item-date").css('top', position - 40 + 'px');
            } else if ($('.js_radio_input input:checked').data('paysys') == 'gift') {
                $('.js_paysystem_type1').hide();
                $('.js_paysystem_type2').hide();
                $('.js_footer_label').html('Сделать подарок');
                $('.js_price_footer').html('Итого');
                $('.js_total_price').html(price + ' ' + '<span class="rub">i</span>');
                $('.hidden_total_price').html(price + ' ' + '<span class="rub">i</span>');
            } else if ($('.js_radio_input input:checked').prop('id') == 'delivery_new') {
                $('.js_footer_label').html($('.shipping_region').val() + ' ' + $('.shipping_region option:selected').data('price') + ' ' + '<span class="rub">i</span>');
                $('.js_price_footer').html('Итого с доставкой');
                $('.js_total_price').html(price + parseInt($('.shipping_region option:selected').data('price')) + ' ' + '<span class="rub">i</span>');
                $('.hidden_total_price').html(price + parseInt($('.shipping_region option:selected').data('price')) + ' ' + '<span class="rub">i</span>');
                $('.hidden_delivery_type').val($('.shipping_region option:selected').data('deltype'));
            } else {
                total_price = price + deliveryPrice();
                $('.js_footer_label').html($('.js_radio_input input:checked').data('id') + ' ' + $('.js_radio_input input:checked').data('price') + ' ' + '<span class="rub">i</span>');
                $('.js_price_footer').html('Итого с доставкой');
                $('.js_total_price').html((total_price > 10000 ? format_number(total_price) : total_price) + ' ' + '<span class="rub">i</span>');
                $('.hidden_total_price').html(total_price + ' ' + '<span class="rub">i</span>');
                $('.hidden_delivery_type').val($('.js_radio_input input:checked').data('deltype'));
                $('.hidden_del_addr').val($('.js_radio_input input:checked').data('addr'));
                var position = $('.b-method-shipping-input.js_radio_input input:checked').position().top;
                if ($('.b-method-shipping-input.js_radio_input input:checked').attr('id') == 'delivery_new') position = $('.b-method-shipping-input.js_radio_input input:checked').parent().position().top - 100;
                $(".b-method-shipping_item.b-method-shipping_item-date").css('top', position - 40 + 'px');
            }
        });

        $('.shipping_region').change(function () {
            $('.js_footer_label').html($('.shipping_region').val() + ' ' + $('.shipping_region option:selected').data('price') + ' ' + '<span class="rub">i</span>');
            $('.js_price_footer').html('Итого с доставкой');
            $('.js_total_price').html(price + parseInt($('.shipping_region option:selected').data('price')) + ' ' + '<span class="rub">i</span>');
            $('.hidden_total_price').html(price + parseInt($('.shipping_region option:selected').data('price')) + ' ' + '<span class="rub">i</span>');
            $('.hidden_delivery_type').val($('.shipping_region option:selected').data('deltype'));
        });

        /*$('.hidden_addr').focus(function () {
         $('.js_radio_input input').prop('checked', false);
         $(".b-method-shipping_item.b-method-shipping_item-date").css('top',$('.b-method-shipping__line.b-method-shipping__line--last').position());
         });*/

        $('.b-block-adress--add').click(function () {
            $('.b-block-adress--add').hide();
            $('.b-application-event__form--line').show();
        });

        $('#ORDER_FORM').validate({
            rules: {
                NAME: {
                    required: true,
                    minlength: 3
                },
                EMAIL: {
                    required: true
                },
                PERSONAL_PHONE: {
                    required: true
                },
                date: {
                    required: true
                },
                timefrom: {
                    required: true
                },
                timeto: {
                    required: true
                }
            },
            messages: {
                NAME: {
                    required: 'Обязательное поле',
                    minlength: 'Не менее 3 символов'
                },
                EMAIL: {
                    required: 'Обязательное поле',
                    email: 'Введите валидную почту'
                },
                PERSONAL_PHONE: 'Обязательное поле',
                date: 'Обязательно',
                timefrom: 'Обязательно',
                timeto: 'Обязательно',
                hidden_delivery_adress: 'Обязательное поле'
            }
        });
        <?if(!$USER->IsAuthorized()) {?>
        $('.hidden_addr').addClass('required');
        <? } ?>
        $('.js_radio_input input').change();
    })
</script>




<?
$user_id = $USER->GetID();
if (isset($user_id) && $user_id != '') {
    $rsUser = $USER->GetByID($user_id);
    $rows_q = $rsUser->SelectedRowsCount();
    if ($rows_q > 0) {
        $arUser = $rsUser->Fetch();
        ?>
        <form action="/include/cart_sd_step.php" method="POST" name="ORDER_FORM" id="ORDER_FORM"
              enctype="multipart/form-data">
            <!--form-account-->
            <!--<section class="b-topblock b-min-height-213 b-topblock-mobhide">
            </section>-->


            <section class="b-bg-grey b-bg-grey--order">
                <div class="b-content-center b-block-order">
                    <div class="b-block-new--title b-block-order--title "> ваш заказ</div>
                    <div class="b-block-order--wrap  b-title--border-top">
                        <div class="b-block-order--content-wrap">
                            <div class="b-block-basket__link-nav">
                                <a class="b-block-basket-link-nav__item" href="/personal/cart">
                                    <span> Корзина</span> </a>
                                <a class="b-block-basket-link-nav__item active" href="/personal/order/make/">
                                    <span> оформление</span> </a>
                            </div>

                            <div class="personal-information">
                                <div class="b-information--title"> персональные данные</div>
                                <? if (!$USER->IsAuthorized()): ?>
                                    <span class="js_cart_login">я уже зарегистрирован </span>
                                <? endif; ?>
                            </div>


                            <!--form-account-->
                            <div class="b-account-form b-form-order">
                                <div class="b-account-form--wrap">
                                    <div id="order_form_content">
                                        <div class="b-account-form">
                                            <div class="b-account-form--line">
                                                <label for="">ваше имя</label>

                                                <div class="b-account-form--input">
                                                    <input type="text" name="NAME" value="<?= $arUser["NAME"] ?>"
                                                           class="required"/>
                                                </div>
                                            </div>
                                            <div class="b-account-form--line">
                                                <label for="">Адрес эл. почты</label>

                                                <div class="b-account-form--input">
                                                    <input type="email" name="EMAIL" value="<?= $arUser["EMAIL"] ?>"
                                                           class="required email"/>
                                                </div>
                                            </div>
                                            <div class="b-account-form--line">
                                                <label for="">телефон</label>

                                                <div class="b-account-form--input">
                                                    <input type="text" name="PERSONAL_PHONE"
                                                           value="<?= str_replace('+7', '', $arUser["PERSONAL_PHONE"]) ?>"
                                                           class="js-phone-mask required"
                                                           placeholder="+7(926)123-45-67"/>
                                                </div>
                                            </div>
                                            <!--<div class="b-account-form--line">
                                                 <label for="">Комментарий</label>
                                                 <div class="b-account-form--input">
                                                     <textarea name="COMMENT" rows="10" cols="35" placeholder="Здесь можно оставить комментарий по Вашему заказу, в том числе сделать данный заказ подарком для кого-либо." class="cart_form_textarea"></textarea>
                                                 </div>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="b-method-shipping b-title--border-top">
                                    <div class="b-method-shipping__line">
                                        <div class="b-information--title"> Способ и адрес доставки</div>

                                        <!--<div class="b-method-shipping_item">
                                            <div class="b-method-shipping-input js_radio_input">
                                                <input class="radio" type="radio" id="gift" name="address" data-paysys="gift"/>
                                                <label class="b-label-radio" for="gift">Сделать подарок</label>
                                            </div>
                                        </div>
                                        <div class="b-method-shipping_item">
                                            <span class="b-method-shipping-text"> Мы сделаем подарок от вашего имени для человека, адрес или телефон которого вы нам сообщите</span>
                                        </div>
                                        <div class="b-method-shipping_item">
                                            <a href="#" class="b-bnt-form b-bnt-form--green">сообщить</a>
                                        </div>-->
                                    </div>

                                    <div class="b-method-shipping__line">
                                        <div class="b-method-shipping--title js-del-btn">
                                            Самовывоз - бесплатно
                                        </div>
                                        <div class="js-del-slide-wrap">
                                            <?/* $APPLICATION->IncludeFile('/include/pickup_inc.php', array(),
                                                array(
                                                    'MODE' => 'html',
                                                    'TEMPLATE' => 'page_inc.php',
                                                )
                                            );*/ ?>
                                            <div class="b-method-shipping_item">
                                                <? $APPLICATION->IncludeComponent(
                                                    "bitrix:news.list",
                                                    "cupcake_pickup_adr",
                                                    Array(
                                                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                                        "ADD_SECTIONS_CHAIN" => "N",
                                                        "AJAX_MODE" => "N",
                                                        "AJAX_OPTION_ADDITIONAL" => "",
                                                        "AJAX_OPTION_HISTORY" => "N",
                                                        "AJAX_OPTION_JUMP" => "N",
                                                        "AJAX_OPTION_STYLE" => "Y",
                                                        "CACHE_FILTER" => "N",
                                                        "CACHE_GROUPS" => "Y",
                                                        "CACHE_TIME" => "3600",
                                                        "CACHE_TYPE" => "A",
                                                        "CHECK_DATES" => "Y",
                                                        "COMPONENT_TEMPLATE" => "cupcake_pickup_adr",
                                                        "DETAIL_URL" => "",
                                                        "DISPLAY_BOTTOM_PAGER" => "N",
                                                        "DISPLAY_DATE" => "N",
                                                        "DISPLAY_NAME" => "N",
                                                        "DISPLAY_PICTURE" => "N",
                                                        "DISPLAY_PREVIEW_TEXT" => "N",
                                                        "DISPLAY_TOP_PAGER" => "N",
                                                        "FIELD_CODE" => array(0 => "", 1 => "",),
                                                        "FILTER_NAME" => "",
                                                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                                        "IBLOCK_ID" => "27",
                                                        "IBLOCK_TYPE" => "pickupadr",
                                                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                                        "INCLUDE_SUBSECTIONS" => "N",
                                                        "MESSAGE_404" => "",
                                                        "NEWS_COUNT" => "20",
                                                        "PAGER_BASE_LINK_ENABLE" => "N",
                                                        "PAGER_DESC_NUMBERING" => "N",
                                                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                                        "PAGER_SHOW_ALL" => "N",
                                                        "PAGER_SHOW_ALWAYS" => "N",
                                                        "PAGER_TEMPLATE" => ".default",
                                                        "PAGER_TITLE" => "Новости",
                                                        "PARENT_SECTION" => "",
                                                        "PARENT_SECTION_CODE" => "",
                                                        "PREVIEW_TRUNCATE_LEN" => "",
                                                        "PROPERTY_CODE" => array(0 => "PICKUP_ADR", 1 => "",),
                                                        "SET_BROWSER_TITLE" => "N",
                                                        "SET_LAST_MODIFIED" => "N",
                                                        "SET_META_DESCRIPTION" => "N",
                                                        "SET_META_KEYWORDS" => "N",
                                                        "SET_STATUS_404" => "N",
                                                        "SET_TITLE" => "N",
                                                        "SHOW_404" => "N",
                                                        "SORT_BY1" => "ACTIVE_FROM",
                                                        "SORT_BY2" => "SORT",
                                                        "SORT_ORDER1" => "DESC",
                                                        "SORT_ORDER2" => "ASC"
                                                    )
                                                ); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="b-method-shipping__line b-method-shipping__line--last">
                                        <div class="b-method-shipping--title js-del-btn">
                                            <span>Доставка — от 400 руб.</span>
                                        </div>
                                        <div class="js-del-slide-wrap">
                                            <? $APPLICATION->IncludeFile('/include/del_inc.php', array(),
                                                array(
                                                    'MODE' => 'html',
                                                    'TEMPLATE' => 'page_inc.php',
                                                )
                                            ); ?>

                                            <div class="b-method-shipping_item b-method-shipping_item-full">
                                                <? $checked = true; ?>
                                                <? foreach ($arUser['UF_ADRESSES'] as $key => $adress):
                                                    $text = explode('|', $adress);
                                                    ?>
                                                    <div class="b-method-shipping-input js_radio_input">
                                                        <? if (empty($adress)) { ?>
                                                            <script>
                                                                $('.hidden_addr').show().focus();
                                                            </script>
                                                        <? } else { ?>
                                                        <input class="radio" name="address" type="radio"
                                                               id="delivery<?= $key ?>"
                                                               data-deltype="<?= $arResult['DELIVERY_TYPES_ARR'][$text[1]][$text[1]] ?>"
                                                               data-id="<?= $text[1]; ?>"
                                                               data-price="<?= $arResult['DELIVERY_PRICE_ARR'][$text[1]][$text[1]] ?>"
                                                               data-addr="<?= $text[0] ?>"
                                                            <?= $checked ? 'checked' : '' ?>/>
                                                            <label class="b-label-radio"
                                                                   for="delivery<?= $key ?>"><?= $text[0] ?></label>
                                                        <input type="hidden"
                                                               value="<?= $arResult['DELIVERY_PRICE_ARR'][$text[1]][$text[1]] ?>"
                                                               name="delivery_price">
                                                        <input type="hidden" name="delivery_adress"
                                                               value="<?= $text[0] ?>">
                                                            <? $checked = false; ?>
                                                        <? } ?>
                                                    </div>
                                                <? endforeach; ?>
                                            </div>


                                            <div class="b-application-event__form--line">
                                                <div
                                                    class="b-application-event__form-item b-form-item-shipping-address">
                                                    <label for=""> новый адрес</label>

                                                    <div style="position: relative; margin:0;"
                                                         class="b-method-shipping-input js_radio_input">
                                                        <input id="delivery_new" class="radio" name="address"
                                                               type="radio"
                                                            <?= $checked ? 'checked' : '' ?>
                                                               style="position:absolute; left:0; top:5px;"/>
                                                        <label class="b-label-radio"
                                                               for="delivery_new"
                                                               style="position:absolute; left:0; top:8px;"></label>

                                                        <div class="b-form-item__input" style="margin-left:45px;">

                                                            <input class="hidden_addr" type="text"
                                                                   name="hidden_delivery_adress"
                                                                   value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="b-application-event__form-item b-form-item--select">
                                                    <label for=""> зона доставки</label>

                                                    <div class="b-form-item__input b-form-item__input--select">
                                                        <p class="select_title">По Москве</p>
                                                        <select class="shipping_region">
                                                            <? foreach ($arResult['DELIVERY'] as $key => $region): ?>
                                                                <? if ($region['NAME'] != 'Самовывоз'): ?>
                                                                    <option value="<?= $region['NAME'] ?>"
                                                                            data-deltype="<?= $key ?>"
                                                                            data-price="<?= $arResult['DELIVERY_PRICE_ARR'][$region['NAME']][$region['NAME']] ?>"><?= $region['NAME'] ?></option>
                                                                <? endif; ?>
                                                            <? endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										
										<script type="text/javascript">
											$(document).ready(function() {
												$('.js-mask-timefrom').focusout(function(){
													arr = $(this).val().split(':');
													if($.isNumeric(arr[0]) == true && $.isNumeric(arr[1]) == true){
														if(arr[0] < 10){
															alert("Доставка возможна только в диапазоне с 10:00 до 20:00");
															$(this).val("");
														}
														
													}
												});
												$('.js-mask-timeto').focusout(function(){
													arr = $(this).val().split(':');
													if($.isNumeric(arr[0]) == true && $.isNumeric(arr[1]) == true){
														if(arr[0] > 20){
															alert("Доставка возможна только в диапазоне с 10:00 до 20:00");
															$(this).val("");
														}
														
													}
												});
											});
										</script>
										
                                        <div class="b-method-shipping_item b-method-shipping_item-date">
                                            <div
                                                class="b-application-event__form-item b-application-event__form-item--date i-margin-0">
                                                <label for="date"> дата доставки</label>

                                                <div class="b-form-item__input b-item--date-input">
                                                    <input type='text' name='date' readonly='readonly'
                                                           onclick='showcalendar(this)'/>
                                                    <span class="b-calendar"> i</span>
                                                </div>
                                            </div>
                                            <div
                                                class="b-application-event__form-item b-application-event__form-item--time">
                                                <label for=""> время доставки</label>

                                                <div class="b-application-event__time">
                                                    <div class="b-form-item__input">
                                                        <input type="text" placeholder=":" name="timefrom"
                                                               class="js-mask-timefrom">
                                                    </div>
                                                    <span></span>

                                                    <div class="b-form-item__input">
                                                        <input type="text" placeholder=":" name="timeto"
                                                               class="js-mask-timeto">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="b-payment-method  b-title--border-top">
                            <div class="b-method-shipping__line">
                                <div class="b-information--title">Способ оплаты</div>
                                <? $flag = true; ?>
                                <? foreach ($arResult["PAYSYSTEM_UNAUTHED"] as $arPaySystem) { ?>
                                    <div
                                        class="b-method-shipping_item b-method-shipping_item--payment js_paysystem_type<?= $arPaySystem["ID"] ?>">
                                        <div class="b-method-shipping-input">
                                            <? if ($flag) { ?>
                                                <input class="radio" id="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>"
                                                       name="PAY_SYSTEM_ID" value="<?= $arPaySystem["ID"] ?>"
                                                       type="radio"
                                                       checked/>
                                                <label class="b-label-radio"
                                                       for="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>"><?= $arPaySystem["NAME"]; ?></label>
                                                <? $flag = false; ?>
                                            <? } else { ?>
                                                <input class="radio" id="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>"
                                                       name="PAY_SYSTEM_ID" value="<?= $arPaySystem["ID"] ?>"
                                                       type="radio"/>
                                                <label class="b-label-radio"
                                                       for="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>"><?= $arPaySystem["NAME"]; ?></label>
                                            <? } ?>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                        <div class="b-comments-wrap">
                            <label for="">Комментарий и промо-код</label>

                            <div class="b-order-comments">
                                <textarea name="COMMENT" rows="7" cols="35"
                                          class="cart_form_textarea"></textarea>
                            </div>
                        </div>
                        <div class="b-total-page">
                            <div class="b-content-center">
                                <div class="b-flag-bg">
                                    <div class="b-price-foter">
                                        <span class="b-price-foter__label js_footer_label">Самовывоз </span>
                                        <span class="b-price-foter__desc js_price_footer">Итого </span>

                                        <div class="b-price-foter__price js_total_price">
                                            <? $totalPrice = preg_replace('|(\D)|', '', $arResult['ORDER_PRICE_FORMATED']); ?>
                                            <?= $totalPrice > 10000 ? number_format($totalPrice, 0, '', ' ') : $totalPrice ?>
                                            <span
                                                class="rub">i</span>
                                        </div>
                                    </div>
                                    <div class="button-group">
                                        <a href="/personal/cart/">
                                            <button class="b-bnt-form b-bnt-buy-one-click wo_border"
                                                    value="" type="button"></button>
                                        </a>
                                        <input class="hidden_total_price" type="hidden"
                                               value="<?= preg_replace('|(\D)|', '', $arResult['ORDER_PRICE_FORMATED']) ?>"
                                               name="total_price">
                                        <input type="hidden" class="hidden_delivery_type" value="" name="delivery_type">
                                        <input type="hidden" class="hidden_del_addr" val="" name="pickup_adr">
                                        <button type="submit" class="b-bnt-form b-bnt-modal-cupcake--white js-ck-buy-btn">Купить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    <? }
} else { ?>
    <form action="/include/cart_sd_step.php" method="POST" name="ORDER_FORM" id="ORDER_FORM"
          enctype="multipart/form-data">
        <!--form-account-->
        <!--<section class="b-topblock b-min-height-213 b-topblock-mobhide">
        </section>-->


        <section class="b-bg-grey b-bg-grey--order">
            <div class="b-content-center b-block-order">
                <div class="b-block-new--title b-block-order--title "> ваш заказ</div>
                <div class="b-block-order--wrap  b-title--border-top">
                    <div class="b-block-order--content-wrap">
                        <div class="b-block-basket__link-nav">
                            <a class="b-block-basket-link-nav__item" href="/personal/cart/">
                                <span> Корзина</span> </a>
                            <a class="b-block-basket-link-nav__item active" href="/personal/order/make/">
                                <span> оформление</span> </a>
                        </div>

                        <div class="personal-information">
                            <div class="b-information--title"> персональные данные</div>
                            <? if (!$USER->IsAuthorized()): ?>
                                <span class="js_cart_login">я уже зарегистрирован </span>
                            <? endif; ?>
                        </div>


                        <!--form-account-->
                        <div class="b-account-form b-form-order">
                            <div class="b-account-form--wrap">
                                <div id="order_form_content">
                                    <div class="b-account-form">
                                        <div class="b-account-form--line">
                                            <label for="">ваше имя</label>

                                            <div class="b-account-form--input">
                                                <input type="text" name="NAME" value="<?= $arUser["NAME"] ?>"
                                                       class="required"/>
                                            </div>
                                        </div>
                                        <div class="b-account-form--line">
                                            <label for="">Адрес эл. почты</label>

                                            <div class="b-account-form--input">
                                                <input type="email" name="EMAIL" value="<?= $arUser["EMAIL"] ?>"
                                                       class="email required"/>
                                            </div>
                                        </div>
                                        <div class="b-account-form--line">
                                            <label for="">телефон</label>

                                            <div class="b-account-form--input">
                                                <input type="text" name="PERSONAL_PHONE"
                                                       value="<?= $arUser["PERSONAL_PHONE"] ?>"
                                                       class="js-phone-mask required" placeholder="+7(926)123-45-67"/>
                                            </div>
                                        </div>
                                        <!--<div class="b-account-form--line">
                                            <label for="">Комментарий</label>
                                            <div class="b-account-form--input">
                                                <textarea name="COMMENT" rows="10" cols="35"
                                                          placeholder="Здесь можно оставить комментарий по Вашему заказу, в том числе сделать данный заказ подарком для кого-либо."
                                                          class="cart_form_textarea"></textarea>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="b-method-shipping b-title--border-top">
                                <div class="b-method-shipping__line">
                                    <div class="b-information--title"> Способ и адрес доставки</div>

                                    <!--<div class="b-method-shipping_item">
                                        <div class="b-method-shipping-input js_radio_input">
                                            <input class="radio" type="radio" id="gift" name="address" data-paysys="gift"/>
                                            <label class="b-label-radio" for="gift">Сделать подарок</label>
                                        </div>
                                    </div>
                                    <div class="b-method-shipping_item">
                                        <span class="b-method-shipping-text"> Мы сделаем подарок от вашего имени для человека, адрес или телефон которого вы нам сообщите</span>
                                    </div>
                                    <div class="b-method-shipping_item">
                                        <a href="#" class="b-bnt-form b-bnt-form--green">сообщить</a>
                                    </div>-->
                                </div>

                                <div class="b-method-shipping__line">
                                    <div class="b-method-shipping--title js-del-btn">
                                        Самовывоз - бесплатно
                                    </div>
                                    <div class="js-del-slide-wrap">
                                        <?/* $APPLICATION->IncludeFile('/include/pickup_inc.php', array(),
                                            array(
                                                'MODE' => 'html',
                                                'TEMPLATE' => 'page_inc.php',
                                            )
                                        ); */?>
                                        <div class="b-method-shipping_item">
                                            <? $APPLICATION->IncludeComponent(
                                                "bitrix:news.list",
                                                "cupcake_pickup_adr",
                                                Array(
                                                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                                    "ADD_SECTIONS_CHAIN" => "N",
                                                    "AJAX_MODE" => "N",
                                                    "AJAX_OPTION_ADDITIONAL" => "",
                                                    "AJAX_OPTION_HISTORY" => "N",
                                                    "AJAX_OPTION_JUMP" => "N",
                                                    "AJAX_OPTION_STYLE" => "Y",
                                                    "CACHE_FILTER" => "N",
                                                    "CACHE_GROUPS" => "Y",
                                                    "CACHE_TIME" => "3600",
                                                    "CACHE_TYPE" => "A",
                                                    "CHECK_DATES" => "Y",
                                                    "COMPONENT_TEMPLATE" => "cupcake_pickup_adr",
                                                    "DETAIL_URL" => "",
                                                    "DISPLAY_BOTTOM_PAGER" => "N",
                                                    "DISPLAY_DATE" => "N",
                                                    "DISPLAY_NAME" => "N",
                                                    "DISPLAY_PICTURE" => "N",
                                                    "DISPLAY_PREVIEW_TEXT" => "N",
                                                    "DISPLAY_TOP_PAGER" => "N",
                                                    "FIELD_CODE" => array(0 => "", 1 => "",),
                                                    "FILTER_NAME" => "",
                                                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                                    "IBLOCK_ID" => "27",
                                                    "IBLOCK_TYPE" => "pickupadr",
                                                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                                    "INCLUDE_SUBSECTIONS" => "N",
                                                    "MESSAGE_404" => "",
                                                    "NEWS_COUNT" => "20",
                                                    "PAGER_BASE_LINK_ENABLE" => "N",
                                                    "PAGER_DESC_NUMBERING" => "N",
                                                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                                    "PAGER_SHOW_ALL" => "N",
                                                    "PAGER_SHOW_ALWAYS" => "N",
                                                    "PAGER_TEMPLATE" => ".default",
                                                    "PAGER_TITLE" => "Новости",
                                                    "PARENT_SECTION" => "",
                                                    "PARENT_SECTION_CODE" => "",
                                                    "PREVIEW_TRUNCATE_LEN" => "",
                                                    "PROPERTY_CODE" => array(0 => "PICKUP_ADR", 1 => "",),
                                                    "SET_BROWSER_TITLE" => "N",
                                                    "SET_LAST_MODIFIED" => "N",
                                                    "SET_META_DESCRIPTION" => "N",
                                                    "SET_META_KEYWORDS" => "N",
                                                    "SET_STATUS_404" => "N",
                                                    "SET_TITLE" => "N",
                                                    "SHOW_404" => "N",
                                                    "SORT_BY1" => "ACTIVE_FROM",
                                                    "SORT_BY2" => "SORT",
                                                    "SORT_ORDER1" => "DESC",
                                                    "SORT_ORDER2" => "ASC"
                                                )
                                            ); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="b-method-shipping__line b-method-shipping__line--last">
                                    <div class="b-method-shipping--title js-del-btn">
                                        <span>Доставка — от 400 руб.</span>
                                    </div>
                                    <div class="js-del-slide-wrap">
                                        <? $APPLICATION->IncludeFile('/include/del_inc.php', array(),
                                            array(
                                                'MODE' => 'html',
                                                'TEMPLATE' => 'page_inc.php',
                                            )
                                        ); ?>

                                        <div class="b-method-shipping_item b-method-shipping_item-full">
                                            <? $checked = true; ?>
                                            <? foreach ($arUser['UF_ADRESSES'] as $key => $adress):
                                                $text = explode('|', $adress);
                                                ?>
                                                <div class="b-method-shipping-input js_radio_input">
                                                    <? if (empty($adress)) { ?>
                                                        <script>
                                                            $('.hidden_addr').show().focus();
                                                        </script>
                                                    <? } else { ?>
                                                    <input class="radio" name="address" type="radio"
                                                           id="delivery<?= $key ?>"
                                                           data-deltype="<?= $arResult['DELIVERY_TYPES_ARR'][$text[1]][$text[1]] ?>"
                                                           data-id="<?= $text[1]; ?>"
                                                           data-price="<?= $arResult['DELIVERY_PRICE_ARR'][$text[1]][$text[1]] ?>"
                                                           data-addr="<?= $text[0] ?>"
                                                        <?= $checked ? 'checked' : '' ?>/>
                                                        <label class="b-label-radio"
                                                               for="delivery<?= $key ?>"><?= $text[0] ?></label>
                                                    <input type="hidden"
                                                           value="<?= $arResult['DELIVERY_PRICE_ARR'][$text[1]][$text[1]] ?>"
                                                           name="delivery_price">
                                                    <input type="hidden" name="delivery_adress" value="<?= $text[0] ?>">
                                                        <? $checked = false; ?>
                                                    <? } ?>
                                                </div>
                                            <? endforeach; ?>
                                        </div>


                                        <div class="b-application-event__form--line">
                                            <div class="b-application-event__form-item b-form-item-shipping-address">
                                                <label for=""> новый адрес</label>

                                                <div style="position: relative; margin:0;"
                                                     class="b-method-shipping-input js_radio_input">
                                                    <input id="delivery_new" class="radio" name="address" type="radio"
                                                        <?= $checked ? 'checked' : '' ?>
                                                           style="position:absolute; left:0; top:5px;"/>
                                                    <label class="b-label-radio"
                                                           for="delivery_new"
                                                           style="position:absolute; left:0; top:8px;"></label>

                                                    <div class="b-form-item__input" style="margin-left:45px;">

                                                        <input class="hidden_addr" type="text"
                                                               name="hidden_delivery_adress"
                                                               value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="b-application-event__form-item b-form-item--select">
                                                <label for=""> зона доставки</label>

                                                <div class="b-form-item__input b-form-item__input--select">
                                                    <p class="select_title">По Москве</p>
                                                    <select class="shipping_region">
                                                        <? foreach ($arResult['DELIVERY'] as $key => $region): ?>
                                                            <? if ($region['NAME'] != 'Самовывоз'): ?>
                                                                <option value="<?= $region['NAME'] ?>"
                                                                        data-deltype="<?= $key ?>"
                                                                        data-price="<?= $arResult['DELIVERY_PRICE_ARR'][$region['NAME']][$region['NAME']] ?>"><?= $region['NAME'] ?></option>
                                                            <? endif; ?>
                                                        <? endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="b-method-shipping_item b-method-shipping_item-date">
                                        <div
                                            class="b-application-event__form-item b-application-event__form-item--date i-margin-0">
                                            <label for="date"> дата доставки</label>

                                            <div class="b-form-item__input b-item--date-input">
                                                <input type='text' name='date' readonly='readonly'
                                                       onclick='showcalendar(this)'/>
                                                <span class="b-calendar"> i</span>
                                            </div>
                                        </div>
                                        <div
                                            class="b-application-event__form-item b-application-event__form-item--time">
                                            <label for=""> время доставки</label>

                                            <div class="b-application-event__time">
                                                <div class="b-form-item__input">
                                                    <input type="text" placeholder=":" name="timefrom"
                                                           class="js-mask-timefrom">
                                                </div>
                                                <span></span>

                                                <div class="b-form-item__input">
                                                    <input type="text" placeholder=":" name="timeto"
                                                           class="js-mask-timeto">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="b-payment-method  b-title--border-top">
                        <div class="b-method-shipping__line">
                            <div class="b-information--title">Способ оплаты</div>
                            <? $flag = true; ?>
                            <? foreach ($arResult["PAYSYSTEM_UNAUTHED"] as $arPaySystem) { ?>
                                <div
                                    class="b-method-shipping_item b-method-shipping_item--payment js_paysystem_type<?= $arPaySystem["ID"] ?>">
                                    <div class="b-method-shipping-input">
                                        <? if ($flag) { ?>
                                            <input class="radio" id="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>"
                                                   name="PAY_SYSTEM_ID" value="<?= $arPaySystem["ID"] ?>" type="radio"
                                                   checked/>
                                            <label class="b-label-radio"
                                                   for="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>"><?= $arPaySystem["NAME"]; ?></label>
                                            <? $flag = false; ?>
                                        <? } else { ?>
                                            <input class="radio" id="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>"
                                                   name="PAY_SYSTEM_ID" value="<?= $arPaySystem["ID"] ?>" type="radio"/>
                                            <label class="b-label-radio"
                                                   for="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>"><?= $arPaySystem["NAME"]; ?></label>
                                        <? } ?>
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                    <div class="b-comments-wrap">
                        <label for="">Комментарий и промо-код</label>

                        <div class="b-order-comments">
                                <textarea name="COMMENT" rows="7" cols="35"
                                          class="cart_form_textarea"></textarea>
                        </div>
                    </div>
                    <div class="b-total-page">
                        <div class="b-content-center">
                            <div class="b-flag-bg">
                                <div class="b-price-foter">
                                    <span class="b-price-foter__label js_footer_label">Самовывоз </span>
                                    <span class="b-price-foter__desc js_price_footer">Итого </span>

                                    <div class="b-price-foter__price js_total_price">
                                        <? $totalPrice = preg_replace('|(\D)|', '', $arResult['ORDER_PRICE_FORMATED']); ?>
                                        <?= $totalPrice > 10000 ? number_format($totalPrice, 0, '', ' ') : $totalPrice ?>
                                        <span
                                            class="rub">i</span>
                                    </div>
                                </div>
                                <div class="button-group">
                                    <a href="/personal/cart/">
                                        <button class="b-bnt-form b-bnt-buy-one-click wo_border"
                                                value="" type="button"></button>
                                    </a>
                                    <input class="hidden_total_price" type="hidden"
                                           value="<?= preg_replace('|(\D)|', '', $arResult['ORDER_PRICE_FORMATED']) ?>"
                                           name="total_price">
                                    <input type="hidden" class="hidden_delivery_type" value="" name="delivery_type">
                                    <input type="hidden" class="hidden_del_addr" val="" name="pickup_adr">
                                    <button type="submit" class="b-bnt-form b-bnt-modal-cupcake--white js-ck-buy-btn">Купить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
<? } ?>

<?
if(COption::GetOptionString("grain.customsettings","SUN_DELIVERY") == '') { ?>
    <script>
        var deliverySun = 0;
    </script>
<? } else { ?>
    <script>
        var deliverySun = 1;
    </script>
<? } ?>
<script>
    $(document).ready(function() {
        var products = [];
    <? foreach($arResult['BASKET_ITEMS'] as $key => $arItem) {?>
        <? if($arItem['NAME'] == 'Базовая коробка') continue; ?>
            products.push({'name':'<?=$arItem['NAME']?>', 'id':'<?=$arItem['ID']?>','price':'<?=$arItem['PRICE']?>','quantity': 1});
    <? } ?>
        var payType = ($('input[name="PAY_SYSTEM_ID"]:checked').val() == 1) ? 'cash' : 'card';

        $('.js-ck-buy-btn').click(function() {
            dataLayer.push({
                'event': 'checkout',
                'ecommerce': {
                    'checkout': {
                        'actionField': {'step': 2, 'option': payType},
                        'products': products
                    }
                },
            });
        });
    });
</script>
