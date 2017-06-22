<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arFields = Array(
	"PHONE" => $_POST["phone"],
	"AUTHOR" => $_POST["name"],
	"AUTHOR_EMAIL" => $_POST["email"],
	"EMAIL_TO" => 'zakaz@cupcakestory.ru',
	"TEXT" => 'Оставлена заявка на странице "Партнерам". Тел.: ' . $_POST["phone"],
);
\CEvent::Send('FEEDBACK_FORM', SITE_ID, $arFields, "N", 39);

$result = [
	'message' => 'Спасибо, мы скоро свяжемся с вами',
];

header('Content-Type: application/json');
echo json_encode($result);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");