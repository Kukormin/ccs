<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

?>Вы сейчас здесь:<?

$last = count($filter['BC']) - 1;
foreach ($filter['BC'] as $i => $item)
{
	if ($i == $last)
	{
		?>
		<span itemprop="item"><?= $item['NAME'] ?></span><?
	}
	else
	{
		?>
		<a itemprop="item" href="<?= $item['HREF'] ?>"><?= $item['NAME'] ?></a> /<?
	}
}