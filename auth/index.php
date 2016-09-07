<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle(""); ?>

<section class="b-topblock b-min-height-213 b-topblock-mobhide">
</section>

<section class="b-bg-grey">
    <div class="b-content-center b-block-account">
        <div class="b-block-new--title b-block-account--title"> Авторизация</div>
        <div class="b-block-account--wrap b-title--border-top i-padding-bott-55">
            <div class="b-block-account--content-wrap">

                <?
                $userName = CUser::GetFullName();
                if (!$userName)
                $userName = CUser::GetLogin();
                ?>
                <script>
                    <?if ($userName):?>
                    BX.localStorage.set("eshop_user_name", "<?=CUtil::JSEscape($userName)?>", 604800);
                    <?else:?>
                    BX.localStorage.remove("eshop_user_name");
                    <?endif?>

                    <?if (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"])>0 && preg_match('#^/\w#', $_REQUEST["backurl"])):?>
                    document.location.href = "<?=CUtil::JSEscape($_REQUEST["backurl"])?>";
                    <?endif?>
                </script> <?
                $APPLICATION->SetTitle("Авторизация");
                ?>
                <p>
                    Вы зарегистрированы и успешно авторизовались.
                </p>

                <p>
                    <a href="<?= SITE_DIR ?>">Вернуться на главную страницу</a>
                </p>

            </div>
        </div>
    </div>
</section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>


