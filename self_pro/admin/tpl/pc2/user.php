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
		<a class="btn" href="?act=user&op=user_add">添加</a>
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>No.</th>
					<th>用户名</th>
					<th>邮箱</th>
					<th>管理员称号</th>
					<th>店铺</th>
					<th>账号类型</th>
					<th>添加时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['admin_id']?></td>
						<td><?php echo $val['username']?></td>
						<td><?php echo $val['email']?></td>
						<td><?php echo $val['admin_state']?></td>
						<td><?php echo $val['store_name']?></td>
						<td><?php echo $val['admin_type']?></td>
						<td><?php echo $val['add_time']?></td>
						<td><a href="?act=user&op=user_edit&id=<?php echo $val['admin_id']?>">编辑权限</a>|<a href="?act=user&op=user_del&id=<?php echo $val['admin_id']?>" onclick="window.confirm('是否真的删除<?php echo $val['username'];?>管理员?');">删除</a></td>
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