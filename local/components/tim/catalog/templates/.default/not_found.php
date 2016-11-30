<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 */

?>
<section class="b-topblock b-topblock--pay-ship">
</section>

<section class="b-bg-grey">
	<div class="b-content-center b-content-center--cupcake b-content-center--cupcake-catalog">
	<div id="bc">
		Вы сейчас здесь: <a href="/">Главная</a> / <a href="/cat/">Весь каталог</a> / <span>Ничего не найдено</span>
	</div>

	<div class="b-catalog-wrap--cupcake js-ajax-content-block not-found">
	<h1>По вашему запросу ничего не найдено</h1>
	<ul id="a404">
		<li>
			<table>
				<tr>
					<td><b class="search"></b></td>
					<td>
						<a href="/search/?q=<?= $arResult['~QUERY'] ?>">Искать "<?= $arResult['~QUERY'] ?>" в новостях и
							статьях</a>
					</td>
				</tr>
			</table>
		</li>
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
						<a href="/cat/">Все товары</a>
					</td>
				</tr>
			</table>
		</li>
	</ul>

</div>
</section><?
