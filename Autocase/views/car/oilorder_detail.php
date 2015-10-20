<!DOCTYPE html lang="en">
<head>
    <meta charset="UTF-8">
    <title>订单详情</title>
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
    <link rel="stylesheet" href="/static/car/assets/css/detail.css">
</head>
<body>
<?if(is_array($data)) { ?>
<div class="detailmain">
    <div class="detailprice">
        <div class="d_price"><span class="fuhao">￥</span><?=$data['pay_amount']/100?></div>
    </div>
    <div class="detailstatus">
        <span><?php switch ($data['status']) {
                      case 1:
                          echo '待支付';
                          break;
                      case 2:
                          echo '支付成功';
                          break;
                      case 3:
                          echo '支付失败';
                          break;
                      case 4:
                          echo '已完成（加油站确认）';
                          break;
                      case 5:
                          echo '退款审核中';
                          break;
                      case 6:
                          echo '退款成功';
                          break;
                      case 7:
                          echo '退款失败';
                          break;
                      case 8:
                          echo '退款被拒绝';
                          break;
                      case 9:
                          echo '退款已同意';
                          break;
                      case 10:
                          echo '退款进行中';
                          break;
                      case 11:
                          echo '订单已取消';
                          break;
        }?></span>
    </div>
</div>
<div class="detailmain1">
    <div class="detail_orderid">
        <div class="dingdan">
            <img src="/static/car/assets/others/image_detail/dingdan.png" class="imgcon">
        </div>
        <div class="orderid"><span><?=$data['order_id']?></span></div>
    </div>
    <div class="detail_station">
        <div class="weizhi">
            <img src="/static/car/assets/others/image_detail/weizhi.png" class="imgcon">
        </div>
        <div class="station"><span><?=$data['oil_station_name']?></span></div>
    </div>
    <div class="detail_date">
        <div class="time">
            <img src="/static/car/assets/others/image_detail/time.png" class="imgcon">
        </div>
        <div class="date"><span><?php echo date("Y-m-d H:i:s", $data['create_time'])?></span></div>
    </div>
    <div class="detail_carno">
        <div class="car">
            <img src="/static/car/assets/others/image_detail/car.png" class="imgcon">
        </div>
        <div class="carno"><span><?=$data['car_no']?></span></div>
    </div>
    <div class="detail_oilno">
        <div class="youqiang">
            <img src="/static/car/assets/others/image_detail/youqiang.png" class="imgcon">
        </div>
        <div class="oilno"><span><?=$data['oil_no']?>#(<?=$data['gun_no']?>号油枪)</span></div>
    </div>
</div>
<div class="detailmain2">
    <div class="detail_page">
        发票开具：即将开通，目前请持小票向收银员展示此页面开具发票
    </div>
    <div class="detail_refund">
        退款申请：如因支付错误或其他特殊原因需要退款，请到柜台联系收银员处理，退款流程如有疑问可致电百度客服电话<span class="detail_phone">400-800-8000</span>
    </div>
</div>
<?} else {?>
<p>订单号为空或者有误！</p>
<?}?>
<script src="http://s1.map.bdimg.com/yyfm/zepto_default/1.1.4/js/zepto_default.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/zepto_otherModules/1.1.4/js/zepto_otherModules.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/nativeAppAdapter/1.12.1/js/nativeAppAdapter.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/orientationTip/1.0.0/js/orientationTip.min.js"></script>
</body>
</html>
