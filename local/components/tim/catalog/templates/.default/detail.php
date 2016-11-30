<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var Local\Catalog\TimCatalog $component */

$product = $component->product;

?>
	<section class="b-topblock b-min-height-213 b-topblock-mobhide">
	</section>
	<div itemscope itemtype="http://schema.org/Product">
	<section class="b-topblock b-product-card__wrap">
		<div class="b-topscreen-slider"><?
			foreach ($product['PICTURES'] as $pic)
			{
				?>
				<div>
					<div class="b-topscreen-blurred" style="background-image: url(<?= $pic ?>);"></div>
					<div class="b-topblock-block-left" style="background-image: url(<?= $pic ?>)"></div>
				</div><?
			}
			?>
		</div>
		<div class="b-content-center b-block-assortment js-modal-window">
			<div class="b-block-assortment__wrap js-product">
				<a class="b-block-new__link b-block-assortment_link i-margin-left-30"
				   href="/cat/<?= $product['CATEGORY']['CODE'] ?>/">в каталог</a>
				<div class="b-content-center--title i-margin-left-30">
					<h1 itemprop="name"><?= $product['NAME'] ?></h1>
				</div>
				<div class="b-product-card__content i-margin-left-30">
					<p itemprop="description">
						<?= $product['PREVIEW_TEXT'] ?>
					</p>
				</div><?

				if ($product['ACTION'])
				{
					?>
					<div class="b-product-card--discont i-margin-left-30 b-title--border-bottom ">
						<div class="b-mod__item-label">акция</div>
						<div class="b-product-card--discont-text"><?= $product['ACTION_TEXT'] ?></div>
					</div><?
				}

				$price = $product['PRICE'];
				$dPrice = $product['PRICE_WO_DISCOUNT'];
				$offerId = 0;

				if (count($product['OFFERS']) > 0)
				{
					$firstCount = 0;
					foreach ($product['OFFERS'] as $offer)
					{
						if (!$offerId)
						{
							$offerId = $offer['ID'];
							$firstCount = $offer['COUNT'];
							$price = $offer['PRICE'];
							$dPrice = $offer['PRICE_WO_DISCOUNT'];
						}
						?><input type="hidden" id="p-<?= $offer['ID'] ?>" value="<?= $offer['PRICE'] ?>"><?
						?><input type="hidden" id="dp-<?= $offer['ID'] ?>" value="<?= $offer['PRICE_WO_DISCOUNT'] ?>"><?
					}

					?>
					<div class="b-block-assortment--select i-margin-left-30">
						<div class="b-application-event__form-item b-form-item--select b-form-item--select-assortment-total">
							<label class="is-color-white" for="count_select">Количество</label>
							<div class="b-form-item__input b-form-item__input--select">
								<p class="select_title"><?= $firstCount ?></p>
								<select id="count_select" class="js_detail_count"><?
									foreach ($product['OFFERS'] as $offer)
									{
										?>
										<option value="<?= $offer['ID'] ?>"><?= $offer['COUNT'] ?></option><?
									}
									?>
								</select>
							</div>
						</div>
					</div><?
				}

				?>
				<div class="b-block-assortment--total" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<meta itemprop="priceCurrency" content="RUB"/><?

					$action = $dPrice > $price ? '' : ' hide-old-price';
					?>
					<div class="b-old--total-price js-priceblock<?= $action ?>">
						<div class="b-old-price">
							<span class="v"><?= number_format($dPrice, 0, '', ' ') ?></span>
							<span class="rub">i</span>
						</div>
						<div class="b-new-price">
							<span class="v" itemprop="price"><?= number_format($price, 0, '', ' ') ?></span>
							<span class="rub">i</span>
						</div>
					</div><?

					?>
					<div class="b-assortment-total--btn">
						<button class="b-bnt-form b-bnt-form--green i-padd-12x40 js-add-to-basket"
						        data-id="<?= $product['ID'] ?>" data-offer="<?= $offerId ?>"
						        data-href="/personal/cart">в корзину</button>
					</div><?

					?>
					<div class="b-delivery_popup">
						Самовывоз — бесплатно,
						<span class="show_delivery_popup" id="js_show_delivery_popup">выбрать магазин</span>.
					</div><?

					?>
				</div>
			</div>
		</div>
	</section><?

	if ($product["DETAIL_TEXT"])
	{
		?>
		<div class="item-desc"><?= $product["DETAIL_TEXT"] ?></div><?
	}

	?>
	<section class="b-bg-grey"><?
		/*if (isset($arResult['BOUND_PRODUCT_ID']))
		{
			?>
			<div class="b-content-center b-grey-block-gift--wrap">
			<div class="b-grey-wrap-top  b-ordering-accessory__list">
				<div class="b-grey-wrap-top-right">
					<div class="b-grey-wrap-bottom">
						<div class="b-grey-wrap-bottom-right">
							<div class="b-application-event--title">
								<span>  <font class="b-block-desktop-only">приятный </font>аксессуар к заказу</span>
							</div>
							<div class="js-postcards-wrap b-addition-order-wrap">
								<?

								$i = 0;
								$length = count($arResult['BOUND_PRODUCT_ID']);
								foreach ($arResult['BOUND_PRODUCT_ID'] as $gid => $arBoundList)
								{
									$i++;
									$class = $i == $length ? ' b-postcard__item--last' : '';
									?>
									<div class="b-postcard__item<?= $class ?>"><?
									foreach ($arBoundList as $products_id)
									{
										foreach ($arResult['BOUND'][$gid][$products_id] as $postcard_fields)
										{
											?>
										<div class="b-mod__item b-mod__item-postcard item_accs"
										     data-oid="<?= $postcard_fields['ID'] ?>"
										     data-bid="<?= $arResult['BOUND_BASKET'][$gid][$postcard_fields['ID']]['ID'] ?>">
											<div class="b-mod__item-img">
												<div class="b-mod__item-img--effect-transform">
													<img class="js-postcard-img"
													     src="<?= CFile::GetPath($postcard_fields['DETAIL_PICTURE']) ?>"
													     alt="">
												</div>
											</div>
											<div class="b-mod__item-title">
														<span
															class="postcard--name js-postcard-name"> <?= $postcard_fields['NAME'] ?></span>
														<span
															class="js-postcard-text"><?= $postcard_fields['PREVIEW_TEXT'] ?></span>
											</div>
											<div class="b-mod__item-price js-postcard-price"
											     data-price="<?= $postcard_fields['PRICE'] ?>">
												<?= $postcard_fields['PRICE'] ?> <span class="rub">i</span>
											</div>
											<div>
												<button class="b-bnt-form b-bnt-form--green js-modal-tobasket"
												        data-href="/personal/cart"
												        data-addid="<?= $postcard_fields['ID'] ?>">в корзину
												</button>
											</div>
											</div><?
										}
									}
									?>
									</div><?
								}
								?>

							</div>
						</div>
					</div>
				</div>
			</div>
			</div><?
		}*/

		//
		// Перелинковка ("У нас есть много вкусных сладостей")
		//
		$APPLICATION->IncludeComponent('tim:empty', 'detail_relinks', array(
			'CATEGORY' => $product['CATEGORY']['ID'],
		));

		?>
	</section><?

	/*
	$category = '';
	$cat = CIBlock::GetByID($arResult['IBLOCK_ID']);
	if ($ar_res = $cat->GetNext())
		$category = $ar_res['NAME'];
	?>
	<script>
		$(document).ready(function () {
			dataLayer.push({
				'ecommerce': {
					'currencyCode': 'RUR',
					'impressions': [{
						'name': '<?=$arResult['
							NAME ']?>',
						'id': '<?=$arResult['
							ID ']?>',
						'price': '<?=$arResult['
							MIN_PRICE ']['
							VALUE ']?>',
						'category': '<?=$category?>'
					}]
				}
			});
			$('.js-modal-tobasket').click(function () {
				if ($('.js-modal-tobasket').html() == 'в корзину') {
					dataLayer.push({
						'event': 'addToCart',
						'ecommerce': {
							'currencyCode': 'RUR',
							'add': {
								'products': [{
									'name': '<?=$arResult['
										NAME ']?>',
									'id': '<?=$arResult['
										ID ']?>',
									'price': '<?=$arResult['
										MIN_PRICE ']['
										VALUE ']?>',
									'category': '<?=$category?>',
									'quantity': parseInt($('.js-modal-counter').html())
								}]
							}
						}
					});
				}
			});
		});
	</script><?
	*/

	?>
</div>


	<!--modal delivery-->
<div class="b-modal-personal_account js_delivery_modal" style="display: none">
	<span class="b-close-modal">close</span>
	<!-- form -->
	<?
	$arUser = array();
	$pickupAddr = array();
	$i = 0;

	$user_id = $USER->GetID();
	if (isset($user_id) && $user_id != '')
	{
		$rsUser = $USER->GetByID($user_id);
		$arUser = $rsUser->Fetch();
	}

	$result = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 27), false, false, array(
			'*',
			'PROPERTY_PICKUP_ADR',
			'PROPERTY_SCHEDULE'
		));
	while ($item = $result->fetch())
	{
		$pickupAddr[$i]['addr'] = $item['PROPERTY_PICKUP_ADR_VALUE'];
		$pickupAddr[$i]['sch'] = $item['PROPERTY_SCHEDULE_VALUE'];
		$i++;
	}

	?>
	<div class="b-personal_account--form">
		<div class="b-grey-wrap-top">
			<div class="b-grey-wrap-top-right">
				<div class="b-grey-wrap-bottom">
					<div class="b-grey-wrap-bottom-right">
						<div class="b-application-event--title">
							<span> Забрать самовывозом</span>
						</div>
						<div class="b-personal_account__form-wrap">
							<form name="delivery" action="/include/cart_sd_step.php" method="post"
							      enctype="multipart/form-data">
								<input type="hidden" name="form_type" value="popup">
								<input class="popup_el_id" type="hidden" name="product_id" value="">
								<input class="popup_quantity" type="hidden" name="quantity" value="">

								<div class="b-personal_account__form--line">
									<!--form item-->
									<div class="pickup-personal-info">
										<div class="b-personal_account__form-item popup-form-item">
											<label for=""> как вас зовут</label>

											<div class="b-form-item__input">
												<input type="text" name="NAME" value="<?= $arUser["NAME"] ?>"/>
											</div>
										</div>
										<div class="b-personal_account__form-item popup-form-item">
											<label for=""> адрес эл. почты</label>

											<div class="b-form-item__input">
												<input class="" type="text" name="EMAIL"
												       value="<?= $arUser["EMAIL"] ?>"/>
											</div>
										</div>
										<div class="b-personal_account__form-item popup-form-item">
											<label for=""> телефон</label>

											<div class="b-form-item__input">
												<input class="" type="text" name="PERSONAL_PHONE"
												       value="<?= $arUser["PERSONAL_PHONE"] ?>"/>
											</div>
										</div>
									</div>
									<!--end form item-->

									<div class="b-pickup_address">
										<div class="pickup-addr-list">Адреса самовывоза</div>
										<ul>
											<? foreach ($pickupAddr as $key => $addr): ?>
												<li>
													<input class="radio" type="radio" value="<?= $addr['addr'] ?>"
													       id="addr<?= $key ?>"
													       name="pickup_adr" <?= $key == 0 ? 'checked' : '' ?>>
													<label class="b-label-radio"
													       for="addr<?= $key ?>"><?= $addr['addr'] . ', </br>Время работы: ' . $addr['sch'] ?></label>
												</li>
											<? endforeach; ?>
										</ul>
									</div>
								</div>
								<div class="popup-info-text">
									<? $APPLICATION->IncludeFile('/include/delivery_modal_text.php', array(), array(
											'MODE' => 'html',
											'TEMPLATE' => 'page_inc.php',
										)); ?>
								</div>
								<button type="submit" class="b-bnt-form">Заказать самовывоз</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><?

if ($product['TITLE'])
	$APPLICATION->SetPageProperty('title', $product['TITLE']);
if ($product['DESCRIPTION'])
	$APPLICATION->SetPageProperty('description', $product['DESCRIPTION']);

$APPLICATION->AddHeadString('<meta property="fb:app_id" content="' . 574393899375304 . '">', true);
$APPLICATION->AddHeadString('<meta property="og:title" content="' . $product['NAME'] . '">', true);
$APPLICATION->AddHeadString('<meta property="og:description" content="' . strip_tags($product['PREVIEW_TEXT']) . '">', true);
$APPLICATION->AddHeadString('<meta property="og:url" content="http://' . SITE_SERVER_NAME . $product['DETAIL_PAGE_URL'] . '">', true);
$APPLICATION->AddHeadString('<meta property="og:image" content="http://' . SITE_SERVER_NAME . $product['PICTURES'][0] . '">', true);

\Local\Utils\Remarketing::setPageType('product');
\Local\Utils\Remarketing::addProductId($arResult['ID']);
\Local\Utils\Remarketing::setTotal($arResult['MIN_PRICE']['VALUE']);