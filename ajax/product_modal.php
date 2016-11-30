<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$product = \Local\Catalog\Products::getById($_REQUEST['id']);
if (!$product)
	return;

\Local\Catalog\Products::viewedCounters($product['ID']);

$disc = $product['ACTION'] ? ' b-modal--cupcake-discont' : '';
$select = empty($product['OFFERS']) ? ' without_select' : '';

?>
<div class="b-modal--cupcake<?= $disc ?><?= $select ?> js-modal-window" id="modal_<?= $product['ID'] ?>"
     style="display:block;" data-id="<?= $product['ID'] ?>">
	<a href="#" class="b-modal-add-products">Продолжить покупки</a>
	<span class="b-close-modal">close</span>
	<div class="b-modal--cupcake__wrap js-product">
		<div class="b-modal-cupcake__img-product">
			<img src="<?= $product['PREVIEW_PICTURE'] ?>" alt="<?= $product['NAME'] ?>">
		</div><?

		if ($product['ACTION'])
		{
			?>
			<div class="b-modal-cupcake__date-discont">
				<div class="b-mod__item-label b-mod__item-label--discont">акция</div>
				<?= $product['ACTION_TEXT'] ?>
			</div><?
		}

		$border = $product['ACTION'] ? ' b-modal-border-top' : '';
		?>
		<div class="b-mod__item-title b-modal-cupcake__item-title--white <?= $border ?>">
			<?= $product['NAME'] ?>
		</div>

		<div class="b-block-assortment--select b-modal-cupcake--select"><?

			$price = $product['PRICE'];
			$dPrice = $product['PRICE_WO_DISCOUNT'];
			$offerId = 0;

			if (count($product['OFFERS']))
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
				<div class="b-application-event__form-item">
					<label class="is-color-white" for="count_select_<?= $product['ID'] ?>">Количество</label>
					<div class="b-form-item__input b-form-item__input--select">
						<p class="select_title"><?= $firstCount ?></p>
						<select id="count_select_<?= $product['ID'] ?>" class="js_detail_count"><?
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

		<div class="b-block-modal-cupcake--total"><?

			$action = $dPrice > $price ? '' : ' hide-old-price';
			?>
			<div class="b-old--total-price b-modal-cupcake-total--price js-priceblock<?= $action ?>">
				<div class="b-old-price">
					<span class="v"><?= number_format($dPrice, 0, '', ' ') ?></span>
					<span class="rub">i</span>
				</div>
				<div class="b-new-price">
					<span class="v"><?= number_format($price, 0, '', ' ') ?></span>
					<span class="rub">i</span>
				</div>
			</div>

			<button class="b-bnt-form b-bnt-modal-cupcake--white js-add-to-basket"
			        data-id="<?= $product['ID'] ?>" data-offer="<?= $offerId ?>"
			        data-href="/personal/cart">в корзину</button>

			<button class="b-bnt-form b-bnt-buy-one-click i-margin-left-30 js-buy-fastorder">купить в один клик</button>
		</div>
	</div>
</div>
<?

/*
$category = '';
$cat = CIBlock::GetByID($item['IBLOCK_ID']);
if ($ar_res = $cat->GetNext())
	$category = $ar_res['NAME'];
?>
<script>
	$(document).ready(function () {
		$('.js-modal-tobasket').click(function () {
			if ($('.js-modal-tobasket').html() == 'в корзину') {
				dataLayer.push({
					'event': 'addToCart',
					'ecommerce': {
						'currencyCode': 'RUR',
						'add': {
							'products': [{
								'name': '<?=$item['NAME']?>',
								'id': '<?=$item['ID']?>',
								'price': '<?=$item['MIN_PRICE']['VALUE']?>',
								'category': '<?=$category?>',
								'quantity': parseInt($('.js-modal-counter').html())
							}]
						}
					}
				});
			}
		});
	});
</script>*/