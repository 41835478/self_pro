<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">用户权限列表</h3>
	<div class="goods_nav" >
		<a class="btn" href="?act=role&op=role_edit">添加</a>
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>id</th>
					<th>用户名</th>
					<th>组</th>
					<th>添加时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['role_id'];?></td>
						<td><?php echo $val['username'];?></td>
						<td><?php echo $val['group_name'];?></td>
						<td><?php echo date('Y-m-d H:i:s',$val['add_time']);?></td>
						<td><a href="?act=role&op=role_edit&role_id=<?php echo $val['role_id'];?>" >编辑</a>|<a href="?act=role&op=role_del&role_id=<?php echo $val['role_id'];?>">删除</a></td>
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