<!--

 * 微信分享页面
 * 
 * @author sunyinfeng.123@163.com
 * @date 2015-08-11
 * @package 路径
 * @version 1.0
 */
-->
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
        <div class="number">
            <span>抢加油红包</span>
        </div>
        <div class="input">
            <?if(empty($errorMessage)) {?>
            <form action="applyhongbao" method="get" id="form1">
                <input type="hidden" name="act_id" id="act_id" value="<?=$_GET['act_id']?>">
                <input type="hidden" name="type_id" id="type_id" value="<?=$_GET['type_id']?>">
                <input type="hidden" name="src_code" id="src_code" value="<?=$_GET['src_code']?>">
                <input type="hidden" name="sig" id="sig" value="<?=$_GET['sig']?>">
                <input type="hidden" name="code" id="code" value="<?=$_GET['code']?>">
                <div class="input_text">
                    <input type="text" name="phone" id="phone" placeholder="输入手机号，立即获取加油优惠券" border="0" />
                </div>
                <!--  -->
                <div class="lingqu">
                    <input type="image" name="submit" src="<?=$hostname?>/static/car/assets/others/images/get_btn.png" id="get_btn" class="get_btn" onclick="return checkMobile(phone.value);" />
                </div>
            </form>
            <div class="bangzhu">
                <a href="help" id="help_link" class="help_link"></a>
            </div>
            <?} else {?>
            <form action="applyhongbao" method="get" id="form1">
                <input type="hidden" name="act_id" id="act_id" value="<?=$_GET['act_id']?>">
                <input type="hidden" name="type_id" id="type_id" value="<?=$_GET['type_id']?>">
                <input type="hidden" name="src_code" id="src_code" value="<?=$_GET['src_code']?>">
                <input type="hidden" name="sig" id="sig" value="<?=$_GET['sig']?>">
                <input type="hidden" name="code" id="code" value="<?=$_GET['code']?>">
                <div class="input_text">
                    <input type="text" name="phone" id="phone" border="0" class="error" />
                </div>
                <!--  -->
                <input type="hidden" name="submit" src="<?=$hostname?>/static/car/assets/others/images/get_btn.png" id="get_btn" class="get_btn" />
            </form>
            <div class="errorMessage">
                <span><?=$errorMessage?></span>
            </div>
            <div class="bangzhu">
                <a href="help" id="help_link" class="help_link"></a>
            </div>
            <?}?>
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
                    <span><?=$v['price']?>元</span>
                </div>
            </div>
            <?}?>
            <div class="address"></div>
        </div>
        <?}?>
    </div>
  </div>
<script src="http://s1.map.bdimg.com/yyfm/zepto_default/1.1.4/js/zepto_default.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/zepto_otherModules/1.1.4/js/zepto_otherModules.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/nativeAppAdapter/1.12.1/js/nativeAppAdapter.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/orientationTip/1.0.0/js/orientationTip.min.js"></script> 
<script src="<?=$hostname?>/static/car/assets/js/util.js"></script>
<script src="<?=$hostname?>/static/car/assets/js/main.js"></script> 
<script>
     function checkMobile(str) {
            if(str == ""){
                alert("手机号不能为空");
                return false;
            }else {
                var re = /^1[3|4|5|7|8][0-9]\d{4,8}$/;
                if(re.test(str)){
                    $.ajax({
                        type: "GET",
                        url: "applyhongbao",
                        data:{
                            'phone': $("#phone").val(),
                            'act_id': $("#act_id").val(),
                            'type_id': $("#type_id").val(),
                            'src_code': $("#src_code").val(),
                            'sig': $("#sig").val(),
                            'code': $("#code").val()
                        },
                        success:function(data){
            
                        }

                    });
                    return true;
                }else {
                    alert("不是完整的11位手机号或者正确的手机号前七位");
                    return false;
                }
            }
        }
</script>
</body>
</html>
