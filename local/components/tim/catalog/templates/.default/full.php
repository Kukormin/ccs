<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var Local\Catalog\TimCatalog $component */

$filter = $component->filter;
$products = $component->products['ITEMS'];

?>
<section class="b-topblock b-topblock--pay-ship">
</section>

<section class="b-bg-grey">
<div class="b-content-center b-content-center--cupcake b-content-center--cupcake-catalog">
<div id="bc"><?

	//=========================================================
	include('bc.php');
	//=========================================================

	?>
</div>

<div id="filters-panel">
	<input type="hidden" name="q" value="<?= $component->searchQuery ?>">
	<input type="hidden" name="catalog_path" value="<?= $filter['CATALOG_PATH'] ?>">
	<input type="hidden" name="separator" value="<?= $filter['SEPARATOR'] ?>"><?

	$closed = array(0, 1, 1, 1, 1, 1, 1);
	if (isset($_COOKIE['filter_groups']))
		$closed = explode(',', $_COOKIE['filter_groups']);

	$i = 0;
	foreach ($filter['GROUPS'] as $group)
	{
		$style = $closed[$i] ? ' style="display:none;"' : '';
		$class = $closed[$i] ? ' closed' : '';
		?>
		<div class="filter-group<?= $class ?>">
			<h3><?= $group['NAME'] ?><s></s></h3><?

			if ($group['TYPE'] == 'price')
			{
				$from = $group['FROM'] ? $group['FROM'] : $group['MIN'];
				$to = $group['TO'] ? $group['TO'] : $group['MAX'];
				?>
				<div class="price-group"<?= $style ?>>
					<div class="inputs">
						<div class="l">от <input type="text" id="from" value="<?= $from ?>"/></div>
						<div class="r">до <input type="text" id="to" value="<?= $to ?>" /></div>
					</div>
					<div id="price_slider" data-from="<?= $from ?>" data-to="<?= $to ?>"
					     data-min="<?= $group['MIN'] ?>" data-max="<?= $group['MAX'] ?>"></div>
				</div><?
			}
			else
			{
				?>
				<div<?= $style ?>>
					<ul><?

						foreach ($group['ITEMS'] as $code => $item)
						{
							$style = '';//$item['CNT'] ? '' : ' style="display:none;"';
							$class = '';
							if (!$item['CNT'] && $item['CHECKED'])
								$class = ' class="checked disabled"';
							elseif ($item['CHECKED'])
								$class = ' class="checked"';
							elseif (!$item['CNT'])
								$class = ' class="disabled"';
							$checked = $item['CHECKED'] ? ' checked' : '';
							$disabled = $item['CNT'] ? '' : ' disabled';

							?>
							<li<?= $class ?><?= $style ?>>
								<b></b><label>
									<input type="checkbox" name="<?= $code ?>"<?= $checked ?><?= $disabled ?> />
									<?= $item['NAME'] ?> (<i><?= $item['CNT'] ?></i>)
								</label>
							</li><?
						}

						?>
					</ul>
				</div><?
			}
			?>
		</div><?

		$i++;
	}
	?>
</div><?

$cnt = $filter['CHECKED_CNT'] ? '(' .  $filter['CHECKED_CNT'] . ')' : '';
?>
<div id="mobile-filters" class="closed">
	<h3><b></b><s></s>Фильтры <i><?= $cnt ?></i></h3>
	<div class="ws"></div>
	<div class="wnd" style="display:none;">
		<div id="mf-cont">
			<ul><?

				$i = 0;
				foreach ($filter['GROUPS'] as $group)
				{
					$style = '';//$group['CNT'] ? '' : ' style="display:none;"';
					$i++;
					$cnt = $group['CHECKED_CNT'] ? '(' .  $group['CHECKED_CNT'] . ')' : '';
					?>
					<li data-id="<?= $i ?>"<?= $style ?>><s></s><?= $group['NAME'] ?> <i><?= $cnt ?></i></li><?
				}

				?>
			</ul><div class="level2"><?

				$i = 0;
				foreach ($filter['GROUPS'] as $group)
				{
					$i++;
					?>
					<div id="mfg<?= $i ?>" class="mfg" style="display:none;">
						<span>Очистить</span>
						<h4><?= $group['NAME'] ?></h4><?

						if ($group['TYPE'] == 'price')
						{
							$from = $group['FROM'] ? $group['FROM'] : $group['MIN'];
							$to = $group['TO'] ? $group['TO'] : $group['MAX'];
							?>
							<div class="price-group">
								<div class="inputs">
									<div class="l">от <input type="text" id="mfrom" value="<?= $from ?>"/></div>
									<div class="r">до <input type="text" id="mto" value="<?= $to ?>" /></div>
								</div>
								<div id="mprice_slider" data-from="<?= $from ?>" data-to="<?= $to ?>"
								     data-min="<?= $group['MIN'] ?>" data-max="<?= $group['MAX'] ?>"></div>
							</div><?
						}
						else
						{
							?>
							<ul><?

							foreach ($group['ITEMS'] as $code => $item)
							{
								$style = '';//$item['CNT'] ? '' : ' style="display:none;"';
								$class = '';
								if (!$item['CNT'] && $item['CHECKED'])
									$class = ' class="checked disabled"';
								elseif ($item['CHECKED'])
									$class = ' class="checked"';
								elseif (!$item['CNT'])
									$class = ' class="disabled"';
								$checked = $item['CHECKED'] ? ' checked' : '';
								$disabled = $item['CNT'] ? '' : ' disabled';

								?>
								<li<?= $class ?><?= $style ?>>
									<input type="checkbox" data-code="<?= $code ?>"<?= $checked ?><?= $disabled ?> />
									<?= $item['NAME'] ?> (<i><?= $item['CNT'] ?></i>)
								</li><?
							}

							?>
							</ul><?
						}
						?>
					</div><?
				}

				?>
			</div>
		</div>
	</div>
</div><?

?>
<div class="b-catalog-wrap--cupcake js-ajax-content-block"><?

	//=========================================================
	include('products.php');
	//=========================================================

	?>
</div>

<div class="b-content-center b-content-center--bottom i-padding-vert-30">
	<a href="#" class="b-scroll-to-top b-scroll-to-top--catalog">
		наверх
	</a>
</div>

</div>
</section><?

\Local\Utils\Remarketing::setPageType('category');

if ($component->navParams['iNumPage'] > 1)
	$component->seo['TITLE'] .= ' - страница ' . $component->navParams['iNumPage'];

if ($component->seo['TITLE'])
	$APPLICATION->SetPageProperty('title', $component->seo['TITLE']);
if ($component->seo['DESCRIPTION'])
	$APPLICATION->SetPageProperty('description', $component->seo['DESCRIPTION']);
