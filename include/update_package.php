<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/include/functions.php");

CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');

$arFields = CSaleBasket::GetByID($_POST['gbid']);
$db_res = CSaleBasket::GetPropsList(array(), array("BASKET_ID" => $arFields['ID']));
$props = array();
while ($ar_res = $db_res->Fetch())
{
	if ($ar_res['CODE'] == "PACKAGE") {
		$ar_res = array(
			'CODE' => $ar_res['CODE'],
			'NAME' => $ar_res['NAME'],
			'VALUE' => $_POST['name'],
			'SORT' => $_POST['newid'],
		);
	}else{
		$ar_res = array(
			'CODE' => $ar_res['CODE'],
			'NAME' => $ar_res['NAME'],
			'VALUE' => $ar_res['VALUE'],
			'SORT' => $ar_res['SORT'],
		);
	}
	$props[] = $ar_res;
}
$data = array(
	'PROPS' => $props,
);
CSaleBasket::Update($_POST['gbid'], $data);

echo $newbid;

/*

 // Удаление позиции с упаковкой
CSaleBasket::Delete($_POST['bid']);

// Получение позиции - родительского товара
$arFields = CSaleBasket::GetByID($_POST['gbid']);
// Получение свойств родительского товара
$db_res = CSaleBasket::GetPropsList(
    array(
            "SORT" => "ASC",
            "NAME" => "ASC"
        ),
    array("BASKET_ID" => $arFields['ID'])
);
// Добавление позиции с новой упаковкой
$newbid = MOD_Add2BasketByProductID($_POST['newid'],1);

$props = array();
while ($ar_res = $db_res->Fetch())
{
    if ($ar_res['CODE'] == "PACKAGE") {
        $ar_res = array(
            'CODE' => $ar_res['CODE'],
            'NAME' => 'Коробка',
            'VALUE' => $_POST['name'],
            'SORT' => $newbid
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
CSaleBasket::Update($_POST['gbid'], $data);
echo $newbid;*/
