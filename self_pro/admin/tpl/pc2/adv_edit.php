<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">广告编辑</h3>
		<form class="from_box" action="" method="post" enctype="multipart/form-data" style="padding-bottom: 10px;" >
		
		<p>广告类型</p>
		<select class="select select_type" onchange="select_adv_type()" name="type" >
			<option value="img" >图片</option>
			<option value="take_turns" >轮播图</option>
		</select>
		</form>
		
		<!-- 图片广告 -->
		<form class="from_box advs img" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="adv_id" value="<?php echo isset($_GET['adv_id'])?intval($_GET['adv_id']):'';?>">
		<input type="hidden" name="type" value="img">
		<p>连接图片（如有需要可以上传图片）</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['images'])){ ?>
					<img src="<?php echo $output['data']['images'];?>">
				<?php } ?>
			</div>
			<div>
				<span class="btn btn-file btn-alt btn-sm">
					<span class="fileupload-new">上传图片</span>
					<span class="fileupload-exists">重新选择</span>
					<input type="file" name="images" />
				</span>
				<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">删除</a>
			</div>
		</div>
		<p>名称</p>
		<input type="text" name="title" value="<?php echo isset($output['data']['title'])?$output['data']['title']:'';?>" class="form-control m-b-10" placeholder="链接地址">
		<p>链接地址</p>
		<input type="text" name="urls" value="<?php echo isset($output['data']['urls'])?$output['data']['urls']:'';?>" class="form-control m-b-10" placeholder="链接地址">
		<p>描述</p>
		<input type="text" name="adv_desc" value="<?php echo isset($output['data']['adv_desc'])?$output['data']['adv_desc']:'';?>" class="form-control m-b-10" placeholder="描述">
		<p>宽度</p>
		<input type="text" name="width" value="<?php echo isset($output['data']['width'])?$output['data']['width']:'';?>" class="form-control m-b-10" placeholder="宽度">
		<p>高度</p>
		<input type="text" name="height" value="<?php echo isset($output['data']['height'])?$output['data']['height']:'';?>" class="form-control m-b-10" placeholder="高度">
		<p>标志</p>
		<input type="text" name="label" value="<?php echo isset($output['data']['label'])?$output['data']['label']:'';?>" class="form-control m-b-10" placeholder="标志">
	
		<input type="submit" value="确认" class="btn btn-lg m-r-5">
		<input type="submit" value="确认" class="btn btn-lg m-r-5" style="position: fixed;top: 50px;left: 50%;">
		</form>
		<!-- 图片广告 -->
		
		<!-- 轮播广告 -->
		<form class="from_box advs take_turns" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="adv_id" value="<?php echo isset($_GET['adv_id'])?intval($_GET['adv_id']):'';?>">
		<input type="hidden" name="type" value="take_turns">
		<p>名称</p>
		<input type="text" name="title" value="<?php echo isset($output['data']['title'])?$output['data']['title']:'';?>" class="form-control m-b-10" placeholder="链接地址">
		<p>描述</p>
		<input type="text" name="adv_desc" value="<?php echo isset($output['data']['adv_desc'])?$output['data']['adv_desc']:'';?>" class="form-control m-b-10" placeholder="描述">
		<p>宽度</p>
		<input type="text" name="width" value="<?php echo isset($output['data']['width'])?$output['data']['width']:'';?>" class="form-control m-b-10" placeholder="宽度">
		<p>高度</p>
		<input type="text" name="height" value="<?php echo isset($output['data']['height'])?$output['data']['height']:'';?>" class="form-control m-b-10" placeholder="高度">
		<p>标志</p>
		<input type="text" name="label" value="<?php echo isset($output['data']['label'])?$output['data']['label']:'';?>" class="form-control m-b-10" placeholder="标志">
		<p>移动方式</p>
		<select class="select" name="adv_mode">
			<?php $adv_mode = array('default' => '默认','left' => '向左','right' => '向右') ?>
			<?php foreach($adv_mode as $key => $val){ ?> 
				<option <?php if(isset($output['data']['adv_mode']) && $output['data']['adv_mode'] == $key ){ ?>selected="selected"<?php } ?> value="<?php echo $key;?>" ><?php echo $val?></option>
			<?php } ?>
		</select>
		
		<p>是否显示左右两边点击按钮</p>
        <div class="make-switch switch-mini">
			<input name="is_L_AND_R" <?php if(isset($output['data']['is_L_AND_R']) && $output['data']['is_L_AND_R']==1 || !isset($output['data']['is_L_AND_R'])){ ?>checked="checked"<?php } ?> type="checkbox">
		</div>
		<p>是否显示底部图标</p>
        <div class="make-switch switch-mini">
			<input name="is_show_bottom" <?php if(isset($output['data']['is_show_bottom']) && $output['data']['is_show_bottom']==1 || !isset($output['data']['is_show_bottom'])){ ?>checked="checked"<?php } ?> type="checkbox">
		</div>
		<p>是否显示底部图标数字</p>
        <div class="make-switch switch-mini">
			<input name="is_show_num" <?php if(isset($output['data']['is_show_num']) && $output['data']['is_show_num']==1 || !isset($output['data']['is_show_num'])){ ?>checked="checked"<?php } ?> type="checkbox">
		</div>
		<p>底部图标位置</p>
		<select class="select" name="is_show_bottom_move">
			<?php $is_show_bottom_move = array('left' => '左边','center' => '中间','right' => '右边') ?>
			<?php foreach($is_show_bottom_move as $key => $val){ ?> 
				<option <?php if(isset($output['data']['is_show_bottom_move']) && $output['data']['is_show_bottom_move'] == $key ){ ?>selected="selected"<?php } ?> value="<?php echo $key;?>" ><?php echo $val?></option>
			<?php } ?>
		</select>
		<p>组图上传</p>
		<div class="upload_imgs">
			<?php $i = 0; ?>
			<?php for($i ; $i < 10; $i++){ ?>
			<div class="fileupload fileupload-new" data-provides="fileupload">
				<p>链接地址</p>
				<input type="text" name="urls[]" value="<?php echo isset($output['data']['urls'][$i])?$output['data']['urls'][$i]:'';?>" class="form-control m-b-10" placeholder="链接地址">
				<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['images'][$i])){ ?>
					<img id="imgs_<?php echo substr(basename($output['data']['images'][$i]),0,19);?>" src="<?php echo $output['data']['images'][$i];?>">
				<?php } ?>
				</div>
				<div>
					<span class="btn btn-file btn-alt btn-sm">
						<span class="fileupload-new">上传图片</span>
						<span class="fileupload-exists">重新选择</span>
						<input type="file" name="images[]" />
					</span>
					<?php if(!empty($output['data']['images'][$i])){ ?>
						<a style="display:inline-flex" class="btn fileupload-exists btn-sm" onclick="delete_images(<?php echo intval($_GET['goods_id']);?>,'<?php echo basename($output['data']['images'][$i]);?>','<?php echo substr(basename($output['data']['images'][$i]),0,19);?>')" >删除</a>
					<?php }else{ ?>
						<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">删除</a>
					<?php } ?>
					
				</div>
			</div>
			<?php } ?>
		</div>
		
		<input type="submit" value="确认" class="btn btn-lg m-r-5">
		<input type="submit" value="确认" class="btn btn-lg m-r-5" style="position: fixed;top: 50px;left: 50%;">
		</form>
		<!-- 轮播广告 -->
</section>
<!--content内容结束-->
<script>
	//设置广告类型
	function select_adv_type(){
		$('.advs').hide();
		var type = $('.select_type').val();
		switch(type){
			case 'img': 
				$('.advs.img').show();
				break;
			case 'take_turns': 
				$('.advs.take_turns').show();
				break;
			default :
				alert('未知错误！');
				break
		}
	}
	<?php if( isset($output['data']['type'] )){ ?>
	function adv_type_init(){
		$('.advs').hide();
		$('.advs.<?php echo isset($output['data']['type'])? $output['data']['type'] :'' ?>').show();
		$('.select_type').val('<?php echo isset($output['data']['type'])? $output['data']['type'] :'' ?>');
	}
	adv_type_init();
	<?php } ?>
	function delete_images(adv_id,image,hide_id){
		url = "?act=adv&op=adv_images_del";
		$.post(url,{adv_id:adv_id,image:image},function(state){
			if(state.code == 1){
				$('#imgs_'+hide_id).hide();
			}else{
				slert('删除失败');
			}
		},'json');
		
	}
</script>
