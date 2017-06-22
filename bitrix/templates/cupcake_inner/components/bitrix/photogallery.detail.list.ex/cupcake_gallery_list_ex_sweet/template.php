<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$file = new \CFile();

?>
<div class="b-mod b-mod--novelty cake_slider_wp">
<div class="b-slider-wrap-about-novelty cake_slider"><?
    foreach ($arResult['ELEMENTS_LIST'] as $item)
    {
        $img = $file->ResizeImageGet(
            $item['PROPERTIES']['REAL_PICTURE']['VALUE'],
            [
                'width' => 367,
                'height' => 367
            ],
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );

        $imgDetail = $file->ResizeImageGet(
            $item['PROPERTIES']['REAL_PICTURE']['VALUE'],
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
