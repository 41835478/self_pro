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
			var order_no = '';
			var order_id = '';
			var sign = '';
			$('.cancel_order').click(function(){
				order_id = $(this).attr('orderid');
				order_no = $(this).attr('orderno');
				sign 	 = $(this).attr('sign');
				$('.weui_dialog_confirm').show()
			})
			$('.weui_dialog_confirm .default').click(function(){
				$('.weui_dialog_confirm').hide()
			})
			$('.weui_dialog_confirm .primary').click(function(){
				var url = '/api/api.php?commend=quxiaodingdan';
				$.post(url,{order_id:order_id,order_no:order_no,sign:sign},function(data){
					if(data.msg.code == '1'){
						alert(data.msg.msg);
						window.location.href = '?act=user&op=person_info';
					}else{
						alert(data.msg.msg);
					}
				},'json');
				$('.weui_dialog_confirm').hide();
			})
			
			disnone();
			function disnone(){
				if($("#contentop").has(".action").length == 0){
					$('.none').show();
				}
			}
		});
</script>
<style>
	
</style>
</head>
<body>
<div data-role="page">
<div data-role = "content-floud">			
	<div style="font-family: '微软雅黑';">
		<ul id="contentop">
			<?php if(isset($output['daizhifu_order']) && !empty($output['daizhifu_order'])){ ?>
			<?php foreach($output['daizhifu_order'] as $key => $val){ ?>
			<li class="action">
				<div class="usl">
					<div class="alo_head">
						<div><?php echo $val['store_name'];?></div>
						<div style="display: none;"></div>
						<div><a style="color:#fff" href="?act=order&op=dingdanxiangqing_2&order_id=<?php echo $val['order_id'];?>" >立即支付</a></div>
						<div class="cancel_order" sign="<?php echo $val['sign'];?>" orderid="<?php echo $val['order_id'];?>" orderno="<?php echo $val['order_no'];?>">取消订单</div>						
					</div>
					<a  href="?act=order&op=dingdanxiangqing_2&order_id=<?php echo $val['order_id'];?>" >
						<div class="alo_body">
							<div style="background:url(<?php echo $val['store_logo'];?>) no-repeat;background-size:100% 100%" ></div>
							<div>
								<p>保利江语海8栋1号别墅</p>
								<p>白场：2017-04-28 10:00-17:00</p>
								<p>合计：￥<span><?php echo $val['over_price'];?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;押金：<span>￥<?php echo $val['deposit']?></span></p>
							</div>

						</div>
					</a>
					<div class="alo_foot">
						<div>状态：待支付</div>
						<div>下单时间：<?php echo date('Y-m-d H:i:s',$val['create_time']);?></div>
					</div>
					<div class="alo_foot_last">订单编号：<?php echo $val['order_no'];?></div>
				</div>	
			</li>
			<?php } ?>
			<?php } ?>
			<div class="none" style="background: url(<?php echo IMG;?>/none.png) no-repeat center top;background-size: 63px 75px;">
				您暂无待支付的订单
			</div>
		</ul>
	</div>			
</div>	

</div>
</div>
<div class="weui_dialog_confirm" style="display: none; font-family: '微软雅黑';">
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

