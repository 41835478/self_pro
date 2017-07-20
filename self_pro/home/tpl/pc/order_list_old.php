<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link type="text/css" rel="stylesheet" href="<?php echo CSS;?>/jquery.mobile-1.4.5.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo CSS;?>/order_list.css" />
<script type="text/javascript" src="<?php echo JS;?>/jquery-2.1.4.min.js" ></script>
<script type="text/javascript" src="<?php echo JS;?>/jquery.mobile-1.4.5.min.js" ></script>
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
		});
</script>
</head>
<body>
<div data-role="page">
<div data-role = "content-floud">			
	<div style="font-family: '微软雅黑';">
		<ul id="hear">
			<li class="action" style="border-bottom: 2px solid #ffc603;height: 43px;"><a href="#">已完成</a></li>
			<li><a href="#" >已取消</a></li>
			<li><a href="#" >待支付</a></li>
		</ul>
		<ul id="contentop">
			
			<li class="action">
				<!-- 已完成 -->
				<?php if(isset($output['yiwancheng']) && !empty($output['yiwancheng'])){ ?>
				<?php foreach($output['yiwancheng'] as $key => $val){ ?>
					<div class="alo">
						<div class="alo_head">
							<div><?php echo $val['store_name'];?></div>
							<div></div>
							<div><a href="#">再次预定</a></div>						
						</div>
						<div class="alo_body">
							<div></div>
							<div>
								<p><?php echo $val['store_xx_address'];?></p>
								<p>订单编号：<?php echo $val['order_no'];?></p>
								<p><?php echo $val['goods_label'];?>：<?php echo date('Y-m-d H:i:s',$val['start_time']);?>-<?php echo date('Y-m-d H:i:s',$val['end_time']);?></p>
							</div>
							<div>合计：￥<?php echo $val['over_price'];?></div>
						</div>
						<div class="alo_foot">
							<div>状态：已完成</div>
							<div>下单时间：<?php echo date('Y-m-d H:i:s',$val['create_time']);?></div>
						</div>
					</div>
				<?php } ?>
				<?php } ?>
				<!--  实例
				<div class="alo">
					<div class="alo_head">
						<div>杭州下沙大学店</div>
						<div></div>
						<div>再次预定</div>						
					</div>
					<div class="alo_body">
						<div></div>
						<div>
							<p>保利江语海8栋1号别墅</p>
							<p>订单编号：MM1230254</p>
							<p>白场：2017-04-28 10:00-17:00</p>
						</div>
						<div>合计：￥4000</div>
					</div>
					<div class="alo_foot">
						<div>状态：已完成</div>
						<div>下单时间：2017-04-27 14:28:56</div>
					</div>
				</div>
				-->
			</li>
			
			<li>
				<!-- 已取消 -->
				<?php if(isset($output['yiquxiao']) && !empty($output['yiquxiao'])){ ?>
				<?php foreach($output['yiquxiao'] as $key => $val){ ?>
				<div class="alo">
					<div class="alo_head">
						<div><?php echo $val['store_name'];?></div>
						<div></div>
						<div><a href="#">再次预定</a></div>						
					</div>
					<div class="alo_body">
						<div></div>
						<div>
							<p><?php echo $val['store_xx_address'];?></p>
							<p>订单编号：<?php echo $val['order_no'];?></p>
							<p><?php echo $val['goods_label'];?>：<?php echo date('Y-m-d H:i:s',$val['start_time']);?>-<?php echo date('Y-m-d H:i:s',$val['end_time']);?></p>
						</div>
						<div>合计：￥<?php echo $val['over_price'];?></div>
					</div>
					<div class="alo_foot">
						<div>状态：已取消</div>
						<div>下单时间：<?php echo date('Y-m-d H:i:s',$val['create_time']);?></div>
					</div>
				</div>
				<?php } ?>
				<?php } ?>
				<!--  实例
			   <div class="alo">
					<div class="alo_head">
						<div>杭州下沙大学店</div>
						<div></div>
						<div>再次预定</div>						
					</div>
					<div class="alo_body">
						<div></div>
						<div>
							<p>保利江语海8栋1号别墅</p>
							<p>订单编号：MM1230254</p>
							<p>白场：2017-04-28 10:00-17:00</p>
						</div>
						<div>合计：￥4000</div>
					</div>
					<div class="alo_foot">
						<div>状态：已取消</div>
						<div>下单时间：2017-04-27 14:28:56</div>
					</div>
				</div>
				-->
			</li>
			
			<li>
				<!-- 待支付 -->
				<?php if(isset($output['daizhifu']) && !empty($output['daizhifu'])){ ?>
				<?php foreach($output['daizhifu'] as $key => $val){ ?>
				<div class="usl">
					<div class="alo_head">
						<div><?php echo $val['store_name'];?></div>
						<div style="display: none;"></div>
						<div><a href="#">立即支付</a></div>
						<div><a href="#">取消订单</div>						
					</div>
					<div class="alo_body">
						<div></div>
						<div>
							<p><?php echo $val['store_xx_address'];?></p>
							<p>订单编号：<?php echo $val['order_no'];?></p>
							<p><?php echo $val['goods_label'];?>：<?php echo date('Y-m-d H:i:s',$val['start_time']);?>-<?php echo date('Y-m-d H:i:s',$val['end_time']);?></p>
						</div>
						<div>合计：￥<?php echo $val['over_price'];?></div>
					</div>
					<div class="alo_foot">
						<div>状态：待支付</div>
						<div>下单时间：<?php echo date('Y-m-d H:i:s',$val['create_time']);?></div>
					</div>
				</div>
				<?php } ?>
				<?php } ?>
				<!--  实例
				<div class="usl">
					<div class="alo_head">
						<div>杭州下沙大学店</div>
						<div style="display: none;"></div>
						<div>立即支付</div>
						<div>取消订单</div>						
					</div>
					<div class="alo_body">
						<div></div>
						<div>
							<p>保利江语海8栋1号别墅</p>
							<p>订单编号：MM1230254</p>
							<p>白场：2017-04-28 10:00-17:00</p>
						</div>
						<div>合计：￥4000</div>
					</div>
					<div class="alo_foot">
						<div>状态：待支付</div>
						<div>下单时间：2017-04-27 14:28:56</div>
					</div>
				</div>	
				-->					
			</li>
		</ul>
	</div>			
</div>	

</div>
</div>

</body>
</html>

