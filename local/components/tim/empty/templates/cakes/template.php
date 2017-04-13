<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$items = \Local\Media\Cakes::getAll();
$file = new \CFile();

?>
<div id="cake_slider_wp">
	<div id="cake_slider"><?
		foreach ($items as $item)
		{
			$img = $file->ResizeImageGet(
				$item['PICTURE'],
				array(
					'width' => 600,
					'height' => 600
				),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				true
			);

			?>
			<div class="cs-item"><img src="<?= $img['src'] ?>" /></div><?
		}
		?>
	</div>
</div><?