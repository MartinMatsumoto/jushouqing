<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>绵阳职业技术学院-成都校友会</title>
    <meta name="Keywords" content="成都校友会,聚首情">
    <meta name="Description" content="绵阳职业技术学院-成都校友会">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/common.css" rel="stylesheet">
    <link href="/css/header.css" rel="stylesheet">
    <link href="/css/footer.css" rel="stylesheet">
    <link href="/css/navigator.css" rel="stylesheet">
    <link href="../essay/css/essay.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/swiper-3.3.1.min.css?20160324">
    <script type="text/javascript">
        //<![CDATA[
        window.jQuery || document.write("<script src='http://api.map.baidu.com/api?v=2.0&ak=Ndcgn2ltp8kXkG2Ip599tREPa3lNrhic'>"+"<"+"/script>");
        //]]>
    </script>
</head>
<body>
<?php
require_once '../entrance.php';
?>
<!-- 顶部 开始 -->
<?php
include '../include/header.php'
?>
<!-- 顶部 结束 -->
<!-- 导航 开始 -->
<?php
include '../include/navigator.php';
$type = empty($_GET["type"]) ? 1 : $_GET["type"];
?>
<!-- 导航 结束 -->

<div class="essay_container">
    <div class="essay_content">
        <div class="content_title">
            <div class="content_title_container">
                <span class="big_text">联系我们</span>
                <span class="small_text">contact us</span>
            </div>
        </div>

        <div class="content_content">
            <div class="title_container">
                联系我们
            </div>
        </div>

        <div class="clear"></div>
        <div id="map_container" class="map_container"></div>
        <script type="text/javascript">
            var map = new BMap.Map("map_container");          // 创建地图实例
            var point = new BMap.Point(104.0772390000,30.5551800000);  // 创建点坐标
            map.centerAndZoom(point, 15);                 // 初始化地图，设置中心点坐标和地图级别

            map.addControl(new BMap.NavigationControl());
            map.addControl(new BMap.ScaleControl());
            map.addControl(new BMap.OverviewMapControl());
            // 启用滚轮放大缩小
            map.enableScrollWheelZoom();

            var marker = new BMap.Marker(point);  // 创建标注
            var opts = {
                width : 100,     // 信息窗口宽度
                height: 70,     // 信息窗口高度
                enableMessage:true,//设置允许信息窗发送短息
            }
            var infoWindow = new BMap.InfoWindow("地址：成都天府软件园A区15层", opts);  // 创建信息窗口对象
            marker.addEventListener("click", function(){
                map.openInfoWindow(infoWindow,point); //开启信息窗口
            });

            map.addOverlay(marker);               // 将标注添加到地图中
            marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
        </script>
    </div>

</div>


<!-- footer 开始 -->
<?php
include '../include/footer.php'
?>
<!-- footer 结束 -->
<script type="text/javascript" src="/libs/jquery.min.js"></script>
<script type="text/javascript" src="/libs/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/index.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
</body>
</html>