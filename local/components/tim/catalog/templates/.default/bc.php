<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var Local\Catalog\TimCatalog $component */

$filter = $component->filter;
$products = $component->products['ITEMS'];


$result = array();

// Товары
ob_start();
include('products.php');
$result['HTML'] = ob_get_contents();
ob_end_clean();

// Заголовок браузера
$result['TITLE'] = $component->seo['TITLE'];

header('Content-Type: application/json');
echo json_encode($result);