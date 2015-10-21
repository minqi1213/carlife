<!DOCTYPE html lang="en">
<head>
    <meta charset="UTF-8">
    <title>百度地图加油</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta content="telephone=no" name="format-detection" />
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="full-screen" content="yes" />
    <meta name="screen-orientation" content="portrait" />
    <meta name="x5-fullscreen" content="true" />
    <meta name="360-fullscreen" content="true" />
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
    <!-- CSS -->
    <link rel="stylesheet" href="/static/car/assets/css/apphelp.css">
</head>
<body>

<div class="main">
    <div class="question">
        <h2><li class="headli">常见问题</li></h2>
    </div>
    <div class="answer">
        <ul>
            <li><a href="helpwhy"><div class="f-right">
                        <span class="right-icon"></span>
                    </div>百度地图加油服务有什么便利？</a></li>
            <!-- <div class="line"></div> -->
           <li class="line"> <a href="helphow"><div class="f-right">
                       <span class="right-icon"></span>
                   </div>如何使用百度地图进行加油？</a></li>
            <!-- <div class="line"></div> -->
            <li  class="line"><a href="oilticket"><div class="f-right">
                        <span class="right-icon"></span>
                    </div>什么是油票？</a></li>
            <li  class="line"><a href="whatcan"><div class="f-right">
                        <span class="right-icon"></span>
                    </div>哪些加油站可使用百度地图加油？</a></li>
        </ul>

    </div>
</div>

<div class="main">
    <div class="question">
        <h2><li class="headli">优惠相关</li></h2>
    </div>
    <div class="answer">
        <ul>
            <li><a href="howtoget"><div class="f-right">
                        <span class="right-icon"></span>
                    </div>什么情况会收到油票或其他优惠？</a></li>
            <!-- <div class="line"></div> -->
            <li  class="line"><a href="youhui"><div class="f-right">
                        <span class="right-icon"></span>
                    </div>为什么首次使用百度地图进行加油时，没有享受到优惠？</a></li>
        </ul>

    </div>
</div>

<div class="main">
    <div class="question">
        <h2><li class="headli">费用相关</li></h2>
    </div>
    <div class="answer">
        <ul>
            <li><a href="feequestion"><div class="f-right">
                        <span class="right-icon"></span>
                    </div>使用百度地图加油时，输入的支付金额有误应如何解决？</a></li>
            <!--  <div class="line"></div> -->
            <li  class="line"><a href="fapiao"><div class="f-right">
                        <span class="right-icon"></span>
                    </div>如何申请发票？</a></li>
            <!-- <div class="line"></div> -->
            <li  class="line"><a href="refund"><div class="f-right">
                        <span class="right-icon"></span>
                    </div>如何申请退款？</a></li>
        </ul>

    </div>
</div>
<div class="main">
    <div class="question">
        <h2><li class="headli">免责声明</li></h2>
    </div>
    <div class="answer">
        <ul>
            <li><a href="shengming"><div class="f-right">
                        <span class="right-icon"></span>
                    </div>免责声明</a></li>
        </ul>

    </div>
</div>
<div class="main">
    <div class="question">
        <h2><li class="headli">客服电话</li></h2>
    </div>
    <div class="answer">
        <ul>
            <li><div class ="block-div" >加油服务请咨询：<a class=normal-link href="tel:400-0998-998"><strong class="s1">400-0998-998</strong></div></li>
            <li class="line"> <div class ="block-div" >支付问题请咨询：<a class=normal-link href="tel:400-8988-855"><strong class="s1">400-8988-855</strong></a></div></li>
        </ul>

    </div>
</div>

<div class="main">
    <div class="question">
        <h2><li class="headli">商务合作</li></h2>
    </div>
    <div class="answer">
        <ul>
            <li><div class ="block-div" >商务合作请联系：<a class="normal-link" href="mailto:jiayou@baidu.com"><strong class="s1">jiayou@baidu.com</strong></a></div></li>
        </ul>

    </div>
</div>
<script src="http://s1.map.bdimg.com/yyfm/zepto_default/1.1.4/js/zepto_default.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/zepto_otherModules/1.1.4/js/zepto_otherModules.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/nativeAppAdapter/1.12.1/js/nativeAppAdapter.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/orientationTip/1.0.0/js/orientationTip.min.js"></script>
</body>
</html>
