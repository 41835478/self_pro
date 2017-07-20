<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<title>黑眼圈潮趴馆</title>
		<link href="<?php echo CSS;?>/swiper-3.4.0.min.css" type="text/css" rel="stylesheet" >
		<link href="<?php echo CSS;?>/homepage.css" type="text/css" rel="stylesheet" >
		<link href="<?php echo CSS;?>/mobiscroll_002.css" rel="stylesheet" type="text/css">
	    <link href="<?php echo CSS;?>/mobiscroll.css" rel="stylesheet" type="text/css">
		<link href="<?php echo CSS;?>/mobiscroll_003.css" rel="stylesheet" type="text/css">
	    <link href="<?php echo CSS;?>/demo.css" rel="stylesheet" type="text/css" >
		<script src="<?php echo JS;?>/jquery-1.12.4.min.js" type="text/javascript" ></script>
		<script src="<?php echo JS;?>/swiper-3.4.0.min.js" type="text/javascript"></script>
		<script src="<?php echo JS;?>/mobiscroll_002.js" type="text/javascript"></script>
	    <script src="<?php echo JS;?>/mobiscroll_004.js" type="text/javascript"></script>
	    <script src="<?php echo JS;?>/mobiscroll.js" type="text/javascript"></script>
	    <script src="<?php echo JS;?>/mobiscroll_003.js" type="text/javascript"></script>
	    <script src="<?php echo JS;?>/mobiscroll_005.js" type="text/javascript"></script>
	    <script src="<?php echo JS;?>/picker.min.js"></script>
		<script src="<?php echo JS;?>/city.js"></script>
	</head>
	
	 <style>
	    	*{
	    		margin: 0;
	    		padding: 0;
	    	}	    	
			@keyframes mymove
			{
			from {background-color:#ffd200;box-shadow:0px 2px 5px #f1f0e7;}
			to {background-color:#e7bb00;box-shadow:0px 4px 7px #dcdcd4;}
			}
			
			@-webkit-keyframes mymove /*Safari and Chrome*/
			{
			from {background-color:#ffd200 ;box-shadow:0px 2px 5px #f1f0e7;}
			to {background-color:#e7bb00;box-shadow:0px 4px 7px #dcdcd4;}
			}
			
			@keyframes mymove1
			{
			from {background-color:#e7bb00;box-shadow:0px 4px 7px #dcdcd4;}
			to {background-color:#ffd200 ;box-shadow:0px 2px 5px #f1f0e7;}
			}
			
			@-webkit-keyframes mymove1 /*Safari and Chrome*/
			{
			from {background-color:#e7bb00;box-shadow:0px 4px 7px #dcdcd4;}
			to {background-color:#ffd200 ;box-shadow:0px 2px 5px #f1f0e7;}
			}
	    </style>
	    <script>
	    	$(function(){
			    var obj =$('#touch_press');
				document.getElementById('touch_press').addEventListener('touchstart', function () {
					$('#touch_press').css({animation:'mymove 0.2s linear forwards'});
				});
				document.getElementById('touch_press').addEventListener('touchend', function () {
					$('#touch_press').css({animation:'mymove1 0.2s linear forwards'})
				});
		    })
		</script>
	
	<script>
		(function (doc, win) {
	        var docEl = doc.documentElement,
	            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
	            recalc = function () {
	                var clientWidth = docEl.clientWidth;
	                if (!clientWidth) return;
	                if(clientWidth>=750){
	                    docEl.style.fontSize = '100px';
	                }else{
	                    docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
	                }
	            };
	
	        if (!doc.addEventListener) return;
	        win.addEventListener(resizeEvt, recalc, false);
	        doc.addEventListener('DOMContentLoaded', recalc, false);
	    })(document, window);  
	    
	    $(function(){
			var mySwiper = new Swiper ('.swiper-container', {
			direction: 'horizontal',
			loop: true,
		    autoplay : 2000,			    
			    // 如果需要分页器
			pagination: '.swiper-pagination',			    
			    // 如果需要前进后退按钮
			nextButton: '.swiper-button-next',
			prevButton: '.swiper-button-prev',			    
			    // 如果需要滚动条
			   // scrollbar: '.swiper-scrollbar',
			  	})  
			var imgData_first=$('.superbox-list').find('img').eq(0).attr('data-img')
			//$('.superbox-current-img').attr('src', imgData_first);  	
			$('.superbox-list').on('click','.superbox-img',function() {
				var imgData = $(this).attr('data-img');
				$(this).parent().eq(0).siblings().eq(0).find('.superbox-current-img').attr('src', imgData);
				$(this).css('box-shadow','3px 5px 5px #888888').siblings().css('box-shadow','none')
			})
		  })
	</script>
	<body style='background:#fafafa'>
		<div class="swiper-container">
		    <div class="swiper-wrapper">
				<?php if(isset($output['adv']) && !empty($output['adv'])){ ?>
				<?php foreach($output['adv'] as $key => $val){ ?>
				<div class="swiper-slide" style="background: url(<?php echo $val;?>) no-repeat center; background-size: cover;"></div>
				<?php } ?>
				<?php } ?>
		    </div>
		    <!-- 如果需要分页器 -->
		    <div class="swiper-pagination"></div>
		</div>
		<!-- 定位 -->
		<div class="place_search" style="width:100%;margin-top: 0.3rem;">
			<div style='height:0.32rem;margin-bottom:0.3rem;padding-top:0.12rem;padding-left:0.88rem;padding-right:0.24rem;background: url(<?php echo IMG?>/HOME_07.gif) no-repeat 3.2% center; background-size:0.44rem 0.44rem;'>
				<div id='city' style="color：#333;font-size: 0.32rem;width:3rem;float: left;height:0.32rem;"></div>
				<div style="color：#333;font-size: 0.32rem;width:2rem;padding-left:0.5rem;float: right;height:0.32rem;background: url(<?php echo IMG?>/HOME_10.gif) no-repeat left center; background-size:0.3rem 0.3rem;">当前位置</div>
			</div>
			<div style='height:0.44rem;padding-left:0.88rem;padding-right:0.24rem;margin-bottom:0.3rem;background: url(<?php echo IMG?>/HOME_14.gif) no-repeat 3.2% center; background-size:0.44rem 0.44rem;'>
				<div style='width:18%;float:left;height:0.44rem;line-height:0.66rem;color:#333;font-size: 0.32rem;margin-right: 0.2rem;' class="demos">
					<input style='border:none;color:#333;font-size: 0.32rem;' value="" class="" readonly="readonly" name="appDateTime" id="appDateTime" type="text">
				</div>
				<div style='float:right;margin-right:40%;height:0.44rem;line-height:0.7rem;color:#999;font-size: 0.24rem;'>入场</div>
			</div>
			<div style='height:0.44rem;padding-left:0.88rem;padding-right:0.24rem;margin-bottom:0.3rem;'>
				<div style='width:18%;float:left;height:0.44rem;line-height:0.66rem;color:#333;font-size: 0.32rem;margin-right: 0.2rem;' class="demos">
					<input style='border:none;color:#333;font-size: 0.32rem;' value="" class="" readonly="readonly" name="appDateTime" id="appDateTime1" type="text">
				</div>
				<div style='float:right;margin-right:40%;height:0.44rem;line-height:0.7rem;color:#999;font-size: 0.24rem;'>离场</div>
			</div>
			<div style='height:0.32rem;padding-left:0.88rem;padding-top:0.12rem;margin-bottom:0.3rem;background: url(<?php echo IMG?>/HOME_16.gif) no-repeat 3.2% center; background-size:0.44rem 0.44rem;'>
				<input id="keyword" style='border:none;outline:none;font-size: 0.32rem;float: left;height:0.44rem;color:#999;' placeholder='关键词/位置/店名' type="text"/>
			</div>
			<div id="touch_press" style="text-align:center;color:#fff;line-height:0.88rem;width:7.02rem;margin:0 auto;font-size:0.36rem;font-family:'微软雅黑';margin-bottom:10px;height: 0.88rem;box-shadow:0px 2px 5px #f1f0e7;border-radius:6px;background: #ffd200 url(<?php echo IMG?>/HOME_19.gif) no-repeat 40% CENTER; background-size: 0.44REM 0.44rem;">搜索</div>
		</div>
		<div class="place_search" style="width:100%;overflow:hidden;">
			<div></div>
			<div></div>
			<div></div>
		</div>
		<div class="room">
			<div class="room_head">轰趴聚会</div>
			<div class="room_body">
				<div class="room_body_content">
					<?php if(isset($output['store_list']) && !empty($output['store_list'])){ ?> 
					<?php foreach($output['store_list'] as $key => $val){ ?>
					<div class="superbox">
						<?php if($val['store_id'] == 2){ ?>
						<!--
						<a href="javascript:alert('店铺升级中，敬请期待！');" >
						-->
						<a href="?act=order&op=reserve&store_id=<?php echo $val['store_id']?>" >	
						<?php }else{ ?>
						<a href="?act=order&op=reserve&store_id=<?php echo $val['store_id']?>" >
							
						<?php } ?>
							<div class="superbox-show">
							  <!-- 	<div class="superbox-show-more" style="background:url(<?php echo IMG;?>/home_more.png) no-repeat center ;background-size: 1.6rem 0.4rem;">&nbsp;点击查看</div>
								<div class="superbox-show-location">
									<div class="superbox_model"></div>
									<div class="superbox-show-location_content">
											<div style="font-size: 15px;font-family:'黑体';"><?php echo $val['store_name'];?></div>
											<div style="font-size: 12px;font-family: '微软雅黑';overflow: hidden;">
												<div class="superbox-show-l" style="background: url(<?php echo IMG;?>/home_location.png) no-repeat left center; background-size: 7px 10px;"><?php echo $val['store_xx_address'];?></div>
												<div class="superbox-show-r">￥ <?php echo $val['price'];?></div>
											</div>
									</div>
								</div>		-->						
								<img src="<?php echo $val['store_imgs'][0];?>" class="superbox-current-img">
								<div style="overflow:hidden;width:100%;background:#fff">
										<div style="font-size:0.32rem;color:#333;float:left;padding-top:0.18rem;padding-left:0.12rem;font-family: '微软雅黑';"><?php echo $val['store_name'];?></div>
										<div style="font-size:0.32rem;color:#ff5464;float:right;padding-top:0.18rem;padding-right:0.12rem;font-family: '微软雅黑';">￥ <?php echo $val['price'];?>.00</div>
									
								</div>
								<?php if(isset($val['store_label']) && !empty($val['store_label'])){ ?>
								
								<div style="padding:0.12rem 0.12rem;overflow:hidden;background:#fff">
									<?php foreach($val['store_label'] as $k => $v){ ?>
									<p style='line-height:0.4rem;float:left;margin-right:0.2rem;text-align:center;border-radius:0.06rem;width:1rem;height:0.4rem;font-size:0.24rem;color:#999;border:1px solid #ccc;padding:0 2px'><?php echo $v;?></p>
									<?php } ?>
								</div>
								<?php } ?>
								
							</div>
						</a>
				     <!--    
						<div class="superbox-list">
				            <img src="<?php echo $val['store_imgs'][0];?>" data-img="<?php echo $val['store_imgs'][0];?>" alt="" class="superbox-img">
				            <img src="<?php echo $val['store_imgs'][1];?>" data-img="<?php echo $val['store_imgs'][1];?>" alt="" class="superbox-img">
				            <img src="<?php echo $val['store_imgs'][2];?>" data-img="<?php echo $val['store_imgs'][2];?>" alt="" class="superbox-img">
				        </div>
						-->
				    </div>
					<?php } ?>
					<?php } ?>
					
					
				</div>
			</div>
		</div>
		<footer class="footer">
			<div class="table fs12 bt bgf tc footer_wrap">
				<a style="text-decoration:none;" href="" class="table-cell vm on"><i class="ft-icon-plan" style="margin-left:1.03rem"></i></a>
		<!--		<a style="text-decoration:none;" href="?act=user&op=fangjian" class="table-cell vm"><i class="ft-icon-notice"></i>房间</a> -->
				<a style="text-decoration:none;" href="?act=user&op=person_info" class="table-cell vm" ><i class="ft-icon-friends" style="margin-left:2.28rem"></i></a>
			</div>
			<div style="height:1.2rem;width:0.9rem;position:absolute;top:-0.22rem;left:3.3rem;background: url(<?php echo IMG;?>/circleadd.png) no-repeat center;background-size:cover "><a href="?act=user&op=fangjian" style="display:block;height:1.2rem;width:0.9rem;"></a></div>
		</footer>
	</body>
</html>

<script type="text/javascript">
        $(function () {
			var currYear = (new Date()).getFullYear();	
			var opt={};
			opt.date = {preset : 'date'};
			opt.datetime = {preset : 'datetime'};
			opt.time = {preset : 'time'};
			opt.default = {
				theme: 'android-ics light', //皮肤样式
		        display: 'modal', //显示方式 
		        mode: 'scroller', //日期选择模式
				dateFormat: 'yyyy-mm-dd',
				lang: 'zh',
				showNow: true,
				nowText: "今天",
		        startYear: currYear, //开始年份
		        endYear: currYear + 5 ,
		       	stepHour: 9,
                startH:9,
                endH:18,//结束年份
			};
		  	var optDateTime = $.extend(opt['datetime'], opt['default']);
		  	var optTime = $.extend(opt['time'], opt['default']);
			$("#appDateTime").mobiscroll(optDateTime).datetime(optDateTime);
			var opt1={};
			opt1.date = {preset : 'date'};
			opt1.datetime = {preset : 'datetime'};
			opt1.time = {preset : 'time'};
			opt1.default = {
				theme: 'android-ics light', //皮肤样式
		        display: 'modal', //显示方式 
		        mode: 'scroller', //日期选择模式
				dateFormat: 'yyyy-mm-dd',
				lang: 'zh',
				showNow: true,
				nowText: "今天",
		        startYear: currYear, //开始年份
		        endYear: currYear + 5 ,
		       	stepHour: 9,
                startH:8,
                endH:17,//结束年份
			};
		  	var optDateTime1 = $.extend(opt1['datetime'], opt1['default']);
		    $("#appDateTime1").mobiscroll(optDateTime1).datetime(optDateTime1);		  	
        });
			var myDate = new Date();
			var	dateMo=(myDate.getMonth() + 1)
			var	dateDa=(myDate.getDate())
			if((myDate.getMonth() + 1)<10){
				dateMo='0'+(myDate.getMonth() + 1)
			}
			if(myDate.getDate()<10){
				dateDa='0'+(myDate.getDate())
				
			}
			var timestr=myDate.getFullYear()
			        + '-' + dateMo
			        + '-' + dateDa
			        + ' ' + '09'
			        + ':' + '00';
			var timestr1=myDate.getFullYear()
			        + '-' + dateMo
			        + '-' + dateDa
			        + ' ' + '17'
			        + ':' + '00';
			$('#appDateTime').val(timestr);
			$('#appDateTime1').val(timestr1);
    </script>
    
</html>
<script>
var nameEl = document.getElementById('city');

var first = []; /* 省，直辖市 */
var second = []; /* 市 */
var third = []; /* 镇 */

var selectedIndex = [0, 0, 0]; /* 默认选中的地区 */

var checked = [0, 0, 0]; /* 已选选项 */

function creatList(obj, list){
  obj.forEach(function(item, index, arr){
  var temp = new Object();
  temp.text = item.name;
  temp.value = index;
  list.push(temp);
  })
}

creatList(city, first);

if (city[selectedIndex[0]].hasOwnProperty('sub')) {
  creatList(city[selectedIndex[0]].sub, second);
} else {
  second = [{text: '', value: 0}];
}

if (city[selectedIndex[0]].sub[selectedIndex[1]].hasOwnProperty('sub')) {
  creatList(city[selectedIndex[0]].sub[selectedIndex[1]].sub, third);
} else {
  third = [{text: '', value: 0}];
}

var picker = new Picker({
    data: [first, second, third],
  selectedIndex: selectedIndex,
    title: '地址选择'
});

picker.on('picker.select', function (selectedVal, selectedIndex) {
  var text1 = first[selectedIndex[0]].text;
  var text2 = second[selectedIndex[1]].text;
  var text3 = third[selectedIndex[2]] ? third[selectedIndex[2]].text : '';

    nameEl.innerText = text1 + ' ' + text2 + ' ' + text3;
});

picker.on('picker.change', function (index, selectedIndex) {
  if (index === 0){
    firstChange();
  } else if (index === 1) {
    secondChange();
  }

  function firstChange() {
    second = [];
    third = [];
    checked[0] = selectedIndex;
    var firstCity = city[selectedIndex];
    if (firstCity.hasOwnProperty('sub')) {
      creatList(firstCity.sub, second);

      var secondCity = city[selectedIndex].sub[0]
      if (secondCity.hasOwnProperty('sub')) {
        creatList(secondCity.sub, third);
      } else {
        third = [{text: '', value: 0}];
        checked[2] = 0;
      }
    } else {
      second = [{text: '', value: 0}];
      third = [{text: '', value: 0}];
      checked[1] = 0;
      checked[2] = 0;
    }

    picker.refillColumn(1, second);
    picker.refillColumn(2, third);
    picker.scrollColumn(1, 0)
    picker.scrollColumn(2, 0)
  }

  function secondChange() {
    third = [];
    checked[1] = selectedIndex;
    var first_index = checked[0];
    if (city[first_index].sub[selectedIndex].hasOwnProperty('sub')) {
      var secondCity = city[first_index].sub[selectedIndex];
      creatList(secondCity.sub, third);
      picker.refillColumn(2, third);
      picker.scrollColumn(2, 0)
    } else {
      third = [{text: '', value: 0}];
      checked[2] = 0;
      picker.refillColumn(2, third);
      picker.scrollColumn(2, 0)
    }
  }

});

picker.on('picker.valuechange', function (selectedVal, selectedIndex) {
  console.log(selectedVal);
  console.log(selectedIndex);
});

nameEl.addEventListener('click', function () {
    picker.show();
});



var	search_store_url = '/api/api.php?commend=get_index_store_list';
$('#touch_press').click(function(){
	var city = $('#city').html();
	var start_time = $('#appDateTime').val();
	var end_time = $('#appDateTime1').val();
	var keyword = $('#keyword').val();
	$.post(search_store_url,{city:city,start_time:start_time,end_time:end_time,keyword:keyword},function(msg){
		if(msg.data == '200'){
			var data = msg.msg;
			var len = data.length;
			var str = '';
			for(var i = 0  ; i < len ; i++){
				var store_label = '';
				if(data[i].store_label != null){
					
					for(x in data[i].store_label){
						store_label += '<p style="line-height:0.4rem;float:left;margin-right:0.2rem;text-align:center;border-radius:0.06rem;width:1rem;height:0.4rem;font-size:0.24rem;color:#999;border:1px solid #ccc;padding:0 2px">'+data[i].store_label[x]+'</p>';
					}
				}
				str += '<div class="superbox"><a href="?act=order&amp;op=reserve&amp;store_id=5"><div class="superbox-show"><img src="'+ data[i].image +'" class="superbox-current-img"><div style="overflow:hidden;width:100%;background:#fff"><div style="font-size:0.32rem;color:#333;float:left;padding-top:0.18rem;padding-left:0.12rem;font-family: \'微软雅黑\';">'+ data[i].store_name +'</div><div style="font-size:0.32rem;color:#ff5464;float:right;padding-top:0.18rem;padding-right:0.12rem;font-family: \'微软雅黑\';">￥'+ data[i].price +'</div></div><div style="padding:0.12rem 0.12rem;overflow:hidden;background:#fff">'+store_label+'</div></div></a></div>';
				
			}
			$('.room_body_content').html(str);
			console.log(data);
		}else{
			alert(msg.msg);
		}
	},'json');
	
});
</script>

