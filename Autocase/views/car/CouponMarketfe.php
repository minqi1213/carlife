<!DOCTYPE html lang="en">
<head>
<meta charset="UTF-8">
<title>百度地图加油</title>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
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
<link rel="stylesheet" href="/static/car/assets/css/reset.css">
<link rel="stylesheet" href="/static/car/assets/css/layout_market.css">

<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=EItDGOvG4crYlHEZmlGQiQxE"></script>
</head>
<body>
<div class="main">
	<div class="bak_top">
        <div class="number">
            <span>加油红包</span>
        </div>
        <div class="input">
            <?if(empty($errorMessage)) { ?>
            <form action="applymarket" method="get" id="form1">
                <div class="input_text">
                    <input type="text" name="phone" id="phone" placeholder="输入手机号，立即获取加油优惠券" border="0" />
                </div>
                <!--  -->
                <div class="lingqu">
                    <input type="image" name="submit" src="/static/car/assets/others/image_market/get_btn.png" id="get_btn" class="get_btn" onclick="return checkMobile(phone.value);" />
                </div>
            </form>
            <div class="bangzhu">
                <a href="help" id="help_link" class="help_link"></a>
            </div>
            <?} else {?>
            <form action="applymarket" method="get" id="form1">
                
                <input type="text" name="phone" id="phone" border="0" class="error" />
                <!--  -->
                <input type="hidden" name="submit" src="/static/car/assets/others/image_market/get_btn.png" id="get_btn" class="get_btn" />
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
    <div id="bak_bottom">
        <div class="gap"></div>
        <div class="sta">
            <button type="button" id="station_btn" class="station_btn"></button>
       </div> 
       <div id="allmap"></div>
       <div class="tic">
            <button type="button" id="ticket_btn" class="ticket_btn"></button> 
       </div>
    </div>

<script src="http://s1.map.bdimg.com/yyfm/zepto_default/1.1.4/js/zepto_default.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/zepto_otherModules/1.1.4/js/zepto_otherModules.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/nativeAppAdapter/1.12.1/js/nativeAppAdapter.min.js"></script>
<script src="http://s1.map.bdimg.com/yyfm/orientationTip/1.0.0/js/orientationTip.min.js"></script>
<script src="/static/car/assets/js/util.js"></script>
<script src="/static/car/assets/js/main_market.js"></script>
    <script>
        $(document).ready(function(){
            // 百度地图API功能
            var map = new BMap.Map("allmap");
            map.centerAndZoom(new BMap.Point(116.202874,40.046323),12);
            var data_info = [[116.258257,39.85439,"地址：北京市丰台区丰台西路榆树庄凯特厂西侧"],
                [116.202874,40.046323,"地址：北京市海淀区太舟坞街406号"],
                [116.270862,40.039273,"地址：北京市海淀区黑山扈19号"]
            ];

            var opts = {
                width : 200,     // 信息窗口宽度
                height: 70,     // 信息窗口高度
                title: "地图信息",
                enableMessage:true,//设置允许信息窗发送短息
            }

            var labelGather = ["北京京都金穗加油站","北京市龙潭加油站","北京市海淀燕林加油站"];
            for(var i=0;i<data_info.length;i++){
                var marker = new BMap.Marker(new BMap.Point(data_info[i][0],data_info[i][1]));  // 创建标注
                var content = data_info[i][2];
                var label = new BMap.Label(labelGather[i],{offset:new BMap.Size(20,-10)});
                marker.setLabel(label);
                map.addOverlay(marker);               // 将标注添加到地图中
                addClickHandler(content,marker);
            }
            function addClickHandler(content,marker){
                marker.addEventListener("click",function(e){
                            openInfo(content,e)}
                );
            }
            function openInfo(content,e){
                var p = e.target;
                var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
                var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象
                map.openInfoWindow(infoWindow,point); //开启信息窗口
            }
            /*var point = new BMap.Point(116.288333,40.028855);
            var marker = new BMap.Marker(point);  // 创建标注
            map.addOverlay(marker);              // 将标注添加到地图中

            var label = new BMap.Label("壳牌加油站 圆西路站",{offset:new BMap.Size(20,-10)});
            marker.setLabel(label);
            var opts = {
                width : 200,     // 信息窗口宽度
                height: 100,     // 信息窗口高度
                title : "壳牌加油站 圆西路站" , // 信息窗口标题
                enableMessage:true,//设置允许信息窗发送短息
                message:"壳牌加油站 圆西路站"
            }
            var infoWindow = new BMap.InfoWindow("地址：北京海淀区圆明园西路，农业大学西区南侧（北五环肖家河桥向北500米）", opts);  // 创建信息窗口对象
            marker.addEventListener("click", function(){
                map.openInfoWindow(infoWindow,point); //开启信息窗口
            });
            map.centerAndZoom(point, 16);
            map.disableDragging(); */
        });
    </script>
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
                        url: "applymarket",
                        data:{
                            'phone': $("#phone").val()
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
