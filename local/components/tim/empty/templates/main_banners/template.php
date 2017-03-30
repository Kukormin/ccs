<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$main = \Local\Media\Banners::getBySectionCode('main_slider');
$right = \Local\Media\Banners::getBySectionCode('main_right', 2);

if (!$main && !$right)
	return;

$file = new CFile();

?>
<div class="b-content-center">
	<div class="carousel-block"><?

		// Большой слайдер
		?>
		<div class="carousel-main"><?

			foreach ($main as $item)
			{
				$pic = $file->ResizeImageGet(
					$item['PICTURE'],
					array('width' => 770, 'height' => 485),
					BX_RESIZE_IMAGE_PROPORTIONAL,
					true
				);

				?>
				<div class="carousel-main-row">
					<a href="<?= $item['LINK'] ?>">
						<div style="background-image: url('<?= $pic['src']?>'); width: 100%; height: 100%;">
							<div class="details">
								<h3><?= $item['NAME'] ?></h3>
								<p><?= $item['TEXT'] ?></p>
							</div>
						</div>
					</a>
				</div><?
			}

			?>
		</div><?

		// Баннеры справа
		?>
		<div class="carousel-thumbs"><?

			foreach ($right as $item)
			{
				$pic = $file->ResizeImageGet(
					$item['PICTURE'],
					array('width' => 370, 'height' => 230),
					BX_RESIZE_IMAGE_PROPORTIONAL,
					true
				);

				?>
				<div class="carousel-thumbs-row">
					<a href="<?= $item['LINK'] ?>"><img src="<?= $pic['src'] ?>" alt="<?= $item['NAME'] ?>">
						<div class="details">
							<h3><?= $item['NAME'] ?></h3>
							<p><?= $item['TEXT'] ?></p>
						</div>
					</a>
				</div><?
			}

			?>
		</div><?

		?>
	</div>
</div>