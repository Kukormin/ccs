<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

\Bitrix\Main\Loader::IncludeModule('sale');

$result = 0;

if ($_POST['action'] == 'add')
{
	\Local\Sale\Cart::add($_POST['id'], $_POST['offer'], $_POST['quantity']);
	$result = \Local\Sale\Cart::getQuantity();
}
elseif ($_POST['action'] == 'pack') {
	$result = \Local\Sale\Cart::pack($_POST['bid'], $_POST['pid']);
}
elseif ($_POST['action'] == 'offer') {
	$result = \Local\Sale\Cart::offer($_POST['bid'], $_POST['oid']);
}
elseif ($_POST['action'] == 'postal') {
	$result = \Local\Sale\Cart::postal($_POST['bid'], $_POST['id']);
}
/*elseif ($_POST['action'] == 'delete')
{
	CSaleBasket::Delete($_POST["ajaxdeleteid"]);
}
elseif($_POST["ajaxbasketcountid"] && $_POST["ajaxbasketcount"] && $_POST["ajaxaction"] == 'update'){
	$arFields = array(
		"QUANTITY" => $_POST["ajaxbasketcount"]
	);
	CSaleBasket::Update($_POST["ajaxbasketcountid"], $arFields);
}*/

header('Content-Type: application/json');
echo json_encode($result);