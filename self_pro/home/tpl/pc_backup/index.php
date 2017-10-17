<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>搜索定位</title>
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>
    <link rel="stylesheet" href="<?php echo TPL;?>css/location.css"/>
    <script type="text/javascript"
            src="http://webapi.amap.com/maps?v=1.3&key=f96691851b88fc2826c0d478968245ae&plugin=AMap.Autocomplete,AMap.PlaceSearch"></script>
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
    <script type="text/javascript" src="<?php echo TPL;?>scripts/zepto-1.2.0.min.js"></script>
<body>
<div id="myPageTop">
    <div>
        <input id="tipinput" placeholder="请输入您要添加的社区名称并确认"/>
    </div>
</div>
<div id="container"></div>
<div class="clearFix">
    <div id="nowLocation" class="fl"></div>
</div>
<div class="list">
    <ul id="nearbyList">

    </ul>
</div>
<div id="panel"></div>
<script type="text/javascript">
    //    getLocation();
    //    function getLocation(){
    //        if (navigator.geolocation){
    //            navigator.geolocation.getCurrentPosition(showPosition,showError);
    //        }else{
    //            alert("浏览器不支持地理定位。");
    //        }
    //    }
    //    function showPosition(position){
    //        var lat = position.coords.latitude; //纬度
    //        var lag = position.coords.longitude; //经度
    //        alert('纬度:'+lat+',经度:'+lag);
    //        console.log('纬度:'+lat+',经度:'+lag);
    //    }
    //    function showError(error){
    //        switch(error.code) {
    //            case error.PERMISSION_DENIED:
    //                alert("定位失败,用户拒绝请求地理定位");
    //                break;
    //            case error.POSITION_UNAVAILABLE:
    //                alert("定位失败,位置信息是不可用");
    //                break;
    //            case error.TIMEOUT:
    //                alert("定位失败,请求获取用户位置超时");
    //                break;
    //            case error.UNKNOWN_ERROR:
    //                alert("定位失败,定位系统失效");
    //                break;
    //        }
    //    }


    /***************************************
     由于Chrome、IOS10等已不再支持非安全域的浏览器定位请求，为保证定位成功率和精度，请尽快升级您的站点到HTTPS。
     ***************************************/
    var map, geolocation;
    //加载地图，调用浏览器定位服务
    map = new AMap.Map('container', {
        resizeEnable: true
    });
    map.plugin('AMap.Geolocation', function () {
        geolocation = new AMap.Geolocation({
            enableHighAccuracy: true,//是否使用高精度定位，默认:true
            timeout: 10000,          //超过10秒后停止定位，默认：无穷大
            buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
            zoomToAccuracy: true,      //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
            buttonPosition: 'RB'
        });
        map.addControl(geolocation);
        geolocation.getCurrentPosition();
        AMap.event.addListener(geolocation, 'complete', onComplete);//返回定位信息
        AMap.event.addListener(geolocation, 'error', onError);      //返回定位出错信息
    });
    //解析定位结果
    function onComplete(data) {

        //已知点坐标
//        lnglatXY = [121.469043, 31.204359];
        lnglatXY = [data.position.getLng(), data.position.getLat()];
        regeocoder(lnglatXY);
        searchNearBy(lnglatXY);
    }
    //解析定位错误信息
    function onError(data) {
        console.log("定位失败", data);
    }


    //搜索周边地理位置信息
    function searchNearBy(cpoint) {
        //周边搜索
        AMap.service(["AMap.PlaceSearch"], function () {
            var placeSearch = new AMap.PlaceSearch({ //构造地点查询类
                type: '商务住宅',
                map: map,
                panel: "panel"
            });
            //关键词，中心点，半径
            placeSearch.searchNearBy('', cpoint, 500, function (status, result) {
                console.log(status, result);
                var array = result.poiList.pois;
                console.log(array);
                var html = "<div class='title'>附近楼宇/社区：</div>";
                for (var i = 0; i < array.length; i++) {
                    html += "<li class='community'><div>" + array[i].name +
                        "</div><div class='detail'><span class='address'>" + array[i].address + "</span><span class='distance fr'><img src='<?php echo TPL;?>images/location.png'>" + array[i].distance + "m</span></div></li>";
                }
                $("#nearbyList").html(html);
            });
        });
    }


    //逆地理编码,由经纬度获取地址信息
    function regeocoder(lnglatXY) {
        var geocoder = new AMap.Geocoder({
            radius: 1000,
            extensions: "all"
        });
        geocoder.getAddress(lnglatXY, function (status, result) {
            if (status === 'complete' && result.info === 'OK') {
                geocoder_CallBack(result);
            }
        });
        var marker = new AMap.Marker({  //加点
            map: map,
            position: lnglatXY
        });
        map.setFitView();
    }
    function geocoder_CallBack(data) {
        console.log(data);
        var address = data.regeocode.formattedAddress; //返回地址描述
        console.log(address);
        var community = data.regeocode.aois[0].name;
        console.log(community);
        $('#nowLocation').html("<img src='<?php echo TPL;?>images/location.png'>" + "当前定位：" + community);
    }


    //搜索输入提示后查询
    //地图加载
    var map = new AMap.Map("container", {
        resizeEnable: true
    });
    //输入提示
    var autoOptions = {
        input: "tipinput"
    };
    var auto = new AMap.Autocomplete(autoOptions);
    var placeSearch = new AMap.PlaceSearch({
        map: map
    });  //构造地点查询类
    AMap.event.addListener(auto, "select", select);//注册监听，当选中某条记录时会触发
    function select(e) {
        console.log(e);
        placeSearch.setCity(e.poi.adcode);
        placeSearch.search(e.poi.name);  //关键字查询查询

        //更新页面列表信息
        var lng = e.poi.location.lng;
        var lat = e.poi.location.lat;
        lnglatXY = [lng, lat];
        regeocoder(lnglatXY);
        searchNearBy(lnglatXY);
    }

</script>
</body>
</html>