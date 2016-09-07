<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
shuffle($arResult['ITEMS']);
/*if(isset($_COOKIE['test'])){
    echo "<pre>";
    print_r($arResult);
    die;
}*/
?>
<? if (count($arResult["ITEMS"])) { ?>
<div class="b-slider-stock-wrap">
    <div class="b-slider-stock__list">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <? //if (in_array($_GET['SECTION_ID'], $arItem['PROPERTIES']['DISPLAY_'.$key]['VALUE']) && ($key=='MAIN' || $arItem['PROPERTIES']['DISPLAY_'.$key.'_MAIN']['VALUE'] == 'Да')): ?>
                <a href="<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>">
                    <div class="b-slider-stock__item"
                         style="background: #<?=$arItem['PROPERTIES']['BACKGROUND_COLOR']['VALUE']?> url('<?= $arItem['DETAIL_PICTURE']['SRC'] ?>') no-repeat scroll 100% top/contain">
                        <div class="b-slider-stock__content">
                            <div class="b-slider-stock__title">
                                <?= $arItem['NAME'] ?>
                            </div>
                            <div class="b-slider-stock__text">
                                <?= $arItem['DETAIL_TEXT'] ?>
                            </div>
                        </div>
                    </div>
                </a>
            <? //endif; ?>
        <? endforeach; ?>
    </div>
</div>
<?php } else { ?>
<script type="text/javascript">
    $(function () {$('.b-content-center--cupcake').css('padding-top','45px');});
</script>
<?php } ?>
