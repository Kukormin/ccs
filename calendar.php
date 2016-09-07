<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("calendar");
?><br>
 <br>
 <br>
 <br>
 <br>
 <br>
 <br>
 <br>
 <br>
 <br>
 <br>
 <br>
 <br>
<br>
<br>
<br>
<br>
<br>
<br>
 <br>
 <?$APPLICATION->IncludeComponent(
	"bitrix:main.calendar",
	"cupcake_calendar",
	Array(
		"COMPONENT_TEMPLATE" => "cupcake_calendar",
		"FORM_NAME" => "",
		"HIDE_TIMEBAR" => "N",
		"INPUT_NAME" => "date_fld",
		"INPUT_NAME_FINISH" => "",
		"INPUT_VALUE" => "",
		"INPUT_VALUE_FINISH" => "",
		"SHOW_INPUT" => "Y",
		"SHOW_TIME" => "Y"
	)
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>