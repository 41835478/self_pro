<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" ></script>
 <div id="allmap" style="display:none"></div>
<script>

wx.config({
    //debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo $output["wx_jdk"]['appId'];?>', // 必填，公众号的唯一标识
    timestamp: <?php echo $output["wx_jdk"]['timeStamp'];?>, // 必填，生成签名的时间戳
    nonceStr: '<?php echo $output["wx_jdk"]['nonceStr'];?>', // 必填，生成签名的随机串
    signature: '<?php echo $output["wx_jdk"]['signature'];?>',// 必填，签名，见附录1
    jsApiList: [
				'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
				'hideMenuItems',
				'getLocation',
                'chooseImage', 'uploadImage', 'previewImage'
				] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});
	wx.ready(function() {
            //分享到朋友圈
            wx.onMenuShareTimeline({
                title: '<?php echo $output["wechatShare"]["title"];?>',
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                success: function () {},
                cancel: function () {}
            });
			
			wx.getLocation({
				type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
				success: function (res) {
					var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
					var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
					var speed = res.speed; // 速度，以米/每秒计
					var accuracy = res.accuracy; // 位置精度
				//	console.log('------');
					console.log(res);
				//	wx.openLocation(res);
					createMap(res);
				}
			});
			
            //分享给朋友
            wx.onMenuShareAppMessage({
                title: '<?php echo $output["wechatShare"]["title"]?>',
                desc: '<?php echo $output["wechatShare"]["desc"]?>',
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                type: '<?php echo $output["wechatShare"]["type"]?>',
                dataUrl: "",
                success: function () {},
                cancel: function () {}
            });
			
//            alert('<?php echo $output["wechatShare"]["title"]?>');
            //分享到QQ
            wx.onMenuShareQQ({
                title: '<?php echo $output["wechatShare"]["title"]?>',
                desc: '<?php echo $output["wechatShare"]["desc"]?>',
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                success: function () {},
                cancel: function () {}
            });
            //分享到腾讯微博
            wx.onMenuShareWeibo({
                title: '<?php echo $output["wechatShare"]["title"]?>',
                desc: '<?php echo $output["wechatShare"]["desc"]?>',
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                success: function () {},
                cancel: function () {}
            });
        });
		
</script>

<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=VEGH5ffTCdjpENIeRqZjXgyGfburBjiP"></script>


<script>

//创建地图函数：
function createMap(pos){
//	var map = new BMap.Map("dituContent");//在百度地图容器中创建一个地图
//	var point = new BMap.Point(pos.longitude,pos.latitude);//定义一个中心点坐标
	var x = pos.longitude;
    var y = pos.latitude;
	
    var ggPoint = new BMap.Point(x,y);

    //地图初始化
    var bm = new BMap.Map("allmap");
    bm.centerAndZoom(ggPoint, 15);
    bm.addControl(new BMap.NavigationControl());

    //添加gps marker和label
    var markergg = new BMap.Marker(ggPoint);
    bm.addOverlay(markergg); //添加GPS marker
    var labelgg = new BMap.Label("未转换的GPS坐标（错误）",{offset:new BMap.Size(20,-10)});
    markergg.setLabel(labelgg); //添加GPS label

    //坐标转换完之后的回调函数
    translateCallback = function (data){
      if(data.status === 0) {
        var marker = new BMap.Marker(data.points[0]);
        bm.addOverlay(marker);
        var label = new BMap.Label("转换后的百度坐标（正确）",{offset:new BMap.Size(20,-10)});
        marker.setLabel(label); //添加百度label
    //    console.log('--------');
    //    console.log(label.map.Zg);
    //    console.log('--------');
		bm.setCenter(data.points[0]);
		var city_name = label.map.Zg;   //城市名称
		$('#city').html(city_name);
      }
    }

    setTimeout(function(){
        var convertor = new BMap.Convertor();
        var pointArr = [];
        pointArr.push(ggPoint);
        convertor.translate(pointArr, 1, 5, translateCallback)
    }, 1000);
	//	window.map = map;//将map变量存储在全局
}

//创建marker
   
</script>