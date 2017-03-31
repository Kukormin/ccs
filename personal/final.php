<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("спасибо за покупку");
?><? $APPLICATION->SetPageProperty("title", "Спасибо за покупку");
$price = intval($_GET['price']);
$oid = intval($_GET['id']);
?>

    <section class="b-topblock b-topblock--order b-min-height-213">
    </section>


    <section class="b-bg-grey">
        <div class="b-content-center b-order">
            <div class="b-content-center--title"> спасибо за покупку!</div>
            <div class="b-order--description"> Ваш заказ на сумму <span
                    class="violet"><?= number_format($price, 0, '', ' ') ?><span class="rub">i</span></span> принят
                <span class="b-order--description--span">Мы перезвоним вам в ближайшее время </span>
                <span class="b-order--description--span">Вы можете уточнить любые детали вашего заказа по телефону <a class="violet" href="tel:+7 499 322 00 20">+7 499 322 00 20</a> </span>
            </div>


            <!--<div class="b-block-social">
                <div class="b-block-social-title">
                    поделиться ссылкой:
                </div>
                <ul class="b-social__list">
                    <li class="b-social__item"> <a class="b-vk" href="#"></a></li>
                    <li class="b-social__item"> <a class="b-f" href="#"></a></li>
                    <li class="b-social__item"> <a class="b-tw" href="#"></a></li>
                    <li class="b-social__item"> <a class="b-live" href="#"></a></li>
                    <li class="b-social__item"> <a class="b-g" href="#"></a></li>
                    <li class="b-social__item"> <a class="b-pl" href="#"></a></li>
                </ul>
            </div>-->
        </div>

        <div class="b-content-center b-slider-about-novelty">
            <div class="b-title b-title--border-middle">
                <div class="b-title__item b-title__item--grey">
						<span href="#" class="b-mod--about-novelty__item-img">
							У нас есть много вкусных сладостей
						</span>
                </div>
            </div>
            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "cupcake_section_slider_final",
                array(
                    "ACTION_VARIABLE" => "action",
                    "ADD_PICT_PROP" => "-",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "ADD_TO_BASKET_ACTION" => "ADD",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "BACKGROUND_IMAGE" => "-",
                    "BASKET_URL" => "/personal/cart",
                    "BROWSER_TITLE" => "-",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COMPONENT_TEMPLATE" => "cupcake_section_slider_final",
                    "CONVERT_CURRENCY" => "N",
                    "DETAIL_URL" => "",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "ELEMENT_SORT_FIELD" => "created",
                    "ELEMENT_SORT_FIELD2" => "",
                    "ELEMENT_SORT_ORDER" => "desc",
                    "ELEMENT_SORT_ORDER2" => "",
                    "FILTER_NAME" => "arrFilter",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "IBLOCK_ID" => "4",
                    "IBLOCK_TYPE" => "catalog",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "LABEL_PROP" => "-",
                    "LINE_ELEMENT_COUNT" => "3",
                    "MESSAGE_404" => "",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_DETAIL" => "Подробнее",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "META_DESCRIPTION" => "-",
                    "META_KEYWORDS" => "-",
                    "OFFERS_CART_PROPERTIES" => array(
                        0 => "ARTICLE",
                        1 => "NUMBER",
                        2 => "TAGS",
                        3 => "STAR_GIFT_PRICE",
                    ),
                    "OFFERS_FIELD_CODE" => array(
                        0 => "ID",
                        1 => "CODE",
                        2 => "XML_ID",
                        3 => "NAME",
                        4 => "TAGS",
                        5 => "SORT",
                        6 => "PREVIEW_TEXT",
                        7 => "PREVIEW_PICTURE",
                        8 => "DETAIL_TEXT",
                        9 => "DETAIL_PICTURE",
                        10 => "IBLOCK_TYPE_ID",
                        11 => "IBLOCK_ID",
                        12 => "IBLOCK_CODE",
                        13 => "IBLOCK_NAME",
                        14 => "IBLOCK_EXTERNAL_ID",
                        15 => "DATE_CREATE",
                        16 => "",
                    ),
                    "OFFERS_LIMIT" => "5",
                    "OFFERS_PROPERTY_CODE" => array(
                        0 => "ARTICLE",
                        1 => "NUMBER",
                        2 => "TAGS",
                        3 => "STAR_GIFT_PRICE",
                        4 => "FILLING",
                        5 => "",
                    ),
                    "OFFERS_SORT_FIELD" => "sort",
                    "OFFERS_SORT_FIELD2" => "id",
                    "OFFERS_SORT_ORDER" => "asc",
                    "OFFERS_SORT_ORDER2" => "desc",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "Товары",
                    "PAGE_ELEMENT_COUNT" => "15",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRICE_CODE" => array(
                        0 => "BASE",
                    ),
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRODUCT_DISPLAY_MODE" => "N",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_PROPERTIES" => array(
                        0 => "ACTION",
                        1 => "NEW",
                        2 => "STAR_GIFT",
                    ),
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "items_num",
                    "PRODUCT_SUBSCRIPTION" => "N",
                    "PROPERTY_CODE" => array(
                        0 => "ACTION",
                        1 => "NEW",
                        2 => "ACTION_TEXT",
                        3 => "STAR_GIFT",
                        4 => "",
                    ),
                    "SECTION_CODE" => "",
                    "SECTION_ID" => $_REQUEST["SECTION_ID"],
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "SECTION_URL" => "",
                    "SECTION_USER_FIELDS" => array(
                        0 => "UF_ACSESS_BOUND",
                        1 => "UF_DISPLAY_MAIN",
                        2 => "UF_DATE",
                        3 => "UF_PASSWORD",
                        4 => "",
                    ),
                    "SEF_MODE" => "N",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "Y",
                    "SHOW_404" => "N",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "SHOW_CLOSE_POPUP" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "TEMPLATE_THEME" => "blue",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "Y"
                ),
                false
            ); ?>
        </div>
    </section>
        <?
        CModule::IncludeModule('sale');
        CModule::IncludeModule("iblock");

        $deliveryPrice = '';
        $productName = '';
        $productPrice = '';
        $quantity = '';
        $categoryName = [];

        $arOrder = CSaleOrder::GetByID($oid);
        $db_dtype = CSaleDelivery::GetList(
        array(
        "SORT" => "ASC",
        ),
        array(
        "ACTIVE" => "Y",
        ),
        false,
        false,
        array('*')
        );

        while ($ar_dtype = $db_dtype->Fetch()) {
            if ($ar_dtype['ID'] == $arOrder['DELIVERY_ID']) {
                $deliveryPrice = $ar_dtype['PRICE'];
                break;
            }
        }
        ?>
        <script>
			DSPCounter('send', {
				'sid': '216208',
				'site_area': 'chGedGaY',
				'user_id': '',
				'lead_id': '',
				'order_sum': '<?=$price?>'
			});

			dataLayer.push({
                'ecommerce': {
                    'purchase': {
                        'actionField': {
                            'id': '<?=$oid?>',
                            'affiliation': 'cupcakestory.ru',
                            'revenue': '<?=$price?>',
                            'shipping': '<?=$deliveryPrice?>',
                            'tax': 0,
                            'currency': 'RUR'
                        },
                        'products': [
                            <?
                            $dbBasketItems = CSaleBasket::GetList(
                                array("NAME" => "ASC"),
                                array(
                                    "LID" => s1,
                                    "ORDER_ID" => $oid
                                ),
                                false,
                                false,
                                array("ID", "PRODUCT_ID", "PRICE", "WEIGHT", "NAME", "IBLOCK_NAME")
                            );?>

                            <?while ($arBasketItems = $dbBasketItems->GetNext()) {
                                $res = CIBlockElement::GetByID($arBasketItems['PRODUCT_ID']);
                                if($ar_res = $res->GetNext()) {
                                    $catPos = strpos($ar_res['IBLOCK_NAME'], '(');
                                    $categoryName = trim(substr($ar_res['IBLOCK_NAME'], 0, $catPos));
                                }
                                $pos = strpos($arBasketItems['NAME'], '(');
                                $productName = trim(substr($arBasketItems['NAME'], 0, $pos)) ? trim(substr($arBasketItems['NAME'], 0, $pos)) : $arBasketItems['NAME'];
                                ?>
                            {
                                'id': '<?=$arBasketItems['PRODUCT_ID']?>',
                                'name': '<?=$productName?>',
                                'category': '<?=$categoryName?>',
                                'price': '<?=$arBasketItems['PRICE']?>',
                                'quantity': '<?=preg_replace('/\D/', '', $arBasketItems['NAME']) ? preg_replace('/\D/', '', $arBasketItems['NAME']) : '1'?>',
                            },
                            <? } ?>
                        ]
                    }
                }
            });
        </script>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>