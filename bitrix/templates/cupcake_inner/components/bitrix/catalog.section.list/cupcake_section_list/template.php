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

/*foreach($arResult['SECTIONS'] as $section) {
    if($section['IBLOCK_CODE'] == 'cupcakes') {
        $APPLICATION->SetPageProperty("title", "Капкейки");
    } elseif($section['IBLOCK_CODE'] == 'cakes') {
        $APPLICATION->SetPageProperty("title", "Торты");
    } else {
        $APPLICATION->SetPageProperty("title", "Эклеры");
    }
}*/
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

if (isset($_GET["SECTION_CODE"])) { 
    $section = \CIBlockSection::GetList(array(), array('CODE'=>$_GET["SECTION_CODE"]), false, array('ID','LEFT_MARGIN','RIGHT_MARGIN','DEPTH_LEVEL'));
    $section = $section->Fetch();

    $sectionParents = [];
    $rsSect = \CIBlockSection::GetList(array('left_margin' => 'asc'), array(
      'IBLOCK_ID' => $arParams["IBLOCK_ID"],
      "<=LEFT_BORDER" => $section["LEFT_MARGIN"],
      ">=RIGHT_BORDER" => $section["RIGHT_MARGIN"],
      "<DEPTH_LEVEL" => $section["DEPTH_LEVEL"]
    ));

    while($arSect = $rsSect->Fetch())
    {
      $sectionParents[$arSect['ID']] = $arSect;
    }

}
?>


<div class="b-grey-wrap-top b-grey-wrap-top--asaide">
    <div class="b-grey-wrap-top-right">
        <div class="b-grey-wrap-bottom">
            <div class="b-grey-wrap-bottom-right">
                <?

                if (0 < $arResult["SECTIONS_COUNT"])
                {
                ?>
                <ul id="nav_list_asaide" class="b-cupcake-fiirst-line__list">
                    <?
                    $intCurrentDepth = 1;
                    $boolFirst = true;
                    $onPath = false;
                    $isParentActive = false;
                    $isActive = false;
                    $path = [];
                    foreach ($arResult['SECTIONS'] as &$arSection)
                    {
                    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
                    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
             
                    $isActive = $section['ID']==$arSection['ID'];
                    
                    if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL'])
                    {
                        if (0 < $intCurrentDepth)
                            echo "\n",str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);
                        if($arSection['RELATIVE_DEPTH_LEVEL'] == 2) {
                            echo '<ul class="b-cupcake-second-line__list '.($onPath||$isParentActive?'open':'').'" '.($onPath||$isParentActive?'style="display:block"':'').'>';
                        } elseif ($arSection['RELATIVE_DEPTH_LEVEL'] == 3) {
                            echo '<ul class="b-cupcake-third-line__list '.($onPath||$isParentActive?'open':'').'" '.($onPath||$isParentActive?'style="display:block"':'').'>';
                        }
                    }
                    elseif ($intCurrentDepth == $arSection['RELATIVE_DEPTH_LEVEL'])
                    {
                        if (!$boolFirst)
                            echo '</li>';
                    }
                    else
                    {
                        while ($intCurrentDepth > $arSection['RELATIVE_DEPTH_LEVEL'])
                        {
                            echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
                            $intCurrentDepth--;
                        }
                        echo str_repeat("\t", $intCurrentDepth-1),'</li>';
                    }

                    echo (!$boolFirst ? "\n" : ''),str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);
                    
                    if($arSection['RELATIVE_DEPTH_LEVEL'] == 1) { ?>
                    <li class="b-cupcake-fiirst-line__item <?=$isActive?'active':''?>"><a class="b-cupcake-fiirst-line__link " href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"];?><? ?></a>
                        <?} elseif ($arSection['RELATIVE_DEPTH_LEVEL'] == 2) {?>
                    <li class="b-cupcake-second-line__item <?=$isActive?'active':''?>"><a class="b-cupcake-second-line__link " href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"];?><? ?></a>
                        <?} elseif ($arSection['RELATIVE_DEPTH_LEVEL'] == 3) {?>
                    <li class="b-cupcake-third-line__item <?=$isActive?'active':''?>"><a class="b-cupcake-third-line__link " href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"];?><? ?></a>
                        <? }

                        $intCurrentDepth = $arSection['RELATIVE_DEPTH_LEVEL'];
                        $boolFirst = false;

                        $onPath = isset($sectionParents[$arSection['ID']]);
                        if ($onPath || $isActive) {
                            $path[] = '<a class="b-mobile-breadcrumbs_link" href="' . $arSection["SECTION_PAGE_URL"] . '">' . $arSection["NAME"] . '</a>';
                        }
                        $isParentActive = $isActive || $onPath;
                    }
                        unset($arSection);
                        while ($intCurrentDepth > 1)
                        {
                            echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
                            $intCurrentDepth--;
                        }
                        if ($intCurrentDepth > 0)
                        {
                            echo '</li>',"\n";
                        }
                    
                ?>
                </ul>
                <?php } ?>
                <?
                echo ('LINE' != $arParams['VIEW_MODE'] ? '<div style="clear: both;"></div>' : '');
                ?>
            </div>
        </div>
    </div>
</div>



<div class="b-mobile-breadcrumbs b-block-mobile-only">
    <div class="mobile_catalog_open">Развернуть каталог</div>
    <?

    if (0 < $arResult["SECTIONS_COUNT"])
    {
    ?>
    <div class="cupcake__navigation--mobile"> </div>
     <div class="cupcake__navigation--mobile-wrap">

        <div class="b-grey-wrap-top">
            <div class="b-grey-wrap-top-right">
                <div class="b-grey-wrap-bottom">
                    <div class="b-grey-wrap-bottom-right">
                        <ul class="b-cupcake__navigation--mobile-first-line__list">
                            <?
                            $intCurrentDepth = 1;
                            $boolFirst = true;
                            $onPath = false;
                            $isParentActive = false;
                            $isActive = false;
                            $path = [];
                            foreach ($arResult['SECTIONS'] as &$arSection)
                            {
                            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
                            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

                            $isActive = $section['ID']==$arSection['ID'];

                            if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL'])
                            {
                                if (0 < $intCurrentDepth)
                                    echo "\n",str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);
                                if($arSection['RELATIVE_DEPTH_LEVEL'] == 2) {
                                    echo '<ul class="b-cupcake__navigation--mobile-second-line__list '.($onPath||$isParentActive?'open':'').'" '.($onPath||$isParentActive?'style="display:block"':'').'>';
                                } elseif ($arSection['RELATIVE_DEPTH_LEVEL'] == 3) {
                                    echo '<ul class="b-cupcake__navigation--mobile-third-line__list '.($onPath||$isParentActive?'open':'').'" '.($onPath||$isParentActive?'style="display:block"':'').'>';
                                }
                            }
                            elseif ($intCurrentDepth == $arSection['RELATIVE_DEPTH_LEVEL'])
                            {
                                if (!$boolFirst)
                                    echo '</li>';
                            }
                            else
                            {
                                while ($intCurrentDepth > $arSection['RELATIVE_DEPTH_LEVEL'])
                                {
                                    echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
                                    $intCurrentDepth--;
                                }
                                echo str_repeat("\t", $intCurrentDepth-1),'</li>';
                            }

                            echo (!$boolFirst ? "\n" : ''),str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);

                            if($arSection['RELATIVE_DEPTH_LEVEL'] == 1) { ?>
                            <li class="b-cupcake__navigation--mobile-first-line__item <?=$isActive?'active':''?>"><a class="b-cupcake__navigation--mobile-first-line__link " href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"];?><? ?></a>
                                <?} elseif ($arSection['RELATIVE_DEPTH_LEVEL'] == 2) {?>
                            <li class="b-cupcake__navigation--mobile-second-line__item <?=$isActive?'active':''?>"><a class="b-cupcake__navigation--mobile-second-line__link " href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"];?><? ?></a>
                                <?} elseif ($arSection['RELATIVE_DEPTH_LEVEL'] == 3) {?>
                            <li class="b-cupcake__navigation--mobile-third-line__item <?=$isActive?'active':''?>"><a class="b-cupcake__navigation--mobile-third-line__link " href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"];?><? ?></a>
                                <? }

                                $intCurrentDepth = $arSection['RELATIVE_DEPTH_LEVEL'];
                                $boolFirst = false;

                                $onPath = isset($sectionParents[$arSection['ID']]);
                                $isParentActive = $isActive || $onPath;
                                }
                                unset($arSection);
                                while ($intCurrentDepth > 1)
                                {
                                    echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
                                    $intCurrentDepth--;
                                }
                                if ($intCurrentDepth > 0)
                                {
                                    echo '</li>',"\n";
                                }

                                ?>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }
?>