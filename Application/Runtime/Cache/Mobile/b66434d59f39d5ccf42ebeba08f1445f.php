<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />
  <meta name="format-detection" content="telephone=no" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style type="text/css">
    body, html{width: 100%;height: 100%;margin:0;font-family:"微软雅黑";}
    #allmap{height:800px;width:100%;}
    #r-result{width:100%; font-size:14px;}
  </style>
  <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=136zq3mq9SLUa8bh8AAZu43v"></script>
    <script type="text/javascript" src="/demo/Public/Js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript">

        // 用经纬度设置地图中心点
        $(document).ready(function (){

            // 百度地图API功能
            var map = new BMap.Map("allmap");
            map.centerAndZoom(new BMap.Point(116.331398,39.897445),15);
            map.enableScrollWheelZoom(true);

            // 用经纬度设置地图中心点
                if(document.getElementById("longitude").value != "" && document.getElementById("latitude").value != ""){
                    map.clearOverlays();
                    var new_point = new BMap.Point(document.getElementById("longitude").value,document.getElementById("latitude").value);
                    var marker = new BMap.Marker(new_point);  // 创建标注
                    map.addOverlay(marker);              // 将标注添加到地图中
                    map.panTo(new_point);
                }
        });
    </script>
  <title>校区位置</title>
</head>
<body>
<div id="allmap"></div>
<div id="r-result">
   <input id="longitude" type="hidden" value="<?php echo ($lg); ?>" style="width:100px; margin-right:10px;" />
  <input id="latitude" type="hidden" value="<?php echo ($lt); ?>" style="width:100px; margin-right:10px;" />
</div>
</body>
</html>