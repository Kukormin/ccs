<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/** @var array $arParams */
/** @var array $arResult */

use Bitrix\Sale\DiscountCouponsManager;

//debugmessage($arResult);

//инфоблоки, товары из которых не надо выводить стандартным методом
$hideItemsFrom = array(
	16, //аксессуары
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


<section class="b-bg-grey b-bg-grey--basket" style="margin-bottom: 100px;">
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
foreach ($arResult['GROUPED_GOODS'] as $parentName => $items)
{
	$arItem = $arResult["GRID"]["ROWS"][reset($items)];
	if (in_array($arItem['IBLOCK_ID'], $hideItemsFrom))
		continue;

	?>
	<!--block basket__item-->
	<div class="b-basket__item"><?

		foreach ($items as $k)
		{
			$arItem2 = $arResult["GRID"]["ROWS"][$k];

			?>
			<div class="b-basket__li-item js-basket-item-cont <?= round($arPack['PRICE'],
				0) == 0 ? 'js-free-box' : '' ?> <?= $arPack['NAME'] == 'VIP-коробка' ? 'js-vip-box' : ''; ?>"
			    id="line_<?= $arItem2['ID'] ?>" data-oiid="<?= $arItem2["ID"] ?>"
			    data-base-price="<?= $arItem2['PRICE'] ?>"><?

				//
				// Картинка и название
				//
				?>
				<div class="b-mod__item--basket">
					<div class="b-mod__item-img--effect-transform b-mod__item-basket--img">
						<img src="<?= $arItem['PREVIEW_PICTURE_SRC'] ?>" alt="">
					</div>
					<div class="b-mod__item-title--basket">
						<?= $arItem['PARENT_NAME'] ? $arItem['PARENT_NAME'] : $arItem['NAME']; ?>
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
							foreach ($arItem2["SKU_DATA"] as $propId => $arProp)
							{
								?>
								<label class="b-basket-select--label" for=""> в упаковке</label>
								<div class="b-form-item__input b-form-item__input--select">
									<p class="select_title"></p>
									<select class="js-basket-option" data-name="<?= $arProp['NAME'] ?>"
									        data-code="<?= $arProp["CODE"] ?>"><?

										foreach ($arProp["VALUES"] as $valueId => $arSkuValue)
										{
											$selected = '';
											foreach ($arItem2["PROPS"] as $arItemProp)
												if ($arItemProp["CODE"] == $arItem2["SKU_DATA"][$propId]["CODE"])
													if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
														$selected = ' selected';
											$valId = $arProp['TYPE'] == 'S' && $arProp['USER_TYPE'] ==
											'directory' ? $arSkuValue['XML_ID'] : $arSkuValue['NAME'];

											?>
											<option
												data-value-id="<?= $valId ?>"
												data-element="<?= $arItem2["ID"] ?>"
												data-property="<?= $arProp["CODE"] ?>"
												value="<?= $arSkuValue['ID'] ?>"<?= $selected ?>><?=
												$arSkuValue['NAME'] ?></option><?
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


				$packagePrice = 0;
				if (isset($arItem['PACKAGES']) && isset($arResult['PACKAGES'][$arItem['PACKAGES']]))
				{
					$packageName = '';
					$packageBid = 0;
					foreach ($arItem2["PROPS"] as $cProp)
					{
						if ($cProp['CODE'] == 'PACKAGE')
						{
							$packageName = $cProp['VALUE'];
							$packageBid = $cProp['SORT'];
						}
					}

					?>
					<br />
					<div class="b-slider-wrap-basket__list js-package-cont" data-package-bid="<?= $packageBid ?>"><?
						foreach ($arResult['PACKAGES'][$arItem['PACKAGES']] as $arPack)
						{
							?>
							<div
								class="b-slider__item js-package-item <?= round($arPack['PRICE'], 0) == 0 ? 'js-free-box' : '' ?> <?= strpos($arPack['NAME'], '9') !== false ? 'js-vip-box' : ''; ?>"
								data-package-price="<?= $arPack['PRICE'] ?>"
								data-package-name="<?= $arPack['NAME'] ?>"
								data-package-id="<?= $arPack['ID'] ?>">
								<div class="b-slider__item-basket">
									<div class="b-item-basket-img js-package-popup"
									     data-featherlight="<?= $arPack['DETAIL_PICTURE'] ?>">
										<img src="<?= $arPack['PREVIEW_PICTURE'] ?>" alt="">
										<span class="b-modal-basket__link"> </span>
									</div><?

									if (count($arResult['PACKAGES'][$arItem['PACKAGES']]) > 1)
									{
										?>
										<div class="b-mod__item-checkbox">
											<input type="checkbox" class="checkbox em-radio js-package-selector"
											       id="pack_<?= $arPack['ID'] ?>" <?= $arPack['NAME'] == $packageName ? 'checked' : '' ?>
											       name="package_<?= $arItem2['ID'] ?>"/>
											<label for="pack_<?= $arPack['ID'] ?>">чекбокс</label>
										</div><?
									}

									if ($arPack['NAME'] == $packageName)
									{
										?>
										<script>
											$(function () {
												$('#line_<?=$arItem2['ID']?>').data('package-price', <?=$arPack['PRICE']?>);
											});
										</script><?
										$packagePrice = $arPack['PRICE'];
									}

									?>
									<div class="b-mod__item-title">
										<span class="b-slider__item-basket--name"> <?= $arPack['NAME'] ?></span>
									</div>
									<div class="b-mod__item-price b-mod__item-price--basket"> <?=
										$arPack['PRICE'] > 0 ? round($arPack['PRICE'], 0) . '<span class="rub">i</span>' : 'бесплатно' ?></div>
								</div>
							</div><?
						}
						?>
					</div><?
				}

				$packageTotal += $packagePrice * $arItem2["QUANTITY"];
				$sum = round(($arItem2['PRICE'] + $packagePrice) * $arItem2["QUANTITY"]);
				?>
				<div class="b-total-basket__group">
							<span class="b-total-basket--price" id="current_price_<?= $arItem2["ID"] ?>"> <span
									class="js-item-total"><?= $sum ?></span> <span
									class="rub">i</span>  </span>

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

//товары без SKU
foreach ($arResult["GRID"]["ROWS"] as $arItem)
{

	if (in_array($arItem['IBLOCK_ID'], $hideItemsFrom))
		continue;
	// print_r($arItem);
	?>
	<!-- 111 -->
	<div class="b-basket__item">
		<div class="b-mod__item--basket">
			<div class="b-mod__item-img--effect-transform b-mod__item-basket--img">
				<img src="<?= $arItem['PREVIEW_PICTURE_SRC'] ?>" alt="">
			</div>
			<div class="b-mod__item-title--basket">
				<?= $arItem['NAME'] ?>
			</div>
		</div>
		<div class="b-basket__item--box">
			<? if (isset($arItem['PACKAGES']) && isset($arResult['PACKAGES'][$arItem['PACKAGES']]))
			{ ?><span> коробка</span><? } ?>
		</div>
		<!--block basket__ol-list-->
		<ol class="b-basket__ol-list">
			<!--block basket__li-item-->
			<li class="b-basket__li-item js-basket-item-cont" id="line_<?= $arItem['ID'] ?>"
			    data-oiid="<?= $arItem["ID"] ?>" data-base-price="<?= $arItem['PRICE'] ?>">
				<div class="b-basket--select">
					<div class="b-basket-select__item">
						<?
						foreach ($arItem["PROPS"] as $val):

							if (is_array($arItem["SKU_DATA"]))
							{
								$bSkip = false;
								foreach ($arItem["SKU_DATA"] as $propId => $arProp)
								{
									if ($arProp["CODE"] == $val["CODE"])
									{
										$bSkip = true;
										break;
									}
								}
								if ($bSkip)
									continue;
							}


							echo '<label class="b-basket-select--label" for=""> ' . $val['NAME'] . '</label>
                                            <div class="b-form-item__input b-form-item__input--select">
                                                <p class="select_title">' . $val['VALUE'] . '</p>
                                                <select class="js-basket-prop" data-name="' . $val['NAME'] . '" data-code="' . $val['CODE'] . '">';

							foreach ($arResult['PROPS'][$arItem['PARENT_IBLOCK_ID'] ? $arItem['PARENT_IBLOCK_ID'] : $arItem['IBLOCK_ID']][$val['CODE']] as $props)
							{
								echo '<option value="' . $props['ID'] . '">' . $props['NAME'] . '</option>';
							}

							echo '</select>
                                            </div>';
						endforeach;
						?>
					</div>

				</div>

				<!--block slider-->
				<div class="b-order-basket__wrap">
					<?  $packageName = '';
					$packageBid = 0;
					foreach ($arItem["PROPS"] as $cProp)
					{
						if ($cProp['CODE'] == 'PACKAGE')
						{
							$packageName = $cProp['VALUE'];
							$packageBid = $cProp['SORT'];
						}
					}
					?>
					<div class="b-slider-wrap-basket__list js-package-cont" data-package-bid="<?= $packageBid ?>">
						<? $packagePrice = 0; ?>
						<? if (isset($arItem['PACKAGES']) && isset($arResult['PACKAGES'][$arItem['PACKAGES']]))
						{ ?>

							<? foreach ($arResult['PACKAGES'][$arItem['PACKAGES']] as $arPack)
						{ ?>
							<div class="b-slider__item js-package-item" data-package-price="<?= $arPack['PRICE'] ?>"
							     data-package-name="<?= $arPack['NAME'] ?>" data-package-id="<?= $arPack['ID'] ?>">
								<div class="b-slider__item-basket">
									<div class="b-item-basket-img js-package-popup"
									     data-featherlight="<?= $arPack['DETAIL_PICTURE'] ?>">
										<img src="<?= $arPack['PREVIEW_PICTURE'] ?>" alt="">
										<span class="b-modal-basket__link"> </span>
									</div>
									<div class="b-mod__item-checkbox">
										<input type="checkbox" class="checkbox em-radio js-package-selector"
										       id="pack_<?= $arPack['ID'] ?>" <?= $arPack['NAME'] == $packageName ? 'checked' : '' ?>
										       name="package_<?= $arItem2['ID'] ?>"/>
										<label for="pack_<?= $arPack['ID'] ?>">чекбокс</label>
									</div>
									<? if ($arPack['NAME'] == $packageName)
									{ ?>
										<script>
											$(function () {
												$('#line_<?=$arItem2['ID']?>').data('package-price', <?=$arPack['PRICE']?>);
											});
										</script>
										<? $packagePrice = $arPack['PRICE']; ?>
									<? } ?>
									<div class="b-mod__item-title">
										<span class="b-slider__item-basket--name"> <?= $arPack['NAME'] ?></span>
									</div>
									<div
										class="b-mod__item-price b-mod__item-price--basket"> <?= $arPack['PRICE'] > 0 ? round($arPack['PRICE'], 0) . '<span class="rub">i</span>' : 'бесплатно' ?></div>
								</div>
							</div>
						<?php } ?>

						<?php } ?>
					</div>

					<div class="b-total-basket__group">
						<span class="b-total-basket--price" id="current_price_<?= $arItem["ID"] ?>"> <span
								class="js-item-total"><?= ($arItem['PRICE'] + $packagePrice) ?></span> <span
								class="rub">i</span>  </span>

						<div class="b-total-basket--delete js-basket-remove">
							<span> Удалить</span>
						</div>
					</div>
				</div>
			</li>

			<div class="b-item-basket--add js-duplicate-item" id="anchit_<?= $arItem['PRODUCT_ID'] ?>"
			     data-id="<?= $arItem['PRODUCT_ID'] ?>">
				<span class="b-item-basket--add-text"> Хочу еще</span>
			</div>
		</ol>
	</div>
<? } ?>

<? //endforeach; ?>

<div class="addition-order--title"> Дополнительно к заказу</div>
<div class="js-postcards-wrap b-addition-order-wrap">
	<?
	$accs_array_grp = [];
	$i = 0;
	foreach ($arResult["GRID"]["ROWS"] as $k => $arItem)
	{
		if ($arItem['IBLOCK_ID'] == 16)
		{
			$accs_array_grp[$arItem['SECTION_ID']][$arResult["GRID"]["ROWS"][$k]['PRODUCT_ID']] = $arResult["GRID"]["ROWS"][$k];
		}
	}
	$categoryList = $arResult['CATEGORY_LIST']; //получить все из инфоблока 16

	foreach ($categoryList as $gid => $arSection):
		//$gid = $arSection['IBLOCK_SECTION_ID'];
		$length = count($arItem) - 1;
		if (!array_key_exists($gid, $accs_array_grp))
			continue;
		?>
		<div class="b-postcard__item js-postcard-block <?= ($i == $length ? 'b-postcard__item--last' : ''); ?>">
			<?php $i++; ?>
			<!--block slider-->
			<div class="add-postcard-wrap">
				<div class="add-postcard--title"> <?= $arSection['NAME']; ?> <sup class="sum-add-postcard"> 0</sup>
				</div>
				<div class="b-postcard-delete" <?= !isset($accs_array_grp[$gid]) ? 'style="display: none;"' : ''; ?>>
					Удалить
				</div>
				<div class="b-slider-add-postcard__list">
					<?php  $j = 0;

					foreach ($accs_array_grp[$gid] as $k => &$arItem):
						$arItem['INDEX'] = $j;?>
						<div class="b-slider__item" data-price="<?= $arItem["PRICE"]; ?>"
						     data-quantity="<?= $arItem["QUANTITY"]; ?>" data-oid="<?= $arItem['PRODUCT_ID']; ?>"
						     data-bid="<?= $arItem['ID']; ?>">
							<div class="b-mod__item">
								<div class="b-mod__item-img">
									<div class="b-mod__item-img--effect-transform">
										<img src="<?= $arItem['PREVIEW_PICTURE_SRC'] ?>" alt="">
									</div>
								</div>
							</div>
							<div class="b-mod__item-title">
								<span class="postcard--name"> <?= $arItem['NAME']; ?></span>
								<span><?= $arItem['PREVIEW_TEXT'] ?></span>
							</div>
						</div>
					<? endforeach ?>
				</div>

				<div
					class="b-add-postcard--quantity" <?= !isset($accs_array_grp[$gid]) ? 'style="display: none;"' : ''; ?>>
					<div class="b-form-item__input b-form-item__input--select add-postcard--select">
						<p class="select_title">1</p>
						<select class="js-postcard-counter" name="postcard-counter">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
						</select>
					</div>
					<div class="add-postcard--quantity__item"> шт</div>
					<div class="b-mod__item-price"><span class="js-postcard-total-price">200</span> <span
							class="rub">i</span></div>
				</div>
			</div>

			<!--block slider-->
			<div class="b-slider-wrap-postcard__list">
				<? foreach ($arResult['CATEGORY_LIST'] as $key => $val): ?>
					<? foreach ($val['ITEMS'] as $kk => $catalog_items): ?>
						<? if ($catalog_items['IBLOCK_SECTION_ID'] != $gid)
							continue; ?>
						<div class="b-slider__item">
							<div class="b-mod__item b-mod__item-about-novelty b-mod__item-postcard js-postcard-item"
							     data-oid="<?= $catalog_items['ID']; ?>"
							     data-bid="<?= $accs_array_grp[$gid][$catalog_items['ID']]['ID']; ?>">
								<div class="b-mod__item-img">
									<div class="b-mod__item-img--effect-transform">
										<img class="js-postcard-img"
										     src="<?= CFile::GetPath($catalog_items['PREVIEW_PICTURE']) ?>" alt="">
									</div>
								</div>
								<div class="b-mod__item-checkbox">
									<input type="checkbox" class="checkbox js-addable-postcard"
									       id="checkbox<?= $catalog_items['ID']; ?>" <?= (isset($accs_array_grp[$gid][$catalog_items['ID']]) ? 'checked="checked" data-sliderid="' . ($accs_array_grp[$gid][$catalog_items['ID']]['INDEX']) . '"' : ''); ?>/>
									<label
										for="checkbox<?= $catalog_items['ID']; ?>"><?= $catalog_items['ID']; ?></label>
								</div>
								<div class="b-mod__item-title">
									<span class="postcard--name js-postcard-name"> <?= $catalog_items['NAME'] ?></span>
									<span class="js-postcard-text"><?= $catalog_items['PREVIEW_TEXT'] ?></span>
								</div>
								<div class="b-mod__item-price js-postcard-price"
								     data-price="<?= $catalog_items['PRICE'] ?>"><?= $catalog_items['PRICE'] ?> <span
										class="rub">i</span></div>
							</div>
						</div>
					<? endforeach; ?>
				<? endforeach; ?>
			</div>
		</div>
	<? endforeach ?>


</div><?

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

	<div class="bx_ordercart_order_pay clearfix">

		<div class="bx_ordercart_order_pay_left" id="coupons_block">
			<?
			if ($arParams["HIDE_COUPON"] != "Y")
			{
				?>
				<div class="bx_ordercart_coupon">
				<span class="coupons_block_span"><?= GetMessage("STB_COUPON_PROMT") ?></span><input type="text"
				                                                                                    id="coupon"
				                                                                                    name="COUPON"
				                                                                                    value=""
				                                                                                    onchange="enterCoupon();">&nbsp;<a
					class="bx_bt_button bx_big b-bnt-form" style="font-size: 12px !important;" href="javascript:void(0)"
					onclick="enterCoupon();"
					title="<?= GetMessage('SALE_COUPON_APPLY_TITLE'); ?>"><?= GetMessage('SALE_COUPON_APPLY'); ?></a>
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

			$cl = ' hidden';
			if ($arResult['DISCOUNT_PRICE_ALL'] > 0)
				$cl = '';

			?>
			<dl class="discount-total<?= $cl ?>">
				<dt>Итого без скидки:</dt><dd><em id="dtotal1"><?= round($arResult['DISCOUNT_PRICE_ALL'] +
						$arResult['allSum'])
				?></em><span class="rub">i</span></dd>
				<dt>Скидка:</dt><dd><span id="dtotal2"><?= round($arResult['DISCOUNT_PRICE_ALL']) ?></span><span
						class="rub">i</span></dd>
				<dt>Стоимость со скидкой:</dt><dd><span id="dtotal3"><?= round($arResult['allSum']) ?></span><span
						class="rub">i</span></dd>
			</dl><?

			?>
		</div>
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
	
	
	
						