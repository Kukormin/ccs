<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @var Local\Catalog\TimCatalog $component */

//
// Постраничка
//
$iCur = $component->products['NAV']['PAGE'];
if ($iCur == 'all')
	return;

$iEnd = ceil($component->products['NAV']['COUNT'] / $component::PAGE_SIZE);

if ($iEnd <= 1)
	return;

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

$url = $component->filter['URL'];
if (strpos($url, '?') !== false)
	$urlPage = $url . '&page=';
else
	$urlPage = $url . '?page=';

?>
<div class="js-catalog-pager">
<div class="b-content-center b-pagination b-title--border-top">
	<a href="<?= $urlPage ?>all" class="show_all_btn">Показать все</a>
	<ul class="b-pagination__list"><?

		if ($iCur > 1) {
			if ($iCur == 2)
				$href = $url;
			else
				$href = $urlPage . ($iCur-1);
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
			$href = $url;
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
					$href = $url;
				else
					$href = $urlPage . $i;
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

			$href = $urlPage . $iEnd;
			?>
			<li class="b-pagination__item">
			<a class="b-pagination_link" href="<?= $href ?>" data-page="<?= $iEnd ?>"><?= $iEnd ?></a>
			</li><?
		}
		if ($iCur < $iEnd) {
			$href = $urlPage . ($iCur+1);
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
