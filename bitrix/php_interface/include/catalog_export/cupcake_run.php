<?
//<title>Cupcake - retailCRM</title>
// Выведем в файл данных название выбраного инфоблока
$strName = "";

// Переменная $IBLOCK_ID должна быть установлена
// мастером экспорта или из профиля
// Переменная $SETUP_FILE_NAME должна быть установлена
// мастером экспорта или из профиля
$IBLOCK_ID = IntVal($IBLOCK_ID);

// Модули каталога и инфоблоков уже подключены
$db_res = CIBlock::GetList(Array(),
	Array("ID"=>IntVal($IBLOCK_ID))
);
if ($ar_res = $db_res->Fetch())
{
	$strName = $ar_res["NAME"];
}

if (strlen($strName)>0)
{
	if ($fp = @fopen($_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME,
		'wb'))
	{
		@fwrite($fp, $strName);
		@fclose($fp);
	}
	else
	{
		$strExportErrorMessage = "Ошибка открытия файла данных на запись";
	}
}
else
{
	$strExportErrorMessage = "Информационный блок не найден";
}
