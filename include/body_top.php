<?
if (!defined('PRODUCTION_ZONE') || PRODUCTION_ZONE !== true)
	return;

?>
<script type="text/javascript">
    var rrPartnerId = "57f4d6a465bf1932e8abf6db";
    var rrApi = {};
    var rrApiOnReady = rrApiOnReady || [];
    rrApi.addToBasket = rrApi.order = rrApi.categoryView = rrApi.view =
        rrApi.recomMouseDown = rrApi.recomAddToCart = function() {};
    (function(d) {
        var ref = d.getElementsByTagName('script')[0];
        var apiJs, apiJsId = 'rrApi-jssdk';
        if (d.getElementById(apiJsId)) return;
        apiJs = d.createElement('script');
        apiJs.id = apiJsId;
        apiJs.async = true;
        apiJs.src = "//cdn.retailrocket.ru/content/javascript/tracking.js";
        ref.parentNode.insertBefore(apiJs, ref);
    }(document));
</script><?

?>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PVMWDQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-PVMWDQ');</script>
<!-- End Google Tag Manager -->

<!-- Rating@Mail.ru counter -->
<script type="text/javascript">
var _tmr = window._tmr || (window._tmr = []);
_tmr.push({id: "2856468", type: "pageView", start: (new Date()).getTime()});
(function (d, w, id) {
if (d.getElementById(id)) return;
var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window, "topmailru-code");
</script><noscript><div style="position:absolute;left:-10000px;">
<img src="//top-fwz1.mail.ru/counter?id=2856468;js=na" style="border:0;" height="1" width="1" alt="Рейтинг@Mail.ru" />
</div></noscript>
<!-- //Rating@Mail.ru counter -->

<script>
	(function (w, d, n, u, s) {
		w[n]=w[n]||function(){(w[n].q=w[n].q||[]).push(arguments)};
		var a=d.createElement(s),m=d.getElementsByTagName(s)[0];
		a.async=true;a.src=u;m.parentNode.insertBefore(a,m)
	})(window, document, 'DSPCounter', '//tags.soloway.ru/DSPCounter.js', 'script');
</script>
<script type="text/javascript">DSPCounter('send', {'sid':'216208','user_id':''});</script><?
