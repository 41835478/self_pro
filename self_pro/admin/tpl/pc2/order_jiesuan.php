<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/order.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container" >
<!-- Table Striped -->
<div class="block-area" id="tableStriped" style="margin-left: 10px;max-width: 90%;">
	<h3 class="block-title">订单编辑</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<?php if(isset($output['order_id'])){ $_GET['order_id'] = $output['order_id']; }?>
		<input type="hidden" name="order_id" value="<?php echo isset($_GET['order_id'])?intval($_GET['order_id']):'';?>" >
		<p>预定人姓名</p>
		<input type="text" name="order_name" value="<?php echo isset($output['data']['order_name'])?$output['data']['order_name']:'';?>" class="form-control m-b-10">
		<p>姓名</p>
		<input type="text" name="safe_name" value="<?php echo isset($output['data']['safe_name'])?$output['data']['safe_name']:'';?>" class="form-control m-b-10">
		<p>订单简单描述</p>
		<input type="text" name="order_desc" value="<?php echo isset($output['data']['order_desc'])?$output['data']['order_desc']:'';?>" class="form-control m-b-10" >
		<p>应付金额</p>
		<input type="text" name="price" value="<?php echo isset($output['data']['price'])?$output['data']['price']:'';?>" class="form-control m-b-10"   >
		<p>实付款</p>
		<input type="text" name="over_price" value="<?php echo isset($output['data']['over_price'])?$output['data']['over_price']:'';?>" class="form-control m-b-10"   >
		<p>押金</p>
		<input type="text" name="deposit" value="<?php echo isset($output['data']['deposit'])?$output['data']['deposit']:'';?>" class="form-control m-b-10"   >
		<p>优惠</p>
		<input type="text" name="youhui_price" value="<?php echo isset($output['data']['youhui_price'])?$output['data']['youhui_price']:'0';?>" class="form-control m-b-10"  >
		<!--
		<p>积分</p>
		<input type="text" name="total_price" value="<?php echo isset($output['data']['total_price'])?$output['data']['total_price']:'0';?>" class="form-control m-b-10"  >
		-->
		<div style="margin-top:10px;">
		<?php $pay = array('实付款未支付','实付款已支付'); ?>
		<?php foreach($pay as $key => $val){ ?>
		<label class="checkbox-inline">
			<input name="pay" <?php if(isset($output['data']['pay']) && $output['data']['pay'] == $key){ ?> checked="checked" <?php } ?> value="<?php echo $key;?>" <?php ?> type="radio">
			<?php echo $val;?>
		</label>
		<?php } ?>
		</div>
		
		<div style="margin-top:10px;">
		<?php $deposit_pay = array('押金未支付','押金已支付'); ?>
		<?php foreach($deposit_pay as $key => $val){ ?>
		<label class="checkbox-inline">
			<input name="deposit_pay" <?php if(isset($output['data']['deposit_pay']) && $output['data']['deposit_pay'] == $key){ ?> checked="checked" <?php } ?> value="<?php echo $key;?>" <?php ?> type="radio">
			<?php echo $val;?>
		</label>
		<?php } ?>
		</div>
		
		<p>减免</p>
		<input type="text" name="reminder" value="<?php echo isset($output['data']['reminder'])?$output['data']['reminder']:'0';?>" class="form-control m-b-10"  >
		<p>人数</p>
		<input type="text" name="people_num" value="<?php echo isset($output['data']['people_num'])?$output['data']['people_num']:'1';?>" class="form-control m-b-10"  >
		<p>手机号</p>
		<input type="text" name="mobile" value="<?php echo isset($output['data']['mobile'])?$output['data']['mobile']:'';?>" class="form-control m-b-10"  >
		<p>订单出售时间（不填写代表没有限制）(开始)</p>
		<!-- Date Time Picker -->
		<div class="row">
			<div class="col-md-4 m-b-15">
				<p>日期</p>
				<div class="input-icon datetime-pick date-only">
					<input data-format="yyyy-MM-dd" name="start_day" type="text" class="form-control input-sm" value="<?php echo isset($output['data']['start_day'])?$output['data']['start_day']:'';?>" />
					<span class="add-on">
						<i class="sa-plus"></i>
					</span>
				</div>
			</div>
			<div class="col-md-4 m-b-15">
				<p>小时</p>
				<div class="input-icon datetime-pick time-only">
					<input data-format="hh:mm:ss" name="start_hour" type="text" class="form-control input-sm" value="<?php echo isset($output['data']['start_hour'])?$output['data']['start_hour']:'';?>" />
					<span class="add-on">
						<i class="sa-plus"></i>
					</span>
				</div>
			</div>
		</div>
		<p>订单出售时间（不填写代表没有限制）(结束)</p>
		<!-- Date Time Picker -->
		<div class="row">
			<div class="col-md-4 m-b-15">
				<p>日期</p>
				<div class="input-icon datetime-pick date-only">
					<input data-format="yyyy-MM-dd" name="end_day" type="text" class="form-control input-sm" value="<?php echo isset($output['data']['end_day'])?$output['data']['end_day']:'';?>" />
					<span class="add-on">
						<i class="sa-plus"></i>
					</span>
				</div>
			</div>
			<div class="col-md-4 m-b-15">
				<p>小时</p>
				<div class="input-icon datetime-pick time-only">
					<input data-format="hh:mm:ss" name="end_hour" type="text" class="form-control input-sm" value="<?php echo isset($output['data']['end_hour'])?$output['data']['end_hour']:'';?>" />
					<span class="add-on">
						<i class="sa-plus"></i>
					</span>
				</div>
			</div>
		</div>
		
		<!-- 是否扣除押金 -->
		<?php if(isset($_GET['order_id']) && intval($_GET['order_id']) > 0){ ?>
		<div>
			<table>
				<tr>
					<td style="float:right" >线上售出 | 现库存 | 原始库存</td>
				</tr>
				<?php if(isset($output['goods']) && !empty($output['goods'])){ ?>
				<?php foreach($output['goods'] as $key => $val){ ?>	
				<tr>
					<td><div style="float:left;width:auto;margin:10px;min-width:100px;"><?php echo $val['goods_name'];?>（￥<?php echo $val['price'];?>）</div>
					<input type="hidden" name="goods_id[]" value="<?php echo $val['goods_id'];?>">
					<input type="hidden" name="goods_price[]" value="<?php echo $val['price'];?>">
					<input readOnly="true" class="form-control input-sm" style="float:left;width:60px;"  value="<?php echo $val['goods_num'];?>">
					<input style="float:left;width:60px;" name="goods_num[]" class="form-control input-sm xiankucun" price="<?php echo $val['price'];?>" data="<?php echo $val['xian_num'];?>" value="<?php echo $val['xian_num'];?>">
					<input style="float:left;width:60px;" name="goods_num2[]" class="form-control input-sm xiankucun"  value="<?php echo $val['goods_num'];?>">
					<input readOnly="true" style="float:left;width:60px;" class="form-control input-sm" value="<?php echo $val['z_num'];?>"></td>
				</tr>
				<?php } ?>
				<?php } ?>
			</table>
		</div>
		应扣除押金：<input readOnly="true" name="yinkouchu" class="form-control input-sm" style="width:100px;" id="kouchu" value="0"><br>
		<?php } ?>
		
		<?php if(isset($output['goods_zu']) && !empty($output['goods_zu'])){ ?>
		<p>租赁商品</p>
		<div>
			<table>
			<?php foreach($output['goods_zu'] as $key => $val ){ ?>
				<tr><div style="float:left;width:auto;margin:10px;min-width:100px;"><?php echo $val['z_name'];?> * (<?php echo $val['z_num'];?>)</div>
				</tr>
			<?php } ?>
			</table>
		</div>
		<?php } ?>
		<!--空盒子-->
		<div class="empty_box" style="width:100%;margin-top:30px;float:left" ></div>
		
		<?php if(isset($_GET['order_id']) && intval($_GET['order_id']) > 0){ ?>
		
			<a onclick="order_settlement()" class="btn btn-lg m-r-5">订单结算</a>
			
		<?php } ?>
		<!--
		<a onclick="enter()" class="btn btn-lg m-r-5">确认</a>
		<a onclick="enter()" class="btn btn-lg m-r-5" style="position: fixed;top: 50px;left: 50%;">确认</a>
		-->
	</form>
</section>
<!--content内容结束-->
<script>
	function enter(){
		$('.from_box').submit();
	}
	
	function order_settlement(){
		var url = '?act=order&op=order_settlement';
		$('.from_box').attr('action',url);
		enter();
	}
	$('.xiankucun').blur(function(){
		var yuanlai_price = 0;
		var xianzai_price = 0;
		$('.xiankucun').each(function(){
			yuanlai_price += parseInt($(this).attr('data')) * parseInt($(this).attr('price'))
			xianzai_price += parseInt($(this).val()) * parseInt($(this).attr('price'))
		});
		if(yuanlai_price >= xianzai_price){
			$('#kouchu').val((yuanlai_price - xianzai_price));
		}
	});
</script>
<script>
	function delete_images(order_id,image,hide_id){
		url = "?act=order&op=order_images_del";
		$.post(url,{order_id:order_id,image:image},function(state){
			if(state.code == 1){
				$('#imgs_'+hide_id).hide();
			}else{
				slert('删除失败');
			}
		},'json');
		
	}
</script>
