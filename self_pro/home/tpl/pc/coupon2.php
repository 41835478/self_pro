<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS?>/index.css"/>
    <title>我的优惠卷</title>
</head>
<body>
<div class="you_1">
    <div class="you_1_y you_lk" data="0">可使用</div>
    <div class="you_1_n you_lk" data="1">不可用</div>
    <div class="clear"></div>
    <div class="you_1_y_btm ">
		<?php if(isset($output['is_use_list']) && !empty($output['is_use_list'])){ ?>
		<?php foreach($output['is_use_list'] as $key => $val){ ?>
		<div class="you_1_y_btm_1" data="<?php echo $val['coupon_id'];?>">
            <div class="you_1_y_btm_1_lft">&yen;<?php echo $val['coupon_price'];?></div>
            <div class="you_1_y_btm_1_rht">
                <div class="you_1_y_btm_1_rht_1"><?php echo $val['coupon_name'];?></div>
                <p><?php echo $val['coupon_desc'];?></p>
                <p><?php echo date('Y年m月d日',$val['start_time']);?>-<?php echo date('Y年m月d日',$val['end_time']);?></p>
                <i class="you_1_y_btm_1_rht_gou"></i>
            </div>
        </div>
		<?php } ?>
		<?php } ?>
		<div class="none none0" style="background: url(<?php echo IMG;?>/wuyouhuiquan.png) no-repeat center top;background-size: 85px 75px;">
			暂无优惠卷
		</div>	
    </div>
    <div class="you_1_n_btm you_1_y_btm fade">
		<!-- 不可用 -->
		<?php if(isset($output['no_use_list']) && !empty($output['no_use_list'])){ ?>
		<?php foreach($output['no_use_list'] as $key => $val){ ?>
			 <?php if($val['']){ ?>
				<div class="you_1_y_btm_1">
					<div class="you_1_n_btm_1_lft you_1_y_btm_1_lft">&yen;<?php echo $val['coupon_price'];?></div>
					<div class="you_1_y_btm_1_rht">
						<div class="ccc you_1_y_btm_1_rht_1"><?php echo $val['coupon_price'];?></div>
						<p><?php echo $val['coupon_desc'];?></p>
						<p><?php echo date('Y年m月d日',$val['start_time']);?>-<?php echo date('Y年m月d日',$val['end_time']);?></p>
						<i class="you_1_n_btm_1_rht_gou you_1_n_btm_1_rht_gou_1"></i>
					</div>
				</div> 
			 <?php }else{ ?>
				 <div class="you_1_y_btm_1">
					<div class="you_1_n_btm_1_lft you_1_y_btm_1_lft">&yen;<?php echo $val['coupon_price'];?></div>
					<div class="you_1_y_btm_1_rht">
						<div class="ccc you_1_y_btm_1_rht_1"><?php echo $val['coupon_price'];?></div>
						<p><?php echo $val['coupon_desc'];?></p>
						<p><?php echo date('Y年m月d日',$val['start_time']);?>-<?php echo date('Y年m月d日',$val['end_time']);?></p>
						<i class="you_1_n_btm_1_rht_gou you_1_n_btm_1_rht_gou_2"></i>
					</div>
				</div>
			 <?php } ?>
		<?php } ?>
		<?php } ?>
		<div class="none none1" style="background: url(<?php echo IMG;?>/wuyouhuiquan.png) no-repeat center top;background-size: 85px 75px;">
			暂无优惠卷
		</div>	
    </div>
</div>
<div class="you_2">
    确&nbsp;定
</div>
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>
<script>

	$(".you_lk").click(function(){
		disnone($(this).attr('data'));
	});
	if($(".you_1_y_btm").eq(0).has(".you_1_y_btm_1").length == 0){
		$('.none0').show();
	}else{
		$('.none0').hide();
	}
	function disnone(x){
		if($(".you_1_y_btm").eq(x).has(".you_1_y_btm_1").length == 0){
			$('.none').hide();
			$('.none' + x).show();
		}
	}

	$('.you_2').click(function(){
		var url="/api/api.php?commend=set_coupon";
		var order_id = '<?php echo $output['order_id'];?>';
		var coupon_id = $('.redgou').attr('data');
		if(typeof(coupon_id) != 'undefined'){
			$.post(url,{order_id:order_id,coupon_id:coupon_id},function(data){
				if(data.msg.code == '1'){
					window.location.href = "?act=order&op=order&order_id=" + order_id;
				}else{
					alert(data.msg.msg);
				}
			},'json');
		}
		
		
	});
	
</script>
<style>
.none{
		width:100%;
		height:105px;
		position: absolute;
		top: 200px;
		text-align: center;
		color:#ccc;
		font-size:15px ;
		padding-top: 80px;
		font-family: "微软雅黑";
	}
</style>