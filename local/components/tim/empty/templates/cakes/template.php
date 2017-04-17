<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$items = \Local\Media\Cakes::getAll();
$file = new \CFile();

foreach ($items as $section)
{
	?>
	<div class="b-mod b-mod--novelty cake_slider_wp">
		<div class="b-title b-title--border-middle">
			<div class="b-title__item b-title__item--grey">
				<?= $section['NAME'] ?>
			</div>
		</div>
		<div class="b-slider-wrap-about-novelty cake_slider"><?
			foreach ($section['ITEMS'] as $item)
			{
				$img = $file->ResizeImageGet(
					$item['PICTURE1'],
					[
						'width' => 367,
						'height' => 367
					],
					BX_RESIZE_IMAGE_PROPORTIONAL,
					true
				);

				$imgDetail = $file->ResizeImageGet(
					$item['PICTURE'],
					[
						'width' => 800,
						'height' => 800
					],
					BX_RESIZE_IMAGE_PROPORTIONAL,
					true
				);

				?>
				<div class="cs-item js-package-popup" data-featherlight="<?= $imgDetail['src'] ?>"><img src="<?=
				$img['src']
				?>"/></div><?
			}
			?>
		</div>
	</div><?
}