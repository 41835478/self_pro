<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">退款列表</h3>
	
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td>
							<div class="order_list">
							<?php if($val['is_tyajin'] == 0){ ?>
								<div><a href="?act=order&op=tuikuan_edit&order_id=<?php echo $val['order_id']?>">退押金</a></div>
							<?php } ?>
							<?php if($val['is_settlement'] == 0){ ?>
								<div><a href="?act=order&op=order_jiesuan&order_id=<?php echo $val['order_id']?>">订单结算</a></div>
							<?php } ?>
							<!--
							<div><a href="?act=order&op=goods_jisuan&order_id=<?php echo $val['order_id']?>">库存计算</a></div>
							-->
							<br>
							<div>订单号:<?php echo $val['order_no']?></div>
							<div>支付状态:<?php echo $val['pay']?></div>
							<div>押金金额:<?php echo $val['deposit']?></div>
							<div>押金状态:<?php echo $val['deposit_pay']?></div>
							<div>发票金额:<?php echo $val['fapiao_price']?></div>
							<div>发票状态:<?php echo $val['order_state']?></div>
							
							<div>发票地址:<?php echo $val['order_address']?></div>
							<div>入住状态:<?php echo $val['ruzhu_state']?></div>
							<div><a href="?act=order&op=room_details&order_id=<?php echo $val['order_id']?>">房间账单</a>:<?php echo $val['safe_name']?></div>
							<div>游玩人数:<?php echo $val['people_num']?></div>
							<div>备注:<?php echo $val['order_remarks']?></div>
							<div>渠道:<?php echo $val['channel']?></div>
							<div>房间金额:<?php echo $val['room_price']?></div>
							<div>创建时间:<?php echo date('Y-m-d H:i:s',$val['create_time']);?></div>
							<div>开始时间:<?php echo date('Y-m-d H:i:s',$val['start_time']);?></div>
							<div>结束时间:<?php echo date('Y-m-d H:i:s',$val['end_time']);?></div>
							<?php if(isset($val['bujia']) && $val['bujia'] > 0){ ?>
								<div>订单补价:<?php echo $val['bujia']?></div>
							<?php } ?>
							</div>
						</td>
						<!--
						<td><?php echo $val['order_no']?></td>
						<td><?php echo $val['safe_name']?></td>
						<td><?php echo $val['order_name']?></td>
						<td><?php echo $val['is_show'] == 1? '显示':'不显示'; ?></td>
						<td><?php echo $val['over_price'];?></td>
						<td><?php echo $val['pay'] == 1 ? '已支付' : '未支付';?></td>
						<td><?php echo $val['deposit_pay'] == 1 ? '已支付' : '未支付';?></td>
						<td><?php echo $val['people_num'];?></td>
						<td><?php echo $val['mobile'];?></td>
						<td><?php echo date('Y-m-d H:i',$val['start_time'])?></td>
						<td><?php echo date('Y-m-d H:i',$val['end_time'])?></td>
						<td><?php echo $val['order_label']?></td>
						<td><a href="?act=order&op=order_edit&order_id=<?php echo $val['order_id'];?>" >订单详情</a>|<a href="?act=order&op=order_del&order_id=<?php echo $val['order_id'];?>">删除订单</a></td>
						-->
					</tr>
				<?php } ?>
				<?php } ?>
			</tbody>
			
		</table>
	</div>
	<!--页码start-->
	<?php echo $output['page'];?>
	<!--页码end-->
</section>
<style>
	.order_list{
		width:100%;
	}
	.order_list div{
		min-width:210px;
		float:left;
	}
</style>