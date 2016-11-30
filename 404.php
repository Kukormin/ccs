<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");

?>
<section class="b-topblock b-topblock--pay-ship">
</section>

<section class="b-bg-grey">
	<div class="b-content-center b-content-center--cupcake b-content-center--cupcake-catalog">
		<div id="bc">
			Вы сейчас здесь: <a href="/">Главная</a> / <span>Ошибка 404</span>
		</div>

		<div class="b-catalog-wrap--cupcake js-ajax-content-block not-found">
			<h1>Вы набрали неправильный адрес страницы</h1>
			<ul id="a404">
				<li>
					<table>
						<tr>
							<td><b class="index"></b></td>
							<td>
								<a href="/">Перейти на главную</a>
							</td>
						</tr>
					</table>
				</li>
				<li>
					<table>
						<tr>
							<td><b class="cat"></b></td>
							<td>
								<a href="/cat/">Каталог товаров</a>
							</td>
						</tr>
					</table>
				</li>
			</ul>
		</div>

		<img src="/images/new404.png" alt="404" />
</section><?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
