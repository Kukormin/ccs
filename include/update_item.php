<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');

$arFields = CSaleBasket::GetByID($_POST['id']);

$db_res = CSaleBasket::GetPropsList(
    array(
            "SORT" => "ASC",
            "NAME" => "ASC"
        ),
    array("BASKET_ID" => $arFields['ID'])
);
$props = array();
while ($ar_res = $db_res->Fetch())
{
    if (isset($_POST['params'][$ar_res['CODE']])) {
        $ar_res = array(
            'CODE' => $ar_res['CODE'],
            'NAME' => $_POST['params'][$ar_res['CODE']]['NAME'],
            'VALUE' => $_POST['params'][$ar_res['CODE']]['VALUE'],
            'SORT' => $ar_res['SORT']
        );
    }else{
        $ar_res = array(
            'CODE' => $ar_res['CODE'],
            'NAME' => $ar_res['NAME'],
            'VALUE' => $ar_res['VALUE'],
            'SORT' => $ar_res['SORT']
        );
    }
    $props[] = $ar_res;
}
$data = array();
$data['PROPS'] = $props;
echo CSaleBasket::Update($_POST['id'], $data)?1:0;