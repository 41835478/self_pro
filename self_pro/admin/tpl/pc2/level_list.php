<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">等级列表</h3>
	<div class="goods_nav" >
		<a class="btn" href="?act=user&op=level_edit">添加</a>
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>等级id</th>
					<th>用户等级名称</th>
					<th>需要达到积分值</th>
					<th>等级</th>
					<th>标示</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['level_id']?></td>
						<td><?php echo $val['level_name']?></td>
						<td><?php echo $val['integral']?></td>
						<td><?php echo $val['level']?></td>
						<td><?php echo $val['label']?></td>
						<td><a href="?act=user&op=level_edit&level_id=<?php echo $val['level_id']?>">编辑</a>|<a href="?act=user&op=level_del&level_id=<?php echo $val['level_id']?>">删除</a></td>
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