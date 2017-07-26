<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet">
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">商铺列表</h3>
	<div class="goods_nav" >
		<a class="btn" href="?act=store&op=store_list&type=1">全部</a>
		<!--
		<a class="btn" href="?act=store&op=store_list&type=2">开启的店铺</a>
		<a class="btn" href="?act=store&op=store_list&type=3">关闭的店铺</a>
		<a class="btn" href="?act=store&op=store_list&type=4">审核通过</a>
		<a class="btn" href="?act=store&op=store_list&type=5">审核中</a>
		<a class="btn" href="?act=store&op=store_list&type=6">审核失败</a>
		<a class="btn" href="?act=store&op=store_list&type=7">已过期</a>
		-->
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>商铺id</th>
					<th>商铺名称</th>
					<th>商家名称</th>
					<th>商铺是否开启</th>
					<th>标记</th>
					<th>注册时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['store_id'];?></td>
						<td><?php echo $val['store_name'];?></td>
						<td><?php echo $val['true_name'];?></td>
						<td><?php echo $val['is_open'] == 1 ? '开启' : '未开启';?></td>
						<td><?php echo $val['label'];?></td>
						<td><?php echo date('Y-m-d H:i:s',$val['add_time']);?></td>
						<td>
						<!--
						<a href="?act=link&op=link_edit&store_id=<?php echo $val['store_id'];?>" >查看</a>
						|<a href="?act=store&op=store_edit&store_id=<?php echo $val['store_id'];?>" >编辑</a>
                        -->
						|<a href="?act=store&op=store_state_submit&store_id=<?php echo $val['store_id'];?>&state=1" >开启</a>
						|<a href="?act=store&op=store_state_submit&store_id=<?php echo $val['store_id'];?>&state=2" >关闭</a>
						<!-- 审核通过就去掉显示 -->
						<?php if($val['store_state'] != 1){ ?>
						|<a href="?act=store&op=store_state_submit&store_id=<?php echo $val['store_id'];?>&state=3" >通过</a>
						|<a href="?act=store&op=store_state_submit&store_id=<?php echo $val['store_id'];?>&state=4" >不通过</a>	
						<?php } ?>
						|<!--<a href="?act=store&op=link_del&store_id=<?php echo $val['store_id'];?>">删除</a>-->
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