<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER["DOCUMENT_ROOT"].'/include/functions.php');

CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");
/* Addition of the goods in a basket at addition in a basket */
if($_POST["ajaxaddid"] && $_POST["ajaxaction"] == 'add'){
	$params = array();
	if (isset($_POST['params'])) {
		foreach ($_POST['params'] as $code => $value) {
			$params[] = array(
				'CODE' => $code,
				'NAME' => trim($value['NAME']),
				'VALUE' => trim($value['VALUE']),
				'SORT' => 'ASC'
			);
		}
	}
    $result = MOD_Add2BasketByProductID($_POST["ajaxaddid"], isset($_POST['quantity'])&&is_numeric($_POST['quantity'])?$_POST['quantity']:1, array(), $params);
    header('Content-Type: application/json');
    echo json_encode($result?$result:0);
}
// Добавление товара в новую позицию корзины, даже если ТП уже есть в корзине
if($_POST["ajaxaddid"] && $_POST["ajaxaction"] == 'dupadd'){
	$params = array();
	
	if (isset($_POST['params'])) {
		foreach ($_POST['params'] as $code => $value) {
			$params[] = array(
				'CODE' => $code,
				'NAME' => trim($value['NAME']),
				'VALUE' => trim($value['VALUE']),
				'SORT' => 'ASC'
			);
		}
	}
    
    if (isset($_POST['quantity']) && is_numeric($_POST['quantity']) && $_POST['quantity'] > 1){
        $result = array();
        for ($i = 0; $i < $_POST['quantity']; $i++ ) {
            $result[] = MOD_Add2BasketByProductID($_POST["ajaxaddid"], 1, array('ALLOW_DUBLICATE' => 'Y'), $params);
        }
    } else {
        $result = MOD_Add2BasketByProductID($_POST["ajaxaddid"], 1, array('ALLOW_DUBLICATE' => 'Y'), $params);
    }
    header('Content-Type: application/json');
    echo json_encode($result?$result:0);
}
/* Goods removal at pressing on to remove in a small basket */
if($_POST["ajaxdeleteid"] && $_POST["ajaxaction"] == 'delete'){
    CSaleBasket::Delete($_POST["ajaxdeleteid"]);
}
/* Changes of quantity of the goods after receipt of inquiry from a small basket */
if($_POST["ajaxbasketcountid"] && $_POST["ajaxbasketcount"] && $_POST["ajaxaction"] == 'update'){
    $arFields = array(
        "QUANTITY" => $_POST["ajaxbasketcount"] 
    );
    CSaleBasket::Update($_POST["ajaxbasketcountid"], $arFields);
}
