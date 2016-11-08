<?
function intarocrm_before_order_send($resOrder){
	if(!CModule::IncludeModule("sale") || !CModule::IncludeModule("intaro.intarocrm") || empty($resOrder))
		return false;
	if($resOrder['delivery']['cost']){
		$arOrder = CSaleOrder::GetByID($resOrder['externalId']);
		if($arOrder["DELIVERY_ID"] && $arOrder["DELIVERY_ID"]!=''){
			$arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
			$resOrder['delivery']['cost'] = $arDeliv["PRICE"];
		}
	}

	if(preg_match("/(\d{2}\.\d{2}\.\d{4}) с (\d{2}:\d{2}) по (\d{2}:\d{2})/", $resOrder['customerComment'], $match)) {
		$resOrder['delivery']['date'] = $match[1];
		$resOrder['delivery']['address']['deliveryTime'] = 'с ' . $match[2] . ' до ' . $match[3];
	}

	return $resOrder;
}

if (!function_exists('DebugMessage')) {
	function DebugMessage($message, $title = false, $color = '#008B8B') {
		?><table border="0" cellpadding="5" cellspacing="0" style="border:1px solid <?=$color?>;margin:2px;text-align:left;">
			<tr><td style="color:<?=$color?>;font-size:11px;font-family:Verdana;"><?
			if(strlen($title)) {
				?><p>[<?=$title?>]</p><?
			}
			if (is_array($message) || is_object($message)) {
				echo '<pre>'; print_r($message); echo '</pre>';
			}
			else {
				var_dump($message);
			}
			?></td></tr>
		</table><?
	}
}

if(!function_exists('log_array')) {
	function log_array($arFields = array(), $sFileName = 'log.txt', $bBacktrace = true) {
		if($GLOBALS['USER']->isAdmin()) {
			_log_array($arFields, $sFileName, $bBacktrace);
		}
	}
}

if(!function_exists('_log_array')) {
	function _log_array($arFields = array(), $sFileName = 'log.txt', $bBacktrace = true) {
		$sMess = '';
		$sMess .= date('d.m.Y H:i:s')."\n";
		$sMess .= print_r($arFields, true)."\n";
		if($bBacktrace && function_exists('debug_backtrace')) {
			$arBacktrace = debug_backtrace();
			$iterationsCount = min(count($arBacktrace), 18);
			for($i = 1; $i < $iterationsCount; $i++) {
				if(strlen($arBacktrace[$i]['class'])) {
					$sMess .= $arBacktrace[$i]['class'].'::';
				}
				$sMess .= $arBacktrace[$i]['function']." >> ";
			}
		}
		$sMess .= "\n----------\n\n";
		$sFileName = empty($sFileName) ? 'log.txt' : $sFileName;
		$sFile = $_SERVER['DOCUMENT_ROOT'].'/_log/'.$sFileName;
		file_put_contents($sFile, $sMess, FILE_APPEND);
	}
}
