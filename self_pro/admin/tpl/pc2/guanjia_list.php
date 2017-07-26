<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">商品列表</h3>
	<div class="goods_nav" >
		<a class="btn" href="?act=guanjia&op=guanjia_edit">添加</a>
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>id</th>
					<th>店铺</th>
					<th>账号</th>
					<th>名称</th>
					<th>数值</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['guanjia_id']?></td>
						<td><?php echo $val['store_name']?></td>
						<td><?php echo $val['username']?></td>
						<td><?php echo $val['guanjia_name']?></td>
						<td><?php echo $val['guanjia_shuzhi']?></td>
						<td><a href="?act=guanjia&op=guanjia_edit&guanjia_id=<?php echo $val['guanjia_id'];?>" >编辑</a></a></td>
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