<?
/** @global CMain $APPLICATION */

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Карта сайта. Cupcake Story — семейная кондитерская. Капкейки, торты, эклеры, пряники, пирожные с доставкой на дом");

?><section class="b-topblock b-topblock--pay-ship"></section> <section class="b-bg-grey b-bg-grey--contact">
	<div class="b-content-center b-loyalty b-sitemap"><?

		$APPLICATION->IncludeFile('/include/sitemap.html', array());

		?>
	</div>
</section><?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");