<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Торты на заказ");
?><section class="b-topblock b-topblock--pay-ship">

</section>
<section class="b-bg-grey"><?

$APPLICATION->IncludeComponent('tim:empty', 'cakes');

?>
</section><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>