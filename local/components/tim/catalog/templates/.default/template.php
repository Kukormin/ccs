<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 */

if ($arResult['AJAX'])
	include ('products.php');
elseif ($arResult['NOT_FOUND'])
	include ('not_found.php');
else
	include ('full.php');
