<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */

?>
<div class="search-form">
	<form action="<?= $arResult['FORM_ACTION'] ?>">
		<div align="center"><?

			if ($arParams['USE_SUGGEST'] === 'Y')
			{
				$APPLICATION->IncludeComponent(
					'bitrix:search.suggest.input',
					'custom',
					array(
						'NAME' => 'q',
						'VALUE' => '',
						'INPUT_SIZE' => 15,
						'DROPDOWN_SIZE' => 10,
					),
					$component,
					array('HIDE_ICONS' => 'Y')
				);
			}
			else
			{
				?>
				<input type="text" name="q" placeholder="Поиск" maxlength="50" /><?
			}

			?>
		</div>
		<div align="right"><input type="submit" value="" /></div>
	</form>
</div>