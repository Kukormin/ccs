<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arResult */

foreach ($arResult as $item)
{
	?><li class="b-top-nav__item"><a href="<?= $item['LINK'] ?>" class="b-top-nav__link"><?= $item['TEXT'] ?></a></li><?
}
