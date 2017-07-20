<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link type="text/css" rel="stylesheet" href="<?php echo CSS;?>/jquery.mobile-1.4.5.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo CSS;?>/order_list.css" />
	<link rel="stylesheet" href="<?php echo CSS;?>/weui.min.css" />
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
				
				disnone($(this).attr('data'));
			});
			var order_no = '';
			var order_id = '';
			var sign = '';
			$('.cancel_order').click(function(){
				order_id = $(this).attr('orderid');
				order_no = $(this).attr('orderno');
				sign 	 = $(this).attr('sign');
				$('.daizhifu').show()
			})
			$('.daizhifu .default').click(function(){
				$('.daizhifu').hide()
			})
			$('.daizhifu .primary').click(function(){
				var url = '/api/api.php?commend=quxiaodingdan';
				$.post(url,{order_id:order_id,order_no:order_no,sign:sign},function(data){
					if(data.msg.code == '1'){
						alert(data.msg.msg);
						window.location.href = window.location.href;
					}else{
						alert(data.msg.msg);
					}
				},'json');
				$('.daizhifu').hide()
			})
				
			$('.apply_order').click(function(){
				order_id = $(this).attr('orderid');
				order_no = $(this).attr('orderno');
				sign 	 = $(this).attr('sign');
				$('.yiwancheng').show()
			})
			$('.yiwancheng .default').click(function(){
				$('.yiwancheng').hide()
			})
			$('.yiwancheng .primary').click(function(){
				var url = '/api/api.php?commend=quxiaodingdan2';
				$.post(url,{order_id:order_id,order_no:order_no,sign:sign},function(data){
					if(data.msg.code == '1'){
						alert(data.msg.msg);
						window.location.href = window.location.href;
					}else{
						alert(data.msg.msg);
					}
				},'json');
				$('.yiwancheng').hide()
			})				
			if($("#contentop li").eq(0).has(".alo_l").length == 0){
				$('.none0').show();
			}
			function disnone(x){
				if($("#contentop li").eq(x).has(".alo_l").length == 0){
					$('#contentop li').find('.none').hide();
					$('#contentop li').eq(x).find('.none' + x).show();
				}
			}
		});
</script>
</head>
<body>
<div data-role="page">
<div data-role = "content-floud">			
	<div style="font-family: '微软雅黑';">
		<ul id="hear">
			<li data="0" class="action" style="border-bottom: 2px solid #ffc603;height: 43px;"><a href="#">已完成</a></li>
			<li data="1"><a href="#" >已取消</a></li>
			<li data="2"><a href="#" >待支付</a></li>
		</ul>
		<ul id="contentop">
			
			<li class="action">
				<!-- 已完成 -->
				<?php if(isset($output['yiwancheng']) && !empty($output['yiwancheng'])){ ?>
				<?php foreach($output['yiwancheng'] as $key => $val){ ?>
				<div class="alo alo_l">
					<div class="alo_head">
						<div><?php echo $val['store_name'];?></div>
						<div></div>
						<div><a style="color:#fff" href="?act=order&op=reserve&store_id=<?php echo $val['store_id'];?>">再次预定</a></div>		
						<div class="apply_order" sign="<?php echo $val['sign'];?>" orderno="<?php echo $val['order_no'];?>" orderid="<?php echo $val['order_id'];?>" ><a href="#">取消订单</a></div>						
					</div>
					<a href="?act=order&op=dingdanxiangqing_1&order_id=<?php echo $val['order_id'];?>">
						<div class="alo_body">
							<div >
								<img src="<?php echo $val['store_logo'];?>" style="width:100%;height:100%">
							</div>
							<div>
								<p><?php echo $val['store_xx_address'];?></p>
								<p><?php echo $val['goods_label'];?>：<?php echo date('Y-m-d H:i',$val['start_time']);?>~<?php echo date('m-d H:i',$val['end_time']);?></p>
								<p>合计：￥<span><?php echo $val['over_price'];?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;押金：<span>￥<?php echo $val['deposit'];?></span></p>
							</div>

						</div>
					</a>
					<div class="alo_foot">
						<div>状态：交易成功</div>
						<div>下单时间：<?php echo date('Y-m-d H:i:s',$val['create_time']);?></div>
					</div>
					<div class="alo_foot_last">订单编号：<?php echo $val['order_no'];?></div>
				</div>
				<?php } ?>
				<?php } ?>
				<div class="none none0" style="background: url(<?php echo IMG;?>/none.png) no-repeat center top;background-size: 63px 75px;">
					您暂无已完成的订单
				</div>
			<!--
				<div class="alo">
					<div class="alo_head">
						<div>杭州下沙大学店</div>
						<div></div>
						<div>再次预定</div>	
						<div class="apply_order"><a href="#">取消订单</a></div>						
					</div>
					<div class="alo_body">
						<div></div>
						<div>
							<p>保利江语海8栋1号别墅</p>
							<p>白场：2017-04-28 10:00-17:00</p>
							<p>合计：￥<span>4000.00</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;押金：<span>￥2000.00</span></p>
						</div>

					</div>
					<div class="alo_foot">
						<div>状态：交易成功</div>
						<div>下单时间：2017-04-27 14:28:56</div>
					</div>
					<div class="alo_foot_last">订单编号：MM1230254MM1230254MM1230254</div>
				</div>
				-->
			</li>
			
			<li>
				<!-- 已取消 -->
				<?php if(isset($output['yiquxiao']) && !empty($output['yiquxiao'])){ ?>
				<?php foreach($output['yiquxiao'] as $key => $val){ ?>
				<div class="alo alo_l">
					<div class="alo_head">
						<div><?php echo $val['store_name'];?></div>
						<div onclick="delete_order(<?php echo $val['order_id']?>)" style="background:url(<?php echo IMG;?>/rubbish.png) no-repeat center;background-size: 12px 13px;"></div>
						<div><a style="color:#fff" href="?act=order&op=reserve&store_id=<?php echo $val['store_id'];?>">再次预定</a></div>						
					</div>
					<a href="?act=order&op=dingdanxiangqing_3&order_id=<?php echo $val['order_id'];?>" >
						<div class="alo_body">
							<div >
								<img src="<?php echo $val['store_logo'];?>" style="width:100%;height:100%">
							</div>
							<div>
								<p><?php echo $val['store_xx_address'];?></p>
								<p><?php echo $val['goods_label'];?>：<?php echo date('Y-m-d H:i',$val['start_time']);?>~<?php echo date('m-d H:i',$val['end_time']);?></p>
								<p>合计：￥<span><?php echo $val['over_price'];?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;押金：<span>￥<?php echo $val['deposit'];?></span></p>
							</div>

						</div>
					</a>
					<div class="alo_foot">
						<div>状态：已取消</div>
						<div>下单时间：<?php echo date('Y-m-d H:i:s',$val['create_time']);?></div>
					</div>
					<div class="alo_foot_last">订单编号：<?php echo $val['order_no'];?></div>
				</div>
				<?php } ?>
				<?php } ?>
				<div class="none none1" style="background: url(<?php echo IMG;?>/none.png) no-repeat center top;background-size: 63px 75px;">
					您暂无已取消的订单
				</div>
					
			</li>
			
			<li>
				<!-- 待支付 -->
				<?php if(isset($output['daizhifu']) && !empty($output['daizhifu'])){ ?>
				<?php foreach($output['daizhifu'] as $key => $val){ ?>
				<div class="usl alo_l">
					<div class="alo_head">
						<div><?php echo $val['store_name'];?></div>
						<div style="display: none;"></div>
						<div><a href="?act=order&op=dingdanzhifu&order_id=<?php echo $val['order_id'];?>" style="color:#fff">立即支付</a></div>
						<div class="cancel_order" sign="<?php echo $val['sign'];?>" orderno="<?php echo $val['order_no'];?>" orderid="<?php echo $val['order_id'];?>" ><a href="#">取消订单</a></div>						
					</div>
					<a href="?act=order&op=dingdanxiangqing_2&order_id=<?php echo $val['order_id'];?>">
						<div class="alo_body">
							<div >
								<img src="<?php echo $val['store_logo'];?>" style="width:100%;height:100%">
							</div>
							<div>
								<p><?php echo $val['store_xx_address'];?></p>
								<p><?php echo $val['goods_label'];?>：<?php echo date('Y-m-d H:i',$val['start_time']);?>~<?php echo date('m-d H:i',$val['end_time']);?></p>
								<p>合计：￥<span><?php echo $val['over_price'];?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;押金：<span>￥<?php echo $val['deposit'];?></span></p>
							</div>

						</div>
					</a>
					<div class="alo_foot">
						<div>状态：待支付</div>
						<div>下单时间：<?php echo date('Y-m-d H:i:s',$val['create_time']);?></div>
					</div>
					<div class="alo_foot_last">订单编号：<?php echo $val['order_no'];?></div>
				</div>
				<?php } ?>
				<?php } ?>
				<div class="none none2 daizhifunone" style="background: url(<?php echo IMG;?>/none.png) no-repeat center top;background-size: 63px 75px;">
					您暂无待支付的订单
				</div>				
			</li>
		</ul>
	</div>			
</div>	

</div>
</div>
<div class="weui_dialog_confirm daizhifu" style="display: none; font-family: '微软雅黑';">
    <div class="weui_mask"></div>
    <div class="weui_dialog">
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">你确定要取消订单吗？</strong></div>
        <div class="weui_dialog_ft">
            <a href="#" class="weui_btn_dialog default">取消</a>
            <a href="#" class="weui_btn_dialog primary">确定</a>
        </div>
    </div>
</div>

<div class="weui_dialog_confirm yiwancheng" style="display: none; font-family: '微软雅黑';">
    <div class="weui_mask"></div>
    <div class="weui_dialog">
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">你确定要取消订单吗？</strong></div>
        <div class="weui_dialog_ft">
            <a href="#" class="weui_btn_dialog default">取消</a>
            <a href="#" class="weui_btn_dialog primary">确定</a>
        </div>
    </div>
</div>
</body>
</html>
<script>
	//删除订单
	function delete_order(order_id){
		var url = '/api/api.php?commend=delete_order'
		$.post(url,{order_id:order_id},function(state){
			if(state.msg.code == '1'){
				window.location.href = window.location.href;
			}
		},'json');
	}
</script>

