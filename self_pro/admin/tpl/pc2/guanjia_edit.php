<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">商品管理</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="guanjia_id" value="<?php echo isset($_GET['guanjia_id'])?intval($_GET['guanjia_id']):'';?>" >
		<p>名称</p>
		<input type="text" name="guanjia_name" value="<?php echo isset($output['data']['guanjia_name'])?$output['data']['guanjia_name']:'';?>" class="form-control m-b-10" placeholder="请填写商品名称">
		<p>手机号</p>
		<input type="text" name="guanjia_phone" value="<?php echo isset($output['data']['guanjia_phone'])?$output['data']['guanjia_phone']:'';?>" class="form-control m-b-10" placeholder="手机号">
		<p>爱好</p>
		<input type="text" name="guanjia_aihao" value="<?php echo isset($output['data']['guanjia_aihao'])?$output['data']['guanjia_aihao']:'';?>" class="form-control m-b-10" placeholder="">
		<p>年龄</p>
		<input type="text" name="guanjia_age" value="<?php echo isset($output['data']['guanjia_age'])?$output['data']['guanjia_age']:'';?>" class="form-control m-b-10" placeholder="">
		<p>星座</p>
		<input type="text" name="guanjia_xingzuo" value="<?php echo isset($output['data']['guanjia_xingzuo'])?$output['data']['guanjia_xingzuo']:'';?>" class="form-control m-b-10" placeholder="">
		<p>学历</p>
		<input type="text" name="guanjia_xueli" value="<?php echo isset($output['data']['guanjia_xueli'])?$output['data']['guanjia_xueli']:'';?>" class="form-control m-b-10" placeholder="">
		<p>标签</p>
		<input type="text" name="guanjia_biaoqian" value="<?php echo isset($output['data']['guanjia_biaoqian'])?$output['data']['guanjia_biaoqian']:'';?>" class="form-control m-b-10" placeholder="">
		<p>数值</p>
		<input type="text" name="guanjia_shuzhi" value="<?php echo isset($output['data']['guanjia_shuzhi'])?$output['data']['guanjia_shuzhi']:'';?>" class="form-control m-b-10" placeholder="">
		<p>管家签名</p>
		<input type="text" name="guanjia_qianming" value="<?php echo isset($output['data']['guanjia_qianming'])?$output['data']['guanjia_qianming']:'';?>" class="form-control m-b-10" placeholder="">
		<p>性别</p>
		<div style="margin-top:20px;">
			<?php $renzheng = array('未认证','已认证'); ?>
			<?php foreach($renzheng as $key => $val){ ?>
			<label class="checkbox-inline">
				<input name="is_renzheng" <?php if(isset($output['data']['is_renzheng']) && $output['data']['is_renzheng'] == ($key)){ ?> checked="checked" <?php } ?> value="<?php echo ($key);?>" <?php ?> type="radio">
				<?php echo $val;?>
			</label>
			<?php } ?>
		</div>
		<p>性别</p>
		<div style="margin-top:20px;">
			<?php $guanjia_xingbie = array('男','女'); ?>
			<?php foreach($guanjia_xingbie as $key => $val){ ?>
			<label class="checkbox-inline">
				<input name="guanjia_xingbie" <?php if(isset($output['data']['guanjia_xingbie']) && $output['data']['guanjia_xingbie'] == ($key+1)){ ?> checked="checked" <?php } ?> value="<?php echo ($key+1);?>" <?php ?> type="radio">
				<?php echo $val;?>
			</label>
			<?php } ?>
		</div>
        
		<p>管家账号</p>
		<select class="select" name="admin_id">
			<?php if(isset($output['guanjia']) && !empty($output['guanjia'])){ ?>
			<?php foreach($output['guanjia'] as $key => $val){ ?>
				<option value="<?php echo $val['admin_id'];?>" <?php if(isset($output['data']['admin_id']) && $val['admin_id'] == $output['data']['admin_id']){ ?>selected="selected"<?php } ?> ><?php echo $val['username'];?></option>
			<?php } ?>
			<?php } ?>
		</select>
		<p>店铺</p>
		<select class="select" name="store_id">
			<?php if(isset($output['store_list']) && !empty($output['store_list'])){ ?>
			<?php foreach($output['store_list'] as $key => $val){ ?>
				<option value="<?php echo $val['store_id'];?>" <?php if(isset($output['data']['store_id']) && $val['store_id'] == $output['data']['store_id']){ ?>selected="selected"<?php } ?> ><?php echo $val['store_name'];?></option>
			<?php } ?>
			<?php } ?>
		</select>
		<!--
		<p>是否按百分比数量警告：</p>
        <div class="make-switch switch-mini">
			<input name="is_guanjia_warning" type="checkbox">
		</div>
		-->
		<p>图片</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['guanjia_logo'])){ ?>
					<img src="<?php echo $output['data']['guanjia_logo'];?>">
				<?php } ?>
			</div>
			<div>
				<span class="btn btn-file btn-alt btn-sm">
					<span class="fileupload-new">上传图片</span>
					<span class="fileupload-exists">重新选择</span>
					<input type="file" name="guanjia_logo" />
				</span>
				<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">删除</a>
			</div>
		</div>
		<!--
		<p>备用图片上传2</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-new thumbnail small form-control"></div>
			<div class="fileupload-preview form-control fileupload-exists thumbnail small"></div>
			<span class="btn btn-file btn-alt btn-sm">
				<span class="fileupload-new">上传图片</span>
				<span class="fileupload-exists">重新选择</span>
				<input type="file" />
			</span>
			<a href="#" class="btn-sm btn fileupload-exists" data-dismiss="fileupload">删除</a>
		</div>
		<p>备用图片上传3</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-new thumbnail small form-control"></div>
			<div class="fileupload-preview form-control fileupload-exists thumbnail small"></div>
			<span class="btn btn-file btn-alt btn-sm">
				<span class="fileupload-new">上传图片</span>
				<span class="fileupload-exists">重新选择</span>
				<input type="file" />
			</span>
			<a href="#" class="btn-sm btn fileupload-exists" data-dismiss="fileupload">删除</a>
		</div>
		-->
		<!--
		<a class="btn btn-xs" onclick="add_img()" >添加图片数量（1）</a>       
		<a class="btn btn-xs" onclick="add_img()" >删除图片数量（1）</a>
		-->	
		<!--
		<p>组图上传</p>
		<div class="upload_imgs">
			<?php $i = 0; ?>
			<?php for($i ; $i < 10; $i++){ ?>
			<div class="fileupload fileupload-new" data-provides="fileupload">
				<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['guanjia_images'][$i])){ ?>
					<img id="imgs_<?php echo substr(basename($output['data']['guanjia_images'][$i]),0,19);?>" src="<?php echo $output['data']['guanjia_images'][$i];?>">
				<?php } ?>
				</div>
				<div>
					<span class="btn btn-file btn-alt btn-sm">
						<span class="fileupload-new">上传图片</span>
						<span class="fileupload-exists">重新选择</span>
						<input type="file" name="guanjia_images[]" />
					</span>
					<?php if(!empty($output['data']['guanjia_images'][$i])){ ?>
						<a style="display:inline-flex" class="btn fileupload-exists btn-sm" onclick="delete_images(<?php echo intval($_GET['guanjia_id']);?>,'<?php echo basename($output['data']['guanjia_images'][$i]);?>','<?php echo substr(basename($output['data']['guanjia_images'][$i]),0,19);?>')" >删除</a>
					<?php }else{ ?>
						<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">删除</a>
					<?php } ?>
					
				</div>
			</div>
			<?php } ?>
		</div>
		-->
		
		<!--空盒子-->
		<div class="empty_box" style="width:100%;margin-top:30px;float:left" ></div>
		
		<a onclick="enter()" class="btn btn-lg m-r-5">确认</a>
		<a onclick="enter()" class="btn btn-lg m-r-5" style="position: fixed;top: 50px;left: 50%;">确认</a>
	</form>
</section>
<!--content内容结束-->
<script>
	function enter(){
		$('.from_box').submit();
	}
</script>
<script>
	/*
	function delete_images(guanjia_id,image,hide_id){
		url = "?act=guanjia&op=guanjia_images_del";
		$.post(url,{guanjia_id:guanjia_id,image:image},function(state){
			if(state.code == 1){
				$('#imgs_'+hide_id).hide();
			}else{
				slert('删除失败');
			}
		},'json');
		
	}
	*/
</script>
