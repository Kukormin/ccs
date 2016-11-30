<?
define('HIDE_HEADER', true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");

CModule::IncludeModule('sale');

$ORDER_ID = intval($_GET['ORDER_ID']);
$arOrder = array();
if ($ORDER_ID)
{
	$arOrder = \CSaleOrder::GetByID($ORDER_ID);
	$PRICE = $arOrder['PRICE'];
	if($arOrder['PAY_SYSTEM_ID'] == 2) {
		include($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sale_payment/payler/payment.php");
	} else {
		LocalRedirect("/personal/final.php?id=" . $ORDER_ID . "&price=" . $PRICE);
	}
}

if (!$arOrder)
{
	if ($_REQUEST['action'] == 'saveOrderAjax')
	{
		require_once($_SERVER["DOCUMENT_ROOT"] . "/include/functions.php");
		$dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC"), array(
				"FUSER_ID" => CSaleBasket::GetBasketUserID(),
				"LID" => 's1',
				"ORDER_ID" => "NULL"
			), false, false, array(
				"ID",
				"PRODUCT_ID",
				"QUANTITY",
				"DELAY",
				"CAN_BUY",
				"PRICE",
				"WEIGHT",
				"NAME"
			));
		// Добавляем подарочные упаковки в заказ
		while ($arBasketItems = $dbBasketItems->GetNext())
		{
			if ($arBasketItems["DELAY"] == "N" && $arBasketItems["CAN_BUY"] == "Y")
			{
				$rsProps = CSaleBasket::GetPropsList(array(), array(
						"BASKET_ID" => $arBasketItems['ID'],
						'CODE' => 'PACKAGE'
					));
				if ($prop = $rsProps->Fetch())
				{
					$pack = \Local\Sale\Package::getById($prop['SORT']);

					if ($pack && $pack['PRICE'] > 0)
						Local\Sale\Cart::addPackage($pack, $arBasketItems['QUANTITY']);
				}
			}
		}
	}

	$APPLICATION->IncludeComponent("bitrix:sale.order.ajax", "cupcake_basket_make", Array(
			"ALLOW_AUTO_REGISTER" => "Y",
			"ALLOW_NEW_PROFILE" => "Y",
			"COMPONENT_TEMPLATE" => "cupcake_basket_make",
			"COUNT_DELIVERY_TAX" => "N",
			"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
			"DELIVERY2PAY_SYSTEM" => "",
			"DELIVERY_NO_AJAX" => "N",
			"DELIVERY_NO_SESSION" => "Y",
			"DELIVERY_TO_PAYSYSTEM" => "d2p",
			"DISABLE_BASKET_REDIRECT" => "N",
			"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
			"PATH_TO_AUTH" => "/auth/",
			"PATH_TO_BASKET" => "/personal/cart/",
			"PATH_TO_ORDER" => "/personal/order/make/",
			"PATH_TO_PAYMENT" => "/personal/order/payment/",
			"PATH_TO_PERSONAL" => "/personal/order/",
			"PAY_FROM_ACCOUNT" => "Y",
			"PRODUCT_COLUMNS" => array(0 => "PROPERTY_FILLING",),
			"PROP_1" => array(),
			"SEND_NEW_USER_NOTIFY" => "Y",
			"SET_TITLE" => "Y",
			"SHOW_ACCOUNT_NUMBER" => "Y",
			"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
			"SHOW_STORES_IMAGES" => "N",
			"TEMPLATE_LOCATION" => "popup",
			"USE_PREPAYMENT" => "N"
		));

	?>
	<br/><?
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>