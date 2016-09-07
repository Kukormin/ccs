<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
//print_r($arResult);
?>
<?$flag = true;
$items = array();
foreach($arResult["ITEMS"] as $k => $arItem):
    $items[] = array(
        'name' => $arItem['NAME'],
        'adr' => $arItem['PROPERTIES']['PICKUP_ADR']['VALUE'],
        'schedule' => $arItem['PROPERTIES']['SCHEDULE']['VALUE'],
        'coords' => $arItem['PROPERTIES']['COORDS']['VALUE']
    );

endforeach;?>

<script>
    var map_info = JSON.parse('<?=json_encode($items)?>');
</script>