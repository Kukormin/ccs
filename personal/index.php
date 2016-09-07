<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Персональный раздел");
?>

	<section class="b-topblock b-min-height-213 b-topblock-mobhide">
	</section>



	<section class="b-bg-grey">
		<div class="b-content-center b-block-account">

			<div class="b-block-new--title b-block-account--title"> личный кабинет </div>


<?$APPLICATION->IncludeComponent(
	"bitrix:main.profile", 
	"cupcake_profile", 
	array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CHECK_RIGHTS" => "N",
		"COMPONENT_TEMPLATE" => "cupcake_profile",
		"SEND_INFO" => "N",
		"SET_TITLE" => "Y",
		"USER_PROPERTY" => array(
		),
		"USER_PROPERTY_NAME" => ""
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>