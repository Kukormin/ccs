<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

$hasPages = !($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false));
?>
<div class="js-ajax-pager">
<div class="b-content-center b-pagination <?=$hasPages?'b-title--border-top':''?>">
<? if (!$hasPages) {?>
<? } else { ?>
		<ul class="b-pagination__list">
<?if($arResult["bDescPageNumbering"] === true):?>

	<?if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
		<?if($arResult["bSavePage"]):?>
			<li class="b-pagination__item b-pagination--prev"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" data-page="PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"></a></li>
			<li class="b-pagination__item"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" data-page="PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">1</a></li>
		<?else:?>
			<?if (($arResult["NavPageNomer"]+1) == $arResult["NavPageCount"]):?>
				<li class="b-pagination__item b-pagination--prev"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>" data-page="PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"></a></li>
			<?else:?>
				<li class="b-pagination__item b-pagination--prev"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" data-page="PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"></a></li>
			<?endif?>
			<li class="b-pagination__item"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>" data-page="">1</a></li>
		<?endif?>
	<?else:?>
			<li class="b-pagination__item b-pagination--prev"></li>
			<li class="b-pagination__item"><span class="b-pagination_link active">1</span></li>
	<?endif?>

	<?
	$arResult["nStartPage"]--;
	while($arResult["nStartPage"] >= $arResult["nEndPage"]+1):
	?>
		<?$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;?>

		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
			<li class="b-pagination__item"><span class="b-pagination_link active"><?=$NavRecordGroupPrint?></span></li>
		<?else:?>
			<li class="b-pagination__item b-pagination--prev"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>" data-page="PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$NavRecordGroupPrint?></a></li>
		<?endif?>

		<?$arResult["nStartPage"]--?>
	<?endwhile?>

	<?if ($arResult["NavPageNomer"] > 1):?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class="b-pagination__item b-pagination--prev"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=1" data-page="PAGEN_<?=$arResult["NavNum"]?>=1"><?=$arResult["NavPageCount"]?></a></li>
		<?endif?>
			<li class="b-pagination__item b-pagination--next"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" data-page="PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"></a></li>
	<?else:?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class="b-pagination__item"><span class="b-pagination_link active"><?=$arResult["NavPageCount"]?></span></li>
		<?endif?>
		<li class="b-pagination__item b-pagination--next"><span class="b-pagination_link active"></span></li>
	<?endif?>

<?else:?>

	<?if ($arResult["NavPageNomer"] > 1):?>
		<?if($arResult["bSavePage"]):?>
			<li class="b-pagination__item b-pagination--prev"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" data-page="PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"></a></li>
			<li class="b-pagination__item"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=1" data-page="PAGEN_<?=$arResult["NavNum"]?>=1">1</a></li>
		<?else:?>
			<?if ($arResult["NavPageNomer"] > 2):?>
				<li class="b-pagination__item b-pagination--prev"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" data-page="PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"></a></li>
			<?else:?>
				<li class="b-pagination__item b-pagination--prev"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>" data-page=""></a></li>
			<?endif?>
			<li class="b-pagination__item"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>" data-page="">1</a></li>
		<?endif?>
	<?else:?>
			<li class="b-pagination__item b-pagination--prev"><span class="b-pagination_link"></span></li>
			<li class="b-pagination__item"><span class="b-pagination_link active">1</span></li>
	<?endif?>

	<?
	$arResult["nStartPage"]++;
	while($arResult["nStartPage"] <= $arResult["nEndPage"]-1):
	?>
		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
			<li class="b-pagination__item"><span class="b-pagination_link active"><?=$arResult["nStartPage"]?></span></li>
		<?else:?>
			<li class="b-pagination__item"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>" data-page="PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a></li>
		<?endif?>
		<?$arResult["nStartPage"]++?>
	<?endwhile?>

	<?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class="b-pagination__item"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>" data-page="PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a></li>
		<?endif?>
			<li class="b-pagination__item b-pagination--next"><a class="b-pagination_link" href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" data-page="PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"></a></li>
	<?else:?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class="b-pagination__item"><span class="b-pagination_link active"><?=$arResult["NavPageCount"]?></span></li>
		<?endif?>
			<li class="b-pagination__item b-pagination--next"><span></span></li>
	<?endif?>
<?endif?>


		</ul>
<?php } ?>		
		<div style="clear:both"></div>
</div>
</div>