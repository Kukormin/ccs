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
		<div class="b-content-center b-block-assortment js-modal-window" data-id="<?= $product['ID'] ?>">
			<div class="b-block-assortment__wrap">
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
					</div>
					<?
				}

				$price = $product['PRICE'];

				?>
				<div class="b-block-assortment--select i-margin-left-30"><?

					if (count($product['OFFERS']) > 0)
					{
						$firstCount = 1;
						foreach ($product['OFFERS'] as $offer)
						{
							$firstCount = $offer['COUNT'];
							$price = $offer['PRICE'];
							break;
						}

						?>
						<div class="b-application-event__form-item b-form-item--select b-form-item--select-assortment-total">
							<label class="is-color-white" for="count_select">Количество</label>
							<div class="b-form-item__input b-form-item__input--select">
								<p class="select_title"><?= $firstCount ?></p>
								<select id="count_select" class="js_cupcake_number"><?
									foreach ($product['OFFERS'] as $offer)
									{
										?>
										<option value="<?= $offer['ID'] ?>"><?= $offer['COUNT'] ?></option><?
									}
									?>
								</select>
							</div>
						</div><?
					}
					?>
				</div>

				<div class="b-block-assortment--total" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<meta itemprop="priceCurrency" content="RUB"/>
					<?
					$boolHasDiscout = false;
					if ($arResult['MIN_PRICE']['DISCOUNT_VALUE'] != $arResult['MIN_PRICE']['VALUE'])
					{
						$boolHasDiscout = true;
						$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
						$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
					}

					if ($boolHasDiscout)
					{
						?>
						<div class="b-old--total-price js-priceblock"
						     data-price="<?= $arResult['MIN_PRICE']['DISCOUNT_VALUE']; ?>"
						     data-oldprice="<?= $arResult['MIN_PRICE']['VALUE']; ?>">
							<div class="b-old-price">
								<?= number_format($arResult['MIN_PRICE']['VALUE'], 0, '', ' '); ?> <span
									class="rub">i</span></div>
							<div class="b-new-price">
								<span
									itemprop="price"><?= number_format($arResult['MIN_PRICE']['DISCOUNT_VALUE'], 0, '', ' '); ?></span>
								<span class="rub">i</span></div>
						</div>
						<?
					}
					else
					{
						?>
						<div class="b-history-total--price js-priceblock" data-price="<?= $price ?>" data-oldprice="0">
							<span itemprop="price"><?= number_format($price, 0, '', ' '); ?></span>
							<span class="rub">i</span>
						</div><?
					}
/*
					?>
					<div class="b-assortment-total--btn">
						<button class="b-bnt-form b-bnt-form--green i-padd-12x40 js-modal-tobasket"
						        data-href="/personal/cart">в корзину</button>
					</div><?

					?>
					<div class="b-delivery_popup">
						Самовывоз — бесплатно,
						<span class="show_delivery_popup" id="js_show_delivery_popup">выбрать магазин</span>.
					</div><?*/

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

return;


use Bitrix\Main\Localization\Loc;
use Local\Catalog\Filter;
use Local\Catalog\Common;
use Local\Catalog\Sections;
use Local\Catalog\Options;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

Loc::loadMessages(__FILE__);

$product = $arResult['PRODUCT'];
$section = Sections::getById($product['SECTION']);

$arTestProductsCode = array(
	'test-online-payments',
);

if (!$product || !$USER->IsAdmin() && in_array($product['CODE'], $arTestProductsCode))
{
	@define("ERROR_404", "Y");
	return;
}

$name = $product['NAME'];
$colorName = strtolower($product['COLOR']['NAME']);
$gender = '';

if ($product['FOR_M'] && $product['FOR_W'])
{
	$gender = '';
}
else if ($product['FOR_M'])
	$gender = 'Мужские';
elseif ($product['FOR_W'])
	$gender = 'Женские';
$fullName = $gender . ' ' . $colorName . ' ' . $product['BRAND'] . ' ' . $name;
$metaPhoto = '';

if ($arParams['FAST_VIEW'])
{
	?>
	<div class="modal-block__inner">
	<div class="modal-block__content"><?
}
?>

	<div class="product">
	<div class="deliveryCalcPopupDiv" style="display:none">
	</div>
	<div class="product__content i-clfx" itemscope itemtype="http://schema.org/Product"><?

	//
	// Фотографии
	//
	?>
	<div class="product__preview">
		<div class="gallery-img">
			<div class="gallery-preview">
				<?
				$file = new \CFile();
				$previews = array();
				foreach ($product['PHOTOS'] as $i => $photo)
				{
					$imageNum = ' - изображение ' . ($i + 1);
					$alt = 'Купить ' . $fullName . $imageNum;
					$title = $product['BRAND'] . ' ' . $name . $imageNum;
					$detail = $file->ResizeImageGet($photo, array(
							"width" => 470,
							"height" => 422
						), BX_RESIZE_IMAGE_EXACT);
					$big = $file->ResizeImageGet($photo, array(
							"width" => 620,
							"height" => 620
						), BX_RESIZE_IMAGE_EXACT);
					$previews[] = $detail['src'];
					$wai = $i ? ' i-wai' : '';
					if (!$metaPhoto)
						$metaPhoto = $big['src'];
					?>
				<a href="<?= $big['src'] ?>" title="<?= $name ?>" itemscope itemtype="http://schema.org/ImageObject"
				   class="js-fancybox-img<?= $wai ?>" rel="gallery" data-prev-product="<?= $product['ID'] ?>">
					<?= $file->ShowImage($detail['src'], 470, 422, 'itemprop="image" alt="' . $alt . '" title="' . $title . '"') ?>
					</a><?
				}
				?>
			</div>
			<ul class="list list_inline list_flat list_thumb gallery-sm"><?

				foreach ($previews as $pic)
				{
					?>
					<li class="list__item">
					<img src="<?= $pic ?>" width="110" height="110" alt="<?= $name ?>">
					<span class="thumb__mask-element"></span>
					</li><?
				}
				?>
			</ul>
		</div>
	</div><?

	//
	// Базовые свойства
	//
	?>
	<div class="product__main i-clfx">
	<div class="product__main__left">
		<?
		$activeOffer = false;
		foreach ($product['OFFERS'] as $offer)
		{
			if ($offer['AVAIL'] || $product['STATUS'] == 'NOT_HANDLE')
			{
				if ($_GET['SIZE'] == $offer['NAME'] || $activeOffer === false)
					$activeOffer = $offer;
			}
		}

		$catalogBrandHref = Filter::$CATALOG_PATH . $product['BRAND_CODE'] . '/';
		?>
		<p class="product__articul">
			Артикул <span class="product__articul__num" id="articul"
			              itemprop="sku"><?= $activeOffer['ARTICUL'] ?></span>
		</p>

		<p class="product__category" itemprop="brand" itemscope itemtype="http://schema.org/Brand">
			<a href="<?= $catalogBrandHref ?>" itemprop="url"><span itemprop="name"><?= $product['BRAND'] ?></span></a>
		</p>

		<h1 class="product__title" itemprop="name"><?= $product['NAME'] ?> <?= $product['BRAND'] ?></h1>
		<meta itemprop="description" content="<?= strip_tags($product['DESCRIPTION']) ?>"/>
		<div class="product__offers" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<?
			if ($product['PRICE'] < $product['OLD_PRICE'])
			{
				?>
				<span class="product__price-old">
				<span class="product__price__num">&nbsp;<?= $product['OLD_PRICE'] ?></span>
				</span><?
			}
			?>
			<span class="product__price">
						<span class="product__price__num"><?= $product['PRICE'] ?></span><span class="valuta">p</span>
					</span>

			<meta itemprop="price" content="<?= $product['PRICE'] ?>">
			<meta itemprop="priceCurrency" content="RUB">
			<link itemprop="availability" href="http://schema.org/InStock"/>
		</div><?

		if ($activeOffer)
		{
			?>
			<div class="i-clfx product__choice">
			<div class="l-col l-col_4 size-table">
				<p class="product__choice__title">Выберите размер (RUS)</p>
				<ul class="list list_flat list_inline list_product-size">
					<?
					foreach ($product['OFFERS'] as $offer)
					{
						$active = $offer['ID'] == $activeOffer['ID'] ? ' active' : '';
						if ($offer['AVAIL'] || $product['STATUS'] == 'NOT_HANDLE')
							$disable = '';
						else
							$disable = ' list__item_disable';

						?>
						<li class="list__item<?= $disable ?><?= $active ?> size-list_item"
					<li class="list__item<?= $disable ?><?= $active ?>"
					    data-id="<?= $offer['ID']; ?>"
					    data-size="<?= $offer['NAME'] ?>"
					    data-article="<?= $offer['ARTICUL'] ?>"
					    data-color="<?= $colorName ?>"
					    data-skuid="<?= $offer['ID'] ?>"
						<?= !empty($offer['SIZE_INFO_TEXT']) ? 'data-sizetooltip="Y" title="' . $offer['SIZE_INFO_TEXT'] . '"' : ''; ?>
					    data-href="<?= $product['DETAIL_PAGE_URL'] ?><?= $offer['NAME'] ?>/">
						<a class="product-size-item"><?= $offer['NAME'] ?></a>
						</li><?
					}
					?>
				</ul>
			</div>
			</div><?

			// Таблица размеров
			?>
		<a href="/sizetable.php?brand=<?= $product['BRAND'] ?>&category=<?= $section['NAME'] ?>&gender=<?= $product['GENDER'] ?>"
		   data-prev-product="<?= $product['ID'] ?>" class="size-select-btn js-fancybox-content">Таблица размеров</a><?

			// Кнопки "купить" и "Заказать в один клик"
			?>

			<div class="i-clfx product__operation">
			<div class="l-col l-col_4 buy_btn">
				<? if ($arResult['IN_BASKET']): ?>
					<a class="btn" href="/order/">Оформить</a>
				<? else: ?>
					<span id="btn_to_basket" onclick="yaCounter27318569.reachGoal('btn_to_basket_click');  return true;"
					      data-id="<?= $product['ID'] ?>" data-gtm-product-id="<?= $product['EXTERNAL_ID'] ?>">
									<span class="btn">в корзину</span>
								</span>
				<?endif; ?>
			</div>
			<div class="l-col l-col_4">
							<span href="#addtooneclick" class="btn btn_decor btn_width-100 js-fancybox" id="click2order"
							      data-id="<?= $product['ID'] ?>" data-prev-product="<?= $product['ID'] ?>">
								<span class="btn_decor__inside">Заказать в один клик</span>
							</span>
			</div>
			</div><?
		}
		else
		{
			?>
			<div class="i-clfx product__operation">
				<div class="l-col l-col_4">
							<span>
								<span class="btn">Нет в наличии</span>
							</span>
				</div>
			</div><?
		}

		if ($product['STATUS'] != 'NOT_HANDLE' && $activeOffer)
		{
			?>
			<div class="product__delivery"><?

			$fromShopsDeliveryAvail = Options::deliveryFromShopAvail();

			foreach ($product['OFFERS'] as $offer)
			{
				$active = $offer['ID'] == $activeOffer['ID'] ? ' active' : '';
				?>
				<p class="art_<?= $offer['ARTICUL'] ?><?= $active ?>"><?

				$offerStocks = $product['STOCKS']['OFFERS'][$offer['ID']];
				$webAvailable = false;
				$availableShops = array();
				foreach ($offerStocks as $storeId => $amount)
				{
					if ($amount > 0)
						if ($storeId == \Local\Catalog\City::ESTORE_ID)
							$webAvailable = true;
						else
							$availableShops[] = $storeId;
				}
				$shopsAvailable = count($availableShops);

				if ($webAvailable || $shopsAvailable)
				{
					if ($shopsAvailable && $product['STOCKS']['PICKUP_AVAIL'])
					{
						/*$href = '/shops.php?shops=' . implode(',', $availableShops);
						$title = $shopsAvailable > 1 ? ' магазинах' : ' магазине';
						?>Самовывоз: доступен в <?
						?><a href="<?= $href ?>" class="product__delivery__shop js-fancybox-content" data-prev-product="<?= $product['ID'] ?>">
						<span><?= $shopsAvailable ?><?= $title ?></span>
						</a><?*/
						$cityId = \Local\Catalog\City::getCurrentId();
						?>Забрать в магазине — бесплатно, <a
						href="/ajax/reserve_form.php?city=<?= $cityId ?>&store=0&offer=<?= $offer['ID'] ?>&product=<?= $product['ID'] ?>"
						class="product__delivery__shop product_reserve js-fancybox-content"
						data-prev-product="<?= $product['ID'] ?>">выбрать магазин</a>
						<br/><?
					}

					// Если нет товара на складе ИМ, но есть в магазинах, то проверим рубильник "доставка из розницы"
					if (!$webAvailable && $shopsAvailable)
					{
						if ($fromShopsDeliveryAvail)
							$webAvailable = true;
					}

					if ($webAvailable)
					{
						?>
						Доставка:
						<span class="product__delivery__time js--autoload-delivery-time">
												<img width="20" src="<?= SITE_TEMPLATE_PATH ?>/images/bx_loader.gif">
											</span>
						<?// Бесплатная доставка в регионах
						if ($_SESSION['IS_MOSCOW'] !== 'Y')
						{
							\Bitrix\Main\Loader::includeModule('prmedia.freedeliveryaction');
							if (\Prmedia\FreeDeliveryAction\Checker::isActive())
							{
								?>
								<br/><br/>
								<span class="product__promo_delivery_text">
												Акция! При оплате на сайте заказа на сумму от 7000 руб. доставка будет бесплатной.
											</span><br/><br/><?
							}
						}
					}
				}

				?>
				</p><?
			}
			?>
			</div><?
		}

		if ($arParams['FAST_VIEW'])
		{
			?>
			<div class="l-col l-col_8 detail_product_link">
			<a href="<?= $product['DETAIL_PAGE_URL'] ?>" data-id="<?= $product['ID'] ?>">
				<span class="btn">подробное описание товара</span>
			</a>
			</div><?
		}
		?>
	</div><?

	//
	// Блоки справа
	//
	if (!$arParams['FAST_VIEW'])
	{
		$tips = Common::getCardTips();
		?>
		<div class="product__main__right">
		<ul class="list list_flat list_advantage">
			<li class="list__item">
				<div class="advantage-item">
					<div data-tooltip="Y" title="<?= $tips['delivery'] ?>">
						<div class="advantage-item__pic-wrap">
							<span class="i-ico i-ico_delivery"></span>
						</div>
						<div class="advantage-item__main">
							<p class="advantage-item__title advantage-item__title_tooltip">
								<span>Доставка по всей России</span>
							</p>
						</div>
					</div>
					<a class="deliveryCalcPopup js-fancybox fancybox.iframe" href="/shipping/ajax.php">калькулятор</a>
				</div>
			</li>
			<li class="list__item">
				<div class="advantage-item">
					<div data-tooltip="Y" title="<?= $tips['fitting'] ?>">
						<div class="advantage-item__pic-wrap">
							<span class="i-ico i-ico_fitting"></span>
						</div>
						<div class="advantage-item__main">
							<p class="advantage-item__title advantage-item__title_tooltip">
								<span>Примерка перед покупкой</span>
							</p>
						</div>
					</div>
				</div>
			</li>
			<li class="list__item">
				<div class="advantage-item">
					<div data-tooltip="Y" title="<?= $tips['support'] ?>">
						<div class="advantage-item__pic-wrap">
							<span class="i-ico i-ico_support"></span>
						</div>
						<div class="advantage-item__main">
							<p class="advantage-item__title">
								<span>Клиентская служба поддержки</span>
							</p>
						</div>
					</div>
				</div>
			</li>
		</ul>
		</div><?
	}

	?>
	<div class="i-clfx product__action"><?

		//
		// Шаринг
		//
		$url = 'http://' . SITE_SERVER_NAME . $APPLICATION->GetCurPage();
		?>
		<div class="l-col l-col_4">
			<span class="product__action__title">Поделиться с друзьями:</span>
			<ul class="list list_flat list_inline list_soc-ico">
				<li class="list__item">
					<a class="soc-ico__main soc-ico__main_facebook"
					   href="https://www.facebook.com/sharer/sharer.php?src=uplab&u=<?= $url ?>"></a>
				</li>
				<li class="list__item">
					<a class="soc-ico__main soc-ico__main_vkontakte" href="http://vk.com/share.php?url=<?= $url ?>"></a>
				</li>
				<li class="list__item">
					<a class="soc-ico__main soc-ico__main_twitter"
					   href="https://twitter.com/intent/tweet?url=<?= $url ?>"></a>
				</li>
			</ul>
		</div><?

		//
		// Добавить в избранное
		//
		if (isset($_SESSION['favs']) && !empty($_SESSION['favs'][$activeOffer['ID']]))
		{
			$favText = 'Удалить из избранного';
			$favClass = ' class="fav-btn_added"';
			$btnClass = ' favourites-btn_added';
			$favStat = 'remove';
		}
		else
		{
			$favText = 'Добавить в избранное';
			$favClass = '';
			$btnClass = '';
			$favStat = 'add';
		}
		?>
		<div class="l-col l-col_4">
			<div class="favourites-wrap">
				<div class="btn btn_decor btn_width-100 favourites-btn<?= $btnClass ?>">
					<div id="fav-btn-text"<?= $favClass ?> href="#addfavourites"
					     onClick="fav(<?= $activeOffer['ID'] ?>, '<?= $favStat ?>')">
						<span class="i-ico i-ico_heard"></span><?= $favText ?>
					</div>
				</div>
			</div>
		</div><?

		?>
	</div>
	</div>
	</div><?

	if (!$arParams['FAST_VIEW'])
	{
		?>
		<div class="product__descr i-clfx"><?

		//
		// Блок рекомендаций

		define('CITYID_RF', 0);
		define('CITYID_MSK', 317);
		define('CITYID_SPB', 66636);
		define('CITYID_VRN', 1248809);

		$city = \Local\Catalog\City::getCurrent();
		$RR_CODE = array(
			CITYID_MSK => 'moskva',
			CITYID_SPB => 'sankt_peterburg',
			CITYID_VRN => 'voronezh',
			CITYID_RF => 'rf'
		);
		$stock_id = (isset($RR_CODE[$city['ID']])) ? $RR_CODE[$city['ID']] : $RR_CODE[CITYID_RF];
		//
		?>
		<div class="product__descr__left" itemscope itemtype="http://schema.org/ItemList">
		<div data-retailrocket-markup-block="56bdbb229872e510dcd6fe9b" data-argument="<?= $activeOffer['ID']; ?>"
		     data-stock-id="<?= $stock_id; ?>"></div>
		<link itemprop="url" href="<?= $product['DETAIL_PAGE_URL'] ?>"/>
		<meta itemprop="numberOfItems" content="<?= count($arResult['RECOMMENDATIONS']) ?>"/>
		<p class="product__descr__title">рекомендуем:</p>
		<ul class="list list_flat list_inline list_product list_product list_product-sm">
			<?

			foreach ($arResult['RECOMMENDATIONS'] as $item)
			{
				?>
				<li class="list__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/Product">

					<div class="product-item">
						<a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="product-item__pic-wrap">
							<? if ($item['PHOTOS'][0])
							{ ?>
								<div class="product-item__pic-wrap__preview"><?

								$img = $file->ResizeImageGet($item['PHOTOS'][0], Array(
										"width" => 110,
										"height" => 110
									), BX_RESIZE_IMAGE_EXACT);
								echo $file->ShowImage($img['src'], 110, 110, 'itemprop="image" alt="' . $item['NAME'] . '"');

								?>
								</div><?
							}

							if ($item['PHOTOS'][1])
							{
								?>
								<div class="product-item__pic-wrap__hover"><?

									$img = $file->ResizeImageGet($item['PHOTOS'][1], Array(
											"width" => 110,
											"height" => 110
										), BX_RESIZE_IMAGE_EXACT);
									echo $file->ShowImage($img['src'], 110, 110, 'itemprop="image" alt="' . $item['NAME'] . '"');

									?>
								</div>
							<? } ?>
						</a>
						<a itemprop="url" style="text-decoration: none;" title="<?= $item["NAME"] ?>"
						   href="<?= $item['DETAIL_PAGE_URL'] ?>">
							<div class="product-item__main">
								<p class="product-item__brand" itemprop="brand"><?= $item['BRAND'] ?></p>

								<p class="product-item__title" itemprop="name"><?= $item['NAME'] ?></p>

								<p style="display:none;" itemprop="description"><?= $item['NAME'] ?></p>

								<div class="product-item__offers" itemprop="offers" itemscope
								     itemtype="http://schema.org/Offer"><?

									if ($item['PRICE'] < $item['OLD_PRICE'])
									{
										?>
										<span class="product-item__price-old">
										<span class="product-item__price__num">&nbsp;<?= $item['OLD_PRICE'] ?></span>
										</span><?
									}
									?>
									<span class="product-item__price">
									<span class="product-item__price__num"><?= $item['PRICE'] ?></span><span
											class="valuta">p</span>
								</span>

									<meta itemprop="price" content="<?= $item['PRICE'] ?>">
									<meta itemprop="priceCurrency" content="RUB">
									<link itemprop="availability" href="http://schema.org/InStock"/>
								</div>
							</div>
							<div class="product-item__overlay"></div>
						</a>
					</div>
					<a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="btn-link2 blue">купить</a>
				</li>
			<?
			}
			?>

		</ul>
		</div><?

		//
		// Детальная информация
		//

		?>
		<div class="product__descr__right"><?

		if ($product['DESCRIPTION'])
		{
			?>
			<p class="product__descr__title">описание:</p>
			<p itemprop="description"><?= $product['DESCRIPTION'] ?></p><?
		}

		if ($product['DETAILS'])
		{
			?>
			<p class="product__descr__title">детали:</p>
			<p><?= $product['DETAILS'] ?></p><?
		}

		if ($product['MATERIAL'])
		{
			?>
			<p class="product__descr__title">Состав:</p>
			<ul><?
			if ($product['MATERIAL']['UPPER'])
			{
				?>
				<li>Верх: <?= implode(', ', $product['MATERIAL']['UPPER']) ?></li><?
			}
			if ($product['MATERIAL']['LINING'])
			{
				?>
				<li>Подкладка: <?= implode(', ', $product['MATERIAL']['LINING']) ?></li><?
			}
			if ($product['MATERIAL']['SOLE'])
			{
				?>
				<li>Подошва: <?= implode(', ', $product['MATERIAL']['SOLE']) ?></li><?
			}
			?>
			</ul><?
		}

		?>
		</div><?
		?>
		</div><?
	}
	?>
	</div>

<?

if ($arParams['FAST_VIEW'])
{
	?>
	</div>
	</div><?
}

$gtmId = $product['EXTERNAL_ID'];
$GTM_DATA_LAYER['SECTION_IDS'][] = intval($product['SECTION']);
$gtmItem = array(
	'categoryId' => intval($product['SECTION']),
	'name' => $product['NAME'],
	'id' => $gtmId,
	'price' => number_format($product['PRICE'], 2, '.', ''),
	'brand' => $product['BRAND'],
	'variant' => '',
	// намеренно оставлено пустым
	'category' => $section['FULL_NAME']
);
$GTM_DATA_LAYER['ITEMS'][$gtmId] = $gtmItem;
unset($gtmItem['categoryId']);
$GTM_DATA_LAYER['ECOMMERCE']['detail']['products'] = array($gtmItem);
$arResult['DATA_LAYER_ITEM'] = $gtmItem;

?>
	<!-- Google Tag Manager -->
<script>
	(function (window) {
		if (typeof window.dataLayer !== 'undefined') {
			window.dataLayer.push(<?= CUtil::PhpToJSObject($GTM_DATA_LAYER) ?>);
			window.dataLayerPageCategory = 'productPage';
		}

	})(window);
</script><?

Local\Helpers\RetailRocket::showCounterCatalogDetail($activeOffer['ID']);
Local\Helpers\RetailRocket::isSubscribe();
$fullName = $colorName . ' ' . $name . ' ' . $product['BRAND'];
$metaTags = array();
$lowName = $name;
$lowName = explode(' ', $lowName);
$lowName[0] = mb_strtolower($lowName[0]);
$lowName = implode(' ', $lowName);
if (!empty($product['SECTION_CODE']) && in_array($product['SECTION_CODE'], array(
			'krossovki',
			'kedy'
		))
)
{
	$metaTags['title'] = $gender . ' ' . $lowName . ' ' . $product['BRAND'] . ' - продажа, цена, фото, описание';
	$metaTags['keywords'] = strtolower($gender . ' ' . $name . ' ' . $product['BRAND'] . ' купить цена продажа фото описание интернет-магазин');
	$metaTags['description'] = $name . ' ' . $product['BRAND'] . ' в Сети фирменных магазинов Street Beat';

}
else
{
	$metaTags['title'] = $name . ' ' . $product['BRAND'] . ' - продажа, цена, фото, описание';
	$metaTags['keywords'] = strtolower($name . ' ' . $product['BRAND'] . ' купить цена продажа фото описание интернет-магазин');
	$metaTags['description'] = $name . ' ' . $product['BRAND'] . ' в Сети фирменных магазинов Street Beat';
}
$APPLICATION->SetPageProperty('title', $metaTags['title']);
$APPLICATION->SetPageProperty('keywords', $metaTags['keywords']);
$APPLICATION->SetPageProperty('description', $metaTags['description']);
$APPLICATION->SetPageProperty('image', 'http://' . SITE_SERVER_NAME . $metaPhoto);

foreach ($arResult['BC'] as $item)
	$APPLICATION->AddChainItem($item['NAME'], $item['HREF']);
