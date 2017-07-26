<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/order.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container" >
<!-- Table Striped -->
<div class="block-area" id="tableStriped" style="margin-left: 10px;max-width: 90%;">
	
		<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="order_id" value="<?php echo isset($_GET['order_id'])?intval($_GET['order_id']):'';?>" >
		<!-- 是否扣除押金 -->
		<?php if(isset($_GET['order_id']) && intval($_GET['order_id']) > 0){ ?>
		<div>
			<table>
				<tr>
					<td style="float:right" >售出</td>
				</tr>
				<?php if(isset($output['goods']) && !empty($output['goods'])){ ?>
				<?php foreach($output['goods'] as $key => $val){ ?>	
				<tr>
					<td><div style="float:left;width:auto;margin:10px;min-width:100px;"><?php echo $val['goods_name'];?>（￥<?php echo $val['goods_price'];?>）</div>
					<input type="hidden" name="goods_id[]" value="<?php echo $val['goods_id'];?>">
					<input type="hidden" name="goods_price[]" value="<?php echo $val['goods_price'];?>">
					<input style="float:left;width:60px;" name="goods_num[]" class="form-control input-sm xiankucun" value="<?php echo isset($val['num'])?$val['num']:0;?>">
				</tr>
				<?php } ?>
				<?php } ?>
			</table>
		</div>
		<!--
		应扣除押金：<input readOnly="true" name="yinkouchu" class="form-control input-sm" style="width:100px;" id="kouchu" value="0"><br>
		-->
		<?php } ?>
		</form>
		<!--空盒子-->
		<div class="empty_box" style="width:100%;margin-top:30px;float:left" ></div>
		
		<?php if(isset($_GET['order_id']) && intval($_GET['order_id']) > 0){ ?>
		
			<a onclick="order_settlement()" class="btn btn-lg m-r-5">库存添加</a>
			
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
	//	var url = '?act=order&op=order_settlement';
	//	$('.from_box').attr('action',url);
		enter();
	}
	/*
	$('.xiankucun').blur(function(){
	//	var yuanlai = parseInt($(this).attr('data'));
	//	var price 	= parseInt($(this).attr('price'));
	//	var xianzai = parseInt($(this).val());
	//	var yajin 	= parseInt($('#kouchu').val());
		var yuanlai_price = 0;
		var xianzai_price = 0;
		$('.xiankucun').each(function(){
			yuanlai_price += parseInt($(this).attr('data')) * parseInt($(this).attr('price'))
			xianzai_price += parseInt($(this).val()) * parseInt($(this).attr('price'))
		});
		if(yuanlai_price >= xianzai_price){
		//	var num = yuanlai - xianzai;
		//	num = num * price + yajin;
		//	$('#kouchu').val(num);
			$('#kouchu').val((yuanlai_price - xianzai_price));
			
		}
	});
	*/
</script>
<script>
	/*
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
	*/
</script>
