<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?>
<style>
	.badCoupon{
		border: 1px solid #e16565 !important;
		background: rgba(225,101,101,.16) !important;
		box-shadow: 0 0 2px 0 rgba(225,101,101,.8) !important;
	}
	.bad{
		display:none !important;
	}
</style><?

$APPLICATION->IncludeComponent(
	"custom:sale.basket.basket",
	"basket_test",
	Array(
		"ACTION_VARIABLE" => "action",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"COLUMNS_LIST" => array(0=>"NAME",1=>"DISCOUNT",2=>"PROPS",3=>"DELETE",4=>"DELAY",5=>"PRICE",6=>"QUANTITY",7=>"SUM",8=>"PROPERTY_ADDITIONAL_IMAGES",9=>"PROPERTY_NEW",10=>"PROPERTY_ACTION",11=>"PROPERTY_STAR_GIFT",12=>"PROPERTY_FILLING",13=>"PROPERTY_NUMBER",14=>"PROPERTY_ARTICLE",15=>"PROPERTY_STAR_GIFT_PRICE",),
		"COMPONENT_TEMPLATE" => "basket",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"HIDE_COUPON" => "N",
		"OFFERS_PROPS" => array(0=>"NUMBER",),
		"PATH_TO_ORDER" => "/personal/order/make/",
		"PRICE_VAT_SHOW_VALUE" => "Y",
		"QUANTITY_FLOAT" => "N",
		"SET_TITLE" => "Y",
		"USE_PREPAYMENT" => "N"
	)
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");