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

			$showBtn = \Local\Catalog\Suspended::check($item['ID']);
			if ($showBtn)
			{
				?>
				<div class="quick-detail" data-id="<?= $item['ID'] ?>"></div><?
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
		</div><?
	}
	?>
</div><?

//=========================================================
// Постраничка
//
include('pager.php');
//=========================================================
//

?>
<div class="new_descr"><?
	// Описание выводим только на первой странице.
	if ($component->navParams['iNumPage'] == 1)
	{
		echo $component->seo['TEXT'];
	}
	?>
</div><?