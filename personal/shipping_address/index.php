<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Адреса доставки");
?>

<?$APPLICATION->IncludeComponent(
    "bitrix:main.profile",
    "cupcake_shipping_adress",
    Array(
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CHECK_RIGHTS" => "N",
        "COMPONENT_TEMPLATE" => "cupcake_shipping_adress",
        "SEND_INFO" => "N",
        "SET_TITLE" => "Y",
        "USER_PROPERTY" => array("UF_ADRESSES"),
        "USER_PROPERTY_NAME" => ""
    )
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>