<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$dataNew = \Local\Catalog\Products::getDataByFilter(array('NEW' => 'Y'));
$idsNew = $dataNew['IDS'] ? $dataNew['IDS'] : array();

$dataHit = \Local\Catalog\Products::getDataByFilter(array('HIT' => 'Y'));
$idsHit = $dataHit['IDS'] ? $dataHit['IDS'] : array();

$ids = array_merge($idsNew, $idsHit);

$sort = array(
	'sort' => 'asc',
	'created' => 'desc',
);
$nav = array(
	'nTopCount' => 15
);
$result = \Local\Catalog\Products::get($sort, $ids, $nav);
$products = $result['ITEMS'];

if (!$products)
	return;

?>
<div class="b-mod b-mod--novelty">
	<div class="b-slider-wrap-about-novelty" id="related_products_main"><?

		foreach ($products as $item) {
			?>
			<div class="b-slider__item">
				<div class="b-mod__item b-mod__item-about-novelty">
					<div class="b-mod__item-img">
						<div class="b-mod__item-img--effect-transform">
							<a href="<?= $item['DETAIL_PAGE_URL'] ?>">
								<img data-lazy="<?= $item['PREVIEW_PICTURE'] ?>"
								     alt="<?= $item['PIC_ALT'] ?>" title="<?= $item['PIC_TITLE'] ?>" />
							</a>
						</div><?

						$label = '';
						if ($item['NEW'])
							$label = 'новинка';
						elseif ($item['HIT'])
							$label = 'хит';

						if ($label)
						{
							?>
							<div class="b-mod__item-label"><?= $label ?></div><?
						}

						?>
					</div>
					<div class="b-mod__item-title">
						<a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['NAME'] ?></a>
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