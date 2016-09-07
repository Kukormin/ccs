<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
foreach($arResult["ALL_ITEMS"] as $arColumns):?>
    <li class="b-bottom-nav__item <?=strpos($APPLICATION->GetCurPage(), $arColumns["LINK"])===0?'active':'';?>"><a href="<?=$arColumns["LINK"]?>" <?if(!empty($arColumns["PARAMS"]["IMG"])) {?> style="background: url(<?=$arColumns["PARAMS"]["IMG"]?>) no-repeat center top;" <? } ?>class="b-bottom-nav__link"><?=$arColumns["TEXT"]?></a></li>
<?endforeach;?>
