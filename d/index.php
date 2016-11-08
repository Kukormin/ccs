<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');

/** @global CMain $APPLICATION */

$APPLICATION->SetTitle('Карточка товара');


$APPLICATION->IncludeComponent('tim:catalog.element', '', array());


require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');