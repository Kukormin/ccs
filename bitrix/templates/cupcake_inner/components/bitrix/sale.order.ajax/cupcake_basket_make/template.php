<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

$deliveryPriceDefault = 450;
$price = round($arResult['ORDER_PRICE']);
?>
<script>
	$(document).ready(function () {
		function deliveryPrice() {
			return <?= $deliveryPriceDefault ?>;
		}

		var price = <?=$price?>;
		var total_price = 0;
		var delivery_id = 14;
		var free_delivery_id = 16;
		var deliveryType = 0;
		var new_address = $('#new_address');

		$('.js_radio_input input').change(function () {
			var isNewDelivery = false;
			var delPrice = 0;
			if ($('.js_radio_input input:checked').data('price') == 0) {
				deliveryType = parseInt($('.js_radio_input input:checked').data('deltype'));
				$('.js_footer_label').html('Самовывоз');
				$('.js_price_footer').html('Итого');
				$('#address_hidden').val($('.js_radio_input input:checked').data('addr'));
				$('.del_title').text('самовывоза');
			} else if ($('.js_radio_input input:checked').prop('id') == 'delivery_new') {
				if (FREE_DELIVERY_SELECTED) {
					deliveryType = free_delivery_id;
					$('.js_footer_label').html('Бесплатная доставка');
				}
				else {
					delPrice = deliveryPrice();
					deliveryType = delivery_id;
					$('.js_footer_label').html('Доставка ' + delPrice + ' <span class="rub">i</span>');
				}
				$('.js_price_footer').html('Итого с доставкой');
				$('#address_hidden').val('');
				isNewDelivery = true;
				$('.del_title').text('доставки');
			} else {
				if (FREE_DELIVERY_SELECTED) {
					deliveryType = free_delivery_id;
					$('.js_footer_label').html('Бесплатная доставка');
				}
				else {
					delPrice = deliveryPrice();
					deliveryType = delivery_id;
					$('.js_footer_label').html('Доставка ' + delPrice + ' <span class="rub">i</span>');
				}
				$('.js_price_footer').html('Итого с доставкой');
				$('#address_hidden').val($('.js_radio_input input:checked').siblings('label').text());
				$('.del_title').text('доставки');
			}
			total_price = price + delPrice;
			$('.js_total_price').html((total_price > 10000 ? format_number(total_price) : total_price) + ' <span class="rub">i</span>');
			$('.hidden_total_price').html(total_price + ' <span class="rub">i</span>');
			$('.hidden_delivery_type').val(deliveryType);
			if (isNewDelivery) {
				new_address.addClass('required');
			}
			else
			{
				new_address.removeClass('required');
				new_address.removeClass('error');
				new_address.siblings('label').remove();
			}
		});

		$('#new_address').focus(function() {
			$(this).parent().siblings('input').prop('checked', 'checked');
			$('.js_radio_input input').change();
		});
		
		// !!! Костыль для отключения доставок
		if (!$('.b-method-shipping__line--last .js_radio_input input').length) {
			$('.js_radio_input:first input').prop('checked', 'checked');
			$('.js_radio_input input').change();
		}

		$('#ORDER_FORM').validate({
			rules: {
				ORDER_PROP_1: {
					required: true,
					minlength: 3
				},
				ORDER_PROP_3: {
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
				ORDER_PROP_1: {
					required: 'Обязательное поле',
					minlength: 'Не менее 3 символов'
				},
				ORDER_PROP_2: {
					email: 'Введите верную почту'
				},
				ORDER_PROP_3: 'Обязательное поле',
				date: 'Обязательно',
				timefrom: 'Обязательно',
				timeto: 'Обязательно',
				new_address: 'Обязательное поле'
			},
			submitHandler: function(form) {
				var date = $('input[name="date"]').val();
				var ti = $('#time_interval').val();
				var comment = $('textarea[name="COMMENT"]').val();
				var coupon = $('input[name="COUPON_CODE"]').val();
				if (coupon)
					coupon = '. Промо-код: ' + coupon;
				var OD = "Дата и время доставки: " + date + ' ' +
					intervals[ti] + coupon + ". Комментарий: " + comment;
				$('input[name=ORDER_DESCRIPTION]').val(OD);
				var hiddenAddr = $('#address_hidden').val();
				if (!hiddenAddr)
					$('#address_hidden').val($('#new_address').val());
				var data = $('#ORDER_FORM').serialize();
				$('#overlay').show();
				$.ajax({
					type: 'POST',
					url: '/personal/order/make/',
					data: data,
					success: function (res) {
						if (res.order.REDIRECT_URL) {
							location.href = res.order.REDIRECT_URL;
						}
						else
							$('#overlay').hide();
					},
					error: function() {
						$('#overlay').hide();
					},
					complete: function (res) {
					}
				});
				return false;
			}
		});

		var intervals = [
			'с 10:00 по 13:00',
			'с 13:00 по 16:00',
			'с 16:00 по 20:00'
		];

		$('.js_radio_input input').change();
	})
</script><?

$arUser = array();
$user_id = $USER->GetID();
if (isset($user_id) && $user_id != '')
{
	$rsUser = $USER->GetByID($user_id);
	$rows_q = $rsUser->SelectedRowsCount();
	if ($rows_q > 0)
		$arUser = $rsUser->Fetch();

	$rsUserProps = CSaleOrderUserProps::getList(
		array("DATE_UPDATE" => "DESC"),
		array("USER_ID" => $user_id)
	);

	$arUserData = array(
		'NAME' => '',
		'EMAIL' => '',
		'PHONE' => '',
	    'ADDRESS' => array(),
	);

	while ($arUserProps = $rsUserProps->Fetch())
	{
		$vals = array();
		$db_propVals = CSaleOrderUserPropsValue::GetList(
			array("ID" => "ASC"),
			array("USER_PROPS_ID" => $arUserProps['ID'])
		);
		while ($arPropVals = $db_propVals->Fetch())
		{
			$vals[$arPropVals['ORDER_PROPS_ID']] = $arPropVals['VALUE'];
		}
		if (!$arUserData['NAME'] && $vals[1])
			$arUserData['NAME'] = $vals[1];
		if (!$arUserData['EMAIL'] && $vals[2])
			$arUserData['EMAIL'] = $vals[2];
		if (!$arUserData['PHONE'] && $vals[3])
			$arUserData['PHONE'] = $vals[3];
		$adr = trim($vals[7]);
		if ($adr)
		{
			//!!! Костыли для самовывоза
			// по-хорошему не нужно сохранять в профиль адрес при самовывозе
			if ($adr != 'МЕГА Химки, главный вход' && $adr != 'Москва, ул. Самокатная, 4с9')
				$arUserData['ADDRESS'][$adr] = $adr;
		}
	}

	if (!$arUserData['NAME'] && $arUser['NAME'])
		$arUserData['NAME'] = $arUser['NAME'];
	if (!$arUserData['EMAIL'] && $arUser['EMAIL'])
		$arUserData['EMAIL'] = $arUser['EMAIL'];
	if (!$arUserData['PHONE'] && $arUser['PERSONAL_PHONE'])
		$arUserData['PHONE'] = $arUser['PERSONAL_PHONE'];
}

?>
<form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM"
      enctype="multipart/form-data">
<?=bitrix_sessid_post()?>
<input type="hidden" name="action" value="saveOrderAjax">
<input type="hidden" name="ORDER_DESCRIPTION" value="">
<input id="address_hidden" type="hidden" name="ORDER_PROP_7" value="">
<input type="hidden" name="PERSON_TYPE" value="1">
<input type="hidden" name="PERSON_TYPE_OLD" value="1"><?

$couponCode = '';
if (!empty($arResult['JS_DATA']['COUPON_LIST']))
{
	foreach ($arResult['JS_DATA']['COUPON_LIST'] as $oneCoupon)
	{
		if ($oneCoupon['JS_STATUS'] == 'APPLIED')
		{
			$couponCode = $oneCoupon['COUPON'];
			break;
		}
	}
}

?>
<input type="hidden" name="COUPON_CODE" value="<?= $couponCode ?>">
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

<div class="b-account-form b-form-order">
<div class="b-account-form--wrap">
	<div id="order_form_content">
		<div class="b-account-form">
			<div class="b-account-form--line">
				<label for="">ваше имя</label>

				<div class="b-account-form--input">
					<input type="text" name="ORDER_PROP_1" value="<?= $arUserData["NAME"] ?>"
					       class="required"/>
				</div>
			</div>
			<div class="b-account-form--line">
				<label for="">Адрес эл. почты</label>

				<div class="b-account-form--input">
					<input type="email" name="ORDER_PROP_2" value="<?= $arUserData["EMAIL"] ?>"
					       class="email"/>
				</div>
			</div>
			<div class="b-account-form--line">
				<label for="">телефон</label>

				<div class="b-account-form--input">
					<input type="text" name="ORDER_PROP_3"
					       value="<?= str_replace('+7', '', $arUserData["PHONE"]) ?>"
					       class="js-phone-mask required" placeholder="+7(926)123-45-67"/>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="b-method-shipping b-title--border-top">
	<div class="b-method-shipping__line">
		<div class="b-information--title"> Способ и адрес доставки</div>
	</div>

	<div class="b-method-shipping__line">
		<div class="b-method-shipping--title js-del-btn">
			Самовывоз - бесплатно
		</div>
		<div class="js-del-slide-wrap">
			<div class="b-method-shipping_item"><?
				$APPLICATION->IncludeComponent("bitrix:news.list", "cupcake_pickup_adr", Array(
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
						"FIELD_CODE" => array(
							0 => "",
							1 => "",
						),
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
						"PROPERTY_CODE" => array(
							0 => "PICKUP_ADR",
							1 => "",
						),
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
					));
				?>
			</div>
		</div>
	</div><?

	// !!! Костыль для отключения доставок
	if ($arResult['ORDER_PRICE'] >= 2000)
	{
		?>
		<div class="b-method-shipping__line b-method-shipping__line--last">
		<div class="b-method-shipping--title js-del-btn">
			<span>Доставка — от <?= $deliveryPriceDefault ?> руб.</span>
		</div>
		<div class="js-del-slide-wrap"><?
			$APPLICATION->IncludeFile('/include/del_inc.php', array(), array(
				'MODE' => 'html',
				'TEMPLATE' => 'page_inc.php',
			));

			$new = '';
			$checked = ' checked';
			if ($arUserData['ADDRESS'])
			{
				?>
				<div class="addresses">
				<label>Ваши адреса</label><?
				$index = 0;
				foreach ($arUserData['ADDRESS'] as $address)
				{
					$index++;
					?>
					<div class="b-method-shipping-input js_radio_input">
					<input class="radio" name="address" type="radio" id="delivery<?= $index ?>"<?= $checked ?> />
					<label class="b-label-radio" for="delivery<?= $index ?>"><?= $address ?></label>
					</div><?
					$checked = '';
					$new = 'Новый ';
				}

				?>
				</div><?
			}

			?>
			<div class="b-application-event__form-item b-form-item-shipping-address">
				<label for="delivery_new"><?= $new ?>адрес</label>

				<div style="position: relative; margin:0;"
				     class="b-method-shipping-input js_radio_input">
					<input id="delivery_new" class="radio" name="address" type="radio"<?= $checked ?> />
					<label class="b-label-radio" for="delivery_new" style="top:8px;"></label>

					<div class="b-form-item__input" style="margin-left:32px;">
						<input id="new_address" type="text" name="new_address" value="">
					</div>
				</div>
			</div><?

			/*
			 Убрал зоны доставки, пока оставим здесь, если захотят вернуть
			?>
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
			</div><?
			*/

			?>
		</div>
		</div><?
	}
	else
	{
		?>
		<div class="b-method-shipping__line b-method-shipping__line--last">
			<div class="b-method-shipping--title js-del-btn">
				<span>Доставка осуществляется при заказе от 2000 <span class="rub">i</span></span>
			</div>
		</div><?
	}
	?>
</div>
<div class="b-method-shipping b-title--border-top">
	<div class="b-method-shipping__line">
		<div class="b-information--title">Дата и время <span class="del_title">доставки</span></div>
	</div>
	<div class="b-method-shipping_item b-method-shipping_item-date">
		<div
			class="b-application-event__form-item b-application-event__form-item--date i-margin-0">
			<label for="date"> дата <span class="del_title">доставки</span></label>

			<div class="b-form-item__input b-item--date-input">
				<input type='text' name='date' readonly='readonly'
				       onclick='showcalendar(this)'/>
				<span class="b-calendar"> i</span>
			</div>
		</div>
		<div
			class="b-application-event__form-item b-application-event__form-item--time">
			<label for="time_interval"> время <span class="del_title">доставки</span></label><?

			$intervals = array(
				'10:00 — 13:00',
				'13:00 — 16:00',
				'16:00 — 20:00',
			);
			?>
			<div class="b-form-item__input b-form-item__input--select">
				<p class="select_title"><?= $intervals[0] ?></p>
				<select id="time_interval" name="time_interval" class="b-form-item__input"><?
					foreach ($intervals as $index => $interval)
					{
						?>
						<option value="<?= $index ?>"><?= $interval ?></option><?
					}
					?>
				</select>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<div class="b-payment-method  b-title--border-top">
	<div class="b-method-shipping__line">
		<div class="b-information--title">Способ оплаты</div><?
		$checked = ' checked';
		foreach ($arResult["PAYSYSTEM_UNAUTHED"] as $arPaySystem)
		{
			?>
			<div
				class="b-method-shipping_item b-method-shipping_item--payment js_paysystem_type<?= $arPaySystem["ID"] ?>">
				<div class="b-method-shipping-input">
					<input class="radio" id="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>"
					       name="PAY_SYSTEM_ID" value="<?= $arPaySystem["ID"] ?>" type="radio"<?= $checked ?>/>
					<label class="b-label-radio"
					       for="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>"><?= $arPaySystem["NAME"] ?></label>
				</div>
			</div><?

			$checked = '';
		}
		?>
	</div>
</div>
<div class="b-comments-wrap">
	<label for="">Комментарий</label>

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
					<? $totalPrice = round($arResult['ORDER_PRICE']) ?>
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
				<input type="hidden" class="hidden_delivery_type" value="14" name="DELIVERY_ID">
				<button type="submit" class="b-bnt-form b-bnt-modal-cupcake--white js-ck-buy-btn">Купить
				</button>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</section>
</form><?

$sunday = COption::GetOptionString("grain.customsettings", "SUNDAY") == 'Y';
$dtime = COption::GetOptionString("grain.customsettings", "DHOUR"); // Время в формате 15:30
$tmp = explode(':', $dtime);
$dhour = intval($tmp[0]);
$dminutes = intval($tmp[1]);
if (!$dhour)
	$dhour = 16;
$holidayText = COption::GetOptionString("grain.customsettings", "HOLIDAY");
$holidaysJs = '';
$s = strtok($holidayText, ", \r\n\t");
while ($s !== false)
{
	if (strlen($s) > 0)
	{
		if ($holidaysJs)
			$holidaysJs .= ',';
		$tmp = explode('.', $s);
		$holidaysJs .= "'" . intval($tmp[0]) . "." . intval($tmp[1]) . "." . intval($tmp[2]) . "'";
	}
	$s = strtok(", \r\n\t");
}

$freeDeliveryText = COption::GetOptionString("grain.customsettings", "FREE_DELIVERY");
$freeDeliveryJs = '';
$s = strtok($freeDeliveryText, ", \r\n\t");
while ($s !== false)
{
	if (strlen($s) > 0)
	{
		if ($freeDeliveryJs)
			$freeDeliveryJs .= ',';
		$tmp = explode('.', $s);
		$freeDeliveryJs .= "'" . intval($tmp[0]) . "." . intval($tmp[1]) . "." . intval($tmp[2]) . "'";
	}
	$s = strtok(", \r\n\t");
}

?>
<script>var sunday_holidays = <?= $sunday ? 1 : 0 ?>;
	var holidays = [<?= $holidaysJs ?>];
	var dhour = <?= ($dhour-3) ?>;var dminutes = <?= $dminutes ?>;
	var free_delivery = [<?= $freeDeliveryJs ?>];</script>

<script>
	$(document).ready(function () {
		var products = [];
		<? foreach($arResult['BASKET_ITEMS'] as $key => $arItem) {?>
		<? if($arItem['NAME'] == 'Базовая коробка') continue; ?>
		products.push({
			'name': '<?=$arItem['NAME']?>',
			'id': '<?=$arItem['ID']?>',
			'price': '<?=$arItem['PRICE']?>',
			'quantity': 1
		});
		<? } ?>
		var payType = ($('input[name="PAY_SYSTEM_ID"]:checked').val() == 1) ? 'cash' : 'card';

		$('.js-ck-buy-btn').click(function () {
			if (!!dataLayer)
				dataLayer.push({
					'event': 'checkout',
					'ecommerce': {
						'checkout': {
							'actionField': {'step': 2, 'option': payType},
							'products': products
						}
					}
				});
		});
	});
</script><?

$total = 0;
foreach($arResult['BASKET_ITEMS'] as $key => $arItem)
{
	//[PRODUCT_XML_ID] => 1358#1355
	$productId = $arItem['PRODUCT_XML_ID'];
	$total += $arItem['PRICE'] * $arItem['QUANTITY'];
	$tmp = explode('#', $productId);
	if (count($tmp) > 1)
		$productId = $tmp[0];
	\Local\Utils\Remarketing::addProductId($productId);
}
\Local\Utils\Remarketing::setPageType('purchase');
\Local\Utils\Remarketing::setTotal($total);