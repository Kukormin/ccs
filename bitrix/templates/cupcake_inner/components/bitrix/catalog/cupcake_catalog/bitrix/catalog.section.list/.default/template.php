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
?>
<section class="b-topblock b-topblock--pay-ship">
	</section>

<section class="b-bg-grey">
	<!--block slider-->
	<div class="b-content-center b-slider-stock b-slider-cupcake">
		<div class="b-slider-stock-wrap">
			<div class="b-slider-stock__list">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "cupcake_banners_inner",
                    Array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "Y",
                        "COMPONENT_TEMPLATE" => "cupcake_banners",
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "Y",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array(0=>"ID",1=>"CODE",2=>"XML_ID",3=>"NAME",4=>"DETAIL_TEXT",5=>"DETAIL_PICTURE",6=>"DATE_ACTIVE_FROM",7=>"ACTIVE_FROM",8=>"DATE_ACTIVE_TO",9=>"ACTIVE_TO",10=>"IBLOCK_TYPE_ID",11=>"IBLOCK_ID",12=>"IBLOCK_CODE",13=>"IBLOCK_NAME",14=>"IBLOCK_EXTERNAL_ID",15=>"",),
                        "FILTER_NAME" => "",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => "21",
                        "IBLOCK_TYPE" => "banner",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "0",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Новости",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array(0=>"LINK_NAME",1=>"DISPLAY_MAIN",2=>"LINK",3=>"",),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "DESC",
                        "SORT_ORDER2" => "ASC"
                    )
                );?>

			</div>
		</div>
	</div>
	<div class="b-content-center b-content-center--cupcake">


		<!--<div class="b-mobile-breadcrumbs b-block-mobile-only">
			<ul class="b-mobile-breadcrumbs_list">
				<li class="b-mobile-breadcrumbs_item">
					<a class="b-mobile-breadcrumbs_link" href="#"> Праздничные </a>
				</li>
				<li class="b-mobile-breadcrumbs_item">
					<a class="b-mobile-breadcrumbs_link last" href="#">Девичник</a>
				</li>
			</ul>
			<div class="cupcake__navigation--mobile"> </div>
			<div class="cupcake__navigation--mobile-wrap">

				<div class="b-grey-wrap-top">
					<div class="b-grey-wrap-top-right">
						<div class="b-grey-wrap-bottom">
							<div class="b-grey-wrap-bottom-right">
								<ul class="b-cupcake__navigation--mobile-first-line__list">
									<li class="b-cupcake__navigation--mobile-first-line__item">
										<a class="b-cupcake__navigation--mobile-first-line__link" href="#">Свадебные</a>
									</li>
									<li class="b-cupcake__navigation--mobile-first-line__item">
										<a class="b-cupcake__navigation--mobile-first-line__link" href="#">Классика</a>
									</li>
									<li class="b-cupcake__navigation--mobile-first-line__item">
										<a class="b-cupcake__navigation--mobile-first-line__link" href="#">Детские</a>
									</li>
									<li class="b-cupcake__navigation--mobile-first-line__item">
										<a class="b-cupcake__navigation--mobile-first-line__link" href="#">Праздничные</a>
										<ul class="b-cupcake__navigation--mobile-second-line__list">
											<li class="b-cupcake__navigation--mobile-second-line__item">
												<a class="b-cupcake__navigation--mobile-second-line__link" href="#">Семейные</a>
												<ul class="b-cupcake__navigation--mobile-third-line__list">
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">Крещение</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">День рождения</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">Юбилей</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">Рождение ребенка</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">Девичник</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">Мальчишник</a>
													</li>
												</ul>
											</li>
											<li class="b-cupcake__navigation--mobile-second-line__item">
												<a class="b-cupcake__navigation--mobile-second-line__link" href="#">Календарные</a>
												<ul class="b-cupcake__navigation--mobile-third-line__list">
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">Новый год</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">Рождество</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">14 Февраля</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">8 Марта</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">Пасха</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">9 Мая</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">День защиты детей</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">Выпускной</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">День семьи</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">День знаний</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">День матери</a>
													</li>
													<li class="b-cupcake__navigation--mobile-third-line__item">
														<a class="b-cupcake__navigation--mobile-third-line__link" href="#">Хеллоуин</a>
													</li>
												</ul>
											</li>
										</ul>
									</li>
									<li class="b-cupcake__navigation--mobile-first-line__item">
										<a class="b-cupcake__navigation--mobile-first-line__link" href="#">Эксклюзивные</a>
									</li>
									<li class="b-cupcake__navigation--mobile-first-line__item">
										<a class="b-cupcake__navigation--mobile-first-line__link" href="#">Корпоративные</a>
									</li>
								</ul>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>-->
<?

$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

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
			foreach ($arResult['SECTIONS'] as &$arSection)
			{
				$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
				$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

				if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL'])
				{
					if (0 < $intCurrentDepth)
						echo "\n",str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);
					if($arSection['RELATIVE_DEPTH_LEVEL'] == 2) {
						echo '<ul class="b-cupcake-second-line__list">';
					} elseif ($arSection['RELATIVE_DEPTH_LEVEL'] == 3) {
						echo '<ul class="b-cupcake-third-line__list">';
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
					<li class="b-cupcake-fiirst-line__item"><a class="b-cupcake-fiirst-line__link" href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"];?><? ?></a>
				<?} elseif ($arSection['RELATIVE_DEPTH_LEVEL'] == 2) {?>
					<li class="b-cupcake-second-line__item"><a class="b-cupcake-second-line__link" href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"];?><? ?></a>
				<?} elseif ($arSection['RELATIVE_DEPTH_LEVEL'] == 3) {?>
					<li class="b-cupcake-third-line__item"><a class="b-cupcake-third-line__link" href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"];?><? ?></a>
				<? }

				$intCurrentDepth = $arSection['RELATIVE_DEPTH_LEVEL'];
				$boolFirst = false;
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
	}
?>
</ul>
<?
	echo ('LINE' != $arParams['VIEW_MODE'] ? '<div style="clear: both;"></div>' : '');
?>
				</div>
				</div>
			</div>
		</div>

