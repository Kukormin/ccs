<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$hideItemsFrom = array(
    16, //аксессуары
    12, //коробки
    30 //коробки тортов
);
$boxes = array(
    12, //коробки
    30 //коробки тортов
);

$cp = $this->__component;
if (is_object($cp))
{
	CModule::IncludeModule('iblock');

	if(empty($arResult['ERRORS']['FATAL']))
	{

		$hasDiscount = false;
		$hasProps = false;
		$productSum = 0;
		$basketRefs = array();

		$noPict = array(
			'SRC' => $this->GetFolder().'/images/no_photo.png'
		);

		if(is_readable($nPictFile = $_SERVER['DOCUMENT_ROOT'].$noPict['SRC']))
		{
			$noPictSize = getimagesize($nPictFile);
			$noPict['WIDTH'] = $noPictSize[0];
			$noPict['HEIGHT'] = $noPictSize[1];
		}
		$parents = [];
		$acs_descr = [];
		if (isset($arResult["BASKET"]))
		{
			$arResult['BASKET_GROUPED'] = [];
			foreach ($arResult["BASKET"] as $k => &$prod)
			{
				if (floatval($prod['DISCOUNT_PRICE']))
					$hasDiscount = true;
				// move iblock props (if any) to basket props to have some kind of consistency
				if (isset($prod['IBLOCK_ID']))
				{
					$iblock = $prod['IBLOCK_ID'];
					if (isset($prod['PARENT'])) {
						$parentIblock = $prod['PARENT']['IBLOCK_ID'];
						$parents[$prod['PARENT']['ID']] = $prod['PARENT']['ID'];
					}
					foreach ($arParams['CUSTOM_SELECT_PROPS'] as $prop)
					{
						$key = $prop.'_VALUE';
						if (isset($prod[$key]))
						{
							// in the different iblocks we can have different properties under the same code
							if (isset($arResult['PROPERTY_DESCRIPTION'][$iblock][$prop]))
								$realProp = $arResult['PROPERTY_DESCRIPTION'][$iblock][$prop];
							elseif (isset($arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop]))
								$realProp = $arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop];
							if (!empty($realProp))
								$prod['PROPS'][] = array(
									'NAME' => $realProp['NAME'],
									'VALUE' => htmlspecialcharsEx($prod[$key])
								);
						}
					}
				} else {
					$result = CIBlockElement::GetByID($prod['PRODUCT_ID']);
					while($acc_name = $result->GetNext()) {
						$prod['IBLOCK_ID'] = $acc_name['IBLOCK_ID'];
						$prod['IBLOCK_NAME'] = $acc_name['IBLOCK_NAME'];
					}
				}
				// if we have props, show "properties" column
				if (!empty($prod['PROPS']))
					$hasProps = true;
				$productSum += $prod['PRICE'] * $prod['QUANTITY'];
				$basketRefs[$prod['PRODUCT_ID']][] =& $arResult["BASKET"][$k];
				if (!isset($prod['PICTURE']))
					$prod['PICTURE'] = $noPict;
				
				if (isset($prod['PARENT']['ID'])) {
					$name =  CIBlockElement::GetByID($prod['PARENT']['ID']);
					while($ar_res = $name->GetNext()) {
						$prod['PARENT']['NAME'] = $ar_res['NAME'];
					}
				}
				
				if (!in_array($prod['PARENT']['IBLOCK_ID'],$hideItemsFrom) && !in_array($prod['IBLOCK_ID'],$hideItemsFrom)) {
					$arResult['BASKET_GROUPED']['main'][isset($prod['PARENT']['NAME'])?$prod['PARENT']['ID']:'single'][] = $prod['ID'];
				}else if (!in_array($prod['PARENT']['IBLOCK_ID'],$boxes) && !in_array($prod['IBLOCK_ID'],$boxes)){
					$arResult['BASKET_GROUPED']['accessory'][] = $prod['ID'];
					$acs_descr[$prod['PRODUCT_ID']] = $prod['PRODUCT_ID'];
				}
			}
		}

		if (count($parents)>0) {
			$res = CIBlockElement::GetList(array(),array('ID'=>$parents));
			$arResult['PARENT_DATA'] = array();
			while ($item = $res->GetNextElement()) {
				$arFields = $item->GetFields();
				$arResult['PARENT_DATA'][$arFields['ID']] = $arFields;
			}
		}
		if (count($acs_descr)>0) {
			$res = CIBlockElement::GetList(array(),array('ID'=>$acs_descr));
			$arResult['ACCESSORY_DATA'] = array();
			while ($item = $res->GetNextElement()) {
				$arFields = $item->GetFields();
				$arResult['ACCESSORY_DATA'][$arFields['ID']] = $arFields;
				$acc_section_name = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
				if($ar_section = $acc_section_name->GetNext()) {
					$arResult['ACCESSORY_DATA'][$arFields['ID']]['SECTION_NAME'] = $ar_section['NAME'];
				}else{
					$arResult['ACCESSORY_DATA'][$arFields['ID']]['SECTION_NAME'] = '';
				}
				
			}
		}
		
		$arResult['HAS_DISCOUNT'] = $hasDiscount;
		$arResult['HAS_PROPS'] = $hasProps;

		$arResult['PRODUCT_SUM_FORMATTED'] = SaleFormatCurrency($productSum, $arResult['CURRENCY']);

		if($img = intval($arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE_ID']))
		{

			$pict = CFile::ResizeImageGet($img, array(
				'width' => 150,
				'height' => 90
			), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);

			if(strlen($pict['src']))
				$pict = array_change_key_case($pict, CASE_UPPER);

			$arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE'] = $pict;
		}
		
		$arResult['SHIPMENT_DATA'] =  CSaleDelivery::GetByID($arResult['SHIPMENT'][0]['DELIVERY_ID']);

	}
}
?>