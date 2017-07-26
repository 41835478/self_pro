<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<store href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">商铺设置</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="store_id" value="<?php echo isset($_GET['store_id'])?intval($_GET['store_id']):'';?>" >
		<p>商铺名称</p>
		<input type="text" name="store_name" value="<?php echo isset($output['data']['store_name'])?$output['data']['store_name']:'';?>" class="form-control m-b-10" >
		<p>商铺标题</p>
		<input type="text" name="store_title" value="<?php echo isset($output['data']['store_title'])?$output['data']['store_title']:'';?>" class="form-control m-b-10" >
		<p>手机</p>
		<input type="text" name="phone" value="<?php echo isset($output['data']['phone'])?$output['data']['phone']:'';?>" class="form-control m-b-10" >
		<p>用户名称</p>
		<input type="text" name="true_name" value="<?php echo isset($output['data']['true_name'])?$output['data']['true_name']:'';?>" class="form-control m-b-10" >
		<p>标记</p>
		<input type="text" name="label" value="<?php echo isset($output['data']['label'])?$output['data']['label']:'';?>" class="form-control m-b-10" >
		<p>身份证号</p>
		<input type="text" value="<?php echo isset($output['data']['card_id'])?$output['data']['card_id']:'';?>" class="form-control m-b-10" >
		<p>商铺状态</p>
		<input type="text" value="<?php echo isset($output['data']['is_open'])?$output['data']['is_open']:'';?>" class="form-control m-b-10" >
		<p>是否自营（1是自营，2非自营）</p>
		<input type="text" name="is_self" value="<?php echo isset($output['data']['is_self'])?$output['data']['is_self']:'';?>" class="form-control m-b-10" >
		<p>开店时间</p>
		<input type="text" value="<?php echo isset($output['data']['open_time'])?$output['data']['open_time']:'';?>" class="form-control m-b-10" >
		<p>申请失败原因</p>
		<textarea class="input-sm validate[required] form-control" name="register_fail_desc"><?php echo isset($output['data']['register_fail_desc'])?$output['data']['register_fail_desc']:'';?></textarea>
		<p>连接图片（如有需要可以上传图片）</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['store_logo'])){ ?>
					<img src="<?php echo $output['data']['store_logo'];?>">
				<?php } ?>
			</div>
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['card_z'])){ ?>
					<img src="<?php echo $output['data']['card_z'];?>">
				<?php } ?>
			</div>
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['card_f'])){ ?>
					<img src="<?php echo $output['data']['card_f'];?>">
				<?php } ?>
			</div>
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['store_logo'])){ ?>
					<img src="<?php echo $output['data']['store_logo'];?>">
				<?php } ?>
			</div>
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['store_logo'])){ ?>
					<img src="<?php echo $output['data']['store_logo'];?>">
				<?php } ?>
			</div>
		</div>
		
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
