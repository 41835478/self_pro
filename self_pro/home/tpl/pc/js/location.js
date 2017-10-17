$(function () {
    //返回上个页面
    $(".left_img").click(function () {
        if(nearByArray.length > 0) {
            var data = nearByArray[0];
            commitCommunity(data);
            //返回到首页，同时更新社区信息
            var localStorage = window.localStorage;
            localStorage.community = data.name;
        } else if(selectedCommunity != null){
            var localStorage = window.localStorage;
            localStorage.community = selectedCommunity;
        }
        //获取社区id
        var localStorage = window.localStorage;
        $.ajax({
            type:'POST',
            url:'http://www.125898.com/api/api.php?commend=search_community',
            dataType:'json',
            data:{value:localStorage.community},
            success:function (data) {
                console.log(data);
                var localStorage = window.localStorage;
                localStorage.communityID = data.data.id;
                window.history.back(-1);
            }
        });
    });
    /***************************************
     由于Chrome、IOS10等已不再支持非安全域的浏览器定位请求，为保证定位成功率和精度，请尽快升级您的站点到HTTPS。
     ***************************************/
    var map, geolocation;
    var locationFlag = true;
    var nearByArray = new Array();
    var selectedCommunity;
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
        // lnglatXY = [121.469043, 31.204359];
        lnglatXY = [data.position.getLng(), data.position.getLat()];
        regeocoder(lnglatXY);
        searchNearBy(lnglatXY);
    }
    //解析定位错误信息
    function onError(data) {
        locationFlag = false;
        console.log("定位失败", data);
        $('#nowLocation').html("获取位置信息失败，请手动选择社区");
        // lnglatXY = [121.469043, 31.204359];
        // regeocoder(lnglatXY);
        // searchNearBy(lnglatXY);
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
                nearByArray = array;
                console.log(array);
                var html = "<div class='title'>请选择附近楼宇/社区：</div>";
                for (var i = 0; i < array.length; i++) {
                    html += "<li class='community'><div>" + array[i].name +
                        "</div><div class='detail'><span class='address'>" + array[i].address + "</span><span class='distance fr'><img src='images/location.png'>" + array[i].distance + "m</span></div></li>";
                }
                $("#nearbyList").html(html);
                //选择社区
                $(".community").click(function () {
                    var index = $(this).index();
                    var data = array[index-1];
                    console.log(data);
                    commitCommunity(data);
                    //返回到首页，同时更新社区信息
                    var localStorage = window.localStorage;
                    localStorage.community = data.name;
                    $.ajax({
                        type:'POST',
                        url:'http://www.125898.com/api/api.php?commend=search_community',
                        dataType:'json',
                        data:{value:localStorage.community},
                        success:function (data) {
                            console.log(data);
                            var localStorage = window.localStorage;
                            localStorage.communityID = data.data.id;
                            location.href = "http://www.125898.com";
                        }
                    });
                });
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
        $('#nowLocation').html("<img src='images/location.png'>" + "当前定位：" + community);
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
        //无法定位
        if (!locationFlag) {
            $('#tipinput').val(e.poi.name);
            $('#nowLocation').html("已选择社区：" + e.poi.name);
        }
        placeSearch.setCity(e.poi.adcode);
        placeSearch.search(e.poi.name);  //关键字查询查询
        selectedCommunity = e.poi.name;

        //更新页面列表信息
        var lng = e.poi.location.lng;
        var lat = e.poi.location.lat;
        lnglatXY = [lng, lat];
        regeocoder(lnglatXY);
        searchNearBy(lnglatXY);
    }

    //同步社区信息
    function commitCommunity(data) {
        var posx = data.location.lng;
        var posy = data.location.lat;
        console.log(posx,posy);
        var device = checkDevice();
        $.ajax({
            type:'POST',
            url:'http://www.125898.com/api/api.php?commend=commit_community',
            dataType:'json',
            data:{name:data.name,type:data.type,address:data.address,adcode:data.adcode,
                adname:data.adname, citycode:data.citycode,pname:data.pname,
                cityname:data.cityname,posx:data.location.lng,posy:data.location.lat,
                s_type:device},
            success:function (data) {
                console.log(data);
                var localStorage = window.localStorage;
                localStorage.communityID = data.data.id;
            }
        });
    }

    //判断用户设备类型
    function checkDevice() {
        var isiOS = navigator.userAgent.match('iPad') || navigator.userAgent.match('iPhone') || navigator.userAgent.match(
        'iPod');
        var isAndroid = navigator.userAgent.match('Android');
        if (isiOS) {
            return "iOS";
        } else if (isAndroid) {
            return "Android";
        } else
            return "";
    }
});