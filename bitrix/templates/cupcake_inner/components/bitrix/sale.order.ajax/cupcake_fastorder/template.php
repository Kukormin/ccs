<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//print_r($arResult);
$price = preg_replace('|(\D)|', '', $arResult['ORDER_PRICE_FORMATED']);
?>
                        <script>
                            $(document).ready(function() {
                                $('#ORDER_FORM').validate({
                                    rules: {
                                        NAME: {
                                            required: true,
                                            minlength: 3
                                        },
                                        EMAIL: {
                                            required: true
                                        }
                                    }
                                });

                            })
                        </script>				

                        <?
                        $user_id = $USER->GetID();
                        if(isset($user_id) && $user_id!='') {
                        $rsUser = $USER->GetByID($user_id);
                        $rows_q = $rsUser -> SelectedRowsCount();
                        if($rows_q > 0) {
                        $arUser = $rsUser->Fetch();
						}
						}
                        ?>
<div class="b-grey-wrap-top">
	<div class="b-grey-wrap-top-right">
		<div class="b-grey-wrap-bottom">
			<div class="b-grey-wrap-bottom-right">
				<div class="b-application-event--title">
					<span> Быстрый заказ</span>
				</div>
				<div class="b-personal_account__form-wrap">
					<form method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data" action="/include/cart_fast_order.php" class="js-fastorder-form">
						<div class="b-personal_account__form--line">
							<div class="b-personal_account__form-item" style="width: 100%">
								<label>Укажите свой номер телефона и мы перезвоним вам сами для уточнения деталей заказа</label>
							</div>
						</div>
						<div class="b-personal_account__form--line">
							<!--form item-->
							<div class="b-personal_account__form-item">
								<label for="">Ваше имя</label>
								<div class="b-form-item__input">
									<input type="text" name="NAME" value="<?=isset($arUser["NAME"])?$arUser["NAME"]:''?>" class="required">
								</div>
							</div>
							<div class="b-personal_account__form-item">
								<label for="">Ваш телефон</label>
								<div class="b-form-item__input">
									<input type="text" id="js-fastorder-mask" name="PERSONAL_PHONE" value="<?=isset($arUser["PERSONAL_PHONE"])?$arUser["PERSONAL_PHONE"]:''?>" class="required" placeholder="+7(926)123-45-67">
                                    <input type="hidden" name="EMAIL" val="<?=$arUser["EMAIL"]?>">
								</div>
							</div>
						</div>

						<div class="b-personal_account__form--line b-personal_account__form--line-login">
							<div class="b-personal_account__form-item">
								<button class="b-bnt-form" type="submit" name="Order" value="Заказать">Заказать</button>
							</div>
						</div>
						

					</form>
				</div>
			</div>
		</div>
	</div>
</div>