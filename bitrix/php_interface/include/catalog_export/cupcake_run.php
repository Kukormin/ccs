<?
//<title>Cupcake - retailCRM</title>

$export = new \Local\Catalog\Export();
$res = $export->start();

if (!$res)
	$strExportErrorMessage = $export->getError();
