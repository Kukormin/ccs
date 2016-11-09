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

\Local\Utils\Remarketing::setPageType('category');

?>
<div class="b-catalog-wrap--cupcake js-ajax-content-block">
	<h1><? $APPLICATION->ShowTitle(false) ?></h1><?

	if ($filter['CUR_FILTERS'])
	{
		?>
		<div id="current-filters"><?

			foreach ($filter['CUR_FILTERS'] as $item)
			{
				?>
				<span><?= $item['NAME'] ?> <a href="<?= $item['HREF'] ?>">x</a></span><?
			}

			?>
		</div><?
	}

	?>
	<div class="b-mod-catalog--cupcake">


		<?
		if (count($products) <= 0)
		{
			?>
			<p class="b-mod-catalog--cupcake--empty">Товары для этого раздела пока готовятся, пожалуйста, зайдите
				немного позже :)</p><?
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
					<div class="basket-button" data-id="<?= $item['ID'] ?>"></div>
				</div>
				<div class="b-mod__item-title">
					<a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['TITLE'] ?></a>
					<span><?= $item['NAME'] ?></span>
				</div>
				<div class="b-mod__item-price"><?

					if ($item['PRICE_D'] > $item['PRICE'])
					{
						?>
						<em><?= number_format($item['PRICE_D'], 0, '', ' ') ?></em><?
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
				$href = $APPLICATION->GetCurPageParam('page=1', array('page'));
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
			//TODO: seo тут
			?>здесь будет сео текст<?
			/*$desc = CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "DESCRIPTION");
			if ($desc != '' && $_REQUEST['SECTION_CODE'] == '')
				echo $desc;
			else
			{
				$rsSections = CIBlockSection::GetList(array(), array(
					'IBLOCK_ID' => $arResult['IBLOCK_ID'],
					'CODE' => $_REQUEST['SECTION_CODE']
				));
				if ($arSection = $rsSections->Fetch())
				{
					echo $arSection['DESCRIPTION'];
				}
			}*/
		}
		?>
	</div><?

?>
</div>
<!--end b-catalog-wrap--cupcake-->
<div class="b-content-center b-content-center--bottom i-padding-vert-30">
	<a href="#" class="b-scroll-to-top b-scroll-to-top--catalog">
		наверх
	</a>
</div>
<?




return;














	?>
	<div class="aside aside_left">
	<aside itemscope="" itemtype="http://schema.org/WPSideBar">
	<div class="filter-smart">
	<?

	// ==============================================================================
	// Панель фильтров
	// ==============================================================================
	?>
	<!--noindex-->
	<form class="form form-filter" id="form-filter-form" action="<?= $arResult['FILTER']['CATALOG_PATH'] ?>"
	      method="get" accept-charset="utf-8"><?

		if ($arResult['QUERY'])
		{
			?><input type="hidden" name="q" value="<?= $arResult['QUERY'] ?>" /><?
		}

		//
		// Свойства
		//
		foreach ($arResult['FILTER']['GROUPS'] as $groupName => $group)
		{

			if (!$group['FCNT'])
				continue;
			if ($group['HIDDEN'] && !$isAdmin)
				continue;

			$active = $group['COLLAPSED'] ? '' : ' aside__section-item_active';
			$style = $group['COLLAPSED'] ? ' style="display:none;"' : '';

			?>
			<div class="aside__section-item<?= $active ?>"><?

			// Заголовок группы, который можно свернуть
			?><p class="aside__section-item__title"><?= $groupName ?></p><?

			$firstProp = $group['PROPS'][0];
			if ($firstProp['CODE'] == 'MAIN_COLOR')
				$list_inline = ' list_inline list_color';
			elseif ($firstProp['CODE'] == 'SIZE')
				$list_inline = ' list_choice list_inline list_size';
			else
				$list_inline = ' list_choice';
			?>
			<div class="aside__section-item__main"<?= $style ?>><?

			// Для цен своя верстка
			if ($firstProp['CODE'] == 'PRICE')
			{
				$min = intval($firstProp['VARS']['FMIN']);
				$max = intval($firstProp['VARS']['FMAX']);
				$from = isset($firstProp['VARS']['FROM']) ? intval($firstProp['VARS']['FROM']) : $min;
				$to = isset($firstProp['VARS']['TO']) ? intval($firstProp['VARS']['TO']) : $max;
				if ($from < $min)
					$from = $min;
				if ($to > $max)
					$to = $max;

				?>
				<div class="formCost">
					<div class="sliderCont">
						<div id="slider" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content props">
							<div class="ui-slider-range ui-widget-header"></div>
							<a class="ui-slider-handle ui-state-default handle-l">
												<span class="ui-slider__price-val"><?
													$disabled = $from <= $min ? ' disabled' : '';
													?><input type="text" name="priceFrom" id="minCost"
												             value="<?= $from ?>"<?= $disabled ?> /><?
													?></span>
							</a>
							<a class="ui-slider-handle ui-state-default handle-r">
												<span class="ui-slider__price-val"><?
													$disabled = $to >= $max ? ' disabled' : '';
													?><input type="text" name="priceTo" id="maxCost"
												             value="<?= $to ?>"<?= $disabled ?> /><?
													?></span>
							</a>
						</div>
					</div>
					<span class="ui-slider__min-val"><?= $min ?> p</span>
					<span class="ui-slider__max-val"><?= $max ?> p</span>
				</div>
				<script type="text/javascript">
					var jqSlider = $("#slider");
					var jqMinCost = $("input#minCost");
					var jqMaxCost = $("input#maxCost");
					jqSlider.slider({
						min: <?= $min ?>,
						max: <?= $max ?>,
						values: [<?= $from ?>, <?= $to ?>],
						range: true,
						change: function (event, ui) {
							jqMinCost.get(0).form.submit();
						},
						stop: function (event, ui) {
							var from = ui.values[0];
							var to = ui.values[1];
							jqMinCost.val(from);
							jqMaxCost.val(to);
							jqMinCost.prop('disabled', from <= <?= $min ?>);
							jqMaxCost.prop('disabled', to >= <?= $max ?>);
						},
						slide: function (event, ui) {
							var from = ui.values[0];
							var to = ui.values[1];
							if (to - from < 200) {
								return false;
							} else {
								jqMinCost.val(from);
								jqMaxCost.val(to);
							}
						}
					});
				</script><?
			}
			else
			{
				?>
				<ul class="list list_flat<?= $list_inline ?> props"><?
				// Свойства и варианты свойств получились на одном уровне
				// (в зависимости от типа свойства)
				foreach ($group['PROPS'] as $prop)
				{
					if (!$prop['FCNT'])
						continue;
					if ($prop['ADD']['HIDDEN'] == 'Y' && !$isAdmin)
						continue;

					foreach ($prop['VARS'] as $variant)
					{
						if (!$variant['FCNT'])
							continue;

						// Пропускаем нулевые варианты чекбоксов
						if ($prop['USER_TYPE'] == 'SASDCheckboxNum' && $variant['VALUE'] == 0)
						{
							continue;
						}

						$name = $prop['ADD']['URL_PARAM'];
						if ($prop['MULTI'])
						{
							$name .= '[]';
						}

						// Нажатый или нет
						if ($variant['CHECKED'])
						{
							$label = ' class="act"';
							$span = ' active';
							$checked = ' checked';
							$selected = ' list__item_selected';
						}
						else
						{
							$label = '';
							$span = '';
							$checked = '';
							$selected = '';
						}

						// Для цветов верстка немного отличается
						if ($prop['CODE'] == 'MAIN_COLOR')
						{
							?>
						<li class="list__item<?= $selected ?>" style="background:<?= $variant['ADD']['BG'] ?>;">
							<div class="color-item" title="<?= $variant['NAME'] ?>">
								<input type="checkbox" class="form__checkbox"
								       name="<?= $name ?>"
								       value="<?= $variant['ID'] ?>"
								       onclick="this.form.submit();"<?= $checked ?> />
							</div>
							</li><?
						}
						else
						{
							?>
							<li class="list__item">
							<div class="choice-item small-check">
								<label<?= $label ?>>
														<span class="wrap-checkbox<?= $span ?>"><?
															?><input type="checkbox" class="form__checkbox"
														             name="<?= $name ?>"
														             value="<?= $variant['ID'] ?>"
														             onclick="this.form.submit();"<?= $checked ?> /><?
															?></span><?
									echo $variant['NAME'];
									/* Теперь решили вообще убрать количество
									// ! Костыль. Для размеров не выводим количество вариантов
									if ($prop['CODE'] != 'SIZE')
									{
										?> <i>(<?= $variant['FCNT'] ?>)</i><?
									}
									?></label>*/
									?>
							</div>
							</li><?
						}
					}
				}
				?></ul><?
			}
			?></div>
			</div><?
		}

		$disabled = $arResult['FILTER']['PROPS_FILTERED_COUNT'] ? '' : ' class="btn-disabled"';
		?>
		<a<?= $disabled ?> href="<?= $arResult['FILTER']['CATALOG_PATH'] ?>">
			<span class="btn btn_decor btn_width-100">сбросить фильтры</span>
		</a><?
		?>
	</form>
	<!--/noindex-->

	</div>
	</aside>
	<?
	if (!empty($arResult['QUERY']))
	{
		?>
		<div data-retailrocket-markup-block="56bdbd1c5a65882cd4034051" data-argument="<?= $arResult['QUERY']; ?>"
		     data-stock-id="<?= $stock_id; ?>"></div>
	<?
	}
	else
	{
		?>
		<div data-retailrocket-markup-block="56bdbd2c9872e510dcd6fe9d" data-stock-id="<?= $stock_id; ?>"></div>
	<?
	}
	?>
	</div>
<?


// =============================================================
// Cписок товаров
// =============================================================
?>
	<div class="catalog" itemscope itemtype="http://schema.org/ItemList">
		<? if (isset($arResult['SEO']['DETAIL_PICTURE']))
		{ ?>
			<img src="<?= $arResult['SEO']['DETAIL_PICTURE'] ?>"/>
		<? } ?>
		<h1 itemprop="name"><? $APPLICATION->ShowTitle(false) ?></h1>

		<link itemprop="url" href="http://street-beat.ru<?= $arResult['FILTER']['SEF_URL'] ?>"/>
		<meta itemprop="numberOfItems" content="<?= $arResult['PRODUCTS']['DB_RESULT']->NavRecordCount ?>"/>

		<div class="filter i-clfx"><?

			//
			// Сортировка
			//
			?>
			<div class="filter__left">
				<span class="filter__title">Сортировать по:</span>

				<div class="g-nav g-nav_filter g-nav_filter_sort">
					<nav role="navigation">
						<ul id='sort' class="g-nav__inner "><?
							foreach ($arResult['SORT'] as $key => $sort)
							{
								if ($sort['ORDER'] == 'desc')
								{
									$order = 'asc';
									$arrow = ' g-nav__item_down';
								}
								elseif ($sort['ORDER'] == 'asc')
								{
									$order = 'desc';
									$arrow = ' g-nav__item_up';
								}
								else
								{
									$order = $sort['ORDER_DEFAULT'];
									$arrow = $order == 'asc' ? ' g-nav__item_up' : ' g-nav__item_down';
								}
								if ($sort['FIELD'] == 'SORT')
								{
									$arrow = '';
								}
								$active = $sort['ORDER'] ? ' g-nav__item_active' : '';
								$href = $APPLICATION->GetCurPageParam('sort=' . $key . '&order=' . $order, array(
										'sort',
										'order'
									));
								?>
								<li class="g-nav__item<?= $arrow ?><?= $active ?>"><?
								?><a class="g-nav__ln" href="<?= $href ?>"><?= $sort['NAME'] ?></a><?
								?></li><?
							}
							?></ul>
					</nav>
				</div>
			</div><?

			//
			// Количество элементов на странице
			//
			?>
			<div class="filter__right">
				<span class="filter__title">Показывать по:</span>

				<div class="g-nav g-nav_filter">
					<nav id="pagecount" role="navigation">
						<ul id="count-page" class="g-nav__inner"><?

							$variants = array(
								24,
								48,
								'all'
							);
							foreach ($variants as $size)
							{
								$name = $size == 'all' ? 'Все' : $size;
								$href = $APPLICATION->GetCurPageParam('page_size=' . $size, array('page_size'));
								$active = $arResult['PAGE']['ELEMENTS_ON_PAGE'] == $size ? ' g-nav__item_active' : '';
								?>
								<li class="g-nav__item<?= $active ?>"><?
								?><a class="g-nav__ln" href="<?= $href ?>"><?= $name ?></a><?
								?></li><?
							}

							?></ul>
					</nav>
				</div>
			</div>
		</div>

		<div id="catalog-wrap"><?

			// ====================================================================
			// Товары
			//
			include('products.php');
			//
			// ====================================================================

			?></div><?

		if ($arResult['SEO']['TEXT'])
		{
			?>
			<div><?= $arResult['SEO']['TEXT'] ?></div><?
		}
		?></div>
<?

if ($arResult['SEO']['H1'])
	$APPLICATION->SetTitle($arResult['SEO']['H1']);
if ($arResult['SEO']['TITLE'])
	$APPLICATION->SetPageProperty('title', $arResult['SEO']['TITLE']);
if ($arResult['SEO']['DESCRIPTION'])
	$APPLICATION->SetPageProperty('description', $arResult['SEO']['DESCRIPTION']);
if ($arResult['SEO']['KEYWORDS'])
	$APPLICATION->SetPageProperty('keywords', $arResult['SEO']['KEYWORDS']);

foreach ($arResult['FILTER']['BC'] as $item)
	$APPLICATION->AddChainItem($item['NAME'], $item['HREF']);

if ($APPLICATION->GetCurPage() == "/cat/new/" || $APPLICATION->GetCurPage() == "/cat/sale/")
	$APPLICATION->AddChainItem($arResult['SEO']['H1'], "");

if ($_REQUEST['page'] > 0)
{
	$pageNum = (int)$_REQUEST['page'];
	$pagerTitle = $APPLICATION->GetProperty('title');
	$pagerTitle .= ' - Страница ' . $pageNum;
	$APPLICATION->SetPageProperty('title', $pagerTitle);
}