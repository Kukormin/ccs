<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
$this->setFrameMode(true);
?>

<? if (count($arResult['ITEMS']))
{ ?>

    <div class="goodies-content">
		<? foreach ($arResult['ITEMS'] as $item)
		{ ?>
            <div class="goody-wrapper">
                <table class="goody-item">
                    <tr>
                        <td colspan="3">
                            <div class="goody-item__image"
                                 style="background: url('<?= $item['PREVIEW_PICTURE']['SRC'] ?>'); background-size: cover;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="goody-item__content-left">
                            <span class="goody__name"><?= $item['NAME'] ?></span>
                            <span class="goody_property"><?= $item['PROPERTIES']['PROPERTY']['VALUE'] ?></span>
                        </td>
                        <td class="goody-item__content-mid"></td>
                        <td class="goody-item__content-right">
                            <?= $item['PROPERTIES']['WEIGHT']['VALUE'] ?>
                            / <?= $item['PROPERTIES']['UNIT']['VALUE'] ?>
                        </td>
                    </tr>
                </table>
            </div>
		<? } ?>
        <div class="clr"></div>
    </div>

<? } ?>
