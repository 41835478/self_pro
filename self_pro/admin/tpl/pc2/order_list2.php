<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet">
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">邀请订单列表</h3>
	<!--
	<div class="goods_nav" >
		<a class="btn" href="?act=order&op=order_edit">添加订单</a>
		<?php if(isset($output['store_list']) && !empty($output['store_list'])){ ?>
		<select class="select store_select" name="store" >
		<option value="0">请选择店铺</option>
		<?php foreach($output['store_list'] as $key => $val){ ?>
			<option <?php if(isset($output['store_id']) && $output['store_id'] == $val['store_id']){ ?>selected="selected"<?php }?> value="<?php echo $val['store_id']?>" ><?php echo $val['store_name']?></option>
		<?php } ?>
		</select>
		<?php } ?>
		<?php $pay = array('999'=>'全部','0'=>'未支付','1'=>'已支付','2'=>'已取消')?>
		<select class="select pay_select" name="brand_id">
		<?php foreach($pay as $key => $val){ ?>
			<option <?php if(isset($output['pay']) && $output['pay'] == $key){ ?>selected="selected"<?php }?> value="<?php echo $key?>"><?php echo $val?></option>
		<?php } ?>
		</select>
		<a class="btn" onclick="key_search()">搜索</a>
	</div>
	-->
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>订单id</th>
					<th>订单号</th>
					<th>姓名</th>
					<th>下订单名称</th>
					<!--<th>是否显示</th>-->
					<th>实付款</th>
					<th>支付状态</th>
					<th>押金支付状态</th>
					<th>人数</th>
					<th>手机号</th>
					<th>开始时间</th>
					<th>结束时间</th>
					<!--<th>订单标记</th>-->
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr>
						<td><?php echo $val['order_id']?></td>
						<td><?php echo $val['order_no']?></td>
						<td><?php echo $val['safe_name']?></td>
						<td><?php echo $val['order_name']?></td>
						<!--<td><?php echo $val['is_show'] == 1? '显示':'不显示'; ?></td>-->
						<td><?php echo $val['over_price'];?></td>
						<td><?php echo $val['pay'] == 1 ? '已支付' : '未支付';?></td>
						<td><?php echo $val['deposit_pay'] == 1 ? '已支付' : '未支付';?></td>
						<td><?php echo $val['people_num'];?></td>
						<td><?php echo $val['mobile'];?></td>
						<td><?php echo date('Y-m-d H:i',$val['start_time'])?></td>
						<td><?php echo date('Y-m-d H:i',$val['end_time'])?></td>
						<!--<td><?php echo $val['order_label']?></td>-->
						<td><a href="?act=order&op=order_edit&order_id=<?php echo $val['order_id'];?>" >订单详情</a>|<a href="?act=order&op=order_del&order_id=<?php echo $val['order_id'];?>">删除订单</a></td>
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
<style>
.btn-group.bootstrap-select.select{
	width:300px;
}
</style>
<script>
	var where = {};
	/*
	$('.store_select').change(function(){
		where.store_id = $(this).val();
	//	window.location.href = '?act=order&op=order_list&store_id='+store_id;
	});
	$('.pay_select').change(function(){
		where.pay = $(this).val();
	
	});
	*/
	var str = '';
	function key_search(){
		where.store_id = $('.store_select').val();
		where.pay = $('.pay_select').val();
		if(typeof(where.store_id) != 'undefined'){
			str += '&store_id='+where.store_id;
		}
		if(typeof(where.pay) != 'undefined'){
			str += '&pay='+where.pay;
		}
		window.location.href = '?act=user&op=member_order_list'+str;
	}
</script>