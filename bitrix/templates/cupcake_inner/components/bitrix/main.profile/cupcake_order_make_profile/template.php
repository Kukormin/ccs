<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
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


            <form class="profile_form" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
                <!--form-account-->
                <div class="b-account-form">
                    <div class="b-account-form--wrap b-account-form--wrap-shipping-address">
                       <div>
                            <?=$arResult["BX_SESSION_CHECK"]?>
                            <input type="hidden" name="lang" value="<?=LANG?>" />
                            <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
                           <div class="b-account-form--line">
                               <label for="">ваше имя</label>
                               <div class="b-account-form--input">
                                   <input type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" />
                               </div>
                           </div>
                           <div class="b-account-form--line">
                                <label for="">Адрес эл. почты</label>
                                <div class="b-account-form--input">
                                    <input type="email" name="EMAIL" value="<?=$arResult["arUser"]["EMAIL"]?>" />
                                </div>
                           </div>
                           <div class="b-account-form--line">
                               <label for="">телефон</label>
                               <div class="b-account-form--input">
                                   <input type="text" name="PERSONAL_PHONE" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
                               </div>
                           </div>

                           <ol class="b-block-account-address__list">
                               <?foreach($arResult['arUser']['UF_ADRESSES'] as $key => $adress):?>
                                   <?php
                                   $text = explode('|', $adress);
                                   ?>
                                   <li class="b-block-account-address__item js-address-block">
                                       <span class="b-block-account-address__item-area js-address-value"><?=$text[0]?></span>
                        <span class="b-block-account-address__item-area js-address-edit" style="display:none">
                            <input type="text" name="UF_ADRESSES[<?=$key?>]" data-id="<?=$text[1];?>" value="<?=$text[0]?>">
                        </span>
                                       <div class="b-block-account-address__group">
                                           <span class="b-account--change js-address-change"> Изменить  </span>
                                           <span class="b-account_address--delete js-address-delete">Удалить</span>
                                       </div>
                                   </li>
                               <?endforeach;?>
                           </ol>



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

                           <div class="b-method-shipping b-title--border-top">
                               <div class="b-method-shipping__line">
                                   <div class="b-information--title"> Способ и адрес доставки</div>

                                   <div class="b-method-shipping_item">
                                       <div class="b-method-shipping-input">
                                           <input class="radio" type="radio" id="" />
                                           <label class="b-label-radio" for="">Сделать подарок</label>
                                       </div>
                                   </div>
                                   <div class="b-method-shipping_item">
                                       <span class="b-method-shipping-text"> Мы сделаем подарок от вашего имени для человека, адрес или телефон которого вы нам сообщите</span>
                                   </div>
                                   <div class="b-method-shipping_item">
                                       <a href="#" class="b-bnt-form b-bnt-form--green">сообщить</a>
                                   </div>
                               </div>

                               <div class="b-method-shipping__line">
                                   <div class="b-method-shipping--title">
                                       Самовывоз
                                   </div>
                                   <div class="b-method-shipping_item">
                                       <?$APPLICATION->IncludeComponent(
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
                                               "CACHE_TIME" => "36000000",
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
                                               "FIELD_CODE" => array(0=>"",1=>"",),
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
                                               "PROPERTY_CODE" => array(0=>"PICKUP_ADR",1=>"",),
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
                                       );?>
                                   </div>
                               </div>

                               <div class="b-method-shipping__line b-method-shipping__line--last">
                                   <div class="b-method-shipping--title">
                                       Доставка по адресу
                                   </div>
                                   <div class="b-method-shipping_item b-method-shipping_item-full">
                                       <div class="b-method-shipping-input">
                                           <input class="radio" name="delivery" type="radio" id="delivery1" checked />
                                           <label class="b-label-radio" for="delivery1">123456, Московская область, Улица Академика Королева, 12 А, кв. 48</label>
                                       </div>

                                       <div class="b-method-shipping-input">
                                           <input class="radio" name="delivery" type="radio" id="delivery2" />
                                           <label class="b-label-radio" for="delivery2">123456, Москва, Улица Отрадная, 45, кв. 48</label>
                                       </div>
                                   </div>
                                   <div class="b-method-shipping_item b-method-shipping_new-address">
                                       <span class="b-block-adress--add"> новый адрес</span>
                                   </div>
                                   <div class="b-method-shipping_item b-method-shipping_item-date">
                                       <div class="b-application-event__form-item b-application-event__form-item--date i-margin-0">
                                           <label for="date"> дата торжества</label>
                                           <div class="b-form-item__input b-item--date-input">
                                               <input type='text' name='date' readonly='readonly' onclick='showcalendar(this)' />
                                               <span class="b-calendar"> i</span>
                                           </div>
                                       </div>
                                       <div class="b-application-event__form-item b-application-event__form-item--time">
                                           <label for=""> время доставки</label>
                                           <div class="b-application-event__time">
                                               <div class="b-form-item__input">
                                                   <input type="text" placeholder=":">
                                               </div>
                                               <span></span>
                                               <div class="b-form-item__input">
                                                   <input type="text" placeholder=":">
                                               </div>
                                           </div>
                                       </div>
                                   </div>

                               </div>


                           </div>

                           <div class="b-account-form--line">
                                <input class="b-bnt-form b-bnt-form--account" type="submit" name="save" value="<?=GetMessage("MAIN_SAVE")?>">
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
