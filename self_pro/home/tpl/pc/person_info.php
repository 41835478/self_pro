<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>我的潮趴</title>
		<meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
	</head>
	<link rel="stylesheet" href="<?php echo CSS;?>/weui.min.css" />
	<link rel="stylesheet" href="<?php echo CSS;?>/person.css" />
	<script type="text/javascript" src ="<?php echo JS;?>/jquery-1.12.4.min.js"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
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
	</script>
	<style>
	a,img,button,input,textarea,div{-webkit-tap-highlight-color:rgba(255,255,255,0);}
		.weui_cells {
    margin-top: 0;

}
	</style>
	<body style="padding-bottom: 1.5rem;">	
		<a href="?act=user&op=gerenziliao">
		<div class='person_head' style="background: url(<?php echo IMG;?>/person_head.png) no-repeat center; background-size: cover;">
			<div class='person_spe' style="background: url(<?php echo IMG;?>/short.png) no-repeat 95% center; background-size: 0.23rem 0.4rem;">
				<div class='person_head_img' style="background: url(<?php echo $output['user']['user_logo'];?>) no-repeat center; background-size: cover;"></div>
				<div class='person_head_ifo'>
					<div class='person_head_ifo_1'><?php echo $output['user']['nickname'];?></div>
					<div class='person_head_ifo_2'><?php echo $output['user']['phone'];?></div>
					<div class='person_head_ifo_3'>青铜会员</div>
				<!--<div class='person_head_ifo_3'><?php echo $output['level_name'];?></div> -->
				</div>
			</div>
		</div>
		</a>
		<div style="clear: both;overflow: hidden;">
			<div class="weui_cells weui_cells_access" style="width: 33.3%;float: left;">		
			    <a class="weui_cell" href="?act=user&op=evaluate">
			        <div class="weui_cell_hd">
			            <img src="<?php echo IMG;?>/icon_13.png" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
			        </div>
			        <div class="weui_cell_bd weui_cell_primary">
			            <p>待评价</p>
			        </div>
			    </a>
			</div>
			<div class="weui_cells weui_cells_access" style="width: 33.3%;float: left;">		
			    <a class="weui_cell" href="?act=order&op=wait_pay">
			        <div class="weui_cell_hd">
			            <img src="<?php echo IMG;?>/icon_11.png" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
			        </div>
			        <div class="weui_cell_bd weui_cell_primary">
			            <p>待支付</p>
			        </div>
			    </a>
			</div>
			<div class="weui_cells weui_cells_access" style="width: 33.3%;float: left;">		
			    <a class="weui_cell" href="?act=user&op=dairuzhu">
			        <div class="weui_cell_hd">
			            <img src="<?php echo IMG;?>/icon_12.png" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
			        </div>
			        <div class="weui_cell_bd weui_cell_primary">
			            <p>待入驻</p>
			        </div>
			    </a>
			</div>
		</div>
		
		<div class="weui_cells weui_cells_access" style="margin-top: 0.4rem;">		
		    <a class="weui_cell" href="?act=order&op=order_list">
		        <div class="weui_cell_hd">
		            <img src="<?php echo IMG;?>/icon_1.png" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
		        </div>
		        <div class="weui_cell_bd weui_cell_primary">
		            <p>全部订单</p>
		        </div>
		        <div class="weui_cell_ft">
					<?php if(isset($output['all_order_num']) && $output['all_order_num'] > 0){ echo $output['all_order_num'];}else {echo 0;};?>
		        </div>
		    </a>
		</div>
		<div class="weui_cells weui_cells_access">		
		    <a class="weui_cell" href="?act=order&op=myyaj_ketui">
		        <div class="weui_cell_hd">
		            <img src="<?php echo IMG;?>/icon_2.png" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
		        </div>
		        <div class="weui_cell_bd weui_cell_primary">
		            <p>我的押金</p>
		        </div>
		        <div class="weui_cell_ft">
		        	<?php if(isset($output['yajin_order']) && !empty($output['yajin_order'])){ echo $output['yajin_order']['deposit'];}else {echo 0;};?>
		        </div>
		    </a>
		</div>
		<div class="weui_cells weui_cells_access">		
		    <a class="weui_cell" href="?act=user&op=jifen">
		        <div class="weui_cell_hd">
		            <img src="<?php echo IMG;?>/icon_3.png" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
		        </div>
		        <div class="weui_cell_bd weui_cell_primary">
		            <p>我的积分</p>
		        </div>
		        <div class="weui_cell_ft">
		        	<?php echo $output['user']['user_integral'];?>
		        </div>
		    </a>
		</div>
		<div class="weui_cells weui_cells_access">		
		    <a class="weui_cell" href="?act=user&op=coupon2">
		        <div class="weui_cell_hd">
		            <img src="<?php echo IMG;?>/icon_4.png" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
		        </div>
		        <div class="weui_cell_bd weui_cell_primary">
		            <p>优惠券</p>
		        </div>
		        <div class="weui_cell_ft">
		        	
		        </div>
		    </a>
		</div>
		
		<div class="weui_cells weui_cells_access">		
		    <a class="weui_cell" href="?act=user&op=get_duihuanma">
		        <div class="weui_cell_hd">
		            <img src="<?php echo IMG;?>/HOME_16.gif" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
		        </div>
		        <div class="weui_cell_bd weui_cell_primary">
		            <p>优惠券兑换</p>
		        </div>
		        <div class="weui_cell_ft">
		        	
		        </div>
		    </a>
		</div>
		
		<div class="weui_cells weui_cells_access">		
		    <a class="weui_cell" href="?act=user&op=wei_fap">
		        <div class="weui_cell_hd">
		            <img src="<?php echo IMG;?>/icon_5.png" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
		        </div>
		        <div class="weui_cell_bd weui_cell_primary">
		            <p>未开发票</p>
		        </div>
		        <div class="weui_cell_ft">
		        	
		        </div>
		    </a>
		</div>
		<div class="weui_cells weui_cells_access">		
		    <a class="weui_cell" href="?act=user&op=advice">
		        <div class="weui_cell_hd">
		            <img src="<?php echo IMG;?>/icon_6.png" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
		        </div>
		        <div class="weui_cell_bd weui_cell_primary">
		            <p>意见反馈</p>
		        </div>
		        <div class="weui_cell_ft">
		        	
		        </div>
		    </a>
		</div>
		<div class="weui_cells weui_cells_access">		
		    <a class="weui_cell" href="#">
		        <div class="weui_cell_hd">
		            <img src="<?php echo IMG;?>/icon_7.png" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
		        </div>
		        <div class="weui_cell_bd weui_cell_primary">
		            <p>在线客服</p>
		        </div>
		        <div class="weui_cell_ft">
		        	
		        </div>
		    </a>
		</div>
		<div class="weui_cells weui_cells_access">		
		    <a class="weui_cell" href="tel:4008889610">
		        <div class="weui_cell_hd">
		            <img src="<?php echo IMG;?>/icon_8.png" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
		        </div>
		        <div class="weui_cell_bd weui_cell_primary">
		            <p>客服电话</p>
		        </div>
		        <div class="weui_cell_ft">
					400-888-9610
		        </div>
		    </a>
		</div>
		<div class="weui_cells weui_cells_access">		
		    <a class="weui_cell" href="?act=alldan&op=alldan">
		        <div class="weui_cell_hd">
		            <img src="<?php echo IMG;?>/icon_9.png" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
		        </div>
		        <div class="weui_cell_bd weui_cell_primary">
		            <p>邀请好友</p>
		        </div>
		        <div class="weui_cell_ft">
		        	
		        </div>
		    </a>
		</div>
		<div class="weui_cells weui_cells_access">		
		    <a class="weui_cell" href="?act=user&op=dakehu">
		        <div class="weui_cell_hd">
		            <img src="<?php echo IMG;?>/icon_10.png" style="width:0.44rem;height:0.44rem;margin-right:0.2rem;display:block">
		        </div>
		        <div class="weui_cell_bd weui_cell_primary">
		            <p>企业大客户</p>
		        </div>
		        <div class="weui_cell_ft">
		        	
		        </div>
		    </a>
		</div>
		<footer class="footer">
			<div class="table fs12 bt bgf tc footer_wrap">
				<a style="text-decoration:none;" href="index.php" class="table-cell vm "><i class="ft-icon-plan" style="margin-left:1.03rem"></i></a>
		<!--		<a style="text-decoration:none;" href="?act=user&op=fangjian" class="table-cell vm"><i class="ft-icon-notice"></i>房间</a> -->
				<a style="text-decoration:none;" href="" class="table-cell vm on" ><i class="ft-icon-friends" style="margin-left:2.28rem";></i></a>
			</div>
			<div style="height:1.2rem;width:0.9rem;position:absolute;top:-0.22rem;left:3.3rem;background: url(<?php echo IMG;?>/circleadd.png) no-repeat center;background-size:cover "><a href="?act=user&op=fangjian" style="display:block;height:1.2rem;width:0.9rem;"></a></div>
		</footer>
	</body>
</html>
