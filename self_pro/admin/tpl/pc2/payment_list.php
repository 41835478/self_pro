<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">支付列表</h3>
	<div class="goods_nav" >
		<!-- <a class="btn" href="?act=payment&op=payment_edit">添加</a> -->
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>id</th>
					<th>名称</th>
					<th>是否启用</th>
					<th>中文名称</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['id']?></td>
						<td><?php echo $val['name']?></td>
						<td><?php echo $val['is_open'] == 1? '显示':'不显示'; ?></td>
						<td><?php echo $val['chinese_name'];?></td>
						<td><a href="?act=payment&op=payment_edit&id=<?php echo $val['id'];?>" >编辑</a><!--|<a href="?act=payment&op=payment_del&payment_id=<?php echo $val['payment_id'];?>">删除</a>--></td>
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