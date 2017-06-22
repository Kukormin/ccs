<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
$this->setFrameMode(true);
?>

<? if (count($arResult['ITEMS']))
{ ?>

    <div class="goodies-content">
		<? foreach ($arResult['LINES'] as $line){ ?>
            <div class="goody__line">
                <? foreach ($line as $item) { ?>
                    <div class="goody-item">
                        <div class="goody-item__image" style="background: url('<?=$item['PREVIEW_PICTURE']['SRC']?>'); background-size: cover;"></div>
                        <div class="goody-item__content">
                            <div class="goody-item__content-left">
                                <span class="goody__name"><?=$item['NAME']?></span>
                                <span class="goody_property"><?=$item['PROPERTIES']['PROPERTY']['VALUE']?></span>
                            </div>
                            <div class="goody-item__content-mid"></div>
                            <div class="goody-item__content-right"><?=$item['PROPERTIES']['WEIGHT']['VALUE']?> / <?=$item['PROPERTIES']['UNIT']['VALUE']?> </div>
                        </div>
                    </div>
                <?}?>
            </div>
		<? } ?>
        <div class="clr"></div>
    </div>

<? } ?>
