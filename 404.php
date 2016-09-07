<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");?>


<style>
p {
	text-align: center !important;
	font-size: 20px;
}

.error {
	width: 100%;
	text-align: center;
	font-size: 200px;
	line-height: 200px;
	color: #CCCCCC;
}
</style>
<div style="margin-top:250px">
<div class="error">404</div>
<div class="error-text">
<p>Вы набрали неправильный адрес страницы.<br>Пожалуйста, перейдите на главную страницу сайта или воспользуйтесь формой поиска</p>
</div></div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
