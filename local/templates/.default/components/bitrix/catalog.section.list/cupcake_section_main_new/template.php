<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

foreach ($arResult['SECTIONS'] as &$arSection) {
    if($arSection['UF_DISPLAY_MAIN'] == 1 && !empty($arSection['PICTURE']['SRC'])) { ?>
        <div class="b-mod__item b-mod__item--cupcake">
            <a href="<?=$arSection['SECTION_PAGE_URL']?>">
            <span class="b-mod__item-img--cupcake b-dimming-effect">
                <img src="<?=$arSection['PICTURE']['SRC']?>" alt="">
                <span class="b-mod__item-text--black">
                    <span class="b-mod__item-text--black-desk"><?=$arSection['DESCRIPTION']?></span>
                    <span class="b-mod__link--text-hover">посмотреть</span>
                </span>
            </span>
            <span class="b-mod__category-name">
                <span> <?=$arSection['NAME']?> </span>
            </span>
            </a>
        </div>
    <? } }?>