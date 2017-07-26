<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">广告列表</h3>
	<div class="goods_nav" >
		<a class="btn" href="?act=adv&op=adv_edit">添加</a>
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>广告id</th>
					<th>广告名称</th>
					<th>广告类型</th>
					<th>添加时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['adv_id'];?></td>
						<td><?php echo $val['title'];?></td>
						<td><?php echo $val['type'];?></td>
						<td><?php echo date('Y-m-d H:i:s',$val['add_time']);?></td>
						<td><a href="?act=adv&op=adv_edit&adv_id=<?php echo $val['adv_id'];?>" >编辑</a>|<a href="?act=adv&op=adv_del&adv_id=<?php echo $val['adv_id'];?>">删除</a></td>
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