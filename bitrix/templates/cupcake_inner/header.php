<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><? IncludeTemplateLangFile(__FILE__); ?>
<?// umt info from intaro
if (!isset($_SESSION['retailcrm'])) {
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $urlData);

    $params = array();
    
    foreach ($urlData as $k => $v) {
        if ($k == 'utm_term' || $k == 'utm_content' || $k == 'utm_source' || $k == 'utm_medium' || $k == 'utm_campaign') {
            $params[$k] = $v;
        }
    }
 
    if (count($params)>0) {
        $_SESSION['retailcrm'] = $params;
    }
}
//?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta name='yandex-verification' content='4821d23a92acdadc' />
    <?$APPLICATION->ShowHead();?>
    <title><?$APPLICATION->ShowTitle()?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <link href="/bitrix/templates/.default/css/slick.css" rel="stylesheet" type="text/css" />
    <link href="/bitrix/templates/.default/css/about.css?v=1" rel="stylesheet" type="text/css" />
    <link href="/bitrix/templates/.default/template_styles.css?v=5" rel="stylesheet" type="text/css" />
    <link href="/bitrix/templates/.default/css/cupcake-media.css?v=3" rel="stylesheet" type="text/css" />
    <link href="/bitrix/templates/.default/css/featherlight.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>

    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="/bitrix/templates/.default/js/jquery.stellar.min.js"></script>
    <script type="text/javascript" src="/bitrix/templates/.default/js/featherlight.js"></script>
    <script type="text/javascript" src="/bitrix/templates/.default/js/slick.js"></script>
    <script type="text/javascript" src="/bitrix/templates/.default/js/richmarker.js"></script>
    <script type="text/javascript" src="/bitrix/templates/.default/js/cupcake.js?v=2"></script>
    <script type="text/javascript" src="/bitrix/templates/.default/js/share.js"></script>
    <script type="text/javascript" src="/bitrix/templates/.default/js/additional.js"></script>
    <script type="text/javascript" src="/bitrix/templates/.default/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/bitrix/templates/.default/js/messages_ru.js"></script>
    <script type="text/javascript" src="/bitrix/templates/.default/js/jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="/bitrix/templates/.default/js/jquery.form.min.js"></script>
	<script type="text/javascript" src="/bitrix/templates/.default/js/calendar.js?v=2"></script>

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<script type="text/javascript"> 
  (function(w, d, e) { 
       var a = 'all', b = 'tou'; var src = b + 'c' +'h'; src = 'm' + 'o' + 'd.c' + a + src; 
       var jsHost = (("https:" == d.location.protocol) ? "https://" : "http://")+ src; 
       s = d.createElement(e); p = d.getElementsByTagName(e)[0]; s.async = 1; s.src = jsHost +"."+"r"+"u/d_client.js?param;ref"+escape(d.referrer)+";url"+escape(d.URL)+";cook"+escape(d.cookie)+";"; 
       if(!w.jQuery) { jq = d.createElement(e); jq.src = jsHost +"."+"r"+'u/js/jquery-1.7.min.js'; p.parentNode.insertBefore(jq, p);} 
       p.parentNode.insertBefore(s, p); 
   }(window, document, 'script')); 
</script> 

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '1466962019996062');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1466962019996062&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<meta name="google-site-verification" content="hr5ePvwzR38szUFRFQDF_ZR3vpcewz-ZKBgwXg4WDLE" />
<meta name='yandex-verification' content='68d480cb35a9235a' />
</head>

<body>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PVMWDQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PVMWDQ');</script>
<!-- End Google Tag Manager -->
<div id="panel"><?$APPLICATION->ShowPanel();?></div>

<div class="b-content-wrap">
 <? if (strpos('/personal/cart/',$APPLICATION->GetCurPage())!==0):?>
        <?if (strpos('/personal/order/make/',$APPLICATION->GetCurPage())!==0):?>
    <section class="b-header">
        <? $APPLICATION->IncludeFile( '/include/header_alert.php', array(),
            array(
                'MODE'  => 'html',
                'TEMPLATE'  => 'page_inc.php',
            )
        ); ?>
        <nav class="b-top-nav">
            <ul class="b-top-nav__list">
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "cupcakes_menu_black",
                Array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "left",
                    "COMPONENT_TEMPLATE" => "catalog_horizontal_old",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => "",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_THEME" => "site",
                    "ROOT_MENU_TYPE" => "top",
                    "USE_EXT" => "N"
                )
            );?>
                </ul>
        </nav>
        <div class="b-panel">
            <div class="b-header__center">
<?$APPLICATION->IncludeComponent("bitrix:search.form", "header-search2", Array(
	"USE_SUGGEST" => "Y",	// Показывать подсказку с поисковыми фразами
		"PAGE" => "#SITE_DIR#search/index.php",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
                <?
                global $USER;
                if ($USER->IsAuthorized()) { ?>
                    <a href="/personal/"><div class="b-header__user b-header__user--registration active"><?=$USER->GetFirstName()?></div></a>
                <? } else { ?>
                    <div class="b-header__user"><span class="js_login">Вход</span> / <span class="js_register">Регистрация</span></div>
                <? } ?>
                <div class="b-header-phones-wrapper">
                    <div class="b-header__phone">+7 499 322 00 20</div>
                    <div class="b-header-watsup">Пишите нам в WhatsApp</div>
                    <div class="b-header-watsup-phone">+7 968 622 73 42</div>
                </div>
                <div class="b-header__logo">
                    <div class="b-header__logo-link"><a href="/"><img src="/bitrix/templates/.default/images/icn-logo.png" alt=""></a></div>
                </div>
            </div>

            <div class="b-header__bottom">
                <div class="b-header__bottom-nav">
                    <div class="b-links">
                        <a href="/sweet-table/" class="sweet-table <?=strpos('/sweet-table/',$APPLICATION->GetCurPage())===0?'active':'';?>">сладкие столы</a>
                        <!--<a href="/gift_for_star/" class="gift <?=strpos($APPLICATION->GetCurPage(),'/gift_for_star/')===0?'active':'';?>">подарок для звезды</a>-->
                        <a href="/personal/cart/" class="basket <?=strpos($APPLICATION->GetCurPage(),'/personal/cart/')===0 || strpos($APPLICATION->GetCurPage(),'/personal/order/make/')===0?'active':'';?>"><img src="/bitrix/templates/.default/images/icn-bascet.png" alt="">
                        <span class="item_shopping_cart js-basket-total-count" style="display: none;"></span>
                        </a>
                    </div>
                    <div class="mobile-button-nav"></div>
                    <nav class="b-bottom-nav">
                        <ul class="b-bottom-nav__list">
                            <li class="b-bottom-nav__item b-bottom-nav__item--mob">
                                <? if (!$USER->IsAuthorized()) { ?>
                                <div class="b-header__user"><span class="js_login">Вход</span> / <span class="js_register">Регистрация</span></div>
                                <? } else { ?>
                                <div class="b-personal-area">
                                    <a href="/personal/" class="b-personal-area__link">Персональные данные</a>
                                    <a href="/personal/shipping_address/" class="b-personal-area__link">Адреса доставки</a>
                                    <a href="/personal/order/?filter_history=Y" class="b-personal-area__link">История заказов</a>
                                    <a href="/?logout=yes" class="b-personal-area__link">Выход</a>
                                </div>
                                <? } ?>
                            </li>
                            <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"cupcakes_menu_pink_inner", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"COMPONENT_TEMPLATE" => "cupcakes_menu_pink_inner",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "bottom",
		"USE_EXT" => "N",
		"MENU_THEME" => "site"
	),
	false
);?>
                        </ul>
                        <ul class="b-top-nav__list--mobile">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "cupcakes_menu_black",
                                Array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "left",
                                    "COMPONENT_TEMPLATE" => "catalog_horizontal_old",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "1",
                                    "MENU_CACHE_GET_VARS" => "",
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_TYPE" => "N",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "MENU_THEME" => "site",
                                    "ROOT_MENU_TYPE" => "top",
                                    "USE_EXT" => "N"
                                )
                            );?>
                            <li class="b-top-nav__item  b-top-nav__item--mob">
                                <div class="b-header__phone b-header__phone--mob">+7 499 322-00-20</div>
                                <div class="b-header-watsup b-header-watsup--mob">Пишите нам в WhatsApp</div>
                                <div class="b-header-watsup-phone b-header-watsup-phone--mob">+7 968 622 73 42</div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
<?endif;?>
<?endif;?>