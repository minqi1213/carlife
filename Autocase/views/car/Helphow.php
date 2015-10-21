<!DOCTYPE html lang="en">
<head>
<meta charset="UTF-8">
<title>百度地图加油</title>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<!--<meta content="telephone=no" name="format-detection" />
<meta content="yes" name="apple-mobile-web-app-capable">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="full-screen" content="yes" />
<meta name="screen-orientation" content="portrait" />
<meta name="x5-fullscreen" content="true" />
<meta name="360-fullscreen" content="true" />-->
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
    <link rel="stylesheet" href="/static/car/assets/css/apphelp.css">
</head>
<style>
    .how{
        width: 100%;
        height: 36.25rem;
        position: relative;
        background-image: url('http://tc-mbu-web12.epc.baidu.com:8240/static/car/assets/others/images/method.png');
        background-size: 100% 100%;
        background-repeat: no-repeat;
        margin-top: 20px;
    }

</style>
<body>
<div class="main">
    <div class="question question-how">
        <h2><li>如何使用百度地图进行加油？</li></h2>
        <p class="intro">在您使用百度地图在线支付油费前，需确保您已到达油站完成加油，并在百度地图加油订单页面输入了正确的油枪号、加油金额等相关信息。具体操作流程如下：</p>

    </div>
    <div class="answer">
        <div class="how"></div>

    </div>
</div>

<script src="http://s1.map.bdimg.com/yyfm/zepto_default/1.1.4/js/zepto_default.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/zepto_otherModules/1.1.4/js/zepto_otherModules.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/nativeAppAdapter/1.12.1/js/nativeAppAdapter.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/orientationTip/1.0.0/js/orientationTip.min.js"></script>
</body>
</html>
