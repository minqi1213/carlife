<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<title>百度地图加油</title>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta content="telephone=no" name="format-detection" />
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="screen-orientation" content="portrait" />

<script>
(function() {
    window.Html = {
        el: document.documentElement,
        width: window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
        height: window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight
    };

    function resetRem() {
        Html.el.style.fontSize = Html.width * 20 / 320 + 'px';
    }

    function resetScreen() {
        Html = {
            el: document.documentElement,
            width: window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
            height: window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        resetRem();
        resetScreen();
    });

    document.addEventListener('WeixinJSBridgeReady', function() {
        resetRem();
        resetScreen();
    }, false);

    window.addEventListener('pageshow', function() {
        setTimeout(resetRem, 300);
        setTimeout(resetScreen, 300);
    });

    window.addEventListener('load', function() {
        setTimeout(resetRem, 300);

    });

    window.addEventListener('resize', function() {
        setTimeout(resetRem, 300);
        setTimeout(resetScreen, 300);

    });

})();
</script>
</head>
<link rel="stylesheet" href="/static/car/assets/css/apphelp.css">
<body>
<div class="main">
    <div class="question">
        <h2><li>免责声明</li></h2>
    </div>
    <div class="answer">
        <p>在您通过百度地图使用加油服务之前，请您认真阅读以下条款（以下简称“本条款”）；
        </p>
        <p>1.      您通过百度地图所获取的所有加油服务均由第三方加油站提供，百度地图仅提供技术支持服务。
        </p>
        <p>
            2.      您在使用加油服务时油品质量、发票以及安全相关的问题均由您与第三方加油站自行协商解决，如因产品及服务给您造成任何损失均由第三方加油站承担全部责任；
        </p>
        <p>3.      您理解并同意，您是否使用第三方加油站提供的服务均由您自行判断和自愿选择。您理解并清楚使用百度地图中的第三方加油服务可能引发的后果，并愿意承担由此产生的责任。
        </p>
        <p>4.      您提交加油服务请求后，为保证您顺利接受加油服务，您的车牌号信息会被发送至加油站，如果您不同意发送车牌号信息，请勿提交服务请求。
        </p>
        <p>
            5.      您理解并同意，您对加油服务的使用视为您同意本条款。
        </p>
     </div>
</div>
<script src="http://s1.map.bdimg.com/yyfm/zepto_default/1.1.4/js/zepto_default.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/zepto_otherModules/1.1.4/js/zepto_otherModules.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/nativeAppAdapter/1.12.1/js/nativeAppAdapter.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/orientationTip/1.0.0/js/orientationTip.min.js"></script>
</body>
</html>
