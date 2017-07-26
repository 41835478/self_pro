<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式end-->
<style>
.goods_nav {
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>
<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">导航列表</h3>
	<div class="goods_nav" >
		<a class="btn" href="?act=navigation&op=navigation_edit">添加</a>
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>导航id</th>
					<th>导航名称</th>
					<th>是否显示</th>
					<th>首页是否显示</th>
					<th>添加时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			
			<?php ?>
			<?php if(isset($output['data']) && is_array($output['data'])){ ?>
			<?php 
				function show_cat($arr){
					foreach($arr as $key => $val){ ?>
						<tr>
							<td><?php echo $val['cat_id']?></td>
							<td><?php echo $val['cat_name']?></td>
							<td><?php echo $val['is_show'] == 1? '显示':'不显示'; ?></td>
							<td><?php echo $val['is_home_show'] == 1? '显示':'不显示'; ?></td>
							<td><?php echo date('Y-m-d H:i',$val['add_time'])?></td>
							<td><a href="?act=navigation&op=navigation_edit&cat_id=<?php echo $val['cat_id'];?>" >编辑</a>|<a href="?act=navigation&op=navigation_del&cat_id=<?php echo $val['cat_id'];?>">删除</a></td>
						</tr>
						<?php
						if(!empty($val['list'])){ //递归
							show_cat($val['list']);
						}
					}
				}
				show_cat($output['data']);
			?>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<!--页码start-->
	<?php // echo $output['page'];?>
	<!--页码end-->
</section>