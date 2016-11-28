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
<div class="b-content-center b-content-center--cupcake" style="padding-top: 45px;">
<div id="bc"><?
	$last = count($filter['BC']) - 1;
	foreach ($filter['BC'] as $i => $item)
	{
		if ($i == $last)
		{
			?>
			<span><?= $item['NAME'] ?></span><?
		}
		else
		{
			?>
			<a href="<?= $item['HREF'] ?>"><?= $item['NAME'] ?></a> /<?
		}
	}

?>
</div>

<div id="filters-panel">
	<input type="hidden" name="q" value="<?= $component->searchQuery ?>">
	<input type="hidden" name="catalog_path" value="<?= $filter['CATALOG_PATH'] ?>">
	<input type="hidden" name="separator" value="<?= $filter['SEPARATOR'] ?>"><?

	foreach ($filter['GROUPS'] as $group)
	{
		if (!$group['CNT'])
			continue;

		?>
		<div class="filter-group">
			<h3><?= $group['NAME'] ?></h3><?

			if ($group['TYPE'] == 'price')
			{
				$from = $group['FROM'] ? $group['FROM'] : $group['MIN'];
				$to = $group['TO'] ? $group['TO'] : $group['MAX'];
				?><div id="price_slider" data-from="<?= $from ?>" data-to="<?= $to ?>"
				       data-min="<?= $group['MIN'] ?>" data-max="<?= $group['MAX'] ?>"></div><?
			}
			else
			{
				?>
				<ul><?

					foreach ($group['ITEMS'] as $code => $item)
					{
						if (!$item['CNT'])
							continue;

						$class = '';
						$checked = $item['CHECKED'] ? ' checked' : '';

						?>
						<li<?= $class ?>>
							<label>
								<input type="checkbox" name="<?= $code ?>"<?= $checked ?> />
								<?= $item['NAME'] ?> (<?= $item['CNT'] ?>)
							</label>
						</li><?
					}

				?>
				</ul><?
			}
			?>
		</div><?
	}
	?>
</div><?

/*
?>
<div class="b-mobile-breadcrumbs b-block-mobile-only">
	<div class="mobile_catalog_open">Развернуть каталог</div>
	<div class="cupcake__navigation--mobile"> </div>
	<div class="cupcake__navigation--mobile-wrap">

		<div class="b-grey-wrap-top">
			<div class="b-grey-wrap-top-right">
				<div class="b-grey-wrap-bottom">
					<div class="b-grey-wrap-bottom-right">
						<ul class="b-cupcake__navigation--mobile-first-line__list"><?

							$intCurrentDepth = 1;
							$boolFirst = true;
							$onPath = false;
							$isParentActive = false;
							$isActive = false;
							$path = [];
							foreach ($arResult['SECTIONS'] as &$arSection)
							{
							$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
							$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

							$isActive = $section['ID']==$arSection['ID'];

							if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL'])
							{
								if (0 < $intCurrentDepth)
									echo "\n",str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);
								if($arSection['RELATIVE_DEPTH_LEVEL'] == 2) {
									echo '<ul class="b-cupcake__navigation--mobile-second-line__list '.($onPath||$isParentActive?'open':'').'" '.($onPath||$isParentActive?'style="display:block"':'').'>';
								} elseif ($arSection['RELATIVE_DEPTH_LEVEL'] == 3) {
									echo '<ul class="b-cupcake__navigation--mobile-third-line__list '.($onPath||$isParentActive?'open':'').'" '.($onPath||$isParentActive?'style="display:block"':'').'>';
								}
							}
							elseif ($intCurrentDepth == $arSection['RELATIVE_DEPTH_LEVEL'])
							{
								if (!$boolFirst)
									echo '</li>';
							}
							else
							{
								while ($intCurrentDepth > $arSection['RELATIVE_DEPTH_LEVEL'])
								{
									echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
									$intCurrentDepth--;
								}
								echo str_repeat("\t", $intCurrentDepth-1),'</li>';
							}

							echo (!$boolFirst ? "\n" : ''),str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);

							if($arSection['RELATIVE_DEPTH_LEVEL'] == 1) { ?>
							<li class="b-cupcake__navigation--mobile-first-line__item <?=$isActive?'active':''?>"><a class="b-cupcake__navigation--mobile-first-line__link " href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"];?><? ?></a>
								<?} elseif ($arSection['RELATIVE_DEPTH_LEVEL'] == 2) {?>
							<li class="b-cupcake__navigation--mobile-second-line__item <?=$isActive?'active':''?>"><a class="b-cupcake__navigation--mobile-second-line__link " href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"];?><? ?></a>
								<?} elseif ($arSection['RELATIVE_DEPTH_LEVEL'] == 3) {?>
							<li class="b-cupcake__navigation--mobile-third-line__item <?=$isActive?'active':''?>"><a class="b-cupcake__navigation--mobile-third-line__link " href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"];?><? ?></a>
								<? }

								$intCurrentDepth = $arSection['RELATIVE_DEPTH_LEVEL'];
								$boolFirst = false;

								$onPath = isset($sectionParents[$arSection['ID']]);
								$isParentActive = $isActive || $onPath;
								}
								unset($arSection);
								while ($intCurrentDepth > 1)
								{
									echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
									$intCurrentDepth--;
								}
								if ($intCurrentDepth > 0)
								{
									echo '</li>',"\n";
								}

							?>
						</ul>

					</div>
				</div>
			</div>
		</div>
	</div>
</div><?
*/

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
