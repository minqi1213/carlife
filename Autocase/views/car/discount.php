<!DOCTYPE html lang="en">
<head>
    <meta charset="UTF-8">
    <title>优惠码</title>
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
    <link rel="stylesheet" href="/static/car/assets/css/discount.css">
</head>
<body>
<div class="main">
    <?if(isset($summary)){?>
    <div class="brand">
        <p>恭喜您获得 <span><?=$summary?></span> 优惠码</p>
    </div>
    <?} else {?>
    <div class="brand">
        <p>获取优惠码失败！</p>
    </div>
    <?}?>
    <?if(isset($code)){?>
    <div class="code">
        <span><?=$code?></span>
    </div>
    <?} else {?>
    <div class="code">
        <span>获取优惠码失败！</span>
    </div>
    <?}?>
</div>
<div class="method">
    <div class="title">
        <h2>使用方法</h2>
    </div>
    <div class="content">
        <ol>
            <li class="gap">客户可凭优惠码在赶集易洗车客户端下单页面预约上门洗车服务</li>
            <li>进入下单页面，点击“个人中心”，进入验证登录页面，输入手机号，获取验证码后登录到个人中心</li>
            <li>点击进入个人中心的优惠券，在兑换优惠券页面输入优惠券券码，进行兑换</li>
            <li>兑换完后需要洗车时，直接返回到洗车页面，填写好相关的信息，直接提交即可！</li>
        </ol>
    </div>
</div>
<script src="http://s1.map.bdimg.com/yyfm/zepto_default/1.1.4/js/zepto_default.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/zepto_otherModules/1.1.4/js/zepto_otherModules.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/nativeAppAdapter/1.12.1/js/nativeAppAdapter.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/orientationTip/1.0.0/js/orientationTip.min.js"></script>
</body>
</html>
