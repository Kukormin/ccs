<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
<ul class="b-cupcake-fiirst-line__list">

<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
		<li class="b-cupcake-fiirst-line__item "><a href="<?=$arItem["LINK"]?>" class="b-cupcake-fiirst-line__link active"><?=$arItem["TEXT"]?></a></li>
	<?else:?>
		<li class="b-cupcake-fiirst-line__item "><a class="b-cupcake-fiirst-line__link " href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
	<?endif?>
	
<?endforeach?>

</ul>
<?endif?>