<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">管理员列表</h3>
	<div class="goods_nav" >
		<a class="btn" href="?act=group&op=group_edit">添加</a>
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>组id</th>
					<th>组名称</th>
					<th>添加时间</th>
					<th>更新时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['group_id']?></td>
						<td><?php echo $val['group_name']?></td>
						<td><?php echo $val['add_time']?></td>
						<td><?php echo $val['update_time']?></td>
						<td><a href="?act=group&op=group_edit&group_id=<?php echo $val['group_id']?>">编辑</a>|<a href="?act=group&op=group_del&group_id=<?php echo $val['group_id']?>">删除</a></td>
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