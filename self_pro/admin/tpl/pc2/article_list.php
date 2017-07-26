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
	<h3 class="block-title">文章列表</h3>
	<div class="goods_nav" >
		<a class="btn" href="?act=article&op=article_edit">添加</a>
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>文章id</th>
					<th>文章名称</th>
					<th>关键字</th>
					<th>是否显示</th>
					<th>标记</th>
					<th>添加时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			
			<?php if(isset($output['data']) && is_array($output['data'])){ ?>
			<?php 
				function show_class($arr){
					foreach($arr as $key => $val){ ?>
						<tr>
							<td><?php echo $val['article_id']?></td>
							<td><?php echo $val['title']?></td>
							<td><?php echo $val['keyword']?></td>
							<td><?php echo $val['is_show'] == 1? '显示':'不显示'; ?></td>
							<td><?php echo $val['label']?></td>
							<td><?php echo date('Y-m-d H:i',$val['add_time'])?></td>
							<td><a href="?act=article&op=article_edit&article_id=<?php echo $val['article_id'];?>" >编辑</a>|<a href="?act=article&op=article_del&article_id=<?php echo $val['article_id'];?>">删除</a></td>
						</tr>
						<?php
					//	if(!empty($val['list'])){ //递归
					//		show_class($val['list']);
					//	}
					}
				}
				show_class($output['data']);
			?>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<?php echo $output['page'];?>
</section>