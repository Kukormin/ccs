<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$items = \Local\Catalog\Goodies::get();

if (!$items)
	return;

?>

    <div class="goodies-content"><?

        foreach ($items as $item)
		{
		    $pic = CFile::GetPath($item['PREVIEW_PICTURE']);
		    $ar = explode('#', $item['NAME'], 2);
		    if (count($ar) > 1)
			{
				$name = $ar[0];
				$add = $ar[1];
			}
			else
			{
				$name = $item['NAME'];
				$add = '';
			}
			$price = number_format($item['CATALOG_PRICE_1'], 0, '', ' ');

		    ?>
            <div class="goody-wrapper">
                <table class="goody-item">
                    <tr>
                        <td colspan="3">
                            <div class="goody-item__image"
                                 style="background: url('<?= $pic ?>'); background-size: cover;">
                                <div class="b-price"><div class="price"><?= $price ?> <span class="rub">i</span></div></div>
                                <div class="quick-detail quick-add-cart" data-id="<?= $item['ID'] ?>"
                                     data-href="/personal/cart"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="goody-item__content-left">
                            <span class="goody__name"><?= $name ?></span>
                            <span class="goody_property"><?= $add ?></span>
                        </td>
                        <td class="goody-item__content-mid"></td>
                        <td class="goody-item__content-right">
							<?= $item['CATALOG_WEIGHT'] ?>г / шт.
                        </td>
                    </tr>
                </table>
            </div><?
		}

		?>
        <div class="clr"></div>
    </div><?


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