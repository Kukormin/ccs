<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent(
			"bitrix:sale.order.ajax",
			"cupcake_fastorder",
			Array(
				"ALLOW_AUTO_REGISTER" => "Y",
				"ALLOW_NEW_PROFILE" => "Y",
				"COMPONENT_TEMPLATE" => "cupcake_fastorder",
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
				"PRODUCT_COLUMNS" => array(0=>"PROPERTY_FILLING",),
				"PROP_1" => array(),
				"SEND_NEW_USER_NOTIFY" => "Y",
				"SET_TITLE" => "Y",
				"SHOW_ACCOUNT_NUMBER" => "Y",
				"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
				"SHOW_STORES_IMAGES" => "N",
				"TEMPLATE_LOCATION" => "popup",
				"USE_PREPAYMENT" => "N"
			)
		);?>