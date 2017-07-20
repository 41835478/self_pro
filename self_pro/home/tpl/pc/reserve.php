<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<title>别墅预定</title>
		<link rel="stylesheet" type="text/css" href="<?php echo CSS;?>/css.css">
		<link rel="stylesheet" href="<?php echo CSS;?>/swiper-3.4.0.min.css">
		<link rel="stylesheet" href="<?php echo CSS;?>/calendar.css">
		<script type="text/javascript" src ="<?php echo JS;?>/jquery-1.12.4.min.js"></script>
		<script type="text/javascript" src="<?php echo JS;?>/map.js"></script>
		<script type="text/javascript" src="<?php echo JS;?>/swiper-3.4.0.min.js"></script>
		<script src="<?php echo JS;?>/calendar.js"></script> 
		<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	</head>
	<style>
		.swiper-container {
		    width: 100%;
		    height: 3.9rem;
		    }
	dl {
    display: block;
    -webkit-margin-before: 0em;
    -webkit-margin-after: 0em;
    -webkit-margin-start: 0px;
    -webkit-margin-end: 0px;
}
dd {
    display: block;
    -webkit-margin-start: 0px;
}
	</style>
	<script>   
		var store_id = <?php echo $_GET['store_id'];?>;
		function close_spe(){
			$(".model_des").hide();
			$(".zdf").show()
		}
		function house_des(){
			$(".model_des").show();
			$(".zdf").hide();
			$("html,body").animate({scrollTop:$("#top_1").offset().top},0);
		}
		function close_spe_1(){
			$(".model_des_spe").hide();
			$(".zdf").show()
		}
		function get_more(){
			$(".model_des_spe").show();
			$(".zdf").hide()
		}
		function dis(){
			$('.sharee').hide();
		}
		function share() {
			$(".sharee").show();
		}
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
			var v=($('.swiper-slide').length)+1;
/* 			var tg_site = localStorage.getItem("tg_site");
			if(tg_site=="true"){
				$('.tg_dis').hide();
			} */
			var mySwiper = new Swiper ('.swiper-container', {
			direction: 'horizontal',
			loop: true,
			autoplay : 2000,			    
				// 如果需要分页器
			// pagination: '.swiper-pagination',			    
				// 如果需要前进后退按钮
			nextButton: '.swiper-button-next',
			prevButton: '.swiper-button-prev',		
			onSlideChangeStart:function(swiper){
				var t=$('.swiper-slide-active').index();
				if(t==v){
					t=1;
				}
				$('.tynsb').html(t+' / '+(v-1)) 
				}			
				// 如果需要滚动条
			   // scrollbar: '.swiper-scrollbar',
				})  
		 })
/* 			function tg_dis(){
				$('.tg_dis').hide();
				localStorage.setItem("tg_site", "true");
			}  */

  </script>
	<body style="background: #fafafa;">
<div class="zdf" style="display: block;">
		<!--
		<div  style="height:4.2rem;background: url(<?php echo $output['store']['store_logo'];?>) no-repeat center; background-size: cover;"></div>
		-->
		<div class="swiper-container" style="position:relative">
		    <div class="swiper-wrapper">
				<?php if(isset($output['store_images']) && !empty($output['store_images'])){ ?>
				<?php foreach($output['store_images'] as $key => $val){ ?>
					<div class="swiper-slide" style="background: url(<?php echo $val;?>) no-repeat center; background-size: cover;"></div>
				<?php } ?>
				<?php } ?>
		    </div>  -->	
		    <!-- 如果需要分页器 -->
			
		    <div class="swiper-pagination"></div>
			<?php if(isset($output['store']['store_3d_url']) && !empty($output['store']['store_3d_url'])){ ?>
			<a href="<?php echo $output['store']['store_3d_url'];?>">
			<div class='vr360' style="position:absolute;width:1.2rem;height:1.2rem;bottom:0.1rem;right:0.24rem;background: url(<?php echo IMG;?>/360vr.png) no-repeat right bottom; background-size:0.4rem 0.4rem;z-index:999"></div>
			<div style='position:absolute;height:0.6rem;bottom:0;font-family:"微软雅黑";font-size:0.24rem;right:0.84rem;color:#fff;z-index:99;line-height:0.6rem;'>点击最后VR图标，即可观看全景图</div>
			</a>
  <!-- 			
			<div class="weui_dialog_alert tg_dis" style="position:absolute;z-index:999999;width:100%;height:100%;top:0" onclick="tg_dis()">
				<div class="weui_dialog" style="height:100%;width:100%;top:0;background:black;opacity:0.8;z-index:9998;"></div>
				<div class="weui_mask"  style="width:4.34rem;height:3.34rem;position:absolute;background:url(<?php echo IMG;?>/zhidian.png) no-repeat center bottom;background-size:cover;bottom:0;right:1rem;z-index:9997;"></div>
			</div> 
	-->
			<?php } ?>
			<div class='tynsb' style='position:absolute;height:0.4rem;bottom:0.1rem;left:0.24rem;font-size:0.24rem;z-index:999;width:1.5rem;color:#fff;z-index:99;line-height:0.4rem;
			font-family:"微软雅黑";background: url(<?php echo IMG;?>/1_06.png) no-repeat left center; background-size:0.38rem 0.3rem;padding-left:0.5rem'>
			1/10</div>
			<div class="weui_dialog_alert" style="position:absolute;z-index:9;width:100%;bottom:0;height:0.6rem" >
				<div class="weui_dialog" style="height:100%;width:100%;top:0;background:black;opacity:0.3;z-index:9;"></div>
			</div> 
		</div>
		
		<div class="shop_ifo_1" style="border-bottom:1px solid #aaa">
			<div class="fz_35 ml20 mb20 fw_b"><?php echo $output['store']['store_name'];?></div>
			<div class="ml20">
				<?php if(isset($output['store']['store_label']) && !empty($output['store']['store_label'])){ ?>
				<?php foreach($output['store']['store_label'] as $key => $val){ ?>
					<p class="fl mr20 lh_40 boder_ffc603 c_ffc603 plr_7 br_3" style="font-size:0.24rem;"><?php echo $val;?></p>
				<?php } ?>
				<?php } ?>
				
			</div>
		</div>
		<div style="display: -webkit-flex;display:flex;background:#fff;margin-bottom:0.2rem;position:relative">
				<dl style="flex:1;height:1.18rem" onclick="house_des()">
					<dt style="height:0.64rem;width:100%;background:url(<?php echo IMG;?>/1_11.png) no-repeat center bottom; background-size:0.44rem 0.44rem;margin-bottom:0.1rem;"></dt>
					<dd style='text-align:center;font-size:0.2rem;font-family:"微软雅黑"'>别墅描述</dd>
				</dl>
				<dl style="flex:1;height:1.18rem">
					<a href="?act=guanjia&op=guanjia&guanjia_id=<?php echo $output['guanjiapl']['guanjia_id']?>">
						<dt style="height:0.64rem;width:100%;background:url(<?php echo IMG;?>/1_13.png) no-repeat center bottom; background-size:0.44rem 0.44rem;margin-bottom:0.1rem;"></dt>
						<dd style='text-align:center;font-size:0.2rem;font-family:"微软雅黑"'>管家详情</dd>
					</a>
				</dl>
				<dl style="flex:1;height:1.18rem">
					<a href="?act=order&op=userdian&store_id=<?php echo $output['store_id'];?>">
						<dt style="height:0.64rem;width:100%;background:url(<?php echo IMG;?>/1_15.png) no-repeat center bottom; background-size:0.44rem 0.44rem;margin-bottom:0.1rem;"></dt>
						<dd style='text-align:center;font-size:0.2rem;font-family:"微软雅黑"'>用户点评</dd>
					</a>
				</dl>
				<dl style="flex:1;height:1.18rem">
					<a href="?act=order&op=shangpinzhanshi&store_id=<?php echo $output['store']['store_id'];?>">
						<dt style="height:0.64rem;width:100%;background:url(<?php echo IMG;?>/1_18.png) no-repeat center bottom; background-size:0.44rem 0.44rem;margin-bottom:0.1rem;"></dt>
						<dd style='text-align:center;font-size:0.2rem;font-family:"微软雅黑"'>商品展示</dd>
					</a>
				</dl>
				<div style="height:0.8rem;border-left:0.01rem solid #aaa;position:absolute;top:0.19rem;left:1.86rem"></div>
				<div style="height:0.8rem;border-left:0.01rem solid #aaa;position:absolute;top:0.19rem;left:50%"></div>
				<div style="height:0.8rem;border-left:0.01rem solid #aaa;position:absolute;top:0.19rem;right:1.86rem"></div>
		</div>
		<!-- 配置 -->
		<!--
	    <?php if(isset($output['store']['editorValue'][0])){ echo $output['store']['editorValue'][0];}?>
		<div class="user_des mb20 pb_20">
			<div class="user_des_head bgc_ffc603 pl_20 fz_30 c_fff">用户点评 (<span><?php echo $output['yonghupl_count'] > 0 ? $output['yonghupl_count'] : 0;?></span>)</div>
			<?php if($output['yonghupl_count'] > 0){ ?>
			<div class="user_des_body pl_20 pt_20">
				<div style="overflow: hidden; height: 1.22rem;">
					<div class="user_des_body_head fl mr20" style="background: url(<?php echo $output['yonghupl']['user_logo']?>) no-repeat center; background-size: 100% 100%;"></div>
					<div class="fl">
						<p class="user_des_body_name fz_30 fw_b "><?php echo $output['yonghupl']['nickname'];?></p>
						<p class="user_des_body_des c_64"><?php echo date('Y年m月d日',$output['yonghupl']['create_time']);?></p>
						<p class="user_des_body_star">
							<?php $i = 1 ; for($i;$i <= $output['yonghupl']['evaluation_num']; $i ++){ ?>
								<img src="<?php echo IMG;?>/star.png">
							<?php } ?>
						</p>
					</div>
				</div>
				<div class="figcaption pt_20 mb20"><p><?php echo $output['yonghupl']['message'];?></p></div>
				<a href="?act=order&op=userdian&store_id=<?php echo $output['store_id'];?>"><div class="user_des_more">点击查看全部评论</div></a>
			</div>
			<?php }else{ ?>
			<div class="user_des_body pl_20 " style="font-size:20px;padding-top:15px">
			暂无评论
			</div>
			<?php } ?>			
		</div>
		<div class="housekeep_ifo" >
			<div class="housekeep_ifo_head" style="background: url(<?php echo IMG;?>/tg_lt.png) no-repeat 95% center; background-size: 0.17rem 0.28rem;">
				<div class="housekeep_ifo_head_img fl" style="background:url(<?php echo $output['guanjiapl']['guanjia_logo'];?>) no-repeat left center; background-size: cover;"></div>
				<a href="?act=guanjia&op=guanjia&guanjia_id=<?php echo $output['guanjiapl']['guanjia_id']?>">
				<div class="housekeep_ifo_head_itd fl">
					<div>
						<div style="height: 0.51rem;">
							<span class="fl" style="height: 0.51rem;">管家&nbsp;</span>
							<?php $i = 1 ; for($i;$i <= $output['guanjiapl']['guanjia_shuzhi']; $i ++){ ?>
								<img style="margin-top:0.115rem" src="<?php echo IMG;?>/tg_heart.png">
							<?php } ?>
						</div>
						<div>
							<?php foreach($output['guanjiapl']['guanjia_biaoqian'] as $key => $val){ ?>
								<p class="fl mr20 lh_40 boder_ffc603 c_ffc603 plr_7 br_3 fw_b"><?php echo $val;?></p>
							<?php } ?>					
						</div>
					</div>
				</div>
				</a>
			</div>
			<?php if(isset($output['store']['editorValue'][5])){ echo $output['store']['editorValue'][5];};?>
		</div>
		<a href="?act=order&op=shangpinzhanshi&store_id=<?php echo $output['store']['store_id'];?>">
		<div style="height:0.5rem; padding:0.2rem;line-height:0.5rem;font-size:0.36rem;font-family:'微软雅黑';margin-bottom:0.2rem;background:#fff url(<?php echo IMG;?>/tg_lt.png) no-repeat 95% center; background-size: 0.17rem 0.28rem;">商品展示</div>
		</a>
				-->
				
		<div class="map">
			<!--<div class="calendar1_head" style="padding-top: 0.36rem; padding-bottom: 0.36rem;">别墅位置</div>-->
			 <div style="width:100%;height:3rem;" id="dituContent"></div>
			 <div class="fz_30 ml20" style="font-size:0.3rem;color:#333;font-family:'微软雅黑';height:0.44rem;margin-top:0.2rem;padding-left:0.6rem;background: url(<?php echo IMG;?>/1_24.png) no-repeat left; background-size:0.44rem 0.44rem ;line-height:0.44rem"><?php echo $output['store']['store_xx_address'];?></div>
		</div>
		<div class="calendar1">
			<div class="calendar1_head">别墅日历</div>
			
			<!-- 旧日历 -->
			<!--
			<div id="demo">
  				<div id="ca"></div>
			</div>
			-->
			<div id="calendar">
				<div id="tools">
					<div class="l" style="font-size:0.3rem;">
						<div style="float:left;position:relative;background:url('<?php echo IMG;?>/1_33.png') no-repeat right center;background-size:0.18rem 0.1rem;padding-right:0.4rem">
							<span id="show_year" style="color:#333;font-size:0.32rem;font-family:'微软雅黑'">年</span>
							<select id="selectYear" style="font-size:0.3rem;opacity:0;position:absolute;left:0px;top:0px;"></select>
						</div>
						<div style="float:left;margin-left:0.5rem;position:relative;background:url('<?php echo IMG;?>/1_33.png') no-repeat right center;background-size:0.18rem 0.1rem;padding-right:0.4rem">
							<span id="show_month" style="color:#333;font-size:0.32rem;font-family:'微软雅黑'">月</span>
							<select id="selectMonth" style="font-size:0.3rem;opacity:0;position:absolute;left:0px;top:0px;"></select>
						</div>
					</div>
					<div class="r">
						<span id="prevMonth" style="margin-right:0.3rem;float:left;width:0.18rem;height:0.28rem;background:url('<?php echo IMG;?>/1_28.png') no-repeat right center;background-size:0.18rem 0.28rem;"></span>
						<span id="nextMonth" style="float:right;;width:0.18rem;height:0.28rem;background:url('<?php echo IMG;?>/1_31.png') no-repeat right center;background-size:0.18rem 0.28rem;"></span>
					</div>
				</div>
				<table id="showTable">
					<thead>
						<tr>
							<th>日</th>
							<th>一</th>
							<th>二</th>
							<th>三</th>
							<th>四</th>
							<th>五</th>
							<th>六</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
<div class="weui_dialog_alert sharee_spe" id="sharee_spe_tg"  style="position:fixed;z-index:999999;width:100%;height:100%;top:0;display:none">
	<div class="weui_dialog" style="height:100%;width:100%;top:0;background:white;opacity:0;z-index:9998;"></div>
	<div class="weui_mask">
		<div class="select_day">
			<div>
				<div class="select_day_head">请选择场次<span class="sharee_spe_close" style="float: right; padding-right: 0.1rem;">X</span></div>
				<div class="select_day_body">
					<div class="select_day_body_l fl lk1">
						<div>早场</div>
						<div><?php echo $output['changci'][0]['start_time'];?>-<?php echo $output['changci'][0]['end_time'];?></div>
					</div>
					<?php if($output['store']['store_id'] != 2 || true){ ?>
					<div class="select_day_body_r fl lk2">
						<div>晚场</div>
						<div><?php echo $output['changci'][1]['start_time'];?>-<?php echo $output['changci'][1]['end_time'];?></div>
					</div>	
					<?php }else{ ?>
					<div class="select_day_body_r fl">
						<div style="margin-top:0.5rem;fant-size:2.3rem">暂未开放</div>
					</div>		
					<?php } ?>
				</div>
			</div>
			<div class="select_day_button">确定</div>
		</div>
	</div>
</div>

			<div style="margin:0 auto; width:94%;padding-top: 0.25rem;font-size: 0.32rem; color:#333;border-top:1px dashed #aaa;">别墅每天可被预定两场</div>	
			 <div class="keep_know_content_spe">
				 白场时间：<?php echo $output['changci'][0]['start_time'];?>-<?php echo $output['changci'][0]['end_time'];?> 夜场时间:<?php echo $output['changci'][1]['start_time'];?>-<?php echo $output['changci'][1]['end_time'];?>
			 </div>
		</div>
		<div class="keep_know">
			<?php if(isset($output['store']['editorValue'][1])){ echo $output['store']['editorValue'][1];};?>
		<!--	<div class="keep_know_content_spe">
				白场时间：<?php echo $output['changci'][0]['start_time'];?>-<?php echo $output['changci'][0]['end_time'];?>  夜场时间:<?php echo $output['changci'][1]['start_time'];?>-<?php echo $output['changci'][1]['end_time'];?>
			</div>
			-->
			<div class="keep_know_content_spe" style="padding-top:0.1rem;">
				取消扣款：在线支付订单后，为了更好的服务客户，如果1小时内取消订单可全额退款，1小时外取消订单定金扣除后全额退款，详情请留意订单填写页中的条约说明。
			</div>
			<div class="keep_know_content_money">
				特殊说明&费用
			</div>
			<div class="keep_know_content_spe">
				入住押金：￥<?php echo $output['changci'][0]['deposit'];?>，离店后无设施损坏等问题，押金全额退还。
			</div>
			<div class="keep_know_content_spe">
				额外费用及加床：别墅允许加人入住，暂时不限制人数
			</div>
			<div class="keep_know_content_spe">
				附：禁止携带宠物入内
			</div>
			<div class="user_des_more user_des_more_hh" onclick="get_more()">查看更多</div>
		</div>
		<div class="tg_answer">
			<div class="tg_answer_1">
				<dl>
					<dt style="background: url(<?php echo IMG;?>/share_icon.png) no-repeat center ; background-size:0.44rem 0.44rem;"></dt>
					<dd onclick="share()">分享</dd>
				</dl>
			</div>
			<div class="tg_answer_1">
				<dl>
					<dt style="background: url(<?php echo IMG;?>/phone.png) no-repeat center ; background-size:0.44rem 0.44rem;"></dt>
					<dd><a style="color:#646464" href="tel:<?php echo $output['guanjiapl']['guanjia_phone'];?>">手机</a></dd>
				</dl>
			</div>
			<div class="tg_answer_3"  >&yen;<span id="yuding_price" >0</span>起</div>
			<div class="tg_answer_4" onclick="lijiyuding()">立即预定</div>
		</div>
	<div class="weui_dialog_alert sharee" style="position:fixed;z-index:999999;width:100%;height:100%;top:0;display:none" onclick="dis()">
		<div class="weui_dialog" style="height:100%;width:100%;top:0;background:black;opacity:0.8;z-index:9998;"></div>
		<div class="weui_mask"  style="width:100%;height:70%;position:absolute;background:url(<?php echo IMG;?>/sharee.png) no-repeat center bottom;background-size:cover;top:0;z-index:9997;"></div>
	</div>
</div>
	<div id="top_1" class="model_des" style="background:white;display: none;">
		<?php if(isset($output['store']['editorValue'][2])){ echo $output['store']['editorValue'][2];};?>
	</div>
	<div class="model_des_spe" style="display: none;background: #fafafa;padding-bottom: 1rem;">
		<div class="te_1">
	        <div class="te_1_1">入住押金</div>
	        <div class="te_1_2">&yen;<?php echo $output['changci'][0]['deposit'];?>，离店后无设施损坏等问题，押金全额退还</div>
	    </div>
		<?php if(isset($output['store']['editorValue'][3])){ echo $output['store']['editorValue'][3];};?>
	</div>
	
	</body>
</html>
<script>
//创建地图函数：
function createMap(){
	var map = new BMap.Map("dituContent");//在百度地图容器中创建一个地图
	var point = new BMap.Point(<?php echo $output['store']['position_x']?>,<?php echo $output['store']['position_y']?>);//定义一个中心点坐标
	map.centerAndZoom(point,15);//设定地图的中心点和坐标并将地图显示在地图容器中
	window.map = map;//将map变量存储在全局
}

//标注点数组
var markerArr = [{title:"<?php echo $output['store']['map_title']?>",content:"<?php echo $output['store']['store_xx_address']?>",point:"<?php echo $output['store']['position2']?>",isOpen:1,icon:{w:21,h:21,l:46,t:46,x:1,lb:10}}
	 ];
//创建marker
    
</script>

<script>

		var over_post = {};
		var store_id = <?php echo $_GET['store_id'];?>;
        window.onload = function() {
			
            var text1 = document.getElementById('text1');
                calendar();


			var dat1 = {};
			var dat2 = {};
			var dat3 = {};
			function get_month_order_reserve(YY,mm,dd){
				
				var to_year = $('#selectYear option:selected').val();
				var to_month = parseInt($('#selectMonth option:selected').val())+1;
			
				function init_order(){
					if(dat3 != null){
						$('#showTable td').each(function(i){
							var Y = $('#selectYear option:selected').val();
							var m = parseInt($('#selectMonth option:selected').val())+1;
							var d = $(this).html();
							var sss = Y + '-' + m + '-' + d;
							for(k in dat3){
								if(k == sss){
									$(this).attr('time',k);
									$(this).attr('data2',dat3[k]);
									var abc = $(this);
									var code = dat3[k];
									abc.css('color','transparent');
									switch(code){
									case 1:
										abc.css('background','');
										abc.css('color','#000');
									break;
									case 2:
										abc.css('background','url(<?php echo IMG;?>/leftcircle.png) no-repeat center');
									break;
									case 3:
										abc.css('background','url(<?php echo IMG;?>/rightcircle.png) no-repeat center');
									break;
									case 4:
										abc.css('background','url(<?php echo IMG;?>/t5.png) no-repeat center');
									break;
									case 5:
										abc.css('background','url(<?php echo IMG;?>/t6.png) no-repeat center');
									break;
									case 6:
										abc.css('background','url(<?php echo IMG;?>/t9.png) no-repeat center');
									break;
									case 7:
										abc.css('background','url(<?php echo IMG;?>/t8.png) no-repeat center');
									break;
									case 8:
										abc.css('background','url(<?php echo IMG;?>/t7.png) no-repeat center');
									break;
								}
								}
							}
						});
					}
				}
				var uri = '/api/api.php?commend=get_month_order_reserve';
				var t_one = YY + '-' + mm + '-' + dd;
				$.post(uri,{store_id:store_id,today:t_one},function(data){
					if(typeof(data.msg) == 'object'){
						var da = data.msg;
						var YMD1 = new Date();
						var YMD2 = new Date();
						var dangqianshijian = YMD1.getTime();
						$('#showTable td').each(function(i){
							if(parseInt($(this).html()) > 0){
							//	console.log(da);
								for(x in da){
									var day = parseInt($(this).html());
									YMD2.setDate(day);
									YMD2.setMonth(to_month-1);
									YMD2.setFullYear(to_year);
									//console.log(dangqianshijian +'|' +YMD2.getTime());
									if(day < 10){
										day = '0' + day;
									}
									//dangqianshijian <= YMD2.getTime() 超过的时间不显示图片
									if(x == to_year + '-' + to_month + '-' + day && dangqianshijian <= YMD2.getTime()){
										if(da[x] == '1'){
											$(this).css('background','url(<?php echo IMG;?>/leftcircle.png) no-repeat center');
										}
										if(da[x] == '2'){
											$(this).css('background','url(<?php echo IMG;?>/rightcircle.png) no-repeat center');
										}
										if(da[x] == '3'){
											$(this).css('background','url(<?php echo IMG;?>/dinged.png) no-repeat center');
										//	$(this).css('color','transparent');  //去掉日
										}
										$(this).css('color','transparent');
										$(this).attr('state',da[x]);
										$(this).attr('data',x);
										$(this).attr('is_yuding',1);
									}
								}
							}
						});
					}
					init_order();
					
				},'json');
			}
			
			var to_year = $('#selectYear option:selected').val();
			var to_month = parseInt($('#selectMonth option:selected').val())+1;
			var to_today = $('.today').html();
			get_month_order_reserve(to_year,to_month,to_today);
            function calendar() {

                var calendarElement = document.getElementById('calendar');

                var selectYearElement = document.getElementById('selectYear');
                var selectMonthElement = document.getElementById('selectMonth');
                var showTableElement = document.getElementById('showTable');
                var prevMonthElement = document.getElementById('prevMonth');
                var nextMonthElement = document.getElementById('nextMonth');
				var show_year = document.getElementById('show_year');
                var show_month = document.getElementById('show_month');

                calendarElement.style.display = 'block';

                /*
                 * 获取今天的时间
                 * */
                var today = new Date();

                //设置日历显示的年月
                var showYear = today.getFullYear();
                var showMonth = today.getMonth();

                    //持续更新当前时间
                updateTime();
                //动态生成选择年的select
                for (var i=2017; i<2050; i++) {
                    var option = document.createElement('option');
                    option.value = i;
					
                    option.innerHTML = i;
                    if ( i == showYear ) {
                        option.selected = true;
                    }
                    selectYearElement.appendChild(option);
                }
                //动态生成选择月的select
                for (var i=1; i<13; i++) {
                    var option = document.createElement('option');
                    option.value = i - 1;
                    option.innerHTML = i;
                    if ( i == showMonth + 1 ) {
                        option.selected = true;
                    }
                    selectMonthElement.appendChild(option);
                }

                //初始化显示table
                showTable();
				
				$('#show_year').html($('#selectYear').val()+'年')
				$('#show_month').html((Number($('#selectMonth').val())+1)+'月')
                //选择年
                selectYearElement.onchange = function() {
                    showYear = this.value;
                    showTable();
                    showOption();
					show_year.innerHTML=this.value+'年';
					get_month_order_reserve(parseInt(this.value),(showMonth+1),1);
					huise();
                }

                //选择月
                selectMonthElement.onchange = function() {
                    showMonth = Number(this.value);
                    showTable();
                    showOption();
					show_month.innerHTML=(Number(this.value)+1)+'月';
					get_month_order_reserve(showYear,(Number(this.value)+1),1);
					huise();
                }

                //上一个月
                prevMonthElement.onclick = function() {
                    showMonth--;
                    showTable();
                    showOption();
					var Y = $('#selectYear option:selected').val();
					var m = parseInt($('#selectMonth option:selected').val())+1;
					get_month_order_reserve(Y,m,1);
					huise();
					show_year.innerHTML=$('#selectYear option:selected').val()+'年';
					show_month.innerHTML=(parseInt($('#selectMonth option:selected').val())+1)+'月';
                }

                //下一个月
                nextMonthElement.onclick = function() {
                    showMonth++;
                    showTable();
                    showOption();
					var Y = $('#selectYear option:selected').val();
					var m = parseInt($('#selectMonth option:selected').val())+1;
					get_month_order_reserve(Y,m,1);
					huise();
					show_year.innerHTML=$('#selectYear option:selected').val()+'年';
					show_month.innerHTML=(parseInt($('#selectMonth option:selected').val())+1)+'月';
                }
				function huise(){
					$('#showTable td').each(function(){
						var nian = $('#selectYear option:selected').val();
						 var yue = parseInt($('#selectMonth option:selected').val())+1;
						 var ri = $(this).html();
						 var date_time = new Date();
						 var date_time2 = new Date();
						 date_time.setDate(ri);
						 date_time.setMonth(yue-1);
						 date_time.setYear(nian);
						 var d1 = date_time.getTime();
						 var d2 = date_time2.getTime();
						 if(d1 < d2){
							 $(this).css('color','#cccccc');
						 }
					})
				}
				huise();
				
				var ll = rr = true;  //是否允许被点击
				var that = null;  	//控制当前被点击的
				$('#showTable').on('click','td',function(){
					 var nian = $('#selectYear option:selected').val();
					 var yue = parseInt($('#selectMonth option:selected').val())+1;
					 var ri = $(this).html();
					 $(this).css('color','transparent');
					 var date_time = new Date();
					 var date_time2 = new Date();
					 date_time.setDate(ri);
					 date_time.setMonth(yue-1);
					 date_time.setYear(nian);
					 var d1 = date_time.getTime();
					 var d2 = date_time2.getTime();
					 if(d1 < d2){
						 return false;
					 }
					 
					 
					 console.log(date_time);
					 if(ri == ''){
						 return false;
					 }
					 that = $(this);
					 that.time = nian + '-' + yue + '-' + ri;
					 that.l = that.r = true;
					 
					 if(typeof($(this).attr('data2')) == 'undefined' ){
						  that.l = that.r = false;
					 }
					
					 if(typeof($(this).attr('data2')) != 'undefined' ){
						var data2 = $(this).attr('data2');
						switch(data2){
							case '1':
								that.l = that.r = false;
							break;
							case '2':
								that.l = that.r = false;
							break;
							case '3':
								that.l = false;
							break;
							case '4':
								ll = false
							break;
							case '5':
								rr = false;
							break;
							case '6':
								that.r = false;
							break;
							case '7':
								that.l = false;
							break;
						} 
					 }
					 
					 if($(this).attr('state') == '1' ){
						$('.lk1').css('background','url(<?php echo IMG;?>/dinged_la.png) no-repeat center');//dinged_la.png
						$('.lk1').css('backgroundSize','1.4rem 1.4rem');
						$('.lk1 div').hide();
						ll = false;
						that.l = false;
					 }
					 if($(this).attr('state') == '2' || $(this).attr('data2') == '3'){
						$('.lk2 div').hide();
						$('.lk2').css('background','url(<?php echo IMG;?>/dinged_la.png) no-repeat center');//dinged_la.png
						$('.lk2').css('backgroundSize','1.4rem 1.4rem');
						rr = false;
						that.r = false;
					 }
					 if($(this).attr('state') == '3'){
						 return false;
					 }
					
					 if(that.l){
						 $('.lk1').css('backgroundColor','rgb(255, 198, 3)');
					 }
					 if(that.r){
						 $('.lk2').css('backgroundColor','rgb(255, 198, 3)');
					 }
					 
					
					 $('#sharee_spe_tg').show();
				});
				
				$('.sharee_spe_close').click(function(){
					$('#sharee_spe_tg').hide();
					box_init();
				})
				var data2 = 0;
				var selected_num = 0;
				var post_data = {};
				
				var left_num = 0;
				var right_num = 0;
				var chongjian = 0;
				var str4 = 0;
				var shuju_f = false;
				$('.select_day_button').click(function(){
					var str1 = that.attr('time');
					var str2 = that.attr('data2');
					var str3 = that.css('background-image');
			
					if(that.l == false && that.r == false){
						data2 = 1;
						selected_num = 0;
					}
					if(ll == false && that.r == false){
						data2 = 2;
						selected_num = 0;
					}
					if(rr == false && that.l == false){
						data2 = 3;
						selected_num = 0;
					}
					if(ll == false && that.r == true){  //左边一杯选中
						data2 = 4;
						selected_num = 2;
					}
					if(rr == false && that.l == true){
						data2 = 5;
						selected_num = 1;
					}
					if(rr == true && that.l == true && that.r == false){
						data2 = 6;
						selected_num = 1;
					}
					if(ll == true && that.l == false && that.r == true){
						data2 = 7;
						selected_num = 2;
					}
					if(that.l == true && that.r == true){
						data2 = 8;
						selected_num = 3;
					}
					
					dat3[that.time] = data2;
					if(typeof(dat1[that.time]) != 'undefined'){
						str4 = dat1[that.time];
						shuju_f = true;
					}
					
					if(selected_num > 0){
						dat1[that.time] = selected_num;
					}else{
						dat1[that.time] = 0;
						dat3[that.time] = 1;
					}
					for(c in dat1){
						if(dat1[c] == 2){
							dat2[c] = dat1[c];
							right_num ++;
						}
					}
					for(b in dat1){
						if(dat1[b] == 3){
							dat2[b] = dat1[b];
							chongjian ++;
						}
					}
					for(a in dat1){
						if(dat1[a] == 1){
							dat2[a] = dat1[a];
							left_num ++;
						}
					}
					over_post = dat2;
					var url = '/api/api.php?commend=reserve';
					var ttt = that;
					//设置颜色
					/*
					if(selected_num > 0){
						that.css('color','#fff');
					}else{
						that.css('color','#000');
					}
					*/
					$.post(url,{store_id:store_id,dat2:dat2},function(ddd){
						if(ddd.msg.code == '1'){
							$('#yuding_price').html(ddd.msg.over_price);
						}
						if(ddd.msg.code == '-1'){  //报错
						//	ttt.css('color','#000');  //把颜色还回去
							alert(ddd.msg.msg);
							ttt.attr('time',str1);
						//	alert(str2);
							if(typeof(str2) == 'undefined'){
								ttt.attr('data2','1');
									ttt.css('color','#000');
							}else{
								if(str2 == 1){
									ttt.css('color','#000');
								}
								ttt.attr('data2',str2);
							}
							dat3[ttt.time] = '';
							if(shuju_f){
								over_post[ttt.time] = str4;
								dat1[ttt.time] = str4;
							}else{
								delete over_post[ttt.time];
								delete dat1[ttt.time];
							}
							shuju_f = false;
							
							ttt.css('backgroundImage',str3);
							ttt.css('backgroundRepeat','no-repeat');
							ttt.css('backgroundPosition','center');
						}
						
					},'json');
					switch(data2){
						case 1:
							that.css('background','');
							that.css('color','#000');
						break;
						case 2:
							that.css('background','url(<?php echo IMG;?>/leftcircle.png) no-repeat center');
						break;
						case 3:
							that.css('background','url(<?php echo IMG;?>/rightcircle.png) no-repeat center');
						break;
						case 4:
							that.css('background','url(<?php echo IMG;?>/t5.png) no-repeat center');
						break;
						case 5:
							that.css('background','url(<?php echo IMG;?>/t6.png) no-repeat center');
						break;
						case 6:
							that.css('background','url(<?php echo IMG;?>/t9.png) no-repeat center');
						break;
						case 7:
							that.css('background','url(<?php echo IMG;?>/t8.png) no-repeat center');
						break;
						case 8:
							that.css('background','url(<?php echo IMG;?>/t7.png) no-repeat center');
						break;
					}
					that.attr('time',that.time);
					that.attr('data2',data2);
					that.attr('class','curr');
					
					$('#sharee_spe_tg').hide();
					$('.tg_answer_3').show();
					box_init();
				});
				
				//确定和关闭初始化
				function box_init(){
					ll = rr = true;
					$('.lk2 div').show();
					$('.lk1 div').show();
					$('.lk1').css('background','');
					$('.lk2').css('background','');
					that = null;
					state = 0;
					selected_num = 0;
					left_num = right_num = 0;
					dat2 = {};
				}
				$('.lk1').click(function(){
					if(!ll){
						return false;
					}
					if($(this).css('backgroundColor')=='rgb(251, 251, 251)'){
						$(this).css('backgroundColor','rgb(255, 198, 3)');
						that.l = true;
					}else{
						$(this).css('backgroundColor','rgb(251, 251, 251)');
						that.l = false;
					};
				})
				$('.lk2').click(function(){
					if(!rr){
						return false;
					}
					if($(this).css('backgroundColor')=='rgb(251, 251, 251)'){
						$(this).css('backgroundColor','rgb(255, 198, 3)');
						that.r = true;
					}else{
						$(this).css('backgroundColor','rgb(251, 251, 251)');
						that.r = false;
					};
				})
                /*
                * 实时更新当前时间
                * */
                function updateTime() {
                    var timer = null;
                    //每个500毫秒获取当前的时间，并把当前的时间格式化显示到指定位置
                    var today = new Date();
                    timer = setInterval(function() {
                        var today = new Date();
                    }, 500);
                }

                function showTable() {
                    showTableElement.tBodies[0].innerHTML = '';
                    //根据当前需要显示的年和月来创建日历
                    //创建一个要显示的年月的下一个的日期对象
                    var date1 = new Date(showYear, showMonth+1, 1, 0, 0, 0);
                    //对下一个月的1号0时0分0秒的时间 - 1得到要显示的年月的最后一天的时间
                    var date2 = new Date(date1.getTime() - 1);
                    //得到要显示的年月的总天数
                    var showMonthDays = date2.getDate();
                    //获取要显示的年月的1日的星期,从0开始的星期
                    date2.setDate(1);
                    //showMonthWeek表示这个月的1日的星期，也可以作为表格中前面空白的单元格的个数
                    var showMonthWeek = date2.getDay();

                    var cells = 7;
                    var rows = Math.ceil( (showMonthDays + showMonthWeek) / cells );

                    //通过上面计算出来的行和列生成表格
                    //没生成一行就生成7列
                    //行的循环
                    for ( var i=0; i<rows; i++ ) {

                        var tr = document.createElement('tr');

                        //列的循环
                        for ( var j=0; j<cells; j++ ) {

                            var td = document.createElement('td');

                            var v = i*cells + j - ( showMonthWeek - 1 );

                            //根据这个月的日期控制显示的数字
                            //td.innerHTML = v;
                            if ( v > 0 && v <= showMonthDays  ) {

                                //高亮显示今天的日期
                                if ( today.getFullYear() == showYear && today.getMonth() == showMonth && today.getDate() == v ) {
                                    td.className = 'today';
                                }

                                td.innerHTML = v;
                            } else {
                                td.innerHTML = '';
                            }

                            td.ondblclick = function() {
                                calendarElement.style.display = 'none';

                                text1.value = showYear + '年' + (showMonth+1) + '月' + this.innerHTML + '日';
                            }

                            tr.appendChild(td);

                        }

                        showTableElement.tBodies[0].appendChild(tr);

                    }
                }

                function showOption() {

                    var date = new Date(showYear, showMonth);
                    var sy = date.getFullYear();
                    var sm = date.getMonth();
            //        console.log(showYear, showMonth)

                    var options = selectYearElement.getElementsByTagName('option');
                    for (var i=0; i<options.length; i++) {
                        if ( options[i].value == sy ) {
                            options[i].selected = true;
                        }
                    }

                    var options = selectMonthElement.getElementsByTagName('option');
                    for (var i=0; i<options.length; i++) {
                        if ( options[i].value == sm ) {
                            options[i].selected = true;
                        }
                    }
                }
            }

            /*
             * 获取指定时间的时分秒
             * */
            function getTime(d) {
                return [
                    addZero(d.getHours()),
                    addZero(d.getMinutes()),
                    addZero(d.getSeconds())
                ].join(':');
            }

            /*
            * 获取指定时间的年月日和星期
            * */
            function getDate(d) {
                return d.getFullYear() + '年'+ addZero(d.getMonth() + 1) +'月'+ addZero(d.getDate()) +'日 星期' + getWeek(d.getDay());
            }

            /*
            * 给数字加前导0
            * */
            function addZero(v) {
                if ( v < 10 ) {
                    return '0' + v;
                } else {
                    return '' + v;
                }
            }

            /*
            * 把数字星期转换成汉字星期
            * */
            function getWeek(n) {
                return '日一二三四五六'.split('')[n];
            }
			
			
        }
		
		//立即预订
		function lijiyuding(){
		//	console.log(over_post);return ;
			var price = $('#yuding_price').html();
			//价格不能为空
			if(price != '' && price != '0'){
				var url = '/api/api.php?commend=lijiyuding';
				$.post(url,{store_id:store_id,over_post:over_post},function(state){
					if(state.msg.code == '1'){
						window.location.href="?act=order&op=order&order_id="+state.msg.order_id;
					}else{
						alert(state.msg.msg);
					}
				},'json');
			}else{
				alert('请预约时间');
			}
		}
    </script>
	<script>
	</script>
	 <style>
    	
        #calendar {
        	width: 94%;
            padding: 0px 3%;
            background: #fff;
        }

        #tools {
            padding: 0.3rem 0;
            height: 30px;
            color: #000;
        }
        #tools .l {
            float: left;
        }
        #tools .r {
            float: right;
			margin-right:15px;
        }
        table {
            width: 100%;
            color: #646464;
			font-size:0.3rem;
			border-collapse: collapse;
        }
        table th {
            color:gary;
        }
        table td {
            text-align: center;
            cursor: default;
			line-height:1rem;
			height: 1rem;
			font-size:0.32rem;
			color:#333;
        }
        table td.today {
            color: red;
        }
		#showTable thead tr th{
			line-height:0.3rem;
			padding-top:0.3rem;
			border-top:1px solid #aaa;
			font-size:0.34rem;
			color:#333;
		}
    </style>