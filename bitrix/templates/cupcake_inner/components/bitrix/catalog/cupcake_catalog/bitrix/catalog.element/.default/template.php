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


$offer_prices = [];
foreach($arResult['OFFERS'] as $offers) {
	if($offers['PROPERTIES']['DISCOUNT_PRICE']['VALUE'] < $offers['PRICES']['BASE']['VALUE']) {
		$offer_prices[$offers['ID']][] = $offers['PRICES']['BASE']['VALUE'];
		$offer_prices[$offers['ID']][] = $offers['PROPERTIES']['DISCOUNT_PRICE']['VALUE'];
	} else {
		$offer_prices[$offers['ID']][] = $offers['PRICES']['BASE']['VALUE'];
	}
}
?>
<section class="b-topblock b-min-height-213 b-topblock-mobhide">
	</section>

<section class="b-topblock  b-product-card__wrap">
	<div class="b-topblock-block-left"> </div>
	<div class="b-content-center b-block-assortment">
		<div class="b-block-assortment__wrap">
			<a class="b-block-new__link b-block-assortment_link i-margin-left-30" href="/cupcakes">в каталог </a>
			<div class="b-content-center--title i-margin-left-30">
				<?=$arResult['NAME']?>
			</div>
			<div class="b-product-card__content i-margin-left-30">
				<p> <?=$arResult['PREVIEW_TEXT']?></p>
			</div>
			<div class="b-product-card--discont i-margin-left-30 b-title--border-bottom ">
				<div class="b-mod__item-label">акция</div>
				<div class="b-product-card--discont-text">
					до конца августа Вторая коллекция в подарок
				</div>
			</div>
			<div class="b-block-assortment--select i-margin-left-30">
				<div class="b-application-event__form-item b-form-item--select b-form-item--select-assortment">
					<label class="is-color-white" for=""> Начинка</label>
					<div class="b-form-item__input b-form-item__input--select">
						<p class="select_title">Ваниль</p>
						<select>
							<option>Ваниль</option>
							<option>Ваниль2</option>
						</select>
					</div>
				</div>
				<div class="b-application-event__form-item b-form-item--select b-form-item--select-assortment-total">
					<label class="is-color-white" for=""> количество</label>
					<div class="b-form-item__input b-form-item__input--select">
						<p class="select_title">6</p>
						<select class="js_cupcake_number">
							<? foreach($arResult['OFFERS'] as $offers) { ?>
								<option value="<?=$offers['ID'];?>"><?=$offers['PROPERTIES']['NUMBER']['VALUE']?></option>
							<?} ?>
						</select>
						<script>
							var offer_prices = JSON.parse('<?=json_encode($offer_prices);?>');
						</script>
					</div>
				</div>
				<div class="b-block-assortment-package_list">
					<span class="b-block-assortment--package"> 1 упаковка</span>
					<span class="b-block-assortment--package-add"> Хочу еще</span>
				</div>
			</div>


			<div class="b-block-assortment--total">
				<div class="b-old--total-price">
					<div class="b-old-price"> <?=$arResult['MIN_PRICE']['VALUE']?> <span class="rub">i</span></div>
					<div class="b-new-price"><?=$arResult['OFFERS'][0]['PROPERTIES']['DISCOUNT_PRICE']['VALUE']?> <span class="rub">i</span></div>
				</div>
				<div class="b-assortment-total--btn">
					<button class="b-bnt-form b-bnt-form--green i-padd-12x40">в корзину</button>
				</div>

				<button class="b-bnt-present b-bnt-form">сделать подарок</button>
			</div>


			<div class="b-block-social i-margin-left-30">
				<div class="b-block-social-title is-color-white">
					поделиться ссылкой:
				</div>
				<ul class="b-social__list">
					<li class="b-social__item"> <a class="b-vk b-vk--white" href="#"></a></li>
					<li class="b-social__item"> <a class="b-f b-f--white" href="#"></a></li>
					<li class="b-social__item"> <a class="b-tw b-tw--white" href="#"></a></li>
					<li class="b-social__item"> <a class="b-live b-live--white" href="#"></a></li>
					<li class="b-social__item"> <a class="b-g b-g--white" href="#"></a></li>
					<li class="b-social__item"> <a class="b-pl" href="#"></a></li>
				</ul>
			</div>


		</div>
	</div>
</section>

<section class="b-bg-grey">

	<div class="b-content-center b-grey-block-gift--wrap">
		<div class="b-grey-wrap-top  b-ordering-accessory__list">
			<div class="b-grey-wrap-top-right">
				<div class="b-grey-wrap-bottom">
					<div class="b-grey-wrap-bottom-right">
						<div class="b-application-event--title">
							<span>  <font class="b-block-desktop-only">приятный </font>аксессуар к заказу</span>
						</div>

<? //print_r($arResult); ?>

<div class="js-postcards-wrap" style="display: none">
<?  

$i = 0;
$length = count($arResult['BOUND_PRODUCT_ID']) - 1; 
foreach ($arResult['BOUND_PRODUCT_ID'] as $gid=>$arBoundList) { ?>
						<div class="b-postcard__item js-postcard-block <?=($i==$length?'b-postcard__item--last':'');?>">
                        <?php $i++; ?>
							<!--block slider-->
							<div class="add-postcard-wrap">
								<div class="add-postcard--title"> <?=$arBoundList['NAME'];?> <sup class="sum-add-postcard"> 0</sup></div>
								<div class="b-postcard-delete" <?=!isset($arResult['BOUND_BASKET'][$gid])?'style="display: none;"':'';?>>Удалить </div>
								<div class="b-slider-add-postcard__list">
                                    <?php  $j = 0;
                                    foreach ($arResult['BOUND_BASKET'][$gid] as &$item) { 
                                        $item['INDEX'] = $j;?>
                                        <div class="b-slider__item" data-price="<?=$item["PRICE"];?>" data-quantity="<?=$item["QUANTITY"];?>" data-oid="<?=$item['PRODUCT_ID'];?>" data-bid="<?=$item['ID'];?>">
                                            <div class="b-mod__item">
                                                <div class="b-mod__item-img">
                                                    <div class="b-mod__item-img--effect-transform">
                                                        <img src="<?=CFile::GetPath($arResult['BOUND'][$gid][$item['PRODUCT_ID']]['BOUND_FIELDS']['DETAIL_PICTURE'])?>" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="b-mod__item-title">
                                                <span class="postcard--name"> <?=$arResult['BOUND'][$gid][$item['PRODUCT_ID']]['BOUND_FIELDS']['NAME']?></span>
                                                <span><?=$arResult['BOUND'][$gid][$item['PRODUCT_ID']]['BOUND_FIELDS']['PREVIEW_TEXT']?></span>
                                            </div>
                                        </div>
                                    <?php } ?>
								</div>

								<div class="b-add-postcard--quantity" <?=!isset($arResult['BOUND_BASKET'][$gid])?'style="display: none;"':'';?>>
									<div class="b-form-item__input b-form-item__input--select add-postcard--select">
										<p class="select_title">1</p>
										<select class="js-postcard-counter" name="postcard-counter">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
										</select>
									</div>
									<div class="add-postcard--quantity__item"> шт</div>
									<div class="b-mod__item-price"> <span class="js-postcard-total-price">200</span> <span class="rub">i</span></div>
								</div>
							</div>

							<!--block slider-->
							<div class="b-slider-wrap-postcard__list">
								<? foreach($arBoundList as $products_id) { ?>
									<?foreach($arResult['BOUND'][$gid][$products_id] as $postcard_fields) {?>
                                    
								<div class="b-slider__item">
									<div class="b-mod__item b-mod__item-about-novelty b-mod__item-postcard js-postcard-item" data-oid="<?=$postcard_fields['ID'];?>" >
										<div class="b-mod__item-img">
											<div class="b-mod__item-img--effect-transform">
												<img class="js-postcard-img" src="<?=CFile::GetPath($postcard_fields['DETAIL_PICTURE'])?>" alt="">
											</div>
										</div>
										<div class="b-mod__item-checkbox">
											<input type="checkbox" class="checkbox js-addable-postcard" id="checkbox<?=$postcard_fields['ID'];?>" <?=(isset($arResult['BOUND_BASKET'][$gid][$postcard_fields['ID']])?'checked="checked" data-sliderid="'.($arResult['BOUND_BASKET'][$gid][$postcard_fields['ID']]['INDEX']).'"':'');?>/>
											<label for="checkbox<?=$postcard_fields['ID'];?>"><?=$postcard_fields['ID'];?></label>
										</div>
										<div class="b-mod__item-title">
											<span class="postcard--name js-postcard-name"> <?=$postcard_fields['NAME']?></span>
											<span class="js-postcard-text"><?=$postcard_fields['PREVIEW_TEXT']?></span>
										</div>
										<div class="b-mod__item-price js-postcard-price" data-price="<?=$postcard_fields['PRICE']?>" ><?=$postcard_fields['PRICE']?> <span class="rub">i</span></div>
									</div>
								</div>
								<? } }?>
							</div>
						</div>
<? } ?>
            <div class="b-close-post-list js-postcard-toggle"> </div>
            
</div>
<div class="b-ordering-accessory js-postcards-wrap"> 
    <div class="b-grey-assortment--title"> 
        <span>  Подарить эмоции в одно мгновение ... </span>  <span> возможно ли это ? </span>
    </div>
    <span class="b-grey-assortment--desc"> 
        Cupcake Story дарит вам возможность передать ваши чувства в одно мгновение, в&nbsp;один клик! Вы можете послать вашим близким сладкий сюрприз с&nbsp;пожеланиями  и&nbsp;признанием, лишь заполнив пару строк ! 
    </span>

    <button class="b-bnt-form b-bnt-form--green js-postcard-toggle">развернуть</button> 
</div>

						

					</div>
				</div>
			</div>
		</div>
	</div>




	<div class="b-content-center b-slider-about-novelty">
		<div class="b-title b-title--border-middle">
			<div class="b-title__item b-title__item--grey">
						<span href="#" class="b-mod--about-novelty__item-img">
							У нас есть много вкусных коллекций
						</span>
			</div>
		</div>
		<!--block slider-->
		<div class="b-slider-wrap-about-novelty">
			<div class="b-slider__item">

				<div class="b-mod__item b-mod__item-about-novelty">
					<div class="b-mod__item-img">
						<div class="b-mod__item-img--effect-transform">
							<img src="images/pic/mod-img-1.jpg" alt="">
						</div>
						<div class="b-mod__item-label">новинка</div>
						<div class="basket-button"></div>
					</div>
					<div class="b-mod__item-title">
						Шоколад-Вишня
						<span>Выпускной</span>
					</div>
					<div class="b-mod__item-price">1 200 P <span>/ 6 шт</span></div>
				</div>
			</div>
			<div class="b-slider__item">
				<div class="b-mod__item b-mod__item-about-novelty">
					<div class="b-mod__item-img">
						<div class="b-mod__item-img--effect-transform">
							<img src="images/pic/mod-img-2.jpg" alt="">
						</div>
						<div class="b-mod__item-label">новинка</div>
						<div class="basket-button"></div>
					</div>
					<div class="b-mod__item-title">
						Банан-Шоколад
						<span>юбилей</span>
					</div>
					<div class="b-mod__item-price">1 200 P <span>/ 6 шт</span></div>
				</div>
			</div>
			<div class="b-slider__item">
				<div class="b-mod__item b-mod__item-about-novelty">
					<div class="b-mod__item-img">
						<div class="b-mod__item-img--effect-transform">
							<img src="images/pic/mod-img-3.jpg" alt="">
						</div>
						<div class="b-mod__item-label">новинка</div>
						<div class="basket-button"></div>
					</div>
					<div class="b-mod__item-title">
						Лимонная соната
						<span>день рождения</span>
					</div>
					<div class="b-mod__item-price">1 200 P <span>/ 6 шт</span></div>
				</div>
			</div>
			<div class="b-slider__item">
				<div class="b-mod__item b-mod__item-about-novelty">
					<div class="b-mod__item-img">
						<div class="b-mod__item-img--effect-transform">
							<img src="images/pic/mod-img-4.jpg" alt="">
						</div>
						<div class="b-mod__item-label">новинка</div>
						<div class="basket-button"></div>
					</div>
					<div class="b-mod__item-title">
						Баунти
						<span>Выпускной</span>
					</div>
					<div class="b-mod__item-price">1 200 P <span>/ 6 шт</span></div>
				</div>
			</div>
		</div>

	</div>
</section>