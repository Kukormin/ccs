<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');

/** @global CMain $APPLICATION */

$APPLICATION->SetTitle('Каталог товаров');

?>
<section class="b-topblock b-topblock--pay-ship">
</section>

<section class="b-bg-grey">
	<div class="b-content-center b-content-center--cupcake" style="padding-top: 45px;"><?

		$APPLICATION->IncludeComponent('tim:catalog', '', array());

		?>
	</div>
</section><?

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');