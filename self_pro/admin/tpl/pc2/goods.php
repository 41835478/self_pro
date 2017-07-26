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
		<a class="btn" href="?act=goods&op=goods_edit">添加</a>
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>商品id</th>
					<th>商品名称</th>
					<th>是否显示</th>
					<th>商品价格</th>
					<th>商品数量（库存）</th>
					<th>添加时间</th>
					<th>商品标记</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['goods_id']?></td>
						<td><?php echo $val['goods_name']?></td>
						<td><?php echo $val['is_show'] == 1? '显示':'不显示'; ?></td>
						<td><?php echo $val['goods_price'];?></td>
						<td><?php echo $val['goods_num']?></td>
						<td><?php echo date('Y-m-d H:i',$val['add_time'])?></td>
						<td><?php echo $val['goods_label']?></td>
						<td>查看|<a href="?act=goods&op=goods_edit&goods_id=<?php echo $val['goods_id'];?>" >编辑</a>|<a href="?act=goods&op=goods_del&goods_id=<?php echo $val['goods_id'];?>">删除</a></td>
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