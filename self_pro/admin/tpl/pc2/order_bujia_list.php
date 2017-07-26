<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">订单补价</h3>
	<!--
	<div class="goods_nav" >
		<a class="btn" href="?act=order&op=order_bujia_edit">添加</a>
	</div>
	-->
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>id</th>
					<th>补价价格</th>
					<th>订单号</th>
					<th>是否支付</th>
					<th>添加时间</th>
					<th>支付时间</th>
					<th>备注</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['b_id'];?></td>
						<td><?php echo $val['b_price'];?></td>
						<td><?php echo $val['order_no'];?></td>
						<td><?php echo $val['pay'] == 1 ? "已支付" : "未支付";?></td>
						<td><?php echo $val['create_time'] > 0 ? date('Y-m-d H:i:s',$val['create_time']):'';?></td>
						<td><?php echo $val['create_time'] > 0 ? date('Y-m-d H:i:s',$val['pay_time']):'';?></td>
						<td><?php echo $val['b_beizhu'];?></td>
						<!--
						<td><?php if($val['pay'] == 0){ ?><a href="?act=order&op=order_bujia_qrcode&b_id=<?php echo $val['b_id'];?>" >补价二维码</a>|<?php } ?><a href="?act=order&op=order_bujia_del&b_id=<?php echo $val['b_id'];?>">删除</a></td>
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