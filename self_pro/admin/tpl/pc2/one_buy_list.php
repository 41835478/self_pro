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
	<h3 class="block-title">商品列表</h3>
	<div class="goods_nav" >
		<a class="btn" href="?act=one&op=one_buy_edit">添加</a>
		<a class="btn" href="?act=one&op=review_list">审核列表</a>
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>名称</th>
					<th>标题</th>
					<th>副标题</th>
					<th>价格</th>
					<th>活动（开始时间）</th>
					<th>活动（结束时间）</th>
					<th>是否审核</th>
					<th>排序</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			
			<?php if(isset($output['data']) && is_array($output['data'])){ ?>
			<?php foreach($output['data'] as $key => $val){ ?>
						<tr>
							<td><?php echo $val['id'];?></td>
							<td><?php echo $val['name'];?></td>
							<td><?php echo $val['title']; ?></td>
							<td><?php echo $val['title2']; ?></td>
							<td><?php echo $val['one_price']; ?></td>
							<td><?php echo date('Y-m-d H:i',$val['start_time']);?></td>
							<td><?php echo date('Y-m-d H:i',$val['end_time']);?></td>
							<td><?php echo $val['is_review'] == 1?'是':'否';?></td>
							<td><?php echo $val['one_sort'];?></td>
							<td><a href="?act=one&op=one_buy_edit&one_id=<?php echo $val['id'];?>" >编辑</a>|<a href="?act=one&op=one_buy_del&one_id=<?php echo $val['id'];?>">删除</a></td>
						</tr>
				<?php } ?>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<?php echo $output['page'];?>
</section>