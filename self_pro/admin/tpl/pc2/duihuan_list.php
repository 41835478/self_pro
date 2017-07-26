<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">兑换码</h3>
	<div class="goods_nav" >
		<a class="btn" href="?act=duihuan&op=duihuan_edit">添加</a>
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>id</th>
					<th>码</th>
					<th>是否使用</th>
					<th>添加时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['d_id']?></td>
						<td><?php echo $val['d_code']?></td>
						<td><?php echo $val['is_use'] == 1? '已使用':'未使用'; ?></td>
						<td><?php echo date('Y-m-d H:i',$val['add_time'])?></td>
						<td>
							<?php if($val['user_id'] > 0){ ?>
								<a href="?act=duihuan&op=chakan&d_id=<?php echo $val['d_id'];?>">查看</a>|
							<?php } ?>
							<?php if($val['is_use'] == 0){ ?>
								<a href="?act=duihuan&op=duihuan_del&d_id=<?php echo $val['d_id'];?>">删除</a>
							<?php } ?>
						</td>
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