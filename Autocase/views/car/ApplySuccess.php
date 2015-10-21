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
<script>
// tap touchend touchstart
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?24a72bde5fc530003072ca4b3c0b271c";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<!-- CSS -->
<?php 
$hostname = "http://oil.baidu.com";
?>
<link rel="stylesheet" href="<?=$hostname?>/static/car/assets/css/reset.css">
<link rel="stylesheet" href="<?=$hostname?>/static/car/assets/css/layout.css">

</head>

<body>
<div class="main">
    <div class="bak_top">
        <div class="number_success">
            <span><?=$amount/100?><span class="yuan">元</span></span>
        </div>
        <div class="input">
            <div class="chenggong">
                <a id="success" class="success"></a>
            </div>
            <div class="mobile">
                <span><?=$phone?></span>
            </div>
           <!--  <a id="modify" class="modify"></a>
            <a href="#" id="oil_btn" class="oil_btn"></a> -->
            <div class="bangzhu">
                <a href="help" id="help_link" class="help_link"></a>
            </div>
        </div>
    </div>
    <div class="bak_bottom">
        <?if(is_array($records)) {?>
        <div class="comment">
            <span><img src="<?=$hostname?>/static/car/assets/others/images/comment_06.png" class="comment_img"></span>
            <span><img src="<?=$hostname?>/static/car/assets/others/images/comment_03.png" class="shouqi"></span>
            <span><img src="<?=$hostname?>/static/car/assets/others/images/comment_06.png" class="comment_img"></span>
        </div>
        <div class="record">
            <?foreach ($records as $k => $v) { ?>
            <div class="user">
                <div class="image">
                    <img src="<?=$v['img_link']?>" class="front">
                </div>
                <div class="message">
                    <div class="usermessage">
                        <span class="username"><?=$v['nick_name']?></span>
                        <span class="usertime"><?php echo date('Y-m-d H:i:s', $v['timestamp']); ?></span>
                    </div>
                    <div class="userword">
                        <p><?=$v['comment']?></p>
                    </div>
                </div>
                <div class="coupon">
                    <span><?=$v['price']?></span>
                </div>
            </div>
            <?}?>
            <div class="address"></div>
        </div>
        <?}?>
    </div>

<script src="http://s1.map.bdimg.com/yyfm/zepto_default/1.1.4/js/zepto_default.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/zepto_otherModules/1.1.4/js/zepto_otherModules.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/nativeAppAdapter/1.12.1/js/nativeAppAdapter.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/orientationTip/1.0.0/js/orientationTip.min.js"></script>
<script src="<?=$hostname?>/static/car/assets/js/util.js"></script>
<script src="<?=$hostname?>/static/car/assets/js/main.js"></script>
</body>
</html>
