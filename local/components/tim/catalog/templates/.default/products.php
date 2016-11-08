<ul class="list list_flat list_inline list_product"><?
	$fromShopsDeliveryAvail = \Local\Catalog\Options::deliveryFromShopAvail();
	foreach ($arResult['PRODUCTS']['ITEMS'] as $id => $product)
	{
		$file = new \CFile();
		$alt = str_replace('"', '\"', $product['NAME']);

		// Основная картинка
		if ($product['PHOTOS'][0])
		{
			$renderImage = $file->ResizeImageGet(
				$product['PHOTOS'][0],
				Array("width" => 230, "height" => 218),
				BX_RESIZE_IMAGE_EXACT
			);
		}
		else
		{
			$renderImage['src'] = SITE_TEMPLATE_PATH . "/images/nophoto.jpg";
		}
		$pic = $file->ShowImage($renderImage['src'], 230, 218, 'itemprop="image" alt="' . $alt . '"');

		// Дополнительная картинка
		if ($product['PHOTOS'][1])
		{
			$renderImage = $file->ResizeImageGet(
				$product['PHOTOS'][1],
				Array("width" => 230, "height" => 218),
				BX_RESIZE_IMAGE_EXACT
			);
			$picHover = $file->ShowImage($renderImage['src'], 230, 218, 'alt="' . $alt . '"');
		}
		else
		{
			$picHover = $pic;
		}

		?>
		<li class="list__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/Product">

		<a href="<?= $product['DETAIL_PAGE_URL']; ?>" class="fast-view js-product-fast"
		   data-gtm-product-id="<?= $product['EXTERNAL_ID'] ?>" data-fancy="<?= $product['DETAIL_PAGE_URL']; ?>?fv">быстрый просмотр</a>

		<div class="product-item" data-href="<?= $product['DETAIL_PAGE_URL']; ?>"
			 data-gtm-product-id="<?= $product['EXTERNAL_ID'] ?>">
			<div class="product-item__pic-wrap">
				<div class="product-item__pic-wrap__preview"><?= $pic ?></div>
				<div class="product-item__pic-wrap__hover"><?= $picHover ?></div>
			</div><?

			if ($product['FLAGS']['HIT']) {
				?><p class="product-item__status">Хит</p><?
			}
			elseif ($product['FLAGS']['NEW']) {
				?><p class="product-item__status">New</p><?
			}
			elseif ($product['FLAGS']['SALE']) {
				?><p class="product-item__status">Sale</p><?
			}
			?>
			<div class="product-item__main">
				<p class="product-item__brand" itemprop="brand"><?= $product['BRAND'] ?></p>

				<p class="product-item__title" itemprop="name">
					<a itemprop="url" href="http://<?= $_SERVER['HTTP_HOST'].$product['DETAIL_PAGE_URL'] ?>" itemprop="url"><?= $product['NAME'] ?></a>
				</p>

				<div class="product-item__descr" itemprop="description">
					<p style="display:none;"><?=strip_tags($product['DESCRIPTION'])?></p>
				</div>
				<div class="product-item__offers" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<meta itemprop="price" content="<?=$product['PRICE']?>" />
					<meta itemprop="priceCurrency" content="RUB" />
					<link itemprop="availability" href="http://schema.org/<?=($product['STOCKS']['DELIVERY_AVAIL'] || ($fromShopsDeliveryAvail && ($product['STOCKS']['RETAIL'] > 0 || $product['STOCKS']['PICKUP_AVAIL']))) ? "InStock" : "OutOfStock"?>" />
					<?
					if ($product['PRICE'] > 1)
					{
						if ($product['PRICE'] < $product['OLD_PRICE'])
						{
							?>
							<span class="product-item__price-old"><?
							?><span class="product-item__price__num"><?= $product['OLD_PRICE'] ?></span><?
							?><span class="valuta">p</span><?
							?></span><?
						}

						?>
						<span class="product-item__price"><?
						?><span class="product-item__price__num"><?= $product['PRICE'] ?></span><?
						?><span class="valuta">p</span>
						</span><?
					}
					?>
					<p class="good_icons">			
						<?						
						if ($product['STOCKS']['PICKUP_AVAIL'])
						{
							?><span title="Забрать в магазине" class="delivery_text">самовывоз</span><?
						}
						if ($product['STOCKS']['DELIVERY_AVAIL'] || ($fromShopsDeliveryAvail && ($product['STOCKS']['RETAIL'] > 0 || $product['STOCKS']['PICKUP_AVAIL'])))
						{
							?><br/><span title="Доставка" class="delivery_text">доставка</span><?
						}
						?>
					</p>
				</div>				
			</div>
			<div style="height:15px;"></div>
			<div class="product-item__overlay">
				<div class="product-item__overlay__inside">

				</div>
			</div>
		</div>
		</li><?
	}
	?>
</ul><?

// Google Tag Manager data
global $GTM_DATA_LAYER;
$GTM_DATA_LAYER['PAGE_CATEGORY'] = 'categoryPage';
$GTM_DATA_LAYER['ECOMMERCE']['currencyCode'] = 'RUR';
$index = count($GTM_DATA_LAYER['ECOMMERCE']['impressions']) + 1;
foreach ($arResult['PRODUCTS']['ITEMS'] as $item)
{
	if ($item['SECTION'])
	{
		$GTM_DATA_LAYER['SECTION_IDS'][] = $item['SECTION'];
	}

	$gtmId = $item['EXTERNAL_ID'];
	$impression = array(
		'name' => $item['NAME'],
		'id' => $gtmId,
		'list' => 'search_result',
		'price' => number_format($item['PRICE'], 2, '.', ''),
		'brand' => $item['BRAND'],
		'variant' => '',  // намеренно оставлено пустым
		'category' => '',  // намеренно оставлено пустым
		'categoryId' => $item['SECTION'],
		'position' => $index
	);
	$index++;

	$GTM_DATA_LAYER['ECOMMERCE']['impressions'][] = $impression;
	if (isset($GTM_DATA_LAYER['ITEMS'][$gtmId]))
	{
		continue;
	}

	$GTM_DATA_LAYER['ITEMS'][$gtmId] = $impression;
}
?>
<script>
	$(function () {
		$.extend(window.dataLayerItems, <?=CUtil::PhpToJSObject($GTM_DATA_LAYER['ITEMS'])?>);
	});
</script><?

// TODO: скрипт вынести отдельно в js
?>
<!-- Google Tag Manager -->
<script>
	(function (window) {
		if (typeof window.dataLayer !== 'undefined') {
			$('.product-item[data-gtm-product-id]').on('click', function (e) {
				var this_$ = $(this), product_id = this_$.data('gtm-product-id'), href = this_$.data('href');
				if (typeof product_id === 'undefined' || typeof window.dataLayerItems !== 'object') {
					return true;
				}
				var product = window.dataLayerItems[product_id];
				if (typeof product === 'undefined') {
					return true;
				}
				e.stopImmediatePropagation();
				window.dataLayer.push({
					event: 'productClick',
					ecommerce: {
						click: {
							actionField: {
								list: 'search_result'
							},
							products: [product]
						},
					},
					eventCallback: function() {
						window.document.location = href;
					}
				});
			});
			$('.fast-view[data-gtm-product-id]').on('click', function () {
				var this_$ = $(this), product_id = this_$.data('gtm-product-id');
				if (typeof product_id === 'undefined' || typeof window.dataLayerItems !== 'object') {
					return true;
				}
				var product = window.dataLayerItems[product_id];
				if (typeof product === 'undefined') {
					return true;
				}
				var product_list = product.list;
				delete product.list;
				window.dataLayer.push({
					ecommerce: {
						detail: {
							products: [product]
						},
						click: {
							actionField: {
								list: product_list
							},
							products: [product]
						}
					},
					event: 'productView'
				});
			});

		}
	}) (window);
</script><?

$page = $arResult['PRODUCTS']['DB_RESULT']->NavPageNomer;
if ($page < $arResult['PRODUCTS']['DB_RESULT']->NavPageCount)
{
	$href = $APPLICATION->GetCurPageParam('page=' . ($page + 1), array('page'));
	?><div class="btn-wrap btn-wrap_center">
	<span id="load-catalog-items" class="btn-more" data-href="<?= $href ?>">Загрузить еще</span>
	</div><?
}

if ($arResult['PRODUCTS']['DB_RESULT'])
{
	$navString = $arResult['PRODUCTS']['DB_RESULT']->GetPageNavStringEx($navComponentObject, '', 'streetbeat', 'Y');
	echo $navString;
}
