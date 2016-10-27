<?php

/** Error reporting */
error_reporting(E_ALL);

/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';


echo date('H:i:s') , " Load from XML file" , PHP_EOL;
$inputFileName = "XML.xml";

/**  Identify the type of $inputFileName  **/
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
echo 'Loading ' , $inputFileName , ' using ' , $inputFileType , " Reader" , PHP_EOL;

/**  Create a new Reader of the type that has been identified  **/
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
/**  Load $inputFileName to a PHPExcel Object  **/
$objPHPExcel = $objReader->load($inputFileName);

print_r($objPHPExcel);
// echo date('H:i:s') , " Write to Excel2007 format" , PHP_EOL;
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
// echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', __FILE__) , PHP_EOL;


// // Echo memory peak usage
// echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , PHP_EOL;

// // Echo done
// echo date('H:i:s') , " Done writing file" , PHP_EOL;
