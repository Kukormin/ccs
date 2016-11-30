<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */

$filter = array(
	'CATEGORY' => array($arParams['CATEGORY'] => true),
);
$sort = array(
	'sort' => 'asc',
);
$nav = array(
	'nTopCount' => 15
);
$data = \Local\Catalog\Products::getDataByFilter($filter);
$result = \Local\Catalog\Products::get($sort, $data['IDS'], $nav);
$products = $result['ITEMS'];

if (!$products)
	return;

?>
<div class="b-content-center b-slider-about-novelty">
	<div class="b-title b-title--border-middle">
		<div class="b-title__item b-title__item--grey">
			<span class="b-mod--about-novelty__item-img">
				У нас есть много вкусных сладостей
			</span>
		</div>
	</div>
	<div class="b-slider-wrap-about-novelty" id="related-products"><?

		foreach ($products as $item) {
			?>
			<div class="b-slider__item">
				<div class="b-mod__item b-mod__item-about-novelty">
					<div class="b-mod__item-img">
						<div class="b-mod__item-img--effect-transform">
							<a href="<?= $item['DETAIL_PAGE_URL'] ?>">
								<img src="<?= $item['PREVIEW_PICTURE'] ?>"
								     alt="<?= $item['PIC_ALT'] ?>" title="<?= $item['PIC_TITLE'] ?>" />
							</a>
						</div><?


						$label = '';
						$class = '';
						if ($item['ACTION'])
						{
							$label = 'акция';
							$class = ' b-mod__item-label--discont';
						}
						elseif ($item['NEW'])
							$label = 'новинка';
						elseif ($item['HIT'])
							$label = 'хит';

						if ($label)
						{
							?>
							<div class="b-mod__item-label<?= $class ?>"><?= $label ?></div><?
						}

						?>
					</div>
					<div class="b-mod__item-title">
						<a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['TITLE'] ?></a>
						<span><?= $item['NAME'] ?></span>
					</div>
					<div class="b-mod__item-price"><?

						if ($item['PRICE_WO_DISCOUNT'] > $item['PRICE'])
						{
							?>
							<em><?= number_format($item['PRICE_WO_DISCOUNT'], 0, '', ' ') ?></em><?
						}
						?>
						<?= number_format($item['PRICE'], 0, '', ' ') ?> P<?

						if ($item['PRICE_COUNT'])
						{
							?>
							<span>/ <?= $item['PRICE_COUNT'] ?> шт</span><?
						}

						?>
					</div>

				</div>
			</div><?
		}

		?>
	</div>
</div><?