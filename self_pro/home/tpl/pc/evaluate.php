<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>评价中心</title>
<link type="text/css" rel="stylesheet" href="<?php echo CSS;?>/jquery.mobile-1.4.5.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo CSS;?>/evaluate.css" />
<link rel="stylesheet" href="<?php echo CSS;?>/weui.min.css" />

<script type="text/javascript" src="<?php echo JS;?>/jquery-2.1.4.min.js" ></script>

<script>
		$(function(){
			$("#hear li").click(function(){
				$(this).css({
					borderBottom: "2px solid #ffc603",
					color:'#ffc603',
					height:"43px"
				}).siblings().css({
					borderBottom: "none",
					color:'#646464',
					height:"45px"
				});
			});					
				
			$("#hear li").click(function(){
				$(this).addClass("action").siblings().removeClass("action");
				var index = $(this).index();
				$("#contentop li").eq(index).css("display","block").siblings().css("display","none");
			});
			disnone();
			function disnone(){
				if($("#contentop li").eq(0).has(".alo").length == 0){
					$("#contentop li").eq(0).find('.none').show();
				}
				if($("#contentop li").eq(1).has(".alo").length == 0){
					$("#contentop li").eq(1).find('.none').show();
				}
			}
			
		});
</script>
</head>
<body style="background:#fafafa" >
<div data-role="page">
<div data-role = "content-floud">			
	<div style="font-family: '微软雅黑';">
		<ul id="hear">
			<li class="action" style="border-bottom: 2px solid #ffc603;height: 43px;"><a href="#">待评价</a></li>
			<li><a href="#" >已评价</a></li>
		</ul>
		<ul id="contentop">			
			<li class="action">
				<?php if(isset($output['daipingjia']) && !empty($output['daipingjia'])){ ?>
				<?php foreach($output['daipingjia'] as $key => $val){ ?>
				<div class="alo">
					<div class="alo_body">
						<div style="background:url('<?php echo $val['store_logo'];?>')"></div>
						<div>
							<p><?php echo $val['store_name'];?></p>
							<p><?php echo $val['store_xx_address'];?></p>
						</div>
						<div><a href="?act=user&op=evaluate_detail&order_id=<?php echo $val['order_id'];?>" style="color:#f83600">评价晒单</a></div>
					</div>
				</div>
				<?php } ?>
				<?php } ?>
				
				<div class="none" style="background: url(<?php echo IMG;?>/none.png) no-repeat center top;background-size: 63px 75px;">
					您暂无待评价的订单
				</div>
			</li>
			
			<li>
				<?php if(isset($output['yipingjia']) && !empty($output['yipingjia'])){ ?>
				<?php foreach($output['yipingjia'] as $key => $val){ ?>
				<div class="alo">
					<div class="alo_body">
						<div style="background:url('<?php echo $val['store_logo'];?>')"></div>
						<div>
							<p><?php echo $val['store_name'];?></p>
							<p><?php echo $val['store_xx_address'];?></p>
						</div>
						<div><a href="?act=user&op=pingjiaxiangqing&order_id=<?php echo $val['order_id'];?>" style="color:#f83600">查看评价</a></div>
					</div>
				</div>
				<?php } ?>
				<?php } ?>
				<div class="none" style="background: url(<?php echo IMG;?>/none.png) no-repeat center top;background-size: 63px 75px;">
					您暂无已评价的订单
				</div>
			</li>
		</ul>
	</div>			
</div>	
</div>
</body>
</html>

