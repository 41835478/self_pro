<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">用户管理</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="level_id" value="<?php echo isset($_GET['level_id'])?intval($_GET['level_id']):'';?>" >
		<p>等级名称</p>
		<input type="text" name="level_name" value="<?php echo isset($output['data']['level_name'])?$output['data']['level_name']:'';?>" class="form-control m-b-10" placeholder="">
		<p>需要达到的积分值</p>
		<input type="text" name="integral" value="<?php echo isset($output['data']['integral'])?$output['data']['integral']:'';?>" class="form-control m-b-10" placeholder="">
		<p>等级</p>
		<input type="text" name="level" value="<?php echo isset($output['data']['level'])?$output['data']['level']:'';?>" class="form-control m-b-10" placeholder="">
		<p>标志</p>
		<input type="text" name="label" value="<?php echo isset($output['data']['label'])?$output['data']['label']:'';?>" class="form-control m-b-10" placeholder="">
		<p>等级图标</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['icon'])){ ?>
					<img src="<?php echo $output['data']['icon'];?>">
				<?php } ?>
			</div>
			<div>
				<span class="btn btn-file btn-alt btn-sm">
					<span class="fileupload-new">上传图片</span>
					<span class="fileupload-exists">重新选择</span>
					<input type="file" name="icon" />
				</span>
				<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">删除</a>
			</div>
		</div>
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
<style>
	.user_sex{
		margin-right:20px;
	}
</style>
