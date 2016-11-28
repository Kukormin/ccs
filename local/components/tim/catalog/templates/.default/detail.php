<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var Local\Catalog\TimCatalogElement $component */

$product = $component->product;

$APPLICATION->SetPageProperty("fb:app_id", '574393899375304');
$APPLICATION->SetPageProperty("og:title", $product['NAME']);
$APPLICATION->SetPageProperty("og:description", strip_tags($product['PREVIEW_TEXT']));
$APPLICATION->SetPageProperty("og:url", 'http://' . SITE_SERVER_NAME . $product['DETAIL_PAGE_URL']);
$APPLICATION->SetPageProperty("og:image", 'http://' . SITE_SERVER_NAME . $product['PICTURES'][0]);

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
	</section>
	<div class="item-desc"><?= $product["DETAIL_TEXT"] ?></div>

	<section class="b-bg-grey"><?
	if (isset($arResult['BOUND_PRODUCT_ID']))
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
	}

	?>

	<div class="b-content-center b-slider-about-novelty">
		<div class="b-title b-title--border-middle">
			<div class="b-title__item b-title__item--grey">
							<span href="#" class="b-mod--about-novelty__item-img">
							У нас есть много вкусных сладостей
						</span>
			</div>
		</div>
		<!--block slider-->

		<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "cupcake_section_slider", array(
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
				"COMPONENT_TEMPLATE" => "cupcake_section_slider",
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
					2 => "STAR_GIFT",
					3 => "",
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
			), false);?>

	</div>

	</section>
	<?
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
	</script>
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

\Local\Utils\Remarketing::setPageType('product');
\Local\Utils\Remarketing::addProductId($arResult['ID']);
\Local\Utils\Remarketing::setTotal($arResult['MIN_PRICE']['VALUE']);
