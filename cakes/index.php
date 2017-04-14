<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Торты на заказ");
?><section class="b-topblock b-topblock--pay-ship">

</section>
<section class="b-bg-grey">
	<div class="b-content-center b-block-new">
		<div class="b-block-new--wrap" style="padding-top:0;">
			<h1>
				<div class="b-block-new--title">
					Торты на заказ
				</div>
			</h1>
			<div class="b-block-new-content">
				<p>
					&nbsp;
				</p>
				<p>Начинка и оформление торта могут быть любыми. В каталоге представлены некоторые из вариантов оформления торта.</p>
				<p>Мы всегда рады создать для вас что-то совершенно новое!
					Заказ и уточнение цены по телефону 8(499)322-00-20.</p>
			</div>
		</div>
	</div><?

$APPLICATION->IncludeComponent('tim:empty', 'cakes');

?>
</section><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>