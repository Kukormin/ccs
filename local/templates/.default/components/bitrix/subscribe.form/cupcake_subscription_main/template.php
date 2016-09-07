<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
?>

<? CModule::IncludeModule('subscribe'); ?>
    <div class="b-personal_account--form">
        <div class="b-grey-wrap-top">
            <div class="b-grey-wrap-top-right">
                <div class="b-grey-wrap-bottom">
                    <div class="b-grey-wrap-bottom-right">
                        <div class="b-application-event--title">
                            <span> Подписка</span>
                        </div>
                        <div class="b-personal_account__form-wrap">

                            <form action="" method="post">
                                <div class="b-personal_account__form--line">
                                    <div class="b-personal_account__form-item">
                                        <label for="">Email</label>
                                        <div class="b-form-item__input">
                                            <input type="email" value="" name="email">
                                        </div>
                                    </div>
                                    <div class="b-personal_account__form-item b-personal_account__form-item-right-btn">
                                        <input class="b-bnt-form" type="submit" value="Подписаться">
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?
$EMAIL = $_POST['email'];
$RUBRICKS = [];
foreach ($arResult["RUBRICS"] as $rubrick) {

    $RUBRICKS[] = $rubrick['ID'];
}

$arFields = Array(
    "EMAIL" => $EMAIL,
    "ACTIVE" => "Y",
    "RUB_ID" => $RUBRICKS,
    "SEND_CONFIRM" => "N",
    "CONFIRMED" => "Y"
);
$subscr = new CSubscription;
$subscr->Add($arFields);




