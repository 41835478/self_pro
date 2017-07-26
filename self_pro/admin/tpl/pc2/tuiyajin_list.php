<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">友链列表</h3>
	<div class="goods_nav" >
		<a class="btn" href="?act=link&op=link_edit">添加</a>
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>id</th>
					<th>店铺</th>
					<th>订单号</th>
					<th>支付单号</th>
					<th>用户名</th>
					<th>下订单姓名</th>
					<th>退押金金额</th>
					<th>退款时间</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['t_id'];?></td>
						<td><?php echo $val['store_name'];?></td>
						<td><?php echo $val['order_no'];?></td>
						<td><?php echo $val['transaction_id'];?></td>
						<td><?php echo $val['nickname'];?></td>
						<td><?php echo $val['safe_name'];?></td>
						<td><?php echo $val['t_price'];?></td>
						<td><?php echo date('Y-m-d H:i:s',$val['create_time']);?></td>
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