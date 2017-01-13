<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/** @var array $arParams */
/** @var array $arResult */

use Bitrix\Sale\DiscountCouponsManager;

//debugmessage($arResult);

//инфоблоки, товары из которых не надо выводить стандартным методом
$hideItemsFrom = array(
	\Local\Sale\Postals::IBLOCK_ID,
	12, //коробки
	30, //коробки тортов
	37, //коробки для эклеров
);

?>
<script>
	var basket_settings = {
		'action_var': '<?= $arParams['ACTION_VARIABLE'] ?>',
		'sid': '<?= bitrix_sessid() ?>'
	};
</script>


<section class="b-bg-grey b-bg-grey--basket" style="margin-bottom: 0;">
<div class="b-content-center b-block-order">
<div class="b-block-new--title b-block-order--title"> ваш заказ</div>

<div class="b-block-basket-wrap b-title--border-top">
<div class="b-block-basket-content-wrap">
<div class="b-block-basket__link-nav">
	<a class="b-block-basket-link-nav__item active" href="/personal/cart/">
		<span> Корзина</span> </a>
	<a class="b-block-basket-link-nav__item" href="/personal/order/make/">
		<span> оформление</span> </a>
</div><?

$packageTotal = 0;
$postalId = 0;
$postalBid = 0;
$postalPrice = 0;
foreach ($arResult['GROUPED_GOODS'] as $parentName => $items)
{
	$arItem = $arResult["GRID"]["ROWS"][reset($items)];

	if ($arItem['IBLOCK_ID'] == \Local\Sale\Postals::IBLOCK_ID)
	{
		$postalId = $arItem['PRODUCT_ID'];
		$postalBid = $arItem['ID'];
		$postalPrice = $arItem['PRICE'];
	}

	if (in_array($arItem['IBLOCK_ID'], $hideItemsFrom))
		continue;

	?>
	<!--block basket__item-->
	<div class="b-basket__item"><?

		foreach ($items as $k)
		{
			$arItem2 = $arResult["GRID"]["ROWS"][$k];
			$product = \Local\Catalog\Products::getById($arItem2['PARENT_ITEM_ID']);

			?>
			<div class="b-basket__li-item js-basket-item-cont <?= round($pack['PRICE'],
				0) == 0 ? 'js-free-box' : '' ?> <?= $pack['NAME'] == 'VIP-коробка' ? 'js-vip-box' : ''; ?>"
			    id="line_<?= $arItem2['ID'] ?>" data-oiid="<?= $arItem2["ID"] ?>"
			    data-base-price="<?= $arItem2['PRICE'] ?>"><?

				//
				// Картинка и название
				//
				?>
				<div class="b-mod__item--basket">
					<div class="b-mod__item-img--effect-transform b-mod__item-basket--img">
						<img src="<?= $arItem2['PREVIEW_PICTURE_SRC'] ?>" alt="">
					</div>
					<div class="b-mod__item-title--basket">
						<?= $arItem2['PARENT_NAME'] ? $arItem2['PARENT_NAME'] : $arItem2['NAME']; ?>
					</div>
				</div><?
			/*
				?>
				<div class="b-basket__item--box"><?
					if (isset($arItem['PACKAGES']) && isset($arResult['PACKAGES'][$arItem['PACKAGES']]))
					{
						?>
						<span> коробка</span><?
					}
					?>
				</div><?*/

				?>
				<div class="b-basket--select">
					<div class="b-basket-select__item  b-basket-select__item--number">
						<div class="b-basket-select__item--input"><?
							if ($product['OFFERS'])
							{
								?>
								<label class="b-basket-select--label" for=""> в упаковке</label>
								<div class="b-form-item__input b-form-item__input--select">
									<p class="select_title"></p>
									<select class="js-basket-option"><?

										foreach ($product['OFFERS'] as $offer)
										{
											$selected = $arItem2['PRODUCT_ID'] == $offer['ID'] ? ' selected' : '';
											?>
											<option value="<?= $offer['ID'] ?>"<?= $selected ?>><?=
												$offer['COUNT'] ?></option><?
										}

										?>
									</select>
								</div><?
							}
							?>
						</div>
						<span><?= count($arItem2["SKU_DATA"]) ? 'шт' : '' ?></span>
					</div>
					<div class="b-basket-cnt">
						<span class="basket_cnt basket_cnt_minus"></span><?
						?><div class="b-basket-cnt--input b-form-item__input">
							<input
								type="text"
								size="2"
								id="QUANTITY_INPUT_<?=$arItem2["ID"]?>"
								name="QUANTITY_INPUT_<?=$arItem2["ID"]?>"
								maxlength="2"
								min="1"
								value="<?=$arItem2["QUANTITY"]?>" disabled />
						</div><?
						?><span class="basket_cnt basket_cnt_plus"></span>
					</div>


				</div><?

				$packages = \Local\Sale\Package::getByCategory($product['CATEGORY']['ID']);

				$packagePrice = 0;
				if ($packages)
				{
					$packageName = '';
					$packageId = 0;
					foreach ($arItem2["PROPS"] as $cProp)
					{
						if ($cProp['CODE'] == 'PACKAGE')
						{
							$packageName = $cProp['VALUE'];
							$packageId = $cProp['SORT'];
						}
					}

					?>
					<br />
					<div class="js-package-cont"><?
						foreach ($packages as $pack)
						{
							$vip = strpos($pack['NAME'], '9') !== false ? ' js-vip-box' : '';
							$free = round($pack['PRICE'], 0) == 0 ? ' js-free-box' : '';
							?>
							<div class="js-package-item b-slider__item-basket<?= $vip ?><?= $free ?>"
							     data-package-price="<?= intval($pack['PRICE']) ?>"
							     data-package-name="<?= $pack['NAME'] ?>"
							     data-package-id="<?= $pack['ID'] ?>">
								<div class="b-item-basket-img js-package-popup"
								     data-featherlight="<?= $pack['DETAIL_PICTURE'] ?>">
									<img src="<?= $pack['PREVIEW_PICTURE'] ?>" alt="">
								</div><?

								if (count($packages) > 1)
								{
									$checked = $pack['ID'] == $packageId ? ' checked' : '';
									?>
									<div class="b-mod__item-checkbox">
										<input type="checkbox" class="checkbox em-radio js-package-selector"
										       name="pack_<?= $arItem2['ID'] ?>"
										       id="p_<?= $pack['ID'] ?>"<?= $checked ?> />
										<label for="p_<?= $pack['ID'] ?>"></label>
									</div><?
								}

								$price = intval($pack['PRICE']);
								if ($pack['ID'] == $packageId)
									$packagePrice = $price;
								$fPrice = $price > 0 ? $price . ' <span class="rub">i</span>' : 'бесплатно';

								?>
								<div class="b-mod__item-title">
									<span class="b-slider__item-basket--name"><?= $pack['NAME'] ?></span>
								</div>
								<div class="b-mod__item-price b-mod__item-price--basket"><?= $fPrice ?></div>
							</div><?
						}
						?>
					</div><?
				}

				$packageSum = intval($packagePrice * $arItem2["QUANTITY"]);
				$packageTotal += $packageSum;
				$sum = round(($arItem2['PRICE'] + $packagePrice) * $arItem2["QUANTITY"]);

				\Local\Utils\Remarketing::addProductId($product['ID']);

				?>
				<div class="b-total-basket__group">
					<span class="b-total-basket--price" id="current_price_<?= $arItem2["ID"] ?>">
						<span class="js-item-total"><?= $sum ?></span>
						<input type="hidden" value="<?= $packageSum ?>">
						<span class="rub">i</span>
					</span>
					<div class="b-total-basket--delete js-basket-remove">
						<span> Удалить</span>
					</div>
				</div>

			</div><?

			unset($arResult["GRID"]["ROWS"][$k]);
		}
		?>
	</div><?
}

\Local\Utils\Remarketing::setPageType('cart');
\Local\Utils\Remarketing::setTotal($arResult['allSum']);

/*
?>
<div class="b-basket-gift">
	<span class="b-basket-gift--text">Мы сделаем подарок от вашего имени для человека, адрес или телефон которого вы нам сообщите</span>
	<button class="b-bnt-present b-bnt-form">сделать подарок</button>
</div><?
*/

?>
</div>


<div id="basket_items_list">
	<div class="bx_ordercart_order_table_container">
		<table id="basket_items">
		</table>
	</div>
	<input type="hidden" id="column_headers" value="<?= CUtil::JSEscape(implode($arHeaders, ",")) ?>"/>
	<input type="hidden" id="offers_props" value="<?= CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ",")) ?>"/>
	<input type="hidden" id="action_var" value="<?= CUtil::JSEscape($arParams["ACTION_VARIABLE"]) ?>"/>
	<input type="hidden" id="quantity_float" value="<?= $arParams["QUANTITY_FLOAT"] ?>"/>
	<input type="hidden" id="count_discount_4_all_quantity"
	       value="<?= ($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N" ?>"/>
	<input type="hidden" id="price_vat_show_value"
	       value="<?= ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N" ?>"/>
	<input type="hidden" id="hide_coupon" value="<?= ($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N" ?>"/>
	<input type="hidden" id="use_prepayment" value="<?= ($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N" ?>"/>
	<input type="hidden" id="auto_calculation" value="<?= ($arParams["AUTO_CALCULATION"] == "N") ? "N" : "Y" ?>"/>


	<style>
		.coupons_block_span {
			margin-bottom: 3px !important;
			font-family: 'PTSansCaption', sans-serif !important;
			letter-spacing: 1.3px !important;
			font-size: 10px !important;
			line-height: 25px !important;
			color: #7c7d70 !important;
			text-transform: uppercase !important;
			display: block !important;
		}
	</style>

	<div class="bx_ordercart_order_pay clearfix"><?

		/*$postals = \Local\Sale\Postals::getAll();
		if ($postals)
		{
			?>
			<div id="postals" data-bid="<?= $postalBid ?>" data-price="<?= $postalPrice ?>">
				<h3>Открытка к заказу:</h3><?
				foreach ($postals as $pst)
				{
					$checked = $pst['ID'] == $postalId ? ' checked' : '';
					$price = intval($pst['PRICE']);
					$fPrice = $price > 0 ? $price . ' <span class="rub">i</span>' : 'бесплатно';
					?>
					<div class="b-slider__item-basket"
					     data-price="<?= intval($pst['PRICE']) ?>"
					     data-id="<?= $pst['ID'] ?>">
						<div class="b-item-basket-img js-package-popup"
						     data-featherlight="<?= $pst['DETAIL_PICTURE'] ?>">
							<img src="<?= $pst['PREVIEW_PICTURE'] ?>" alt="">
						</div>
						<div class="b-mod__item-checkbox">
							<input type="checkbox" class="checkbox js-postals-selector"
							       name="postal" id="postal_<?= $pst['ID'] ?>"<?= $checked ?> />
							<label for="postal_<?= $pst['ID'] ?>"></label>
						</div>
						<div class="b-mod__item-price b-mod__item-price--basket"><?= $fPrice ?></div>
					</div><?
				}
				?>
			</div><?
		}*/

		/*?>
		<div id="free_postals">
			<div class="b-item-basket-img js-package-popup" data-featherlight="/images/postals.jpg">
				<img src="/images/postals_t.jpg" alt="" />
			</div>
			<p>Открытка "С Новым Годом" в подарок!</p>
		</div><?*/

		?>
		<div class="bx_ordercart_order_pay_left" id="coupons_block">
			<?
			if ($arParams["HIDE_COUPON"] != "Y")
			{
				?>
				<div class="bx_ordercart_coupon">
					<span class="coupons_block_span"><?= GetMessage("STB_COUPON_PROMT") ?></span>
					<input type="text" id="coupon" name="COUPON" value="" onchange="enterCoupon();" />
					<p class="coupon_btn">
						<a class="bx_bt_button bx_big b-bnt-form" style="font-size: 12px !important;"
						   href="javascript:void(0)"
						   onclick="enterCoupon();" title="<?= GetMessage('SALE_COUPON_APPLY_TITLE'); ?>">
							<?= GetMessage('SALE_COUPON_APPLY'); ?>
						</a>
					</p>
				</div><?
				if (!empty($arResult['COUPON_LIST']))
				{
					foreach ($arResult['COUPON_LIST'] as $oneCoupon)
					{
						$couponClass = 'disabled';
						switch ($oneCoupon['STATUS'])
						{
							case DiscountCouponsManager::STATUS_NOT_FOUND:
							case DiscountCouponsManager::STATUS_FREEZE:
								$couponClass = 'bad';
								break;
							case DiscountCouponsManager::STATUS_APPLYED:
								$couponClass = 'good';
								break;
						}
						?>
						<div class="bx_ordercart_coupon" id="c_<?= $oneCoupon['ID'] ?>"><input
							disabled readonly type="text" name="OLD_COUPON[]"
							value="<?= htmlspecialcharsbx($oneCoupon['COUPON']); ?>"
							class="<? echo $couponClass; ?>"><span class="<? echo $couponClass; ?>"
							data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span>

						<div class="bx_ordercart_coupon_notes"><?
							if (isset($oneCoupon['CHECK_CODE_TEXT']))
							{
								echo(is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
							}
							?></div></div><?
					}
					unset($couponClass, $oneCoupon);
				}
			}
			else
			{
				?>&nbsp;<?
			}

			?>
			<script>var discount_price_all = <?= round($arResult['DISCOUNT_PRICE_ALL']) ?>;var allSum = <?= round($arResult['allSum'])
			?>;</script>
			<dl class="discount-total hidden">
				<dt>Итого без скидки:</dt><dd><em id="dtotal1"></em><span class="rub">i</span></dd>
				<dt>Скидка:</dt><dd><span id="dtotal2"></span><span class="rub">i</span></dd>
				<dt>Стоимость со скидкой:</dt><dd><span id="dtotal3"></span><span class="rub">i</span></dd>
			</dl>
		</div><?
		$savingData = \Local\Utils\Savings::getCurrentUserData();
		if ($savingData['LEVEL'])
		{
			?>
			<p class="loyality loyality-value"><?= $savingData['NAME'] ?></p>
			<p class="loyality loyality-info">Условия <a href="/loyalty/">программы лояльности</a></p><?
		}
		?>

	</div>
</div>
</div>
</div>
</section>

<div class="b-total-page">
	<div class="b-content-center">
		<div class="b-flag-bg b-flag-bg--basket">
			<div class="b-price-foter">
				<span class="b-price-foter__desc">Итого</span>

				<div class="b-price-foter__price">
					<span class="js-order-total"
					      id="allSum_FORMATED"><?= $arResult['allSum']?></span>
					<span class="rub">i</span>
				</div>
			</div>
			<div class="button-group">
				<a href="/" class="continue-order">продолжить покупки</a>
				<a href="javascript:void(0)" onclick="checkOut();">
					<button class="b-bnt-form b-bnt-modal-cupcake--white js-checkout-btn" type="submit">оформить
					</button>
				</a>
			</div>
		</div>
	</div>
</div>
	
	
	
						