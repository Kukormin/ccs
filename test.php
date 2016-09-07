<?php die();
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule("intaro.intarocrm"); CModule::IncludeModule("iblock"); CModule::IncludeModule("sale");CModule::IncludeModule("catalog");


 echo"<pre>";var_dump($_SESSION['retailcrm']);echo"</pre>";//phpinfo();