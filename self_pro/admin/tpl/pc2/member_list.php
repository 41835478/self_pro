<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">会员列表</h3>
	<div class="goods_nav" >
		<a class="btn" href="?act=user&op=member_edit">添加</a>
	</div>
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>用户id</th>
					<th>会员名称</th>
					<th>手机号</th>
					<th>用户站内金</th>
					<th>用户积分</th>
					<th>是否允许登陆</th>
					<th>注册时间</th>
					<th>注册类型</th>
					<th>邀请列表</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['user_id']?></td>
						<td><?php echo $val['nickname']?></td>
						<td><?php echo $val['phone']?></td>
						<td><?php echo $val['user_gold']?></td>
						<td><?php echo $val['user_integral']?></td>
						<td><?php echo $val['user_state']?></td>
						<td><?php echo $val['add_time']?></td>
						<td><?php echo $val['user_type']?></td>
						<td><a href="?act=user&op=member_order_list&user_id=<?php echo $val['user_id']?>">邀请订单</a></td>
						<td><a href="?act=user&op=member_edit&user_id=<?php echo $val['user_id']?>">编辑</a><!--|<a href="?act=user&op=member_del&user_id=<?php echo $val['user_id']?>">删除</a>--></td>
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