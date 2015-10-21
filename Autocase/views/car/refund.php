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

<body>
<div class="main">
    <div class="question">
        <h2><li>如何申请退款？</li></h2>
    </div>
    <div class="answer">
        <p>当支付金额与实际消费金额不符需要退款，需联系油站工作人员，将有误订单进行退款申请，待百度地图确认退款申请无误后，会确认退款申请，并完成退款。退款金额会原路退回到您用来支付的银行卡中，到款时间会根据银行有所不同，通常需要15个工作日，即可到银行查看退款情况。</p>
    </div>
</div>
<script src="http://s1.map.bdimg.com/yyfm/zepto_default/1.1.4/js/zepto_default.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/zepto_otherModules/1.1.4/js/zepto_otherModules.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/nativeAppAdapter/1.12.1/js/nativeAppAdapter.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/orientationTip/1.0.0/js/orientationTip.min.js"></script>
</body>
</html>
