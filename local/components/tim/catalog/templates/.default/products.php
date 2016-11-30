<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @var Local\Catalog\TimCatalog $component */

?><h1><?= $component->seo['H1'] ?></h1><?

if ($filter['CUR_FILTERS'])
{
	?>
	<div id="current-filters"><?

	foreach ($filter['CUR_FILTERS'] as $item)
	{
		?><span><a href="<?= $item['HREF'] ?>"></a><?= $item['NAME'] ?></span><?
	}

	?>
	</div><?
}

?>
<div id="products-cont" class="b-mod-catalog--cupcake">


	<?
	if (count($products) <= 0)
	{
		?>
		<p class="b-mod-catalog--cupcake--empty">Не найдено ни одного подходящего товара. Попробуйте отключить
			какой-нибудь фильтр</p><?
	}

	foreach ($products as $id => $item) {

		?>
		<div class="b-mod__item">
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
			<div class="quick-detail" data-id="<?= $item['ID'] ?>"></div>
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
		</div><?
	}
	?>
</div><?

//
// Постраничка
//
$iCur = $component->products['NAV']['PAGE'];
$iEnd = ceil($component->products['NAV']['COUNT'] / $component::PAGE_SIZE);

if ($iEnd > 1) {
	$iStart = $iCur - 2;
	$iFinish = $iCur + 2;
	if ($iStart < 1) {
		$iFinish -= $iStart - 1;
		$iStart = 1;
	}
	if ($iFinish > $iEnd) {
		$iStart -= $iFinish - $iEnd;
		if ($iStart < 1) {
			$iStart = 1;
		}
		$iFinish = $iEnd;
	}

	?>
	<div class="js-catalog-pager">
	<div class="b-content-center b-pagination b-title--border-top">
		<ul class="b-pagination__list"><?

			if ($iCur > 1) {
				if ($iCur == 2)
					$href = $APPLICATION->GetCurPageParam('', array('page'));
				else
					$href = $APPLICATION->GetCurPageParam('page=' . ($iCur-1), array('page'));
				?>
				<li class="b-pagination__item b-pagination--prev">
				<a class="b-pagination_link" href="<?= $href ?>" data-page="<?= ($iCur-1) ?>"></a>
				</li><?
			}
			else {
				?>
				<li class="b-pagination__item b-pagination--prev">
					<span class="b-pagination_link"></span>
				</li><?
			}
			if ($iStart > 1) {
				$href = $APPLICATION->GetCurPageParam('', array('page'));
				?>
				<li class="b-pagination__item">
				<a class="b-pagination_link" href="<?= $href ?>" data-page="1">1</a>
				</li><?

				if ($iStart > 2) {
					?>
					<li class="b-pagination__item">
						<span class="b-pagination_link">...</span>
					</li><?
				}
			}
			for ($i = $iStart; $i <= $iFinish; $i++) {
				if ($i == $iCur) {
					?>
					<li class="b-pagination__item">
					<span class="b-pagination_link active"><?= $i ?></span>
					</li><?
				}
				else {
					if ($i == 1)
						$href = $APPLICATION->GetCurPageParam('', array('page'));
					else
						$href = $APPLICATION->GetCurPageParam('page=' . $i, array('page'));
					?>
					<li class="b-pagination__item">
					<a class="b-pagination_link" href="<?= $href ?>" data-page="<?= $i ?>"><?= $i ?></a>
					</li><?
				}
			}
			if ($iFinish < $iEnd) {
				if ($iFinish < $iEnd - 1) {
					?>
					<li class="b-pagination__item">
						<span class="b-pagination_link">...</span>
					</li><?
				}

				$href = $APPLICATION->GetCurPageParam('page=' . $iEnd, array('page'));
				?>
				<li class="b-pagination__item">
				<a class="b-pagination_link" href="<?= $href ?>" data-page="<?= $iEnd ?>"><?= $iEnd ?></a>
				</li><?
			}
			if ($iCur < $iEnd) {
				$href = $APPLICATION->GetCurPageParam('page=' . ($iCur+1), array('page'));
				?>
				<li class="b-pagination__item b-pagination--next">
				<a class="b-pagination_link" href="<?= $href ?>" data-page="<?= ($iCur+1) ?>"></a>
				</li><?
			}
			else {
				?>
				<li class="b-pagination__item b-pagination--next">
					<span class="b-pagination_link"></span>
				</li><?
			}

			?>
		</ul>
	</div>
	</div><?

}

?>
<div class="new_descr"><?
	// Описание выводим только на первой странице.
	if ($component->navParams['iNumPage'] == 1)
	{
		echo $component->seo['TEXT'];
	}
	?>
</div><?