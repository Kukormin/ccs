<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$banners = \Local\Media\Banners::getBySectionCode('index_cupcackes');

if (!$banners)
	return;

$file = new CFile();

?>
<div class="b-mod b-mod--cupcake">
	<div class="b-title b-title--border-middle">
		<div class="b-title__item b-title__item--grey">
			КАПКЕЙКИ
		</div>
	</div>
	<div class="home_cupcake-wrap"><?

		foreach ($banners as $item) {

			$pic = $file->ResizeImageGet(
				$item['PICTURE'],
				array('width' => 270, 'height' => 270),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				true
			);

			?>
			<div class="b-mod__item b-mod__item--cupcake">
				<a href="<?= $item['LINK'] ?>">
		            <span class="b-mod__item-img--cupcake b-dimming-effect">
		                <img src="<?= $pic['src']?>" alt="<?= $item['NAME'] ?>">
		                <span class="b-mod__item-text--black">
		                    <span class="b-mod__item-text--black-desk"><?= $item['TEXT'] ?></span>
		                    <span class="b-mod__link--text-hover">посмотреть</span>
		                </span>
		            </span>
		            <span class="b-mod__category-name">
		                <span><?= $item['NAME'] ?></span>
	                </span>
				</a>
			</div><?
		}

		?>
	</div>
</div>