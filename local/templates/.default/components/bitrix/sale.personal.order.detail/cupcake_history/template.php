<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(!empty($arResult['ERRORS']['FATAL'])):?>

	<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
		<?=ShowError($error)?>
	<?endforeach?>

	<?$component = $this->__component;?>
	<?if($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])):?>
		<?$APPLICATION->AuthForm('', false, false, 'N', false);?>
	<?endif?>

<?else:?>

	<?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

		<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
			<?=ShowError($error)?>
		<?endforeach?>

	<?endif?>
<div class="js-copy-order-order">
 <table class="b-history-table">
	<tr class="b-history-header-row">
		<td colspan="2">коллекция</td>
		<td>кол-во</td>
		<td>стоимость коллекции</td>
		<td colspan="2">коробка</td>
		<td>стоимость коробки</td>
	</tr>
<?foreach ($arResult['BASKET_GROUPED']['main'] as $parent => $ids):?>
<? if ($parent != 'single') { ?>
	<? $first = true;
		foreach ($ids as $id) { ?>
	<? $arItem = $arResult['BASKET'][$id]; ?>
	<tr class="b-history-item-row js-copy-order-item js-copy-order-<?=$id;?>" data-id="<?=$arItem['PRODUCT_ID'];?>" data-quantity="<?=$arItem['QUANTITY']?>">
		<td>
			
			<? if ($first) {?><div class="b-history-table-img"> <img src="<?=CFile::GetPath($arItem['PREVIEW_PICTURE'])?>" alt=""/></div><? } ?>
		</td>
		<td>
			<? if ($first) {?>
			<span class="b-history-table--title"><?=$arResult['PARENT_DATA'][$arItem['PARENT']['ID']]['NAME']?></span>
			<span class="b-history-table--desc">
				<? $props = array(); 
				foreach ($arItem['PROPS'] as $arProp) { ?>
					<? 
					$prop = array(
						'CODE'=>$arProp['CODE'],
						'NAME'=>$arProp['NAME'],
						'VALUE'=>$arProp['VALUE'],
						'SORT'=>'ASC'
					);
					if ($arProp['CODE'] == 'PACKAGE') {
						$arItem['package'] = $arProp['SORT'];
						$prop['PACK'] = $arResult['BASKET'][$arProp['SORT']]['PRODUCT_ID'];
						$props[] = $prop;
						continue;
					}
					if ($arProp['CODE'] == 'NUMBER') {
						$arItem['number'] = $arProp['VALUE'];
						$props[] = $prop;
						continue;
					} 
					$props[] = $prop;
					?>
					<?=$arProp['NAME'];?>: <?=$arProp['VALUE'];?>
				<? } ?>
			</span>
			<? } ?>
		</td>
		<?$first = false;?>
		<td><span class="b-history-table--total-items"><?=isset($arItem['number'])?$arItem['number']:1?> шт</span></td>
		<td>
			<span class="b-history-table--price"><?=strtok($arItem['PRICE'],'.')?> <span class="rub">i</span></span>
			<script>
				$(function () {
					$(".js-copy-order-<?=$id;?>").data('props','<?=json_encode($props);?>');
				});
			</script>
		</td>
		<?php if(isset($arItem['package'])) { ?>
		<td>
			<div class="b-history-table-img-border"> <img src="<?=$arResult['BASKET'][$arItem['package']]['PICTURE']['SRC']?>" alt=""/></div>
		</td>
		<td>
			<span class="b-history-table-name-item">  <?=$arResult['BASKET'][$arItem['package']]['NAME']?></span>
		</td>
		<td>
			<span class="b-history-table--price">  <?=strtok($arResult['BASKET'][$arItem['package']]['PRICE'],'.')?> <span class="rub">i</span></span>
		</td>
		<?php } else { ?>
		<td></td>
		<td></td>
		<td></td>
		<?php } ?>
	</tr>
	<?php } ?>
<?php }else{ ?>

	<? 
		foreach ($ids as $id) { ?>
	<? $arItem = $arResult['BASKET'][$id];  ?>
	<tr class="b-history-item-row js-copy-order-item js-copy-order-<?=$id;?>" data-id="<?=$arItem['PRODUCT_ID'];?>" data-quantity="<?=$arItem['QUANTITY']?>">
		<td>
			<div class="b-history-table-img"> <img src="<?=CFile::GetPath($arItem['PREVIEW_PICTURE'])?>" alt=""/></div>
		</td>
		<td>
			<span class="b-history-table--title"><?=$arItem['IBLOCK_ID']?><?=$arItem['NAME']?></span>
			<span class="b-history-table--desc">
				<? $props = array(); 
				foreach ($arItem['PROPS'] as $arProp) { ?>
					<? 
					$prop = array(
						'CODE'=>$arProp['CODE'],
						'NAME'=>$arProp['NAME'],
						'VALUE'=>$arProp['VALUE'],
						'SORT'=>'ASC'
					);
					if ($arProp['CODE'] == 'PACKAGE') {
						$arItem['package'] = $arProp['SORT'];
						$prop['PACK'] = $arResult['BASKET'][$arProp['SORT']]['PRODUCT_ID'];
						$props[] = $prop;
						continue;
					}
					if ($arProp['CODE'] == 'NUMBER') {
						$arItem['number'] = $arProp['VALUE'];
						$props[] = $prop;
						continue;
					} 
					$props[] = $prop;
					?>
					<?=$arProp['NAME'];?>: <?=$arProp['VALUE'];?>
				<? } ?>
			</span>
		</td>
		<?$first = false;?>
		<td><span class="b-history-table--total-items"><?=isset($arItem['number'])?$arItem['number']:1?> шт</span></td>
		<td>
			<script>
				$(function () {
					$(".js-copy-order-<?=$id;?>").data('props','<?=json_encode($props);?>');
				});
			</script>
			<span class="b-history-table--price"><?=strtok($arItem['PRICE'],'.')?> <span class="rub">i</span></span>
		</td>
		<?php if(isset($arItem['package'])) { ?>
		<td>
			<div class="b-history-table-img-border"> <img src="<?=$arResult['BASKET'][$arItem['package']]['PICTURE']['SRC']?>" alt=""/></div>
		</td>
		<td>
			<span class="b-history-table-name-item">  <?=$arResult['BASKET'][$arItem['package']]['NAME']?></span>
		</td>
		<td>
			<span class="b-history-table--price">  <?=strtok($arResult['BASKET'][$arItem['package']]['PRICE'],'.')?> <span class="rub">i</span></span>
		</td>
		<?php } else { ?>
		<td></td>
		<td></td>
		<td></td>
		<?php } ?>
	</tr>
	<?php } ?>
<?php } ?>
<?endforeach;?>
<? if (count($arResult['BASKET_GROUPED']['accessory'])>0) { ?>
	<tr class="b-history-additem-title-row">
		<td colspan="7" class="b-history-table-dop">
			<span class="b-history-table-dop--title">  Дополнительно к заказу</span>
		</td>
	</tr>
	<? foreach ($arResult['BASKET_GROUPED']['accessory'] as $id) { 
	$arItem = $arResult['BASKET'][$id];
	?>
	<tr class="b-history-additem-row js-copy-order-item js-copy-order-<?=$id;?>" data-id="<?=$arItem['PRODUCT_ID'];?>" data-quantity="<?=$arItem['QUANTITY']?>">
		<td>
			<div class="b-history-table-img"> <img src="<?=CFile::GetPath($arItem['PREVIEW_PICTURE'])?>" alt=""/> </div>
		</td>
		<td>
			<span class="b-history-table--title"> <?=$arItem['NAME'];?></span>
			<span class="b-history-table--cont"><?=$arResult['ACCESSORY_DATA'][$arItem['PRODUCT_ID']]['SECTION_NAME'];?> </span>
			<span class="b-history-table--desc"><?=$arResult['ACCESSORY_DATA'][$arItem['PRODUCT_ID']]['PREVIEW_TEXT'];?></span>
		</td>
		<td> <span class="b-history-table--total-items"><?=$arItem['QUANTITY']?> шт</span></td>
		<td colspan="4"> <span class="b-history-table--price">  <?=strtok($arItem['PRICE'],'.')?> <span class="rub">i</span></span></td>
	</tr>
	<? } ?>
<? } ?>	
</table>	
<div class="b-history-shipping-address">
	<span class="b-history-table-dop--title"> адрес <?
		if ($arResult['SHIPMENT'][0]['DELIVERY_NAME'] != 'Самовывоз') {
			echo 'доставки';
		} else {
			echo 'самовывоза';
		}
	?></span>
	<span class="b-history-table--address"> <? foreach ($arResult['ORDER_PROPS'] as $oProp) {
		if ($oProp['PROPERTY_NAME'] == 'Адрес доставки') {
			echo $oProp['VALUE'];
			break;
		}
	}?></span>
</div>
<div class="b-history-total">
	<div class="b-history-total--info">
		<span class="b-history-table-delivery">
			<?if ($arResult['SHIPMENT'][0]['DELIVERY_NAME'] != 'Самовывоз') {?>Доставка <?=$arResult['SHIPMENT_DATA']['NAME']?> <?=$arResult['SHIPMENT_DATA']['PRICE']?> <span class="rub">i</span><?}else{?>&nbsp;<?}?>
		</span>
		<span class="b-history-table-delivery--total">
			Итого <?if ($arResult['SHIPMENT'][0]['DELIVERY_NAME'] != 'Самовывоз') {?>с доставкой<? } ?>
		</span>
	</div>
	<div class="b-history-total--price">
		<?=$arResult["PRICE"]?> <span class="rub">i</span>
	</div>
	<div class="b-history-total--btn">
		<a href="<?=$arParams["URL_TO_COPY"]?>" class="js-copy-order"><button class="b-bnt-form b-bnt-form--green"><?=GetMessage('SPOL_REPEAT_ORDER')?></button></a>
	</div>
</div>
</div>
<?endif?>